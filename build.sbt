name := "pclab"
 
version := "0.1"
      
lazy val `pclab` = (project in file(".")).enablePlugins(PlayScala)

resolvers += "scalaz-bintray" at "https://dl.bintray.com/scalaz/releases"
      
resolvers += "Akka Snapshot Repository" at "http://repo.akka.io/snapshots/"
      
scalaVersion := "2.12.2"

libraryDependencies ++= Seq( evolutions, jdbc , ehcache , ws , specs2 % Test , guice ,
  "com.h2database" % "h2" % "1.4.192" ,
  "com.typesafe.play" %% "anorm" % "2.5.3" )

unmanagedResourceDirectories in Test <+=  baseDirectory ( _ /"target/web/public/test" )  

