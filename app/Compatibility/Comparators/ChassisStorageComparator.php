<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Contracts\SystemContract;
use PCForge\Compatibility\Helpers\System;
use PCForge\Models\ChassisComponent;
use PCForge\Models\StorageComponent;

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

    public function getComponents(): array
    {
        return ['chassis', 'storage'];
    }
}
