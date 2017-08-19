<?php

namespace PCLab\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use PCLab\Presenters\Presenter;

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

        return app()->make($this->presenter);
    }
}
