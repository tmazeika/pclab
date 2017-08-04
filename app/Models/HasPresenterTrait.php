<?php

namespace PCForge\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
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
            ->needs(Model::class)
            ->give(function () {
                return $this;
            });

        return resolve($this->presenter);
    }
}
