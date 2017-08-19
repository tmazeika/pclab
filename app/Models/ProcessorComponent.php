<?php

namespace PCLab\Models;

use Illuminate\Database\Eloquent\Builder;
use PCLab\Presenters\ProcessorComponentPresenter;

/**
 * @property int id
 * @property int cores
 * @property bool has_apu
 * @property bool has_stock_cooler
 * @property int speed
 * @property int socket_id
 *
 * @property Socket socket
 */
class ProcessorComponent extends ComponentChild
{
    protected $fillable = [
        'cores',
        'has_apu',
        'has_stock_cooler',
        'socket_id',
        'speed',
    ];

    protected $presenter = ProcessorComponentPresenter::class;

    public function socket()
    {
        return $this->belongsTo(Socket::class);
    }

    public function scopeWithAll(Builder $query): void
    {
        parent::scopeWithAll($query);

        $query->with('socket');
    }

    public function getRequiredComponentTypes(): array
    {
        $arr = [];

        if (!$this->has_apu) {
            $arr[] = GraphicsComponent::typeName();
        }

        if (!$this->has_stock_cooler) {
            $arr[] = CoolingComponent::typeName();
        }

        return $arr;
    }

}
