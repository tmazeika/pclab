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
        $countInc = $select ? 1 : -1;
        $components = Component::all();

        // first pass: (in)directly (in)compatible components
        $incompatibleComponentIds = $components
            ->whereNotIn('id', Compatibility::where('component_1_id', $componentId)->pluck('component_2_id')->all())
            ->pluck('id')
            ->all();

        // second pass: dynamically (in)compatible components
        // TODO

        // finally, rank up all disabled components
        $disabledCounts = [];

        foreach ($incompatibleComponentIds as $key => $incompatibleComponentId) {
            $disabledCount = session("c$incompatibleComponentId-disabled", 0) + $countInc;

            // if a component is still disabled after the user has deselected the triggering component, don't try to
            // re-enable it
            if ($disabledCount > 0 && !$select) {
                unset($incompatibleComponentIds[$key]);
            }
            else if ($disabledCount < 0) {
                abort(400, 'Component is disabled a negative number of times');
            }

            $disabledCounts[] = ["c$incompatibleComponentId-disabled" => $disabledCount];
        }

        session(array_merge([], ...$disabledCounts));

        return array_values($incompatibleComponentIds);
    }
}
