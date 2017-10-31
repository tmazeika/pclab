package compatibility.checks

import db.models.components.ProcessorWithRelated

class ProcessorProcessorCheck extends Check[ProcessorWithRelated, ProcessorWithRelated] {
  override def isIncompatible(processor1: ProcessorWithRelated, processor2: ProcessorWithRelated): Boolean = true
}
