package myskillsperformance

import scala.concurrent.duration._

import io.gatling.core.Predef._
import io.gatling.http.Predef._
import io.gatling.jdbc.Predef._

class AdvancedMySkillsPerformanceSimulation extends Simulation {
  // Let's split this big scenario into composable business processes, like one would do with PageObject pattern with Selenium

  // object are native Scala singletons
  object Browser {

    val headers_0 = Map(
      "Accept" -> "application/json, text/plain, */*",
      "Content-Type" -> "application/json;charset=utf-8")

    val solve = exec(http("Solve")
      .get("/zinio/ts/solve.php"))
      .pause(2)
  }

  val httpConf = http
    .baseURL("http://localhost")
    .acceptHeader("text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8")
    .doNotTrackHeader("1")
    .acceptLanguageHeader("en-US,en;q=0.5")
    .acceptEncodingHeader("gzip, deflate")
    .userAgentHeader("Mozilla/5.0 (Macintosh; Intel Mac OS X 10.8; rv:16.0) Gecko/20100101 Firefox/16.0")

  // Now, we can write the scenario as a composition
  val scn = scenario("TS").exec(Browser.solve)

  //setUp(scn.inject(atOnceUsers(1)).protocols(httpConf))
  setUp(scn.inject(rampUsers(50) over(100 seconds))).protocols(httpConf)
}