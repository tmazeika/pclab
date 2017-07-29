<?php

namespace PCForge\Compatibility\Helpers;

use Exception;
use Fhaculty\Graph\Graph;
use Fhaculty\Graph\Vertex;
use Graphp\GraphViz\GraphViz;
use PCForge\Models\Component;

class GraphUtils
{
    /**
     * Echos an image representation of the given graph and dies. May only be used when 'app.debug' is true.
     *
     * @param Graph $g
     *
     * @throws Exception
     */
    public static function dd(Graph $g): void
    {
        if (!config('app.debug')) {
            throw new Exception('Debugging is disabled');
        }

        /** @var Vertex $v */
        foreach ($g->getVertices() as $v) {
            $attr = $v->getAttribute(IncompatibilityGraph::COMPONENT_ATTR);

            if ($attr === null) {
                $name = Component::findOrFail($v->getId())->name;
            }
            else {
                $name = $attr->parent->name;
            }

            $v->setAttribute('graphviz.label', $name);
        }

        echo (new GraphViz())->createImageHtml($g);
        dd();
    }
}