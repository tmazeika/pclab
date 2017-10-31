package compatibility.checks

import db.models.components._

// TODO: use injection
class MotherboardPowerSupplyCheck(system: System) extends Check[MotherboardWithRelated, PowerSupplyWithRelated] {
  override def isIncompatible(motherboard: MotherboardWithRelated, powerSupply: PowerSupplyWithRelated): Boolean =
    system notEnoughPower(motherboard, powerSupply)
}
