package db.models.pivots

case class ChassisFormFactor(
  id: Option[Int],

  chassisId: Int,
  formFactorId: Int,
)
