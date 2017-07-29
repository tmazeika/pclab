<?php

namespace PCForge\Compatibility\Services;

use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Illuminate\Support\Collection;
use PCForge\Compatibility\Contracts\ComponentIncompatibilityServiceContract;
use PCForge\Compatibility\Contracts\IncompatibilityGraphContract;
use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Compatibility\Contracts\SelectionStorageServiceContract;
use PCForge\Compatibility\Helpers\GraphUtils;
use PCForge\Compatibility\Helpers\IncompatibilityGraph;
use PCForge\Models\ComponentChild;

class ComponentIncompatibilityService implements ComponentIncompatibilityServiceContract
{
    /** @var IncompatibilityGraphContract $incompatibilityGraph */
    private $incompatibilityGraph;

    /** @var SelectionContract $selection */
    private $selection;

    public function __construct(IncompatibilityGraphContract $incompatibilityGraph, SelectionContract $selection)
    {
        $this->incompatibilityGraph = $incompatibilityGraph;
        $this->selection = $selection;
    }

    public function getIncompatibilities(): Collection
    {
        $g = new Graph();

        $this->incompatibilityGraph->build($g);

        /** @var Collection $selection */
        $selection = $this->selection->getAll();

        if ($selection->count() === 0) {
            return collect();
        }

        return $selection
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
                return $v->getAttribute(IncompatibilityGraph::COMPONENT_ATTR);
            })
            ->values();
    }
}
