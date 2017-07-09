<?php

namespace PCForge\Contracts;

interface SelectionStorageServiceContract
{
    public function store(): void;

    public function retrieve(array $selects = ['*'], array $withs = []): void;
}
