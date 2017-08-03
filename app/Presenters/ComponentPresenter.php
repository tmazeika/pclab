<?php

namespace PCForge\Presenters;

class ComponentPresenter extends Presenter
{
    private const COMPONENT_IMG_DIR = 'img/components';

    use ComponentPresenterTrait;

    public function formattedPrice()
    {
        return '$' . number_format($this->entity->price / 100.0, 2);
    }

    public function img()
    {
        $id = $this->entity->id;

        return asset(self::COMPONENT_IMG_DIR . "/$id.jpg");
    }
}
