<?php

namespace PCLab\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use PCLab\Presenters\ComponentPresenter;

/**
 * @property int id
 * @property int component_type_id
 * @property int child_id
 * @property string child_type
 * @property string asin
 * @property bool is_available
 * @property string name
 * @property int price
 * @property int watts_usage
 * @property int weight
 *
 * @property ComponentChild child
 * @property ComponentType type
 */
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
        return $this->belongsTo(ComponentType::class, 'component_type_id');
    }

    public function child()
    {
        return $this->morphTo();
    }

    public function scopeWithAll(Builder $query): void
    {
        $query->with('type', 'child');
    }
}
