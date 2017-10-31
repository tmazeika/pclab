package compatibility.checks

import db.models.components.MemoryStickWithRelated

class MemoryStickMemoryStickCheck extends Check[MemoryStickWithRelated, MemoryStickWithRelated] {
  override def isIncompatible(memoryStick1: MemoryStickWithRelated, memoryStick2: MemoryStickWithRelated): Boolean = true
}
