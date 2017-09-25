package db.models.components

import db.models.properties.{FormFactor, Socket}

case class AllComponents(
  chassis: Seq[ChassisWithRelated],
  coolingSolutions: Seq[CoolingSolutionWithRelated],
  graphicsCards: Seq[GraphicsCardWithRelated],
  memorySticks: Seq[MemoryStickWithRelated],
  motherboards: Seq[MotherboardWithRelated],
  powerSupplies: Seq[PowerSupplyWithRelated],
  processors: Seq[ProcessorWithRelated],
  storageDevices: Seq[StorageDeviceWithRelated],
)

case class ChassisWithRelated(
  self: Chassis,
  parent: Component,
  formFactors: Seq[FormFactor],
)

case class CoolingSolutionWithRelated(
  self: CoolingSolution,
  parent: Component,
  sockets: Seq[Socket],
)

case class GraphicsCardWithRelated(
  self: GraphicsCard,
  parent: Component,
)

case class MemoryStickWithRelated(
  self: MemoryStick,
  parent: Component,
)

case class MotherboardWithRelated(
  self: Motherboard,
  parent: Component,
  formFactor: FormFactor,
  socket: Socket,
)

case class PowerSupplyWithRelated(
  self: PowerSupply,
  parent: Component,
)

case class ProcessorWithRelated(
  self: Processor,
  parent: Component,
  socket: Socket,
)

case class StorageDeviceWithRelated(
  self: StorageDevice,
  parent: Component,
)
