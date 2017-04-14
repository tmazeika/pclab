<?php

namespace PCForge\Repositories;

use Illuminate\Support\Collection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Models\Component;

class ComponentRepository implements ComponentRepositoryContract
{
    public function all(): Collection
    {
        return cache()->tags('components')->rememberForever('all', function () {
            return Component::all();
        });
    }
}
