package compatibility.checks

import db.models.components.ProcessorWithRelated

object ProcessorProcessorCheck extends Check[ProcessorWithRelated, ProcessorWithRelated] {

  override def isIncompatible(processor1: ProcessorWithRelated, processor2: ProcessorWithRelated)(implicit system: System): Boolean = true

}
