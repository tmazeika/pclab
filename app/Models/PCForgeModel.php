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

    public static function validate(array $data, string $op)
    {
        $ruleSet = $op . '_RULES';
        $validator = Validator::make($data, constant("self::$ruleSet"));

        return $validator->fails() ? $validator->errors() : true;
    }
}
