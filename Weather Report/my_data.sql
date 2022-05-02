-- MySQL dump 10.13  Distrib 8.0.28, for Linux (x86_64)
--
-- Host: localhost    Database: weather_db
-- ------------------------------------------------------
-- Server version	8.0.28-0ubuntu0.20.04.3

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES ('West New York','::1');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `weather_report`
--

LOCK TABLES `weather_report` WRITE;
/*!40000 ALTER TABLE `weather_report` DISABLE KEYS */;
INSERT INTO `weather_report` VALUES (469,'Edgewater','2022-05-01',NULL,'Low: 52 °F','Light Rain Likely','Light rain likely, mainly after 11pm.  Increasing clouds, with a low around 52. South wind 7 to 9 mph.  Chance of precipitation is 70%. New precipitation amounts of less than a tenth of an inch possible.'),(470,'Edgewater','2022-05-02','Night','Low: 49 °F','Patchy Fog','Patchy fog.  Otherwise, mostly cloudy, with a low around 49. Northeast wind 6 to 8 mph.'),(471,'Edgewater','2022-05-03','Day','High: 64 °F','Partly Sunny','Partly sunny, with a high near 64. Northeast wind around 7 mph.'),(472,'Edgewater','2022-05-03','Night','Low: 50 °F','Chance Likely','Showers likely, mainly after 2am.  Cloudy, with a low around 50. Southeast wind around 10 mph.  Chance of precipitation is 60%. New precipitation amounts of less than a tenth of an inch possible.'),(473,'Edgewater','2022-05-04','Day','High: 62 °F','Showers Likely','Showers likely.  Mostly cloudy, with a high near 62. Chance of precipitation is 60%. New precipitation amounts between a tenth and quarter of an inch possible.'),(474,'Edgewater','2022-05-04','Night','Low: 52 °F','Mostly Cloudy','Mostly cloudy, with a low around 52.'),(475,'Edgewater','2022-05-05','Day','High: 69 °F','Partly Sunny','Partly sunny, with a high near 69.'),(476,'Edgewater','2022-05-05','Night','Low: 51 °F','Mostly Cloudy','Mostly cloudy, with a low around 51.'),(477,'Hoboken','2022-05-01',NULL,'Low: 52 °F','Light Rain Likely','Light rain likely, mainly after 2am.  Cloudy, with a low around 52. Southeast wind around 7 mph.  Chance of precipitation is 70%. New precipitation amounts of less than a tenth of an inch possible.'),(478,'Hoboken','2022-05-02','Night','Low: 50 °F','Patchy Fog','Patchy fog.  Otherwise, mostly cloudy, with a low around 50. Northeast wind 5 to 8 mph.'),(479,'Hoboken','2022-05-03','Day','High: 64 °F','Partly Sunny','Partly sunny, with a high near 64. Northeast wind 6 to 9 mph becoming southeast in the afternoon.'),(480,'Hoboken','2022-05-03','Night','Low: 51 °F','Chance Likely','Showers likely, mainly after 2am.  Cloudy, with a low around 51. Southeast wind 8 to 10 mph.  Chance of precipitation is 60%. New precipitation amounts of less than a tenth of an inch possible.'),(481,'Hoboken','2022-05-04','Day','High: 63 °F','Showers Likely','Showers likely.  Mostly cloudy, with a high near 63. Chance of precipitation is 70%. New precipitation amounts between a tenth and quarter of an inch possible.'),(482,'Hoboken','2022-05-04','Night','Low: 53 °F','Mostly Cloudy','Mostly cloudy, with a low around 53.'),(483,'Hoboken','2022-05-05','Day','High: 69 °F','Partly Sunny','Partly sunny, with a high near 69.'),(484,'Hoboken','2022-05-05','Night','Low: 51 °F','Mostly Cloudy','Mostly cloudy, with a low around 51.'),(485,'Jersey City','2022-05-01',NULL,'Low: 52 °F','Light Rain Likely','Light rain likely, mainly after 11pm.  Increasing clouds, with a low around 52. South wind 6 to 9 mph.  Chance of precipitation is 70%. New precipitation amounts of less than a tenth of an inch possible.'),(486,'Jersey City','2022-05-02','Day','High: 59 °F','Chance Light Patchy Fog','A chance of light rain before 11am, then a slight chance of drizzle or light rain between 11am and 2pm.  Patchy fog.  Otherwise, cloudy, with a high near 59. East wind 7 to 9 mph.  Chance of precipitation is 50%.'),(487,'Jersey City','2022-05-02','Night','Low: 50 °F','Patchy Fog','Patchy fog.  Otherwise, mostly cloudy, with a low around 50. Northeast wind 5 to 7 mph.'),(488,'Jersey City','2022-05-03','Day','High: 63 °F','Partly Sunny','Partly sunny, with a high near 63. Northeast wind 6 to 9 mph becoming southeast in the afternoon.'),(489,'Jersey City','2022-05-03','Night','Low: 50 °F','Chance Likely','Showers likely, mainly after 2am.  Cloudy, with a low around 50. Southeast wind 7 to 10 mph.  Chance of precipitation is 60%. New precipitation amounts of less than a tenth of an inch possible.'),(490,'Jersey City','2022-05-04','Day','High: 63 °F','Showers Likely','Showers likely.  Mostly cloudy, with a high near 63. Chance of precipitation is 70%. New precipitation amounts between a tenth and quarter of an inch possible.'),(491,'Jersey City','2022-05-04','Night','Low: 53 °F','Mostly Cloudy','Mostly cloudy, with a low around 53.'),(492,'Jersey City','2022-05-05','Day','High: 69 °F','Partly Sunny','Partly sunny, with a high near 69.'),(493,'Jersey City','2022-05-05','Night','Low: 51 °F','Mostly Cloudy','Mostly cloudy, with a low around 51.'),(494,'Trenton','2022-05-01',NULL,'Low: 52 °F','Showers Likely','Showers likely, mainly after 3am.  Cloudy, with a low around 52. South wind around 5 mph becoming southeast after midnight.  Chance of precipitation is 60%. New precipitation amounts between a tenth and quarter of an inch possible.'),(495,'Trenton','2022-05-02','Day','High: 67 °F','Showers','Showers likely, mainly before 8am.  Mostly cloudy, with a high near 67. Calm wind becoming northeast around 5 mph in the afternoon.  Chance of precipitation is 60%. New precipitation amounts of less than a tenth of an inch possible.'),(496,'Trenton','2022-05-02','Night','Low: 49 °F','Mostly Cloudy','Mostly cloudy, with a low around 49. Northeast wind around 5 mph.'),(497,'Trenton','2022-05-03','Day','High: 67 °F','Partly Sunny','Partly sunny, with a high near 67. Northeast wind around 5 mph.'),(498,'Trenton','2022-05-03','Night','Low: 49 °F','Chance Likely','Showers likely, mainly after 2am.  Cloudy, with a low around 49. Southeast wind around 5 mph.  Chance of precipitation is 60%. New precipitation amounts of less than a tenth of an inch possible.'),(499,'Trenton','2022-05-04','Day','High: 69 °F','Showers Likely','Showers likely.  Mostly cloudy, with a high near 69. Chance of precipitation is 70%. New precipitation amounts of less than a tenth of an inch possible.'),(500,'Trenton','2022-05-04','Night','Low: 52 °F','Mostly Cloudy','Mostly cloudy, with a low around 52.'),(501,'Trenton','2022-05-05','Day','High: 71 °F','Partly Sunny','Partly sunny, with a high near 71.'),(502,'Trenton','2022-05-05','Night','Low: 49 °F','Mostly Cloudy','Mostly cloudy, with a low around 49.'),(503,'West New York','2022-05-01',NULL,'Low: 53 °F','Light Rain Likely','Light rain likely, mainly after 11pm.  Increasing clouds, with a low around 53. South wind 6 to 9 mph.  Chance of precipitation is 70%. New precipitation amounts of less than a tenth of an inch possible.'),(504,'West New York','2022-05-02','Night','Low: 50 °F','Patchy Fog','Patchy fog.  Otherwise, mostly cloudy, with a low around 50. Northeast wind 5 to 8 mph.'),(505,'West New York','2022-05-03','Day','High: 64 °F','Partly Sunny','Partly sunny, with a high near 64. Northeast wind 6 to 9 mph.'),(506,'West New York','2022-05-03','Night','Low: 51 °F','Chance Likely','Showers likely, mainly after 2am.  Cloudy, with a low around 51. Southeast wind 8 to 10 mph.  Chance of precipitation is 60%. New precipitation amounts of less than a tenth of an inch possible.'),(507,'West New York','2022-05-04','Day','High: 63 °F','Showers Likely','Showers likely.  Mostly cloudy, with a high near 63. Chance of precipitation is 70%. New precipitation amounts between a tenth and quarter of an inch possible.'),(508,'West New York','2022-05-04','Night','Low: 53 °F','Mostly Cloudy','Mostly cloudy, with a low around 53.'),(509,'West New York','2022-05-05','Day','High: 69 °F','Partly Sunny','Partly sunny, with a high near 69.'),(510,'West New York','2022-05-05','Night','Low: 51 °F','Mostly Cloudy','Mostly cloudy, with a low around 51.');
/*!40000 ALTER TABLE `weather_report` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-05-01 20:00:58
