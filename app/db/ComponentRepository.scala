package db

import db.models.components._
import db.models.pivots._
import db.models.properties._
import slick.jdbc.PostgresProfile.api._

object ComponentRepository {
  trait EnumValue[M] extends Table[M] {
    def id = column[Int]("id", O.PrimaryKey, O.AutoInc)

    def name = column[String]("name")
  }

  /*
  Properties
   */

  class FormFactorTable(tag: Tag) extends Table[FormFactor](tag, "form_factors") with EnumValue[FormFactor] {
    override def * = (
      id.?,
      name,
    ) <> (FormFactor.tupled, FormFactor.unapply)
  }

  val formFactors = TableQuery[FormFactorTable]

  class SocketTable(tag: Tag) extends Table[Socket](tag, "sockets") with EnumValue[Socket] {
    override def * = (
      id.?,
      name,
    ) <> (Socket.tupled, Socket.unapply)
  }

  val sockets = TableQuery[SocketTable]

  /*
  Components
   */

  class ComponentTable(tag: Tag) extends Table[Component](tag, "components") {
    def id = column[Int]("id", O.PrimaryKey, O.AutoInc)

    def brand = column[String]("brand")
    def cost = column[Int]("cost")
    def isAvailableImmediately = column[Boolean]("is_available_immediately")
    def model = column[String]("model")
    def name = column[String]("name")
    def powerCost = column[Short]("power_cost")
    def weight = column[Int]("weight")

    override def * = (
      id.?,
      brand,
      cost,
      isAvailableImmediately,
      model.?,
      name,
      powerCost,
      weight,
    ) <> (Component.tupled, Component.unapply)
  }

  val components = TableQuery[ComponentTable]

  trait BelongsToComponentsTable[M] extends Table[M] {
    def id = column[Int]("id", O.PrimaryKey, O.AutoInc)

    def componentId = column[Int]("component_id", O.Unique)
    def component = foreignKey("component_fk", componentId, components)(_.id, onDelete = ForeignKeyAction.Cascade)
  }

  class ChassisTable(tag: Tag) extends Table[Chassis](tag, "chassis") with BelongsToComponentsTable[Chassis] {
    def adaptableBays = column[Short]("adaptable_bays")
    def adaptableCageBays = column[Short]("adaptable_cage_bays")
    def audioHeaders = column[Short]("audio_headers")
    def fanHeaders = column[Short]("fan_headers")
    def fullBays = column[Short]("full_bays")
    def fullCageBays = column[Short]("full_cage_bays")
    def maxBlockedGraphicsCardLength = column[Short]("max_blocked_graphics_card_length")
    def maxCoolingFanHeight = column[Short]("max_cooling_fan_height")
    def maxFullGraphicsCardLength = column[Short]("max_full_graphics_card_length")
    def maxPowerSupplyLength = column[Short]("max_power_supply_length")
    def smallBays = column[Short]("small_bays")
    def smallCageBays = column[Short]("small_cage_bays")
    def usb2Headers = column[Short]("usb2_headers")
    def usb3Headers = column[Short]("usb3_headers")
    def usesSataPower = column[Boolean]("uses_sata_power")

    override def * = (
      id.?,
      componentId,
      adaptableBays,
      adaptableCageBays,
      audioHeaders,
      fanHeaders,
      fullBays,
      fullCageBays,
      maxBlockedGraphicsCardLength,
      maxCoolingFanHeight,
      maxFullGraphicsCardLength,
      maxPowerSupplyLength,
      smallBays,
      smallCageBays,
      usb2Headers,
      usb3Headers,
      usesSataPower,
    ) <> (Chassis.tupled, Chassis.unapply)
  }

  val chassis = TableQuery[ChassisTable]

  class CoolingSolutionTable(tag: Tag) extends Table[CoolingSolution](tag, "cooling_solutions") with BelongsToComponentsTable[CoolingSolution] {
    def height = column[Short]("height")
    def maxMemoryStickHeight = column[Short]("max_memory_stick_height")
    def tdp = column[Short]("tdp")

    override def * = (
      id.?,
      componentId,
      height,
      maxMemoryStickHeight,
      tdp,
    ) <> (CoolingSolution.tupled, CoolingSolution.unapply)
  }

  val coolingSolutions = TableQuery[CoolingSolutionTable]

  class GraphicsCardTable(tag: Tag) extends Table[GraphicsCard](tag, "graphics_cards") with BelongsToComponentsTable[GraphicsCard] {
    def family = column[String]("family")
    def hasDisplayPort = column[Boolean]("has_display_port")
    def hasDvi = column[Boolean]("has_dvi")
    def hasHdmi = column[Boolean]("has_hdmi")
    def hasVga = column[Boolean]("has_vga")
    def length = column[Short]("length")
    def supportsSli = column[Boolean]("supports_sli")

    override def * = (
      id.?,
      componentId,
      family,
      hasDisplayPort,
      hasDvi,
      hasHdmi,
      hasVga,
      length,
      supportsSli,
    ) <> (GraphicsCard.tupled, GraphicsCard.unapply)
  }

  val graphicsCards = TableQuery[GraphicsCardTable]

  class MemoryStickTable(tag: Tag) extends Table[MemoryStick](tag, "memory_sticks") with BelongsToComponentsTable[MemoryStick] {
    def capacity = column[Int]("capacity")
    def generation = column[Short]("generation")
    def height = column[Short]("height")
    def pins = column[Short]("pins")

    override def * = (
      id.?,
      componentId,
      capacity,
      generation,
      height,
      pins,
    ) <> (MemoryStick.tupled, MemoryStick.unapply)
  }

  val memorySticks = TableQuery[MemoryStickTable]

  class MotherboardTable(tag: Tag) extends Table[Motherboard](tag, "motherboards") with BelongsToComponentsTable[Motherboard] {
    def audioHeaders = column[Short]("audio_headers")
    def cpuPower4Pins = column[Short]("cpu_power_4pins")
    def cpuPower8Pins = column[Short]("cpu_power_8pins")
    def fanHeaders = column[Short]("fan_headers")

    def formFactorId = column[Int]("form_factor_id")
    def formFactor = foreignKey("form_factor_fk", formFactorId, formFactors)(_.id, onDelete = ForeignKeyAction.Restrict)

    def hasDisplayPort = column[Boolean]("has_displayport")
    def hasDvi = column[Boolean]("has_dvi")
    def hasHdmi = column[Boolean]("has_hdmi")
    def hasVga = column[Boolean]("has_vga")
    def mainPowerPins = column[Short]("main_power_pins")
    def maxMemoryCapacity = column[Int]("max_memory_capacity")
    def memoryGeneration = column[Short]("memory_generation")
    def memoryPins = column[Short]("memory_pins")
    def memorySlots = column[Short]("memory_slots")
    def pcie3Slots = column[Short]("pcie3_slots")
    def sataSlots = column[Short]("sata_slots")

    def socketId = column[Int]("socket_id")
    def socket = foreignKey("socket_fk", socketId, sockets)(_.id, onDelete = ForeignKeyAction.Restrict)

    def supportsSli = column[Boolean]("supports_sli")
    def usb2Headers = column[Short]("usb2_headers")
    def usb3Headers = column[Short]("usb3_headers")

    override def * = (
      id.?,
      componentId,
      audioHeaders,
      cpuPower4Pins,
      cpuPower8Pins,
      fanHeaders,
      formFactorId,
      hasDisplayPort,
      hasDvi,
      hasHdmi,
      hasVga,
      mainPowerPins,
      maxMemoryCapacity,
      memoryGeneration,
      memoryPins,
      memorySlots,
      pcie3Slots,
      sataSlots,
      socketId,
      supportsSli,
      usb2Headers,
      usb3Headers,
    ) <> (Motherboard.tupled, Motherboard.unapply)
  }

  val motherboards = TableQuery[MotherboardTable]

  class PowerSupplyTable(tag: Tag) extends Table[PowerSupply](tag, "power_supplies") with BelongsToComponentsTable[PowerSupply] {
    def cpu4Pins = column[Short]("cpu_4pins")
    def cpu8Pins = column[Short]("cpu_8pins")
    def cpuAdaptable = column[Short]("cpu_adaptable")
    def isModular = column[Boolean]("is_modular")
    def length = column[Short]("length")
    def main20Pins = column[Short]("main_20pins")
    def main24Pins = column[Short]("main_24pins")
    def mainAdaptable = column[Short]("main_adaptable")
    def powerOutput = column[Short]("power_output")

    override def * = (
      id.?,
      componentId,
      cpu4Pins,
      cpu8Pins,
      cpuAdaptable,
      isModular,
      length,
      main20Pins,
      main24Pins,
      mainAdaptable,
      powerOutput,
    ) <> (PowerSupply.tupled, PowerSupply.unapply)
  }

  val powerSupplies = TableQuery[PowerSupplyTable]

  class ProcessorTable(tag: Tag) extends Table[Processor](tag, "processors") with BelongsToComponentsTable[Processor] {
    def hasGpu = column[Boolean]("has_gpu")

    def socketId = column[Int]("socket_id")
    def socket = foreignKey("socket_fk", socketId, sockets)(_.id, onDelete = ForeignKeyAction.Restrict)

    override def * = (
      id.?,
      componentId,
      hasGpu,
      socketId,
    ) <> (Processor.tupled, Processor.unapply)
  }

  val processors = TableQuery[ProcessorTable]

  class StorageDeviceTable(tag: Tag) extends Table[StorageDevice](tag, "storage_devices") with BelongsToComponentsTable[StorageDevice] {
    def capacity = column[Int]("capacity")
    def isFullWidth = column[Boolean]("is_full_width")

    override def * = (
      id.?,
      componentId,
      capacity,
      isFullWidth,
    ) <> (StorageDevice.tupled, StorageDevice.unapply)
  }

  val storageDevices = TableQuery[StorageDeviceTable]

  /*
  Pivots
   */

  class ChassisFormFactorTable(tag: Tag) extends Table[ChassisFormFactor](tag, "chassis_form_factor") {
    def id = column[Int]("id", O.PrimaryKey, O.AutoInc)

    def chassisId = column[Int]("chassis_id")
    def chassis = foreignKey("chassis_fk", chassisId, ComponentRepository.chassis)(_.id, onDelete = ForeignKeyAction.Cascade)

    def formFactorId = column[Int]("form_factor_id")
    def formFactor = foreignKey("form_factor_fk", formFactorId, formFactors)(_.id, onDelete = ForeignKeyAction.Restrict)

    override def * = (
      id.?,
      chassisId,
      formFactorId,
    ) <> (ChassisFormFactor.tupled, ChassisFormFactor.unapply)
  }

  val chassisFormFactor = TableQuery[ChassisFormFactorTable]

  class CoolingSolutionSocketTable(tag: Tag) extends Table[CoolingSolutionSocket](tag, "cooling_solution_socket") {
    def id = column[Int]("id", O.PrimaryKey, O.AutoInc)

    def coolingSolutionId = column[Int]("cooling_solution_id")
    def coolingSolution = foreignKey("cooling_solution_fk", coolingSolutionId, coolingSolutions)(_.id, onDelete = ForeignKeyAction.Cascade)

    def socketId = column[Int]("socket_id")
    def socket = foreignKey("socket_fk", socketId, sockets)(_.id, onDelete = ForeignKeyAction.Restrict)

    override def * = (
      id.?,
      coolingSolutionId,
      socketId,
    ) <> (CoolingSolutionSocket.tupled, CoolingSolutionSocket.unapply)
  }

  val coolingSolutionFormFactor = TableQuery[CoolingSolutionSocketTable]
}
