package db.models.components

case class Component(
  id: Option[Int],

  brand: String,
  cost: Int, // pennies
  isAvailableImmediately: Boolean,
  model: Option[String],
  name: String,
  powerUsage: Short, // watts
  weight: Int, // grams
)
