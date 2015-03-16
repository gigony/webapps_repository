-- MySQL dump 10.13  Distrib 5.6.22, for osx10.9 (x86_64)
--
-- Host: localhost    Database: timeclock
-- ------------------------------------------------------
-- Server version	5.6.22

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
-- Table structure for table `audit`
--

DROP TABLE IF EXISTS `audit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `audit` (
  `modified_by_ip` varchar(39) NOT NULL DEFAULT '',
  `modified_by_user` varchar(50) NOT NULL DEFAULT '',
  `modified_when` bigint(14) NOT NULL,
  `modified_from` bigint(14) NOT NULL,
  `modified_to` bigint(14) NOT NULL,
  `modified_why` varchar(250) NOT NULL DEFAULT '',
  `user_modified` varchar(50) NOT NULL DEFAULT '',
  PRIMARY KEY (`modified_when`),
  UNIQUE KEY `modified_when` (`modified_when`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `audit`
--

LOCK TABLES `audit` WRITE;
/*!40000 ALTER TABLE `audit` DISABLE KEYS */;
/*!40000 ALTER TABLE `audit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `dbversion`
--

DROP TABLE IF EXISTS `dbversion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `dbversion` (
  `dbversion` decimal(5,1) NOT NULL DEFAULT '0.0',
  PRIMARY KEY (`dbversion`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `dbversion`
--

LOCK TABLES `dbversion` WRITE;
/*!40000 ALTER TABLE `dbversion` DISABLE KEYS */;
INSERT INTO `dbversion` VALUES (1.4);
/*!40000 ALTER TABLE `dbversion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `employees`
--

DROP TABLE IF EXISTS `employees`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `employees` (
  `empfullname` varchar(50) NOT NULL DEFAULT '',
  `tstamp` bigint(14) DEFAULT NULL,
  `employee_passwd` varchar(25) NOT NULL DEFAULT '',
  `displayname` varchar(50) NOT NULL DEFAULT '',
  `email` varchar(75) NOT NULL DEFAULT '',
  `groups` varchar(50) NOT NULL DEFAULT '',
  `office` varchar(50) NOT NULL DEFAULT '',
  `admin` tinyint(1) NOT NULL DEFAULT '0',
  `reports` tinyint(1) NOT NULL DEFAULT '0',
  `time_admin` tinyint(1) NOT NULL DEFAULT '0',
  `disabled` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`empfullname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `employees`
--

LOCK TABLES `employees` WRITE;
/*!40000 ALTER TABLE `employees` DISABLE KEYS */;
INSERT INTO `employees` VALUES ('admin',NULL,'xy.RY2HT1QTc2','administrator','','','',1,1,1,0),('oscar',1425918440,'xyw1.V0rbu5mQ','Oscar Madison','oscar@yahoo.com','g1','TheOffice',0,1,0,0),('felix',1425913149,'xyw1.V0rbu5mQ','Felix Ungar','felix@yahoo.com','Front Group','front',0,1,0,0),('glenda',1426021285,'xyw1.V0rbu5mQ','Glenda Radner','gradner@comcast.net','b101group','b101',0,0,0,0),('norma',1425993531,'xyw1.V0rbu5mQ','Norma Rae Robbins','nrr@inetd.net','back','backoffice',0,1,0,0),('lois',1425933373,'xyw1.V0rbu5mQ','Lois Lane','llane@dailyplanetnews.net','b101group','b101',0,0,0,0),('jolsen',1425933366,'xyw1.V0rbu5mQ','Jimmy Olsen','jolson@dailyplanetnews.net','b102group','b102',0,0,0,0),('ckent',1426021279,'xyw1.V0rbu5mQ','Clark Kent','ckent@dailyplanetnews.net','b103group','b103',0,0,0,0),('skyler',1425918430,'xyw1.V0rbu5mQ','Schuyler Colfax','scolfax3041@q.com','a101group','a101',0,0,0,0),('randy',1425918448,'xyw1.V0rbu5mQ','Randy Neuman','iluvla2much@aol.com','a102group','a102',0,0,0,0),('don',1425931878,'xyw1.V0rbu5mQ','Don Imus','dimus@whoknows.net','c10xgroup','c103',0,0,0,0),('howard',NULL,'xyw1.V0rbu5mQ','Howard Stein','howardstein@skyhook.us','c10xgroup','c103',0,0,0,0),('vince',1426021292,'xyw1.V0rbu5mQ','Vince Foster','vfoster@whitehouse.gov','group1','TheOffice',0,0,0,0),('hilly',1425925264,'xyw1.V0rbu5mQ','Hillary Clinton','hdr44@clintonemail.net','back','backoffice',0,1,0,0),('billc',1425913130,'xyw1.V0rbu5mQ','Bill Clinton','cigarlover69@yahoo.com','c10xgroup','c103',0,0,0,0),('louis',NULL,'xyw1.V0rbu5mQ','Louis Armstrong','blowyerhorn@hotmail.com','c10xgroup','c102',0,0,0,0),('clyde',1425935372,'xyw1.V0rbu5mQ','Clyde Barrow','clydeb8472@q.com','c10xgroup','c102',0,0,0,0);
/*!40000 ALTER TABLE `employees` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `groupname` varchar(50) NOT NULL DEFAULT '',
  `groupid` int(10) NOT NULL AUTO_INCREMENT,
  `officeid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
INSERT INTO `groups` VALUES ('g1',1,1),('g2',2,1),('g3',3,1),('g4',4,1),('g5',5,1),('g6',6,1),('g7',7,1),('g8',8,1),('g9',9,1),('group1',10,1),('a101group',12,7),('a102group',13,8),('b103group',14,6),('b101group',15,4),('b102group',16,5),('c10xgroup',17,9),('c10xgroup',18,10),('back',19,2),('Front Group',20,3);
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `info`
--

DROP TABLE IF EXISTS `info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `info` (
  `fullname` varchar(50) NOT NULL DEFAULT '',
  `inout` varchar(50) NOT NULL DEFAULT '',
  `timestamp` bigint(14) DEFAULT NULL,
  `notes` varchar(250) DEFAULT NULL,
  `ipaddress` varchar(39) NOT NULL DEFAULT '',
  KEY `fullname` (`fullname`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `info`
--

LOCK TABLES `info` WRITE;
/*!40000 ALTER TABLE `info` DISABLE KEYS */;
INSERT INTO `info` VALUES ('don','in',1425870279,'im here dammit','127.0.0.1'),('felix','in',1425870303,'keep it clean','127.0.0.1'),('oscar','in',1425870321,'i always do','127.0.0.1'),('jolsen','in',1425870350,'','127.0.0.1'),('ckent','in',1425870364,'','127.0.0.1'),('jolsen','break',1425870863,'','127.0.0.1'),('billc','in',1425870879,'','127.0.0.1'),('don','lunch',1425870893,'','127.0.0.1'),('randy','in',1425870982,'','127.0.0.1'),('jolsen','in',1425870991,'','127.0.0.1'),('glenda','in',1425871008,'','127.0.0.1'),('billc','out',1425913130,'','10.211.136.85'),('ckent','out',1425913137,'','10.211.136.85'),('don','in',1425913141,'','10.211.136.85'),('felix','out',1425913149,'','10.211.136.85'),('glenda','break',1425913156,'','10.211.136.85'),('jolsen','lunch',1425913163,'','10.211.136.85'),('skyler','in',1425914661,'','10.211.136.85'),('ckent','in',1425914681,'im baaaack','10.211.136.85'),('skyler','out',1425918430,'','10.211.136.85'),('oscar','out',1425918440,'','10.211.136.85'),('randy','out',1425918448,'','10.211.136.85'),('hilly','in',1425918454,'','10.211.136.85'),('vince','in',1425918471,'','10.211.136.85'),('lois','in',1425918480,'','10.211.136.85'),('norma','in',1425918493,'','10.211.136.85'),('ckent','break',1425918716,'ill be baaaack','10.211.136.85'),('don','lunch',1425919026,'','10.211.136.85'),('don','in',1425922477,'','10.211.136.85'),('jolsen','in',1425922494,'that was great','10.211.136.85'),('hilly','out',1425925264,'','10.211.136.85'),('vince','break',1425925275,'','10.211.136.85'),('don','out',1425931878,'','10.211.136.85'),('clyde','in',1425932253,'','10.211.136.85'),('clyde','out',1425932291,'','10.211.136.85'),('jolsen','out',1425933366,'','10.211.136.85'),('lois','out',1425933373,'','10.211.136.85'),('clyde','in',1425935299,'','10.211.136.85'),('clyde','out',1425935372,'','10.211.136.85'),('norma','out',1425993531,'','10.211.136.85'),('vince','in',1425993544,'','10.211.136.85'),('glenda','in',1425993552,'','10.211.136.85'),('ckent','in',1425993558,'','10.211.136.85'),('ckent','out',1426021279,'','10.211.136.85'),('glenda','out',1426021285,'','10.211.136.85'),('vince','out',1426021292,'','10.211.136.85');
/*!40000 ALTER TABLE `info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `metars`
--

DROP TABLE IF EXISTS `metars`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `metars` (
  `metar` varchar(255) NOT NULL DEFAULT '',
  `timestamp` timestamp(6) NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  `station` varchar(4) NOT NULL DEFAULT '',
  PRIMARY KEY (`station`),
  UNIQUE KEY `station` (`station`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `metars`
--

LOCK TABLES `metars` WRITE;
/*!40000 ALTER TABLE `metars` DISABLE KEYS */;
/*!40000 ALTER TABLE `metars` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `offices`
--

DROP TABLE IF EXISTS `offices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `offices` (
  `officename` varchar(50) NOT NULL DEFAULT '',
  `officeid` int(10) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`officeid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `offices`
--

LOCK TABLES `offices` WRITE;
/*!40000 ALTER TABLE `offices` DISABLE KEYS */;
INSERT INTO `offices` VALUES ('TheOffice',1),('backoffice',2),('front',3),('b101',4),('b102',5),('b103',6),('a101',7),('a102',8),('c102',9),('c103',10);
/*!40000 ALTER TABLE `offices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `punchlist`
--

DROP TABLE IF EXISTS `punchlist`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `punchlist` (
  `punchitems` varchar(50) NOT NULL DEFAULT '',
  `color` varchar(7) NOT NULL DEFAULT '',
  `in_or_out` tinyint(1) DEFAULT NULL,
  PRIMARY KEY (`punchitems`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `punchlist`
--

LOCK TABLES `punchlist` WRITE;
/*!40000 ALTER TABLE `punchlist` DISABLE KEYS */;
INSERT INTO `punchlist` VALUES ('in','#009900',1),('out','#FF0000',0),('break','#FF9900',0),('lunch','#0000FF',0);
/*!40000 ALTER TABLE `punchlist` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2015-03-12 19:56:05
