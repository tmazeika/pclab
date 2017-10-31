package compatibility

import javax.inject.Inject

import compatibility.checks.{ChassisChassisCheck, ChassisCoolingSolutionCheck, ChassisGraphicsCardCheck, ChassisMotherboardCheck, ChassisPowerSupplyCheck, ChassisStorageDeviceCheck, CoolingSolutionCoolingSolutionCheck, CoolingSolutionMemoryStickCheck, CoolingSolutionMotherboardCheck, CoolingSolutionPowerSupplyCheck, CoolingSolutionProcessorCheck, GraphicsCardGraphicsCardCheck, GraphicsCardMotherboardCheck, GraphicsCardPowerSupplyCheck, MemoryStickMemoryStickCheck, MemoryStickMotherboardCheck, MemoryStickPowerSupplyCheck, MotherboardMotherboardCheck, MotherboardPowerSupplyCheck, MotherboardProcessorCheck, MotherboardStorageDeviceCheck, PowerSupplyPowerSupplyCheck, PowerSupplyProcessorCheck, PowerSupplyStorageDeviceCheck, ProcessorProcessorCheck, System}
import db.models.components._
import services.ComponentRepository

import scala.concurrent.{ExecutionContext, Future}
import scalax.collection.GraphEdge.UnDiEdge
import scalax.collection.GraphPredef._
import scalax.collection.mutable.Graph

class CompatibilityService @Inject()(repo: ComponentRepository)(implicit ec: ExecutionContext) {
  type ComponentGraph = Graph[ComponentWithRelated[_], UnDiEdge]

  def getIncompatibilities(selectedIds: Seq[(Int, Int)]): Future[Seq[Int]] = repo.all map { components ⇒
    // TODO: clean up
    val selected = selectedIds.map { t ⇒
      (components.all find (_.parent.id.get == t._1) getOrElse (throw new IllegalArgumentException("Invalid selected ID")), t._2)
    }

    val direct = buildDirect(components, selected)
    val indirect = buildIndirect(components, selected, direct._1, direct._2)

    Seq()
  }

  private def buildDirect(components: Components, selected: Seq[(ComponentWithRelated[_], Int)]): (ComponentGraph, ComponentGraph) = {
    val all = components.all
    val g = Graph().asInstanceOf[ComponentGraph]
    val gComp = g.clone
    // TODO: use injection
    val system = new System(selected)

    for ((c1, i) ← all dropRight 1 zipWithIndex; c2 ← all drop i + 1) {
      // sort the component tuple alphabetically
      val t = if (c1.getClass.getName.compareTo(c2.getClass.getName) < 0) (c1, c2) else (c2, c1)

      // TODO: use injection; no need for such a long pattern match
      if (t match {
        case (a: ChassisWithRelated, b: ChassisWithRelated) ⇒ new ChassisChassisCheck isIncompatible(a, b)
        case (a: ChassisWithRelated, b: CoolingSolutionWithRelated) ⇒ new ChassisCoolingSolutionCheck isIncompatible(a, b)
        case (a: ChassisWithRelated, b: GraphicsCardWithRelated) ⇒ new ChassisGraphicsCardCheck isIncompatible(a, b)
        case (a: ChassisWithRelated, b: MotherboardWithRelated) ⇒ new ChassisMotherboardCheck isIncompatible(a, b)
        case (a: ChassisWithRelated, b: PowerSupplyWithRelated) ⇒ new ChassisPowerSupplyCheck(system) isIncompatible(a, b)
        case (a: ChassisWithRelated, b: StorageDeviceWithRelated) ⇒ new ChassisStorageDeviceCheck(system) isIncompatible(a, b)
        case (a: CoolingSolutionWithRelated, b: CoolingSolutionWithRelated) ⇒ new CoolingSolutionCoolingSolutionCheck isIncompatible(a, b)
        case (a: CoolingSolutionWithRelated, b: MemoryStickWithRelated) ⇒ new CoolingSolutionMemoryStickCheck isIncompatible(a, b)
        case (a: CoolingSolutionWithRelated, b: MotherboardWithRelated) ⇒ new CoolingSolutionMotherboardCheck isIncompatible(a, b)
        case (a: CoolingSolutionWithRelated, b: PowerSupplyWithRelated) ⇒ new CoolingSolutionPowerSupplyCheck(system) isIncompatible(a, b)
        case (a: CoolingSolutionWithRelated, b: ProcessorWithRelated) ⇒ new CoolingSolutionProcessorCheck isIncompatible(a, b)
        case (a: GraphicsCardWithRelated, b: GraphicsCardWithRelated) ⇒ new GraphicsCardGraphicsCardCheck isIncompatible(a, b)
        case (a: GraphicsCardWithRelated, b: MotherboardWithRelated) ⇒ new GraphicsCardMotherboardCheck(system) isIncompatible(a, b)
        case (a: GraphicsCardWithRelated, b: PowerSupplyWithRelated) ⇒ new GraphicsCardPowerSupplyCheck(system) isIncompatible(a, b)
        case (a: MemoryStickWithRelated, b: MemoryStickWithRelated) ⇒ new MemoryStickMemoryStickCheck isIncompatible(a, b)
        case (a: MemoryStickWithRelated, b: MotherboardWithRelated) ⇒ new MemoryStickMotherboardCheck isIncompatible(a, b)
        case (a: MemoryStickWithRelated, b: PowerSupplyWithRelated) ⇒ new MemoryStickPowerSupplyCheck(system) isIncompatible(a, b)
        case (a: MotherboardWithRelated, b: MotherboardWithRelated) ⇒ new MotherboardMotherboardCheck isIncompatible(a, b)
        case (a: MotherboardWithRelated, b: PowerSupplyWithRelated) ⇒ new MotherboardPowerSupplyCheck(system) isIncompatible(a, b)
        case (a: MotherboardWithRelated, b: ProcessorWithRelated) ⇒ new MotherboardProcessorCheck isIncompatible(a, b)
        case (a: MotherboardWithRelated, b: StorageDeviceWithRelated) ⇒ new MotherboardStorageDeviceCheck(system) isIncompatible(a, b)
        case (a: PowerSupplyWithRelated, b: PowerSupplyWithRelated) ⇒ new PowerSupplyPowerSupplyCheck isIncompatible(a, b)
        case (a: PowerSupplyWithRelated, b: ProcessorWithRelated) ⇒ new PowerSupplyProcessorCheck(system) isIncompatible(a, b)
        case (a: PowerSupplyWithRelated, b: StorageDeviceWithRelated) ⇒ new PowerSupplyStorageDeviceCheck(system) isIncompatible(a, b)
        case (a: ProcessorWithRelated, b: ProcessorWithRelated) ⇒ new ProcessorProcessorCheck isIncompatible(a, b)
        case _ ⇒ false
      }) {
        gComp add c1
        gComp add c2
        g add c1 ~ c2
      } else {
        g add c1
        g add c2
        gComp add c1 ~ c2
      }
    }

    (g, gComp)
  }

  private def buildIndirect(components: Components, selected: Seq[(ComponentWithRelated[_], Int)], direct: ComponentGraph, complement: ComponentGraph) = {
    // TODO
  }
}
