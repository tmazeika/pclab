package compatibility.checks

import db.models.components._

object GraphicsCardPowerSupplyCheck extends Check[GraphicsCardWithRelated, PowerSupplyWithRelated] {

  override def isIncompatible(graphicsCard: GraphicsCardWithRelated, powerSupply: PowerSupplyWithRelated)(implicit system: System): Boolean =
    system notEnoughPower(graphicsCard, powerSupply)

}
