<?php

namespace PCLab\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Component parent
 */
abstract class ComponentChild extends Model
{
    use HasPresenterTrait;

    /** @var int $selectCount */
    public $selectCount = 0;

    /** @var bool $disabled */
    public $disabled = false;

    public static function featuresView(): string
    {
        return 'partials.lab.' . self::typeName() . '-component';
    }

    /**
     * Gets the type name of this component. E.g. "PCLab\Models\ProcessorComponent" becomes "processor".
     *
     * @return string
     */
    public static function typeName(): string
    {
        return strtolower(substr(class_basename(get_called_class()), 0, -strlen('Component')));
    }

    public final function parent()
    {
        return $this->morphOne(Component::class, 'child');
    }

    public final function type(): ComponentType
    {
        return $this->parent->type;
    }

    public function scopeWithAll(Builder $query): void
    {
        $query->with('parent', 'parent.type');
    }

    // TODO: belongs elsewhere?
    /**
     * Gets an array of component types that are required when this component is in the system. For example, a
     * processor that does not come with a stock cooler would require a cooling component. The component types are the
     * fully qualified class names of the model.
     *
     * @return array
     */
    public function getRequiredComponentTypes(): array
    {
        return [];
    }
}
