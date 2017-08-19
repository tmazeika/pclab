<?php

namespace PCLab\Compatibility\Helpers;

use Exception;
use Fhaculty\Graph\Edge\Base as Edge;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\GraphViz\GraphViz;
use PCLab\Models\Component;
use PCLab\Models\ComponentChild;

final class GraphUtils
{
    private const COMPONENT_ATTR = 'component';

    /**
     * Echos an image representation of the given graph. May only be used when 'app.debug' is true.
     *
     * @param Graph $g
     *
     * @throws Exception when debugging is disabled
     */
    public static function dump(Graph $g): void
    {
        if (!config('app.debug')) {
            throw new Exception('Debugging is disabled');
        }

        /** @var Vertex $v */
        foreach ($g->getVertices() as $v) {
            $attr = self::getVertexComponent($v);
            $label = $v->getId() . '. ' . ($attr === null)
                ? Component::findOrFail($v->getId())->name
                : $attr->parent->name;

            $v->setAttribute('graphviz.label', $label);
        }

        echo (new GraphViz())->createImageHtml($g);
    }

    public static function getVertexComponent(Vertex $v): ?ComponentChild
    {
        return $v->getAttribute(self::COMPONENT_ATTR);
    }

    public static function setVertexComponent(Vertex $v, ComponentChild $component): void
    {
        $v->setAttribute(self::COMPONENT_ATTR, $component);
    }

    /**
     * Builds the complement of the given graph.
     *
     * @param Graph $g
     *
     * @return Graph
     */
    public static function complement(Graph $g): Graph
    {
        $gC = new Graph();
        $vertices = collect($g->getVertices()->getVector());

        $vertices
            ->each(function (Vertex $v) use ($gC) {
                $gC->createVertexClone($v);
            })
            ->each(function (Vertex $v1) use ($gC, $vertices) {
                $vertices
                    ->reject(function (Vertex $v2) use ($v1) {
                        return $v1->hasEdgeTo($v2);
                    })
                    ->each(function (Vertex $v2) use ($gC, $v1) {
                        self::createEdgeIn($gC, $v1, $v2);
                    });
            });

        return $gC;
    }

    /**
     * Creates an edge between the given vertices in $g.
     *
     * @param Graph $g
     * @param Vertex $v1
     * @param Vertex $v2
     *
     * @return Edge
     */
    private static function createEdgeIn(Graph $g, Vertex $v1, Vertex $v2): Edge
    {
        return $g->getVertex($v1->getId())->createEdge($g->getVertex($v2->getId()));
    }
}