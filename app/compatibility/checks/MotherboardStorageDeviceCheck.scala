package compatibility.checks

import db.models.components.{MotherboardWithRelated, StorageDeviceWithRelated}

object MotherboardStorageDeviceCheck extends Check[MotherboardWithRelated, StorageDeviceWithRelated] {

  // TODO: check SATA slots
  override def isIncompatible(motherboard: MotherboardWithRelated, storageDevice: StorageDeviceWithRelated)(implicit system: System): Boolean = false

}
