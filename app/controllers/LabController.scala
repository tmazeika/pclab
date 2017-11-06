package controllers

import javax.inject._

import compatibility.CompatibilityService
import play.api.libs.json.Json.toJson
import play.api.mvc._
import services.ComponentRepository

import scala.concurrent.{ExecutionContext, Future}
import scala.util.{Failure, Success}

@Singleton
class LabController @Inject()(cc: ControllerComponents, repo: ComponentRepository, compatibility: CompatibilityService)
  (implicit ec: ExecutionContext) extends AbstractController(cc) {

  def index = Action.async {
    repo.all map { all ⇒
      Ok(views.html.lab(toJson(all) toString))
    }
  }

  def select(selectedIds: Seq[Int], selectedCounts: Seq[Int]) = Action.async {
    zipSelected(selectedIds, selectedCounts) match {
      case Left(m) ⇒ Future(BadRequest(m))
      case Right(selected) ⇒ compatibility getIncompatibilities selected map {
        case Failure(e) ⇒ BadRequest(e.getMessage)
        case Success(incompatibilities) ⇒ Ok(toJson(incompatibilities))
      }
    }
  }

  private def zipSelected(selectedIds: Seq[Int], selectedCounts: Seq[Int]) =
    if (selectedIds.length != selectedCounts.length)
      Left("Selected IDs and counts must have the same length")
    else if (selectedCounts exists (1 to 999 contains _))
      Right(selectedIds zip selectedCounts)
    else
      Left("One or more selected count(s) out of range")

}
