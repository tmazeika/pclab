package db.models.components

case class PowerSupply(
  id: Option[Int],
  componentId: Int,

  cpu4Pins: Short,
  cpu8Pins: Short,
  cpuAdaptable: Short,
  isModular: Boolean,
  length: Short, // millimeters
  main20Pins: Short,
  main24Pins: Short,
  mainAdaptable: Short,
  powerOutput: Short, // watts
)
