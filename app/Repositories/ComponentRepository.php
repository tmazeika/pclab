<?php

namespace PCForge\Repositories;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\Component;

class ComponentRepository implements ComponentRepositoryContract
{
    public function getAllAvailableComponentsWithIds(): Collection
    {
        return cache()->tags('components')->rememberForever('available-components-ids', function () {
            return Component::select('id', 'component_type_id')->where('is_available', true)->get();
        });
    }

    public function getAllAvailableComponents(): Collection
    {
        return cache()->tags('components')->rememberForever('available-components-types', function () {
            return Component::where('is_available', true)->get();
        });
    }
}
