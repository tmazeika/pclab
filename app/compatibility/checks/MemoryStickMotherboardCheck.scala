package compatibility.checks

import db.models.components.{MemoryStickWithRelated, MotherboardWithRelated}

object MemoryStickMotherboardCheck extends Check[MemoryStickWithRelated, MotherboardWithRelated] {

  // TODO: check memory capacity and count
  override def isIncompatible(memoryStick: MemoryStickWithRelated, motherboard: MotherboardWithRelated)(implicit system: System): Boolean =
    memoryStick.self.generation != motherboard.self.memoryGeneration ||
      memoryStick.self.pins != motherboard.self.memoryPins

}
