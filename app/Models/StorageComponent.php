<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

class StorageComponent extends Model implements CompatibilityNode
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'capacity',
        'is_ssd',
        'size',
    ];

    private $createRules = [
        'id'               => 'nullable|integer|unique:storage_components|min:0',
        'component_id'     => 'required|exists:components,id|unique:storage_components',
        'capacity'         => 'required|integer|min:0',
        'is_ssd'           => 'required|boolean',
        'storage_width_id' => 'required|exists:storage_widths,id',
    ];

    private $updateRules = [
        'id'               => 'nullable|integer|unique:storage_components|min:0',
        'component_id'     => 'nullable|exists:components,id|unique:storage_components',
        'capacity'         => 'nullable|integer|min:0',
        'is_ssd'           => 'nullable|boolean',
        'storage_width_id' => 'nullable|exists:storage_widths,id',
    ];

    public function storage_size()
    {
        return $this->hasMany('PCForge\Models\StorageWidth');
    }

    public function getAllDirectlyCompatibleComponents(): array
    {
        return [];
    }

    /**
     * Gets all components that are directly incompatible with this component. More specifically, the components that
     * can be reliably deemed incompatible with this component while disregarding the presence of other components in
     * the build.
     *
     * @return int[] an array of component ID's
     */
    public function getAllDirectlyIncompatibleComponents(): array
    {
        return [];
    }
}
