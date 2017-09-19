package db

case class Component(
  id: Option[Int],
  brand: String,
  name: String,
  model: String,

  // market
  isAvailableImmediately: Boolean,
  cost: Int, // pennies

  // power
  powerUsage: Short, // watts

  // physical
  weight: Int, // grams
)

case class Chassis(
  id: Option[Int],
  componentId: Int,

  // cooling
  maxCoolingFanHeight: Short, // millimeters

  // graphics
  maxBlockedGraphicsCardLength: Short, // millimeters
  maxFullGraphicsCardLength: Short, // millimeters

  // motherboard
  audioHeaders: Short,
  fanHeaders: Short,
  usb2Headers: Short,
  usb3Headers: Short,

  // power
  usesSataPower: Boolean,
  maxPowerSupplyLength: Short, // millimeters

  // storage
  smallBays: Short,
  fullBays: Short,
  adaptableBays: Short,
  smallCageBays: Short,
  fullCageBays: Short,
  adaptableCageBays: Short,
)

case class CoolingSolution(
  id: Option[Int],
  componentId: Int,

  tdp: Short, // watts

  // physical
  height: Short, // millimeters
  maxMemoryStickHeight: Short, // millimeters
)

case class GraphicsCard(
  id: Option[Int],
  componentId: Int,
  family: String,

  hasDisplayPort: Boolean,
  hasDvi: Boolean,
  hasHdmi: Boolean,
  hasVga: Boolean,
  supportsSli: Boolean,

  // physical
  length: Short, // millimeters
)

case class MemoryStick(
  id: Option[Int],
  componentId: Int,

  capacity: Int, // megabytes
  generation: Short,
  pins: Short,

  // physical
  height: Short, // millimeters
)

case class Motherboard(
  id: Option[Int],
  componentId: Int,

  formFactorId: Int,

  // graphics
  hasDisplayPort: Boolean,
  hasDvi: Boolean,
  hasHdmi: Boolean,
  hasVga: Boolean,
  pcie3Slots: Short,
  supportsSli: Boolean,

  // headers
  audioHeaders: Short,
  fanHeaders: Short,
  usb2Headers: Short,
  usb3Headers: Short,

  // memory
  maxMemoryCapacity: Int, // megabytes
  memoryGeneration: Short,
  memoryPins: Short,
  memorySlots: Short,

  // power
  cpuPowerPins: Short,
  mainPowerPins: Short,

  // processor
  socketId: Int,

  // storage
  sataSlots: Short,
)

case class PowerSupply(
  id: Option[Int],
  componentId: Int,

  cpuPins: Short,
  modular: Boolean,
  mainPins: Short,
  powerOutput: Short, // watts

  // physical
  length: Short, // millimeters
)

case class StorageDevice(
  id: Option[Int],
  componentId: Int,

  capacity: Int, // megabytes

  // physical
  fullWidth: Boolean,
)
