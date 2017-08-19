<?php

namespace PCLab\Compatibility\Services;

use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Illuminate\Support\Collection;
use PCLab\Compatibility\Contracts\ComponentIncompatibilityServiceContract;
use PCLab\Compatibility\Contracts\ComponentRepositoryContract;
use PCLab\Compatibility\Contracts\IncompatibilityGraphContract;
use PCLab\Compatibility\Contracts\SelectionContract;
use PCLab\Compatibility\Contracts\SelectionStorageServiceContract;
use PCLab\Compatibility\Helpers\GraphUtils;
use PCLab\Compatibility\Helpers\IncompatibilityGraph;
use PCLab\Models\ComponentChild;

class ComponentIncompatibilityService implements ComponentIncompatibilityServiceContract
{
    /** @var IncompatibilityGraphContract $incompatibilityGraph */
    private $incompatibilityGraph;

    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    /** @var SelectionContract $selection */
    private $selection;

    public function __construct(IncompatibilityGraphContract $incompatibilityGraph, ComponentRepositoryContract $componentRepo, SelectionContract $selection)
    {
        $this->incompatibilityGraph = $incompatibilityGraph;
        $this->componentRepo = $componentRepo;
        $this->selection = $selection;
    }

    public function getIncompatibilities(): Collection
    {
        if ($this->selection->isEmpty()) {
            return collect();
        }

        $components = $this->componentRepo->get();
        $g = $this->incompatibilityGraph->build($components);

        return $this->selection->getAll()
            ->map(function (ComponentChild $component) use ($g) {
                return $g->getVertex($component->parent->id)->getVerticesEdge()->getVector();
            })
            ->reduce(function ($carry, array $vertices) {
                /** @var Collection|null $carry */
                return $carry
                    ? $carry->merge($vertices)
                    : collect($vertices);
            })
            ->uniqueStrict()
            ->map(function (Vertex $v) {
                return GraphUtils::getVertexComponent($v);
            });
    }
}
