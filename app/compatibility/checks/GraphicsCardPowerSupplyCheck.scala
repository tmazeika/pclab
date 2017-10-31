package compatibility.checks

import db.models.components._

// TODO: use injection
class GraphicsCardPowerSupplyCheck(system: System) extends Check[GraphicsCardWithRelated, PowerSupplyWithRelated] {
  override def isIncompatible(graphicsCard: GraphicsCardWithRelated, powerSupply: PowerSupplyWithRelated): Boolean =
    system notEnoughPower(graphicsCard, powerSupply)
}
