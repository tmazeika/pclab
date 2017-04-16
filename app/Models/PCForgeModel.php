<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

abstract class PCForgeModel extends Model
{
    public static function tableName()
    {
        $calledClass = get_called_class();

        return (new $calledClass)->getTable();
    }
}
