package compatibility.checks

import db.models.components.PowerSupplyWithRelated

class PowerSupplyPowerSupplyCheck extends Check[PowerSupplyWithRelated, PowerSupplyWithRelated] {
  override def isIncompatible(powerSupply1: PowerSupplyWithRelated, powerSupply2: PowerSupplyWithRelated): Boolean = true
}
