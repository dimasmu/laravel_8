-- MySQL dump 10.13  Distrib 8.0.29, for Win64 (x86_64)
--
-- Host: localhost    Database: movie_db2
-- ------------------------------------------------------
-- Server version	8.0.29

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
-- Table structure for table `detail_movie`
--

DROP TABLE IF EXISTS `detail_movie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `detail_movie` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `movie_id` bigint unsigned NOT NULL,
  `episode` int NOT NULL,
  `view` int DEFAULT '0',
  `like` int DEFAULT '0',
  `dislike` int DEFAULT '0',
  `created_by` int DEFAULT '0',
  `updated_by` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `detail_movie_movie_id_foreign` (`movie_id`),
  CONSTRAINT `detail_movie_movie_id_foreign` FOREIGN KEY (`movie_id`) REFERENCES `movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `detail_movie`
--

LOCK TABLES `detail_movie` WRITE;
/*!40000 ALTER TABLE `detail_movie` DISABLE KEYS */;
INSERT INTO `detail_movie` VALUES (4,2,1,0,0,0,0,0,'2022-07-31 19:17:19','2022-07-31 19:17:19');
/*!40000 ALTER TABLE `detail_movie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `link_movie`
--

DROP TABLE IF EXISTS `link_movie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `link_movie` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `detail_movie_id` bigint unsigned NOT NULL,
  `embed` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `resolution` int DEFAULT NULL,
  `created_by` int DEFAULT '0',
  `updated_by` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `link_movie_detail_movie_id_foreign` (`detail_movie_id`),
  CONSTRAINT `link_movie_detail_movie_id_foreign` FOREIGN KEY (`detail_movie_id`) REFERENCES `detail_movie` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `link_movie`
--

LOCK TABLES `link_movie` WRITE;
/*!40000 ALTER TABLE `link_movie` DISABLE KEYS */;
INSERT INTO `link_movie` VALUES (21,4,'<iframe src=\"https://userscloud.com/embed-6ivb6e45ehcz.html\" scrolling=\"no\" frameborder=\"0\" width=\"1024\" height=\"768\" allowfullscreen=\"true\" webkitallowfullscreen=\"true\" mozallowfullscreen=\"true\"></iframe>','https://userscloud.com/6ivb6e45ehcz',18,0,0,'2022-07-31 19:18:37','2022-07-31 19:20:04');
/*!40000 ALTER TABLE `link_movie` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_12_14_000001_create_personal_access_tokens_table',1),(2,'2022_07_16_054041_create_movie_table',1),(3,'2022_07_21_075720_create_detail_movies_table',1),(4,'2022_07_22_052346_create_link_movies_table',1),(5,'2022_07_26_052436_create_standard_fields_table',1),(6,'2022_07_26_052438_standard_field_detail',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `movie`
--

DROP TABLE IF EXISTS `movie`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `movie` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `category` json DEFAULT NULL,
  `release` timestamp NULL DEFAULT NULL,
  `aired_from` timestamp NULL DEFAULT NULL,
  `aired_to` timestamp NULL DEFAULT NULL,
  `duration` int DEFAULT NULL,
  `status` int DEFAULT NULL,
  `is_status` tinyint(1) DEFAULT NULL,
  `created_by` int DEFAULT '0',
  `updated_by` int DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `movie`
--

LOCK TABLES `movie` WRITE;
/*!40000 ALTER TABLE `movie` DISABLE KEYS */;
INSERT INTO `movie` VALUES (2,'Kimetsu no Yaiba Season 2',NULL,'[\"Action\", \"Shounen\", \"Supernatural\", \"Demon\", \"Historical\"]','2021-12-04 17:00:00','2021-03-05 17:00:00','2021-05-05 17:00:00',14,12,NULL,0,0,'2022-07-31 19:17:08','2022-07-31 19:17:08');
/*!40000 ALTER TABLE `movie` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `standard_field`
--

DROP TABLE IF EXISTS `standard_field`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `standard_field` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_status` tinyint(1) DEFAULT '0',
  `created_by` int DEFAULT '0',
  `updated_by` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standard_field`
--

LOCK TABLES `standard_field` WRITE;
/*!40000 ALTER TABLE `standard_field` DISABLE KEYS */;
INSERT INTO `standard_field` VALUES (1,'genre',1,0,0,NULL,NULL),(2,'status',1,0,0,NULL,NULL),(3,'duration',1,0,0,NULL,NULL),(4,'resolution',1,0,0,NULL,NULL),(5,'hosting',1,0,0,NULL,NULL);
/*!40000 ALTER TABLE `standard_field` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `standard_field_detail`
--

DROP TABLE IF EXISTS `standard_field_detail`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `standard_field_detail` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_status` tinyint(1) DEFAULT '0',
  `group` bigint unsigned NOT NULL,
  `created_by` int DEFAULT '0',
  `updated_by` int DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `standard_field_detail_group_foreign` (`group`),
  CONSTRAINT `standard_field_detail_group_foreign` FOREIGN KEY (`group`) REFERENCES `standard_field` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `standard_field_detail`
--

LOCK TABLES `standard_field_detail` WRITE;
/*!40000 ALTER TABLE `standard_field_detail` DISABLE KEYS */;
INSERT INTO `standard_field_detail` VALUES (1,'Action',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(2,'Adventure',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(3,'Comedy',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(4,'Fantasy',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(5,'Shounen',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(6,'Drama',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(7,'Sci-Fi',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(8,'Romance',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(9,'Ecchi',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(10,'Supernatural',1,1,0,0,'2022-07-22 02:24:10','2022-07-22 02:24:10'),(11,'On going',1,2,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(12,'Complete',1,2,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(13,'24 Minutes / Episode',1,3,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(14,'23 Minutes / Episode',1,3,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(15,'1 Hours / Episode',1,3,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(16,'360P',1,4,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(17,'480P',1,4,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(18,'720P',1,4,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(19,'1080P',1,4,0,0,'2022-07-22 02:25:02','2022-07-22 02:25:02'),(20,'Demon',1,1,0,0,NULL,NULL),(21,'Historical',1,1,0,0,NULL,NULL);
/*!40000 ALTER TABLE `standard_field_detail` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-08-11 15:58:27
