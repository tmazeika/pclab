name := "pclab"
 
version := "0.1"
      
lazy val `pclab` = (project in file(".")).enablePlugins(PlayScala)

resolvers ++= Seq(
  "scalaz-bintray" at "https://dl.bintray.com/scalaz/releases",
  "Akka Snapshot Repository" at "http://repo.akka.io/snapshots/")

scalaVersion := "2.12.3"

libraryDependencies ++= Seq(ehcache, ws, specs2 % Test, guice,
  "org.scalaz" %% "scalaz-core" % "7.2.16",
  "org.postgresql" % "postgresql" % "42.1.4",
  "com.typesafe.play" %% "play-slick" % "3.0.1",
  "com.typesafe.play" %% "play-slick-evolutions" % "3.0.2",
  "org.scala-graph" %% "graph-core" % "1.12.1")

unmanagedResourceDirectories in Test <+= baseDirectory (_ /"target/web/public/test")

