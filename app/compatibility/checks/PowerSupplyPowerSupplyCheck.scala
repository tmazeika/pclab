package compatibility.checks

import db.models.components.PowerSupplyWithRelated

object PowerSupplyPowerSupplyCheck extends Check[PowerSupplyWithRelated, PowerSupplyWithRelated] {

  override def isIncompatible(powerSupply1: PowerSupplyWithRelated, powerSupply2: PowerSupplyWithRelated)(implicit system: System): Boolean = true

}
