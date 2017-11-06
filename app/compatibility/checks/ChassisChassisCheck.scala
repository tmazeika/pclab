package compatibility.checks

import db.models.components.ChassisWithRelated

object ChassisChassisCheck extends Check[ChassisWithRelated, ChassisWithRelated] {

  override def isIncompatible(chassis1: ChassisWithRelated, chassis2: ChassisWithRelated)(implicit system: System): Boolean = true

}
