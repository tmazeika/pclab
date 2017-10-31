package compatibility.checks

import db.models.components.{PowerSupplyWithRelated, ProcessorWithRelated}

// TODO: use injection
class PowerSupplyProcessorCheck(system: System) extends Check[PowerSupplyWithRelated, ProcessorWithRelated] {
  override def isIncompatible(powerSupply: PowerSupplyWithRelated, processor: ProcessorWithRelated): Boolean =
    system notEnoughPower(processor, powerSupply)
}
