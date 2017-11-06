package compatibility.checks

import db.models.components.{ChassisWithRelated, StorageDeviceWithRelated}

object ChassisStorageDeviceCheck extends Check[ChassisWithRelated, StorageDeviceWithRelated] {

  // TODO: check 2p5, 3p5, and adaptable bay counts
  override def isIncompatible(chassis: ChassisWithRelated, storageDevice: StorageDeviceWithRelated)(implicit system: System): Boolean = false

}
