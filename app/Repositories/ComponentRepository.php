<?php

namespace PCForge\Repositories;

use Illuminate\Database\Eloquent\Builder;
use PCForge\Contracts\ComponentRepositoryContract;

class ComponentRepository implements ComponentRepositoryContract
{
    public function withParent($modelClass): Builder
    {
        return $modelClass::join('components', 'components.child_id', '=', $modelClass::typeName() . '_components.id');
    }
}
