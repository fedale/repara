-- MariaDB dump 10.19  Distrib 10.6.5-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: database
-- ------------------------------------------------------
-- Server version	10.6.5-MariaDB-1:10.6.5+maria~focal

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `access_control`
--

DROP TABLE IF EXISTS `access_control`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `access_control` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `roles` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ips` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `host` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `methods` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `allow` smallint(6) NOT NULL DEFAULT 1,
  `sort` smallint(6) NOT NULL DEFAULT 0,
  `active` tinyint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `path` (`path`),
  KEY `host` (`host`),
  KEY `allow` (`allow`),
  KEY `sort` (`sort`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `access_control`
--

LOCK TABLES `access_control` WRITE;
/*!40000 ALTER TABLE `access_control` DISABLE KEYS */;
INSERT INTO `access_control` VALUES (1,'Login','^/admin/login','PUBLIC_ACCESS',NULL,NULL,NULL,1,0,1,'2022-01-02 10:07:17','2022-06-28 20:19:55'),(2,'Logout','^/admin/logout','PUBLIC_ACCESS',NULL,NULL,NULL,1,1,1,'2022-01-02 10:07:17','2022-06-28 20:20:04'),(4,'Admin area','^/','IS_AUTHENTICATED_FULLY',NULL,NULL,NULL,1,1000,1,'2022-06-28 19:46:44','2022-06-28 19:46:44');
/*!40000 ALTER TABLE `access_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset`
--

DROP TABLE IF EXISTS `asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `model_id` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `model_id` (`model_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  CONSTRAINT `FK_2AF5A5C7975B7E7` FOREIGN KEY (`model_id`) REFERENCES `asset_model` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=132 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset`
--

LOCK TABLES `asset` WRITE;
/*!40000 ALTER TABLE `asset` DISABLE KEYS */;
INSERT INTO `asset` VALUES (1,1,'Monitor Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:31:41',NULL),(2,3,'Laptop Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,4,'Laptop Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,5,'Tastiera scrivania Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(118,0,'61',1,'2021-04-22 06:20:55','2021-04-27 06:57:57',NULL),(119,0,'62',1,'2021-04-27 07:00:57','2021-07-08 04:12:55',NULL),(120,0,'61',1,'2021-04-27 20:18:49','2021-04-27 20:18:49',NULL),(121,0,'61',1,'2021-04-27 20:19:06','2021-07-08 04:12:55',NULL),(122,0,'61',1,'2021-04-27 20:19:19','2021-04-27 20:19:19',NULL),(123,0,'62',0,'2021-04-28 06:53:42','2021-07-08 04:26:30','2021-07-08 04:17:17'),(124,0,'61',1,'2021-07-08 04:43:04','2021-07-08 04:43:04',NULL),(125,0,'70',1,'2021-07-08 04:43:15','2021-07-08 04:43:15',NULL),(126,0,'71',1,'2021-07-08 04:43:26','2021-07-08 04:43:26',NULL),(127,0,'62',1,'2021-07-08 04:43:34','2021-07-11 06:48:35',NULL),(128,0,'65',-1,'2021-07-08 04:47:45','2021-07-08 04:49:09','2021-07-08 04:49:09'),(129,0,'71',0,'2021-07-08 04:52:03','2021-07-15 05:10:03',NULL),(130,0,'70',-1,'2021-07-09 03:40:45','2021-07-09 04:02:29','2021-07-09 04:02:29'),(131,0,'70',1,'2021-07-19 04:15:29','2021-07-20 03:50:06',NULL);
/*!40000 ALTER TABLE `asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_attachment`
--

DROP TABLE IF EXISTS `asset_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `path` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stuff_id` (`asset_id`),
  KEY `active` (`active`),
  KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `created_at` (`created_at`),
  KEY `path` (`path`),
  KEY `updated_at` (`updated_at`),
  KEY `size` (`size`),
  KEY `filename` (`filename`),
  CONSTRAINT `FK_BFBE3AE15DA1941` FOREIGN KEY (`asset_id`) REFERENCES `asset` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_attachment`
--

LOCK TABLES `asset_attachment` WRITE;
/*!40000 ALTER TABLE `asset_attachment` DISABLE KEYS */;
INSERT INTO `asset_attachment` VALUES (35,0,'123','image/png',20491,'/uploads/assets/123','V942ox8WWwRd4cwgsZ5lUsfPsAuU-j-h.png',1,'2021-07-08 04:21:30','2021-07-08 04:21:30',NULL),(36,3,'129','application/pdf',75349,'/uploads/assets/129','pVRsPd_MaazZrPwcY-Mi2NncE2ALAZN6.pdf',-1,'2021-07-09 03:41:10','2021-07-11 06:23:48','2021-07-11 06:23:48'),(37,2,'129','application/pdf',49207,'/uploads/assets/129','Ft5ue_N0t7PJghWTsoHuDkH9KSIaGnnW.pdf',1,'2021-07-11 05:49:07','2021-07-11 05:49:07',NULL),(38,5,'129','application/pdf',248171,'/uploads/assets/129','h6LAn4aiUDFlNlSx-Wbw-nVy71J30w5_.pdf',1,'2021-07-11 06:04:48','2021-07-11 06:04:48',NULL),(39,2,'126','application/pdf',49207,'/uploads/assets/126','QIXUPG1mw-0n95uGoYqqF5iosk2V4sB0.pdf',-1,'2021-07-11 06:47:21','2021-07-11 06:48:08','2021-07-11 06:48:08'),(40,7,'126','application/pdf',76524,'/uploads/assets/126','6OmVTe1_fgeIBs9xXhhQBzJC-MZD2PbY.pdf',-1,'2021-07-11 06:47:27','2021-07-11 06:47:39','2021-07-11 06:47:39'),(41,3,'127','application/pdf',241882,'/uploads/assets/127','zomh07WG_nkBr3ZMIuFYyYY04tEHV_Cq.pdf',-1,'2021-07-11 06:48:19','2021-07-11 06:48:24','2021-07-11 06:48:24'),(42,5,'127','application/pdf',248171,'/uploads/assets/127','scvaCoShdOcx9bXXqzKSphNME7BuUiMS.pdf',-1,'2021-07-11 06:48:19','2021-07-11 06:48:40','2021-07-11 06:48:40'),(43,8,'127','application/pdf',216391,'/uploads/assets/127','buQ5rexW12F5umR2DH8H13IVRDsNSXCA.pdf',1,'2021-07-11 06:48:19','2021-07-11 06:48:19',NULL),(44,9,'127','application/pdf',216236,'/uploads/assets/127','S5Akb3kYgrxrhNaEGCqcoEhZDS3bXH7_.pdf',1,'2021-07-11 07:02:58','2021-07-11 07:02:58',NULL),(45,3,'131','application/pdf',75349,'/uploads/assets/131','zXPHAhxnzJhC8Q-mmgZYno9s-ivfrFKX.pdf',1,'2021-07-19 04:18:25','2021-07-19 04:18:25',NULL);
/*!40000 ALTER TABLE `asset_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_brand`
--

DROP TABLE IF EXISTS `asset_brand`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_brand` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_brand`
--

LOCK TABLES `asset_brand` WRITE;
/*!40000 ALTER TABLE `asset_brand` DISABLE KEYS */;
INSERT INTO `asset_brand` VALUES (1,'Apple',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(2,'HP',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,'Lenovo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,'Dell',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(5,'Samsung',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(48,'Dell',1,'2021-04-22 06:18:14','2021-07-05 04:26:12',NULL),(49,'Apple',0,'2021-04-22 06:18:19','2021-07-05 04:14:24',NULL),(50,'Samsung',0,'2021-04-27 06:55:47','2021-07-05 04:14:24',NULL),(51,'HP',1,'2021-04-27 06:55:53','2021-07-05 04:26:25',NULL),(52,'Canon',0,'2021-04-27 06:56:09','2021-05-15 15:29:19',NULL),(53,'Minolta',-1,'2021-04-27 06:56:14','2021-07-05 04:28:13','2021-07-05 04:28:13'),(86,'qe',-1,'2021-04-29 06:45:48','2021-05-15 15:29:38','2021-05-15 01:29:38'),(87,'dadasdas',-1,'2021-04-29 06:48:57','2021-05-04 06:44:44','2021-05-04 04:44:44'),(107,'adsvdryr',-1,'2021-05-01 05:42:53','2021-05-04 06:44:42','2021-05-04 04:44:42'),(108,'eqweqwqew',-1,'2021-05-01 05:49:19','2021-05-02 07:01:57','2021-05-02 05:01:57'),(109,'sdfsdffdsdf',-1,'2021-05-01 05:49:27','2021-05-02 07:01:55','2021-05-02 05:01:55'),(110,'sdfsdffdsdf',-1,'2021-05-01 05:49:27','2021-05-02 07:01:52','2021-05-02 05:01:52'),(111,'aawwqwqwqww',-1,'2021-05-03 05:39:35','2021-05-04 06:44:39','2021-05-04 04:44:39'),(112,'wqesssdaqq',-1,'2021-06-01 06:58:13','2021-07-05 04:28:13','2021-07-05 04:28:13'),(113,'bbbbbbbbbbbbbbbba',-1,'2021-06-02 05:41:15','2021-07-05 04:28:06','2021-07-05 04:28:06'),(114,'new brande',-1,'2021-07-05 04:14:10','2021-07-05 04:28:06','2021-07-05 04:28:06'),(115,'dasdasda',-1,'2021-07-05 04:15:19','2021-07-05 04:28:06','2021-07-05 04:28:06'),(116,'my new brand',-1,'2021-07-05 04:15:29','2021-07-05 04:28:06','2021-07-05 04:28:06'),(117,'asdasdasd',-1,'2021-07-05 04:18:41','2021-07-05 04:28:06','2021-07-05 04:28:06'),(118,'sada',-1,'2021-07-05 04:22:29','2021-07-05 04:28:06','2021-07-05 04:28:06'),(119,'Brand da eliminare',-1,'2021-07-05 04:22:37','2021-07-05 04:27:59','2021-07-05 04:27:59'),(120,'My new brand222',1,'2021-07-05 04:31:20','2021-07-08 03:45:42',NULL),(121,'brand yeah',1,'2021-07-08 04:01:18','2021-07-08 04:01:18',NULL),(122,'sdfsdfs',1,'2021-07-13 17:19:11','2021-07-13 17:19:11',NULL),(123,'232323232323',1,'2021-07-13 17:19:18','2021-07-13 17:19:18',NULL),(124,'yrtyrtyrtyr',1,'2021-07-13 17:19:23','2021-07-13 17:19:23',NULL),(125,'new asset brand',1,'2021-07-19 04:32:03','2021-07-19 04:32:03',NULL),(126,'new asset brand #2 NOT active',1,'2021-07-19 04:32:32','2021-07-19 04:36:25',NULL);
/*!40000 ALTER TABLE `asset_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_model`
--

DROP TABLE IF EXISTS `asset_model`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_model` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `brand_id` smallint(5) unsigned DEFAULT NULL,
  `type_id` smallint(6) NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `created_at` (`created_at`),
  KEY `brand_id` (`brand_id`),
  KEY `updated_at` (`updated_at`),
  KEY `type_id` (`type_id`),
  KEY `active` (`active`),
  CONSTRAINT `FK_42CE5C9E44F5D008` FOREIGN KEY (`brand_id`) REFERENCES `asset_brand` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=74 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_model`
--

LOCK TABLES `asset_model` WRITE;
/*!40000 ALTER TABLE `asset_model` DISABLE KEYS */;
INSERT INTO `asset_model` VALUES (1,'Monitor 24',4,2,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(2,'Monitor 32',3,2,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,'Macbook Pro 13',1,5,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,'XPS 13',4,5,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(5,'Latitude 15',4,5,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(6,'Keyboard 105',5,3,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(7,'Mouse wireless',3,4,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(61,'Macbook Pro 13',49,82,0,'2021-04-22 06:20:44','2021-07-19 04:54:18',NULL),(62,'XPS 13',48,82,1,'2021-04-27 06:59:15','2021-04-27 06:59:15',NULL),(63,'Vostro',48,82,0,'2021-04-27 06:59:29','2021-07-19 04:54:16',NULL),(64,'S9',50,30,1,'2021-04-27 06:59:41','2021-07-06 04:13:49',NULL),(65,'LaserJet 1100',51,83,0,'2021-04-27 06:59:55','2021-07-19 04:54:15',NULL),(66,'Color Proof2',48,31,1,'2021-04-27 07:00:07','2021-07-06 04:08:34',NULL),(67,'XPS 1322',48,31,0,'2021-04-28 19:47:39','2021-07-19 04:54:14',NULL),(68,'new model asset',48,30,1,'2021-07-06 04:22:15','2021-07-06 04:22:15',NULL),(69,'new model asset 2',48,30,0,'2021-07-06 04:24:21','2021-07-19 04:54:12',NULL),(70,'new model asset 3',49,30,1,'2021-07-06 04:24:33','2021-07-08 03:37:51',NULL),(71,'new model asset 4',49,30,0,'2021-07-06 04:24:49','2021-07-19 04:54:11',NULL),(72,'nuovo modello di asset2',48,30,-1,'2021-07-08 03:38:59','2021-07-08 03:42:49','2021-07-08 03:42:49'),(73,'new model asset',48,33,1,'2021-07-19 04:41:44','2021-07-19 04:41:54',NULL);
/*!40000 ALTER TABLE `asset_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_type`
--

DROP TABLE IF EXISTS `asset_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_type` (
  `id` smallint(5) unsigned NOT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_type`
--

LOCK TABLES `asset_type` WRITE;
/*!40000 ALTER TABLE `asset_type` DISABLE KEYS */;
INSERT INTO `asset_type` VALUES (1,'Desktop Computer',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(2,'Monitor',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,'Keyboard',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,'Mouse',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(5,'Laptop',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(18,'terdfg',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(19,'dasdsad',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(20,'qqweeq2133danilo',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(21,'q',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(22,'wwwwww',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(23,'e',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(24,'r',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(25,'t',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(26,'ydqwq',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(28,'wqwqwqw',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(29,'rrrrrrr',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(30,'qweqweqeqe111111',1,'2021-07-17 04:10:40','2021-07-19 04:27:23',NULL),(31,'new brand',1,'2021-07-17 04:10:40','2021-07-19 04:27:27',NULL),(32,'aaa',1,'2021-07-17 04:10:40','2021-07-19 04:27:30',NULL),(33,'my new asset type2',1,'2021-07-17 04:10:40','2021-07-19 04:27:33',NULL),(34,'New type of asset',1,'2021-07-19 04:28:02','2021-07-19 04:28:02',NULL),(35,'new type of asset #2',1,'2021-07-19 04:28:38','2021-07-19 04:28:38',NULL),(36,'new asset type 3',1,'2021-07-19 04:29:11','2021-10-11 19:46:20',NULL);
/*!40000 ALTER TABLE `asset_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `craue_config_setting`
--

DROP TABLE IF EXISTS `craue_config_setting`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `craue_config_setting` (
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `craue_config_setting`
--

LOCK TABLES `craue_config_setting` WRITE;
/*!40000 ALTER TABLE `craue_config_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `craue_config_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer`
--

DROP TABLE IF EXISTS `customer`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` smallint(5) unsigned NOT NULL DEFAULT 1,
  `confirmed_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `blocked_at` datetime DEFAULT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `type_id` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'','customer1','customer1@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(2,'','customer2','customer2@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(3,'','customer3','customer3@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(4,'','customer4','customer4@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(5,'dada','dada','dada','$2y$13$j8Cwt4d1yArJJVwxk0ZdDuqmDQTo9M7aru4Lp5U.2ZKXbBoCVEdq.',NULL,NULL,1,NULL,NULL,NULL,1,'2022-06-28 21:03:28','2022-06-28 21:03:28',NULL),(7,'dada2','dada2','dada@gmai.lc','$2y$13$U3U90Yw1joE68Ew6jAl6ZuaSVsZjvzV.Tct0zUiHpBMO73qC.fmjC',NULL,NULL,1,NULL,NULL,NULL,1,'2022-06-28 21:03:53','2022-06-28 21:03:53',NULL);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_attachment`
--

DROP TABLE IF EXISTS `customer_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `path` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stuff_id` (`customer_id`),
  KEY `active` (`active`),
  KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `created_at` (`created_at`),
  KEY `type_2` (`type`),
  KEY `path` (`path`),
  KEY `updated_at` (`updated_at`),
  KEY `size` (`size`),
  KEY `filename` (`filename`),
  CONSTRAINT `FK_8496DD399395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_attachment`
--

LOCK TABLES `customer_attachment` WRITE;
/*!40000 ALTER TABLE `customer_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_contact`
--

DROP TABLE IF EXISTS `customer_contact`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_contact` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(10) unsigned DEFAULT NULL,
  `firstname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`,`location_id`),
  UNIQUE KEY `phone` (`phone`,`location_id`),
  KEY `active` (`active`),
  KEY `firstname` (`firstname`),
  KEY `created_at` (`created_at`),
  KEY `lastname` (`lastname`),
  KEY `updated_at` (`updated_at`),
  KEY `location_id` (`location_id`),
  CONSTRAINT `FK_50BF428664D218E` FOREIGN KEY (`location_id`) REFERENCES `customer_location` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_contact`
--

LOCK TABLES `customer_contact` WRITE;
/*!40000 ALTER TABLE `customer_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_location`
--

DROP TABLE IF EXISTS `customer_location`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_location` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `address` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `zipcode` varchar(8) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `city` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'Italia',
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`customer_id`),
  KEY `active` (`active`),
  KEY `name` (`address`),
  KEY `created_at` (`created_at`),
  KEY `city` (`city`),
  KEY `updated_at` (`updated_at`),
  KEY `zipcode` (`zipcode`),
  CONSTRAINT `FK_725BCAE49395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_location`
--

LOCK TABLES `customer_location` WRITE;
/*!40000 ALTER TABLE `customer_location` DISABLE KEYS */;
INSERT INTO `customer_location` VALUES (1,NULL,'nome location','via piaggio 26','65100','pescara','Italia',1,'2022-06-30 19:16:14','2022-06-30 19:16:14',NULL);
/*!40000 ALTER TABLE `customer_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_location_place`
--

DROP TABLE IF EXISTS `customer_location_place`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_location_place` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `location_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `customer_id` (`location_id`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `FK_9B2C222264D218E` FOREIGN KEY (`location_id`) REFERENCES `customer_location` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_location_place`
--

LOCK TABLES `customer_location_place` WRITE;
/*!40000 ALTER TABLE `customer_location_place` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_location_place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_location_place_asset`
--

DROP TABLE IF EXISTS `customer_location_place_asset`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_location_place_asset` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_place_id` int(10) unsigned NOT NULL,
  `asset_id` int(10) unsigned NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `active` (`active`),
  KEY `asset_id` (`asset_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_location_place_asset`
--

LOCK TABLES `customer_location_place_asset` WRITE;
/*!40000 ALTER TABLE `customer_location_place_asset` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_location_place_asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_location_place_asset_attachment`
--

DROP TABLE IF EXISTS `customer_location_place_asset_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_location_place_asset_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_location_place_asset_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `path` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `stuff_id` (`customer_location_place_asset_id`),
  KEY `active` (`active`),
  KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `created_at` (`created_at`),
  KEY `type_2` (`type`),
  KEY `path` (`path`),
  KEY `updated_at` (`updated_at`),
  KEY `size` (`size`),
  KEY `filename` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_location_place_asset_attachment`
--

LOCK TABLES `customer_location_place_asset_attachment` WRITE;
/*!40000 ALTER TABLE `customer_location_place_asset_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_location_place_asset_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `customer_profile`
--

DROP TABLE IF EXISTS `customer_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `customer_profile` (
  `customer_id` int(10) unsigned NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'settings preferences',
  PRIMARY KEY (`customer_id`),
  CONSTRAINT `FK_9D8A0EB1A76ED395` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `customer_profile`
--

LOCK TABLES `customer_profile` WRITE;
/*!40000 ALTER TABLE `customer_profile` DISABLE KEYS */;
INSERT INTO `customer_profile` VALUES (1,'Steve','Jungen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Roberto','Salvini',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Lucio','Giacomi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Marco','Martioli',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `customer_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctrine_migration_versions`
--

DROP TABLE IF EXISTS `doctrine_migration_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctrine_migration_versions` (
  `version` varchar(191) COLLATE utf8mb3_unicode_ci NOT NULL,
  `executed_at` datetime DEFAULT NULL,
  `execution_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`version`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3 COLLATE=utf8mb3_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification`
--

DROP TABLE IF EXISTS `notification`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notification_entity_id` int(10) unsigned DEFAULT NULL,
  `entity_id` int(10) unsigned DEFAULT NULL COMMENT 'NULL with deleted entities',
  `message` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `entity_type_id` (`notification_entity_id`),
  KEY `updated_at` (`updated_at`),
  KEY `entity_id` (`entity_id`),
  KEY `active` (`status`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `FK_BF5476CA27CC3A02` FOREIGN KEY (`notification_entity_id`) REFERENCES `notification_entity` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_entity`
--

DROP TABLE IF EXISTS `notification_entity`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_entity` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'post,comment,task,template',
  `action` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subject` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `template` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `subject` (`subject`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_entity`
--

LOCK TABLES `notification_entity` WRITE;
/*!40000 ALTER TABLE `notification_entity` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notification_item`
--

DROP TABLE IF EXISTS `notification_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notification_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `notification_id` int(10) unsigned DEFAULT NULL,
  `recipient_id` int(10) unsigned DEFAULT NULL,
  `sender_id` int(10) unsigned NOT NULL,
  `status` smallint(6) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `notification_id` (`notification_id`),
  KEY `sender_id` (`sender_id`),
  KEY `recipient_id` (`recipient_id`),
  KEY `status` (`status`),
  CONSTRAINT `FK_A7276E24EF1A9D84` FOREIGN KEY (`notification_id`) REFERENCES `notification` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notification_item`
--

LOCK TABLES `notification_item` WRITE;
/*!40000 ALTER TABLE `notification_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project`
--

DROP TABLE IF EXISTS `project`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime_start` datetime DEFAULT NULL,
  `datetime_end` datetime DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '''0''',
  `budget` decimal(15,2) DEFAULT NULL,
  `color` char(6) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `priority` tinyint(1) NOT NULL,
  `visible` tinyint(1) NOT NULL DEFAULT 1,
  `created_by` int(10) unsigned NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `finished_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `updated_at` (`updated_at`),
  KEY `priority` (`priority`),
  KEY `status` (`status`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `created_by` (`created_by`),
  KEY `budget` (`budget`),
  KEY `datetime_start` (`datetime_start`),
  KEY `visible` (`visible`),
  KEY `created_at` (`created_at`),
  KEY `color` (`color`),
  KEY `datetime_end` (`datetime_end`)
) ENGINE=InnoDB AUTO_INCREMENT=284 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (268,'P-567','Controllo Mensile Computer ',NULL,'2021-04-04 06:06:00','2021-04-29 08:30:00','current',NULL,NULL,0,1,1,27,'2021-04-04 08:17:32','2021-04-04 08:17:32',NULL,NULL),(269,'P-582','Pulizia PC',NULL,'2021-04-22 04:33:00','2021-05-06 22:50:00','current',NULL,NULL,0,1,1,27,'2021-04-22 22:39:53','2021-04-22 22:39:53',NULL,NULL),(270,'P-583','Pulizia PC',NULL,'2021-04-24 05:02:00','2021-05-09 23:50:00','current',NULL,NULL,0,1,1,27,'2021-04-25 09:34:13','2021-04-25 09:34:13',NULL,NULL),(271,'P-580','Pulizia PC',NULL,'2021-04-25 07:36:00','2021-05-08 09:00:00','current',NULL,NULL,0,1,1,27,'2021-04-25 09:38:54','2021-04-25 09:38:54',NULL,NULL),(272,'P-575','Pulizia PC',NULL,'2021-04-25 09:23:00','2021-05-09 23:20:00','current',NULL,NULL,0,1,1,27,'2021-04-25 11:23:36','2021-04-25 11:23:36',NULL,NULL),(273,'P-584','Formattazione PC',NULL,'2021-04-25 10:08:00','2021-05-08 12:10:00','current',NULL,NULL,0,1,1,27,'2021-04-25 12:13:33','2021-04-25 12:13:33',NULL,NULL),(274,'P-585','Formattazione PC',NULL,'2021-04-25 13:53:00','2021-05-08 15:25:00','current',NULL,NULL,0,1,1,27,'2021-04-25 15:54:54','2021-04-25 15:54:54',NULL,NULL),(275,'P-586','Formattazione PC',NULL,'2021-04-01 13:45:00','2021-05-08 23:55:00','current',NULL,NULL,0,1,1,27,'2021-04-25 16:00:04','2021-04-25 16:00:04',NULL,NULL),(276,'P-610','Pulizia PC',NULL,'2021-04-27 03:59:00','2021-05-09 05:45:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:00:09','2021-04-27 06:00:09',NULL,NULL),(277,'P-612','Pulizia PC',NULL,'2021-04-27 04:05:00','2021-05-09 06:05:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:06:05','2021-04-27 06:06:05',NULL,NULL),(278,'P-613','Pulizia PC',NULL,'2021-04-27 04:07:00','2021-05-09 23:05:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:08:11','2021-04-27 06:08:11',NULL,NULL),(279,'P-614','Pulizia PC',NULL,'2021-04-27 04:38:00','2021-05-09 06:35:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:39:05','2021-04-27 06:39:05',NULL,NULL),(280,'P-615','Formattazione PC',NULL,'2021-04-27 04:43:00','2021-05-09 06:50:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:43:41','2021-04-27 06:43:41',NULL,NULL),(281,'P-616','Pulizia PC',NULL,'2021-04-27 04:44:00','2021-05-09 23:50:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:45:09','2021-04-27 06:45:09',NULL,NULL),(282,'P-617','Pulizia PC',NULL,'2021-04-27 04:47:00','2021-05-09 23:45:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:47:37','2021-04-27 06:47:37',NULL,NULL),(283,'P-629','Formattazione PC',NULL,'2021-05-21 03:35:00','2021-05-28 07:50:00','current',NULL,NULL,0,1,1,27,'2021-05-21 07:01:14','2021-05-21 07:01:14',NULL,NULL);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_milestone`
--

DROP TABLE IF EXISTS `project_milestone`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_milestone` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration_date` datetime NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_milestone`
--

LOCK TABLES `project_milestone` WRITE;
/*!40000 ALTER TABLE `project_milestone` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_milestone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_milestone_task`
--

DROP TABLE IF EXISTS `project_milestone_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_milestone_task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `milestone_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `milestone_it` (`milestone_id`),
  KEY `task_it` (`task_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_milestone_task`
--

LOCK TABLES `project_milestone_task` WRITE;
/*!40000 ALTER TABLE `project_milestone_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_milestone_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task`
--

DROP TABLE IF EXISTS `project_task`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `customer_id` int(10) unsigned DEFAULT NULL,
  `customer_location_place_asset_id` int(10) unsigned DEFAULT NULL,
  `project_id` int(10) unsigned DEFAULT NULL,
  `type_id` smallint(5) unsigned DEFAULT NULL,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `asset_type` varchar(8) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N/A' COMMENT 'Update with assetType value',
  `priority` smallint(6) NOT NULL,
  `visible` smallint(6) NOT NULL DEFAULT 1,
  `created_by` int(11) NOT NULL,
  `finished_at` datetime DEFAULT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `created_on` (`created_at`),
  KEY `type_id` (`type_id`),
  KEY `status` (`status`),
  KEY `visible` (`visible`),
  KEY `updated_at` (`updated_at`),
  KEY `priority` (`priority`),
  KEY `project_id` (`project_id`),
  KEY `customer_location_place_asset_id` (`customer_location_place_asset_id`),
  KEY `stuff_type` (`asset_type`),
  KEY `created_by` (`created_by`),
  KEY `place_id` (`customer_id`),
  CONSTRAINT `FK_6BEF133D166D1F9C` FOREIGN KEY (`project_id`) REFERENCES `project` (`id`),
  CONSTRAINT `FK_6BEF133D9395C3F3` FOREIGN KEY (`customer_id`) REFERENCES `customer` (`id`),
  CONSTRAINT `FK_6BEF133DC54C8C93` FOREIGN KEY (`type_id`) REFERENCES `project_task_type` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task`
--

LOCK TABLES `project_task` WRITE;
/*!40000 ALTER TABLE `project_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_assigned`
--

DROP TABLE IF EXISTS `project_task_assigned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_assigned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `updated_at` (`updated_at`),
  KEY `task_item_id` (`task_id`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_assigned`
--

LOCK TABLES `project_task_assigned` WRITE;
/*!40000 ALTER TABLE `project_task_assigned` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_assigned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_attachment`
--

DROP TABLE IF EXISTS `project_task_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `project_task_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'image',
  `size` int(10) unsigned NOT NULL,
  `path` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_task_id` (`project_task_id`),
  KEY `active` (`active`),
  KEY `size` (`size`),
  KEY `path` (`path`),
  KEY `created_at` (`created_at`),
  KEY `type_3` (`type`),
  KEY `filename` (`filename`),
  KEY `updated_at` (`updated_at`),
  KEY `user_id` (`user_id`),
  KEY `name` (`name`),
  CONSTRAINT `FK_5D7DE7E41BA80DE3` FOREIGN KEY (`project_task_id`) REFERENCES `project_task` (`id`),
  CONSTRAINT `FK_5D7DE7E4A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_attachment`
--

LOCK TABLES `project_task_attachment` WRITE;
/*!40000 ALTER TABLE `project_task_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_item`
--

DROP TABLE IF EXISTS `project_task_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `difficulty` tinyint(1) NOT NULL,
  `value` char(1) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `datetime_start` datetime DEFAULT NULL,
  `datetime_end` datetime DEFAULT NULL,
  `task_id` int(10) unsigned NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `updated_at` (`updated_at`),
  KEY `value` (`value`),
  KEY `datetime_start` (`datetime_start`),
  KEY `difficulty` (`difficulty`),
  KEY `active` (`active`),
  KEY `datetime_end` (`datetime_end`),
  KEY `created_at` (`created_at`),
  KEY `task_id` (`task_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_item`
--

LOCK TABLES `project_task_item` WRITE;
/*!40000 ALTER TABLE `project_task_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_item_assigned`
--

DROP TABLE IF EXISTS `project_task_item_assigned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_item_assigned` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `task_item_id` int(10) unsigned DEFAULT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  KEY `updated_at` (`updated_at`),
  KEY `task_item_id` (`task_item_id`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`),
  CONSTRAINT `FK_94D23761A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_94D23761D8E78B4` FOREIGN KEY (`task_item_id`) REFERENCES `project_task_item` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_item_assigned`
--

LOCK TABLES `project_task_item_assigned` WRITE;
/*!40000 ALTER TABLE `project_task_item_assigned` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_item_assigned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_template`
--

DROP TABLE IF EXISTS `project_task_template`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_template` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_template`
--

LOCK TABLES `project_task_template` WRITE;
/*!40000 ALTER TABLE `project_task_template` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_template_item`
--

DROP TABLE IF EXISTS `project_task_template_item`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_template_item` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `task_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `task_type_id` smallint(5) unsigned NOT NULL DEFAULT 1,
  `sort` smallint(8) NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `task_id` (`task_id`),
  KEY `task_type_id` (`task_type_id`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`),
  KEY `sort` (`sort`),
  CONSTRAINT `FK_39903C438DB60186` FOREIGN KEY (`task_id`) REFERENCES `project_task_template` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_template_item`
--

LOCK TABLES `project_task_template_item` WRITE;
/*!40000 ALTER TABLE `project_task_template_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_template_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_task_type`
--

DROP TABLE IF EXISTS `project_task_type`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_task_type` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`),
  KEY `active` (`active`),
  KEY `created_at` (`created_at`),
  KEY `updated_at` (`updated_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_task_type`
--

LOCK TABLES `project_task_type` WRITE;
/*!40000 ALTER TABLE `project_task_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user`
--

DROP TABLE IF EXISTS `user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `confirmed_at` int(11) DEFAULT NULL,
  `unconfirmed_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `blocked_at` int(11) DEFAULT NULL,
  `registration_ip` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_id` smallint(5) unsigned DEFAULT 1,
  `active` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  `last_login_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `email` (`email`),
  KEY `type_id` (`type_id`),
  KEY `active` (`active`)
) ENGINE=InnoDB AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'danilo','danilo@gmail.com','$2y$13$8JERmrysMTvPaWxDUfXROebampc0NXFLwZqNrEMXHwC7rzSzMasM6',NULL,NULL,NULL,NULL,1,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL,NULL),(2,'admin','admin@gmail.com','$2y$13$/yq8h/hWOVorhIQ71VyYheAFml6aDt.AeEQX/axE9Xa/nj3k0pXaK',NULL,NULL,NULL,NULL,1,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL,NULL),(3,'federico','federico@dimoia.com','$2y$13$eO7f/1t.G8CPry0DhaA0uOHZ7sn77WHsLPo3P30u6Kv3plAZdV19K',NULL,NULL,NULL,NULL,1,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL,NULL),(14,'admin111','zitter@gmail.com','$2y$13$86Q0HnwbrWf6TMnblYhoJeEoRsSsKgMBwew2s0hTt1RgVloSBMrlq',NULL,NULL,NULL,NULL,1,1,'2022-06-29 17:24:04','2022-06-29 17:24:04',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_customer_assigned`
--

DROP TABLE IF EXISTS `user_customer_assigned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_customer_assigned` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `customer_id` int(10) unsigned NOT NULL,
  `customer_location_id` int(10) unsigned DEFAULT NULL,
  `customer_location_place_id` int(10) unsigned DEFAULT NULL,
  `customer_location_place_asset_id` int(10) unsigned DEFAULT NULL,
  `active` smallint(8) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customer_id_2` (`customer_id`,`customer_location_id`,`customer_location_place_id`,`customer_location_place_asset_id`,`user_id`),
  KEY `updated_at` (`updated_at`),
  KEY `user_id` (`user_id`),
  KEY `customer_location` (`customer_location_id`),
  KEY `active` (`active`),
  KEY `customer_location_place` (`customer_location_place_id`),
  KEY `created_at` (`created_at`),
  KEY `customer_location_place_asset` (`customer_location_place_asset_id`),
  KEY `customer_id` (`customer_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_customer_assigned`
--

LOCK TABLES `user_customer_assigned` WRITE;
/*!40000 ALTER TABLE `user_customer_assigned` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_customer_assigned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_attachment`
--

DROP TABLE IF EXISTS `user_attachment`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_attachment` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `size` int(10) unsigned NOT NULL,
  `path` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `filename` varchar(128) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `path` (`path`),
  KEY `updated_at` (`updated_at`),
  KEY `size` (`size`),
  KEY `filename` (`filename`),
  KEY `stuff_id` (`user_id`),
  KEY `active` (`active`),
  KEY `name` (`name`),
  KEY `type` (`type`),
  KEY `created_at` (`created_at`),
  KEY `type_2` (`type`),
  CONSTRAINT `FK_DE381F57A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_attachment`
--

LOCK TABLES `user_attachment` WRITE;
/*!40000 ALTER TABLE `user_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_group`
--

DROP TABLE IF EXISTS `user_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_group` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,'Group one','group-1'),(2,'Group two','group-2'),(3,'Group three','group-3'),(4,'Group four','group-4');
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_profile`
--

DROP TABLE IF EXISTS `user_profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_profile` (
  `user_id` int(10) unsigned NOT NULL,
  `firstname` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `lastname` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `public_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravatar_email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `gravatar_id` varchar(32) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `website` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bio` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `timezone` varchar(40) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `setting` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT 'settings like notifications',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `FK_D95AB405A76ED395` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (1,'Danilo','Di Moia',NULL,NULL,NULL,'Chieti, Italia',NULL,NULL,'Europe/Rome',NULL),(2,'Gabriella','Castagna',NULL,NULL,NULL,'Chieti, Italia',NULL,NULL,'Europe/Rome',NULL),(3,'Federico','Rampini',NULL,NULL,NULL,'Chieti, Italia',NULL,NULL,'Europe/Rome',NULL);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role`
--

DROP TABLE IF EXISTS `user_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `code` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `name` (`name`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'Engineer','ROLE_ENGINEER'),(2,'Helpdesk','ROLE_HELPDESK'),(3,'Area leader','ROLE_LEADAREA'),(4,'Admin','ROLE_ADMIN');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_role_assigned`
--

DROP TABLE IF EXISTS `user_role_assigned`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_role_assigned` (
  `user_id` int(10) unsigned NOT NULL,
  `role_id` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`user_id`,`role_id`),
  KEY `FK_D95AB405A76ED397` (`role_id`),
  CONSTRAINT `FK_D95AB405A76ED396` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`),
  CONSTRAINT `FK_D95AB405A76ED397` FOREIGN KEY (`role_id`) REFERENCES `user_role` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_role_assigned`
--

LOCK TABLES `user_role_assigned` WRITE;
/*!40000 ALTER TABLE `user_role_assigned` DISABLE KEYS */;
INSERT INTO `user_role_assigned` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `user_role_assigned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `website`
--

DROP TABLE IF EXISTS `website`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `website` (
  `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `default_group_id` int(11) NOT NULL,
  `sort` smallint(6) NOT NULL DEFAULT 0,
  `active` smallint(6) NOT NULL DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  KEY `active` (`active`),
  KEY `default_group_id` (`default_group_id`),
  KEY `sort` (`sort`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `website`
--

LOCK TABLES `website` WRITE;
/*!40000 ALTER TABLE `website` DISABLE KEYS */;
INSERT INTO `website` VALUES (1,'website-1','Website 1',1,0,1,'2022-01-02 10:07:16','2022-01-15 05:49:44',NULL),(2,'website-2','Website 2',1,0,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,'website-3','Website 3',1,0,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,'website-4','Website 4',1,0,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL);
/*!40000 ALTER TABLE `website` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-30 19:57:02
