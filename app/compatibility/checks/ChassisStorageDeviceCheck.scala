package compatibility.checks

import db.models.components.{ChassisWithRelated, StorageDeviceWithRelated}

// TODO: use injection
class ChassisStorageDeviceCheck(system: System) extends Check[ChassisWithRelated, StorageDeviceWithRelated] {
  // TODO: check 2p5, 3p5, and adaptable bay counts
  override def isIncompatible(chassis: ChassisWithRelated, storageDevice: StorageDeviceWithRelated): Boolean = false
}
