package compatibility.checks

import db.models.components.CoolingSolutionWithRelated

class CoolingSolutionCoolingSolutionCheck extends Check[CoolingSolutionWithRelated, CoolingSolutionWithRelated] {
  override def isIncompatible(coolingSolution1: CoolingSolutionWithRelated, coolingSolution2: CoolingSolutionWithRelated): Boolean = true
}
