package db.models.components

import db.models.properties.{FormFactor, Socket}

case class AllComponents(
  chassis: Seq[(Chassis, Component, Seq[FormFactor])],
  coolingSolutions: Seq[(CoolingSolution, Component, Seq[Socket])],
  graphicsCards: Seq[(GraphicsCard, Component)],
  memorySticks: Seq[(MemoryStick, Component)],
  motherboards: Seq[(Motherboard, Component, FormFactor, Socket)],
  powerSupplies: Seq[(PowerSupply, Component)],
  processors: Seq[(Processor, Component, Socket)],
  storageDevices: Seq[(StorageDevice, Component)],
)
