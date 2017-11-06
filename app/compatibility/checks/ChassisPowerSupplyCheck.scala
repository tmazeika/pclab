package compatibility.checks

import db.models.components.{ChassisWithRelated, PowerSupplyWithRelated}

object ChassisPowerSupplyCheck extends Check[ChassisWithRelated, PowerSupplyWithRelated] {

  override def isIncompatible(chassis: ChassisWithRelated, powerSupply: PowerSupplyWithRelated)(implicit system: System): Boolean =
    powerSupply.self.length > chassis.self.maxPowerSupplyLength ||
    system.notEnoughPower(chassis, powerSupply)

}
