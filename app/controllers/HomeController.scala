package controllers

import javax.inject._

import play.api.mvc._

@Singleton
class HomeController @Inject()(cc: ControllerComponents) extends AbstractController(cc)
{
  def index = Action {
    Ok(views.html.index())
  }

  def showcase = Action {
    Ok(views.html.showcase())
  }
}
