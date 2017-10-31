package compatibility.checks

import db.models.components.{ChassisWithRelated, GraphicsCardWithRelated}

class ChassisGraphicsCardCheck extends Check[ChassisWithRelated, GraphicsCardWithRelated] {
  // TODO: check HDD cage
  override def isIncompatible(chassis: ChassisWithRelated, graphicsCard: GraphicsCardWithRelated): Boolean =
    graphicsCard.self.length > chassis.self.maxBlockedGraphicsCardLength
}
