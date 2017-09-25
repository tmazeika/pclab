package db.models.components

case class MemoryStick(
  id: Option[Int],
  componentId: Int,

  capacity: Int, // megabytes
  generation: Short,
  height: Short, // millimeters
  pins: Short,
)
