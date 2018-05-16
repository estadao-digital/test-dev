-- MySQL dump 10.13  Distrib 5.5.60, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: carro
-- ------------------------------------------------------
-- Server version	5.5.60-0ubuntu0.14.04.1

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
-- Table structure for table `acl`
--

DROP TABLE IF EXISTS `acl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `acl` (
  `idacl` int(11) NOT NULL AUTO_INCREMENT,
  `page` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `groups_idgroup` int(11) NOT NULL,
  `profile_idprofile` int(11) NOT NULL,
  `dataCreate` datetime DEFAULT NULL,
  `dataModify` datetime DEFAULT NULL,
  `enable` int(11) DEFAULT NULL,
  PRIMARY KEY (`idacl`),
  KEY `fk_acl_groups1_idx` (`groups_idgroup`),
  KEY `fk_acl_profile1_idx` (`profile_idprofile`)
) ENGINE=MyISAM AUTO_INCREMENT=584825 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `acl`
--

LOCK TABLES `acl` WRITE;
/*!40000 ALTER TABLE `acl` DISABLE KEYS */;
INSERT INTO `acl` VALUES (584793,'acl/aclRemove',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584794,'acl/newAcl',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584795,'acl/profileAccess',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584796,'acl/saveAcl',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584797,'group/delGroup',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584798,'group/index',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584799,'group/newGroup',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584800,'group/saveGroup',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584801,'menuManager/delete',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584802,'menuManager/deleteItem',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584803,'menuManager/index',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584804,'menuManager/itens',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584805,'menuManager/menuNew',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584806,'menuManager/menuNewItem',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584807,'menuManager/saveItem',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584808,'menuManager/saveMenu',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584809,'profile/delProfile',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584810,'profile/groupProfile',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584811,'profile/index',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584812,'profile/listUsers',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584813,'profile/newProfile',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584814,'profile/profileName',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584815,'profile/saveProfile',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584816,'users/ajaxGroup',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584817,'users/ajaxProfile',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584818,'users/index',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584819,'users/listUser',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584820,'users/profileName',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584821,'users/saveUser',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584822,'users/userEdit',6,2,'2018-05-15 14:24:28','2018-05-15 14:24:28',1),(584823,'carros/__call',6,2,'2018-05-15 15:24:00','2018-05-15 15:24:00',1),(584824,'carros/index',6,2,'2018-05-15 15:24:22','2018-05-15 15:24:22',1);
/*!40000 ALTER TABLE `acl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carro`
--

DROP TABLE IF EXISTS `carro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `carro` (
  `idcarro` int(11) NOT NULL AUTO_INCREMENT,
  `marca` varchar(145) DEFAULT NULL,
  `modelo` varchar(145) DEFAULT NULL,
  `ano` int(11) DEFAULT NULL,
  `cor` varchar(45) DEFAULT NULL,
  `placa` varchar(45) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idcarro`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carro`
--

LOCK TABLES `carro` WRITE;
/*!40000 ALTER TABLE `carro` DISABLE KEYS */;
/*!40000 ALTER TABLE `carro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `idgroup` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(300) COLLATE utf8_bin DEFAULT NULL,
  `enable` int(11) DEFAULT NULL,
  PRIMARY KEY (`idgroup`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES (6,'Admin Group',1);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menu`
--

DROP TABLE IF EXISTS `menu`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menu` (
  `idMenu` int(11) NOT NULL AUTO_INCREMENT,
  `menuName` varchar(45) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  `idgroup` int(11) DEFAULT NULL,
  `idprofile` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMenu`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menu`
--

LOCK TABLES `menu` WRITE;
/*!40000 ALTER TABLE `menu` DISABLE KEYS */;
INSERT INTO `menu` VALUES (1,'nav',1,NULL,NULL);
/*!40000 ALTER TABLE `menu` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `menuItem`
--

DROP TABLE IF EXISTS `menuItem`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `menuItem` (
  `idMenuItem` int(11) NOT NULL AUTO_INCREMENT,
  `itemName` varchar(45) DEFAULT NULL,
  `idMenu` int(11) DEFAULT NULL,
  `idParent` int(11) DEFAULT '0',
  `address` varchar(200) DEFAULT NULL,
  `class` varchar(200) DEFAULT NULL,
  `name` varchar(200) DEFAULT NULL,
  `id` varchar(200) DEFAULT NULL,
  `icon` varchar(200) DEFAULT NULL,
  `idgroup` int(11) DEFAULT NULL,
  `idprofile` int(11) DEFAULT NULL,
  `ativo` int(11) DEFAULT NULL,
  PRIMARY KEY (`idMenuItem`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `menuItem`
--

LOCK TABLES `menuItem` WRITE;
/*!40000 ALTER TABLE `menuItem` DISABLE KEYS */;
INSERT INTO `menuItem` VALUES (1,'Groups',1,NULL,'::siteroot::/index.php/group/index/',NULL,NULL,NULL,'glyphicon glyphicon-user',NULL,NULL,1),(2,'Menu Editor',1,NULL,'::siteroot::/index.php/menuManager/index/',NULL,NULL,NULL,'glyphicon glyphicon-th-list',NULL,NULL,1),(3,'Profiles',1,NULL,'::siteroot::/index.php/profile/index/',NULL,NULL,NULL,'glyphicon glyphicon-tags',NULL,NULL,1),(4,'Users',1,NULL,'::siteroot::/index.php/users/index/',NULL,NULL,NULL,'glyphicon glyphicon-user',NULL,NULL,1);
/*!40000 ALTER TABLE `menuItem` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profile` (
  `idprofile` int(11) NOT NULL AUTO_INCREMENT,
  `groups_idgroup` int(11) NOT NULL,
  `name` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `enable` varchar(45) COLLATE utf8_bin DEFAULT NULL,
  `adminProfile` int(11) DEFAULT NULL,
  `dataCreate` datetime DEFAULT NULL,
  `dataModify` datetime DEFAULT NULL,
  PRIMARY KEY (`idprofile`),
  KEY `fk_profile_groups_idx` (`groups_idgroup`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profile`
--

LOCK TABLES `profile` WRITE;
/*!40000 ALTER TABLE `profile` DISABLE KEYS */;
INSERT INTO `profile` VALUES (2,6,'Admin Profile','1',NULL,'2018-05-15 14:24:28','2018-05-15 14:24:28');
/*!40000 ALTER TABLE `profile` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sessions` (
  `id` varchar(32) NOT NULL,
  `access` int(10) unsigned DEFAULT NULL,
  `data` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('3h8i9rjq94sgk4g4au6l7j3mo0',1526398846,'_execute|s:5:\"group\";_method|s:5:\"index\";requesAddress|s:23:\"/index.php/group/index/\";login|s:5:\"admin\";logged|s:2:\"on\";authorized|b:1;');
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userObject`
--

DROP TABLE IF EXISTS `userObject`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userObject` (
  `users_idusers` int(11) NOT NULL,
  `objectName` varchar(100) DEFAULT NULL,
  `jsonObject` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userObject`
--

LOCK TABLES `userObject` WRITE;
/*!40000 ALTER TABLE `userObject` DISABLE KEYS */;
/*!40000 ALTER TABLE `userObject` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `userProfileGroup`
--

DROP TABLE IF EXISTS `userProfileGroup`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `userProfileGroup` (
  `users_idusers` int(11) NOT NULL,
  `profile_idprofile` int(11) NOT NULL,
  `groups_idgroup` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `userProfileGroup`
--

LOCK TABLES `userProfileGroup` WRITE;
/*!40000 ALTER TABLE `userProfileGroup` DISABLE KEYS */;
INSERT INTO `userProfileGroup` VALUES (2,2,6);
/*!40000 ALTER TABLE `userProfileGroup` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `idusers` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `userName` varchar(500) COLLATE utf8_bin DEFAULT NULL,
  `secret` varchar(1000) COLLATE utf8_bin DEFAULT NULL,
  `dataCreate` datetime DEFAULT NULL,
  `dateModify` datetime DEFAULT NULL,
  `enable` int(11) DEFAULT NULL,
  PRIMARY KEY (`idusers`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (2,'admin','System Admin','210dbe4bf016399e7296d2eeebba6d65','2018-05-15 14:24:28','2018-05-15 14:24:28',1);
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

-- Dump completed on 2018-05-15 15:41:41
