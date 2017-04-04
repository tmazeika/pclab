<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MotherboardComponent extends Model implements CompatibilityNode
{
    use ComponentChild, Validatable, VideoOutputer;

    protected $fillable = [
        'id',
        'component_id',
        'audio_headers',
        'fan_headers',
        'usb2_headers',
        'usb3_headers',
        'form_factor_id',
        'has_displayport_out',
        'has_dvi_out',
        'has_hdmi_out',
        'has_vga_out',
        'pcie3_slots',
        'supports_sli',
        'dimm_gen',
        'dimm_pins',
        'dimm_slots',
        'dimm_max_capacity',
        'atx12v_pins',
        'socket_id',
        'sata_slots',
    ];

    private $createRules = [
        'id'                  => 'nullable|integer|unique:motherboard_components|min:0',
        'component_id'        => 'required|exists:components,id|unique:motherboard_components',
        'audio_headers'       => 'required|integer|min:0',
        'fan_headers'         => 'required|integer|min:0',
        'usb2_headers'        => 'required|integer|min:0',
        'usb3_headers'        => 'required|integer|min:0',
        'form_factor_id'      => 'required|exists:form_factors,id',
        'has_displayport_out' => 'required|boolean',
        'has_dvi_out'         => 'required|boolean',
        'has_hdmi_out'        => 'required|boolean',
        'has_vga_out'         => 'required|boolean',
        'pcie3_slots'         => 'required|integer|min:0',
        'supports_sli'        => 'required|boolean',
        'dimm_gen'            => 'required|integer|min:0',
        'dimm_pins'           => 'required|integer|min:0',
        'dimm_slots'          => 'required|integer|min:0',
        'dimm_max_capacity'   => 'required|integer|min:0',
        'atx12v_pins'         => 'required|integer|min:0',
        'socket_id'           => 'required|exists:sockets,id',
        'sata_slots'          => 'required|integer|min:0',
    ];

    private $updateRules = [
        'id'                  => 'nullable|integer|unique:motherboard_components|min:0',
        'component_id'        => 'nullable|exists:components,id|unique:motherboard_components',
        'audio_headers'       => 'nullable|integer|min:0',
        'fan_headers'         => 'nullable|integer|min:0',
        'usb2_headers'        => 'nullable|integer|min:0',
        'usb3_headers'        => 'nullable|integer|min:0',
        'form_factor_id'      => 'nullable|exists:form_factors,id',
        'has_displayport_out' => 'nullable|boolean',
        'has_dvi_out'         => 'nullable|boolean',
        'has_hdmi_out'        => 'nullable|boolean',
        'has_vga_out'         => 'nullable|boolean',
        'pcie3_slots'         => 'nullable|integer|min:0',
        'supports_sli'        => 'nullable|boolean',
        'dimm_gen'            => 'nullable|integer|min:0',
        'dimm_pins'           => 'nullable|integer|min:0',
        'dimm_slots'          => 'nullable|integer|min:0',
        'dimm_max_capacity'   => 'nullable|integer|min:0',
        'atx12v_pins'         => 'nullable|integer|min:0',
        'socket_id'           => 'nullable|exists:sockets,id',
        'sata_slots'          => 'nullable|integer|min:0',
    ];

    public function form_factor()
    {
        return $this->belongsTo('PCForge\Models\FormFactor');
    }

    public function socket()
    {
        return $this->belongsTo('PCForge\Models\Socket');
    }

    public function getAllDirectlyCompatibleComponents(): array
    {
        $formFactorId = $this->form_factor->id;
        $socketId = $this->socket->id;
        $chassisComponentFormFactorTable = (new ChassisComponentFormFactor)->getTable();
        $coolingComponentSocketTable = (new CoolingComponentSocket)->getTable();
        $chassisComponentsTable = (new ChassisComponent)->getTable();
        $coolingComponentsTable = (new CoolingComponent)->getTable();

        // chassis
        $components[] = ChassisComponent
            ::where('audio_headers', '<=', $this->audio_headers)
            ->where('fan_headers', '<=', $this->fan_headers)
            ->where('usb2_headers', '<=', $this->usb2_headers)
            ->where('usb3_headers', '<=', $this->usb3_headers)
            ->whereExists(function($query) use ($formFactorId, $chassisComponentFormFactorTable, $chassisComponentsTable) {
                $query
                    ->select(DB::raw(1))
                    ->from($chassisComponentFormFactorTable)
                    ->whereRaw("$chassisComponentFormFactorTable.chassis_component_id = $chassisComponentsTable.id")
                    ->where('form_factor_id', $formFactorId);
            })
            ->pluck('component_id')
            ->all();

        // cooling
        $components[] = CoolingComponent
            ::whereExists(function($query) use ($socketId, $coolingComponentSocketTable, $coolingComponentsTable) {
                $query
                    ->select(DB::raw(1))
                    ->from($coolingComponentSocketTable)
                    ->whereRaw("$coolingComponentSocketTable.cooling_component_id = $coolingComponentsTable.id")
                    ->where('socket_id', $socketId);
            })
            ->pluck('component_id')
            ->all();

        // graphics TODO: check count
        $components[] = GraphicsComponent
            ::all()
            ->pluck('component_id')
            ->all();

        // memory TODO: safer way to do the whereRaw?
        $components[] = MemoryComponent
            ::whereRaw('count * capacity_each <= ' . $this->dimm_max_capacity)
            ->where('count', '<=', $this->dimm_slots)
            ->where('ddr_gen', $this->dimm_gen)
            ->where('pins', $this->dimm_pins)
            ->pluck('component_id')
            ->all();

        // processor
        $components[] = ProcessorComponent
            ::where('socket_id', $socketId)
            ->pluck('component_id')
            ->all();

        // storage TODO: check count (SATA)

        return array_merge(...$components);
    }

    public function getAllDirectlyIncompatibleComponents(): array
    {
        $formFactorId = $this->form_factor_id;
        $socketId = $this->socket_id;
        $chassisComponentFormFactorTable = (new ChassisComponentFormFactor)->getTable();
        $coolingComponentSocketTable = (new CoolingComponentSocket)->getTable();
        $chassisComponentsTable = (new ChassisComponent)->getTable();
        $coolingComponentsTable = (new CoolingComponent)->getTable();

        // chassis
        $components[] = ChassisComponent
            ::where('audio_headers', '>', $this->audio_headers)
            ->orWhere('fan_headers', '>', $this->fan_headers)
            ->orWhere('usb2_headers', '>', $this->usb2_headers)
            ->orWhere('usb3_headers', '>', $this->usb3_headers)
            ->orWhereNotExists(function($query) use ($formFactorId, $chassisComponentFormFactorTable, $chassisComponentsTable) {
                $query
                    ->select(DB::raw(1))
                    ->from($chassisComponentFormFactorTable)
                    ->whereRaw("$chassisComponentFormFactorTable.chassis_component_id = $chassisComponentsTable.id")
                    ->where('form_factor_id', $formFactorId);
            })
            ->pluck('component_id')
            ->all();

        // cooling
        $components[] = CoolingComponent
            ::whereNotExists(function($query) use ($socketId, $coolingComponentSocketTable, $coolingComponentsTable) {
                $query
                    ->select(DB::raw(1))
                    ->from($coolingComponentSocketTable)
                    ->whereRaw("$coolingComponentSocketTable.cooling_component_id = $coolingComponentsTable.id")
                    ->where('socket_id', $socketId);
            })
            ->pluck('component_id')
            ->all();

        // graphics TODO: check count

        // memory TODO: safer way to do the whereRaw?
        $components[] = MemoryComponent
            ::whereRaw('count * capacity_each > ' . $this->dimm_max_capacity)
            ->orWhere('count', '>', $this->dimm_slots)
            ->orWhere('ddr_gen', '!=', $this->dimm_gen)
            ->orWhere('pins', '!=', $this->dimm_pins)
            ->pluck('component_id')
            ->all();

        // motherboard
        $components[] = MotherboardComponent
            ::where('id', '!=', $this->id)
            ->pluck('component_id')
            ->all();

        // processor
        $components[] = ProcessorComponent
            ::where('socket_id', '!=', $socketId)
            ->pluck('component_id')
            ->all();

        // storage TODO: check count (SATA)

        return array_merge(...$components);
    }
}
