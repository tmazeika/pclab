package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, MemoryStickWithRelated}

object CoolingSolutionMemoryStickCheck extends Check[CoolingSolutionWithRelated, MemoryStickWithRelated] {

  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, memoryStick: MemoryStickWithRelated)(implicit system: System): Boolean =
    memoryStick.self.height > coolingSolution.self.maxMemoryStickHeight

}
