<?php

namespace PCForge\Compatibility\Contracts;

use Fhaculty\Graph\Graph;

interface IncompatibilityGraphContract
{
    public function build(Graph $g): void;
}