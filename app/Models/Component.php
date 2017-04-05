<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use Validatable;

    protected $fillable = [
        'id',
        'component_type_id',
        'asin',
        'name',
        'watts_usage',
        'weight',
    ];

    private $createRules = [
        'id'                => 'nullable|integer|unique:components|min:0',
        'component_type_id' => 'required|exists:component_types,id',
        'asin'              => 'required|string|unique:components',
        'name'              => 'required|string',
        'watts_usage'       => 'required|integer|min:0',
        'weight'            => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                => 'nullable|integer|unique:components|min:0',
        'component_type_id' => 'nullable|exists:component_types,id',
        'asin'              => 'nullable|string|unique:components',
        'name'              => 'nullable|string',
        'watts_usage'       => 'nullable|integer|min:0',
        'weight'            => 'nullable|integer|min:0',
    ];

    public function img()
    {
        return asset('img/components/' . str_pad($this->id, 6, '0', STR_PAD_LEFT) . '.jpg');
    }

    public function isSelected()
    {
        return session("c$this->id-selected");
    }

    public function isDisabled()
    {
        return session("c$this->id-disabled", 0) > 0;
    }

    public function getPrice()
    {
        return cache("a$this->asin-price", 0);
    }

    public function isAvailable()
    {
        return cache("a$this->asin-available", false);
    }

    public function getPriceFormatted()
    {
        return '$' . number_format($this->getPrice() / 100.0, 2);
    }

    public function type()
    {
        return $this->belongsTo('PCForge\Models\ComponentType', 'component_type_id', 'id');
    }

    public function castToActualComponent(): CompatibilityNode
    {
        $model = 'PCForge\Models\\' . ucfirst($this->type->name) . 'Component';

        return $model::where('component_id', $this->id)->first();
    }
}
