package db.models.components

case class Chassis(
  id: Option[Int],
  componentId: Int,

  adaptableBays: Short,
  adaptableCageBays: Short,
  audioHeaders: Short,
  fanHeaders: Short,
  fullBays: Short,
  fullCageBays: Short,
  maxBlockedGraphicsCardLength: Short, // millimeters
  maxCoolingFanHeight: Short, // millimeters
  maxFullGraphicsCardLength: Short, // millimeters
  maxPowerSupplyLength: Short, // millimeters
  smallBays: Short,
  smallCageBays: Short,
  usb2Headers: Short,
  usb3Headers: Short,
  usesSataPower: Boolean,
)
