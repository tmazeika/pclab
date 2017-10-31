package controllers

import javax.inject._

import compatibility.CompatibilityService
import play.api.libs.json.Json.toJson
import play.api.mvc._
import services.ComponentRepository

import scala.concurrent.{ExecutionContext, Future}

@Singleton
class LabController @Inject()(cc: ControllerComponents, repo: ComponentRepository, compat: CompatibilityService)(implicit ec: ExecutionContext) extends AbstractController(cc) {
  def index = Action.async {
    repo.all map { all ⇒
      Ok(views.html.lab(toJson(all) toString))
    }
  }

  def select(selectedIds: Seq[Int], selectedCounts: Seq[Int]) = Action.async {
    // TODO: clean up
    zipSelected(selectedIds, selectedCounts) match {
      case Left(m) ⇒ Future { BadRequest(m) }
      case Right(s) ⇒ {
          compat getIncompatibilities s map { incompat ⇒
            Ok(toJson(incompat))
          }
      }
    }
  }

  private def zipSelected(selectedIds: Seq[Int], selectedCounts: Seq[Int]): Either[String, Seq[(Int, Int)]] =
    if (selectedIds.length != selectedCounts.length)
      Left("Selected IDs and counts must have the same length")
    else if (selectedIds exists (_ <= 0))
      Left("Invalid selected ID")
    else if (selectedCounts exists (_ <= 0))
      Left("All selected counts must be positive")
    else
      Right(selectedIds zip selectedCounts)
}
