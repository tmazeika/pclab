<?php

namespace PCForge\Services;

use PCForge\Compatibility\Helpers\Selection;
use PCForge\Contracts\SelectionStorageServiceContract;
use PCForge\Models\ComponentChild;

class SelectionStorageService implements SelectionStorageServiceContract
{
    public function store(Selection $selection): void
    {
        session([
            'selection' => serialize($selection),
        ]);
    }

    public function retrieve(): Selection
    {
        $default = serialize(new Selection());

        /** @var Selection $selection */
        $selection = unserialize(session('selection', $default));

        // refresh all stored components
        $selection->getAll()->each(function (ComponentChild $component) {
            $component->refresh();
        });

        return $selection;
    }
}
