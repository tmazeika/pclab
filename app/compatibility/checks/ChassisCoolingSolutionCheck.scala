package compatibility.checks

import db.models.components.{ChassisWithRelated, CoolingSolutionWithRelated}

class ChassisCoolingSolutionCheck extends Check[ChassisWithRelated, CoolingSolutionWithRelated] {
  // TODO: check radiator configurations
  override def isIncompatible(chassis: ChassisWithRelated, coolingSolution: CoolingSolutionWithRelated): Boolean =
    coolingSolution.self.height > chassis.self.maxCoolingFanHeight
}
