package db

import controllers.routes
import db.models.components._
import db.models.properties.FormFactor
import play.api.libs.json.Json.{obj, toJson}
import play.api.libs.json.{JsObject, Writes}

package object models {
  implicit val formFactorWrites = new Writes[FormFactor] {
    override def writes(f: FormFactor) = toJson(f.name)
  }

  implicit val chassisWrites = new Writes[ChassisWithRelated] {
    override def writes(c: ChassisWithRelated) = componentWrites(c.parent) ++ obj(
      "form_factors" → c.formFactors
    )
  }

  implicit val coolingSolutionWrites = new Writes[CoolingSolutionWithRelated] {
    override def writes(c: CoolingSolutionWithRelated) = componentWrites(c.parent) ++ obj(
      "tdp" → c.self.tdp,
    )
  }

  implicit val graphicsCardWrites = new Writes[GraphicsCardWithRelated] {
    override def writes(g: GraphicsCardWithRelated) = componentWrites(g.parent) ++ obj(
      "family" → g.self.family,
    )
  }

  implicit val memoryStickWrites = new Writes[MemoryStickWithRelated] {
    override def writes(m: MemoryStickWithRelated) = componentWrites(m.parent) ++ obj(
      "capacity" → m.self.capacity,
      "generation" → m.self.generation,
    )
  }

  implicit val motherboardWrites = new Writes[MotherboardWithRelated] {
    override def writes(m: MotherboardWithRelated) = componentWrites(m.parent) ++ obj(
      "formFactor" → m.formFactor.name,
      "max_memory_capacity" → m.self.maxMemoryCapacity,
      "memory_generation" → m.self.memoryGeneration,
      "memory_slots" → m.self.memorySlots,
      "socket" → m.socket.name,
      "supports_sli" → m.self.supportsSli,
    )
  }

  implicit val powerSupplyWrites = new Writes[PowerSupplyWithRelated] {
    override def writes(p: PowerSupplyWithRelated) = componentWrites(p.parent) ++ obj(
      "is_modular" → p.self.isModular,
      "power_output" → p.self.powerOutput,
    )
  }

  implicit val processorWrites = new Writes[ProcessorWithRelated] {
    override def writes(p: ProcessorWithRelated) = componentWrites(p.parent) ++ obj(
      "socket" → p.socket.name,
    )
  }

  implicit val storageDeviceWrites = new Writes[StorageDeviceWithRelated] {
    override def writes(s: StorageDeviceWithRelated) = componentWrites(s.parent) ++ obj(
      "capacity" → s.self.capacity,
    )
  }

  implicit val componentsWrites = new Writes[Components] {
    override def writes(c: Components): JsObject = obj(
      "chassis" → c.chassis,
      "cooling_solutions" → c.coolingSolutions,
      "memory_sticks" → c.memorySticks,
      "motherboards" → c.motherboards,
      "power_supplies" → c.powerSupplies,
      "processors" → c.processors,
      "storage_devices" → c.storageDevices,
    )
  }

  private def componentWrites(c: Component): JsObject = obj(
    "id" → c.id,
    "brand" → c.brand,
    "cost" → c.cost,
    "is_available_immediately" → c.isAvailableImmediately,
    "model" → c.model,
    "name" → c.name,
    "preview_img_url" → routes.Assets.versioned(s"images/components/${c.previewImgHash}.jpg").url,
  )
}
