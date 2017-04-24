<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;
use PCForge\Presenters\ComponentPresenter;

class Component extends Model
{
    use HasPresenterTrait;

    protected $fillable = [
        'component_type_id',
        'child_id',
        'child_type',
        'asin',
        'is_available',
        'name',
        'price',
        'watts_usage',
        'weight',
    ];

    protected $presenter = ComponentPresenter::class;

    public function type()
    {
        return $this->belongsTo(ComponentType::class, 'component_type_id', 'id');
    }

    public function child()
    {
        return $this->morphTo();
    }
}
