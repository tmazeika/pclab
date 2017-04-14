<?php

namespace PCForge\Contracts;

use Illuminate\Support\Collection;

interface ComponentRepositoryContract
{
    public function getAllAvailableComponentsWithIds(): Collection;

    public function getAllAvailableComponents(): Collection;
}
