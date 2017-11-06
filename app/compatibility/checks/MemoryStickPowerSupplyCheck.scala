package compatibility.checks

import db.models.components._

object MemoryStickPowerSupplyCheck extends Check[MemoryStickWithRelated, PowerSupplyWithRelated] {
  override def isIncompatible(memoryStick: MemoryStickWithRelated, powerSupply: PowerSupplyWithRelated)(implicit system: System): Boolean =
    system notEnoughPower(memoryStick, powerSupply)
}
