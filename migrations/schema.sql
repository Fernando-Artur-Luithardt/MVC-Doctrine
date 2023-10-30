-- MySQL dump 10.13 Distrib 5.5.62, for Win64 (AMD64)
--
-- Host: localhost Database: magazord
-- ------------------------------------------------------
-- Server version 5.5.5-10.4.28-MariaDB

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

-- Create the Magazord database if it doesn't exist and use it
CREATE DATABASE IF NOT EXISTS Magazord;
USE Magazord;

--
-- Table structure for table `contato`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `contato` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tipo` tinyint(1) DEFAULT NULL,
  `descricao` varchar(120) DEFAULT NULL,
  `idPessoa` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `contato_FK` (`idPessoa`),
  CONSTRAINT `contato_FK` FOREIGN KEY (`idPessoa`) REFERENCES `pessoa` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contato`
--

LOCK TABLES `contato` WRITE;
/*!40000 ALTER TABLE `contato` DISABLE KEYS */;
INSERT INTO `contato` VALUES (1,1,'descrito',1);
/*!40000 ALTER TABLE `contato` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pessoa`
--

/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE IF NOT EXISTS `pessoa` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nome` varchar(220) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `pessoa_un` (`cpf`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pessoa`
--

LOCK TABLES `pessoa` WRITE;
/*!40000 ALTER TABLE `pessoa` DISABLE KEYS */;
INSERT INTO `pessoa` VALUES (1,'Fernando','090.907.129-27');
/*!40000 ALTER TABLE `pessoa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'magazord'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;