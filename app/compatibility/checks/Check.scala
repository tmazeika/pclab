package compatibility.checks

import compatibility.CompatibilityService.Component

trait Check[A <: Component, B <: Component] {

  /**
    * Gets whether the given components are directly incompatible with each other. The arguments must not be equal.
    *
    * @param component1 the first component
    * @param component2 the second component
    *
    * @return the existence of at least one direct incompatibility
    */
  def isIncompatible(component1: A, component2: B)(implicit system: System): Boolean

}
