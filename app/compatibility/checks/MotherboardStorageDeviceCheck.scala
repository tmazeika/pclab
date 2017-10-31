package compatibility.checks

import db.models.components.{MotherboardWithRelated, StorageDeviceWithRelated}

// TODO: use injection
class MotherboardStorageDeviceCheck(system: System) extends Check[MotherboardWithRelated, StorageDeviceWithRelated] {
  // TODO: check SATA slots
  override def isIncompatible(motherboard: MotherboardWithRelated, storageDevice: StorageDeviceWithRelated): Boolean = false
}
