package compatibility.checks

import db.models.components.{ChassisWithRelated, PowerSupplyWithRelated}

// TODO: use injection
class ChassisPowerSupplyCheck(system: System) extends Check[ChassisWithRelated, PowerSupplyWithRelated] {
  override def isIncompatible(chassis: ChassisWithRelated, powerSupply: PowerSupplyWithRelated): Boolean =
    powerSupply.self.length > chassis.self.maxPowerSupplyLength ||
    system.notEnoughPower(chassis, powerSupply)
}
