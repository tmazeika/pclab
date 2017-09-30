package controllers

import javax.inject._

import play.api.mvc._
import services.ComponentRepository

import scala.concurrent.ExecutionContext

@Singleton
class LabController @Inject()(cc: ControllerComponents, cRepo: ComponentRepository)(implicit ec: ExecutionContext) extends AbstractController(cc) {
  def index = Action.async {
    cRepo.all map { c ⇒
      Ok(views.html lab c)
    }
  }
}
