<?php

namespace PCForge\Models;

use Illuminate\Support\Facades\Validator;

trait Validatable
{
    private $errors;

    public static function validate(array $data, string $op)
    {
        $ruleSet = $op . '_RULES';
        $validator = Validator::make($data, constant("self::$ruleSet"));

        if ($validator->fails()) {
            return $validator->errors();
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}
