<?php

namespace PCForge\Compatibility\Services;

use PCForge\Compatibility\Contracts\ComponentRepositoryContract;
use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Compatibility\Contracts\SelectionStorageServiceContract;
use PCForge\Compatibility\Helpers\Selection;
use PCForge\Models\ComponentChild;

class SelectionStorageService implements SelectionStorageServiceContract
{
    private const SESSION_KEY = 'selection';

    public function store(): void
    {
        $this->checkSession();

        session([
            self::SESSION_KEY => resolve(SelectionContract::class)->getCounts(),
        ]);
    }

    public function retrieve(): SelectionContract
    {
        $this->checkSession();

        /** @var array $counts */
        $counts = session(self::SESSION_KEY, []);
        $selection = new Selection(resolve(ComponentRepositoryContract::class), $counts);

        // refresh all stored components
        $selection->getAll()->each(function (ComponentChild $component) use ($selection) {
            $component->refresh();
        });

        return $selection;
    }

    private function checkSession(): void
    {
        if (!session()->isStarted()) {
            abort(500, 'Session not started');
        }
    }
}
