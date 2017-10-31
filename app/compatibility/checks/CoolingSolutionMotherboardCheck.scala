package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, MotherboardWithRelated}

class CoolingSolutionMotherboardCheck extends Check[CoolingSolutionWithRelated, MotherboardWithRelated] {
  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, motherboard: MotherboardWithRelated): Boolean =
    !(coolingSolution.sockets contains motherboard.socket)
}
