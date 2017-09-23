package controllers

import javax.inject._

import db.ComponentRepository
import play.api.db.slick.{DatabaseConfigProvider, HasDatabaseConfigProvider}
import play.api.mvc._
import slick.jdbc.PostgresProfile

import scala.concurrent.ExecutionContext

@Singleton
class LabController @Inject()(
  cc: ControllerComponents, val dbConfigProvider: DatabaseConfigProvider
)(implicit ec: ExecutionContext)
  extends AbstractController(cc)
  with HasDatabaseConfigProvider[PostgresProfile]
{
  import dbConfig.profile.api._

  def index = Action.async {
    val components = db run (
      ComponentRepository.motherboards
        join ComponentRepository.components
        on (_.componentId === _.id)
        result
    )

    components map (c ⇒ Ok(views.html lab c))
  }
}
