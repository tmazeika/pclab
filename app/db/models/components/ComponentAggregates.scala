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

sealed abstract class ComponentWithRelated[T] (
  self: T,
  parent: Component,
)

final case class ChassisWithRelated(
  self: Chassis,
  parent: Component,
  formFactors: Seq[FormFactor],
) extends ComponentWithRelated(self, parent)

final case class CoolingSolutionWithRelated(
  self: CoolingSolution,
  parent: Component,
  sockets: Seq[Socket],
) extends ComponentWithRelated(self, parent)

final case class GraphicsCardWithRelated(
  self: GraphicsCard,
  parent: Component,
) extends ComponentWithRelated(self, parent)

final case class MemoryStickWithRelated(
  self: MemoryStick,
  parent: Component,
) extends ComponentWithRelated(self, parent)

final case class MotherboardWithRelated(
  self: Motherboard,
  parent: Component,
  formFactor: FormFactor,
  socket: Socket,
) extends ComponentWithRelated(self, parent)

final case class PowerSupplyWithRelated(
  self: PowerSupply,
  parent: Component,
) extends ComponentWithRelated(self, parent)

final case class ProcessorWithRelated(
  self: Processor,
  parent: Component,
  socket: Socket,
) extends ComponentWithRelated(self, parent)

final case class StorageDeviceWithRelated(
  self: StorageDevice,
  parent: Component,
) extends ComponentWithRelated(self, parent)
