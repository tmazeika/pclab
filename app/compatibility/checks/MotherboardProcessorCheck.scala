package compatibility.checks

import db.models.components.{MotherboardWithRelated, ProcessorWithRelated}

class MotherboardProcessorCheck extends Check[MotherboardWithRelated, ProcessorWithRelated] {
  override def isIncompatible(motherboard: MotherboardWithRelated, processor: ProcessorWithRelated): Boolean =
    motherboard.socket != processor.socket
}
