<?php

namespace PCForge\Presenters;

class ComponentPresenter extends Presenter
{
    use ComponentPresenterTrait;

    public function formattedPrice()
    {
        return '$' . number_format($this->entity->price / 100.0, 2);
    }

    public function img()
    {
        $id = $this->entity->id;

        return asset("img/components/$id.jpg");
    }
}
