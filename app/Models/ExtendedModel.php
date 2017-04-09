<?php

namespace PCForge\Models;

trait ExtendedModel
{
    public static function tableName()
    {
        $calledClass = get_called_class();

        return (new $calledClass)->getTable();
    }
}
