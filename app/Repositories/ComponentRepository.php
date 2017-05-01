<?php

namespace PCForge\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use PCForge\Contracts\ComponentRepositoryContract;

class ComponentRepository implements ComponentRepositoryContract
{
    public function withParent($modelClass): Builder
    {
        return $modelClass::join('components', function (JoinClause $join) use ($modelClass) {
            $join
                ->on('components.child_id', '=', $modelClass::typeName().'_components.id')
                ->where('components.child_type', '=', $modelClass::typeName());
        });
    }
}
