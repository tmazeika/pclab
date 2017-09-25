package db.models.components

case class Motherboard(
  id: Option[Int],
  componentId: Int,

  audioHeaders: Short,
  cpuPower4Pins: Short,
  cpuPower8Pins: Short,
  fanHeaders: Short,
  formFactorId: Int,
  hasDisplayport: Boolean,
  hasDvi: Boolean,
  hasHdmi: Boolean,
  hasVga: Boolean,
  mainPowerPins: Short,
  maxMemoryCapacity: Int, // megabytes
  memoryGeneration: Short,
  memoryPins: Short,
  memorySlots: Short,
  pcie3Slots: Short,
  sataSlots: Short,
  socketId: Int,
  supportsSli: Boolean,
  usb2Headers: Short,
  usb3Headers: Short,
)
