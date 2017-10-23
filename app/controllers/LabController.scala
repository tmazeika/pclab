package controllers

import javax.inject._

import play.api.libs.json.Json
import play.api.mvc._
import services.ComponentRepository

import scala.concurrent.ExecutionContext

@Singleton
class LabController @Inject()(cc: ControllerComponents, repo: ComponentRepository)(implicit ec: ExecutionContext) extends AbstractController(cc) {
  def index = Action.async {
    repo.all map { all ⇒
      Ok(views.html.lab(Json toJson all toString))
    }
  }

  def select = Action {
    Ok("")
  }
}
