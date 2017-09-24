package db.models.components

case class GraphicsCard(
  id: Option[Int],
  componentId: Int,

  family: String,
  hasDisplayPort: Boolean,
  hasDvi: Boolean,
  hasHdmi: Boolean,
  hasVga: Boolean,
  length: Short, // millimeters
  supportsSli: Boolean,
)
