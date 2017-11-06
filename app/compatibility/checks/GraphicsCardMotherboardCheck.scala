package compatibility.checks

import db.models.components.{ComponentWithRelated, GraphicsCard, GraphicsCardWithRelated, MotherboardWithRelated}

// TODO: use injection
object GraphicsCardMotherboardCheck extends Check[GraphicsCardWithRelated, MotherboardWithRelated] {

  override def isIncompatible(graphicsCard: GraphicsCardWithRelated, motherboard: MotherboardWithRelated)(implicit system: System): Boolean =
    system.selected.count(_._1.isInstanceOf[ComponentWithRelated[GraphicsCard]]) == motherboard.self.pcie3Slots

}
