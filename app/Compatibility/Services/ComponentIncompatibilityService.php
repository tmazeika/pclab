<?php

namespace PCForge\Compatibility\Services;

use Fhaculty\Graph\Graph;
use Illuminate\Support\Collection;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\ComponentChild;

class ComponentIncompatibilityService implements ComponentIncompatibilityServiceContract
{
    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    /** @var array $comparators */
    private $comparators;

    public function __construct(ComponentRepositoryContract $componentRepo, array $comparators)
    {
        $this->componentRepo = $componentRepo;
        $this->comparators = $comparators;
    }

    public function getIncompatibilities(): Collection
    {
        $g = $this->buildIncompatibilityGraph();
    }

    private function buildIncompatibilityGraph(): Graph
    {
        $g = new Graph();
        $gComp = new Graph();
        $components = $this->componentRepo->get(true, ...$this->getAllComparatorSelectsAndWiths());

        // create initial incompatibility graph without true compatibilities, along with its compliment
        $components->each(function (ComponentChild $component1, int $i) use ($g, $gComp, $components) {
            $v1 = $g->createVertex($i, true);

            $v1->setAttribute('component', $component1);
            $vComp1 = @$gComp->createVertexClone($v1) ?? $gComp->getVertex($i);

            $components->slice($i + 1)->each(function (ComponentChild $component2, int $j) use ($component1, $i, $g, $gComp, $v1, $vComp1) {
                $v2 = $g->createVertex($j, true);

                $v2->setAttribute('component', $component2);
                $vComp2 = @$gComp->createVertexClone($v2) ?? $gComp->getVertex($j);

                ksort($components = [
                    $this->componentToType($component1) => $component1,
                    $this->componentToType($component2) => $component2,
                ]);

                $comparator = $this->getComparatorFor(...array_keys($components));

                if ($comparator !== null && $comparator->isIncompatible(...array_values($components))) {
                    $v1->createEdge($v2);
                } else {
                    $vComp1->createEdge($vComp2);
                }
            });
        });

        // TODO: check true compatibility between adjacent vertices in $gComp
        // no shot this all fucking works
    }

    private function getAllComparatorSelectsAndWiths(): array
    {
        $allSelects = [];
        $allWiths = [];

        foreach ($this->comparators as $comparator)
        {
            list($selects, $withs) = $this->getComparatorSelectAndWith($comparator);
            $allSelects = array_merge_recursive($allSelects, $selects);
            $allWiths = array_merge_recursive($allWiths, $withs);
        }

        return [$allSelects, $allWiths];
    }

    private function getComparatorSelectAndWith(IncompatibilityComparator $comparator): array
    {
        $components = $comparator->getComponents();

        return [
            [
                $components[0] => $comparator->select1 ?? [],
                $components[1] => $comparator->select2 ?? [],
            ],
            [
                $components[0] => $comparator->with1 ?? [],
                $components[1] => $comparator->with2 ?? [],
            ],
        ];
    }

    private function getComparatorFor(ComponentChild $component1, ComponentChild $component2): IncompatibilityComparator
    {
        sort($pair = [$this->componentToType($component1), $this->componentToType($component2)]);

        $class = '\PCForge\Compatibility\Comparators\\' . $pair[0] . $pair[1] . 'Comparator';

        return class_exists($class) ? resolve($class) : null;
    }

    private function componentToType(ComponentChild $component): string
    {
        return substr(class_basename(get_class($component)), -strlen('Component'));
    }

    //
    ///** @var SelectionStorageServiceContract $selectionStorage */
    //private $selectionStorage;
    //
    //public function __construct(SelectionStorageServiceContract $selectionStorage)
    //{
    //    $this->componentSelectionService = $selectionStorage;
    //}
    //
    //public function getIncompatibilities(): Collection
    //{
    //    $selection = $this->componentSelectionService->selection();
    //    $this->selectionStorage->
    //
    //    ksort($selection);
    //
    //    $components = Component::pluck('id');
    //    $availableComponents = Component::select('id', 'child_id', 'child_type')->where('is_available', true)->with('child')->get();
    //    $availableComponentIds = $availableComponents->pluck('id');
    //    $compatibility = new Graph();
    //
    //    // create vertices
    //    $availableComponentIds->each(function (int $id) use ($compatibility) {
    //        $compatibility->createVertex($id);
    //    });
    //
    //    $incompatibility = $compatibility->createGraphClone();
    //
    //    // create edges between all compatible components and between all incompatible components
    //    $availableComponents->each(function (Component $component) use ($selection, $compatibility, $incompatibility, $availableComponentIds) {
    //        /** @var ComponentChild $child */
    //        $child = $component->child;
    //        /** @var CompatibilityProvider $provider */
    //        $provider = $child->compatibilityProvider();
    //
    //        // incompatibility
    //        $this->createEdges(
    //            $provider->getStaticallyIncompatible($child),
    //            $provider->getDynamicallyIncompatible($child, $selection),
    //            $incompatibility,
    //            $component->id,
    //            $availableComponentIds
    //        );
    //
    //        // compatibility
    //        $this->createEdges(
    //            $provider->getStaticallyCompatible($child),
    //            $provider->getDynamicallyCompatible($child, $selection),
    //            $compatibility,
    //            $component->id,
    //            $availableComponentIds
    //        );
    //    });
    //
    //    $compatibilities = $this->computeCompatibilities($compatibility, $incompatibility)
    //        ->when(empty($selection), function (Collection $collection) {
    //            return $collection
    //                ->filter(function (Collection $adjacentIds) {
    //                    return $adjacentIds->count() > 1;
    //                })
    //                ->flatten();
    //        })
    //        ->when(!empty($selection), function (Collection $collection) use ($selection) {
    //            return $collection
    //                ->filter(function (Collection $adjacentIds, int $id) use ($selection) {
    //                    return array_key_exists($id, $selection);
    //                })
    //                ->reduce(function ($carry, Collection $adjacentIds) {
    //                    return $carry ? $carry->intersect($adjacentIds) : $adjacentIds;
    //                });
    //        });
    //
    //    return $components
    //        ->diff($compatibilities)
    //        ->flatten();
    //}
    //
    //private function createEdges(Collection $static, Collection $dynamic, Graph $graph, int $id, Collection $availableComponentIds): void
    //{
    //    $vertex = $graph->getVertex($id);
    //
    //    $static
    //        ->flatten()
    //        ->union($dynamic->flatten())
    //        ->filter(function (int $id) use ($availableComponentIds) {
    //            return $availableComponentIds->contains($id);
    //        })
    //        ->map(function (int $id) use ($graph) {
    //            return $graph->getVertex($id);
    //        })
    //        ->reject(function (Vertex $adjacentVertex) use ($vertex) {
    //            return $adjacentVertex === $vertex;
    //        })
    //        ->each(function (Vertex $adjacentVertex) use ($vertex) {
    //            if (!$vertex->hasEdgeTo($adjacentVertex)) {
    //                $vertex->createEdge($adjacentVertex);
    //            }
    //        });
    //}
    //
    //private function computeCompatibilities(Graph $compatibility, Graph $incompatibility): Collection
    //{
    //    $incompatibilityVertices = collect($incompatibility->getVertices()->getVector());
    //
    //    /**
    //     * 1. Select a compatibility vertex.
    //     * 2. Go to the incompatibility graph and remove all incident vertices with the selected compatibility vertex
    //     *    from the compatibility graph.
    //     * 3. Consider all reachable vertices from the selected compatibility vertex in the compatibility graph as
    //     *    compatible with the selected compatibility vertex.
    //     */
    //    return collect($compatibility->getVertices()->getVector())
    //        ->mapWithKeys(function (Vertex $compatibilityVertex) use ($compatibility, $incompatibility, $incompatibilityVertices) {
    //            $id = $compatibilityVertex->getId();
    //            $compatibilityCopy = $compatibility->createGraphClone();
    //            $incompatibilityVertex = $incompatibility->getVertex($id);
    //
    //            $incompatibilityVertices
    //                // choose incompatibility vertices that are incident to the selected compatibility vertex
    //                ->filter(function (Vertex $otherIncompatibilityVertex) use ($incompatibilityVertex) {
    //                    return $incompatibilityVertex->hasEdgeTo($otherIncompatibilityVertex);
    //                })
    //                // remove the incompatibility vertex that is equal to the selected compatibility vertex (since this
    //                // compatibility vertex will be the starting point of the reachability search)
    //                ->reject(function (Vertex $otherIncompatibilityVertex) use ($incompatibilityVertex) {
    //                    return $otherIncompatibilityVertex === $incompatibilityVertex;
    //                })
    //                // remove all incompatibility vertices that are incident to the selected compatibility vertex from
    //                // the compatibility graph
    //                ->each(function (Vertex $incompatibilityVertex) use ($compatibilityCopy) {
    //                    $compatibilityCopy->getVertex($incompatibilityVertex->getId())->destroy();
    //                });
    //
    //            return [$compatibilityVertex->getId() =>
    //                        $this->verticesToIds((new DepthFirst($compatibilityCopy->getVertex($id)))->getVertices())];
    //        });
    //}
    //
    //private function verticesToIds(Vertices $vertices): Collection
    //{
    //    return collect($vertices->getVector())->map(function (Vertex $vertex) {
    //        return $vertex->getId();
    //    });
    //}
    //
    //private function generateCompatibilityGraph(Graph $incompatibilityGraph, Graph $typeTree): Graph
    //{
    //    $compatibilityGraph = $this->generateGraphComplement($incompatibilityGraph);
    //    $vertices = $compatibilityGraph->getVertices()->getVector();
    //
    //    for ($i = 0; $i < count($vertices); $i++) {
    //        for ($j = 0; $j < count($vertices); $j++) {
    //            $t1 = $vertices[$i]->getAttribute('type');
    //            $t2 = $vertices[$j]->getAttribute('type');
    //            $distanceOverOne = !$typeTree->getEdges()->hasEdgeMatch(function (Edge $edge) use ($t1, $t2) {
    //                $fromType = $edge->getVerticesStart()->getVertexFirst()->getAttribute('type');
    //                $toType = $edge->getVerticesTarget()->getVertexFirst()->getAttribute('type');
    //
    //                return ($fromType === $t1 && $toType === $t2) || ($fromType === $t2 && $toType === $t1);
    //            });
    //
    //            if ($t1 !== $t2 && $distanceOverOne) {
    //                $vertices[$i]->getEdgesTo($vertices[$j])->getEdgeFirst()->destroy();
    //            };
    //        }
    //    }
    //
    //    return $compatibilityGraph;
    //}
    //
    //private function generateGraphComplement(Graph $g): Graph
    //{
    //    $complement = $g->createGraphClone();
    //    $vertices = $complement->getVertices()->getVector();
    //
    //    for ($i = 0; $i < count($vertices); $i++) {
    //        for ($j = 0; $j < count($vertices); $j++) {
    //            $edges = $vertices[$i]->getEdgesTo($vertices[$j]);
    //
    //            if ($edges->count()) {
    //                $edges->getEdgeFirst()->destroy();
    //            } else {
    //                $vertices[$i]->createEdge($vertices[$j]);
    //            }
    //        }
    //    }
    //
    //    return $complement;
    //}
    //
    //private function ddGraph(Graph $graph): void
    //{
    //    if (!config('app.debug')) {
    //        throw new Exception('Debugging is turned off');
    //    }
    //
    //    $graphViz = new GraphViz();
    //
    //    collect($graph->getVertices()->getVector())->each(function (Vertex $vertex) {
    //        $vertex->setAttribute('graphviz.label', Component::find($vertex->getId())->name);
    //    });
    //
    //    echo $graphViz->createImageHtml($graph);
    //    dd();
    //}
}
