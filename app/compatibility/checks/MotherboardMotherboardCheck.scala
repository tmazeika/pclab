package compatibility.checks

import db.models.components.MotherboardWithRelated

class MotherboardMotherboardCheck extends Check[MotherboardWithRelated, MotherboardWithRelated] {
  override def isIncompatible(motherboard1: MotherboardWithRelated, motherboard2: MotherboardWithRelated): Boolean = true
}
