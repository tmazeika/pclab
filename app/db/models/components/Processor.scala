package db.models.components

case class Processor(
  id: Option[Int],
  componentId: Int,

  hasGpu: Boolean,
  socketId: Int,
)
