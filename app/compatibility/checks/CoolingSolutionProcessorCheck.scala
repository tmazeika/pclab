package compatibility.checks

import db.models.components.{CoolingSolutionWithRelated, ProcessorWithRelated}

object CoolingSolutionProcessorCheck extends Check[CoolingSolutionWithRelated, ProcessorWithRelated] {

  override def isIncompatible(coolingSolution: CoolingSolutionWithRelated, processor: ProcessorWithRelated)(implicit system: System): Boolean =
    !(coolingSolution.sockets contains processor.socket)

}
