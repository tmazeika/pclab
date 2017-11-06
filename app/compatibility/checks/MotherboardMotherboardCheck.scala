package compatibility.checks

import db.models.components.MotherboardWithRelated

object MotherboardMotherboardCheck extends Check[MotherboardWithRelated, MotherboardWithRelated] {

  override def isIncompatible(motherboard1: MotherboardWithRelated, motherboard2: MotherboardWithRelated)(implicit system: System): Boolean = true

}
