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
  chassis: Chassis,
  component: Component,
  formFactors: Seq[FormFactor],
)

case class CoolingSolutionWithRelated(
  coolingSolution: CoolingSolution,
  component: Component,
  sockets: Seq[Socket],
)

case class GraphicsCardWithRelated(
  graphicsCard: GraphicsCard,
  component: Component,
)

case class MemoryStickWithRelated(
  memoryStick: MemoryStick,
  component: Component,
)

case class MotherboardWithRelated(
  motherboard: Motherboard,
  component: Component,
  formFactor: FormFactor,
  socket: Socket,
)

case class PowerSupplyWithRelated(
  powerSupply: PowerSupply,
  component: Component,
)

case class ProcessorWithRelated(
  processor: Processor,
  component: Component,
  socket: Socket,
)

case class StorageDeviceWithRelated(
  storageDevice: StorageDevice,
  component: Component,
)
