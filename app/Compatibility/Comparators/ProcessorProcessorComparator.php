<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Models\ProcessorComponent;

class ProcessorProcessorComparator implements IncompatibilityComparator
{
    /**
     * @param ProcessorComponent $processor1
     * @param ProcessorComponent $processor2
     *
     * @return bool
     */
    public function isIncompatible($processor1, $processor2): bool
    {
        return $processor1->id !== $processor2->id;
    }
}