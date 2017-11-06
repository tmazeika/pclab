package compatibility.checks

import db.models.components.GraphicsCardWithRelated

object GraphicsCardGraphicsCardCheck extends Check[GraphicsCardWithRelated, GraphicsCardWithRelated] {

  // TODO: *may* need to perform additional checks, especially if SLI is being considered
  override def isIncompatible(graphicsCard1: GraphicsCardWithRelated, graphicsCard2: GraphicsCardWithRelated)(implicit system: System): Boolean = false

}
