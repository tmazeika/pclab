<?php

namespace PCForge\Contracts;

use Illuminate\Database\Eloquent\Builder;

interface ComponentRepositoryContract
{
    public function withParent($modelClass): Builder;
}
