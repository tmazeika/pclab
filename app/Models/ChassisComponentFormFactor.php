<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int id
 * @property int chassis_component_id
 * @property int form_factor_id
 *
 * @property ChassisComponent chassis_component
 * @property FormFactor form_factor
 */
class ChassisComponentFormFactor extends Model
{
    public $table = 'chassis_component_form_factor';

    public $timestamps = false;

    protected $fillable = [
        'chassis_component_id',
        'form_factor_id',
    ];
}
