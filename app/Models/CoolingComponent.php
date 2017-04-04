<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CoolingComponent extends Model implements CompatibilityNode
{
    use ComponentChild, Validatable;

    protected $fillable = [
        'id',
        'component_id',
        'is_air',
        'fan_width',
        'height',
        'max_memory_height',
        'radiator_length',
    ];

    private $createRules = [
        'id'                => 'nullable|integer|unique:cooling_components|min:0',
        'component_id'      => 'required|exists:components,id|unique:cooling_components',
        'is_air'            => 'required|boolean',
        'fan_width'         => 'required|integer|min:0',
        'height'            => 'required|integer|min:0',
        'max_memory_height' => 'required|integer|min:0',
        'radiator_length'   => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                => 'nullable|integer|unique:cooling_components|min:0',
        'component_id'      => 'nullable|exists:components,id|unique:cooling_components',
        'is_air'            => 'nullable|boolean',
        'fan_width'         => 'nullable|integer|min:0',
        'height'            => 'nullable|integer|min:0',
        'max_memory_height' => 'nullable|integer|min:0',
        'radiator_length'   => 'nullable|integer|min:0',
    ];

    public function sockets()
    {
        return $this->belongsToMany('PCForge\Models\Socket');
    }

    public function getAllDirectlyCompatibleComponents(): array
    {
        $coolingId = $this->id;
        $coolingComponentSocketTable = (new CoolingComponentSocket)->getTable();
        $motherboardComponentsTable = (new MotherboardComponent)->getTable();

        // motherboard
        $components[] = MotherboardComponent
            ::whereExists(function($query) use ($coolingId, $coolingComponentSocketTable, $motherboardComponentsTable) {
                $query
                    ->select(DB::raw(1))
                    ->from($coolingComponentSocketTable)
                    ->where('cooling_component_id', $coolingId)
                    ->whereRaw("$coolingComponentSocketTable.socket_id = $motherboardComponentsTable.socket_id");
                })
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }

    public function getAllDirectlyIncompatibleComponents(): array
    {
        $coolingId = $this->id;
        $coolingComponentSocketTable = (new CoolingComponentSocket)->getTable();
        $motherboardComponentsTable = (new MotherboardComponent)->getTable();
        $processorComponentsTable = (new ProcessorComponent)->getTable();

        // chassis TODO: check radiators
        $components[] = ChassisComponent
            ::where('max_cooling_fan_height', '<', $this->height)
            ->pluck('component_id')
            ->all();

        // cooling
        $components[] = CoolingComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        // memory
        $components[] = MemoryComponent
            ::where('height', '>', $this->max_memory_height)
            ->pluck('component_id')
            ->all();

        // motherboard
        $components[] = MotherboardComponent
            ::whereNotExists(function($query) use ($coolingId, $coolingComponentSocketTable, $motherboardComponentsTable) {
                $query
                    ->select(DB::raw(1))
                    ->from($coolingComponentSocketTable)
                    ->where('cooling_component_id', $coolingId)
                    ->whereRaw("$coolingComponentSocketTable.socket_id = $motherboardComponentsTable.socket_id");
            })
            ->pluck('component_id')
            ->all();

        // processor
        $components[] = ProcessorComponent
            ::whereNotExists(function($query) use ($coolingId, $coolingComponentSocketTable, $processorComponentsTable) {
                $query
                    ->select(DB::raw(1))
                    ->from($coolingComponentSocketTable)
                    ->where('cooling_component_id', $coolingId)
                    ->whereRaw("$coolingComponentSocketTable.socket_id = $processorComponentsTable.socket_id");
            })
            ->pluck('component_id')
            ->all();

        return array_merge(...$components);
    }
}
