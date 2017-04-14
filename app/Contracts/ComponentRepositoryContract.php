<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentRepositoryContract
{
    public function all(): Collection;
}
