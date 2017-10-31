package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, ProcessorWithRelated}

class CoolingSolutionProcessorCheck extends Check[CoolingSolutionWithRelated, ProcessorWithRelated] {
  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, processor: ProcessorWithRelated): Boolean =
    !(coolingSolution.sockets contains processor.socket)
}
