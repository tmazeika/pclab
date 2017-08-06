<?php

namespace PCForge\Compatibility\Helpers;

use Illuminate\Support\Collection;
use PCForge\Compatibility\Contracts\ComponentRepositoryContract;
use PCForge\Compatibility\Contracts\SelectionContract;
use PCForge\Models\ComponentChild;

class Selection implements SelectionContract
{
    /** @var ComponentRepositoryContract $componentRepo */
    private $componentRepo;

    /** @var array $counts */
    private $counts;

    public function __construct(ComponentRepositoryContract $componentRepo, array $counts)
    {
        $this->componentRepo = $componentRepo;
        $this->counts = $counts;
    }

    public function setProperties(Collection $components): void
    {
        /** @var ComponentChild $component */
        foreach ($components as $component)
        {
            $component->selectCount = $this->getSelectCount($component);
            $component->disabled = $this->isDisabled($component);
        }
    }

    public function select(ComponentChild $component, int $n): void
    {
        $id = $component->parent->id;
        $component->selectCount = $n;

        if ($n === 0) {
            unset($this->counts[$id]);
        } else {
            $this->counts[$id] = $n;
        }
    }

    public function disable(array $components): void
    {
        /** @var ComponentChild $component */
        foreach ($components as $component) {
            $component->disabled = true;
            $this->counts[$component->parent->id] = 0;
        }
    }

    public function disableOnly(array $components): void
    {
        // TODO: might be able to simplify
        // enable all
        /**
         * @var int $id
         * @var int $count
         */
        foreach ($this->counts as $id => $count)
        {
            if ($count === 0) {
                $this->componentRepo->get()->where('parent.id', $id)->first()->disabled = false;
                unset($this->counts[$id]);
            }
        }

        // disable given
        $this->disable($components);
    }

    public function getSelectCount(ComponentChild $component): int
    {
        return $this->counts[$component->parent->id] ?? 0;
    }

    public function isDisabled(ComponentChild $component): bool
    {
        return ($this->counts[$component->parent->id] ?? -1) === 0;
    }

    public function isEmpty(): bool
    {
        $arr = array_flip($this->counts);

        unset($arr[0]);

        return count($arr) === 0;
    }

    public function getAll(): Collection
    {
        return $this->componentRepo->get()
            ->filter(function (ComponentChild $component) {
                return in_array($component->parent->id, array_keys($this->counts));
            })
            ->reject(function (ComponentChild $component) {
                return $this->isDisabled($component);
            })
            ->each(function (ComponentChild $component) {
                $component->selectCount = $this->getSelectCount($component);
            });
    }

    public function getAllOfType(string $class): Collection
    {
        return $this->getAll()->filter(function (ComponentChild $component) use ($class) {
            return get_class($component) === $class;
        });
    }

    public function getCounts(): array
    {
        return $this->counts;
    }
}
