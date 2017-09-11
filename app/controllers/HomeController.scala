package controllers

import javax.inject._

import anorm.SqlParser._
import anorm._
import play.api.db.Database
import play.api.mvc._

@Singleton
class HomeController @Inject()(db: Database, cc: ControllerComponents) extends AbstractController(cc)
{
  def index = Action {
    db.withConnection { implicit c ⇒
      val parser = int("id") ~ str("name") map { case i ~ n ⇒ (i, n) }
      val result = SQL("SELECT id, name FROM components ORDER BY id DESC LIMIT 1") as parser.singleOpt

      Ok(views.html.index(result.getOrElse(-1, "No Name")))
    }
  }

  def showcase = Action {
    db.withConnection { implicit c ⇒
      SQL("INSERT INTO components(name) VALUES ({name})")
        .on('name → "Boi")
        .executeInsert()
    }

    Ok(views.html.showcase())
  }
}
