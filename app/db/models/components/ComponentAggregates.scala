package db.models.components

import db.models.properties.{FormFactor, Socket}

final case class Components(
  chassis: Seq[ChassisWithRelated],
  coolingSolutions: Seq[CoolingSolutionWithRelated],
  graphicsCards: Seq[GraphicsCardWithRelated],
  memorySticks: Seq[MemoryStickWithRelated],
  motherboards: Seq[MotherboardWithRelated],
  powerSupplies: Seq[PowerSupplyWithRelated],
  processors: Seq[ProcessorWithRelated],
  storageDevices: Seq[StorageDeviceWithRelated],
) {
  def all: Seq[ComponentWithRelated[_ <: ComponentWithParent]] = Seq(
    chassis,
    coolingSolutions,
    graphicsCards,
    memorySticks,
    motherboards,
    powerSupplies,
    processors,
    storageDevices,
  ).flatten
}

sealed abstract class ComponentWithRelated[T <: ComponentWithParent] (
  val self: T,
  val parent: Component,
)

final case class ChassisWithRelated(
  override val self: Chassis,
  override val parent: Component,
  formFactors: Seq[FormFactor],
) extends ComponentWithRelated(self, parent)

final case class CoolingSolutionWithRelated(
  override val self: CoolingSolution,
  override val parent: Component,
  sockets: Seq[Socket],
) extends ComponentWithRelated(self, parent)

final case class GraphicsCardWithRelated(
  override val self: GraphicsCard,
  override val parent: Component,
) extends ComponentWithRelated(self, parent)

final case class MemoryStickWithRelated(
  override val self: MemoryStick,
  override val parent: Component,
) extends ComponentWithRelated(self, parent)

final case class MotherboardWithRelated(
  override val self: Motherboard,
  override val parent: Component,
  formFactor: FormFactor,
  socket: Socket,
) extends ComponentWithRelated(self, parent)

final case class PowerSupplyWithRelated(
  override val self: PowerSupply,
  override val parent: Component,
) extends ComponentWithRelated(self, parent)

final case class ProcessorWithRelated(
  override val self: Processor,
  override val parent: Component,
  socket: Socket,
) extends ComponentWithRelated(self, parent)

final case class StorageDeviceWithRelated(
  override val self: StorageDevice,
  override val parent: Component,
) extends ComponentWithRelated(self, parent)
