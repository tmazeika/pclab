package db

/*
Common
 */

case class FormFactor(
  id: Option[Int],

  name: String,
)

case class Socket(
  id: Option[Int],

  name: String,
)

/*
Pivots
 */

case class ChassisFormFactor(
  id: Option[Int],

  chassisId: Int,
  formFactorId: Int,
)

case class CoolingSolutionFormFactor(
  id: Option[Int],

  coolingSolutionId: Int,
  socketId: Int,
)

/*
Components
 */

case class Component(
  id: Option[Int],

  brand: String,
  cost: Int, // pennies
  isAvailableImmediately: Boolean,
  model: String,
  name: String,
  powerUsage: Short, // watts
  weight: Int, // grams
)

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

case class CoolingSolution(
  id: Option[Int],
  componentId: Int,

  height: Short, // millimeters
  maxMemoryStickHeight: Short, // millimeters
  tdp: Short, // watts
)

case class GraphicsCard(
  id: Option[Int],
  componentId: Int,

  family: String,
  hasDisplayPort: Boolean,
  hasDvi: Boolean,
  hasHdmi: Boolean,
  hasVga: Boolean,
  length: Short, // millimeters
  supportsSli: Boolean,
)

case class MemoryStick(
  id: Option[Int],
  componentId: Int,

  capacity: Int, // megabytes
  generation: Short,
  height: Short, // millimeters
  pins: Short,
)

case class Motherboard(
  id: Option[Int],
  componentId: Int,

  audioHeaders: Short,
  cpuPower4Pins: Short,
  cpuPower8Pins: Short,
  fanHeaders: Short,
  formFactorId: Int,
  hasDisplayPort: Boolean,
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

case class Processor(
  id: Option[Int],
  componentId: Int,

  hasApu: Boolean,
  socketId: Int,
)

case class StorageDevice(
  id: Option[Int],
  componentId: Int,

  capacity: Int, // megabytes
  isFullWidth: Boolean,
)
