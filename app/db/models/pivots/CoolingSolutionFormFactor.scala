package db.models.pivots

case class CoolingSolutionFormFactor(
  id: Option[Int],

  coolingSolutionId: Int,
  socketId: Int,
)
