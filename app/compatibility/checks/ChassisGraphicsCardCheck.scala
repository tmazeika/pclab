package compatibility.checks

import db.models.components.{ChassisWithRelated, GraphicsCardWithRelated}

object ChassisGraphicsCardCheck extends Check[ChassisWithRelated, GraphicsCardWithRelated] {

  // TODO: check HDD cage
  override def isIncompatible(chassis: ChassisWithRelated, graphicsCard: GraphicsCardWithRelated)(implicit system: System): Boolean =
    graphicsCard.self.length > chassis.self.maxBlockedGraphicsCardLength

}
