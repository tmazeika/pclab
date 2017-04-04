<?php

namespace PCForge\Services;

use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Models\Compatibility;
use PCForge\Models\Component;

class CompatibilityService implements CompatibilityServiceContract
{
    public function isAllowedToSelect(int $componentId): bool
    {
        return !session("c$componentId-selected", false)
            && session("c$componentId-disabled", 0) === 0;
    }

    public function select(int $componentId): array
    {
        return $this->setSelection($componentId, true);
    }

    public function deselect(int $componentId): array
    {
        return $this->setSelection($componentId, false);
    }

    private function setSelection(int $componentId, bool $select): array
    {
        $incompatibleIds = Component
            ::whereNotIn('id', Compatibility::where('component_1_id', $componentId)->pluck('component_2_id')->all())
            ->pluck('id')
            ->all();
        $sessionArray = [];

        foreach ($incompatibleIds as $key => $incompatibleId) {
            $disabledAmount = session("c$incompatibleId-disabled", 0) + ($select ? 1 : -1);

            if ($disabledAmount < 0) {
                $disabledAmount = 0;
            }

            $sessionArray[] = ["c$incompatibleId-disabled" => $disabledAmount];

            if ($disabledAmount > 0 && !$select) {
                unset($incompatibleIds[$key]);
            }
        }

        session(array_merge(["c$componentId-selected" => $select], ...$sessionArray));

        return array_values($incompatibleIds);
    }
}
