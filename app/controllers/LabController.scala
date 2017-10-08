package controllers

import javax.inject._

import play.api.mvc._
import services.ComponentRepository

import scala.concurrent.ExecutionContext

@Singleton
class LabController @Inject()(cc: ControllerComponents, repo: ComponentRepository)(implicit ec: ExecutionContext) extends AbstractController(cc) {
  def index = Action.async {
    repo.all map { all ⇒
      Ok(views.html lab all)
    }
  }

  def select = Action {
    Ok("")
  }
}
