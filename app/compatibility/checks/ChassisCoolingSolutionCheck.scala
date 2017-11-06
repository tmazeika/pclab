package compatibility.checks

import db.models.components.{ChassisWithRelated, CoolingSolutionWithRelated}

object ChassisCoolingSolutionCheck extends Check[ChassisWithRelated, CoolingSolutionWithRelated] {

  // TODO: check radiator configurations
  override def isIncompatible(chassis: ChassisWithRelated, coolingSolution: CoolingSolutionWithRelated)(implicit system: System): Boolean =
    coolingSolution.self.height > chassis.self.maxCoolingFanHeight

}
