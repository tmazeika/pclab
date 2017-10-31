package compatibility.checks

import db.models.components.ChassisWithRelated

class ChassisChassisCheck extends Check[ChassisWithRelated, ChassisWithRelated] {
  override def isIncompatible(chassis1: ChassisWithRelated, chassis2: ChassisWithRelated): Boolean = true
}
