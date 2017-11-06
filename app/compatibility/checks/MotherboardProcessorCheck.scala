package compatibility.checks

import db.models.components.{MotherboardWithRelated, ProcessorWithRelated}

object MotherboardProcessorCheck extends Check[MotherboardWithRelated, ProcessorWithRelated] {

  override def isIncompatible(motherboard: MotherboardWithRelated, processor: ProcessorWithRelated)(implicit system: System): Boolean =
    motherboard.socket != processor.socket

}
