package compatibility.checks

import db.models.components.{PowerSupplyWithRelated, ProcessorWithRelated}

object PowerSupplyProcessorCheck extends Check[PowerSupplyWithRelated, ProcessorWithRelated] {

  override def isIncompatible(powerSupply: PowerSupplyWithRelated, processor: ProcessorWithRelated)(implicit system: System): Boolean =
    system notEnoughPower(processor, powerSupply)

}
