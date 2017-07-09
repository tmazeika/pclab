<?php

namespace PCForge\Compatibility\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\ChassisComponent;
use PCForge\Models\Component;
use PCForge\Models\MotherboardComponent;
use PCForge\Models\PowerComponent;
use PCForge\Models\StorageComponent;

class StorageComponentCompatibilityProvider implements CompatibilityProvider
{
    private const WIDTH_2P5 = '2p5';

    private const WIDTH_3P5 = '3p5';

    /** @var ComponentRepositoryContract $components */
    private $components;

    private $allStorage;

    public function __construct(ComponentRepositoryContract $componentRepo)
    {
        $this->components = $componentRepo;
    }

    public function getStaticallyCompatible($component): Collection
    {
        return collect([
            $this->components->withParent(ChassisComponent::class)
                ->pluck('components.id'),
            $this->components->withParent(MotherboardComponent::class)
                ->pluck('components.id'),
            $this->components->withParent(PowerComponent::class)
                ->pluck('components.id'),
            $component->id,
        ]);
    }

    public function getStaticallyIncompatible($component): Collection
    {
        return /*$this->components->withParent(MotherboardComponent::class)
            ->where('sata_slots', 0)
            ->pluck('components.id')*/collect();
    }

    public function getDynamicallyCompatible($component, array $selection): Collection
    {
        return collect();
    }

    public function getDynamicallyIncompatible($component, array $selection): Collection
    {
        // chassis
        $this->allStorage = null;
        $width = $component->width;
        $components[] = $this->components->withParent(ChassisComponent::class)
            ->select('components.id', '2p5_bays', '3p5_bays', 'adaptable_bays')
            ->get()
            ->reject(function (ChassisComponent $component) use ($width, $selection) {
                return $this->getAvailableBayCount($component, $width, $selection) > 0;
            })
            ->pluck('components.id');

        // motherboard
        // TODO: DRY
        $storageCount = Component
            ::whereIn('id', array_keys($selection))
            ->where('child_type', 'storage')
            ->get()
            ->reduce(function ($carry, Component $component) use ($selection) {
                return $selection[$component->id] + $carry ?? 0;
            }, 0);

        $components[] = $this->components->withParent(MotherboardComponent::class)
            ->where('sata_slots', '<', $storageCount)
            ->pluck('components.id');

        // power
        $components[] = $this->components->withParent(PowerComponent::class)
            ->where('sata_powers', '<', $storageCount)
            ->pluck('components.id');

        return collect($components);
    }

    private function getAvailableBayCount(Model $chassis, string $width, array $selection): int
    {
        (
            $this->allStorage ?? $this->allStorage = $this->components->withParent(StorageComponent::class)
                ->with('parent')
                ->select('storage_components.id', 'width')
                ->whereIn('components.id', array_keys($selection))
                ->get()
        )
            ->each(function (StorageComponent $component) use ($selection, &$used2p5, &$used3p5) {
                $count = $selection[$component->parent->id];
                $component->width === self::WIDTH_2P5 ? $used2p5 += $count : $used3p5 += $count;
            });


        $avail2p5 = $chassis->{'2p5_bays'};
        $avail3p5 = $chassis->{'3p5_bays'};
        $availAdapt = $chassis->adaptable;
        if ($chassis->id === 1) dd($avail2p5);

        if ($avail2p5 >= $used2p5) {
            $avail2p5 -= $used2p5;
        } else {
            $availAdapt -= $used2p5 - $avail2p5;
            $avail2p5 = 0;
        }

        if ($avail3p5 >= $used3p5) {
            $avail3p5 -= $used3p5;
        } else {
            $availAdapt -= $used3p5 - $avail3p5;
            $avail3p5 = 0;
        }

        return ($width === self::WIDTH_2P5 ? $avail2p5 : $avail3p5) + $availAdapt;
    }
}
