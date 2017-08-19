<?php

namespace PCLab\Compatibility\Comparators;

use PCLab\Compatibility\Contracts\SystemContract;
use PCLab\Compatibility\Helpers\System;
use PCLab\Models\ChassisComponent;
use PCLab\Models\StorageComponent;

class ChassisStorageComparator implements IncompatibilityComparator
{
    /** @var SystemContract $system */
    private $system;

    public function __construct(SystemContract $system)
    {
        $this->system = $system;
    }

    /**
     * @param ChassisComponent $chassis
     * @param StorageComponent $storage
     *
     * @return bool
     */
    public function isIncompatible($chassis, $storage): bool
    {
        list($avail2p5, $avail3p5, $availAdapt) = $this->system->getAvailableBayCounts($chassis);

        return (($storage->width === System::WIDTH_2P5) ? $avail2p5 : $avail3p5) + $availAdapt === 0;
    }
}