<?php

namespace PCForge;

use Illuminate\Support\Facades\Validator;

trait Validatable
{
    private $errors;

    public function validate(array $data, string $op)
    {
        $ruleSet = $op . 'Rules';
        $validator = Validator::make($data, $this->$ruleSet);

        if ($validator->fails()) {
            $this->errors = $validator->errors();

            return false;
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }
}
