package compatibility.checks

import db.models.components.{PowerSupplyWithRelated, StorageDeviceWithRelated}

// TODO: use injection
class PowerSupplyStorageDeviceCheck(system: System) extends Check[PowerSupplyWithRelated, StorageDeviceWithRelated] {
  override def isIncompatible(powerSupply: PowerSupplyWithRelated, storageDevice: StorageDeviceWithRelated): Boolean =
    system notEnoughPower(storageDevice, powerSupply)
}
