package db.models.components

case class CoolingSolution(
  id: Option[Int],
  componentId: Int,

  height: Short, // millimeters
  maxMemoryStickHeight: Short, // millimeters
  tdp: Short, // watts
)
