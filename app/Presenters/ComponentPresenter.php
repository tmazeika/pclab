<?php

namespace PCForge\Presenters;

use Laracasts\Presenter\Presenter;

class ComponentPresenter extends Presenter
{
    public function formattedPrice()
    {
        return '$' . number_format($this->price / 100.0, 2);
    }

    public function img()
    {
        return asset("img/components/$this->id.jpg");
    }
}
