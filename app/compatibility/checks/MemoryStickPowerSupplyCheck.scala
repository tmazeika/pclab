package compatibility.checks

import db.models.components._

// TODO: use injection
class MemoryStickPowerSupplyCheck(system: System) extends Check[MemoryStickWithRelated, PowerSupplyWithRelated] {
  override def isIncompatible(memoryStick: MemoryStickWithRelated, powerSupply: PowerSupplyWithRelated): Boolean =
    system notEnoughPower(memoryStick, powerSupply)
}
