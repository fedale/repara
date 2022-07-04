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
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `access_control`
--

LOCK TABLES `access_control` WRITE;
/*!40000 ALTER TABLE `access_control` DISABLE KEYS */;
INSERT INTO `access_control` VALUES (1,'Login','^/admin/login','PUBLIC_ACCESS',NULL,NULL,NULL,1,0,1,'2022-01-02 10:07:17','2022-06-28 20:19:55'),(2,'Logout','^/admin/logout','PUBLIC_ACCESS',NULL,NULL,NULL,1,1,1,'2022-01-02 10:07:17','2022-06-28 20:20:04'),(4,'Admin area','^/','IS_AUTHENTICATED_FULLY',NULL,NULL,NULL,1,1000,1,'2022-06-28 19:46:44','2022-06-28 19:46:44');
/*!40000 ALTER TABLE `access_control` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `asset`
--

LOCK TABLES `asset` WRITE;
/*!40000 ALTER TABLE `asset` DISABLE KEYS */;
INSERT INTO `asset` VALUES (1,1,'Monitor Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:31:41',NULL),(2,3,'Laptop Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,4,'Laptop Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,5,'Tastiera scrivania Danilo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(118,0,'61',1,'2021-04-22 06:20:55','2021-04-27 06:57:57',NULL),(119,0,'62',1,'2021-04-27 07:00:57','2021-07-08 04:12:55',NULL),(120,0,'61',1,'2021-04-27 20:18:49','2021-04-27 20:18:49',NULL),(121,0,'61',1,'2021-04-27 20:19:06','2021-07-08 04:12:55',NULL),(122,0,'61',1,'2021-04-27 20:19:19','2021-04-27 20:19:19',NULL),(123,0,'62',0,'2021-04-28 06:53:42','2021-07-08 04:26:30','2021-07-08 04:17:17'),(124,0,'61',1,'2021-07-08 04:43:04','2021-07-08 04:43:04',NULL),(125,0,'70',1,'2021-07-08 04:43:15','2021-07-08 04:43:15',NULL),(126,0,'71',1,'2021-07-08 04:43:26','2021-07-08 04:43:26',NULL),(127,0,'62',1,'2021-07-08 04:43:34','2021-07-11 06:48:35',NULL),(128,0,'65',-1,'2021-07-08 04:47:45','2021-07-08 04:49:09','2021-07-08 04:49:09'),(129,0,'71',0,'2021-07-08 04:52:03','2021-07-15 05:10:03',NULL),(130,0,'70',-1,'2021-07-09 03:40:45','2021-07-09 04:02:29','2021-07-09 04:02:29'),(131,0,'70',1,'2021-07-19 04:15:29','2021-07-20 03:50:06',NULL);
/*!40000 ALTER TABLE `asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `asset_attachment`
--

LOCK TABLES `asset_attachment` WRITE;
/*!40000 ALTER TABLE `asset_attachment` DISABLE KEYS */;
INSERT INTO `asset_attachment` VALUES (35,0,'123','image/png',20491,'/uploads/assets/123','V942ox8WWwRd4cwgsZ5lUsfPsAuU-j-h.png',1,'2021-07-08 04:21:30','2021-07-08 04:21:30',NULL),(36,3,'129','application/pdf',75349,'/uploads/assets/129','pVRsPd_MaazZrPwcY-Mi2NncE2ALAZN6.pdf',-1,'2021-07-09 03:41:10','2021-07-11 06:23:48','2021-07-11 06:23:48'),(37,2,'129','application/pdf',49207,'/uploads/assets/129','Ft5ue_N0t7PJghWTsoHuDkH9KSIaGnnW.pdf',1,'2021-07-11 05:49:07','2021-07-11 05:49:07',NULL),(38,5,'129','application/pdf',248171,'/uploads/assets/129','h6LAn4aiUDFlNlSx-Wbw-nVy71J30w5_.pdf',1,'2021-07-11 06:04:48','2021-07-11 06:04:48',NULL),(39,2,'126','application/pdf',49207,'/uploads/assets/126','QIXUPG1mw-0n95uGoYqqF5iosk2V4sB0.pdf',-1,'2021-07-11 06:47:21','2021-07-11 06:48:08','2021-07-11 06:48:08'),(40,7,'126','application/pdf',76524,'/uploads/assets/126','6OmVTe1_fgeIBs9xXhhQBzJC-MZD2PbY.pdf',-1,'2021-07-11 06:47:27','2021-07-11 06:47:39','2021-07-11 06:47:39'),(41,3,'127','application/pdf',241882,'/uploads/assets/127','zomh07WG_nkBr3ZMIuFYyYY04tEHV_Cq.pdf',-1,'2021-07-11 06:48:19','2021-07-11 06:48:24','2021-07-11 06:48:24'),(42,5,'127','application/pdf',248171,'/uploads/assets/127','scvaCoShdOcx9bXXqzKSphNME7BuUiMS.pdf',-1,'2021-07-11 06:48:19','2021-07-11 06:48:40','2021-07-11 06:48:40'),(43,8,'127','application/pdf',216391,'/uploads/assets/127','buQ5rexW12F5umR2DH8H13IVRDsNSXCA.pdf',1,'2021-07-11 06:48:19','2021-07-11 06:48:19',NULL),(44,9,'127','application/pdf',216236,'/uploads/assets/127','S5Akb3kYgrxrhNaEGCqcoEhZDS3bXH7_.pdf',1,'2021-07-11 07:02:58','2021-07-11 07:02:58',NULL),(45,3,'131','application/pdf',75349,'/uploads/assets/131','zXPHAhxnzJhC8Q-mmgZYno9s-ivfrFKX.pdf',1,'2021-07-19 04:18:25','2021-07-19 04:18:25',NULL);
/*!40000 ALTER TABLE `asset_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `asset_brand`
--

LOCK TABLES `asset_brand` WRITE;
/*!40000 ALTER TABLE `asset_brand` DISABLE KEYS */;
INSERT INTO `asset_brand` VALUES (1,'Apple',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(2,'HP',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,'Lenovo',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,'Dell',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(5,'Samsung',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(48,'Dell',1,'2021-04-22 06:18:14','2021-07-05 04:26:12',NULL),(49,'Apple',0,'2021-04-22 06:18:19','2021-07-05 04:14:24',NULL),(50,'Samsung',0,'2021-04-27 06:55:47','2021-07-05 04:14:24',NULL),(51,'HP',1,'2021-04-27 06:55:53','2021-07-05 04:26:25',NULL),(52,'Canon',0,'2021-04-27 06:56:09','2021-05-15 15:29:19',NULL),(53,'Minolta',-1,'2021-04-27 06:56:14','2021-07-05 04:28:13','2021-07-05 04:28:13'),(86,'qe',-1,'2021-04-29 06:45:48','2021-05-15 15:29:38','2021-05-15 01:29:38'),(87,'dadasdas',-1,'2021-04-29 06:48:57','2021-05-04 06:44:44','2021-05-04 04:44:44'),(107,'adsvdryr',-1,'2021-05-01 05:42:53','2021-05-04 06:44:42','2021-05-04 04:44:42'),(108,'eqweqwqew',-1,'2021-05-01 05:49:19','2021-05-02 07:01:57','2021-05-02 05:01:57'),(109,'sdfsdffdsdf',-1,'2021-05-01 05:49:27','2021-05-02 07:01:55','2021-05-02 05:01:55'),(110,'sdfsdffdsdf',-1,'2021-05-01 05:49:27','2021-05-02 07:01:52','2021-05-02 05:01:52'),(111,'aawwqwqwqww',-1,'2021-05-03 05:39:35','2021-05-04 06:44:39','2021-05-04 04:44:39'),(112,'wqesssdaqq',-1,'2021-06-01 06:58:13','2021-07-05 04:28:13','2021-07-05 04:28:13'),(113,'bbbbbbbbbbbbbbbba',-1,'2021-06-02 05:41:15','2021-07-05 04:28:06','2021-07-05 04:28:06'),(114,'new brande',-1,'2021-07-05 04:14:10','2021-07-05 04:28:06','2021-07-05 04:28:06'),(115,'dasdasda',-1,'2021-07-05 04:15:19','2021-07-05 04:28:06','2021-07-05 04:28:06'),(116,'my new brand',-1,'2021-07-05 04:15:29','2021-07-05 04:28:06','2021-07-05 04:28:06'),(117,'asdasdasd',-1,'2021-07-05 04:18:41','2021-07-05 04:28:06','2021-07-05 04:28:06'),(118,'sada',-1,'2021-07-05 04:22:29','2021-07-05 04:28:06','2021-07-05 04:28:06'),(119,'Brand da eliminare',-1,'2021-07-05 04:22:37','2021-07-05 04:27:59','2021-07-05 04:27:59'),(120,'My new brand222',1,'2021-07-05 04:31:20','2021-07-08 03:45:42',NULL),(121,'brand yeah',1,'2021-07-08 04:01:18','2021-07-08 04:01:18',NULL),(122,'sdfsdfs',1,'2021-07-13 17:19:11','2021-07-13 17:19:11',NULL),(123,'232323232323',1,'2021-07-13 17:19:18','2021-07-13 17:19:18',NULL),(124,'yrtyrtyrtyr',1,'2021-07-13 17:19:23','2021-07-13 17:19:23',NULL),(125,'new asset brand',1,'2021-07-19 04:32:03','2021-07-19 04:32:03',NULL),(126,'new asset brand #2 NOT active',1,'2021-07-19 04:32:32','2021-07-19 04:36:25',NULL);
/*!40000 ALTER TABLE `asset_brand` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `asset_model`
--

LOCK TABLES `asset_model` WRITE;
/*!40000 ALTER TABLE `asset_model` DISABLE KEYS */;
INSERT INTO `asset_model` VALUES (1,'Monitor 24',4,2,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(2,'Monitor 32',3,2,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,'Macbook Pro 13',1,5,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,'XPS 13',4,5,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(5,'Latitude 15',4,5,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(6,'Keyboard 105',5,3,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(7,'Mouse wireless',3,4,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(61,'Macbook Pro 13',49,82,0,'2021-04-22 06:20:44','2021-07-19 04:54:18',NULL),(62,'XPS 13',48,82,1,'2021-04-27 06:59:15','2021-04-27 06:59:15',NULL),(63,'Vostro',48,82,0,'2021-04-27 06:59:29','2021-07-19 04:54:16',NULL),(64,'S9',50,30,1,'2021-04-27 06:59:41','2021-07-06 04:13:49',NULL),(65,'LaserJet 1100',51,83,0,'2021-04-27 06:59:55','2021-07-19 04:54:15',NULL),(66,'Color Proof2',48,31,1,'2021-04-27 07:00:07','2021-07-06 04:08:34',NULL),(67,'XPS 1322',48,31,0,'2021-04-28 19:47:39','2021-07-19 04:54:14',NULL),(68,'new model asset',48,30,1,'2021-07-06 04:22:15','2021-07-06 04:22:15',NULL),(69,'new model asset 2',48,30,0,'2021-07-06 04:24:21','2021-07-19 04:54:12',NULL),(70,'new model asset 3',49,30,1,'2021-07-06 04:24:33','2021-07-08 03:37:51',NULL),(71,'new model asset 4',49,30,0,'2021-07-06 04:24:49','2021-07-19 04:54:11',NULL),(72,'nuovo modello di asset2',48,30,-1,'2021-07-08 03:38:59','2021-07-08 03:42:49','2021-07-08 03:42:49'),(73,'new model asset',48,33,1,'2021-07-19 04:41:44','2021-07-19 04:41:54',NULL);
/*!40000 ALTER TABLE `asset_model` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `asset_type`
--

LOCK TABLES `asset_type` WRITE;
/*!40000 ALTER TABLE `asset_type` DISABLE KEYS */;
INSERT INTO `asset_type` VALUES (1,'Desktop Computer',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(2,'Monitor',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(3,'Keyboard',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(4,'Mouse',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(5,'Laptop',1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL),(18,'terdfg',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(19,'dasdsad',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(20,'qqweeq2133danilo',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(21,'q',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(22,'wwwwww',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(23,'e',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(24,'r',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(25,'t',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(26,'ydqwq',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(28,'wqwqwqw',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(29,'rrrrrrr',-1,'2021-07-17 04:10:40','2021-07-17 04:10:49','2021-07-05 03:43:09'),(30,'qweqweqeqe111111',1,'2021-07-17 04:10:40','2021-07-19 04:27:23',NULL),(31,'new brand',1,'2021-07-17 04:10:40','2021-07-19 04:27:27',NULL),(32,'aaa',1,'2021-07-17 04:10:40','2021-07-19 04:27:30',NULL),(33,'my new asset type2',1,'2021-07-17 04:10:40','2021-07-19 04:27:33',NULL),(34,'New type of asset',1,'2021-07-19 04:28:02','2021-07-19 04:28:02',NULL),(35,'new type of asset #2',1,'2021-07-19 04:28:38','2021-07-19 04:28:38',NULL),(36,'new asset type 3',1,'2021-07-19 04:29:11','2021-10-11 19:46:20',NULL);
/*!40000 ALTER TABLE `asset_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `craue_config_setting`
--

LOCK TABLES `craue_config_setting` WRITE;
/*!40000 ALTER TABLE `craue_config_setting` DISABLE KEYS */;
/*!40000 ALTER TABLE `craue_config_setting` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer`
--

LOCK TABLES `customer` WRITE;
/*!40000 ALTER TABLE `customer` DISABLE KEYS */;
INSERT INTO `customer` VALUES (1,'','customer1','customer1@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(2,'','customer2','customer2@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(3,'','customer3','customer3@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(4,'','customer4','customer4@example.com','1234',NULL,NULL,1,NULL,NULL,NULL,1,'2022-01-02 10:07:17','2022-01-02 10:07:17',NULL),(5,'dada','dada','dada','$2y$13$j8Cwt4d1yArJJVwxk0ZdDuqmDQTo9M7aru4Lp5U.2ZKXbBoCVEdq.',NULL,NULL,1,NULL,NULL,NULL,1,'2022-06-28 21:03:28','2022-06-28 21:03:28',NULL),(7,'dada2','dada2','dada@gmai.lc','$2y$13$U3U90Yw1joE68Ew6jAl6ZuaSVsZjvzV.Tct0zUiHpBMO73qC.fmjC',NULL,NULL,1,NULL,NULL,NULL,1,'2022-06-28 21:03:53','2022-06-28 21:03:53',NULL);
/*!40000 ALTER TABLE `customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer_attachment`
--

LOCK TABLES `customer_attachment` WRITE;
/*!40000 ALTER TABLE `customer_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer_contact`
--

LOCK TABLES `customer_contact` WRITE;
/*!40000 ALTER TABLE `customer_contact` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_contact` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer_location`
--

LOCK TABLES `customer_location` WRITE;
/*!40000 ALTER TABLE `customer_location` DISABLE KEYS */;
INSERT INTO `customer_location` VALUES (1,NULL,'nome location','via piaggio 26','65100','pescara','Italia',1,'2022-06-30 19:16:14','2022-06-30 19:16:14',NULL);
/*!40000 ALTER TABLE `customer_location` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer_location_place`
--

LOCK TABLES `customer_location_place` WRITE;
/*!40000 ALTER TABLE `customer_location_place` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_location_place` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer_location_place_asset`
--

LOCK TABLES `customer_location_place_asset` WRITE;
/*!40000 ALTER TABLE `customer_location_place_asset` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_location_place_asset` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer_location_place_asset_attachment`
--

LOCK TABLES `customer_location_place_asset_attachment` WRITE;
/*!40000 ALTER TABLE `customer_location_place_asset_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `customer_location_place_asset_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `customer_profile`
--

LOCK TABLES `customer_profile` WRITE;
/*!40000 ALTER TABLE `customer_profile` DISABLE KEYS */;
INSERT INTO `customer_profile` VALUES (1,'Steve','Jungen',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,'Roberto','Salvini',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,'Lucio','Giacomi',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL),(4,'Marco','Martioli',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `customer_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `doctrine_migration_versions`
--

LOCK TABLES `doctrine_migration_versions` WRITE;
/*!40000 ALTER TABLE `doctrine_migration_versions` DISABLE KEYS */;
/*!40000 ALTER TABLE `doctrine_migration_versions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `notification`
--

LOCK TABLES `notification` WRITE;
/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `notification_entity`
--

LOCK TABLES `notification_entity` WRITE;
/*!40000 ALTER TABLE `notification_entity` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_entity` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `notification_item`
--

LOCK TABLES `notification_item` WRITE;
/*!40000 ALTER TABLE `notification_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project`
--

LOCK TABLES `project` WRITE;
/*!40000 ALTER TABLE `project` DISABLE KEYS */;
INSERT INTO `project` VALUES (268,'P-567','Controllo Mensile Computer ',NULL,'2021-04-04 06:06:00','2021-04-29 08:30:00','current',NULL,NULL,0,1,1,27,'2021-04-04 08:17:32','2021-04-04 08:17:32',NULL,NULL),(269,'P-582','Pulizia PC',NULL,'2021-04-22 04:33:00','2021-05-06 22:50:00','current',NULL,NULL,0,1,1,27,'2021-04-22 22:39:53','2021-04-22 22:39:53',NULL,NULL),(270,'P-583','Pulizia PC',NULL,'2021-04-24 05:02:00','2021-05-09 23:50:00','current',NULL,NULL,0,1,1,27,'2021-04-25 09:34:13','2021-04-25 09:34:13',NULL,NULL),(271,'P-580','Pulizia PC',NULL,'2021-04-25 07:36:00','2021-05-08 09:00:00','current',NULL,NULL,0,1,1,27,'2021-04-25 09:38:54','2021-04-25 09:38:54',NULL,NULL),(272,'P-575','Pulizia PC',NULL,'2021-04-25 09:23:00','2021-05-09 23:20:00','current',NULL,NULL,0,1,1,27,'2021-04-25 11:23:36','2021-04-25 11:23:36',NULL,NULL),(273,'P-584','Formattazione PC',NULL,'2021-04-25 10:08:00','2021-05-08 12:10:00','current',NULL,NULL,0,1,1,27,'2021-04-25 12:13:33','2021-04-25 12:13:33',NULL,NULL),(274,'P-585','Formattazione PC',NULL,'2021-04-25 13:53:00','2021-05-08 15:25:00','current',NULL,NULL,0,1,1,27,'2021-04-25 15:54:54','2021-04-25 15:54:54',NULL,NULL),(275,'P-586','Formattazione PC',NULL,'2021-04-01 13:45:00','2021-05-08 23:55:00','current',NULL,NULL,0,1,1,27,'2021-04-25 16:00:04','2021-04-25 16:00:04',NULL,NULL),(276,'P-610','Pulizia PC',NULL,'2021-04-27 03:59:00','2021-05-09 05:45:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:00:09','2021-04-27 06:00:09',NULL,NULL),(277,'P-612','Pulizia PC',NULL,'2021-04-27 04:05:00','2021-05-09 06:05:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:06:05','2021-04-27 06:06:05',NULL,NULL),(278,'P-613','Pulizia PC',NULL,'2021-04-27 04:07:00','2021-05-09 23:05:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:08:11','2021-04-27 06:08:11',NULL,NULL),(279,'P-614','Pulizia PC',NULL,'2021-04-27 04:38:00','2021-05-09 06:35:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:39:05','2021-04-27 06:39:05',NULL,NULL),(280,'P-615','Formattazione PC',NULL,'2021-04-27 04:43:00','2021-05-09 06:50:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:43:41','2021-04-27 06:43:41',NULL,NULL),(281,'P-616','Pulizia PC',NULL,'2021-04-27 04:44:00','2021-05-09 23:50:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:45:09','2021-04-27 06:45:09',NULL,NULL),(282,'P-617','Pulizia PC',NULL,'2021-04-27 04:47:00','2021-05-09 23:45:00','current',NULL,NULL,0,1,1,27,'2021-04-27 06:47:37','2021-04-27 06:47:37',NULL,NULL),(283,'P-629','Formattazione PC',NULL,'2021-05-21 03:35:00','2021-05-28 07:50:00','current',NULL,NULL,0,1,1,27,'2021-05-21 07:01:14','2021-05-21 07:01:14',NULL,NULL);
/*!40000 ALTER TABLE `project` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_milestone`
--

LOCK TABLES `project_milestone` WRITE;
/*!40000 ALTER TABLE `project_milestone` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_milestone` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_milestone_task`
--

LOCK TABLES `project_milestone_task` WRITE;
/*!40000 ALTER TABLE `project_milestone_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_milestone_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task`
--

LOCK TABLES `project_task` WRITE;
/*!40000 ALTER TABLE `project_task` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task_assigned`
--

LOCK TABLES `project_task_assigned` WRITE;
/*!40000 ALTER TABLE `project_task_assigned` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_assigned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task_attachment`
--

LOCK TABLES `project_task_attachment` WRITE;
/*!40000 ALTER TABLE `project_task_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task_item`
--

LOCK TABLES `project_task_item` WRITE;
/*!40000 ALTER TABLE `project_task_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task_item_assigned`
--

LOCK TABLES `project_task_item_assigned` WRITE;
/*!40000 ALTER TABLE `project_task_item_assigned` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_item_assigned` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task_template`
--

LOCK TABLES `project_task_template` WRITE;
/*!40000 ALTER TABLE `project_task_template` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_template` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task_template_item`
--

LOCK TABLES `project_task_template_item` WRITE;
/*!40000 ALTER TABLE `project_task_template_item` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_template_item` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `project_task_type`
--

LOCK TABLES `project_task_type` WRITE;
/*!40000 ALTER TABLE `project_task_type` DISABLE KEYS */;
/*!40000 ALTER TABLE `project_task_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user`
--

LOCK TABLES `user` WRITE;
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` VALUES (1,'danilo','danilo@gmail.com','$2y$13$DZp5jWG2a2eWANG0eXkqeu4z8gw6d4zI1uMa7f00SnwNidUdA3lXm',NULL,NULL,NULL,NULL,1,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL,NULL),(2,'admin','admin@gmail.com','$2y$13$/yq8h/hWOVorhIQ71VyYheAFml6aDt.AeEQX/axE9Xa/nj3k0pXaK',NULL,NULL,NULL,NULL,1,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL,NULL),(3,'federico','federico@dimoia.com','$2y$13$eO7f/1t.G8CPry0DhaA0uOHZ7sn77WHsLPo3P30u6Kv3plAZdV19K',NULL,NULL,NULL,NULL,1,1,'2022-01-02 10:07:16','2022-01-02 10:07:16',NULL,NULL),(14,'admin111','zitter@gmail.com','$2y$13$86Q0HnwbrWf6TMnblYhoJeEoRsSsKgMBwew2s0hTt1RgVloSBMrlq',NULL,NULL,NULL,NULL,1,1,'2022-06-29 17:24:04','2022-06-29 17:24:04',NULL,NULL);
/*!40000 ALTER TABLE `user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_assigned_customer`
--

LOCK TABLES `user_assigned_customer` WRITE;
/*!40000 ALTER TABLE `user_assigned_customer` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_assigned_customer` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_attachment`
--

LOCK TABLES `user_attachment` WRITE;
/*!40000 ALTER TABLE `user_attachment` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_attachment` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_group`
--

LOCK TABLES `user_group` WRITE;
/*!40000 ALTER TABLE `user_group` DISABLE KEYS */;
INSERT INTO `user_group` VALUES (1,'Group one','group-1'),(2,'Group two','group-2'),(3,'Group three','group-3'),(4,'Group four','group-4');
/*!40000 ALTER TABLE `user_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_profile`
--

LOCK TABLES `user_profile` WRITE;
/*!40000 ALTER TABLE `user_profile` DISABLE KEYS */;
INSERT INTO `user_profile` VALUES (1,'Danilo','Di Moia',NULL,NULL,NULL,'Chieti, Italia',NULL,NULL,'Europe/Rome',NULL),(2,'Gabriella','Castagna',NULL,NULL,NULL,'Chieti, Italia',NULL,NULL,'Europe/Rome',NULL),(3,'Federico','Rampini',NULL,NULL,NULL,'Chieti, Italia',NULL,NULL,'Europe/Rome',NULL);
/*!40000 ALTER TABLE `user_profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_role`
--

LOCK TABLES `user_role` WRITE;
/*!40000 ALTER TABLE `user_role` DISABLE KEYS */;
INSERT INTO `user_role` VALUES (1,'Engineer','ROLE_ENGINEER'),(2,'Helpdesk','ROLE_HELPDESK'),(3,'Area leader','ROLE_LEADAREA'),(4,'Admin','ROLE_ADMIN');
/*!40000 ALTER TABLE `user_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `user_role_assigned`
--

LOCK TABLES `user_role_assigned` WRITE;
/*!40000 ALTER TABLE `user_role_assigned` DISABLE KEYS */;
INSERT INTO `user_role_assigned` VALUES (1,1),(2,1);
/*!40000 ALTER TABLE `user_role_assigned` ENABLE KEYS */;
UNLOCK TABLES;

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
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2022-06-30 19:51:17
