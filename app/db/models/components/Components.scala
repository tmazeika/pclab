package db.models.components

final case class Component(
  id: Option[Int],

  brand: String,
  cost: Int, // pennies
  isAvailableImmediately: Boolean,
  model: Option[String],
  name: String,
  powerUsage: Short, // watts
  previewImgHash: String, // sha1
  weight: Int, // grams
)

sealed abstract class ComponentWithParent(
  val id: Option[Int],
  val componentId: Int,
)

final case class Chassis(
  override val id: Option[Int],
  override val componentId: Int,

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
) extends ComponentWithParent(id, componentId)

final case class CoolingSolution(
  override val id: Option[Int],
  override val componentId: Int,

  height: Short, // millimeters
  maxMemoryStickHeight: Short, // millimeters
  tdp: Short, // watts
) extends ComponentWithParent(id, componentId)

final case class GraphicsCard(
  override val id: Option[Int],
  override val componentId: Int,

  family: String,
  hasDisplayport: Boolean,
  hasDvi: Boolean,
  hasHdmi: Boolean,
  hasVga: Boolean,
  length: Short, // millimeters
  supportsSli: Boolean,
) extends ComponentWithParent(id, componentId)

final case class MemoryStick(
  override val id: Option[Int],
  override val componentId: Int,

  capacity: Int, // megabytes
  generation: Short,
  height: Short, // millimeters
  pins: Short,
) extends ComponentWithParent(id, componentId)

final case class Motherboard(
  override val id: Option[Int],
  override val componentId: Int,

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
) extends ComponentWithParent(id, componentId)

final case class PowerSupply(
  override val id: Option[Int],
  override val componentId: Int,

  cpu4Pins: Short,
  cpu8Pins: Short,
  cpuAdaptable: Short,
  isModular: Boolean,
  length: Short, // millimeters
  main20Pins: Short,
  main24Pins: Short,
  mainAdaptable: Short,
  powerOutput: Short, // watts
) extends ComponentWithParent(id, componentId)

final case class Processor(
  override val id: Option[Int],
  override val componentId: Int,

  hasGpu: Boolean,
  socketId: Int,
) extends ComponentWithParent(id, componentId)

case class StorageDevice(
  override val id: Option[Int],
  override val componentId: Int,

  capacity: Int, // megabytes
  isFullWidth: Boolean,
) extends ComponentWithParent(id, componentId)

