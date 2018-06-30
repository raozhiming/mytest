-- MySQL dump 10.13  Distrib 5.7.22, for Linux (x86_64)
--
-- Host: localhost    Database: vote
-- ------------------------------------------------------
-- Server version	5.7.22-0ubuntu0.16.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `elastos_user_wins`
--

DROP TABLE IF EXISTS `elastos_user_wins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elastos_user_wins` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
  `user_id` int(10) NOT NULL COMMENT '用户id',
  `wins` varchar(255) NOT NULL COMMENT '连赢的局数，以‘，’做字符串拼接',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=103 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `elastos_user_wins`
--

LOCK TABLES `elastos_user_wins` WRITE;
/*!40000 ALTER TABLE `elastos_user_wins` DISABLE KEYS */;
INSERT INTO `elastos_user_wins` VALUES (1,1,'2'),(2,6,'2'),(3,12,'3,6,2,2,3'),(4,13,'3,7,2,10,2'),(5,14,'5,2,2'),(6,15,'2,3,4,2,3'),(7,16,'2,2,2,5,2,3'),(8,17,'2,2,2,2,3'),(9,18,'3,2,2,2,2,2'),(10,19,'5,2,2'),(11,20,'2,2,2,3,2'),(12,21,'2,2,3,6,2,2,2,2'),(13,22,'2,3'),(14,23,'5'),(15,24,'3,3,2,4'),(16,25,'2,2,2,3,2'),(17,26,'2,2,2,4'),(18,27,'2,2,2,2,2'),(19,28,'2'),(20,29,'2,5,3,2'),(21,30,'3,2,2,2'),(22,31,'2,4,2,2'),(23,32,'2,2,2,2'),(24,33,'2,2'),(25,34,'3,2,4,2,4'),(26,35,'2,2,2,2,2,2'),(27,36,'2,2,2,2'),(28,37,'3,2,2,3,2,2,2'),(29,38,'4,2'),(30,39,'2,3,2,2'),(31,40,'2,2,3,2,2'),(32,41,'2,4,3,2,2'),(33,42,'2,5,2,2,2'),(34,43,'2,2,3'),(35,44,'2,5,4'),(36,45,'4,7,2'),(37,46,'5,2'),(38,47,'2'),(39,48,'2,2,2'),(40,49,'3,2,2,2,2,3'),(41,50,'2,2,3'),(42,51,'2,2,2,6,2,2,2'),(43,52,'2,2,2,2,2'),(44,53,'2,3,2,2,2,2'),(45,54,'9,2,2,2,2,2'),(46,55,'2,2,2,2'),(47,56,'2,2,3'),(48,57,'5,2'),(49,58,'3,2,2,3,2,2,4,3,4'),(50,59,'2,3,3,2,5,2,3'),(51,60,'3'),(52,61,'2,2,3'),(53,62,'2,2,2,3'),(54,63,'2,2,2,2,2,2'),(55,64,'2,2,2,2,5,2'),(56,65,'2,2,2,6,2'),(57,66,'2,2,2,2'),(58,67,'5,3,2,2,5'),(59,68,'2,2,2,3'),(60,69,'3,2,2'),(61,70,'2,2,2,3,2'),(62,71,'2,2,2,4,2'),(63,72,'2,2,2,2,2'),(64,73,'2,4,3,3,2'),(65,74,'5,6,3,2'),(66,75,'3,3,2,3,2'),(67,76,'2,2,2,2,2,2'),(68,77,'2,2,2'),(69,78,'3,3'),(70,79,'2,2,2,2,2,2,7,3'),(71,80,'2,2'),(72,81,'2,2,2,2,2,2'),(73,82,'2,4,2,3,3'),(74,83,'2,2,3,3'),(75,84,'3,2,2,2,4,3,2'),(76,85,'2,2,2,2,2'),(77,86,'4,3'),(78,87,'3,3,3,2,2'),(79,88,'2,3,2,5,3,2,2'),(80,89,'2,3,4,2,2'),(81,90,'4,3,4,4'),(82,91,'2,2,2,3,6'),(83,92,'2,4,3'),(84,93,'2,2,4,2'),(85,94,'3,3'),(86,95,'2,2,2,2'),(87,96,'3,2,2,2'),(88,97,'3,2,2,2'),(89,98,'2,2,2,2,2'),(90,99,'2,3,2,2,2,2'),(91,100,'2,2'),(92,101,'3,2,3,2'),(93,102,'2,3,2,2,2'),(94,103,'3,3,2,2,2'),(95,104,'2,2,4,2'),(96,105,'3,4,2,3,6,3,2'),(97,106,'2,2,4,2,2'),(98,107,'3,3,2,2,2,4'),(99,108,'3,3'),(100,109,'2,2,2,2,2,2,3'),(101,110,'2,2,3,3'),(102,111,'3,6,2,2');
/*!40000 ALTER TABLE `elastos_user_wins` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-06-06  3:27:35
