package compatibility.checks

import db.models.components.{PowerSupplyWithRelated, StorageDeviceWithRelated}

object PowerSupplyStorageDeviceCheck extends Check[PowerSupplyWithRelated, StorageDeviceWithRelated] {

  override def isIncompatible(powerSupply: PowerSupplyWithRelated, storageDevice: StorageDeviceWithRelated)(implicit system: System): Boolean =
    system notEnoughPower(storageDevice, powerSupply)

}
