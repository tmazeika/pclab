package compatibility.checks

import db.models.components.{ChassisWithRelated, MotherboardWithRelated}

object ChassisMotherboardCheck extends Check[ChassisWithRelated, MotherboardWithRelated] {

  override def isIncompatible(chassis: ChassisWithRelated, motherboard: MotherboardWithRelated)(implicit system: System): Boolean =
    chassis.self.audioHeaders > motherboard.self.audioHeaders ||
      chassis.self.fanHeaders > motherboard.self.fanHeaders ||
      chassis.self.usb2Headers > motherboard.self.usb2Headers ||
      chassis.self.usb3Headers > motherboard.self.usb3Headers ||
      !(chassis.formFactors contains motherboard.formFactor)

}
