<?php

namespace PCForge\Models;

use Exception;
use PCForge\Presenters\Presenter;

trait HasPresenterTrait
{
    public function presenter(): Presenter
    {
        if (!$this->presenter || !class_exists($this->presenter)) {
            throw new Exception('Invalid or nonexistent presenter class');
        }

        app()
            ->when($this->presenter)
            ->needs(PCForgeModel::class)
            ->give(function () {
                return $this;
            });

        return app()->make($this->presenter);
    }
}
