-- MySQL dump 10.13  Distrib 8.0.20, for Linux (x86_64)
--
-- Host: localhost    Database: carros
-- ------------------------------------------------------
-- Server version	8.0.20-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `carros`
--

DROP TABLE IF EXISTS `carros`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carros` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `marca` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `modelo` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ano` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=117 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carros`
--

LOCK TABLES `carros` WRITE;
/*!40000 ALTER TABLE `carros` DISABLE KEYS */;
INSERT INTO `carros` VALUES (1,'Audi','repudiandae','2010','2020-07-14 07:02:15','2020-07-14 07:02:15'),(2,'Volvo','eos','2013','2020-07-14 07:02:16','2020-07-14 07:02:16'),(3,'BMW','id','2013','2020-07-14 07:02:16','2020-07-14 07:02:16'),(4,'Chevrolet','debitis','2002','2020-07-14 07:02:16','2020-07-14 07:02:16'),(5,'Fiat','corporis','2020','2020-07-14 07:02:16','2020-07-14 07:02:16'),(6,'Volvo','tempora','2007','2020-07-14 07:02:17','2020-07-14 07:02:17'),(7,'Audi','atque','2001','2020-07-14 07:02:17','2020-07-14 07:02:17'),(8,'BMW','mollitia','2001','2020-07-14 07:02:17','2020-07-14 07:02:17'),(9,'Audi','at','2013','2020-07-14 07:02:17','2020-07-14 07:02:17'),(10,'Volvo','sed','2020','2020-07-14 07:02:17','2020-07-14 07:02:17'),(11,'Fiat','possimus','2013','2020-07-14 07:02:17','2020-07-14 07:02:17'),(12,'Volvo','voluptatem','2007','2020-07-14 07:02:17','2020-07-14 07:02:17'),(13,'Volvo','iste','2001','2020-07-14 07:02:18','2020-07-14 07:02:18'),(14,'Chevrolet','neque','2015','2020-07-14 07:02:18','2020-07-14 07:02:18'),(15,'Chevrolet','error','2007','2020-07-14 07:02:18','2020-07-14 07:02:18'),(16,'BMW','et','2000','2020-07-14 07:02:18','2020-07-14 07:02:18'),(17,'Chevrolet','molestiae','2014','2020-07-14 07:02:18','2020-07-14 07:02:18'),(18,'Fiat','explicabo','2020','2020-07-14 07:02:18','2020-07-14 07:02:18'),(19,'Ford','aut','2018','2020-07-14 07:02:18','2020-07-14 07:02:18'),(20,'Audi','excepturi','2000','2020-07-14 07:02:18','2020-07-14 07:02:18'),(21,'Audi','facere','2018','2020-07-14 07:02:18','2020-07-14 07:02:18'),(22,'BMW','consequatur','2013','2020-07-14 07:02:19','2020-07-14 07:02:19'),(23,'Chevrolet','veniam','2010','2020-07-14 07:02:19','2020-07-14 07:02:19'),(24,'BMW','fugiat','2012','2020-07-14 07:02:19','2020-07-14 07:02:19'),(25,'Volvo','dolorum','2018','2020-07-14 07:02:19','2020-07-14 07:02:19'),(26,'Chevrolet','vero','2011','2020-07-14 07:02:19','2020-07-14 07:02:19'),(27,'Ford','architecto','2014','2020-07-14 07:02:19','2020-07-14 07:02:19'),(28,'Chevrolet','eaque','2014','2020-07-14 07:02:19','2020-07-14 07:02:19'),(29,'Chevrolet','praesentium','2011','2020-07-14 07:02:20','2020-07-14 07:02:20'),(30,'Audi','consequuntur','2008','2020-07-14 07:02:20','2020-07-14 07:02:20'),(31,'Chevrolet','reiciendis','2016','2020-07-14 07:02:20','2020-07-14 07:02:20'),(32,'Volvo','expedita','2010','2020-07-14 07:02:20','2020-07-14 07:02:20'),(33,'Audi','rerum','2004','2020-07-14 07:02:21','2020-07-14 07:02:21'),(34,'Ford','magnam','2014','2020-07-14 07:02:21','2020-07-14 07:02:21'),(35,'Chevrolet','qui','2019','2020-07-14 07:02:21','2020-07-14 07:02:21'),(36,'Volvo','omnis','2003','2020-07-14 07:02:22','2020-07-14 07:02:22'),(37,'Audi','laudantium','2020','2020-07-14 07:02:22','2020-07-14 07:02:22'),(38,'Ford','quod','2004','2020-07-14 07:02:22','2020-07-14 07:02:22'),(39,'Fiat','accusantium','2017','2020-07-14 07:02:22','2020-07-14 07:02:22'),(40,'Volvo','reprehenderit','2010','2020-07-14 07:02:23','2020-07-14 07:02:23'),(41,'Volvo','nam','2014','2020-07-14 07:02:23','2020-07-14 07:02:23'),(42,'Volvo','perspiciatis','2015','2020-07-14 07:02:23','2020-07-14 07:02:23'),(43,'Audi','eius','2020','2020-07-14 07:02:23','2020-07-14 07:02:23'),(44,'Ford','eligendi','2014','2020-07-14 07:02:23','2020-07-14 07:02:23'),(45,'Fiat','dolorem','2010','2020-07-14 07:02:24','2020-07-14 07:02:24'),(46,'Fiat','ut','2019','2020-07-14 07:02:24','2020-07-14 07:02:24'),(47,'BMW','commodi','2000','2020-07-14 07:02:24','2020-07-14 07:02:24'),(48,'Chevrolet','sint','2007','2020-07-14 07:02:24','2020-07-14 07:02:24'),(49,'BMW','quae','2004','2020-07-14 07:02:24','2020-07-14 07:02:24'),(50,'Volvo','tenetur','2007','2020-07-14 07:02:25','2020-07-14 07:02:25'),(51,'Volvo','iusto','2010','2020-07-14 07:02:25','2020-07-14 07:02:25'),(52,'Ford','saepe','2010','2020-07-14 07:02:25','2020-07-14 07:02:25'),(53,'Audi','libero','2000','2020-07-14 07:02:25','2020-07-14 07:02:25'),(54,'Fiat','distinctio','2008','2020-07-14 07:02:26','2020-07-14 07:02:26'),(55,'Ford','beatae','2020','2020-07-14 07:02:26','2020-07-14 07:02:26'),(56,'Volvo','nemo','2011','2020-07-14 07:02:26','2020-07-14 07:02:26'),(57,'Fiat','est','2015','2020-07-14 07:02:26','2020-07-14 07:02:26'),(58,'BMW','earum','2010','2020-07-14 07:02:26','2020-07-14 07:02:26'),(59,'Volvo','necessitatibus','2010','2020-07-14 07:02:27','2020-07-14 07:02:27'),(60,'Audi','eum','2017','2020-07-14 07:02:27','2020-07-14 07:02:27'),(61,'Chevrolet','sunt','2018','2020-07-14 07:02:27','2020-07-14 07:02:27'),(62,'Chevrolet','itaque','2001','2020-07-14 07:02:27','2020-07-14 07:02:27'),(63,'Chevrolet','deserunt','2017','2020-07-14 07:02:27','2020-07-14 07:02:27'),(64,'Volvo','incidunt','2004','2020-07-14 07:02:28','2020-07-14 07:02:28'),(65,'Audi','dolore','2006','2020-07-14 07:02:28','2020-07-14 07:02:28'),(66,'Fiat','quos','2006','2020-07-14 07:02:28','2020-07-14 07:02:28'),(67,'Volvo','amet','2013','2020-07-14 07:02:28','2020-07-14 07:02:28'),(68,'Chevrolet','nostrum','2003','2020-07-14 07:02:28','2020-07-14 07:02:28'),(69,'Ford','animi','2020','2020-07-14 07:02:29','2020-07-14 07:02:29'),(70,'Ford','illum','2008','2020-07-14 07:02:29','2020-07-14 07:02:29'),(71,'Audi','ea','2010','2020-07-14 07:02:29','2020-07-14 07:02:29'),(72,'Audi','molestias','2013','2020-07-14 07:02:29','2020-07-14 07:02:29'),(73,'BMW','a','2011','2020-07-14 07:02:29','2020-07-14 07:02:29'),(74,'Volvo','unde','2004','2020-07-14 07:02:29','2020-07-14 07:02:29'),(75,'Audi','quia','2000','2020-07-14 07:02:29','2020-07-14 07:02:29'),(76,'BMW','natus','2003','2020-07-14 07:02:29','2020-07-14 07:02:29'),(77,'BMW','aliquam','2003','2020-07-14 07:02:30','2020-07-14 07:02:30'),(78,'Ford','culpa','2019','2020-07-14 07:02:30','2020-07-14 07:02:30'),(79,'Chevrolet','sit','2008','2020-07-14 07:02:30','2020-07-14 07:02:30'),(80,'Audi','adipisci','2018','2020-07-14 07:02:30','2020-07-14 07:02:30'),(81,'Audi','asperiores','2014','2020-07-14 07:02:30','2020-07-14 07:02:30'),(82,'Ford','ab','2015','2020-07-14 07:02:30','2020-07-14 07:02:30'),(83,'Chevrolet','deleniti','2012','2020-07-14 07:02:30','2020-07-14 07:02:30'),(84,'Chevrolet','doloremque','2009','2020-07-14 07:02:30','2020-07-14 07:02:30'),(85,'Audi','nobis','2019','2020-07-14 07:02:31','2020-07-14 07:02:31'),(86,'BMW','dicta','2009','2020-07-14 07:02:31','2020-07-14 07:02:31'),(87,'Audi','exercitationem','2013','2020-07-14 07:02:31','2020-07-14 07:02:31'),(88,'Fiat','nisi','2005','2020-07-14 07:02:31','2020-07-14 07:02:31'),(89,'Ford','doloribus','2016','2020-07-14 07:02:31','2020-07-14 07:02:31'),(90,'Volvo','voluptate','2009','2020-07-14 07:02:31','2020-07-14 07:02:31'),(91,'Audi','pariatur','2011','2020-07-14 07:02:31','2020-07-14 07:02:31'),(92,'Volvo','autem','2018','2020-07-14 07:02:31','2020-07-14 07:02:31'),(93,'Chevrolet','quasi','2018','2020-07-14 07:02:32','2020-07-14 07:02:32'),(94,'Chevrolet','cumque','2019','2020-07-14 07:02:32','2020-07-14 07:02:32'),(95,'Ford','suscipit','2001','2020-07-14 07:02:32','2020-07-14 07:02:32'),(96,'BMW','ipsam','2005','2020-07-14 07:02:32','2020-07-14 07:02:32'),(97,'Ford','fuga','2020','2020-07-14 07:02:32','2020-07-14 07:02:32'),(98,'Volvo','recusandae','2004','2020-07-14 07:02:32','2020-07-14 07:02:32'),(99,'Audi','alias','2012','2020-07-14 07:02:33','2020-07-14 07:02:33'),(100,'Audi','quis','2010','2020-07-14 07:02:33','2020-07-14 07:02:33'),(116,'Audi','V550','2013','2020-07-16 04:30:17','2020-07-16 04:30:32');
/*!40000 ALTER TABLE `carros` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_resets_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2020_07_14_032711_create_carros_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-15 22:38:40
