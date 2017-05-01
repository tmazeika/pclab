<?php

namespace PCForge\Compatibility\Services;

use Exception;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Set\Vertices;
use Fhaculty\Graph\Vertex;
use Graphp\Algorithms\Search\DepthFirst;
use Graphp\GraphViz\GraphViz;
use Illuminate\Support\Collection;
use PCForge\Compatibility\Providers\CompatibilityProvider;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Contracts\ComponentSelectionServiceContract;
use PCForge\Models\Component;
use PCForge\Models\ComponentChild;

class ComponentIncompatibilityService implements ComponentIncompatibilityServiceContract
{
    /** @var ComponentSelectionServiceContract $componentSelectionService */
    private $componentSelectionService;

    public function __construct(ComponentSelectionServiceContract $componentSelectionService)
    {
        $this->componentSelectionService = $componentSelectionService;
    }

    public function getIncompatibilities(): Collection
    {
        $selection = $this->componentSelectionService->selection();
        $components = Component::all();
        $availableComponents = $components->where('is_available', true);
        $compatibility = new Graph();

        // create vertices
        $availableComponents
            ->pluck('id')
            ->each(function (int $id) use ($compatibility) {
                $compatibility->createVertex($id);
            });

        $incompatibility = $compatibility->createGraphClone();

        // create edges between all compatible components and between all incompatible components
        $availableComponents->each(function (Component $component) use ($selection, $compatibility, $incompatibility) {
            /** @var ComponentChild $child */
            $child = $component->child;
            /** @var CompatibilityProvider $provider */
            $provider = $child->compatibilityProvider();

            //$start = microtime(true);
            // incompatibility
            $this->createEdges(
                $provider->getStaticallyIncompatible($child),
                $provider->getDynamicallyIncompatible($child, $selection),
                $incompatibility,
                $component->id
            );

            // compatibility
            $this->createEdges(
                $provider->getStaticallyCompatible($child),
                $provider->getDynamicallyCompatible($child, $selection),
                $compatibility,
                $component->id
            );
            //dd(((microtime(true) - $start) * 1000).' ms');
        });

        $computedCompatibilities = $this->computeCompatibilities($compatibility, $incompatibility);

        if (empty($selection)) {
            $compatibilities = $computedCompatibilities
                ->filter(function (Collection $adjacentIds) {
                    return $adjacentIds->isNotEmpty();
                })
                ->flatten();
        } else {
            $compatibilities = $computedCompatibilities
                ->filter(function (Collection $adjacentIds, int $id) use ($selection) {
                    return array_key_exists($id, $selection);
                })
                ->reduce(function ($carry, Collection $adjacentIds) {
                    return $carry ? $carry->intersect($adjacentIds) : $adjacentIds;
                });
        }

        return $components->whereNotIn('id', $compatibilities);
    }

    private function createEdges(Collection $static, Collection $dynamic, Graph $graph, int $id): void
    {
        $vertex = $graph->getVertex($id);

        $static
            ->flatten()
            ->union($dynamic
                ->flatten())
            ->filter(function (int $id) {
                return Component::find($id)->is_available;
            })
            ->map(function (int $id) use ($graph) {
                return $graph->getVertex($id);
            })
            ->reject(function (Vertex $adjacentVertex) use ($vertex) {
                return $adjacentVertex === $vertex;
            })
            ->each(function (Vertex $adjacentVertex) use ($vertex) {
                if (!$vertex->hasEdgeTo($adjacentVertex)) {
                    $vertex->createEdge($adjacentVertex);
                }
            });
    }

    private function computeCompatibilities(Graph $compatibility, Graph $incompatibility): Collection
    {
        $incompatibilityVertices = collect($incompatibility->getVertices()->getVector());

        /**
         * 1. Select a compatibility vertex.
         * 2. Go to the incompatibility graph and remove all incident vertices with the selected compatibility vertex
         *    from the compatibility graph.
         * 3. Consider all reachable vertices from the selected compatibility vertex in the compatibility graph as
         *    compatible with the selected compatibility vertex.
         */
        return collect($compatibility->getVertices()->getVector())->mapWithKeys(function (Vertex $compatibilityVertex) use ($compatibility, $incompatibility, $incompatibilityVertices) {
            $compatibilityCopy = $compatibility->createGraphClone();
            $incompatibilityVertex = $incompatibility->getVertex($compatibilityVertex->getId());

            //if ($compatibilityVertex->getId() === 13) {
            //    dump(Component::find($compatibilityVertex->getId())->name);
            //    $this->ddGraph($incompatibility);
            //}

            $incompatibilityVertices
                // choose incompatibility vertices that are incident to the selected compatibility vertex
                ->filter(function (Vertex $otherIncompatibilityVertex) use ($incompatibilityVertex) {
                    return $incompatibilityVertex->hasEdgeTo($otherIncompatibilityVertex);
                })
                // remove the incompatibility vertex that is equal to the selected compatibility vertex (since this
                // compatibility vertex will be the starting point of the reachability search)
                ->reject(function (Vertex $otherIncompatibilityVertex) use ($incompatibilityVertex) {
                    return $otherIncompatibilityVertex === $incompatibilityVertex;
                })
                // remove all incompatibility vertices that are incident to the selected compatibility vertex from the
                // compatibility graph
                ->each(function (Vertex $incompatibilityVertex) use ($compatibilityCopy) {
                    //$compatibilityCopy->getVertex($incompatibilityVertex->getId())->setAttribute('graphviz.color', 'red');
                    $compatibilityCopy->getVertex($incompatibilityVertex->getId())->destroy();
                });

            //if ($compatibilityVertex->getId() === 13) {
            //    dump(Component::find($compatibilityVertex->getId())->name);
            //    $this->ddGraph($compatibilityCopy);
            //}

            return [
                $compatibilityVertex->getId() => $this->verticesToIds(
                    (new DepthFirst($compatibilityCopy->getVertices()->getVector()[0]))->getVertices()),
            ];
        });
    }

    private function verticesToIds(Vertices $vertices): Collection
    {
        return collect($vertices->getVector())->map(function (Vertex $vertex) {
            return $vertex->getId();
        });
    }

    private function ddGraph(Graph $graph): void
    {
        if (!config('app.debug')) {
            throw new Exception('Debugging is turned off');
        }

        $graphViz = new GraphViz();

        collect($graph->getVertices()->getVector())->each(function (Vertex $vertex) {
            $vertex->setAttribute('graphviz.label', Component::find($vertex->getId())->name);
        });

        echo $graphViz->createImageHtml($graph);
        dd();
    }
}
