package compatibility.checks

import db.models.components.CoolingSolutionWithRelated

object CoolingSolutionCoolingSolutionCheck extends Check[CoolingSolutionWithRelated, CoolingSolutionWithRelated] {

  override def isIncompatible(coolingSolution1: CoolingSolutionWithRelated, coolingSolution2: CoolingSolutionWithRelated)(implicit system: System): Boolean = true

}
