<?php

namespace PCLab\Compatibility\Contracts;

use Fhaculty\Graph\Graph;
use Illuminate\Support\Collection;

interface IncompatibilityGraphContract
{
    /**
     * Builds a true incompatibility graph from the given components. The returned graph contains both direct and
     * indirect incompatibilities.
     *
     * @param Collection $components
     *
     * @return Graph
     */
    public function build(Collection $components): Graph;
}