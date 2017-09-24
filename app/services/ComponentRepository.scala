package services

import javax.inject.{Inject, Singleton}

import db.ComponentRepository._
import db.models.components._
import play.api.db.slick.{DatabaseConfigProvider, HasDatabaseConfigProvider}
import slick.jdbc.PostgresProfile

import scala.concurrent.{ExecutionContext, Future}

@Singleton
class ComponentRepository @Inject()(val dbConfigProvider: DatabaseConfigProvider)(implicit ec: ExecutionContext)
  extends HasDatabaseConfigProvider[PostgresProfile] {

  import profile.api._

  def allComponents: Future[AllComponents] = for {
    chassis ← db run (allChassis result) flatMap { chassis ⇒
      Future sequence (chassis map { c ⇒
        db run (allChassisFormFactors(c _1) result) map { formFactors ⇒
          (c _1, c _2, formFactors)
        }
      })
    }
    coolingSolutions ← db run (allCoolingSolutions result) flatMap { coolingSolutions ⇒
      Future sequence (coolingSolutions map { c ⇒
        db run (allCoolingSolutionSockets(c _1) result) map { sockets ⇒
          (c _1, c _2, sockets)
        }
      })
    }
    graphicsCards ← db run (allGraphicsCards result)
    memorySticks ← db run (allMemorySticks result)
    motherboards ← db run (allMotherboards result)
    powerSupplies ← db run (allPowerSupplies result)
    processors ← db run (allProcessors result)
    storageDevices ← db run (allStorageDevices result)
  } yield AllComponents(
    chassis map { ChassisWithRelated tupled },
    coolingSolutions map { CoolingSolutionWithRelated tupled },
    graphicsCards map { GraphicsCardWithRelated tupled },
    memorySticks map { MemoryStickWithRelated tupled },
    motherboards map { MotherboardWithRelated tupled },
    powerSupplies map { PowerSupplyWithRelated tupled },
    processors map { ProcessorWithRelated tupled },
    storageDevices map { StorageDeviceWithRelated tupled },
  )

  private def allChassis = for {
    chassis ← chassis
    component ← components if component.id === chassis.componentId
  } yield (chassis, component)

  private def allChassisFormFactors(chas: Chassis) = for {
    pivot ← chassisFormFactor if pivot.chassisId === chas.id
    formFactor ← formFactors if formFactor.id === pivot.formFactorId
  } yield formFactor

  private def allCoolingSolutions = for {
    coolingSolution ← coolingSolutions
    component ← components if component.id === coolingSolution.componentId
  } yield (coolingSolution, component)

  private def allCoolingSolutionSockets(cool: CoolingSolution) = for {
    pivot ← coolingSolutionSocket if pivot.coolingSolutionId === cool.id
    socket ← sockets if socket.id === pivot.socketId
  } yield socket

  private def allGraphicsCards = for {
    graphicsCard ← graphicsCards
    component ← components if component.id === graphicsCard.componentId
  } yield (graphicsCard, component)

  private def allMemorySticks = for {
    memoryStick ← memorySticks
    component ← components if component.id === memoryStick.componentId
  } yield (memoryStick, component)

  private def allMotherboards = for {
    motherboard ← motherboards
    component ← components if component.id === motherboard.componentId
    formFactor ← formFactors if formFactor.id === motherboard.formFactorId
    socket ← sockets if socket.id === motherboard.socketId
  } yield (motherboard, component, formFactor, socket)

  private def allPowerSupplies = for {
    powerSupply ← powerSupplies
    component ← components if component.id === powerSupply.componentId
  } yield (powerSupply, component)

  private def allProcessors = for {
    processor ← processors
    component ← components if component.id === processor.componentId
    socket ← sockets if socket.id === processor.socketId
  } yield (processor, component, socket)

  private def allStorageDevices = for {
    storage ← storageDevices
    component ← components if component.id === storage.componentId
  } yield (storage, component)
}
