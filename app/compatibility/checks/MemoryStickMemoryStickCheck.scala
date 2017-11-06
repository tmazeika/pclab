package compatibility.checks

import db.models.components.MemoryStickWithRelated

object MemoryStickMemoryStickCheck extends Check[MemoryStickWithRelated, MemoryStickWithRelated] {

  override def isIncompatible(memoryStick1: MemoryStickWithRelated, memoryStick2: MemoryStickWithRelated)(implicit system: System): Boolean = true

}
