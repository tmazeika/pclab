<?php

namespace PCForge\Models;

use Exception;
use Illuminate\Database\Eloquent\Model;
use PCForge\Compatibility\Providers\CompatibilityProvider;

abstract class ComponentChild extends Model
{
    use HasPresenterTrait;

    /** @var int $selectCount */
    public $selectCount = 0;

    public static function featuresView()
    {
        return 'partials.build.' . self::typeName() . '-component';
    }

    public static function typeName()
    {
        // e.g. 'PCForge\Models\ProcessorComponent' -> 'processor'
        return strtolower(substr(class_basename(get_called_class()), 0, -strlen('Component')));
    }

    public function parent()
    {
        return $this->morphOne(Component::class, 'child');
    }
}
