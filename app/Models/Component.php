<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use ExtendedModel, Validatable;

    private const CREATE_RULES = [
        'id'                => 'nullable|integer|unique:components|min:0',
        'component_type_id' => 'required|exists:component_types,id',
        'asin'              => 'required|string|unique:components',
        'is_available'      => 'required|boolean',
        'name'              => 'required|string',
        'price'             => 'required|integer|min:0',
        'watts_usage'       => 'required|integer|min:0',
        'weight'            => 'required|integer|min:0',
    ];

    private const UPDATE_RULES = [
        'id'                => 'nullable|integer|unique:components|min:0',
        'component_type_id' => 'nullable|exists:component_types,id',
        'asin'              => 'nullable|string|unique:components',
        'is_available'      => 'nullable|boolean',
        'name'              => 'nullable|string',
        'price'             => 'nullable|integer|min:0',
        'watts_usage'       => 'nullable|integer|min:0',
        'weight'            => 'nullable|integer|min:0',
    ];

    protected $fillable = [
        'id',
        'component_type_id',
        'asin',
        'is_available',
        'name',
        'price',
        'watts_usage',
        'weight',
    ];

    public function type()
    {
        return $this->belongsTo('PCForge\Models\ComponentType', 'component_type_id', 'id');
    }

    public function getPriceFormatted()
    {
        return '$' . number_format($this->price / 100.0, 2);
    }

    public function getSelectedCountInSession(): int
    {
        return session("c$this->id-selected-count", 0);
    }

    public function img()
    {
        return asset('img/components/' . str_pad($this->id, 6, '0', STR_PAD_LEFT) . '.jpg');
    }

    public function isDisabledInSession(): bool
    {
        return !empty(session("c$this->id-disabled-from", []));
    }

    public function toCompatibilityNode(): CompatibilityNode
    {
        $model = 'PCForge\Models\\' . ucfirst($this->type->name) . 'Component';

        return $model::where('component_id', $this->id)->first();
    }
}
