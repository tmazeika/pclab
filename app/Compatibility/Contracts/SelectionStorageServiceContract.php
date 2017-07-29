<?php

namespace PCForge\Compatibility\Contracts;

interface SelectionStorageServiceContract
{
    public function store(): void;

    public function retrieve(): SelectionContract;
}
