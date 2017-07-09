<?php

namespace PCForge\Services;

use PCForge\Compatibility\Helpers\Selection;
use PCForge\Contracts\ComponentRepositoryContract;
use PCForge\Contracts\SelectionStorageServiceContract;

class SelectionStorageService implements SelectionStorageServiceContract
{
    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    /** @var Selection $selection */
    private $selection;

    public function __construct(ComponentRepositoryContract $componentRepo, Selection $selection)
    {
        $this->componentRepo = $componentRepo;
        $this->selection = $selection;
    }

    public function store(): void
    {
        session(['selection' => $this->selection->getAll()->pluck('parent.id')]);
    }

    public function retrieve(array $selects = ['*'], array $withs = []): void
    {
        $all = $this->componentRepo->all($selects, $withs);

        $this->selection->setAll(session('selection', collect())->map(function (int $id) use ($all) {
            return $all->where('parent.id', $id)->first();
        }));
    }
}
