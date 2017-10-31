package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, PowerSupplyWithRelated}

// TODO: use injection
class CoolingSolutionPowerSupplyCheck(system: System) extends Check[CoolingSolutionWithRelated, PowerSupplyWithRelated] {
  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, powerSupply: PowerSupplyWithRelated): Boolean =
    system notEnoughPower(coolingSolution, powerSupply)
}
