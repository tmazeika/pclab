<?php

namespace PCForge\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property Component parent
 */
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
