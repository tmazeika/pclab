<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

abstract class PCForgeModel extends Model
{
    public static function tableName()
    {
        $calledClass = get_called_class();

        return (new $calledClass)->getTable();
    }
}
