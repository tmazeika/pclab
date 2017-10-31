package compatibility.checks

import db.models.components.GraphicsCardWithRelated

class GraphicsCardGraphicsCardCheck extends Check[GraphicsCardWithRelated, GraphicsCardWithRelated] {
  // TODO: *may* need to perform additional checks, especially if SLI is being considered
  override def isIncompatible(graphicsCard1: GraphicsCardWithRelated, graphicsCard2: GraphicsCardWithRelated): Boolean = false
}
