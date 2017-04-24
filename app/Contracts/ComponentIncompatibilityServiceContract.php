<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentIncompatibilityServiceContract
{
    public function getIncompatibilities(array $selection): Collection;
}
