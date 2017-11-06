package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, PowerSupplyWithRelated}

object CoolingSolutionPowerSupplyCheck extends Check[CoolingSolutionWithRelated, PowerSupplyWithRelated] {

  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, powerSupply: PowerSupplyWithRelated)(implicit system: System): Boolean =
    system notEnoughPower(coolingSolution, powerSupply)

}
