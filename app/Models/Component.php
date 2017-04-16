<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;
use Laracasts\Presenter\PresentableTrait;
use PCForge\Services\ComponentCompatibilityService;

class Component extends PCForgeModel
{
    use PresentableTrait;

    protected $fillable = [
        'component_type_id',
        'asin',
        'is_available',
        'name',
        'price',
        'watts_usage',
        'weight',
    ];

    protected $presenter = 'PCForge\Presenters\ComponentPresenter';

    public function type()
    {
        return $this->belongsTo(ComponentType::class, 'component_type_id', 'id');
    }

    public function child(): ComponentChild
    {
        $model = 'PCForge\Models\\' . ucfirst($this->type->name) . 'Component';

        return $model::where('component_id', $this->id)->first();
    }
}
