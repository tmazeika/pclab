<?php

namespace PCForge\Contracts;

interface ComponentSelectionServiceContract
{
    public function select(int $id, int $count): void;

    public function isSelected(int $id): bool;

    public function getCount(int $id): int;

    public function selection(): array;
}
