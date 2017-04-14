<?php

namespace PCForge\Models;

use Illuminate\Support\Collection;

abstract class ComponentChild extends PCForgeModel
{
    public static function featuresView()
    {
        return 'partials.build.' . self::typeName() . '-component';
    }

    public static function typeName()
    {
        // e.g. 'PCForge\Models\ProcessorComponent' -> 'processor'
        return strtolower(substr(class_basename(get_called_class()), 0, -strlen('Component')));
    }

    /**
     * Gets all components that are directly compatible with this component. More specifically, the components that can
     * be reliably deemed compatible with this component while disregarding the presence of other components in the
     * build.
     *
     * @return Collection
     */
    public abstract function getStaticallyCompatibleComponents(): Collection;

    /**
     * Gets all components that are directly incompatible with this component. More specifically, the components that
     * can be reliably deemed incompatible with this component while disregarding the presence of other components in
     * the build.
     *
     * @return Collection
     */
    public abstract function getStaticallyIncompatibleComponents(): Collection;

    /**
     * Gets all components that are compatible with this component based on some other session specific parameters.
     * Similar to getAllDirectlyCompatibleComponents, but this function determines compatibility using parameters that
     * are unique to each session, such as count and presence of other selected components.
     *
     * @param array $selected an association between component ID's and the number of times they were
     * selected
     *
     * @return Collection
     *
     * @see getStaticallyCompatibleComponents
     */
    public abstract function getDynamicallyCompatibleComponents(array $selected): Collection;

    /**
     * Gets all components that are incompatible with this component based on some other session specific parameters.
     * Similar to getAllDirectlyIncompatibleComponents, but this function determines incompatibility using parameters
     * that are unique to each session, such as count and presence of other selected components.
     *
     * @param array $selected an association between component ID's and the number of times they were
     * selected
     *
     * @return Collection
     *
     * @see getStaticallyIncompatibleComponents
     */
    public abstract function getDynamicallyIncompatibleComponents(array $selected): Collection;

    public function parent()
    {
        return $this->belongsTo('PCForge\Models\Component', 'component_id', 'id');
    }
}
