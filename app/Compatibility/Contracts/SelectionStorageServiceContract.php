<?php

namespace PCForge\Compatibility\Contracts;

use PCForge\Compatibility\Helpers\Selection;

interface SelectionStorageServiceContract
{
    public function store(Selection $selection): void;

    public function retrieve(): Selection;
}
