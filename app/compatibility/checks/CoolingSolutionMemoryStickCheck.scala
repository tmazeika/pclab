package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, MemoryStickWithRelated}

class CoolingSolutionMemoryStickCheck extends Check[CoolingSolutionWithRelated, MemoryStickWithRelated] {
  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, memoryStick: MemoryStickWithRelated): Boolean =
    memoryStick.self.height > coolingSolution.self.maxMemoryStickHeight
}
