package compatibility

import javax.inject.Inject

import com.google.inject.Injector
import compatibility.CompatibilityService.{Component, ComponentGraph}
import compatibility.checks._
import db.models.components._
import services.ComponentRepository

import scala.concurrent.{ExecutionContext, Future}
import scala.util.Try
import scalax.collection.GraphEdge.UnDiEdge
import scalax.collection.GraphPredef._
import scalax.collection.mutable.Graph

class CompatibilityService @Inject()(repo: ComponentRepository, injector: Injector)(implicit ec: ExecutionContext) {

  def getIncompatibilities(selectedIds: Seq[(Int, Int)]): Future[Try[Seq[Int]]] = repo.all map { components ⇒
    selectedIdsToComponents(selectedIds, components) map { implicit selected ⇒
      implicit val system: System = new System
      val (direct, directComp) = buildDirect(components)
      val indirect = buildIndirect(components, direct, directComp)

      // TODO
      Seq(1, 3, 5)
    }
  }

  private def selectedIdsToComponents(selectedIds: Seq[(Int, Int)], components: Components): Try[Seq[(Component, Int)]] = Try {
    selectedIds map { t ⇒
      (components.all find (_.parent.id.get == t._1) getOrElse (throw new IllegalArgumentException("Invalid selected ID")), t._2)
    }
  }

  private def buildDirect(components: Components)(implicit selected: Seq[(Component, Int)], system: System): (ComponentGraph, ComponentGraph) = {
    val g = Graph().asInstanceOf[ComponentGraph]
    val gComp = g.clone

    components.all combinations 2 foreach {
      case Seq(c1, c2) ⇒
        if (isIncompatible(c1, c2)) {
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

  private def isIncompatible[A <: Component, B <: Component](c1: A, c2: B)(implicit system: System) = {
    val t = if (c1.getClass.getName.compareTo(c2.getClass.getName) < 0) (c1.self, c2.self) else (c2.self, c1.self)

    // TODO: this sucks
    t match {
      case (c1: ChassisWithRelated, c2: ChassisWithRelated) ⇒ ChassisChassisCheck isIncompatible(c1, c2)
      case (c1: ChassisWithRelated, c2: ChassisWithRelated) ⇒ ChassisChassisCheck isIncompatible(c1, c2)
      case (c1: ChassisWithRelated, c2: CoolingSolutionWithRelated) ⇒ ChassisCoolingSolutionCheck isIncompatible(c1, c2)
      case (c1: ChassisWithRelated, c2: GraphicsCardWithRelated) ⇒ ChassisGraphicsCardCheck isIncompatible(c1, c2)
      case (c1: ChassisWithRelated, c2: MotherboardWithRelated) ⇒ ChassisMotherboardCheck isIncompatible(c1, c2)
      case (c1: ChassisWithRelated, c2: PowerSupplyWithRelated) ⇒ ChassisPowerSupplyCheck isIncompatible(c1, c2)
      case (c1: ChassisWithRelated, c2: StorageDeviceWithRelated) ⇒ ChassisStorageDeviceCheck isIncompatible(c1, c2)
      case (c1: CoolingSolutionWithRelated, c2: CoolingSolutionWithRelated) ⇒ CoolingSolutionCoolingSolutionCheck isIncompatible(c1, c2)
      case (c1: CoolingSolutionWithRelated, c2: MemoryStickWithRelated) ⇒ CoolingSolutionMemoryStickCheck isIncompatible(c1, c2)
      case (c1: CoolingSolutionWithRelated, c2: MotherboardWithRelated) ⇒ CoolingSolutionMotherboardCheck isIncompatible(c1, c2)
      case (c1: CoolingSolutionWithRelated, c2: PowerSupplyWithRelated) ⇒ CoolingSolutionPowerSupplyCheck isIncompatible(c1, c2)
      case (c1: CoolingSolutionWithRelated, c2: ProcessorWithRelated) ⇒ CoolingSolutionProcessorCheck isIncompatible(c1, c2)
      case (c1: GraphicsCardWithRelated, c2: GraphicsCardWithRelated) ⇒ GraphicsCardGraphicsCardCheck isIncompatible(c1, c2)
      case (c1: GraphicsCardWithRelated, c2: MotherboardWithRelated) ⇒ GraphicsCardMotherboardCheck isIncompatible(c1, c2)
      case (c1: GraphicsCardWithRelated, c2: PowerSupplyWithRelated) ⇒ GraphicsCardPowerSupplyCheck isIncompatible(c1, c2)
      case (c1: MemoryStickWithRelated, c2: MemoryStickWithRelated) ⇒ MemoryStickMemoryStickCheck isIncompatible(c1, c2)
      case (c1: MemoryStickWithRelated, c2: MotherboardWithRelated) ⇒ MemoryStickMotherboardCheck isIncompatible(c1, c2)
      case (c1: MemoryStickWithRelated, c2: PowerSupplyWithRelated) ⇒ MemoryStickPowerSupplyCheck isIncompatible(c1, c2)
      case (c1: MotherboardWithRelated, c2: MotherboardWithRelated) ⇒ MotherboardMotherboardCheck isIncompatible(c1, c2)
      case (c1: MotherboardWithRelated, c2: PowerSupplyWithRelated) ⇒ MotherboardPowerSupplyCheck isIncompatible(c1, c2)
      case (c1: MotherboardWithRelated, c2: ProcessorWithRelated) ⇒ MotherboardProcessorCheck isIncompatible(c1, c2)
      case (c1: MotherboardWithRelated, c2: StorageDeviceWithRelated) ⇒ MotherboardStorageDeviceCheck isIncompatible(c1, c2)
      case (c1: PowerSupplyWithRelated, c2: PowerSupplyWithRelated) ⇒ PowerSupplyPowerSupplyCheck isIncompatible(c1, c2)
      case (c1: PowerSupplyWithRelated, c2: ProcessorWithRelated) ⇒ PowerSupplyProcessorCheck isIncompatible(c1, c2)
      case (c1: PowerSupplyWithRelated, c2: StorageDeviceWithRelated) ⇒ PowerSupplyStorageDeviceCheck isIncompatible(c1, c2)
      case (c1: ProcessorWithRelated, c2: ProcessorWithRelated) ⇒ ProcessorProcessorCheck isIncompatible(c1, c2)
      case _ ⇒ false
    }
  }

  private def buildIndirect(components: Components, direct: ComponentGraph, complement: ComponentGraph)(implicit selected: Seq[(Component, Int)]) = {
    // TODO
    Graph().asInstanceOf[ComponentGraph]
  }

}

object CompatibilityService {

  type Component = ComponentWithRelated[_]
  type ComponentGraph = Graph[Component, UnDiEdge]

}
