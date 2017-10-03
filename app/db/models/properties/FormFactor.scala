package db.models.properties

case class FormFactor(
  id: Option[Int],

  name: String,
)

object FormFactorUtils {
  implicit class Format(f: Seq[FormFactor]) {
    def glue: String = {
      f map (_.name) reduce { _ + ", " + _ }
    }
  }
}
