package db

import slick.jdbc.PostgresProfile.api._

object ComponentRepository {
  class ComponentsTable(tag: Tag) extends Table[Component](tag, "components") {
    def id = column[Int]("id", O.PrimaryKey, O.AutoInc)
    def brand = column[String]("brand")
    def name = column[String]("name")
    def model = column[String]("model")

    // market
    def isAvailableImmediately = column[Boolean]("is_available_immediately")
    def cost = column[Int]("cost")

    // power
    def powerCost = column[Short]("power_cost")

    // physical
    def weight = column[Int]("weight")

    override def * = (
      id.?,
      brand,
      name,
      model,
      isAvailableImmediately,
      cost,
      powerCost,
      weight,
    ) <> (Component.tupled, Component.unapply)
  }

  val componentsTable = TableQuery[ComponentsTable]

  trait BelongsToComponentsTable[M] extends Table[M] {
    def id = column[Int]("id", O.PrimaryKey, O.AutoInc)
    def componentId = column[Int]("component_id", O.Unique)
    def component = foreignKey("component_fk", componentId, componentsTable)(_.id, onDelete = ForeignKeyAction.Cascade)
  }

  class ChassisTable(tag: Tag) extends Table[Chassis](tag, "chassis") with BelongsToComponentsTable[Chassis] {
    // cooling
    def maxCoolingFanHeight = column[Short]("max_cooling_fan_height")

    // graphics
    def maxBlockedGraphicsCardLength = column[Short]("max_blocked_graphics_card_length")
    def maxFullGraphicsCardLength = column[Short]("max_full_graphics_card_length")

    // motherboard
    def audioHeaders = column[Short]("audio_headers")
    def fanHeaders = column[Short]("fan_headers")
    def usb2Headers = column[Short]("usb2_headers")
    def usb3Headers = column[Short]("usb3_headers")

    // power
    def usesSataPower = column[Boolean]("uses_sata_power")
    def maxPowerSupplyLength = column[Short]("max_power_supply_length")

    // storage
    def smallBays = column[Short]("small_bays")
    def fullBays = column[Short]("full_bays")
    def adaptableBays = column[Short]("adaptable_bays")
    def smallCageBays = column[Short]("small_cage_bays")
    def fullCageBays = column[Short]("full_cage_bays")
    def adaptableCageBays = column[Short]("adaptable_cage_bays")

    override def * = (
      id.?,
      componentId,
      maxCoolingFanHeight,
      maxBlockedGraphicsCardLength,
      maxFullGraphicsCardLength,
      audioHeaders,
      fanHeaders,
      usb2Headers,
      usb3Headers,
      usesSataPower,
      maxPowerSupplyLength,
      smallBays,
      fullBays,
      adaptableBays,
      smallCageBays,
      fullCageBays,
      adaptableCageBays,
    ) <> (Chassis.tupled, Chassis.unapply)
  }

  class CoolingSolutionsTable(tag: Tag) extends Table[CoolingSolution](tag, "cooling_solutions") with BelongsToComponentsTable[CoolingSolution] {
    def tdp = column[Short]("tdp")

    // physical
    def height = column[Short]("height")
    def maxMemoryStickHeight = column[Short]("max_memory_stick_height")

    override def * = (
      id.?,
      componentId,
      tdp,
      height,
      maxMemoryStickHeight,
    ) <> (CoolingSolution.tupled, CoolingSolution.unapply)
  }

  class GraphicsCardsTable(tag: Tag) extends Table[GraphicsCard](tag, "graphics_cards") with BelongsToComponentsTable[GraphicsCard] {
    def family = column[String]("family")

    def hasDisplayPort = column[Boolean]("has_display_port")
    def hasDvi = column[Boolean]("has_dvi")
    def hasHdmi = column[Boolean]("has_hdmi")
    def hasVga = column[Boolean]("has_vga")
    def supportsSli = column[Boolean]("supports_sli")

    // physical
    def length = column[Short]("length")

    override def * = (
      id.?,
      componentId,
      family,
      hasDisplayPort,
      hasDvi,
      hasHdmi,
      hasVga,
      supportsSli,
      length,
    ) <> (GraphicsCard.tupled, GraphicsCard.unapply)
  }

  class MemorySticksTable(tag: Tag) extends Table[MemoryStick](tag, "memory_sticks") with BelongsToComponentsTable[MemoryStick] {
    def capacity = column[Int]("capacity")
    def generation = column[Short]("generation")
    def pins = column[Short]("pins")

    // physical
    def height = column[Short]("height")

    override def * = (
      id.?,
      componentId,
      capacity,
      generation,
      pins,
      height,
    ) <> (MemoryStick.tupled, MemoryStick.unapply)
  }
}
