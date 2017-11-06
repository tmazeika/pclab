package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, MotherboardWithRelated}

object CoolingSolutionMotherboardCheck extends Check[CoolingSolutionWithRelated, MotherboardWithRelated] {

  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, motherboard: MotherboardWithRelated)(implicit system: System): Boolean =
    !(coolingSolution.sockets contains motherboard.socket)

}
