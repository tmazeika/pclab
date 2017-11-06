package compatibility.checks

import compatibility.CompatibilityService.Component
import db.models.components.{ComponentWithRelated, PowerSupply}

import scala.math.ceil

class System(implicit val selected: Seq[(Component, Int)]) {

  def notEnoughPower(component: ComponentWithRelated[_], powerSupply: ComponentWithRelated[PowerSupply]): Boolean =
    roundToIncrement(powerUsage + component.parent.powerUsage + System.PowerBuffer, System.PowerIncrement) > powerSupply.self.powerOutput

  def powerUsage: Int = selected map (s ⇒ s._1.parent.powerUsage * s._2) sum

  def roundToIncrement(x: Double, increment: Int): Int = (ceil(x / increment) * increment) toInt

}

object System {

  val PowerBuffer = 150
  val PowerIncrement = 50

}
