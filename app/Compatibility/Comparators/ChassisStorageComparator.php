<?php

namespace PCForge\Compatibility\Comparators;

use PCForge\Compatibility\Helpers\System;
use PCForge\Compatibility\IncompatibilityComparator;
use PCForge\Models\ChassisComponent;
use PCForge\Models\StorageComponent;

class ChassisStorageComparator implements IncompatibilityComparator
{
    // chassis
    public $select0 = [
        '2p5_bays',
        '3p5_bays',
        'adaptable_bays',
    ];

    // storage
    public $select1 = [
        'width',
    ];

    /** @var System $system */
    private $system;

    public function __construct(System $system)
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
