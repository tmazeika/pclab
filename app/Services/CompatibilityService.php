<?php

namespace PCForge\Services;

use PCForge\Contracts\CompatibilityServiceContract;
use PCForge\Models\Compatibility;
use PCForge\Models\Component;

class CompatibilityService implements CompatibilityServiceContract
{
    public function isAllowed(int $id, int $count): bool
    {
        return !$this->isDisabled($id);
    }

    public function select(int $id, int $count): array
    {
        session(["c$id-selected-count" => $count]);

        return Component
            ::all()
            // first pass: dynamically incompatible components
            // TODO
            // second pass: (in)directly incompatible components
            ->whereNotInStrict('id', Compatibility
                ::where('component_1_id', $id)
                ->pluck('component_2_id'))
            ->pluck('id')
            ->filter(function (int $incompatId) use ($id, $count) {
                $disabledFrom = session("c$incompatId-disabled-from", []);
                $disabledFromId = in_array($id, $disabledFrom);

                // if we're not deselecting and this component hasn't already been disabled by the selected component...
                if ($count > 0 && !$disabledFromId) {
                    session()->push("c$incompatId-disabled-from", $id);

                    return true;
                }

                // if we're deselecting and this component has previously been disabled by the selected component...
                if ($count === 0 && $disabledFromId && ($key = array_search($id, $disabledFrom, true)) !== false) {
                    session()->forget("c$incompatId-disabled-from.$key");

                    return !$this->isDisabled($incompatId);
                }

                return false;
            })
            ->values()
            ->all();
    }

    private function isDisabled(int $id): bool
    {
        return !empty(session("c$id-disabled-from"));
    }
}
