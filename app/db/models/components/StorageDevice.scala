package db.models.components

case class StorageDevice(
  id: Option[Int],
  componentId: Int,

  capacity: Int, // megabytes
  isFullWidth: Boolean,
)
