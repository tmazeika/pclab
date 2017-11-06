package compatibility.checks

import db.models.components._

object MotherboardPowerSupplyCheck extends Check[MotherboardWithRelated, PowerSupplyWithRelated] {

  override def isIncompatible(motherboard: MotherboardWithRelated, powerSupply: PowerSupplyWithRelated)(implicit system: System): Boolean =
    system notEnoughPower(motherboard, powerSupply)

}
