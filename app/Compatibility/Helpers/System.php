<?php

namespace PCForge\Compatibility\Helpers;

use PCForge\Contracts\SystemContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\ComponentChild;
use PCForge\Models\PowerComponent;
use PCForge\Models\StorageComponent;

class System implements SystemContract
{
    public const WIDTH_2P5 = '2p5';

    /** The least number of watts above the computed system wattage the power supply must be. */
    private const WATTS_BUFFER = 150;

    /** The computed system wattage should be reported in increments of this number. */
    private const WATTS_INCREMENT = 50;

    private $selection;

    public function __construct(Selection $selection)
    {
        $this->selection = $selection;
    }

    public function hasEnoughPower(ComponentChild $component, PowerComponent $power): bool
    {
        $safeTotal = $this->roundToIncrement(
            $this->getActualWattsUsage() + $component->parent->watts_usage + self::WATTS_BUFFER,
            self::WATTS_INCREMENT);

        return $safeTotal <= $power->watts_out;
    }

    public function getAvailableBayCounts(ChassisComponent $chassis): array
    {
        $this->selection->getAllOfType(StorageComponent::class)
            ->each(function (StorageComponent $storage) use (&$used2p5, &$used3p5) {
                $selectCount = $storage->selectCount;
                ($storage->width === self::WIDTH_2P5) ? $used2p5 += $selectCount : $used3p5 += $selectCount;
            });

        $avail2p5 = $chassis->{'2p5_bays'};
        $avail3p5 = $chassis->{'3p5_bays'};
        $availAdapt = $chassis->adaptable_bays;

        if (($avail2p5 -= $used2p5) < 0) {
            $availAdapt += $avail2p5;
            $avail2p5 = 0;
        }

        if (($avail3p5 -= $used3p5) < 0) {
            $availAdapt += $avail3p5;
            $avail3p5 = 0;
        }

        return [$avail2p5, $avail3p5, $availAdapt];
    }

    private function getActualWattsUsage(): int
    {
        static $cached;

        return $cached ?? $cached = $this->selection->getAll()
                ->reduce(function (int $carry, ComponentChild $component) {
                    return $carry + $component->parent->watts_usage * $component->selectCount;
                }, 0);
    }

    private function roundToIncrement(float $x, int $increment): int
    {
        return ceil($x / $increment) * $increment;
    }
}