-- MySQL dump 10.11
--
-- Host: mysql.database.atlantia.sca.org    Database: atlantia_auth
-- ------------------------------------------------------
-- Server version	5.1.39-log

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
-- Current Database: `atlantia_auth`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `atlantia_auth` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `atlantia_auth`;

--
-- Table structure for table `atlantian`
--

DROP TABLE IF EXISTS `atlantian`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `atlantian` (
  `atlantian_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `first_name` varchar(50) DEFAULT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `address1` varchar(100) DEFAULT NULL,
  `address2` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(2) DEFAULT NULL,
  `zip` varchar(10) DEFAULT NULL,
  `country` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `alternate_email` varchar(100) DEFAULT NULL,
  `phone_home` varchar(20) DEFAULT NULL,
  `phone_mobile` varchar(20) DEFAULT NULL,
  `phone_work` varchar(20) DEFAULT NULL,
  `call_times` varchar(20) DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  `deceased` tinyint(4) NOT NULL DEFAULT '0',
  `deceased_date` date DEFAULT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `website` varchar(100) DEFAULT NULL,
  `biography` text,
  `op_notes` text,
  `sca_name` varchar(255) DEFAULT NULL,
  `preferred_sca_name` varchar(255) DEFAULT NULL,
  `name_reg_date` date DEFAULT NULL,
  `alternate_names` varchar(255) DEFAULT NULL,
  `blazon` text,
  `device_reg_date` date DEFAULT NULL,
  `device_file_name` varchar(255) DEFAULT NULL,
  `device_file_credit` varchar(255) DEFAULT NULL,
  `membership_number` mediumint(8) unsigned DEFAULT NULL,
  `expiration_date` date DEFAULT NULL,
  `expiration_date_pending` date DEFAULT NULL,
  `revoked` tinyint(4) NOT NULL DEFAULT '0',
  `revoked_date` date DEFAULT NULL,
  `branch_id` mediumint(8) unsigned DEFAULT NULL,
  `picture_file_name` varchar(255) DEFAULT NULL,
  `picture_file_credit` varchar(255) DEFAULT NULL,
  `publish_name` tinyint(4) NOT NULL DEFAULT '0',
  `publish_address` tinyint(4) NOT NULL DEFAULT '0',
  `publish_email` tinyint(4) NOT NULL DEFAULT '0',
  `publish_alternate_email` tinyint(4) NOT NULL DEFAULT '0',
  `publish_phone_home` tinyint(4) NOT NULL DEFAULT '0',
  `publish_phone_mobile` tinyint(4) NOT NULL DEFAULT '0',
  `publish_phone_work` tinyint(4) NOT NULL DEFAULT '0',
  `background_check_date` date DEFAULT NULL,
  `background_check_result` tinyint(4) DEFAULT NULL,
  `heraldic_rank_id` mediumint(8) unsigned DEFAULT NULL,
  `heraldic_title` varchar(255) DEFAULT NULL,
  `heraldic_interests` varchar(255) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`atlantian_id`),
  KEY `FK_atlantian__branch` (`branch_id`),
  KEY `FK_atlantian__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_atlantian__branch` FOREIGN KEY (`branch_id`) REFERENCES `atlantia_branch`.`branch` (`branch_id`),
  CONSTRAINT `FK_atlantian__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7163 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Temporary table structure for view `public_atlantian`
--

DROP TABLE IF EXISTS `public_atlantian`;
/*!50001 DROP VIEW IF EXISTS `public_atlantian`*/;
/*!50001 CREATE TABLE `public_atlantian` (
  `atlantian_id` mediumint(8) unsigned,
  `first_name` varchar(50),
  `middle_name` varchar(50),
  `last_name` varchar(50),
  `address1` varchar(100),
  `address2` varchar(100),
  `city` varchar(50),
  `state` varchar(2),
  `zip` varchar(10),
  `country` varchar(50),
  `email` varchar(100),
  `alternate_email` varchar(100),
  `phone_home` varchar(20),
  `phone_mobile` varchar(20),
  `phone_work` varchar(20),
  `call_times` varchar(20),
  `gender` char(1),
  `deceased` tinyint(4),
  `deceased_date` date,
  `inactive` tinyint(4),
  `website` varchar(100),
  `biography` text,
  `sca_name` varchar(255),
  `preferred_sca_name` varchar(255),
  `name_reg_date` date,
  `alternate_names` varchar(255),
  `blazon` text,
  `device_reg_date` date,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `membership_number` mediumint(8) unsigned,
  `expiration_date` date,
  `revoked` tinyint(4),
  `revoked_date` date,
  `branch_id` mediumint(8) unsigned,
  `picture_file_name` varchar(255),
  `picture_file_credit` varchar(255),
  `heraldic_rank_id` mediumint(8) unsigned,
  `heraldic_title` varchar(255),
  `heraldic_interests` varchar(255)
) */;

--
-- Table structure for table `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `user_auth` (
  `user_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `atlantian_id` mediumint(8) unsigned DEFAULT NULL,
  `username` varchar(50) NOT NULL,
  `pass_word` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `sca_name` varchar(255) NOT NULL,
  `account_request_date` date DEFAULT NULL,
  `last_log` varchar(16) DEFAULT NULL,
  `client_ip` varchar(15) DEFAULT NULL,
  `chivalry` tinyint(4) DEFAULT '0',
  `laurel` tinyint(4) DEFAULT '0',
  `pelican` tinyint(4) DEFAULT '0',
  `rose` tinyint(4) DEFAULT '0',
  `whitescarf` tinyint(4) DEFAULT '0',
  `pearl` tinyint(4) DEFAULT '0',
  `dolphin` tinyint(4) DEFAULT '0',
  `kraken` tinyint(4) DEFAULT '0',
  `seastag` tinyint(4) DEFAULT '0',
  `yewbow` tinyint(4) DEFAULT '0',
  `chivalry_pend` tinyint(4) DEFAULT '0',
  `laurel_pend` tinyint(4) DEFAULT '0',
  `pelican_pend` tinyint(4) DEFAULT '0',
  `rose_pend` tinyint(4) DEFAULT '0',
  `whitescarf_pend` tinyint(4) DEFAULT '0',
  `pearl_pend` tinyint(4) DEFAULT '0',
  `dolphin_pend` tinyint(4) DEFAULT '0',
  `kraken_pend` tinyint(4) DEFAULT '0',
  `seastag_pend` tinyint(4) DEFAULT '0',
  `yewbow_pend` tinyint(4) DEFAULT '0',
  `chivalry_admin` tinyint(4) DEFAULT '0',
  `laurel_admin` tinyint(4) DEFAULT '0',
  `pelican_admin` tinyint(4) DEFAULT '0',
  `rose_admin` tinyint(4) DEFAULT '0',
  `whitescarf_admin` tinyint(4) DEFAULT '0',
  `pearl_admin` tinyint(4) DEFAULT '0',
  `dolphin_admin` tinyint(4) DEFAULT '0',
  `kraken_admin` tinyint(4) DEFAULT '0',
  `seastag_admin` tinyint(4) DEFAULT '0',
  `yewbow_admin` tinyint(4) DEFAULT '0',
  `seneschal_admin` tinyint(4) DEFAULT '0',
  `youth_admin` tinyint(4) DEFAULT '0',
  `exchequer_admin` tinyint(4) DEFAULT '0',
  `herald_admin` tinyint(4) DEFAULT '0',
  `marshal_admin` tinyint(4) DEFAULT '0',
  `mol_admin` tinyint(4) DEFAULT '0',
  `moas_admin` tinyint(4) DEFAULT '0',
  `chronicler_admin` tinyint(4) DEFAULT '0',
  `chirurgeon_admin` tinyint(4) DEFAULT '0',
  `webminister_admin` tinyint(4) DEFAULT '0',
  `chatelaine_admin` tinyint(4) DEFAULT '0',
  `op_admin` tinyint(4) DEFAULT '0',
  `backlog_admin` tinyint(4) DEFAULT '0',
  `university_admin` tinyint(4) DEFAULT '0',
  `award_admin` tinyint(4) DEFAULT '0',
  `spike_admin` tinyint(4) DEFAULT '0',
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `UK_username` (`username`),
  UNIQUE KEY `UK_user_auth_atlantian` (`atlantian_id`),
  KEY `FK_user_auth__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_user_auth__atlantian` FOREIGN KEY (`atlantian_id`) REFERENCES `atlantian` (`atlantian_id`),
  CONSTRAINT `FK_user_auth__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=762 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `user_auth`
--

LOCK TABLES `user_auth` WRITE;
/*!40000 ALTER TABLE `user_auth` DISABLE KEYS */;
INSERT INTO `user_auth` VALUES 
(1,NULL,'webminister',password('password'),'webminister@atlantia.sca.org',NULL,NULL,'Web Minister',NULL,NULL,NULL,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1,0,0,0,0,0,0,0,0,0,1,0,1,1,1,1,1,NULL,NULL,NULL),
(2,NULL,'opclerk',password('password'),'op@atlantia.sca.org',NULL,NULL,'Clerk of Precedence',NULL,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,NULL,NULL,NULL),
(3,NULL,'backlog',password('password'),'backlog@atlantia.sca.org',NULL,NULL,'Scroll Backlog Deputy',NULL,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,NULL,'2009-01-11',1),
(4,NULL,'herald',password('password'),'herald@atlantia.sca.org',NULL,NULL,'Triton Principal Herald',NULL,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,1,1,0,0,0,NULL,'2009-01-11',1),
(5,NULL,'university',password('password'),'university@atlantia.sca.org',NULL,NULL,'University Chancellor',NULL,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,NULL,NULL,NULL),
(6,NULL,'registrar',password('password'),'registrar@atlantia.sca.org',NULL,NULL,'University Registrar',NULL,NULL,NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,NULL,NULL,NULL);
/*!40000 ALTER TABLE `user_auth` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Current Database: `atlantia_op`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `atlantia_op` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `atlantia_op`;

--
-- Temporary table structure for view `atlantian`
--

DROP TABLE IF EXISTS `atlantian`;
/*!50001 DROP VIEW IF EXISTS `atlantian`*/;
/*!50001 CREATE TABLE `atlantian` (
  `atlantian_id` mediumint(8) unsigned,
  `first_name` varchar(50),
  `middle_name` varchar(50),
  `last_name` varchar(50),
  `address1` varchar(100),
  `address2` varchar(100),
  `city` varchar(50),
  `state` varchar(2),
  `zip` varchar(10),
  `country` varchar(50),
  `email` varchar(100),
  `alternate_email` varchar(100),
  `phone_home` varchar(20),
  `phone_mobile` varchar(20),
  `phone_work` varchar(20),
  `call_times` varchar(20),
  `gender` char(1),
  `deceased` tinyint(4),
  `deceased_date` date,
  `inactive` tinyint(4),
  `website` varchar(100),
  `biography` text,
  `op_notes` text,
  `sca_name` varchar(255),
  `preferred_sca_name` varchar(255),
  `name_reg_date` date,
  `alternate_names` varchar(255),
  `blazon` text,
  `device_reg_date` date,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `membership_number` mediumint(8) unsigned,
  `expiration_date` date,
  `expiration_date_pending` date,
  `revoked` tinyint(4),
  `revoked_date` date,
  `branch_id` mediumint(8) unsigned,
  `picture_file_name` varchar(255),
  `picture_file_credit` varchar(255),
  `publish_name` tinyint(4),
  `publish_address` tinyint(4),
  `publish_email` tinyint(4),
  `publish_alternate_email` tinyint(4),
  `publish_phone_home` tinyint(4),
  `publish_phone_mobile` tinyint(4),
  `publish_phone_work` tinyint(4),
  `background_check_date` date,
  `background_check_result` tinyint(4),
  `heraldic_rank_id` mediumint(8) unsigned,
  `heraldic_title` varchar(255),
  `heraldic_interests` varchar(255),
  `date_created` date,
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Table structure for table `atlantian_award`
--

DROP TABLE IF EXISTS `atlantian_award`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `atlantian_award` (
  `atlantian_award_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `atlantian_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `award_id` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `award_date` date DEFAULT NULL,
  `event_id` mediumint(8) unsigned DEFAULT NULL,
  `sequence` smallint(6) NOT NULL DEFAULT '0',
  `premier` tinyint(4) NOT NULL DEFAULT '0',
  `retired_date` date DEFAULT NULL,
  `resigned_date` date DEFAULT NULL,
  `revoked_date` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  `comments` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `court_report_id` mediumint(8) unsigned DEFAULT NULL,
  `private` tinyint(4) NOT NULL DEFAULT '0',
  `scroll_status_id` mediumint(8) unsigned DEFAULT NULL,
  `scroll_assignees` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `scroll_assigned_date` date DEFAULT NULL,
  `scroll_notes` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `branch_id` mediumint(8) unsigned DEFAULT NULL,
  `gender` char(1) DEFAULT NULL,
  PRIMARY KEY (`atlantian_award_id`),
  KEY `FK_atlantian_award__atlantian` (`atlantian_id`),
  KEY `FK_atlantian_award__award` (`award_id`),
  KEY `FK_atlantian_award__event` (`event_id`),
  KEY `FK_atlantian_award__last_edited` (`last_updated_by`),
  KEY `FK_atlantian_award__court_report` (`court_report_id`),
  KEY `FK_atlantian_award__scroll_status` (`scroll_status_id`),
  KEY `award_date` (`award_date`),
  KEY `FK_atlantian_award__branch` (`branch_id`),
  CONSTRAINT `FK_atlantian_award__atlantian` FOREIGN KEY (`atlantian_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_atlantian_award__award` FOREIGN KEY (`award_id`) REFERENCES `award` (`award_id`),
  CONSTRAINT `FK_atlantian_award__branch` FOREIGN KEY (`branch_id`) REFERENCES `atlantia_branch`.`branch` (`branch_id`),
  CONSTRAINT `FK_atlantian_award__court_report` FOREIGN KEY (`court_report_id`) REFERENCES `court_report` (`court_report_id`),
  CONSTRAINT `FK_atlantian_award__event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  CONSTRAINT `FK_atlantian_award__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_atlantian_award__scroll_status` FOREIGN KEY (`scroll_status_id`) REFERENCES `scroll_status` (`scroll_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17204 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `award`
--

DROP TABLE IF EXISTS `award`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `award` (
  `award_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `award_name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `select_branch` tinyint(4) NOT NULL DEFAULT '0',
  `type_id` mediumint(8) unsigned DEFAULT NULL,
  `title_id` mediumint(9) DEFAULT NULL,
  `award_file_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `collective_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `award_name_male` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `award_name_female` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `closed` tinyint(4) NOT NULL DEFAULT '0',
  `award_blurb` text CHARACTER SET latin1,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  `website` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `award_group_id` mediumint(8) unsigned DEFAULT NULL,
  `branch_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`award_id`),
  KEY `FK_award__precedence` (`type_id`),
  KEY `FK_award__last_edited` (`last_updated_by`),
  KEY `FK_award__award_group` (`award_group_id`),
  KEY `FK_award__branch` (`branch_id`),
  CONSTRAINT `FK_award__award_group` FOREIGN KEY (`award_group_id`) REFERENCES `award_group` (`award_group_id`),
  CONSTRAINT `FK_award__branch` FOREIGN KEY (`branch_id`) REFERENCES `atlantia_branch`.`branch` (`branch_id`),
  CONSTRAINT `FK_award__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_award__precedence` FOREIGN KEY (`type_id`) REFERENCES `precedence` (`type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=849 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `award`
--

LOCK TABLES `award` WRITE;
/*!40000 ALTER TABLE `award` DISABLE KEYS */;
INSERT INTO `award` VALUES 
(1,'Sovereign',1,1,1,NULL,'Monarchs','King','Queen',0,NULL,NULL,NULL,NULL,NULL,NULL),
(2,'Consort',1,1,1,NULL,'Monarchs','King','Queen',0,NULL,NULL,NULL,NULL,NULL,NULL),
(3,'Heir (Sovereign)',1,2,2,NULL,'Heirs','Prince','Princess',0,NULL,NULL,NULL,NULL,NULL,NULL),
(4,'Heir (Consort)',1,2,2,NULL,'Heirs','Prince','Princess',0,NULL,NULL,NULL,NULL,NULL,NULL),
(5,'Sovereign-Principality',1,3,1,NULL,NULL,'Prince','Princess',0,NULL,NULL,NULL,NULL,NULL,NULL),
(6,'Consort-Principality',1,3,1,NULL,NULL,'Prince','Princess',0,NULL,NULL,NULL,NULL,NULL,NULL),
(7,'Heir-Principality (Sovereign)',1,4,2,NULL,NULL,'Prince','Princess',0,NULL,NULL,NULL,NULL,NULL,NULL),
(8,'Heir-Principality (Consort)',1,4,2,NULL,NULL,'Prince','Princess',0,NULL,NULL,NULL,NULL,NULL,NULL),
(9,'Duchy',1,5,3,'duchy_sq.gif','Royal Peers - Dukes/Duchesses','Duke','Duchess',0,'One becomes a Duke or Duchess after ruling a kingdom twice.',NULL,NULL,NULL,NULL,NULL),
(10,'County',1,6,4,'county_sq.gif','Royal Peers - Counts/Countesses','Count','Countess',0,'One becomes a Count or Countess after ruling a kingdom once.',NULL,NULL,NULL,NULL,NULL),
(11,'Viscounty',1,7,5,'viscounty_sq.gif','Royal Peers - Viscounts/Viscountesses','Viscount','Viscountess',0,'One becomes a Viscount or Viscountess after ruling a principality once. These are from foreign principalities, or from the time when Atlantia was a principality of the East Kingdom. Atlantia has no principalities at this time.',NULL,NULL,NULL,NULL,NULL),
(12,'Laurel',1,8,6,'laurel.gif','Order of the Laurel','Master of the Laurel','Mistress of the Laurel',0,'One becomes a Laurel through excellence in the arts and sciences.','2006-01-20',NULL,'http://laurels.atlantia.sca.org',NULL,NULL),
(13,'Pelican',1,8,6,'pelican.gif','Order of the Pelican','Master of the Pelican','Mistress of the Pelican',0,'One becomes a Pelican through excellence in service.',NULL,NULL,NULL,NULL,NULL),
(14,'Knight',1,8,7,'knight.gif','Order of the Chivalry','Knight','Knight',0,'One becomes a Knight through martial prowess on the field.  Knights swear fealty to the Crown.','2009-04-01',7,NULL,1,NULL),
(15,'Master/Mistress of Arms',1,8,6,'m_at_arms.gif','Order of the Chivalry','Master of Arms','Mistress at Arms',0,'One becomes a Master/Mistress at Arms through martial prowess on the field.  Master/Mistress at Arms do not swear fealty to the Crown.','2009-04-01',7,NULL,1,NULL),
(16,'Rose (PoA)',1,8,NULL,'rose.gif','Order of the Rose','Lord of the Rose','Lady of the Rose',0,'Atlantian Consorts are inducted into the Order of the Rose upon completion of their first reign.',NULL,NULL,NULL,2,NULL),
(17,'Patent of Arms',1,9,NULL,NULL,'Patent of Arms',NULL,NULL,0,'A Patent of Arms is awarded to a recipient along with the first Royal (County, Viscounty) or Bestowed (Chivalry, Laurel, Pelican, Rose) Peerage.','2005-10-18',NULL,NULL,NULL,NULL),
(18,'Territorial Baronage',1,10,8,'baron_sq.gif','Territorial Barons/Baronesses','Territorial Baron','Territorial Baroness',0,'Landed Baronage is appointed by the Crown.  These are current Territorial Barons and Baronesses.','2008-02-21',7,NULL,NULL,NULL),
(19,'Retired Territorial Baronage',1,22,NULL,'baron_sq.gif','Retired Territorial Barons/Baronesses','Territorial Baron, Retired','Territorial Baroness, Retired',0,'Landed Baronage is appointed by the Crown.  These are former Territorial Barons and Baronesses of the Known World.','2008-10-22',7,NULL,9,NULL),
(20,'White Scarf',0,12,9,'white_scarf.gif','Order of the White Scarf','Companion of the White Scarf','Companion of the White Scarf',0,'One receives a White Scarf for prowess in rapier combat.','2006-01-20',NULL,'http://www.mindspring.com/~aedan/',NULL,8),
(21,'Pearl (GoA)',0,12,9,'pearl.gif','Order of the Pearl','Companion of the Pearl','Companion of the Pearl',0,'One becomes a Pearl through teaching and excellence in the arts and sciences.','2006-01-20',NULL,'http://pearls.atlantia.sca.org',4,8),
(22,'Kraken (GoA)',0,12,9,'kraken.gif','Order of the Kraken','Companion of the Kraken','Companion of the Kraken',0,'One is awarded the Kraken for excellence in the martial arts.',NULL,NULL,NULL,5,8),
(23,'Sea Stag (GoA)',0,12,9,'sea_stag.gif','Order of the Sea Stag','Companion of the Sea Stag','Companion of the Sea Stag',0,'One becomes a Sea Stag through excellence in teaching the martial arts.',NULL,NULL,NULL,6,8),
(24,'Yew Bow (GoA)',0,12,9,'yew_bow.gif','Order of the Yew Bow','Companion of the Yew Bow','Companion of the Yew Bow',0,'One is awarded the Yew Bow for excellence in archery.',NULL,NULL,NULL,7,8),
(25,'Golden Dolphin (GoA)',0,12,9,'golden_dolphin.gif','Order of the Golden Dolphin','Companion of the Golden Dolphin','Companion of the Golden Dolphin',0,'One becomes a Golden Dolphin through excellence in service.','2008-01-27',7,'http://goldendolphins.atlantia.sca.org',8,8),
(26,'Grant of Arms',1,13,9,NULL,'Grants of Arms',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL),
(27,'Opal',0,14,9,'opal.gif','Order of the Opal','Companion of the Opal','Companion of the Opal',0,'Non-polling order given to those who excel in service to the kingdom.',NULL,NULL,NULL,NULL,8),
(28,'Coral Branch',0,14,9,'coral_branch.gif','Order of the Coral Branch','Companion of the Coral Branch','Companion of the Coral Branch',0,'Non-polling order given to those who excel in the Arts and Science in the kingdom.',NULL,NULL,NULL,NULL,8),
(29,'King\'s Missiliers',0,14,9,'kings_missiliers.gif','Order of the King\'s Missiliers','Companion of the King\'s Missiliers','Companion of the King\'s Missiliers',0,'Non-polling order given to those who excel in archery/siege/thrown weapons in the kingdom.',NULL,NULL,NULL,NULL,8),
(30,'Silver Osprey',0,14,9,'silver_osprey.gif','Order of the Silver Osprey','Companion of the Silver Osprey','Companion of the Silver Osprey',0,'Non-polling order given to those who excel in fighting in the kingdom.','2007-11-12',7,NULL,NULL,8),
(31,'Sea Dragon',0,14,9,'sea_dragon.gif','Order of the Sea Dragon','Companion of the Sea Dragon','Companion of the Sea Dragon',0,'Non-polling order given to those who excel in Rapier fighting in the kingdom.','2007-11-12',7,NULL,NULL,8),
(32,'Supporters',1,18,NULL,NULL,'Supporters','Supporters','Supporters',0,NULL,'2005-12-04',NULL,NULL,NULL,NULL),
(33,'Court Baronage (AoA)',1,16,8,'cbaron_sq.gif','Court Barons/Baronesses','Court Baron','Court Baroness',0,'Court Baronages are given at the pleasure of the Crown.',NULL,NULL,NULL,3,NULL),
(34,'Award of Arms',1,17,9,NULL,'Awards of Arms','Award of Arms','Award of Arms',0,NULL,'2005-10-30',NULL,NULL,NULL,NULL),
(35,'Augmentation of Arms',1,18,NULL,NULL,'Augmentations of Arms','Augmentation of Arms','Augmentation of Arms',0,NULL,NULL,NULL,NULL,NULL,NULL),
(36,'Queen\'s Order of Courtesy',1,18,NULL,'qoc.gif','Queen\'s Order of Courtesy','Companion of the Queen\'s Order of Courtesy','Companion of the Queen\'s Order of Courtesy',0,'An accolade to courtesy as designated by the Queen.',NULL,NULL,NULL,NULL,NULL),
(37,'Nonpareil',0,18,NULL,'nonpareil.gif','Order of the Nonpareil','Companion of the Nonpareil','Companion of the Nonpareil',0,'One is awarded the Nonpareil for personifying what it is to be an Atlantian. This award may only be given once per reign.',NULL,NULL,NULL,NULL,8),
(38,'Shark\'s Tooth',0,18,NULL,'sharks_tooth.gif','Award of the Shark\'s Tooth','Award of the Shark\'s Tooth','Award of the Shark\'s Tooth',0,'One is awarded a shark\'s tooth for an act of bravery on the field.',NULL,NULL,NULL,NULL,8),
(39,'Silver Nautilus',0,18,NULL,'silver_nautilus.gif','Award of the Silver Nautilus','Award of the Silver Nautilus','Award of the Silver Nautilus',0,'One is awarded the Silver Nautilus in recognition of skill in the arts and sciences.',NULL,NULL,NULL,NULL,8),
(40,'King\'s Award of Excellence',0,18,NULL,'kae.gif','King\'s Award of Excellence','King\'s Award of Excellence','King\'s Award of Excellence',0,'One is awarded the KAE for excellence in service to the King and kingdom.',NULL,NULL,NULL,NULL,8),
(41,'Undine',0,18,NULL,'undine.gif','Award of the Undine','Award of the Undine','Award of the Undine',0,'One is awarded the Undine for excellence in service to the Queen.',NULL,NULL,NULL,NULL,8),
(42,'Herring',0,18,NULL,'herring.gif','Award of the Herring','Award of the Herring','Award of the Herring',0,'One is awarded the Herring for extraordinary achievement as an autocrat',NULL,NULL,NULL,NULL,8),
(43,'Fountain',0,18,NULL,'fountain.gif','Award of the Fountain','Award of the Fountain','Award of the Fountain',0,'One is awarded the Fountain in recognition of service to the kingdom.','2009-06-09',7,NULL,NULL,8),(44,'Sea Urchin',0,18,NULL,'sea_urchin.gif','Award of the Sea Urchin','Companion of the Sea Urchin','Companion of the Sea Urchin',0,'The Award of the Sea Urchin honors and recognizes those young people (up to and including the age of 17) who have distinguished themselves by their contributions to the Kingdom of Atlantia in service, martial activities, and/or arts and sciences.','2009-01-31',7,NULL,NULL,8),(45,'Hippocampus',0,18,NULL,'hippocampus.gif','Award of the Hippocampus','Award of the Hippocampus','Award of the Hippocampus',0,'The Order of the Hippocampus honors and recognizes youths, whose service and contributions to the Kingdom of Atlantia have distinguished themselves in the eyes of the Crown and Kingdom. All past recipients of the Award of the Hippocampus (which is now closed) will be considered to be recipients of this award.','2009-01-31',7,NULL,NULL,8),(46,'Arielle',0,18,NULL,'arielle.gif','Award of Arielle','Award of Arielle','Award of Arielle',0,'Children are awarded the Arielle for acts of courtesy.','2009-10-06',7,NULL,NULL,8),(47,'Saint Aidan',0,18,NULL,'saint_aidan.gif','Company of Sergeants of Saint Aidan','Companion of Saint Aidan','Companion of Saint Aidan',0,'This is a fighting company where new members are selected by existing members and brought in by the King.','2006-01-20',NULL,'http://staiden.atlantia.sca.org',NULL,8),(48,'l\'Academie d\'Espée',0,18,NULL,NULL,'Order of l\'Academie d\'Espée','Companion of l\'Academie d\'Espée','Companion of l\'Academie d\'Espée',1,'Closed order for prowess on the rapier field.','2006-01-20',NULL,'http://www.mindspring.com/~aedan/',NULL,8),(49,'Silver Needle',0,18,NULL,NULL,'Order of the Silver Needle','Companion of the Silver Needle','Companion of the Silver Needle',1,'Closed order for costuming.',NULL,NULL,NULL,NULL,8),(50,'Kitty Hawk',0,20,NULL,NULL,'Order of the Kitty Hawk','Companion of the Kitty Hawk','Companion of the Kitty Hawk',0,'For service to the Barony','2006-02-25',NULL,NULL,NULL,20),(51,'Don Quixote',0,20,NULL,NULL,'Order of the Don Quixote','Companion of the Don Quixote','Companion of the Don Quixote',0,'For service to the Barony beyond reason','2006-02-25',NULL,NULL,NULL,20),(52,'St. Nicholas',0,20,NULL,NULL,'Order of the St. Nicholas','Companion of the St. Nicholas','Companion of the St. Nicholas',0,'For service by or for children','2006-02-25',NULL,NULL,NULL,20),(53,'Boreas',0,20,NULL,NULL,'Order of the Boreas','Companion of the Boreas','Companion of the Boreas',0,'For excellence in arts and sciences','2006-02-25',NULL,NULL,NULL,20),(54,'Tempest',0,20,NULL,NULL,'Order of the Tempest','Companion of the Tempest','Companion of the Tempest',0,'For excellence on the fighting field','2006-02-25',NULL,NULL,NULL,20),(55,'Baronial Award of Excellence',0,20,NULL,NULL,'Baronial Award of Excellence',NULL,NULL,0,'At the discretion of the Baronage','2006-02-25',NULL,NULL,NULL,20),(56,'Purple Heart',0,20,NULL,NULL,'Award of the Purple Heart','Award of the Purple Heart','Award of the Purple Heart',0,'For people injured in service to the Barony','2007-02-18',7,NULL,NULL,20),(57,'Cat\'s Meow',0,20,NULL,NULL,'Award of the Cat\'s Meow','Award of the Cat\'s Meow','Award of the Cat\'s Meow',0,'Given to newer members of the Barony in recognition of their contributions to the Barony.','2007-02-18',7,NULL,NULL,20),(58,'Windfriend',0,20,NULL,NULL,'Award of the Windfriend','Award of the Windfriend','Award of the Windfriend',0,NULL,NULL,NULL,NULL,NULL,20),(59,'Dormant Kittyhawk',0,20,NULL,NULL,'Award of the Dormant Kittyhawk','Award of the Dormant Kittyhawk','Award of the Dormant Kittyhawk',0,'For members of the Barony who have the ability to fall asleep anywhere.','2007-02-18',7,NULL,NULL,20),(60,'Umbonis Ferrei Ordo (UFO)',0,20,NULL,NULL,'Award of the Umbonis Ferrei Ordo (UFO)','Award of the Umbonis Ferrei Ordo (UFO)','Award of the Umbonis Ferrei Ordo (UFO)',0,'The Umbonis Ferrei Ordo, which means \"Order of the Iron Boss\"  in  Latin, or as it traditionally is called, the \"UFO\" is given by the Baronage of Caer Mear, either jointly or separately,  for excellence in the martial arts of the Society.  This award was originally called \"The Unnamed Fighting Order\" for many years, and was renamed by Baron Aedan Alywyn on the suggestion of Master Thomas Broadpaunch.','2008-08-27',7,NULL,NULL,21),(61,'La Bris de Mer',0,20,NULL,NULL,'Order of La Bris de Mer','Companion of La Bris de Mer','Companion of La Bris de Mer',0,'The Order of La Bris de Mer, which means \"The Sea Breeze,\" is given by the Baronage of Caer Mear, either jointly or separately, for enriching the Barony in the arts and sciences of the Society. This award was named La Bris de Mer by Baron Corby and Baroness Thorja.','2008-08-27',7,NULL,NULL,21),(62,'Pharos',0,20,NULL,NULL,'Order of the Pharos','Companion of the Pharos','Companion of the Pharos',0,'The oldest of Caer Mear\'s awards, the Order of the Pharos (named after the lighthouse of Alexandria)  is given for exemplary service to the Barony, by the Baronage of Caer Mear, either jointly or separately. Its Badge is: Gules, atop a grey granite tower a beacon enflamed proper. This award was created by the Founding Baron of Caer Mear, Thomas-Edmund de Warrick.','2008-08-27',7,NULL,NULL,21),(63,'Cornerstone',0,20,NULL,NULL,'Order of the Cornerstone','Companion of the Cornerstone','Companion of the Cornerstone',0,'The Cornerstone is awarded by the Baronage of Caer Mear, either jointly or separately, to youth who have distinguished themselves by their contributions to the Barony. The Cornerstone was created by Baron Balynar Thorvaldsson.','2008-08-27',7,NULL,NULL,21),(64,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy','Baroness\' Award of Courtesy','Baroness\' Award of Courtesy',0,'Given solely at the discretion of the Baroness of Caer Mear, this award is given to those gentles that she feels exemplify courtesy and grace. This award may be received multiple times. Baroness Alewyn Adair created this award.','2008-08-27',7,NULL,NULL,21),(65,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence','Baron\'s Award of Excellence','Baron\'s Award of Excellence',0,'Given solely at the discretion of the Baron of Caer Mear, this award is given to those gentles he finds exceptional. This award may be received multiple times and was created by Baron Manfred Gustsson.','2008-08-27',7,NULL,NULL,21),(66,'Honor of the Corbie',0,20,NULL,NULL,'Honor of the Corbie','Honor of the Corbie','Honor of the Corbie',0,'Fighting award','2006-07-25',NULL,NULL,NULL,127),(67,'Lozulet',0,20,NULL,NULL,'Order of the Lozulet','Companion of the Lozulet','Companion of the Lozulet',0,'Membership in this order is granted by the Baron and/or Baroness those gentles who have demonstrated continued and significant service.','2006-08-02',NULL,NULL,NULL,22),(68,'Faering',0,20,NULL,NULL,'Order of the Faering','Companion of the Faering','Companion of the Faering',0,'This order is composed of those gentles who, as children, have enhanced the Barony.','2006-02-25',NULL,NULL,NULL,22),(69,'Silver Silkie',0,20,NULL,NULL,'Company of the Silver Silkie','Companion of the Company of the Silver Silkie','Companion of the Company of the Silver Silkie',0,'Membership in this order is granted by the Baron and/or Baroness to those gentles who have excelled in Storviks war efforts.','2006-02-25',NULL,NULL,NULL,22),(70,'Owl',0,20,NULL,NULL,'Order of the Owl','Companion of the Owl','Companion of the Owl',0,'Membership in this order is composed of those gentles who have excelled in the Arts and Sciences in the Barony.','2006-02-25',NULL,NULL,NULL,22),(71,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy',NULL,NULL,0,'Given by the Baroness for selfless service and support to the Barony of Storvik.','2006-08-20',NULL,NULL,NULL,22),(72,'Coill\'s Bells',0,20,NULL,NULL,'Order of the Coill\'s Bells','Order of the Coill\'s Bells','Order of the Coill\'s Bells',0,'Given to children sixteen years of age and under who have distinguished themselves by their contributions to the Barony.','2006-05-03',NULL,NULL,NULL,23),(73,'Coill\'s Champions',0,20,NULL,NULL,'Order of the Coill\'s Champions','Order of the Coill\'s Champions','Order of the Coill\'s Champions',0,'For past Baronial Champions.','2006-05-03',NULL,NULL,NULL,23),(74,'Coill\'s Muse',0,20,NULL,NULL,'Order of the Coill\'s Muse','Order of the Coill\'s Muse','Order of the Coill\'s Muse',0,'For excellence in the Arts and Sciences.','2006-05-03',NULL,NULL,NULL,23),(75,'Gordian Knot',0,20,NULL,NULL,'Order of the Gordian Knot','Order of the Gordian Knot','Order of the Gordian Knot',0,'For service to the barony (formerly called Coill\'s Tripaliare.)','2006-05-03',NULL,NULL,NULL,23),(76,'Pewter Spoon',0,20,NULL,NULL,'Order of the Pewter Spoon','Order of the Pewter Spoon','Order of the Pewter Spoon',0,'For skill in planning and cooking feasts.','2006-05-03',NULL,NULL,NULL,23),(77,'Silver Knot',0,20,NULL,NULL,'Order of the Silver Knot','Order of the Silver Knot','Order of the Silver Knot',0,'For service to the Barony by a gentle not residing in the Barony.','2006-05-03',NULL,NULL,NULL,23),(78,'Sword Knot',0,20,NULL,NULL,'Order of the Sword Knot','Order of the Sword Knot','Order of the Sword Knot',0,'For excellence in the martial arts.','2006-05-03',NULL,NULL,NULL,23),(79,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence',NULL,NULL,0,'Given to those gentles whose works have been particularly pleasing to the Baron.','2007-11-27',7,NULL,NULL,23),(80,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy',NULL,NULL,0,'Given by the Baroness to those gentles she deems worthy by reason of their exceptional display of grace and courtesy.','2007-11-27',7,NULL,NULL,23),(81,'Coill\'s Guiding Beacon',0,20,NULL,NULL,'Coill\'s Guiding Beacon',NULL,NULL,0,'Given to those gentles who by word and deed act as guides to those seeking the lights of Chivalry and Courtesy.','2006-05-03',NULL,NULL,NULL,23),(82,'Golden Cord',0,20,NULL,NULL,'Award of the Golden Cord','Award of the Golden Cord','Award of the Golden Cord',0,'Given by the Baroness to those gentles who have done service directly for her.','2006-05-03',NULL,NULL,NULL,23),(83,'Golden Knot',0,20,NULL,NULL,'Award of the Golden Knot','Award of the Golden Knot','Award of the Golden Knot',0,'For excellence in Arts and Sciences.','2006-05-03',NULL,NULL,NULL,23),(84,'Hydra\'s Coill',0,20,NULL,NULL,'Award of the Hydra\'s Coill','Award of the Hydra\'s Coill','Award of the Hydra\'s Coill',0,'For contributions to the Barony by a group.','2006-05-03',NULL,NULL,NULL,23),(85,'Swan and Cygnet',0,20,NULL,NULL,'Order of the Swan and Cygnet','Companion of the Swan and Cygnet','Companion of the Swan and Cygnet',0,'Baronial service award','2006-10-03',NULL,NULL,NULL,24),(86,'Orca',0,20,NULL,NULL,'Order of the Orca','Companion of the Orca','Companion of the Orca',0,'Baronial heavy fighting award','2006-10-03',NULL,NULL,NULL,24),(87,'Golden Phoenix',0,20,NULL,NULL,'Order of the Golden Phoenix','Companion of the Golden Phoenix','Companion of the Golden Phoenix',0,'Baronial long-term service award','2006-10-03',NULL,NULL,NULL,24),(88,'Whelk',0,20,NULL,NULL,'Order of the Whelk','Companion of the Whelk','Companion of the Whelk',0,'Baronial A&S award','2006-10-03',NULL,NULL,NULL,24),(89,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence',NULL,NULL,0,NULL,'2006-02-25',NULL,NULL,NULL,24),(90,'Baroness\' Order of Courtesy',0,20,NULL,NULL,'Baroness\' Order of Courtesy',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,24),(91,'Flying Sea Monkey',0,20,NULL,NULL,'Order of the Flying Sea Monkey','Companion of the Flying Sea Monkey','Companion of the Flying Sea Monkey',0,NULL,'2006-10-03',NULL,NULL,NULL,24),(92,'Sable Skate',0,20,NULL,NULL,'Order of the Sable Skate','Companion of the Sable Skate','Companion of the Sable Skate',0,'Baronial archery award','2006-10-03',NULL,NULL,NULL,24),(93,'[TBD - rapier]',0,20,NULL,NULL,'Order of [TBD - rapier]','Companion of [TBD - rapier]','Companion of [TBD - rapier]',0,'Baronial rapier award',NULL,NULL,NULL,NULL,24),(94,'Sacred Stone',0,20,NULL,NULL,'Order of the Sacred Stone','Companion of the Sacred Stone','Companion of the Sacred Stone',0,'Established in 1982 to recognize outstanding service and dedication to the barony over a long period of time and with the promise of continuing service in the future.','2006-02-25',NULL,NULL,NULL,25),(95,'Phoenix Claw',0,20,NULL,NULL,'Order of the Phoenix Claw','Companion of the Phoenix Claw','Companion of the Phoenix Claw',0,'Established in 1983 to recognize outstanding performance on the field of battle in heavy weapons within the Barony of the Sacred Stone. In 1991, Baron Bran Trefonnen opened this Order to rapier as well.','2006-02-25',NULL,NULL,NULL,25),(96,'Phoenix Eye',0,20,NULL,NULL,'Order of the Phoenix Eye','Companion of the Phoenix Eye','Companion of the Phoenix Eye',0,'Established in 1982 to recognize outstanding Arts and Sciences achievements within the Barony of the Sacred Stone. This includes the teaching of that art in the Barony and its use on the Barony\'s behalf.','2006-02-25',NULL,NULL,NULL,25),(97,'Phoenix Heart',0,20,NULL,NULL,'Order of the Phoenix Heart','Companion of the Phoenix Heart','Companion of the Phoenix Heart',0,'Established in 1988 to recognize courtesy and chivalry in the Barony of the Sacred Stone. The original name of the Order had to be changed to its current name in 1992.','2006-02-25',NULL,NULL,NULL,25),(98,'Yeoman of the Sacred Stone',0,20,NULL,NULL,'Order of the Yeoman of the Sacred Stone','Companion of the Yeoman of the Sacred Stone','Companion of the Yeoman of the Sacred Stone',0,'Created in 1991 to recognize outstanding light weapons contributions on the field, specifically archers and scouts. This is not currently a polling Order due to its small size.','2006-02-25',NULL,NULL,NULL,25),(99,'Baronial Award of Excellence',0,20,NULL,NULL,'Baronial Award of Excellence',NULL,NULL,0,'First given in 1991 and recognizes outstanding achievement in the arts and sciences by a specific work or project. It is now an award of general excellence.','2006-02-25',NULL,NULL,NULL,25),(100,'Flame of the Phoenix',0,20,NULL,NULL,'Award of the Flame of the Phoenix','Award of the Flame of the Phoenix','Award of the Flame of the Phoenix',0,'Created and first given in 1986 as special recognition for the contributions of newcomers to the Barony. It is now an award recognizing an outstanding feat of service in the Barony.','2006-02-25',NULL,NULL,NULL,25),(101,'Feather of the Phoenix',0,20,NULL,NULL,'Award of the Feather of the Phoenix','Award of the Feather of the Phoenix','Award of the Feather of the Phoenix',0,'Created and first given in 1986 to recognize the special contributions made by the Barony\'s children.','2006-02-25',NULL,NULL,NULL,25),(102,'Talon of the Phoenix',0,20,NULL,NULL,'Award of the Talon of the Phoenix','Award of the Talon of the Phoenix','Award of the Talon of the Phoenix',0,'First given in 1992 and recognizes outstanding achievement on the field of battle during a specific event.','2006-02-25',NULL,NULL,NULL,25),(103,'Drakken Egg',0,20,NULL,NULL,'Award of the Drakken Egg','Award of the Drakken Egg','Award of the Drakken Egg',0,'First given in 1993 to recognize contributions made on the behalf of newcomers. It is now an award recognizing outstanding contributions made by newcomers.','2006-02-25',NULL,NULL,NULL,25),(104,'Spirit of the Phoenix',0,20,NULL,NULL,'Award of the Spirit of the Phoenix','Award of the Spirit of the Phoenix','Award of the Spirit of the Phoenix',0,'First given in 2001 and recognizes contributions made on behalf of the Barony from people who live outside its geographical boundaries.','2006-02-25',NULL,NULL,NULL,25),(105,'Ember of the Phoenix',0,20,NULL,NULL,'Award of the Ember of the Phoenix','Award of the Ember of the Phoenix','Award of the Ember of the Phoenix',0,'Created in 2004 and recognizes outstanding achievement in the arts & sciences by a specific work or project.','2006-02-25',NULL,NULL,NULL,25),(106,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence',NULL,NULL,0,'Traditionally only given once per reign (although that is at the Baron’s discretion), this award recognizes the efforts and actions of an individual that the Baron deems exceptionally worthy of praise and recognition.','2006-02-25',NULL,NULL,NULL,26),(107,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy',NULL,NULL,0,'Normally given once per reign, this award is bestowed upon a gentle that the Baroness feels typifies – in word and deed - the ideals of chivalry and courtesy that are the foundation upon which our Society is built.','2006-02-25',NULL,NULL,NULL,26),(108,'Polished Mirror',0,20,NULL,NULL,'Order of the Polished Mirror','Companion of the Polished Mirror','Companion of the Polished Mirror',0,'Given to populace members during their first year (either in the SCA, or in the barony if still relatively new to the Society), for showing great promise in upholding the ideals of the Society.','2006-02-25',NULL,NULL,NULL,26),(109,'Silver Chalice',0,20,NULL,NULL,'Order of the Silver Chalice','Companion of the Silver Chalice','Companion of the Silver Chalice',0,'Award for leaving members who have contributed greatly to the Barony','2006-02-25',NULL,NULL,NULL,26),(110,'Fettered Crane',0,20,NULL,NULL,'Order of the Fettered Crane','Companion of the Fettered Crane','Companion of the Fettered Crane',0,'Given to those gentles that serve the barony truly and faithfully, in an exceptional manner.','2006-02-25',NULL,NULL,NULL,26),(111,'Silver Crocus',0,20,NULL,NULL,'Order of the Silver Crocus','Companion of the Silver Crocus','Companion of the Silver Crocus',0,'Given to those that instruct the Populace in the diverse arts and sciences that we practice to enrich our Society, and to those that show themselves to be uncommonly studied or practiced in such.','2006-02-25',NULL,NULL,NULL,26),(112,'Sable Blade',0,20,NULL,NULL,'Order of the Sable Blade','Companion of the Sable Blade','Companion of the Sable Blade',0,'Given for excellence in teaching of the martial arts that our Society practices.  More rarely, it is given to those members of the Populace that show exceptional prowess in said arts. (Formerly known as the Baronial Fighting Order.)','2006-05-04',NULL,NULL,NULL,26),(113,'Blade of Diana',0,20,NULL,NULL,'Order of the Blade of Diana','Companion of the Blade of Diana','Companion of the Blade of Diana',0,'Given to those that seek to practice and instruct in the arts of the hunt. These arts include such disciplines as horsemanship, archery, falconry, and the throwing of weapons, although it is by no means limited to such.','2006-02-25',NULL,NULL,NULL,26),(114,'Pinnacle of the Mountain',0,20,NULL,NULL,'Order of the Pinnacle of the Mountain','Order of the Pinnacle of the Mountain','Order of the Pinnacle of the Mountain',0,'The Barony’s highest honor signifying those gentles who consistently give of themselves to the utmost for the benefit of the Barony and through their deeds they have made a significant impact on the Barony.','2007-04-01',7,NULL,NULL,27),(115,'Defenders of the Mountain',0,20,NULL,NULL,'Order of the Defenders of the Mountain','Order of the Defenders of the Mountain','Order of the Defenders of the Mountain',0,'Represents those who have served at least one year as Baronial Champion, protected the Barony and furthered the interest of Heavy Combat.','2007-04-01',7,NULL,NULL,27),(117,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence',NULL,NULL,0,'Honors and recognizes those who have distinguished themselves by their excellent contributions to the Barony of Hidden Mountain. This award is a gift solely of the Baron to whomever he deems deserving. The Award is usually the Barons first initial or some other charge that singularly denotes the Barons that give it.','2007-04-01',7,NULL,NULL,27),(118,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy',NULL,NULL,0,'An accolade to courtesy as designated by the Baroness. Honors and recognizes those gentles who have distinguished themselves with exceptional service to the Barony of Hidden Mountain. The Award is usually the Baroness first initial or some other charge that singularly denotes the Baroness that gives it.','2007-04-01',7,NULL,NULL,27),(119,'Sable Mountain',0,20,NULL,NULL,'Order of the Sable Mountain','Order of the Sable Mountain','Order of the Sable Mountain',0,'Given for constant and exemplary contributions of service to the Barony.','2007-04-01',7,NULL,NULL,27),(120,'Crimson Mountain',0,20,NULL,NULL,'Order of the Crimson Mountain','Order of the Crimson Mountain','Order of the Crimson Mountain',0,'Given for constant and exemplary contributions in the art of combat, either heavy, rapier, or cavalry (if it involves mounted combat).','2007-04-01',7,NULL,NULL,27),(121,'Silver Mountain',0,20,NULL,NULL,'Order of the Silver Mountain','Order of the Silver Mountain','Order of the Silver Mountain',0,NULL,'2007-04-01',7,NULL,NULL,27),(122,'Piedmont',0,20,NULL,NULL,'Award of the Piedmont','Award of the Piedmont','Award of the Piedmont',0,'Honors and recognizes those children who have distinguished themselves by their contributions to the Barony of Hidden Mountain.','2007-04-01',7,NULL,NULL,27),(123,'Light of the Mountain',0,20,NULL,NULL,'Award of the Light of the Mountain','Award of the Light of the Mountain','Award of the Light of the Mountain',1,NULL,'2007-04-01',7,NULL,NULL,27),(124,'Spirit of the Mountain',0,20,NULL,NULL,'Award of the Spirit of the Mountain','Award of the Spirit of the Mountain','Award of the Spirit of the Mountain',1,NULL,'2007-04-01',7,NULL,NULL,27),(125,'Azure Mountain',0,20,NULL,NULL,'Order of the Azure Mountain','Order of the Azure Mountain','Order of the Azure Mountain',0,'Awarded for exemplary work in the arts and sciences while furthering the interest of the art form through teaching, displaying, and competition.','2007-04-01',7,NULL,NULL,27),(126,'Brass Trident',0,20,NULL,NULL,'Award of the Brass Trident','Award of the Brass Trident','Award of the Brass Trident',0,'This award is principally intended to recognize a person who has consistently through continual labor brought honor unto the Barony and its citizens through constant unfailing performance of service or the exemplary execution of the performance of fighting arts over an extended period of time. This is the Barony\'s highest award.','2007-04-11',7,NULL,NULL,28),(127,'Marlin',0,20,NULL,NULL,'Award of the Marlin','Award of the Marlin','Award of the Marlin',0,'This award is principally intended to recognize a person who has shown over a period of time noteworthy skill in the fighting arts (which include heavy weapons, rapier, marshaling, archery, and scouting) and uses that skill to bring honor to the Barony or benefit to its citizens. This includes the basics of fighting, teaching and assisting in the production of armor or weapons without remuneration, providing the general public with a \"living pell\" during demos, or providing leadership for the Baronial fighting unit.','2007-04-11',7,NULL,NULL,28),(128,'Oaken Oar',0,20,NULL,NULL,'Award of the Oaken Oar','Award of the Oaken Oar','Award of the Oaken Oar',0,'This award is principally intended to recognize a person who has, over a period of time, performed service of a general nature that has benefited the Barony. It might also be presented to an individual who has performed one or more acts that have rescued the Barony or some of its citizens from a risky, embarrassing or demeaning situation. It could be also be presented to an individual who has carried out the duties of a demanding Baronial Office exceptionally well.','2007-04-11',7,NULL,NULL,28),(129,'Water Lily',0,20,NULL,NULL,'Award of the Water Lily','Award of the Water Lily','Award of the Water Lily',0,'This award is principally intended to recognize a person who has, over a period of time, shown some noteworthy ability in the Arts and/or Sciences and shares that ability with the general populace either through teaching or display, bringing honor unto the Barony or benefit to its citizens.','2007-04-11',7,NULL,NULL,28),(130,'Sandpiper',0,20,NULL,NULL,'Award of the Sandpiper','Award of the Sandpiper','Award of the Sandpiper',0,'This award is intended to reward the works of children under the age of sixteen. It is awarded for exemplary service to the Barony.','2007-04-11',7,NULL,NULL,28),(131,'Sea Fan',0,20,NULL,NULL,'Award of the Sea Fan','Award of the Sea Fan','Award of the Sea Fan',0,'This award is intended to reward the works of children under the age of sixteen. It is awarded for exemplary work in the Arts and Sciences.','2007-04-11',7,NULL,NULL,28),(132,'The Coin of the Sea',0,20,NULL,NULL,'The Coin of the Sea',NULL,NULL,0,'The Coin of the Sea is an award of special recognition and is given at the discretion of the Baron and/or Baroness. It can be given multiple times and for a variety of reasons. The token is traditionally a golden sand dollar pendant.','2007-04-11',7,NULL,NULL,28),(133,'Company of Artificers of Marinus',0,20,NULL,NULL,'Company of Artificers of Marinus',NULL,NULL,0,'Membership in this company is principally intended to recognize a person who, over a period of time, has shown noteworthy skill in the crafting of items that benefit the Barony.','2007-04-11',7,NULL,NULL,28),(134,'Stewards of St. Marinus',0,20,NULL,NULL,'Order of the Stewards of St. Marinus','Order of the Stewards of St. Marinus','Order of the Stewards of St. Marinus',0,'The order was created to recognize those members of the Barony who have successfully run several Marinus events or have successfully cooked feasts for several Marinus events. Members of this order routinely serve as mentors to new autocrats and feast cooks. Members of the order who were recognized for their work as an autocrat are called Hall Stewards. Members of the order who were recognized for their work as a head cook are called Feast Stewards.','2007-04-11',7,NULL,NULL,28),(135,'Golden Arrow',0,20,NULL,'goldenarrow.gif','Order of the Golden Arrow','Companion of the Golden Arrow','Companion of the Golden Arrow',0,'The Golden Arrow is given by the baron and baroness to members of the barony who have exhibited excellence in archery and archery instruction.','2009-07-12',7,NULL,NULL,29),(136,'Blasted Oak',0,20,NULL,'blastedoak.gif','Order of the Blasted Oak','Companion of the Blasted Oak','Companion of the Blasted Oak',0,'The Blasted Oak is given by the baron and baroness to members of the barony who have exhibited exemplary service to the barony.','2009-07-12',7,NULL,NULL,29),(137,'Eagle\'s Feather',0,20,NULL,'eaglesfeather.gif','Order of the Eagle\'s Feather','Companion of the Eagle\'s Feather','Companion of the Eagle\'s Feather',0,'The Eagle\'s Feather is given by the baron and baroness to members of the barony who have achieved excellence in the arts and sciences.','2009-07-12',7,NULL,NULL,29),(138,'Crab\'s Claw',0,20,NULL,'crabsclaw.gif','Order of the Crab\'s Claw','Companion of the Crab\'s Claw','Companion of the Crab\'s Claw',0,'The Crab\'s Claw is given by the baron and baroness to members of the barony who have distinguished themselves by excelling in the martial arts.','2009-07-12',7,NULL,NULL,29),(139,'Garland',0,20,NULL,'garland.gif','Order of the Garland','Companion of the Garland','Companion of the Garland',0,'The Order of the Garland is given to recognize attainments in the arts and sciences, skill in combat, and/or service to the Barony. The badge of the Order is a yellow garter in annulo. The usual token of the Order is a yellow garter worn about the recipient\'s arm or leg or hung from the wearer\'s belt.','2006-02-19',NULL,'http://pontealto.atlantia.sca.org/ponte_db.php?ponte=41',NULL,30),(140,'Ponte di Ferro',0,20,NULL,'ponte_di_ferro.gif','Onore del Ponte di Ferro','Onore del Ponte di Ferro','Onore del Ponte di Ferro',0,'The Onore del Ponte di Ferro (Award of the Iron Bridge) is given to recognize skill in combat within the Barony.','2006-11-01',7,'http://pontealto.atlantia.sca.org/ponte_db.php?ponte=42',NULL,30),(141,'Ponte d\'Argento',0,20,NULL,NULL,'Onore del  Ponte d\'Argento','Onore del Ponte d\'Argento','Onore del  Ponte d\'Argento',0,'The Onore del Ponte d\'Argento (Award of the Silver Bridge) is given to recognize attainments in the arts and sciences.','2006-11-01',7,'http://pontealto.atlantia.sca.org/ponte_db.php?ponte=43',NULL,30),(142,'Ponte d\'Oro',0,20,NULL,'ponte_d_oro.gif','Onore del Ponte d\'Oro','Onore del Ponte d\'Oro','Onore del Ponte d\'Oro',0,'The Onore del Ponte d\'Oro (Award of the Golden Bridge) is given to recognize service to the Barony.','2006-11-27',7,'http://pontealto.atlantia.sca.org/ponte_db.php?ponte=44',NULL,30),(143,'Sea-Hawk',0,20,NULL,NULL,'Order of the Sea-Hawk','Companion of the Sea-Hawk','Companion of the Sea-Hawk',0,'This is the premire order of the Barony and is granted to those who have demonstrated continued and significant service to the Barony and its people for excellence in any skill, service, or field of combat.','2006-02-27',NULL,NULL,NULL,31),(144,'Mark of Excellence',0,20,NULL,NULL,'Mark of Excellence',NULL,NULL,1,'This award is to those gentles who have made a specific\r\ncontribution to the Barony. Since it is an award, it can be conferred to an individual more than once. Beginning February 2006, an augmentation is given with each Mark to denote what type of contribution the gentle made. The emblem of the award is a red cross bottony. The augmentations are the Carraig Uaine, Carraig Deirge, and Carraig Gile.','2006-04-19',NULL,NULL,NULL,31),(145,'Company of Wayfarers',0,20,NULL,NULL,'Order of the Company of Wayfarers','Companion of the Company of Wayfarers','Companion of the Company of Wayfarers',0,'This order is composed of former members of Dun Carraig who have moved from the lands of the Barony.','2006-02-27',NULL,NULL,NULL,31),(146,'St Barbara',0,20,NULL,NULL,'Order of St Barbara','Companion of St Barbara','Companion of St Barbara',0,'The Order of St Barbara is to be a polling Order for members of the Barony who have been involved with the Barony for 10 years or more.','2005-12-29',NULL,NULL,NULL,32),(147,'Job',0,20,NULL,NULL,'Order of Job','Companion of Job','Companion of Job',0,'This award is given in recognition to members of the populace who have given long term service to Bright Hills.','2005-12-29',NULL,NULL,NULL,32),(148,'Shell and Crescent',0,20,NULL,NULL,'Order of the Shell and Crescent','Companion of the Shell and Crescent','Companion of the Shell and Crescent',0,'This award is given in recognition of skills in the Arts and Sciences.','2005-12-29',NULL,NULL,NULL,32),(149,'Silver Scroll',0,20,NULL,NULL,'Order of the Silver Scroll','Companion of the Silver Scroll','Companion of the Silver Scroll',0,'This award is given in recognition for instruction in the field of Arts and Sciences.','2005-12-29',NULL,NULL,NULL,32),(150,'Silberberg',0,20,NULL,NULL,'Order of the Silberberg','Companion of the Silberberg','Companion of the Silberberg',0,'This award is given in recognition for instruction in the Marshal Arts as well as fighting.','2005-12-29',NULL,NULL,NULL,32),(151,'Augean Stables',0,20,NULL,NULL,'Order of the Augean Stables','Companion of the Augean Stables','Companion of the Augean Stables',0,'This award recognizes those who have enriched the Barony either with one great deed or over extreme effort over a short period of time.','2005-12-29',NULL,NULL,NULL,32),(152,'Silver Oak Leaf',0,20,NULL,NULL,'Order of the Silver Oak Leaf','Companion of the Silver Oak Leaf','Companion of the Silver Oak Leaf',0,'Children are the future of the world and those who show willingness to learn and grow, to make the world, Kingdom, and Barony a brighter place do so receive this recognition.  This order was formerly known as the Heart of the Oak.','2005-12-29',NULL,NULL,NULL,32),(153,'Tessa',0,20,NULL,NULL,'Order of Tessa','Companion of Tessa','Companion of Tessa',0,'This award recognizes the service and enthusiasm of new comers.  It was developed to honor Tessa of Crossgate, who though not with us long did exemplify what it means to be an Atlantian.','2005-12-29',NULL,NULL,NULL,32),(154,'Baronial Award of Excellence',0,20,NULL,NULL,'Baronial Award of Excellence',NULL,NULL,0,'Given to those the Baron/Baroness deems deserving, who have distinguished themselves by their excellent contributions to the barony.','2005-12-29',NULL,NULL,NULL,32),(155,'Glass Slipper',0,20,NULL,NULL,'Award of the Glass Slipper','Award of the Glass Slipper','Award of the Glass Slipper',1,'Given as a token by Baron Barre and Baroness Cordelia to those members of the Barony who stayed to the very end of an event and helped with whatever needs to be done.  They don\'t let Cinderella\'s Glass Slipper become a piece of lost and found.','2007-04-01',7,NULL,NULL,32),(157,'Blue Collar',0,20,NULL,NULL,'Order of the Blue Collar','Companion of the Blue Collar','Companion of the Blue Collar',1,'Given as a token of thanks for the everyday hard work performed by a member of the hard working barony.','2006-08-20',NULL,NULL,NULL,32),(158,'Blackstar',0,20,NULL,NULL,'Order of the Blackstar','Companion of the Blackstar','Companion of the Blackstar',1,'Given as a token by the Founding Baron and Baroness at their investiture to three individuals: Mistress Jeanne de Bec, Master Chirhart Blackstar, and Mistress Anne of Hatfield.  These three gentles were recognized for their willingness to open their home to host Investiture, when the original site was closed due to snow','2005-12-29',NULL,NULL,NULL,32),(159,'Cat\'s Paw',0,20,NULL,NULL,'Order of the Cat\'s Paw','Companion of the Cat\'s Paw','Companion of the Cat\'s Paw',1,'Given as a token from Baroness Ekaterina Vladimirovna.  This recognition was retired on April 28, 2001.','2005-12-29',NULL,NULL,NULL,32),(160,'Baronial Service Award',0,20,NULL,NULL,'Baronial Service Award',NULL,NULL,1,'Given to those who served the Barony prior to development of service awards.','2005-12-29',NULL,NULL,NULL,32),(161,'Baroness\' Gold Star',0,20,NULL,NULL,'Baroness\' Gold Star',NULL,NULL,1,'Given to the children of the Barony prior to development of the Silver Oak Leaf','2005-12-29',NULL,NULL,NULL,32),(162,'Saint Roch',0,20,NULL,NULL,'Order of Saint Roch','Companion of Saint Roch','Companion of Saint Roch',0,'Given to those subjects who have distinguished themselves by their service to the Barony.\r\n\r\nConverted from the original Holy Cow award where it was said \"Holy Cow, you have done a lot of work!\"','2007-11-08',7,NULL,NULL,33),(163,'Silver Bow',0,20,NULL,NULL,'Award of the Silver Bow','Award of the Silver Bow','Award of the Silver Bow',0,'Given to those subjects who have distinguished themselves by their skill with bow and arrow, either target or combat. It recognizes also their leadership in furthering combat or target archery education and techniques, and their honorable deportment on and off the field.  Formerly called the Order of the Vined Bow.','2007-12-02',7,NULL,NULL,33),(164,'Minotaur',0,20,NULL,NULL,'Award of the Minotaur','Award of the Minotaur','Award of the Minotaur',0,'Given to those subjects of the barony who have distinguished themselves by their efforts on the heavy fighting field in defense of Stierbach. Formerly called the Order of Theseus.','2007-12-02',7,NULL,NULL,33),(165,'Silver Glove',0,20,NULL,NULL,'Award of the Silver Glove','Award of the Silver Glove','Award of the Silver Glove',0,'Given to those subjects of the barony who have distinguished themselves by their efforts on the rapier fighting field in defense of Stierbach.  Formerly called the Order of the Argent Glove.','2007-12-02',7,NULL,NULL,33),(166,'Silver Axe',0,20,NULL,NULL,'Award of the Silver Axe','Award of the Silver Axe','Award of the Silver Axe',0,'Given to those subjects of the barony who have distinguished themselves by their efforts on the thrown weapons fighting field in defense of Stierbach.  Formerly called the Order of the Dueling Axe.','2007-12-02',7,NULL,NULL,33),(167,'Silver Compass',0,20,NULL,NULL,'Award of the Silver Compass','Award of the Silver Compass','Award of the Silver Compass',0,'Given to those subjects of the barony who have distinguished themselves by their efforts and willingness to teach others the arts and sciences of the period, and/or those who have achieved excellence in the arts and sciences of the period.  Formerly called the Northern Star Award.','2007-12-02',7,NULL,NULL,33),(168,'Silver Heart',0,20,NULL,NULL,'Order of the Silver Heart','Companion of the Silver Heart','Companion of the Silver Heart',0,'Given to those subjects of the barony who have distinguished themselves far and above the ordinary in service to the barony.  Formerly called the Heart of Stierbach.','2007-12-02',7,NULL,NULL,33),(169,'Bull and Crescent',0,20,NULL,NULL,'Award of the Bull and the Crescent','Award of the Bull and the Crescent','Award of the Bull and the Crescent',0,'Given to those children of the barony who have distinguished themselves far and above the ordinary in service to the barony.  Formerly called the Promise of Stierbach, and briefly the Silver Moon.','2008-10-20',7,NULL,NULL,33),(170,'Holder of the Dreamer\'s Cup',0,20,NULL,NULL,'Holder of the Dreamer\'s Cup',NULL,NULL,0,'Token acknowledging an individual who has best embodied the spirit of the Society during a Baronial event.\r\n\r\nSelected by the Autocrat, Seneschal, Baroness, and current holder for the Cup. (Baron will act as tie breaker.)\r\n\r\nRecipient has privilege of carrying the cup at all events he/she attends until the next Baronial event, when a successor is selected, and the cup is passed on.','2006-02-25',NULL,NULL,NULL,33),(171,'Baronial Award of Excellence',0,20,NULL,'hf_bae.gif','Baronial Award of Excellence',NULL,NULL,0,'Recognizes outstanding achievement in any particular area of endeavor by the Populace. The award is given at the pleasure of the Coronets and may be received more than once.','2006-02-25',NULL,NULL,NULL,34),(172,'Hart',0,20,NULL,'hart.gif','Order of the Hart','Companion of the Order of the Hart','Companion of the Order of the Hart',0,'Given to recognize outstanding service and dedication by residents of the Barony of Highland Foorde over a long period of time and with the promise of continuing service in the future.','2006-02-25',NULL,NULL,NULL,34),(173,'Lark',0,20,NULL,'lark.gif','Order of the Lark','Companion of the Order of the Lark','Companion of the Order of the Lark',0,'Given to those residents within the Barony of Highland Foorde who have distinguished themselves by their long-term efforts in Arts & Sciences. This includes the teaching of that art in the Barony and/or its use on the Barony\'s behalf.','2006-02-25',NULL,NULL,NULL,34),(174,'Golden Hawk',0,20,NULL,'golden_hawk.gif','Order of the Golden Hawk','Companion of the Order of the Golden Hawk','Companion of the Order of the Golden Hawk',0,'Given to recognize superior performance and dedication in the Arts of War by residents of the Barony of Highland Foorde. The Arts of War include heavy weapons, rapier or archery as well as any new forms, which may be approved by the Kingdom of Atlantia.','2006-02-25',NULL,NULL,NULL,34),(175,'Golden Moon',0,20,NULL,NULL,'Order of the Golden Moon','Order of the Golden Moon','Order of the Golden Moon',0,'For Service to the group','2007-04-22',7,NULL,NULL,35),(176,'Goshawk',0,20,NULL,NULL,'Order of the Goshawk','Order of the Goshawk','Order of the Goshawk',0,'For Martial activities to the group','2006-02-19',NULL,NULL,NULL,35),(177,'Silver Hawk',0,20,NULL,NULL,'Order of the Silver Hawk','Order of the Silver Hawk','Order of the Silver Hawk',0,'For A&S to the group','2007-04-22',7,NULL,NULL,35),(178,'Baronial Award of Excellence',0,20,NULL,NULL,'Baronial Award of Excellence',NULL,NULL,0,NULL,'2007-04-22',7,NULL,NULL,35),(179,'Silver Decrescent',0,20,NULL,NULL,'Award of the Silver Decrescent','Award of the Silver Decrescent','Award of the Silver Decrescent',0,'For a specific Service','2007-04-22',7,NULL,NULL,35),(180,'Silver Jess',0,20,NULL,NULL,'Award of the Silver Jess','Award of the Silver Jess','Award of the Silver Jess',0,'For a specific Martial activity','2007-04-22',7,NULL,NULL,35),(181,'Silver Wings of Hawkwood',0,20,NULL,NULL,'Award of the Silver Wings of Hawkwood','Award of the Silver Wings of Hawkwood','Award of the Silver Wings of Hawkwood',0,'For a specific A&S','2007-04-22',7,NULL,NULL,35),(182,'Eyas of Hawkwood',0,20,NULL,NULL,'Award of the Eyas of Hawkwood','Award of the Eyas of Hawkwood','Award of the Eyas of Hawkwood',0,'For Children','2006-02-19',NULL,NULL,NULL,35),(183,'Hawk\'s Aerie',0,20,NULL,NULL,'Award of the Hawk\'s Aerie','Award of the Hawk\'s Aerie','Award of the Hawk\'s Aerie',0,'For Newcomers','2006-02-19',NULL,NULL,NULL,35),(200,'Royal Company of Archers',0,12,9,NULL,'Royal Company of Archers',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(201,'Royal Company of Yeomen',0,12,9,NULL,'Royal Company of Yeomen',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(202,'Royal Company of Courtiers',0,12,9,NULL,'Royal Company of Courtiers',NULL,NULL,0,'This order was formerly known as the Guildmasters of Fence',NULL,NULL,NULL,NULL,1),(203,'Western Lily',0,14,9,NULL,'Order of The Western Lily','Order of The Western Lily','Order of The Western Lily',0,NULL,NULL,NULL,NULL,NULL,1),(204,'Leaf of Merit',0,14,9,NULL,'Order of the Leaf of Merit','Order of the Leaf of Merit','Order of the Leaf of Merit',0,NULL,NULL,NULL,NULL,NULL,1),(205,'Rose Leaf',0,14,9,NULL,'Order of the Rose Leaf','Order of the Rose Leaf','Order of the Rose Leaf',0,NULL,NULL,NULL,NULL,NULL,1),(206,'Ash Leaf',0,14,9,NULL,'Order of the Ash Leaf','Order of the Ash Leaf','Order of the Ash Leaf',0,NULL,NULL,NULL,NULL,NULL,1),(207,'Commendabilis',0,18,NULL,NULL,'Commendabilis',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(208,'Queen\'s Order of Grace',0,18,NULL,NULL,'Queen\'s Order of Grace',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(209,'Golden Poppy',0,18,NULL,NULL,'Order of the Golden Poppy','Order of the Golden Poppy','Order of the Golden Poppy',0,NULL,NULL,NULL,NULL,NULL,1),(210,'Silver Nib',0,18,NULL,NULL,'Order of the Silver Nib','Order of the Silver Nib','Order of the Silver Nib',0,NULL,NULL,NULL,NULL,NULL,1),(211,'Silver Molet',0,18,NULL,NULL,'Order of the Silver Molet','Order of the Silver Molet','Order of the Silver Molet',0,NULL,NULL,NULL,NULL,NULL,1),(212,'Knights Bannerette',0,18,NULL,NULL,'Knights Bannerette',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(213,'Valor',0,18,NULL,NULL,'Order of Valor','Order of Valor','Order of Valor',0,NULL,NULL,NULL,NULL,NULL,1),(214,'Western Hero',0,18,NULL,NULL,'Western Hero',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(215,'Silver Mantle',0,18,NULL,NULL,'Order of the Silver Mantle','Order of the Silver Mantle','Order of the Silver Mantle',0,NULL,NULL,NULL,NULL,NULL,1),(216,'Grey Goose Shaft',0,18,NULL,NULL,'Order of the Grey Goose Shaft','Order of the Grey Goose Shaft','Order of the Grey Goose Shaft',0,NULL,NULL,NULL,NULL,NULL,1),(217,'Wreaths of Valor and Chivalry',0,18,NULL,NULL,'Wreaths of Valor and Chivalry',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(218,'The Muckin\' Great Clubbe',0,18,NULL,NULL,'The Muckin\' Great Clubbe',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(219,'The Old Battered Helm',0,18,NULL,NULL,'The Old Battered Helm',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(220,'Wooden Spoon',0,18,NULL,NULL,'Order of the Wooden Spoon','Order of the Wooden Spoon','Order of the Wooden Spoon',0,NULL,NULL,NULL,NULL,NULL,1),(221,'Queen\'s Cypher',0,18,NULL,NULL,'Queen\'s Cypher',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(222,'Arachne\'s Web',0,18,NULL,NULL,'Order of Arachne\'s Web','Order of Arachne\'s Web','Order of Arachne\'s Web',0,NULL,NULL,NULL,NULL,NULL,1),(223,'Pied d\'Argent',0,18,NULL,NULL,'Order of the Pied d\'Argent','Order of the Pied d\'Argent','Order of the Pied d\'Argent',0,NULL,NULL,NULL,NULL,NULL,1),(224,'Defenders of the West',0,18,NULL,NULL,'Defenders of the West',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(225,'Pillars of the West',0,18,NULL,NULL,'Pillars of the West',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(226,'King\'s Lance',0,18,NULL,NULL,'Order of the King\'s Lance','Order of the King\'s Lance','Order of the King\'s Lance',0,NULL,NULL,NULL,NULL,NULL,1),(227,'Golden Acorn',0,18,NULL,NULL,'Order of the Golden Acorn','Order of the Golden Acorn','Order of the Golden Acorn',0,NULL,NULL,NULL,NULL,NULL,1),(228,'Royal Pages of the West',0,18,NULL,NULL,'Royal Pages of the West',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(229,'Western Roll of Honor',0,18,NULL,NULL,'Western Roll of Honor',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(230,'West Kingdom Paragons of Merriment',0,18,NULL,NULL,'West Kingdom Paragons of Merriment',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,1),(231,'Noble Manor',0,18,NULL,NULL,'Order of the Noble Manor','Order of the Noble Manor','Order of the Noble Manor',0,NULL,NULL,NULL,NULL,NULL,1),(232,'Queen\'s Treasure',0,18,NULL,NULL,'Order of the Queen\'s Treasure','Order of the Queen\'s Treasure','Order of the Queen\'s Treasure',0,NULL,NULL,NULL,NULL,NULL,1),(233,'Silver Crescent',0,14,9,NULL,'Order of the Silver Crescent','Order of the Silver Crescent','Order of the Silver Crescent',0,NULL,NULL,NULL,NULL,NULL,2),(234,'Maunche',0,14,9,NULL,'Order of the Maunche','Companion of the Maunche','Companion of the Maunche',0,'A&amp;S award',NULL,NULL,NULL,NULL,2),(235,'Tygers Combattant',0,14,9,NULL,'Order of the Tygers Combattant','Companion of the Tygers Combattant','Companion of the Tygers Combattant',0,'Fighting award',NULL,NULL,NULL,NULL,2),(236,'Sagittarius',0,14,9,NULL,'Order of the Sagittarius','Order of the Sagittarius','Order of the Sagittarius',0,NULL,NULL,NULL,NULL,NULL,2),(237,'Golden Rapier',0,14,9,NULL,'Order of the Golden Rapier','Order of the Golden Rapier','Order of the Golden Rapier',0,NULL,NULL,NULL,NULL,NULL,2),(238,'Queen\'s Order of Courtesy',0,18,NULL,NULL,'Queen\'s Order of Courtesy',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(239,'Burdened Tyger',0,18,NULL,NULL,'Order of the Burdened Tyger','Companion of the Burdened Tyger','Companion of the Burdened Tyger',0,NULL,NULL,NULL,NULL,NULL,2),(240,'Tyger\'s Cub',0,18,NULL,NULL,'Order of the Tyger\'s Cub','Order of the Tyger\'s Cub','Order of the Tyger\'s Cub',0,NULL,NULL,NULL,NULL,NULL,2),(241,'Troubadours',0,18,NULL,NULL,'Order of Troubadours','Order of Troubadours','Order of Troubadours',0,NULL,NULL,NULL,NULL,NULL,2),(242,'Terpsichore',0,18,NULL,NULL,'Order of the Terpsichore','Order of the Terpsichore','Order of the Terpsichore',0,NULL,NULL,NULL,NULL,NULL,2),(243,'Queen\'s Cypher',0,18,NULL,NULL,'Queen\'s Cypher',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(244,'King\'s Cypher',0,18,NULL,NULL,'King\'s Cypher',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(245,'King\'s Order of Excellence',0,18,NULL,NULL,'King\'s Order of Excellence',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(246,'Blue Tyger Legion',0,18,NULL,NULL,'Blue Tyger Legion',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(247,'Queen\'s Honour of Distinction',0,18,NULL,NULL,'Queen\'s Honour of Distinction',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(248,'Valiant Tyger',0,18,NULL,NULL,'Order of the Valiant Tyger','Order of the Valiant Tyger','Order of the Valiant Tyger',0,NULL,NULL,NULL,NULL,NULL,2),(249,'Gift of the Golden Tyger',0,18,NULL,NULL,'Gift of the Golden Tyger',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(250,'East Kingdom Augmentation of Arms',0,18,NULL,NULL,'East Kingdom Augmentation of Arms',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(251,'Royal Augmentation of Arms',0,18,NULL,NULL,'Royal Augmentation of Arms',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(252,'Tyger of the East',0,18,NULL,NULL,'Tyger of the East',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,2),(253,'Dragon\'s Heart',0,12,9,NULL,'Order of the Dragon\'s Heart','Order of the Dragon\'s Heart','Order of the Dragon\'s Heart',0,NULL,NULL,NULL,NULL,NULL,3),(254,'Greenwood Company',0,12,9,NULL,'Order of the Greenwood Company','Order of the Greenwood Company','Order of the Greenwood Company',0,NULL,NULL,NULL,NULL,NULL,3),(255,'Bronze Ring',0,12,9,NULL,'Order of the Bronze Ring','Order of the Bronze Ring','Order of the Bronze Ring',0,NULL,NULL,NULL,NULL,NULL,3),(256,'White Lance',0,12,9,NULL,'Order of the White Lance','Order of the White Lance','Order of the White Lance',0,NULL,NULL,NULL,NULL,NULL,3),(257,'Gold Mace',0,12,9,NULL,'Order of the Gold Mace','Order of the Gold Mace','Order of the Gold Mace',0,NULL,NULL,NULL,NULL,NULL,3),(258,'Evergreen',0,12,9,NULL,'Order of the Evergreen','Order of the Evergreen','Order of the Evergreen',0,NULL,NULL,NULL,NULL,NULL,3),(259,'Willow',0,14,9,NULL,'Order of the Willow','Order of the Willow','Order of the Willow',0,NULL,NULL,NULL,NULL,NULL,3),(260,'Silver Oak',0,14,9,NULL,'Order of the Silver Oak','Order of the Silver Oak','Order of the Silver Oak',0,NULL,NULL,NULL,NULL,NULL,3),(261,'Purple Fret',0,14,9,NULL,'Award of the Purple Fret','Award of the Purple Fret','Award of the Purple Fret',0,NULL,NULL,NULL,NULL,NULL,3),(262,'Doe\'s Grace (Queen\'s Favor)',0,14,9,NULL,'Award of the Doe\'s Grace (Queen\'s Favor)','Award of the Doe\'s Grace (Queen\'s Favor)','Award of the Doe\'s Grace (Queen\'s Favor)',0,NULL,NULL,NULL,NULL,NULL,3),(263,'King\'s Chalice',0,14,9,NULL,'Award of the King\'s Chalice','Award of the King\'s Chalice','Award of the King\'s Chalice',0,NULL,NULL,NULL,NULL,NULL,3),(264,'Dragon\'s Tooth',0,14,9,NULL,'Order of the Dragon\'s Tooth','Order of the Dragon\'s Tooth','Order of the Dragon\'s Tooth',0,NULL,NULL,NULL,NULL,NULL,3),(265,'Dragon\'s Barb',0,14,9,NULL,'Order of the Dragon\'s Barb','Order of the Dragon\'s Barb','Order of the Dragon\'s Barb',0,NULL,NULL,NULL,NULL,NULL,3),(266,'Cavendish Knot',0,14,9,NULL,'Order of the Cavendish Knot','Order of the Cavendish Knot','Order of the Cavendish Knot',0,NULL,NULL,NULL,NULL,NULL,3),(267,'White Chamfron',0,14,9,NULL,'Order of the White Chamfron','Order of the White Chamfron','Order of the White Chamfron',0,NULL,NULL,NULL,NULL,NULL,3),(268,'Red Company',0,14,9,NULL,'Order of the Red Company','Order of the Red Company','Order of the Red Company',0,NULL,NULL,NULL,NULL,NULL,3),(269,'Gaping Wound',0,14,9,NULL,'Order of the Gaping Wound','Order of the Gaping Wound','Order of the Gaping Wound',1,NULL,NULL,NULL,NULL,NULL,3),(270,'Dragon\'s Treasure',0,18,NULL,NULL,'Award of the Dragon\'s Treasure','Award of the Dragon\'s Treasure','Award of the Dragon\'s Treasure',0,NULL,NULL,NULL,NULL,NULL,3),(271,'Baton',0,18,NULL,NULL,'Award of the Baton','Award of the Baton','Award of the Baton',0,NULL,NULL,NULL,NULL,NULL,3),(272,'Silver Acorn',0,18,NULL,NULL,'Award of the Silver Acorn','Award of the Silver Acorn','Award of the Silver Acorn',0,NULL,NULL,NULL,NULL,NULL,3),(273,'Purple Fretty',0,18,NULL,NULL,'Award of the Purple Fretty','Award of the Purple Fretty','Award of the Purple Fretty',0,NULL,NULL,NULL,NULL,NULL,3),(274,'Dragon\'s Teeth',0,18,NULL,NULL,'Award of the Dragon\'s Teeth','Award of the Dragon\'s Teeth','Award of the Dragon\'s Teeth',0,NULL,NULL,NULL,NULL,NULL,3),(275,'Dragon\'s Flight',0,18,NULL,NULL,'Award of the Dragon\'s Flight','Award of the Dragon\'s Flight','Award of the Dragon\'s Flight',0,NULL,NULL,NULL,NULL,NULL,3),(276,'Grove',0,18,NULL,NULL,'Award of the Grove','Award of the Grove','Award of the Grove',0,NULL,NULL,NULL,NULL,NULL,3),(277,'Royal Vanguard',0,18,NULL,NULL,'Order of the Royal Vanguard','Order of the Royal Vanguard','Order of the Royal Vanguard',0,NULL,NULL,NULL,NULL,NULL,3),(278,'Sapphire',0,18,NULL,NULL,'Award of the Sapphire','Award of the Sapphire','Award of the Sapphire',0,NULL,NULL,NULL,NULL,NULL,3),(279,'Rose (no arms)',1,18,NULL,'rose.gif','Order of the Rose','Order of the Rose','Order of the Rose',0,'Consorts may be inducted into the Order of the Rose upon completion of a reign.',NULL,NULL,NULL,2,NULL),(280,'Royal Augmentation of Arms',0,18,NULL,NULL,'Royal Augmentation of Arms',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,3),(281,'Kingdom Augmentation of Arms',0,18,NULL,NULL,'Kingdom Augmentation of Arms',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,3),(282,'Lions of Atenveldt',0,12,9,NULL,'Order of the Lions of Atenveldt','Order of the Lions of Atenveldt','Order of the Lions of Atenveldt',0,NULL,NULL,NULL,NULL,NULL,4),(283,'Defenders of the White Scarf',0,12,9,NULL,'Order of the Defenders of the White Scarf','Order of the Defenders of the White Scarf','Order of the Defenders of the White Scarf',0,NULL,NULL,NULL,NULL,NULL,4),(284,'Light of Atenveldt - Commanders',0,12,9,NULL,'Commanders of the Light of Atenveldt','Commander of the Light of Atenveldt','Commander of the Light of Atenveldt',0,NULL,NULL,NULL,NULL,NULL,4),(285,'Fleur de Soleil - Commanders',0,12,9,NULL,'Commanders of the Fleur de Soleil','Commander of the Fleur de Soleil','Commander of the Fleur de Soleil',0,NULL,NULL,NULL,NULL,NULL,4),(286,'Hawk\'s Lure - Commanders',0,12,9,NULL,'Commanders of the Hawk\'s Lure','Commander of the Hawk\'s Lure','Commander of the Hawk\'s Lure',0,NULL,NULL,NULL,NULL,NULL,4),(287,'Azure Archers of Atenveldt - Commanders',0,12,9,NULL,'Commanders of the Azure Archers of Atenveldt','Commander of the Azure Archers of Atenveldt','Commander of the Azure Archers of Atenveldt',0,NULL,NULL,NULL,NULL,NULL,4),(288,'Queen\'s Grace - Commanders',0,12,9,NULL,'Commanders of the Queen\'s Grace','Commander of the Queen\'s Grace','Commander of the Queen\'s Grace',0,NULL,NULL,NULL,NULL,NULL,4),(289,'Desert Pilgrim - Commanders',0,12,9,NULL,'Commanders of the Desert Pilgrim','Commander of the Desert Pilgrim','Commander of the Desert Pilgrim',0,NULL,NULL,NULL,NULL,NULL,4),(290,'Light of Atenveldt',0,14,9,NULL,'Order of the Light of Atenveldt','Order of the Light of Atenveldt','Order of the Light of Atenveldt',0,NULL,NULL,NULL,NULL,NULL,4),(291,'Fleur de Soleil',0,14,9,NULL,'Order of the Fleur de Soleil','Order of the Fleur de Soleil','Order of the Fleur de Soleil',0,NULL,NULL,NULL,NULL,NULL,4),(292,'Hawk\'s Lure',0,14,9,NULL,'Order of the Hawk\'s Lure','Order of the Hawk\'s Lure','Order of the Hawk\'s Lure',0,NULL,NULL,NULL,NULL,NULL,4),(293,'Azure Archers of Atenveldt',0,14,9,NULL,'Order of the Azure Archers of Atenveldt','Order of the Azure Archers of Atenveldt','Order of the Azure Archers of Atenveldt',0,NULL,NULL,NULL,NULL,NULL,4),(294,'Builders of Atenveldt',0,14,9,NULL,'Builders of Atenveldt',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,4),(295,'Guardians of Atenveldt',0,14,9,NULL,'Order of the Guardians of Atenveldt','Order of the Guardians of Atenveldt','Order of the Guardians of Atenveldt',0,'Formerly the Legion of the Sword of Honor of Atenveldt, formerly the Royal Officer Corps of Atenveldt',NULL,NULL,NULL,NULL,4),(296,'Luxbruder of Atenveldt',0,14,9,NULL,'Order of the Luxbruder of Atenveldt','Order of the Luxbruder of Atenveldt','Order of the Luxbruder of Atenveldt',0,NULL,NULL,NULL,NULL,NULL,4),(297,'Desert Pilgrim of Atenveldt',0,14,9,NULL,'Order of the Desert Pilgrim of Atenveldt','Order of the Desert Pilgrim of Atenveldt','Order of the Desert Pilgrim of Atenveldt',0,NULL,NULL,NULL,NULL,NULL,4),(298,'Sirviente del Sol',0,14,9,NULL,'la Orden del Sirviente del Sol','la Orden del Sirviente del Sol','la Orden del Sirviente del Sol',0,NULL,NULL,NULL,NULL,NULL,4),(299,'Flower of the Desert',0,14,9,NULL,'Order of the Flower of the Desert','Order of the Flower of the Desert','Order of the Flower of the Desert',0,NULL,NULL,NULL,NULL,NULL,4),(300,'Blood of Fenris',0,14,9,NULL,'Order of the Blood of Fenris','Order of the Blood of Fenris','Order of the Blood of Fenris',0,NULL,NULL,NULL,NULL,NULL,4),(301,'Golden Blade',0,14,9,NULL,'Order of the Golden Blade','Order of the Golden Blade','Order of the Golden Blade',0,NULL,NULL,NULL,NULL,NULL,4),(302,'Sable Pheon',0,14,9,NULL,'Order of the Sable Pheon','Order of the Sable Pheon','Order of the Sable Pheon',0,NULL,NULL,NULL,NULL,NULL,4),(303,'Star of the Desert',0,14,9,NULL,'Order of the Star of the Desert','Order of the Star of the Desert','Order of the Star of the Desert',0,NULL,NULL,NULL,NULL,NULL,4),(304,'Hope of the Sun',0,18,NULL,NULL,'Order of the Hope of the Sun','Order of the Hope of the Sun','Order of the Hope of the Sun',0,NULL,NULL,NULL,NULL,NULL,4),(305,'Lion',0,18,NULL,NULL,'Order of the Lion','Order of the Lion','Order of the Lion',0,NULL,NULL,NULL,NULL,NULL,4),(306,'King\'s Sigil of Atenveldt',0,18,NULL,NULL,'King\'s Sigil of Atenveldt',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,4),(307,'Queen\'s Cypher - Commanders',0,18,NULL,NULL,'Commanders of the Queen\'s Cypher','Commander of the Queen\'s Cypher','Commander of the Queen\'s Cypher',0,NULL,NULL,NULL,NULL,NULL,4),(308,'Queen\'s Cypher',0,18,NULL,NULL,'Queen\'s Cypher',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,4),(309,'Queen\'s Grace',0,18,NULL,NULL,'Order of the Queen\'s Grace','Order of the Queen\'s Grace','Order of the Queen\'s Grace',0,NULL,NULL,NULL,NULL,NULL,4),(310,'Thegns/Bannthegns',0,18,NULL,NULL,'Order of the Thegns and Bannthegns','Order of the Thegns and Bannthegns','Order of the Thegns and Bannthegns',0,NULL,NULL,NULL,NULL,NULL,4),(311,'Bough of Meridies',0,12,9,NULL,'Order of the Bough of Meridies','Order of the Bough of Meridies','Order of the Bough of Meridies',0,NULL,NULL,NULL,NULL,NULL,5),(312,'Scarlet Star',0,12,9,NULL,'Order of the Scarlet Star','Order of the Scarlet Star','Order of the Scarlet Star',0,NULL,NULL,NULL,NULL,NULL,5),(313,'Velvet Owl',0,12,9,NULL,'Order of the Velvet Owl','Order of the Velvet Owl','Order of the Velvet Owl',0,NULL,NULL,NULL,NULL,NULL,5),(314,'Legio Uris (Legion of the Bear)',0,14,9,NULL,'Order of the Legio Uris (Legion of the Bear)','Order of the Legio Uris (Legion of the Bear)','Order of the Legio Uris (Legion of the Bear)',0,NULL,NULL,NULL,NULL,NULL,5),(315,'Sable Sword',0,14,9,NULL,'Order of the Sable Sword','Order of the Sable Sword','Order of the Sable Sword',0,NULL,NULL,NULL,NULL,NULL,5),(316,'Split Arrow',0,14,9,NULL,'Order of the Split Arrow','Order of the Split Arrow','Order of the Split Arrow',0,NULL,NULL,NULL,NULL,NULL,5),(317,'Argent Comet',0,14,9,NULL,'Order of the Argent Comet','Order of the Argent Comet','Order of the Argent Comet',0,NULL,NULL,NULL,NULL,NULL,5),(318,'Guidon, Meridies',0,14,9,NULL,'Order of the Guidon, Meridies','Order of the Guidon, Meridies','Order of the Guidon, Meridies',1,NULL,NULL,NULL,NULL,NULL,5),(319,'Sovereign\'s Pleasure',0,18,NULL,NULL,'Order of the Sovereign\'s Pleasure','Order of the Sovereign\'s Pleasure','Order of the Sovereign\'s Pleasure',0,NULL,NULL,NULL,NULL,NULL,5),(320,'Meridian Cross',0,18,NULL,NULL,'Order of the Meridian Cross','Order of the Meridian Cross','Order of the Meridian Cross',0,NULL,NULL,NULL,NULL,NULL,5),(321,'Argent Lily',0,18,NULL,NULL,'Order of the Argent Lily','Order of the Argent Lily','Order of the Argent Lily',0,NULL,NULL,NULL,NULL,NULL,5),(322,'Argent Shield',0,18,NULL,NULL,'Order of the Argent Shield','Order of the Argent Shield','Order of the Argent Shield',0,NULL,NULL,NULL,NULL,NULL,5),(323,'Meridian Broken Bow',0,18,NULL,NULL,'Order of the Meridian Broken Bow','Order of the Meridian Broken Bow','Order of the Meridian Broken Bow',0,NULL,NULL,NULL,NULL,NULL,5),(324,'Weapons Master',0,18,NULL,NULL,'Order of the Weapons Master','Order of the Weapons Master','Order of the Weapons Master',0,NULL,NULL,NULL,NULL,NULL,5),(325,'Argent Lance of Meridies',0,18,NULL,NULL,'Order of the Argent Lance of Meridies','Order of the Argent Lance of Meridies','Order of the Argent Lance of Meridies',0,NULL,NULL,NULL,NULL,NULL,5),(326,'Argent Rapier',0,18,NULL,NULL,'Order of the Argent Rapier','Order of the Argent Rapier','Order of the Argent Rapier',0,NULL,NULL,NULL,NULL,NULL,5),(327,'Cygnet',0,18,NULL,NULL,'Order of the Cygnet','Order of the Cygnet','Order of the Cygnet',0,NULL,NULL,NULL,NULL,NULL,5),(328,'Rising Swan',0,18,NULL,NULL,'Order of the Rising Swan','Order of the Rising Swan','Order of the Rising Swan',0,NULL,NULL,NULL,NULL,NULL,5),(329,'Guiding Hand, Meridies',0,18,NULL,NULL,'Order of the Guiding Hand, Meridies','Order of the Guiding Hand, Meridies','Order of the Guiding Hand, Meridies',0,NULL,NULL,NULL,NULL,NULL,5),(330,'Chalice',0,18,NULL,NULL,'Order of the Chalice','Order of the Chalice','Order of the Chalice',0,NULL,NULL,NULL,NULL,NULL,5),(331,'Athanor',0,18,NULL,NULL,'Order of the Athanor','Order of the Athanor','Order of the Athanor',0,NULL,NULL,NULL,NULL,NULL,5),(332,'Compostella',0,18,NULL,NULL,'Order of the Compostella','Order of the Compostella','Order of the Compostella',0,NULL,NULL,NULL,NULL,NULL,5),(333,'Broken Brank',0,18,NULL,NULL,'Order of the Broken Brank','Order of the Broken Brank','Order of the Broken Brank',0,NULL,NULL,NULL,NULL,NULL,5),(334,'Burning Trumpet',0,18,NULL,NULL,'Order of the Burning Trumpet','Order of the Burning Trumpet','Order of the Burning Trumpet',0,NULL,NULL,NULL,NULL,NULL,5),(335,'Sable Quill',0,18,NULL,NULL,'Order of the Sable Quill','Order of the Sable Quill','Order of the Sable Quill',0,NULL,NULL,NULL,NULL,NULL,5),(336,'Duvant Cross',0,18,NULL,NULL,'Order of the Duvant Cross','Order of the Duvant Cross','Order of the Duvant Cross',0,NULL,NULL,NULL,NULL,NULL,5),(337,'Argent Slipper',0,18,NULL,NULL,'Order of the Argent Slipper','Order of the Argent Slipper','Order of the Argent Slipper',0,NULL,NULL,NULL,NULL,NULL,5),(338,'Cygnet\'s Nest',0,18,NULL,NULL,'Order of the Cygnet\'s Nest','Order of the Cygnet\'s Nest','Order of the Cygnet\'s Nest',0,NULL,NULL,NULL,NULL,NULL,5),(339,'Meridian Majesty',0,18,NULL,NULL,'Order of Meridian Majesty','Order of Meridian Majesty','Order of Meridian Majesty',0,NULL,NULL,NULL,NULL,NULL,5),(340,'Crown\'s Favor',0,18,NULL,NULL,'Award of the Crown\'s Favor','Award of the Crown\'s Favor','Award of the Crown\'s Favor',0,NULL,NULL,NULL,NULL,NULL,5),(341,'Companionate of the Bard',0,18,NULL,NULL,'Companionate of the Bard',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,5),(342,'Companionate of the King\'s Lancer',0,18,NULL,NULL,'Companionate of the King\'s Lancer',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,5),(343,'Companionate of the Meridian King\'s Champion',0,18,NULL,NULL,'Companionate of the Meridian King\'s Champion',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,5),(344,'Companionate of the Meridian Queen\'s Champion',0,18,NULL,NULL,'Companionate of the Meridian Queen\'s Champion',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,5),(345,'Companionate of the Meridian Queen\'s Rapier Champion',0,18,NULL,NULL,'Companionate of the Meridian Queen\'s Rapier Champion',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,5),(346,'Companionate of the Poet Laureate',0,18,NULL,NULL,'Companionate of the Poet Laureate',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,5),(347,'Companionate of the Queen\'s Yeoman',0,18,NULL,NULL,'Companionate of the Queen\'s Yeoman',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,5),(348,'Solar Phoenix',0,19,NULL,NULL,'Order of the Solar Phoenix','Order of the Solar Phoenix','Order of the Solar Phoenix',1,'Chief award of the principality. This award has two kinds of members: Companions of the Solar Phoenix are those who have served the principality well and faithfully, above and beyond that service normally expected of the subjects of the Crown. Commanders of the Solar Phoenix are those who have made a major continuing contribution to the Principality and have demonstrated consistent courtesy and chivalry in their behavior. Only one Commander was made during a reign.','2007-09-27',7,NULL,NULL,76),(349,'Iron Dragon',0,19,NULL,NULL,'Order of the Iron Dragon','Order of the Iron Dragon','Order of the Iron Dragon',1,'Given for exceptional authenticity in behavior, dress, and other areas.','2007-09-27',7,NULL,NULL,76),(350,'Espirit de Soleil',0,19,NULL,NULL,'Order of the Espirit de Soleil','Order of the Espirit de Soleil','Order of the Espirit de Soleil',1,'Given to those who have exhibited talent, enthusiasm, and a willingness to share their knowledge worthy of recognition in the arts and sciences. The token of the order was a medallion depicting the order\'s badge: A fireball sable, enflamed in cross proper, charged with a harp Or, hung from a green ribbon.','2006-12-11',7,NULL,NULL,76),(351,'Fanged Wolf',0,19,NULL,NULL,'Order of the Fanged Wolf','Order of the Fanged Wolf','Order of the Fanged Wolf',1,'Given to those who have demonstated excellence in the fighting arts, both in the teaching and use of traditional SCA-style weaponry.','2007-09-27',7,NULL,NULL,76),(352,'Eye of the Eagle',0,19,NULL,NULL,'Order of the Eye of the Eagle','Order of the Eye of the Eagle','Order of the Eye of the Eagle',1,'Given to those who have demonstrated excellence in both the teaching and use of archery, shinai, or rapier skills.','2007-09-27',7,NULL,NULL,76),(353,'Solar Heart',0,19,NULL,NULL,'Order of the Solar Heart','Order of the Solar Heart','Order of the Solar Heart',1,'Given by the princess to those who have rendered exceptional service to her in the course of the reign.','2007-09-27',7,NULL,NULL,76),(354,'Solar Warlord',0,19,NULL,NULL,'Order of the Solar Warlord','Order of the Solar Warlord','Order of the Solar Warlord',1,NULL,NULL,NULL,NULL,NULL,5),(355,'Dagger of the Sun',0,19,NULL,NULL,'Order of the Dagger of the Sun','Order of the Dagger of the Sun','Order of the Dagger of the Sun',1,'Given to those who have served as Princess\' Champion. The Princess\' Champion is chosen in a tourney devised by the Princess, held the day after her investiture.','2007-09-27',7,NULL,NULL,76),(356,'Gauntlet of Caid',0,12,9,NULL,'Order of the Gauntlet of Caid','Order of the Gauntlet of Caid','Order of the Gauntlet of Caid',0,NULL,NULL,NULL,NULL,NULL,6),(357,'Crescent',0,12,9,NULL,'Order of the Crescent','Order of the Crescent','Order of the Crescent',0,NULL,NULL,NULL,NULL,NULL,6),(358,'Lux Caidus',0,12,9,NULL,'Order of the Lux Caidus','Order of the Lux Caidus','Order of the Lux Caidus',0,NULL,NULL,NULL,NULL,NULL,6),(359,'White Scarf of Caid',0,12,9,NULL,'Order of the White Scarf of Caid','Order of the White Scarf of Caid','Order of the White Scarf of Caid',0,NULL,NULL,NULL,NULL,NULL,6),(360,'Chiron',0,12,9,NULL,'Order of Chiron','Order of Chiron','Order of Chiron',0,NULL,NULL,NULL,NULL,NULL,6),(361,'Argent Arrow',0,14,9,NULL,'Order of the Argent Arrow','Order of the Argent Arrow','Order of the Argent Arrow',0,NULL,NULL,NULL,NULL,NULL,6),(362,'Crescent Sword',0,14,9,NULL,'Order of the Crescent Sword','Order of the Crescent Sword','Order of the Crescent Sword',0,NULL,NULL,NULL,NULL,NULL,6),(363,'Dolphin of Caid',0,14,9,NULL,'Order of the Dolphin of Caid','Order of the Dolphin of Caid','Order of the Dolphin of Caid',0,NULL,NULL,NULL,NULL,NULL,6),(364,'Duellist',0,14,9,NULL,'Order of the Duellist','Order of the Duellist','Order of the Duellist',0,NULL,NULL,NULL,NULL,NULL,6),(365,'Harp Argent',0,14,9,NULL,'Order of the Harp Argent','Order of the Harp Argent','Order of the Harp Argent',0,NULL,NULL,NULL,NULL,NULL,6),(366,'Vanguard of Honor',0,18,NULL,NULL,'Vanguard of Honor',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(367,'Legion of Courtesy',0,18,NULL,NULL,'Legion of Courtesy',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(368,'Signum Reginae',0,18,NULL,NULL,'Signum Reginae',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(369,'Sigillum Regis',0,18,NULL,NULL,'Sigillum Regis',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(370,'Signum Regni',0,18,NULL,NULL,'Signum Regni',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(371,'Corde de Guerre of Caid',0,18,NULL,NULL,'Corde de Guerre of Caid',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(372,'Crossed Swords of Caid',0,18,NULL,NULL,'Crossed Swords of Caid',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(373,'l\'Honneur de la Chanson',0,18,NULL,NULL,'l\'Honneur de la Chanson',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(374,'Acorn',0,18,NULL,NULL,'Order of the Acorn','Order of the Acorn','Order of the Acorn',0,NULL,NULL,NULL,NULL,NULL,6),(375,'Royal Recognition of Excellence',0,18,NULL,NULL,'Royal Recognition of Excellence',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,6),(376,'Star of Merit',0,12,9,NULL,'Order of the Star of Merit','Order of the Star of Merit','Order of the Star of Merit',0,NULL,NULL,NULL,NULL,NULL,7),(377,'Iris of Merit',0,12,9,NULL,'Order of the Iris of Merit','Order of the Iris of Merit','Order of the Iris of Merit',0,NULL,NULL,NULL,NULL,NULL,7),(378,'White Scarf of Ansteorra',0,12,9,NULL,'Order of the White Scarf of Ansteorra','Order of the White Scarf of Ansteorra','Order of the White Scarf of Ansteorra',0,NULL,NULL,NULL,NULL,NULL,7),(379,'Centurions of the Sable Star',0,12,9,NULL,'Order of the Centurions of the Sable Star','Order of the Centurions of the Sable Star','Order of the Centurions of the Sable Star',0,NULL,NULL,NULL,NULL,NULL,7),(380,'Arcus Majoris',0,12,9,NULL,'Order of the Arcus Majoris','Order of the Arcus Majoris','Order of the Arcus Majoris',0,NULL,NULL,NULL,NULL,NULL,7),(381,'Golden Lance',0,12,9,NULL,'Order of the Golden Lance','Order of the Golden Lance','Order of the Golden Lance',0,NULL,NULL,NULL,NULL,NULL,7),(382,'King\'s Gauntlet',0,14,9,NULL,'King\'s Gauntlet',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(383,'Queen\'s Glove',0,14,9,NULL,'Queen\'s Glove',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(384,'Sable Thistle',0,14,9,NULL,'Award of the Sable Thistle','Award of the Sable Thistle','Award of the Sable Thistle',0,NULL,'2006-08-07',NULL,NULL,NULL,7),(385,'Sable Crane',0,14,9,NULL,'Sable Crane',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(386,'Sable Comet',0,14,9,NULL,'Sable Comet',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(387,'Compass Rose',0,14,9,NULL,'Compass Rose',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(388,'Sable Falcon',0,18,NULL,NULL,'Sable Falcon',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(389,'Golden Bridle',0,18,NULL,NULL,'Golden Bridle',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(390,'Queen\'s Rapier',0,18,NULL,NULL,'Queen\'s Rapier',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(391,'King\'s Archer',0,18,NULL,NULL,'King\'s Archer',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(392,'Rising Star of Ansteorra',0,18,NULL,NULL,'Rising Star of Ansteorra',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,7),(393,'Lions of Ansteorra',0,18,NULL,NULL,'Order of the Lions of Ansteorra','Order of the Lions of Ansteorra','Order of the Lions of Ansteorra',0,NULL,NULL,NULL,NULL,NULL,7),(394,'Knights of the Sable Garland',0,18,NULL,NULL,'Order of the Knights of the Sable Garland','Order of the Knights of the Sable Garland','Order of the Knights of the Sable Garland',0,NULL,NULL,NULL,NULL,NULL,7),(395,'Motley Shash',0,18,NULL,NULL,'Motley Shash',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,7),(396,'Crowns\' Favor of Ansteorra',0,18,NULL,NULL,'Crowns\' Favor of Ansteorra',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,7),(397,'Queen\'s Ring of Ansteorra',0,18,NULL,NULL,'Order of the Queen\'s Ring of Ansteorra','Order of the Queen\'s Ring of Ansteorra','Order of the Queen\'s Ring of Ansteorra',1,NULL,NULL,NULL,NULL,NULL,7),(398,'Vine Staff',0,18,NULL,NULL,'Order of the Vine Staff','Order of the Vine Staff','Order of the Vine Staff',1,NULL,NULL,NULL,NULL,NULL,7),(399,'Goutte de Sang',0,12,9,NULL,'Order of the Goutte de Sang','Order of the Goutte de Sang','Order of the Goutte de Sang',0,NULL,NULL,NULL,NULL,NULL,9),(400,'Jambe de Lion',0,12,9,NULL,'Order of the Jambe de Lion','Order of the Jambe de Lion','Order of the Jambe de Lion',0,NULL,NULL,NULL,NULL,NULL,9),(401,'Grey Goose Shaft',0,12,9,NULL,'Order of the Grey Goose Shaft','Order of the Grey Goose Shaft','Order of the Grey Goose Shaft',0,NULL,NULL,NULL,NULL,NULL,9),(402,'White Scarf',0,12,9,NULL,'Order of the White Scarf','Order of the White Scarf','Order of the White Scarf',0,NULL,NULL,NULL,NULL,NULL,9),(403,'Hastae Leonis (Spear of the Lion)',0,12,9,NULL,'Ordo Hastae Leonis (Order of the Spear of the Lion)','Ordo Hastae Leonis (Order of the Spear of the Lion)','Ordo Hastae Leonis (Order of the Spear of the Lion)',0,NULL,NULL,NULL,NULL,NULL,9),(404,'Throne\'s Favor',0,18,NULL,NULL,'Throne\'s Favor',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(405,'Iron Chain',0,18,NULL,NULL,'Order of the Iron Chain','Order of the Iron Chain','Order of the Iron Chain',0,NULL,NULL,NULL,NULL,NULL,9),(406,'Honor of the Lion of An Tir',0,18,NULL,NULL,'Order of the Honor of the Lion of An Tir','Order of the Honor of the Lion of An Tir','Order of the Honor of the Lion of An Tir',0,NULL,NULL,NULL,NULL,NULL,9),(407,'Golden Unicorn/Silver Unicorn',0,18,NULL,NULL,'Golden Unicorn/Silver Unicorn',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(408,'Forget-me-not',0,18,NULL,NULL,'Forget-me-not',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(409,'King\'s Favor',0,18,NULL,NULL,'King\'s Favor',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(410,'Honour of the Belated Rose',0,18,NULL,NULL,'Honour of the Belated Rose',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(411,'Honor of the Lion\'s Cub',0,18,NULL,NULL,'Honor of the Lion\'s Cub',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(412,'La Mano d\'Oro',0,18,NULL,NULL,'La Mano d\'Oro',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(413,'Carp',0,18,NULL,NULL,'Order of the Carp','Order of the Carp','Order of the Carp',0,NULL,NULL,NULL,NULL,NULL,9),(414,'Silver Rose',0,18,NULL,NULL,'Order of the Silver Rose','Order of the Silver Rose','Order of the Silver Rose',0,NULL,NULL,NULL,NULL,NULL,9),(415,'Silver Lily',0,18,NULL,NULL,'Order of the Silver Lily','Order of the Silver Lily','Order of the Silver Lily',0,NULL,NULL,NULL,NULL,NULL,9),(416,'Lion\'s Torse',0,18,NULL,NULL,'Lion\'s Torse',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(417,'Sable Chime',0,18,NULL,NULL,'Sable Chime',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(418,'Lords and Ladies of Valourous Estate',0,18,NULL,NULL,'Order of the Lords and Ladies of Valourous Estate','Order of the Lords and Ladies of Valourous Estate','Order of the Lords and Ladies of Valourous Estate',0,NULL,NULL,NULL,NULL,NULL,9),(419,'Sergeant of Arms',0,18,NULL,NULL,'Sergeant of Arms',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(420,'Whimsical Order of the Ailing Wit',0,18,NULL,NULL,'Whimsical Order of the Ailing Wit',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(421,'Muckin\' Tall Maul',0,18,NULL,NULL,'Muckin\' Tall Maul',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(422,'Old Shattered Shield',0,18,NULL,NULL,'Old Shattered Shield',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(423,'Pernicious Lily',0,18,NULL,NULL,'Pernicious Lily',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,9),(424,'Iren-Hirth',0,12,9,NULL,'Iren-Hirth',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,10),(425,'Boga-Hirth',0,12,9,NULL,'Boga-Hirth',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,10),(426,'Calon Lily',0,12,9,NULL,'Order of the Calon Lily','Order of the Calon Lily','Order of the Calon Lily',0,NULL,NULL,NULL,NULL,NULL,10),(427,'Silver Hammer',0,12,9,NULL,'Order of the Silver Hammer','Order of the Silver Hammer','Order of the Silver Hammer',0,NULL,NULL,NULL,NULL,NULL,10),(428,'Cross of Calontir',0,12,9,NULL,'Order of the Cross of Calontir','Order of the Cross of Calontir','Order of the Cross of Calontir',0,NULL,NULL,NULL,NULL,NULL,10),(429,'Iren-Fyrd',0,14,9,NULL,'Iren-Fyrd',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,10),(430,'Boga-Fyrd',0,14,9,NULL,'Boga-Fyrd',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,10),(431,'Golden Calon Swan',0,14,9,NULL,'Order of the Golden Calon Swan','Order of the Golden Calon Swan','Order of the Golden Calon Swan',0,NULL,NULL,NULL,NULL,NULL,10),(432,'Leather Mallet',0,14,9,NULL,'Order of the Leather Mallet','Order of the Leather Mallet','Order of the Leather Mallet',0,NULL,NULL,NULL,NULL,NULL,10),(433,'Torse',0,14,9,NULL,'Order of the Torse','Order of the Torse','Order of the Torse',0,NULL,NULL,NULL,NULL,NULL,10),(434,'Sword of Calontir',0,18,NULL,NULL,'Order of the Sword of Calontir','Order of the Sword of Calontir','Order of the Sword of Calontir',0,NULL,NULL,NULL,NULL,NULL,10),(435,'Keeper of the Flame',0,18,NULL,NULL,'Order of the Keeper of the Flame','Order of the Keeper of the Flame','Order of the Keeper of the Flame',0,NULL,NULL,NULL,NULL,NULL,10),(436,'Queen\'s Chalice',0,18,NULL,NULL,'Order of the Queen\'s Chalice','Order of the Queen\'s Chalice','Order of the Queen\'s Chalice',0,NULL,NULL,NULL,NULL,NULL,10),(437,'Queen\'s Endorsement of Distinction',0,18,NULL,NULL,'Queen\'s Endorsement of Distinction',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,10),(438,'King\'s Favor',0,18,NULL,NULL,'King\'s Favor',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,10),(439,'Iren Feran',0,18,NULL,NULL,'Iren Feran',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,10),(440,'Falcons Heart',0,18,NULL,NULL,'Order of the Falcons Heart','Order of the Falcons Heart','Order of the Falcons Heart',0,NULL,NULL,NULL,NULL,NULL,10),(441,'Triskele Trimaris',0,12,9,NULL,'Order of the Triskele Trimaris','Order of the Triskele Trimaris','Order of the Triskele Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(442,'Argent Sword of Trimaris',0,12,9,NULL,'Order of the Argent Sword of Trimaris','Order of the Argent Sword of Trimaris','Order of the Argent Sword of Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(443,'Silver Trident Trimaris',0,12,9,NULL,'Order of the Silver Trident Trimaris','Order of the Silver Trident Trimaris','Order of the Silver Trident Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(444,'White Scarf of Trimaris',0,12,9,NULL,'Order of the White Scarf of Trimaris','Order of the White Scarf of Trimaris','Order of the White Scarf of Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(445,'Arc d\'Or',0,12,9,NULL,'Order of the Arc d\'Or','Order of the Arc d\'Or','Order of the Arc d\'Or',0,NULL,NULL,NULL,NULL,NULL,11),(446,'Argent Scales of Trimaris',0,14,9,NULL,'Order of the Argent Scales of Trimaris','Order of the Argent Scales of Trimaris','Order of the Argent Scales of Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(447,'Trade Winds of Trimaris',0,14,9,NULL,'Order of the Trade Winds of Trimaris','Order of the Trade Winds of Trimaris','Order of the Trade Winds of Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(448,'Silver Shield of Trimaris',0,14,9,NULL,'Order of the Silver Shield of Trimaris','Order of the Silver Shield of Trimaris','Order of the Silver Shield of Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(449,'Trimarian Gratitude',0,18,NULL,NULL,'Order of the Trimarian Gratitude','Order of the Trimarian Gratitude','Order of the Trimarian Gratitude',0,NULL,NULL,NULL,NULL,NULL,11),(450,'Emerald Seas',0,18,NULL,NULL,'Order of the Emerald Seas','Order of the Emerald Seas','Order of the Emerald Seas',0,NULL,NULL,NULL,NULL,NULL,11),(451,'Grey Beard',0,18,NULL,NULL,'Order of the Grey Beard','Order of the Grey Beard','Order of the Grey Beard',0,NULL,NULL,NULL,NULL,NULL,11),(452,'Mermaids Pearl',0,18,NULL,NULL,'Order of the Mermaids Pearl','Order of the Mermaids Pearl','Order of the Mermaids Pearl',0,NULL,NULL,NULL,NULL,NULL,11),(453,'Argent Estoile',0,18,NULL,NULL,'Order of the Argent Estoile','Order of the Argent Estoile','Order of the Argent Estoile',0,NULL,NULL,NULL,NULL,NULL,11),(454,'Argent Palm',0,18,NULL,NULL,'Order of the Argent Palm','Order of the Argent Palm','Order of the Argent Palm',0,NULL,NULL,NULL,NULL,NULL,11),(455,'Argent Morning Star of Trimaris',0,18,NULL,NULL,'Order of the Argent Morning Star of Trimaris','Order of the Argent Morning Star of Trimaris','Order of the Argent Morning Star of Trimaris',0,'Formerly known as the Order of the Morning Star',NULL,NULL,NULL,NULL,11),(456,'Trefoil Argent of Trimaris',0,18,NULL,NULL,'Order of the Trefoil Argent of Trimaris','Order of the Trefoil Argent of Trimaris','Order of the Trefoil Argent of Trimaris',0,NULL,NULL,NULL,NULL,NULL,11),(457,'Bard\'s Laureate',0,18,NULL,NULL,'Order of the Bard\'s Laureate','Order of the Bard\'s Laureate','Order of the Bard\'s Laureate',0,NULL,NULL,NULL,NULL,NULL,11),(458,'Fletcher',0,18,NULL,NULL,'Order of the Fletcher','Order of the Fletcher','Order of the Fletcher',0,'Formerly known as the Order of the Sea Urchin',NULL,NULL,NULL,NULL,11),(459,'Golden Galleon',0,18,NULL,NULL,'Order of the Golden Galleon','Order of the Golden Galleon','Order of the Golden Galleon',0,NULL,NULL,NULL,NULL,NULL,11),(460,'Herald’s Tressure',0,18,NULL,NULL,'Order of the Herald’s Tressure','Order of the Herald’s Tressure','Order of the Herald’s Tressure',0,NULL,NULL,NULL,NULL,NULL,11),(461,'Healer’s Lamp',0,18,NULL,NULL,'Order of the Healer’s Lamp','Order of the Healer’s Lamp','Order of the Healer’s Lamp',0,NULL,NULL,NULL,NULL,NULL,11),(462,'Watchful Flame',0,18,NULL,NULL,'Order of the Watchful Flame','Order of the Watchful Flame','Order of the Watchful Flame',0,NULL,NULL,NULL,NULL,NULL,11),(463,'Crown\'s Order of Gratitude',0,18,NULL,NULL,'Crown\'s Order of Gratitude',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,11),(464,'Thorbjorn',0,12,9,NULL,'Order of Thorbjorn','Order of Thorbjorn','Order of Thorbjorn',0,NULL,NULL,NULL,NULL,NULL,12),(465,'Crucible',0,12,9,NULL,'Order of the Crucible','Order of the Crucible','Order of the Crucible',0,NULL,NULL,NULL,NULL,NULL,12),(466,'Wain',0,12,9,NULL,'Order of the Wain','Order of the Wain','Order of the Wain',0,NULL,NULL,NULL,NULL,NULL,12),(467,'Merit for Arts and Sciences',0,14,9,NULL,'Award of Merit for Arts and Sciences','Award of Merit for Arts and Sciences','Award of Merit for Arts and Sciences',0,NULL,NULL,NULL,NULL,NULL,12),(468,'Maiden\'s Heart',0,14,9,NULL,'Award of the Maiden\'s Heart','Award of the Maiden\'s Heart','Award of the Maiden\'s Heart',0,NULL,NULL,NULL,NULL,NULL,12),(469,'Orion',0,14,9,NULL,'Award of Orion','Award of Orion','Award of Orion',0,NULL,NULL,NULL,NULL,NULL,12),(470,'Scarlet Banner',0,14,9,NULL,'Award of the Scarlet Banner','Award of the Scarlet Banner','Award of the Scarlet Banner',0,NULL,NULL,NULL,NULL,NULL,12),(471,'Wolf\'s Cub',0,18,NULL,NULL,'Award of the Wolf\'s Cub','Award of the Wolf\'s Cub','Award of the Wolf\'s Cub',0,NULL,NULL,NULL,NULL,NULL,12),(472,'King\'s Favour',0,18,NULL,NULL,'Award of the King\'s Favour','Award of the King\'s Favour','Award of the King\'s Favour',0,NULL,NULL,NULL,NULL,NULL,12),(473,'Queen\'s Favour',0,18,NULL,NULL,'Award of the Queen\'s Favour','Award of the Queen\'s Favour','Award of the Queen\'s Favour',0,NULL,NULL,NULL,NULL,NULL,12),(474,'Scroll of Honour',0,18,NULL,NULL,'Scroll of Honour',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,12),(475,'St. Crispin',0,19,NULL,NULL,'Order of St. Crispin','Order of St. Crispin','Order of St. Crispin',1,'Formerly the Order of the Peregrine',NULL,NULL,NULL,NULL,12),(476,'Golden Otter',0,19,NULL,NULL,'Order of the Golden Otter','Order of the Golden Otter','Order of the Golden Otter',1,NULL,NULL,NULL,NULL,NULL,12),(477,'Bee',0,19,NULL,NULL,'Order of the Bee','Order of the Bee','Order of the Bee',1,NULL,NULL,NULL,NULL,NULL,12),(478,'Princess\' Favour',0,19,NULL,NULL,'Award of the Princess\' Favour','Award of the Princess\' Favour','Award of the Princess\' Favour',1,'Formerly Tangwystal\'s Favour',NULL,NULL,NULL,NULL,12),(479,'Wolf\'s Tooth',0,19,NULL,NULL,'Award of the Wolf\'s Tooth','Award of the Wolf\'s Tooth','Award of the Wolf\'s Tooth',1,'Formerly the Dragon\'s Tooth?',NULL,NULL,NULL,NULL,12),(480,'Friendship of the Trillium',0,19,NULL,NULL,'Friendship of the Trillium',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12),(481,'Keeper of the Wolf\'s Heart',0,19,NULL,NULL,'Keeper of the Wolf\'s Heart',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,12),(482,'Flower of the Outlands',0,12,9,NULL,'Flower of the Outlands',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,13),(483,'Iron Hart of the Outlands',0,12,9,NULL,'Iron Hart of the Outlands',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,13),(484,'Stag',0,12,9,NULL,'Stag',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,13),(485,'White Scarf of the Outlands',0,12,9,NULL,'Order of the White Scarf of the Outlands','Order of the White Scarf of the Outlands','Order of the White Scarf of the Outlands',0,NULL,NULL,NULL,NULL,NULL,13),(486,'Sharparrow',0,12,9,NULL,'Order of Sharparrow','Order of Sharparrow','Order of Sharparrow',0,NULL,NULL,NULL,NULL,NULL,13),(487,'Stag\'s Heart',0,14,9,NULL,'Order of the Stag\'s Heart','Order of the Stag\'s Heart','Order of the Stag\'s Heart',0,NULL,NULL,NULL,NULL,NULL,13),(488,'Trefoil',0,14,9,NULL,'Order of the Trefoil','Order of the Trefoil','Order of the Trefoil',0,NULL,NULL,NULL,NULL,NULL,13),(489,'Argent Hart',0,14,9,NULL,'Order of the Argent Hart','Order of the Argent Hart','Order of the Argent Hart',0,NULL,NULL,NULL,NULL,NULL,13),(490,'Stag\'s Blood',0,14,9,NULL,'Order of the Stag\'s Blood','Order of the Stag\'s Blood','Order of the Stag\'s Blood',0,NULL,NULL,NULL,NULL,NULL,13),(491,'Golden Pheon',0,14,9,NULL,'Order of the Golden Pheon','Order of the Golden Pheon','Order of the Golden Pheon',0,NULL,NULL,NULL,NULL,NULL,13),(492,'Silver Tynes of the Outlands',0,14,9,NULL,'Order of the Silver Tynes of the Outlands','Order of the Silver Tynes of the Outlands','Order of the Silver Tynes of the Outlands',0,NULL,NULL,NULL,NULL,NULL,13),(493,'Silver Stirrup',0,14,9,NULL,'Order of the Silver Stirrup','Order of the Silver Stirrup','Order of the Silver Stirrup',0,NULL,NULL,NULL,NULL,NULL,13),(494,'Queen\'s Grace',0,18,NULL,NULL,'Order of the Queen\'s Grace','Order of the Queen\'s Grace','Order of the Queen\'s Grace',0,NULL,NULL,NULL,NULL,NULL,13),(495,'Cordon Royale',0,18,NULL,NULL,'Order of the Cordon Royale','Order of the Cordon Royale','Order of the Cordon Royale',0,NULL,NULL,NULL,NULL,NULL,13),(496,'Queen\'s Cypher',0,18,NULL,NULL,'Queen\'s Cypher',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,13),(497,'Promise of the Outlands',0,18,NULL,NULL,'Order of the Promise of the Outlands','Order of the Promise of the Outlands','Order of the Promise of the Outlands',0,NULL,NULL,NULL,NULL,NULL,13),(498,'Walker of the Way',0,18,NULL,NULL,'Order of the Walker of the Way','Order of the Walker of the Way','Order of the Walker of the Way',0,NULL,NULL,NULL,NULL,NULL,13),(499,'Venerable Guard',0,18,NULL,NULL,'Venerable Guard',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,13),(500,'Legion of Gallantry',0,18,NULL,NULL,'Legion of Gallantry',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,13),(501,'Dragon\'s Steel',0,12,9,NULL,'Order of the Dragon\'s Steel','Order of the Dragon\'s Steel','Order of the Dragon\'s Steel',0,NULL,NULL,NULL,NULL,NULL,14),(502,'Lindquistringes',0,14,9,NULL,'Orden des Lindquistringes','Orden des Lindquistringes','Orden des Lindquistringes',0,NULL,NULL,NULL,NULL,NULL,14),(503,'Panache',0,14,9,NULL,'Order of the Panache','Order of the Panache','Order of the Panache',0,NULL,NULL,NULL,NULL,NULL,14),(504,'Silver Guard',0,14,9,NULL,'Order of the Silver Guard','Order of the Silver Guard','Order of the Silver Guard',0,NULL,NULL,NULL,NULL,NULL,14),(505,'Edelweiss',0,14,9,NULL,'Order of the Edelweiss','Order of the Edelweiss','Order of the Edelweiss',1,'Formerly Marguerite',NULL,NULL,NULL,NULL,14),(506,'The King\'s Order of the Companions of  Albion',0,18,NULL,NULL,'The King\'s Order of the Companions of  Albion',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,14),(507,'Queen\'s Order of Courtesy',0,18,NULL,NULL,'Queen\'s Order of Courtesy',NULL,NULL,0,'Formerly Princess\' Order of Courtesy',NULL,NULL,NULL,NULL,14),(508,'Dragon\'s Bowle',0,18,NULL,NULL,'Order of the Dragon\'s Bowle','Order of the Dragon\'s Bowle','Order of the Dragon\'s Bowle',0,NULL,NULL,NULL,NULL,NULL,14),(509,'Dragon\'s Jewel',0,18,NULL,NULL,'Order of the Dragon\'s Jewel','Order of the Dragon\'s Jewel','Order of the Dragon\'s Jewel',0,NULL,NULL,NULL,NULL,NULL,14),(510,'Dragon\'s Pride',0,18,NULL,NULL,'Order of the Dragon\'s Pride','Order of the Dragon\'s Pride','Order of the Dragon\'s Pride',0,NULL,NULL,NULL,NULL,NULL,14),(511,'The Dragon\'s Tear',0,18,NULL,NULL,'The Dragon\'s Tear',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,14),(512,'Popular Company of Sojourners',0,18,NULL,NULL,'Popular Company of Sojourners',NULL,NULL,0,'Formerly Principality Company of Sojourners',NULL,NULL,NULL,NULL,14),(513,'Sigillum Coronae',0,18,NULL,NULL,'Sigillum Coronae',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,14),(514,'Hospitallers of Albion',0,18,NULL,NULL,'Hospitallers of Albion',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,14),(515,'Gryphon of Artemisia',0,12,9,NULL,'Gryphon of Artemisia',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(516,'White Scarf',0,12,9,NULL,'White Scarf',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(517,'Defenders of the Citadel',0,12,9,NULL,'Defenders of the Citadel',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(518,'Golden Sun in Splendour',0,12,9,NULL,'Golden Sun in Splendour',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(519,'Key Cross',0,12,9,NULL,'Key Cross',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(520,'Gryphon\'s Talon',0,14,9,NULL,'Order of the Gryphon\'s Talon','Order of the Gryphon\'s Talon','Order of the Gryphon\'s Talon',0,NULL,NULL,NULL,NULL,NULL,15),(521,'Golden Maple Leaf',0,14,9,NULL,'Golden Maple Leaf',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(522,'Golden Pillar of Artemisia',0,14,9,NULL,'Golden Pillar of Artemisia',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(523,'Gryphon and Pheon',0,14,9,NULL,'Gryphon and Pheon',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(524,'Cheval d\'Or',0,14,9,NULL,'Cheval d\'Or',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(525,'Gryphons Eye',0,14,9,NULL,'Gryphons Eye',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(526,'Golden Scarf',0,14,9,NULL,'Golden Scarf',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(527,'Gryphon\'s Pride of Artemisia',0,18,NULL,NULL,'Order of the Gryphon\'s Pride of Artemisia','Order of the Gryphon\'s Pride of Artemisia','Order of the Gryphon\'s Pride of Artemisia',0,NULL,NULL,NULL,NULL,NULL,15),(528,'Gryphon\'s Heart',0,18,NULL,NULL,'Order of the Gryphon\'s Heart','Order of the Gryphon\'s Heart','Order of the Gryphon\'s Heart',0,NULL,NULL,NULL,NULL,NULL,15),(529,'Gratia et Comitas',0,18,NULL,NULL,'Gratia et Comitas',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(530,'King\'s Council of Artemisia',0,18,NULL,NULL,'King\'s Council of Artemisia',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(531,'Queen\'s Confidence of Artemisia',0,18,NULL,NULL,'Queen\'s Confidence of Artemisia',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(532,'Quodlibet',0,18,NULL,NULL,'Quodlibet',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(533,'Golden Badger',0,18,NULL,NULL,'Golden Badger',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(534,'The Artemisian TANK Corps (Totally Agressive Nasty Killers)',0,18,NULL,NULL,'The Artemisian TANK Corps (Totally Agressive Nasty Killers)',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,15),(535,'Golden Feather of Artemisia',0,19,NULL,NULL,'Golden Feather of Artemisia',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,15),(536,'Gryphon\'s Pheon',0,19,NULL,NULL,'Order of the Gryphon\'s Pheon','Order of the Gryphon\'s Pheon','Order of the Gryphon\'s Pheon',1,NULL,NULL,NULL,NULL,NULL,15),(537,'Maple Leaf of Artemisia',0,19,NULL,NULL,'Order of the Maple Leaf of Artemisia','Order of the Maple Leaf of Artemisia','Order of the Maple Leaf of Artemisia',1,NULL,NULL,NULL,NULL,NULL,15),(538,'Pillar of Artemisia',0,19,NULL,NULL,'Order of the Pillar of Artemisia','Order of the Pillar of Artemisia','Order of the Pillar of Artemisia',1,NULL,NULL,NULL,NULL,NULL,15),(539,'Papillion',0,19,NULL,NULL,'Order of the Papillion','Order of the Papillion','Order of the Papillion',1,NULL,NULL,NULL,NULL,NULL,15),(540,'Artemisian Order of Grace',0,19,NULL,NULL,'Artemisian Order of Grace',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,15),(541,'Prince\'s Counselors of Artemisia',0,19,NULL,NULL,'Order of the Prince\'s Counselors of Artemisia','Order of the Prince\'s Counselors of Artemisia','Order of the Prince\'s Counselors of Artemisia',1,NULL,NULL,NULL,NULL,NULL,15),(542,'Royal Commendation',0,19,NULL,NULL,'Royal Commendation',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,15),(543,'Gage',0,12,9,NULL,'Order of the Gage','Order of the Gage','Order of the Gage',0,NULL,NULL,NULL,NULL,NULL,16),(544,'White Scarf',0,12,9,NULL,'Order of the White Scarf','Order of the White Scarf','Order of the White Scarf',0,NULL,NULL,NULL,NULL,NULL,16),(545,'Scarlet Guard',0,12,9,NULL,'Order of the Scarlet Guard','Order of the Scarlet Guard','Order of the Scarlet Guard',0,NULL,NULL,NULL,NULL,NULL,16),(546,'Millrind',0,12,9,NULL,'Order of the Millrind','Order of the Millrind','Order of the Millrind',0,NULL,NULL,NULL,NULL,NULL,16),(547,'Fleur of Æthelmearc',0,12,9,NULL,'Order of the Fleur of Æthelmearc','Order of the Fleur of Æthelmearc','Order of the Fleur of Æthelmearc',0,NULL,NULL,NULL,NULL,NULL,16),(548,'White Horn',0,12,9,NULL,'Order of the White Horn','Order of the White Horn','Order of the White Horn',0,NULL,NULL,NULL,NULL,NULL,16),(549,'Keystone',0,14,9,NULL,'Order of the Keystone','Order of the Keystone','Order of the Keystone',0,NULL,NULL,NULL,NULL,NULL,16),(550,'Sycamore',0,14,9,NULL,'Order of the Sycamore','Order of the Sycamore','Order of the Sycamore',0,NULL,NULL,NULL,NULL,NULL,16),(551,'Golden Alce',0,14,9,NULL,'Order of the Golden Alce','Order of the Golden Alce','Order of the Golden Alce',0,NULL,NULL,NULL,NULL,NULL,16),(552,'Cornelian',0,18,NULL,NULL,'Order of the Cornelian','Order of the Cornelian','Order of the Cornelian',0,NULL,NULL,NULL,NULL,NULL,16),(553,'Sigil of Æthelmearc',0,18,NULL,NULL,'Order of the Sigil of Æthelmearc','Order of the Sigil of Æthelmearc','Order of the Sigil of Æthelmearc',0,NULL,NULL,NULL,NULL,NULL,16),(554,'Silver Buccle',0,18,NULL,NULL,'Order of the Silver Buccle','Order of the Silver Buccle','Order of the Silver Buccle',0,NULL,NULL,NULL,NULL,NULL,16),(555,'Silver Alce',0,18,NULL,NULL,'Order of the Silver Alce','Order of the Silver Alce','Order of the Silver Alce',0,NULL,NULL,NULL,NULL,NULL,16),(556,'Silver Sycamore',0,18,NULL,NULL,'Order of the Silver Sycamore','Order of the Silver Sycamore','Order of the Silver Sycamore',0,NULL,NULL,NULL,NULL,NULL,16),(557,'Jewel of Æthelmearc',0,18,NULL,NULL,'Order of the Jewel of Æthelmearc','Order of the Jewel of Æthelmearc','Order of the Jewel of Æthelmearc',0,NULL,NULL,NULL,NULL,NULL,16),(558,'Garnet',0,19,NULL,NULL,'Order of the Garnet','Order of the Garnet','Order of the Garnet',1,NULL,NULL,NULL,NULL,NULL,16),(559,'Lochac Company of Archers',0,12,9,NULL,'Lochac Company of Archers',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,17),(560,'White Scarf of Lochac',0,12,9,NULL,'Order of the White Scarf of Lochac','Order of the White Scarf of Lochac','Order of the White Scarf of Lochac',0,NULL,NULL,NULL,NULL,NULL,17),(561,'Golden Tear',0,14,9,NULL,'Order of the Golden Tear','Order of the Golden Tear','Order of the Golden Tear',0,NULL,NULL,NULL,NULL,NULL,17),(562,'Lily',0,14,9,NULL,'Order of the Lily','Order of the Lily','Order of the Lily',0,NULL,NULL,NULL,NULL,NULL,17),(563,'Lochac Order of Grace',0,18,NULL,NULL,'Lochac Order of Grace',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,17),(564,'Rowan',0,18,NULL,NULL,'Order of the Rowan','Order of the Rowan','Order of the Rowan',0,NULL,NULL,NULL,NULL,NULL,17),(565,'Shining Helm',0,18,NULL,NULL,'Order of the Shining Helm','Order of the Shining Helm','Order of the Shining Helm',0,NULL,NULL,NULL,NULL,NULL,17),(566,'Cross of Lochac',0,18,NULL,NULL,'Order of the Cross of Lochac','Order of the Cross of Lochac','Order of the Cross of Lochac',0,'The Order of the Cross of Lochac (formerly the Order of the Southern Cross) may be given to those who have performed service to the Kingdom, but who are not citizens of Lochac. A representation of the southern cross is used in association with this award.','2010-04-11',7,'http://www.sca.org.au/canon/award.php?id=7',NULL,17),(567,'Prix Jongleur',0,18,NULL,NULL,'Prix Jongleur',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,17),(568,'Hasta Belli (Spear of War)',0,18,NULL,NULL,'Order of the Hasta Belli (Spear of War)','Order of the Hasta Belli (Spear of War)','Order of the Hasta Belli (Spear of War)',0,NULL,NULL,NULL,NULL,NULL,17),(569,'Nock',0,18,NULL,NULL,'Order of the Nock','Order of the Nock','Order of the Nock',0,NULL,NULL,NULL,NULL,NULL,17),(570,'Royal Cyphers',0,18,NULL,NULL,'Royal Cyphers',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,17),(571,'Tyr',0,12,9,NULL,'Order of Tyr','Order of Tyr','Order of Tyr',0,NULL,NULL,NULL,NULL,NULL,18),(572,'Bridget\'s Flame',0,12,9,NULL,'Order of Bridget\'s Flame','Order of Bridget\'s Flame','Order of Bridget\'s Flame',0,NULL,NULL,NULL,NULL,NULL,18),(573,'Destrer',0,12,9,NULL,'Order of the Destrer','Order of the Destrer','Order of the Destrer',0,NULL,NULL,NULL,NULL,NULL,18),(574,'Iron Griffin Legion',0,12,9,NULL,'Iron Griffin Legion',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,18),(575,'White Scarf',0,12,9,NULL,'Order of the White Scarf','Order of the White Scarf','Order of the White Scarf',0,NULL,NULL,NULL,NULL,NULL,18),(576,'Aquila',0,12,9,NULL,'Order of Aquila','Order of Aquila','Order of Aquila',0,NULL,NULL,NULL,NULL,NULL,18),(577,'Cygnus',0,14,9,NULL,'Award of Cygnus','Award of Cygnus','Award of Cygnus',0,NULL,NULL,NULL,NULL,NULL,18),(578,'Bale Fire',0,14,9,NULL,'Award of the Bale Fire','Award of the Bale Fire','Award of the Bale Fire',0,NULL,NULL,NULL,NULL,NULL,18),(579,'Queen\'s Glove',0,14,9,NULL,'Award of the Queen\'s Glove','Award of the Queen\'s Glove','Award of the Queen\'s Glove',0,NULL,NULL,NULL,NULL,NULL,18),(580,'Griffin\'s Sword',0,14,9,NULL,'Award of the Griffin\'s Sword','Award of the Griffin\'s Sword','Award of the Griffin\'s Sword',0,NULL,NULL,NULL,NULL,NULL,18),(581,'Black Bolt',0,14,9,NULL,'Award of the Black Bolt','Award of the Black Bolt','Award of the Black Bolt',0,NULL,NULL,NULL,NULL,NULL,18),(582,'Palfrey',0,14,9,NULL,'Award of the Palfrey','Award of the Palfrey','Award of the Palfrey',0,NULL,NULL,NULL,NULL,NULL,18),(583,'Crwth',0,18,NULL,NULL,'Order of the Crwth','Order of the Crwth','Order of the Crwth',0,NULL,NULL,NULL,NULL,NULL,18),(584,'Hearthstead',0,18,NULL,NULL,'Award of the Hearthstead','Award of the Hearthstead','Award of the Hearthstead',0,NULL,NULL,NULL,NULL,NULL,18),(585,'Nordhrband',0,18,NULL,NULL,'Award of the Nordhrband','Award of the Nordhrband','Award of the Nordhrband',0,NULL,NULL,NULL,NULL,NULL,18),(586,'Pyxis',0,18,NULL,NULL,'Order of the Pyxis','Order of the Pyxis','Order of the Pyxis',0,NULL,NULL,NULL,NULL,NULL,18),(587,'Saltire',0,18,NULL,NULL,'Order of the Saltire','Order of the Saltire','Order of the Saltire',0,NULL,NULL,NULL,NULL,NULL,18),(588,'King\'s/Queen\'s Cypher',0,18,NULL,NULL,'King\'s/Queen\'s Cypher',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,18),(589,'Prince\'s/Princess\' Cypher',0,18,NULL,NULL,'Prince\'s/Princess\' Cypher',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,18),(590,'Scroll of Honor',0,18,NULL,NULL,'Scroll of Honor',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,18),(591,'Persephone\'s Circle',0,18,NULL,NULL,'Order of Persephone\'s Circle','Order of Persephone\'s Circle','Order of Persephone\'s Circle',0,NULL,NULL,NULL,NULL,NULL,18),(592,'Compass',0,18,NULL,NULL,'Award of the Compass','Award of the Compass','Award of the Compass',0,NULL,NULL,NULL,NULL,NULL,18),(593,'Gold Lamp',0,18,NULL,NULL,'Award of the Gold Lamp','Award of the Gold Lamp','Award of the Gold Lamp',0,NULL,NULL,NULL,NULL,NULL,18),(594,'Bellerophon',0,18,NULL,NULL,'Award of Bellerophon','Award of Bellerophon','Award of Bellerophon',0,NULL,NULL,NULL,NULL,NULL,18),(595,'White Owle',0,18,NULL,NULL,'Award of the White Owle','Award of the White Owle','Award of the White Owle',0,NULL,NULL,NULL,NULL,NULL,18),(596,'Aegis',0,19,NULL,NULL,'Order of the Aegis','Order of the Aegis','Order of the Aegis',1,'also known as Award of Athena\'s Ring',NULL,NULL,NULL,NULL,18),(597,'Iron Watch',0,19,NULL,NULL,'Order of the Iron Watch','Order of the Iron Watch','Order of the Iron Watch',1,'also known as Eisenwache',NULL,NULL,NULL,NULL,18),(598,'Northshield Cross',0,19,NULL,NULL,'Order of the Northshield Cross','Order of the Northshield Cross','Order of the Northshield Cross',1,'also known as North Star, Guide Star, Northern Cross',NULL,NULL,NULL,NULL,18),(599,'Persephone\'s Circle',0,19,NULL,NULL,'Order of Persephone\'s Circle','Order of Persephone\'s Circle','Order of Persephone\'s Circle',1,NULL,NULL,NULL,NULL,NULL,18),(600,'The Prince/Princess\' Cypher',0,19,NULL,NULL,'The Prince/Princess\' Cypher',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,18),(601,'Sheriffs of Northshield',0,19,NULL,NULL,'Order of the Sheriffs of Northshield','Order of the Sheriffs of Northshield','Order of the Sheriffs of Northshield',1,NULL,NULL,NULL,NULL,NULL,18),(602,'Constabulary',0,19,NULL,NULL,'Order of the Constabulary','Order of the Constabulary','Order of the Constabulary',1,NULL,NULL,NULL,NULL,NULL,18),(603,'Griffin\'s Gem',0,19,NULL,NULL,'Award of the Griffin\'s Gem','Award of the Griffin\'s Gem','Award of the Griffin\'s Gem',1,NULL,NULL,NULL,NULL,NULL,18),(604,'Pictor',0,19,NULL,NULL,'Award of the Pictor','Award of the Pictor','Award of the Pictor',1,NULL,NULL,NULL,NULL,NULL,18),(605,'Orion',0,19,NULL,NULL,'Award of the Orion','Award of the Orion','Award of the Orion',1,NULL,NULL,NULL,NULL,NULL,18),(614,'Stag\'s Tynes',0,19,NULL,NULL,'Order of the Stag\'s Tynes','Order of the Stag\'s Tynes','Order of the Stag\'s Tynes',1,NULL,NULL,NULL,NULL,NULL,13),(615,'Leaping Stag',0,19,NULL,NULL,'Order of the Leaping Stag','Order of the Leaping Stag','Order of the Leaping Stag',1,NULL,NULL,NULL,NULL,NULL,13),(616,'Grail of Grace',0,19,NULL,NULL,'Order of the Grail of Grace','Order of the Grail of Grace','Order of the Grail of Grace',1,NULL,NULL,NULL,NULL,NULL,13),(617,'Princess\' Cypher',0,19,NULL,NULL,'Order of the Princess\' Cypher','Order of the Princess\' Cypher','Order of the Princess\' Cypher',1,NULL,NULL,NULL,NULL,NULL,13),(618,'Prince\'s Gauntlet',0,19,NULL,NULL,'Order of the Prince\'s Gauntlet','Order of the Prince\'s Gauntlet','Order of the Prince\'s Gauntlet',1,NULL,NULL,NULL,NULL,NULL,13),(619,'Crown\'s Order of Chivalry',0,18,NULL,NULL,'Crown\'s Order of Chivalry',NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,11),(620,'Royal Mandarin of the Court (Court Baronage)',0,16,8,NULL,'Royal Mandarin of the Court (Court Baronage)','Royal Mandarin of the Court (Court Baron)','Royal Mandarin of the Court (Court Baroness)',0,NULL,'2005-10-24',NULL,NULL,NULL,2),(621,'Principal of the Bard\'s Laureate',0,18,NULL,NULL,'Principal of the Bard\'s Laureate',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,11),(622,'Protector of the Bard\'s Laureate',0,18,NULL,NULL,'Protector of the Bard\'s Laureate',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,11),(623,'Trimarian Lancer',0,18,NULL,NULL,'Trimarian Lancer',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,11),(624,'The One and Only Court Vicar',0,18,NULL,NULL,'The One and Only Court Vicar',NULL,NULL,1,NULL,'2007-02-13',7,NULL,NULL,8),(625,'Swan',0,20,NULL,NULL,'Companions of the Swan','Companion of the Swan','Companion of the Swan',0,NULL,NULL,NULL,NULL,NULL,73),(626,'Attic Helm',0,20,NULL,NULL,'Order of the Attic Helm','Companion of the Order of the Attic Helm','Companion of the Order of the Attic Helm',0,'This is the Baronial award given to recognize fighters of high caliber. It was established to recognize members who, in addition to fighting skills, train new fighters and show chivalry on and off the field.','2006-02-24',NULL,NULL,NULL,77),(627,'Burdened Bouget',0,20,NULL,NULL,'Order of the Burdened Bouget','Companion of the Order of the Burdened Bouget','Companion of the Order of the Burdened Bouget',0,'This is the Baronial service award. It was established to recognize members of the populace who have made great sacrifices of themselves in service to the Barony. (A bouget is a medieval water bag.)','2006-02-24',NULL,NULL,NULL,77),(628,'Leaping Dolphin',0,20,NULL,NULL,'Order of the Leaping Dolphin','Companion of the Order of the Leaping Dolphin','Companion of the Order of the Leaping Dolphin',0,'This award is given by the new Coronets at their investiture to their predecessors, and none may be inducted into the order who have not ruled as Baron or Baroness. All past Coronets shall be granted this recognition and shall be inducted to the order upon successful completion of their term.','2006-02-24',NULL,NULL,NULL,77),(629,'Oriental Dragon',0,20,NULL,NULL,'Order of the Oriental Dragon','Companion of the Order of the Oriental Dragon','Companion of the Order of the Oriental Dragon',0,'This is the Baronial award given to recognize great skills in the arts or sciences. It is given to those who both do and teach.','2006-02-24',NULL,NULL,NULL,77),(630,'The Voyager',0,20,NULL,NULL,'The Voyager',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,77),(631,'Gold Ring Tourney',0,20,NULL,NULL,'Companions of the Gold Ring Tourney','Companion of the Gold Ring Tourney','Companion of the Gold Ring Tourney',0,NULL,NULL,NULL,NULL,NULL,133),(632,'Silver Swan',0,20,NULL,NULL,'Companions of the Silver Swan','Companion of the Silver Swan','Companion of the Silver Swan',0,NULL,NULL,NULL,NULL,NULL,133),(633,'Baroness\' Recognition',0,20,NULL,NULL,'Baroness\' Recognition',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,133),(634,'Daystar',0,20,NULL,NULL,'Companions of the Daystar','Companion of the Daystar','Companion of the Daystar',0,NULL,NULL,NULL,NULL,NULL,82),(635,'Bronze Tower',0,20,NULL,NULL,'Order of the Bronze Tower','Companion of the Bronze Tower','Companion of the Bronze Tower',0,'For service to the Barony','2006-01-19',NULL,NULL,NULL,81),(636,'Ivory Tower',0,20,NULL,NULL,'Order of the Ivory Tower','Companion of the Ivory Tower','Companion of the Ivory Tower',0,'For personal excellence & achievement or outstanding prowess in Arts and Sciences','2006-01-19',NULL,NULL,NULL,81),(637,'White Oak',0,20,NULL,NULL,'Companions of the White Oak','Companion of the White Oak','Companion of the White Oak',0,NULL,NULL,NULL,NULL,NULL,83),(638,'Gryphon\'s Plume',0,20,NULL,NULL,'Companions of the Gryphon\'s Plume','Companion of the Gryphon\'s Plume','Companion of the Gryphon\'s Plume',0,NULL,NULL,NULL,NULL,NULL,84),(639,'Flaming Brand',0,20,NULL,NULL,'Order of the Flaming Brand','Order of the Flaming Brand','Order of the Flaming Brand',0,'Given for service to the Barony. Members may wear the badge of the order: Ermine, a torch proper.','2006-01-18',NULL,NULL,NULL,84),(640,'Watchful Tower',0,20,NULL,NULL,'Order of the Watchful Tower','Order of the Watchful Tower','Order of the Watchful Tower',0,NULL,NULL,NULL,NULL,NULL,85),(641,'Northern Star',0,20,NULL,NULL,'Award of the Northern Star','Award of the Northern Star','Award of the Northern Star',0,NULL,NULL,NULL,NULL,NULL,86),(642,'White Wolf',0,20,NULL,NULL,'Order of the White Wolf','Order of the White Wolf','Order of the White Wolf',0,NULL,NULL,NULL,NULL,NULL,86),(643,'Silver Thunderbolt',0,20,NULL,NULL,'Companions of the Silver Thunderbolt','Companion of the Silver Thunderbolt','Companion of the Silver Thunderbolt',0,NULL,NULL,NULL,NULL,NULL,91),(644,'Sable Harps',0,20,NULL,NULL,'Companions of the Sable Harps','Companion of the Sable Harps','Companion of the Sable Harps',0,NULL,NULL,NULL,NULL,NULL,91),(645,'Lamp of Tir Ysgithr',0,20,NULL,NULL,'Companions of the Lamp of Tir Ysgithr','Companion of the Lamp of Tir Ysgithr','Companion of the Lamp of Tir Ysgithr',0,NULL,NULL,NULL,NULL,NULL,90),(646,'Axe',0,20,NULL,NULL,'Companions of the Axe','Companion of the Axe','Companion of the Axe',0,NULL,NULL,NULL,NULL,NULL,94),(647,'Dreamstone',0,20,NULL,NULL,'Companions of the Dreamstone','Companion of the Dreamstone','Companion of the Dreamstone',0,'The Baronial service award','2006-03-21',NULL,NULL,NULL,93),(648,'Golden Iris',0,20,NULL,NULL,'Companions of the Golden Iris','Companion of the Golden Iris','Companion of the Golden Iris',0,NULL,NULL,NULL,NULL,NULL,129),(649,'Dwarven Hammer',0,20,NULL,NULL,'Companions of the Dwarven Hammer','Companion of the Dwarven Hammer','Companion of the Dwarven Hammer',1,'From when Hammerhold was a Barony','2005-12-04',NULL,NULL,NULL,128),(650,'Tempered Steel',0,21,NULL,NULL,'Companions of the Tempered Steel','Companion of the Tempered Steel','Companion of the Tempered Steel',1,'From when Hammerhold was a Barony','2005-12-04',NULL,NULL,NULL,128),(651,'Red Raven',0,20,NULL,NULL,'Companions of the Red Raven','Companion of the Red Raven','Companion of the Red Raven',0,NULL,NULL,NULL,NULL,NULL,95),(652,'Silent Trumpet',0,20,NULL,NULL,'Order of the Silent Trumpet','Order of the Silent Trumpet','Order of the Silent Trumpet',0,NULL,NULL,NULL,NULL,NULL,104),(653,'Briar',0,20,NULL,NULL,'Order of the Briar','Order of the Briar','Order of the Briar',0,NULL,NULL,NULL,NULL,NULL,107),(654,'Golden Blossom',0,20,NULL,NULL,'Golden Blossom',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,107),(655,'Baronial Brownie',0,20,NULL,NULL,'Baronial Brownie','Companion of the Baronial Brownie','Companion of the Baronial Brownie',0,NULL,NULL,NULL,NULL,NULL,106),(656,'Escallop',0,20,NULL,NULL,'Companions of the Escallop','Companion of the Escallop','Companion of the Escallop',0,NULL,NULL,NULL,NULL,NULL,108),(657,'House of the Serpent\'s Torque',0,20,NULL,NULL,'Companions of the House of the Serpent\'s Torque','Companion of the House of the Serpent\'s Torque','Companion of the House of the Serpent\'s Torque',0,NULL,NULL,NULL,NULL,NULL,109),(658,'Acorn\'s Glade',0,20,NULL,NULL,'Companions of the Acorn\'s Glade','Companion of the Acorn\'s Glade','Companion of the Acorn\'s Glade',0,NULL,NULL,NULL,NULL,NULL,111),(659,'League of the Hidden Treasure',0,20,NULL,NULL,'Companions of the League of the Hidden Treasure','Companion of the League of the Hidden Treasure','Companion of the League of the Hidden Treasure',0,NULL,NULL,NULL,NULL,NULL,111),(660,'Trident Keype',0,21,NULL,NULL,'Companions of the Trident Keype','Companion of the Trident Keype','Companion of the Trident Keype',0,NULL,NULL,NULL,NULL,NULL,111),(661,'Darkwater Defender',0,20,NULL,NULL,'Order of the Darkwater Defender','Order of the Darkwater Defender','Order of the Darkwater Defender',0,NULL,NULL,NULL,NULL,NULL,111),(662,'Wyvern\'s Scale',0,20,NULL,NULL,'Order of the Wyvern\'s Scale','Order of the Wyvern\'s Scale','Order of the Wyvern\'s Scale',0,NULL,NULL,NULL,NULL,NULL,110),(663,'Guidon',0,20,NULL,NULL,'Award of the Guidon','Award of the Guidon','Award of the Guidon',0,NULL,NULL,NULL,NULL,NULL,113),(664,'Citizen of Ramshaven',0,20,NULL,NULL,'Citizen of Ramshaven',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,113),(665,'Favor of Ramshaven',0,20,NULL,NULL,'Favor of Ramshaven',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,113),(666,'Bear\'s Claw',0,20,NULL,NULL,'Companions of the Bear\'s Claw','Companion of the Bear\'s Claw','Companion of the Bear\'s Claw',0,NULL,NULL,NULL,NULL,NULL,112),(667,'Aspen',0,20,NULL,NULL,'Companions of the Aspen','Companion of the Aspen','Companion of the Aspen',0,NULL,NULL,NULL,NULL,NULL,115),(668,'Gilded Leaf',0,20,NULL,NULL,'Companions of the Gilded Leaf','Companion of the Gilded Leaf','Companion of the Gilded Leaf',0,NULL,NULL,NULL,NULL,NULL,115),(669,'Dragon\'s Blood',0,21,9,NULL,'Order of the Dragon\'s Blood','Companion of the Dragon\'s Blood','Companion of the Dragon\'s Blood',0,'The Order of the Dragon\'s Blood is an arts & sciences award. It is given by the Baron and/or Baroness to those persons who have demonstrated excellence in the arts and sciences. It carries an Award of Arms.','2006-02-28',NULL,NULL,NULL,114),(670,'Pride of Dragonsspine',0,20,NULL,NULL,'Order of the Pride of Dragonsspine','Companion of the Pride of Dragonsspine','Companion of the Pride of Dragonsspine',0,'The Order of the Pride of Dragonsspine is a children\'s award, formerly known as the Dragon\'s Spawn. It is given by the Baron and/or Baroness in appreciation for those youths who have enriched the Barony.','2006-02-28',NULL,NULL,NULL,114),(671,'Scales of Dragonsspine',0,21,9,NULL,'Order of the Scales of Dragonsspine','Companion of the Scales of Dragonsspine','Companion of the Scales of Dragonsspine',0,'The Order of the Scales of Dragonsspine is a service award. It is given by the Baron and/or Baroness to those persons whom they feel have served the Barony well. It carries an Award of Arms.','2006-02-28',NULL,NULL,NULL,114),(672,'Baroness\' Order of Excellence',0,20,NULL,NULL,'Baroness\' Order of Excellence',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,118),(673,'Guardians of the Knight',0,20,NULL,NULL,'Companions of the Guardians of the Knight','Companion of the Guardians of the Knight','Companion of the Guardians of the Knight',0,NULL,NULL,NULL,NULL,NULL,118),(674,'Wheel',0,20,NULL,NULL,'Companions of the Wheel','Companion of the Wheel','Companion of the Wheel',0,NULL,NULL,NULL,NULL,NULL,118),(675,'Crystal of the Salt Waste',0,21,NULL,NULL,'Crystal of the Salt Waste',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,120),(676,'White Duck',0,20,NULL,NULL,'White Duck',NULL,NULL,0,'Formerly Devoted and Unique Company of Keepers DUCK',NULL,NULL,NULL,NULL,120),(677,'White Lark',0,20,NULL,NULL,'White Lark',NULL,NULL,0,'Formerly Laboring Artist\'s Recognition Company LARC',NULL,NULL,NULL,NULL,120),(678,'White Falcon',0,20,NULL,NULL,'White Falcon',NULL,NULL,0,'Formerly Fighters  Awarded for Laboring towards Chivalry Or Nobility FALCON',NULL,NULL,NULL,NULL,120),(679,'White Cygnet',0,20,NULL,NULL,'White Cygnet',NULL,NULL,0,'Formerly Companions of Young Gentles Nurturing Emerging Talent CYGNET',NULL,NULL,NULL,NULL,120),(680,'Ermine and Gauntlet',0,20,NULL,NULL,'Order of the Ermine and Gauntlet','Order of the Ermine and Gauntlet','Order of the Ermine and Gauntlet',0,NULL,NULL,NULL,NULL,NULL,120),(681,'Ermine and Quill',0,20,NULL,NULL,'Order of the Ermine and Quill','Order of the Ermine and Quill','Order of the Ermine and Quill',0,NULL,NULL,NULL,NULL,NULL,120),(682,'Crystal Heart',0,20,NULL,NULL,'Order of the Crystal Heart','Order of the Crystal Heart','Order of the Crystal Heart',0,NULL,NULL,NULL,NULL,NULL,120),(683,'Fons di Anima',0,20,NULL,NULL,'Order of the Fons di Anima','Order of the Fons di Anima','Order of the Fons di Anima',0,NULL,NULL,NULL,NULL,NULL,120),(684,'Golden Reflection',0,20,NULL,NULL,'Order of the Golden Reflection','Order of the Golden Reflection','Order of the Golden Reflection',0,NULL,NULL,NULL,NULL,NULL,120),(685,'Ice Dragon',0,20,NULL,NULL,'Order of the Ice Dragon','Order of the Ice Dragon','Order of the Ice Dragon',0,NULL,NULL,NULL,NULL,NULL,123),(686,'Raven\'s Feather',0,20,NULL,NULL,'Order of the Raven\'s Feather','Order of the Raven\'s Feather','Order of the Raven\'s Feather',0,NULL,NULL,NULL,NULL,NULL,124),(687,'Heliotrope',0,20,NULL,NULL,'Heliotrope',NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,125),(688,'Corolla Aulica',0,19,NULL,NULL,'Corolla Aulica',NULL,NULL,0,'The Corollae Nebulosae\r\n\"Little Crowns of the Mists\", there are three of these: The Corolla Aulica, given for service; the Corolla Muralis, given for leadership and achievement in war; and the Corolla Vitae, given to honor those who have given of their talents and skills to benefit the Principality. The token for the Corollae Nebulosae as a whole is a small cast pendant of a coronet within a bordure engrailed, the type of Corolla dependant on the color of the ribbon from which it is hung: White is for the Corolla Aulica, Blue - the Corolla Vitae, and Green is for the Corolla Muralis.','2006-10-26',7,NULL,NULL,74),(689,'Gilded Thimble',0,20,NULL,NULL,'Order of the Gilded Thimble','Companion of the Gilded Thimble','Companion of the Gilded Thimble',0,'The Order of the Gilded Thimble is given for improvement and skill in Costuming. Authenticity, attention to detail, workmanship and research are among the criteria considered. New members are decided by the current members of the Order.','2005-10-31',NULL,NULL,NULL,99),(690,'Serpent\'s Flame',0,20,NULL,NULL,'Order of the Serpent\'s Flame','Companion of the Serpent\'s Flame','Companion of the Serpent\'s Flame',0,'The Order of the Serpent\'s Flame is given for artistic talent and the teaching of a specific art within the barony.','2005-10-31',NULL,NULL,NULL,99),(691,'Golden Trident',0,20,NULL,NULL,'Order of the Golden Trident','Companion of the Golden Trident','Companion of the Golden Trident',0,'The Order of the Golden Trident is awarded for service and leadership to the barony of Calafia. This is service to the Barony and not to your household or War band.','2005-10-31',NULL,NULL,NULL,99),(692,'Serpent\'s Talon',0,20,NULL,NULL,'Order of the Serpent\'s Talon','Companion of the Serpent\'s Talon','Companion of the Serpent\'s Talon',0,'The Order of the Serpent\'s Talon is given after consultation with the current members of the Order, for Calafian fighters who have succeeded in tournament combat, have maintained a period appearance, have participated in the arts or service to the Society, and who are exceptionally chivalrous.','2005-10-31',NULL,NULL,NULL,99),(693,'Serpent\'s Fang',0,20,NULL,NULL,'Order of the Serpent\'s Fang','Companion of the Serpent\'s Fang','Companion of the Serpent\'s Fang',0,'The Order of the Serpent\'s Fang is given to recognize those fighters whose virtue and skill best represent Calafia on the tournament field. The companions of this Order are selected from members of the Rapier and the Unarmored Combat Guilds of Calafia whom not only excel in prowess on the field, but also strive to improve their forms of combat. Additionally, they provide a continuous example of appearance, chivalry, service and leadership for other members of the Barony to emulate.','2005-10-31',NULL,NULL,NULL,99),(694,'Serpent\'s Heart',0,20,NULL,NULL,'Order of the Serpent\'s Heart','Companion of the Serpent\'s Heart','Companion of the Serpent\'s Heart',0,'The Order of the Serpent\'s Heart is a children\'s award for those who have made a contribution to the barony; one who sets an outstanding example of maturity or chivalry for other children, or a child with exceptional artistic talent who has encouraged other children to learn about the Middle Ages and to become involved in the Society by his/her example.','2005-10-31',NULL,NULL,NULL,99),(695,'Leodamus',0,20,NULL,NULL,'Order of Leodamus','Companion of Leodamus','Companion of Leodamus',0,'This award is given in honor of Lord Leodamus of Thebes by the populace to a Calafian who puts the barony\'s needs above his (or her) own and works to bring divided groups (or individuals) together. This is a special and rarely given award. All Calafian\'s subscribing to the Serpent\'s Tongue are polled at the annual Leodamus of Thebes Tournament.','2005-10-31',NULL,NULL,NULL,99),(696,'Windblown Leaf',0,20,NULL,NULL,'Order of the Windblown Leaf','Companion of the Windblown Leaf','Companion of the Windblown Leaf',0,NULL,'2005-11-20',NULL,NULL,NULL,80),(697,'Sand Dollar',0,20,NULL,NULL,'Sand Dollar',NULL,NULL,0,'Baronial Arts and Sciences award','2005-12-04',NULL,NULL,NULL,105),(698,'Sentinels of the Stargate',0,20,NULL,NULL,'Sodality of the Sentinels of the Stargate','Sodality of the Sentinels of the Stargate','Sodality of the Sentinels of the Stargate',0,NULL,'2006-08-07',NULL,NULL,NULL,103),(699,'Comet Or',0,20,NULL,NULL,'Order of the Comet Or','Companion of the Comet Or','Companion of the Comet Or',0,'Baronial service award','2005-12-17',NULL,NULL,NULL,122),(700,'Red Comet',0,20,NULL,NULL,'Order of the Red Comet','Companion of the Red Comet','Companion of the Red Comet',0,'Baronial martial award','2005-12-17',NULL,NULL,NULL,122),(701,'Baronial Award of Courtesy',0,20,NULL,NULL,'Baronial Award of Courtesy',NULL,NULL,0,'Given to those who exemplify \"Courtesy, Chivalry, and Honour.\"','2005-12-29',NULL,NULL,NULL,32),(702,'Friend of the Mountain',0,20,NULL,NULL,'Friend of the Mountain',NULL,NULL,0,'Awarded to those gentles who have furthered the interest of Hidden Mountain and whom do not live within its boundaries.','2007-04-01',7,NULL,NULL,27),(703,'Academie de Griffe',0,20,NULL,NULL,'Academie de Griffe',NULL,NULL,0,'Given to all of the Barony\'s authorized fencers.','2006-01-18',NULL,NULL,NULL,84),(704,'Augean Stables - Augmentation',0,20,NULL,NULL,'Augmentation of the Order of the Augean Stables','Augmentation of the Order of the Augean Stables','Augmentation of the Order of the Augean Stables',1,'Awarded by Baron Barre and Baroness Cordelia to those members of the Order of the Augean Stables whose work went far beyond that expected from their previous induction into the order.','2007-04-01',7,NULL,NULL,32),(705,'Job - Augmentation',0,20,NULL,NULL,'Augmentation of the Order of Job','Augmentation of the Order of Job','Augmentation of the Order of Job',1,'Awarded by Baron Barre and Baroness Cordelia to those members of the Order of Job whose work went far beyond that expected from their previous induction into the order.','2007-04-01',7,NULL,NULL,32),(706,'Silberberg - Augmentation',0,20,NULL,NULL,'Augmentation of the Order of the Silberberg','Augmentation of the Order of the Silberberg','Augmentation of the Order of the Silberberg',1,'Awarded by Baron Barre and Baroness Cordelia to those members of the Order of the Silberberg whose work went far beyond that expected from their previous induction into the order.','2007-04-01',7,NULL,NULL,32),(707,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence',NULL,NULL,0,'Given by the Baron for outstanding service and support to the Barony of Storvik.','2006-08-02',NULL,NULL,NULL,22),(708,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy',NULL,NULL,0,'This award is granted by the Baroness to any individual who has repeadtedly shown exceptional courtesy to others. The token of the award is a small bead or gift specially choosen by the Baroness.','2006-02-27',NULL,NULL,NULL,31),(709,'Towers of Dreiburgen',0,20,NULL,NULL,'Order of the Towers of Dreiburgen',NULL,NULL,0,'Given for high service to the Barony','2006-01-19',NULL,NULL,NULL,97),(710,'Illuminated Tower',0,20,NULL,NULL,'Order of the Illuminated Tower of Dreiburgen',NULL,NULL,0,'Given for high skill in arts and sciences, including combat arts (can be granted more than once)','2006-01-19',NULL,NULL,NULL,97),(711,'Silver Tower',0,20,NULL,NULL,'Order of the Silver Tower','Companion of the Silver Tower','Companion of the Silver Tower',0,'For outstanding service to the Barony','2006-01-19',NULL,NULL,NULL,81),(712,'le Beau Coeur',0,20,NULL,NULL,'le Beau Coeur',NULL,NULL,0,NULL,'2006-02-06',NULL,NULL,NULL,98),(713,'le Coeur Noble',0,20,NULL,NULL,'le Coeur Noble',NULL,NULL,0,NULL,'2006-02-06',NULL,NULL,NULL,98),(714,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence',NULL,NULL,0,NULL,'2006-02-06',NULL,NULL,NULL,28),(715,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy',NULL,NULL,0,NULL,'2006-02-06',NULL,NULL,NULL,28),(716,'Baronial Gallant',0,20,NULL,NULL,'Order of the Baronial Gallant','Companion of the Order of the Baronial Gallant','Companion of the Order of the Baronial Gallant',0,'This is established to honor those members of the Barony who are at all times examples of courtesy and grace.','2006-02-24',NULL,NULL,NULL,77),(717,'Ginger Flower',0,20,NULL,NULL,'Honor of the Ginger Flower','Honor of the Ginger Flower','Honor of the Ginger Flower',0,'This honor is presented to fighters whose prowess on the field of battle is exceeded only by their ability to die with panache and flair.','2006-02-24',NULL,NULL,NULL,77),(718,'Coronet\'s Appreciation',0,20,NULL,NULL,'Honor of the Coronet\'s Appreciation','Honor of the Coronet\'s Appreciation','Honor of the Coronet\'s Appreciation',0,'This honor is presented to those who have, through some special deed or service, made life easier for the Coronet.','2006-02-24',NULL,NULL,NULL,77),(719,'Tempest Tossed Traveller - Gules',0,20,NULL,NULL,'Order of the Tempest Tossed Traveller - Gules','Companion of the Order of the Tempest Tossed Traveller - Gules','Companion of the Order of the Tempest Tossed Traveller - Gules',0,'As travel throughout the Barony is difficult due to the distance Between the different groups, Palatine Baroness Bernadette and Baron Phtuule created an award on October 23, A.S. XXXIX (2004) to recognise those that travel througout the Barony and to lands beyond our shores. The order consists of four levels, given in succession for the number of groups within the Barony visited by an individual.','2006-02-24',NULL,NULL,NULL,77),(720,'Tempest Tossed Traveller - Argent',0,20,NULL,NULL,'Order of the Tempest Tossed Traveller - Argent','Companion of the Order of the Tempest Tossed Traveller - Argent','Companion of the Order of the Tempest Tossed Traveller - Argent',0,'As travel throughout the Barony is difficult due to the distance Between the different groups, Palatine Baroness Bernadette and Baron Phtuule created an award on October 23, A.S. XXXIX (2004) to recognise those that travel througout the Barony and to lands beyond our shores. The order consists of four levels, given in succession for the number of groups within the Barony visited by an individual.','2006-02-24',NULL,NULL,NULL,77),(721,'Sea Griffon',0,20,NULL,NULL,'Order of the Sea Griffon','Companion of the Order of the Sea Griffon','Companion of the Order of the Sea Griffon',0,'This order recognizes those who are the very ideal of what the gentry of the current Middle Ages should be. It was established to recognize members of the populace who have made great sacrifices of themselves in service to the Barony, who have demonstrated great courtesy, chivalry, and grace at all times, and who have achieved much in the arts and sciences. This is a polling order.','2006-02-24',NULL,NULL,NULL,77),(722,'Empty Shell',0,20,NULL,NULL,'Order of the Empty Shell','Companion of the Order of the Empty Shell','Companion of the Order of the Empty Shell',0,'This is the Baronial award established to honor those members of the Barony who have participated in the Barony\'s various activities thereby enriching it. This order is only given to members who are leaving the Barony.','2006-02-24',NULL,NULL,NULL,77),(723,'Carraig Uaine Mark of Excellence',0,20,NULL,NULL,'Carraig Uaine Mark of Excellence',NULL,NULL,0,'This award is given for a specific achievement in the Arts and Sciences. The token for this award is a green bead to be added to the gentle\'s Mark of Excellence.','2006-04-23',NULL,NULL,NULL,31),(724,'Carraig Deirge Mark of Excellence',0,20,NULL,NULL,'Carraig Deirge Mark of Excellence',NULL,NULL,0,'This award is given for a specific gift of Service.  The token for this award is a red bead to be added to the gentle\'s Mark of Excellence.','2006-04-23',NULL,NULL,NULL,31),(725,'Carraig Gile Mark of Excellence',0,20,NULL,NULL,'Carraig Gile Mark of Excellence',NULL,NULL,0,'This award is given for a specific achievement in the Arts of War (any marshalled activity). The token for this award is a white bead to be added to the recipients Mark of Excellence.','2006-04-23',NULL,NULL,NULL,31),(726,'Emerald Flame',0,20,NULL,NULL,'Order of the Emerald Flame','Companion of the Emerald Flame','Companion of the Emerald Flame',0,'This order is granted to those gentles who have demonstrated on going excellence in Arts and Sciences.','2006-02-28',NULL,NULL,NULL,31),(727,'Garnet Tower',0,20,NULL,NULL,'Order of the Garnet Tower','Companion of the Garnet Tower','Companion of the Garnet Tower',0,'This order is granted to those gentles who have demonstrated on going excellence in gifts of Service.','2006-02-28',NULL,NULL,NULL,31),(728,'Silver Blade',0,20,NULL,NULL,'Order of the Silver Blade','Companion of the Silver Blade','Companion of the Silver Blade',0,'This order is granted to those gentles who have demonstrated on going excellence in the Arts of War (any marshalled activity).','2006-02-28',NULL,NULL,NULL,31),(729,'Dragon\'s Grace',0,21,9,NULL,'Order of the Dragon\'s Grace','Companion of the Dragon\'s Grace','Companion of the Dragon\'s Grace',0,'The Order of the Dragon\'s Grace is a rapier award. It is given by the Baron and/or Baroness to those persons who have demonstrated excellence in the art of fencing. It carries an Award of Arms.','2006-02-28',NULL,NULL,NULL,114),(730,'Dragon\'s Claw',0,21,9,NULL,'Order of the Dragon\'s Claw','Companion of the Dragon\'s Claw','Companion of the Dragon\'s Claw',0,'The Order of the Dragon\'s Claw is a martial arts award. It is given by the Baron and/or Baroness to those persons who have demonstrated excellence in the arts of combat. It carries an Award of Arms.','2006-02-28',NULL,NULL,NULL,114),(731,'Dragon\'s Fire',0,21,9,NULL,'Order of the Dragon\'s Fire','Companion of the Dragon\'s Fire','Companion of the Dragon\'s Fire',0,'The Order of the Dragon\'s Fire, originally the Order of the Dragon Vanguard, is an award given to to those persons who have demonstrated excellence in the art of archery. The award carries with it an Award of Arms.','2006-02-28',NULL,NULL,NULL,114),(732,'Guardians of the Golden Flame',0,20,NULL,NULL,'Order of the Guardians of the Golden Flame','Companion of the Guardians of the Golden Flame','Companion of the Guardians of the Golden Flame',0,'The Order of the Guardians of the Golden Flame is a \"pursuing the Dream\" award. It is given by the Baron and/or Baroness to those persons who, through extended service and loyalty to the Dragon, have brought the strengths and virtues we strive to recreate to the Barony.','2006-02-28',NULL,NULL,NULL,114),(733,'Gentle Dragon',0,20,NULL,NULL,'Order of the Gentle Dragon','Companion of the Gentle Dragon','Companion of the Gentle Dragon',0,'The Order of the Gentle Dragon is a courtesy award. It is given by the Baron and/or Baroness to those persons who have demonstrated excellence in courtesy and chivalry.','2006-02-28',NULL,NULL,NULL,114),(734,'Windmill',0,20,NULL,NULL,'Companions of the Windmill','Companion of the Windmill','Companion of the Windmill',0,'Baronial Service award','2006-03-09',NULL,NULL,NULL,121),(735,'Star of Bryn Madoc',0,20,NULL,NULL,'Star of Bryn Madoc',NULL,NULL,0,'The Baronial Chivalry Exemplar award for ladies, given by the lords of the Barony.','2006-03-21',NULL,NULL,NULL,93),(736,'Mark of Excellence - Augmentation',0,20,NULL,NULL,'Augmentation of the Mark of Excellence','Augmentation of the Mark of Excellence','Augmentation of the Mark of Excellence',1,NULL,'2006-04-23',NULL,NULL,NULL,31),(737,'Dun Carraig\'s Champions',0,20,NULL,NULL,'Order of Dun Carraig\'s Champions','Companion of Dun Carraig\'s Champions','Companion of Dun Carraig\'s Champions',0,NULL,'2006-04-19',NULL,NULL,NULL,31),(738,'Honorary Subject of Black Diamond',0,20,NULL,NULL,'Honorary Subjects of Black Diamond','Honorary Subject of Black Diamond','Honorary Subject of Black Diamond',0,'For those who really should be Black Diamonders, but aren\'t...yet.','2006-05-17',NULL,NULL,NULL,26),(739,'Fledglings',0,20,NULL,NULL,'Award of the Fledglings','Award of the Fledglings','Award of the Fledglings',0,'Children\'s Award','2006-05-22',NULL,NULL,NULL,35),(740,'La Courtesia',0,19,NULL,NULL,'Order of La Courtesia','Order of La Courtesia','Order of La Courtesia',0,'The La Courtesia is given for courtesy. The token is a crystal snowflake hung from a white ribbon. This Order is a polling Order.','2006-05-29',NULL,NULL,NULL,73),(741,'Princess\' Token',0,19,NULL,NULL,'Princess\' Token','Princess\' Token','Princess\' Token',0,'This may be given to any whom the Princess feels gave \"cheerful\" help during her reign.','2006-05-29',NULL,NULL,NULL,73),(742,'Honorary Citizen of Windmasters\' Hill',0,20,NULL,NULL,'Honorary Citizen of Windmasters\' Hill','Honorary Citizen of Windmasters\' Hill','Honorary Citizen of Windmasters\' Hill',0,'For people leaving Windmasters\' Hill that have made a lasting impression on the Barony and we want to be able to keep as members of the populace.','2007-02-18',7,NULL,NULL,20),(743,'Wounded Kitty',0,20,NULL,NULL,'Award of the Wounded Kitty','Award of the Wounded Kitty','Award of the Wounded Kitty',0,'For people injured in service to the Barony','2007-02-18',7,NULL,NULL,20),(744,'Russian Thistle of al-Barran',0,21,9,NULL,'Order of the Russian Thistle of al-Barran','Companion of the Russian Thistle of al-Barran','Companion of the Russian Thistle of al-Barran',0,'Given for excellence and contributions in the arts and sciences.','2006-07-02',NULL,NULL,NULL,116),(745,'Scorpion of al-Barran',0,21,9,NULL,'Order of the Scorpion of al-Barran','Companion of the Scorpion of al-Barran','Companion of the Scorpion of al-Barran',0,'Given for outstanding service to the Barony','2006-07-02',NULL,NULL,NULL,116),(746,'Muddy Drekkar',0,20,NULL,NULL,'Order of the Muddy Drekkar','Companion of the Muddy Drekkar','Companion of the Muddy Drekkar',1,'This one-time award was created to recognize those individuals who helped the Baron and Baroness extract themselves from the mud at the Coronation of Robert and Denise.','2007-01-20',7,NULL,NULL,22),(747,'Great Snowy Owl',0,20,NULL,NULL,'Order of the Great Snowy Owl','Companion of the Great Snowy Owl','Companion of the Great Snowy Owl',1,NULL,'2006-08-20',NULL,NULL,NULL,22),(749,'Oerthan Sword',0,19,NULL,NULL,'Order of the Oerthan Sword','Order of the Oerthan Sword','Order of the Oerthan Sword',0,'This is given for prowess in combat and chivalrous conduct, the token for this is a leather-mounted sword ring decorated with a seated wolf-at-bay.','2006-08-27',NULL,NULL,NULL,75),(750,'Princess\' Riband',0,19,NULL,NULL,'Princess\' Riband','Princess\' Riband','Princess\' Riband',0,'This is given to reward those who have been of exceptional service to the Princess. The token of the order is usually a ribbon of the Princess\' personal colors, or other tokens determined by the Princess.','2006-08-27',NULL,NULL,NULL,75),(751,'Sea Tyger',0,18,NULL,'sea_tyger.gif','Order of the Sea Tyger','Order of the Sea Tyger','Order of the Sea Tyger',0,'Honors and recognizes those young people (up to and including the age of 17) who have distinguished themselves by acts of valor and chivalry in martial activities.','2009-01-31',7,NULL,NULL,8),(752,'Alcyon',0,18,NULL,'alcyon.gif','Order of the Alcyon','Award of the Alcyon','Award of the Alcyon',0,'The Order of the Alcyon honors and recognizes youths, who have distinguished themselves by their labors and achievements in the arts and sciences. All past recipients of the Award of the Alcyon (Closed)will be considered to be recipients of this award.','2009-01-31',7,NULL,NULL,8),(753,'Sanguine Mountain',0,21,9,NULL,'Order of the Sanguine Mountain','Companion of the Sanguine Mountain','Companion of the Sanguine Mountain',0,'The Order of the Sanguine Mountain shall be given by the Baron/Baroness Iron Mountain for outstanding service to the Barony.','2006-09-18',NULL,NULL,NULL,96),(754,'Pearl (AoA)',0,14,9,'pearl.gif','Order of the Pearl','Companion of the Pearl','Companion of the Pearl',0,'One becomes a Pearl through teaching and excellence in the arts and sciences.',NULL,NULL,'http://pearls.atlantia.sca.org',4,8),(755,'Kraken (AoA)',0,14,9,'kraken.gif','Order of the Kraken','Companion of the Kraken','Companion of the Kraken',0,'One is awarded the Kraken for excellence in the martial arts.',NULL,NULL,NULL,5,8),(756,'Sea Stag (AoA)',0,14,9,'sea_stag.gif','Order of the Sea Stag','Companion of the Sea Stag','Companion of the Sea Stag',0,'One becomes a Sea Stag through excellence in teaching the martial arts.',NULL,NULL,NULL,6,8),(757,'Yew Bow (AoA)',0,14,9,'yew_bow.gif','Order of the Yew Bow','Companion of the Yew Bow','Companion of the Yew Bow',0,'One is awarded the Yew Bow for excellence in archery.',NULL,NULL,NULL,7,8),(758,'Golden Dolphin (AoA)',0,14,9,'golden_dolphin.gif','Order of the Golden Dolphin','Companion of the Golden Dolphin','Companion of the Golden Dolphin',0,'One becomes a Golden Dolphin through excellence in service.','2008-01-27',7,'http://goldendolphins.atlantia.sca.org',8,8),(759,'Court Baronage (GoA)',1,11,8,'cbaron_sq.gif','Court Barons/Baronesses','Court Baron','Court Baroness',0,'Court Baronages are given at the pleasure of the Crown.',NULL,NULL,NULL,3,NULL),(760,'Rose (AoA)',1,14,9,'rose.gif','Order of the Rose','Lord of the Rose','Lady of the Rose',0,'Consorts may be inducted into the Order of the Rose upon completion of a reign.',NULL,NULL,NULL,2,NULL),(761,'Rams Heart',0,18,NULL,NULL,'Rams Heart','Rams Heart','Rams Heart',0,NULL,'2006-10-19',7,NULL,NULL,19),(762,'Corolla Vitae',0,19,NULL,NULL,'Corolla Vitae',NULL,NULL,0,'The Corollae Nebulosae\r\n\"Little Crowns of the Mists\", there are three of these: The Corolla Aulica, given for service; the Corolla Muralis, given for leadership and achievement in war; and the Corolla Vitae, given to honor those who have given of their talents and skills to benefit the Principality. The token for the Corollae Nebulosae as a whole is a small cast pendant of a coronet within a bordure engrailed, the type of Corolla dependant on the color of the ribbon from which it is hung: White is for the Corolla Aulica, Blue - the Corolla Vitae, and Green is for the Corolla Muralis.','2006-10-26',7,NULL,NULL,74),(763,'Princess\' Favor',0,19,NULL,NULL,'Order of the Princess\' Favor',NULL,NULL,0,'This is given to those who have been helpful to the Princess during her reign. The token varies from Princess to Princess.','2006-10-26',7,NULL,NULL,74),(764,'Sable Shield',0,20,NULL,NULL,'Order of the Sable Shield','Order of the Sable Shield','Order of the Sable Shield',0,'For those authorized to fight heavy weapons','2006-10-31',7,NULL,NULL,84),(765,'Comet Azure-Argent',0,20,NULL,NULL,'Order of the Comet Azure-Argent','Companion of the Comet Azure-Argent','Companion of the Comet Azure-Argent',0,'Baronial Arts and Sciences award','2006-11-13',7,NULL,NULL,122),(767,'Crimson Cloud',0,20,NULL,NULL,'Award of the Crimson Cloud','Award of the Crimson Cloud','Award of the Crimson Cloud',0,'Given for consistent improvement in the realm of heavy combat.','2007-04-12',7,NULL,NULL,27),(768,'Quintain',0,14,9,'quintain.gif','Order of the Quintain','Companion of the Quintain','Companion of the Quintain',0,'The Order of the Quintain recognizes and honors those who have distinguished themselves and shown excellence in the pursuit of equestrian activities, in service or valor.','2008-01-27',7,NULL,NULL,8),(769,'Phoenix\'s Garnet',0,20,NULL,NULL,'Award of the Phoenix\'s Garnet','Award of the Phoenix\'s Garnet','Award of the Phoenix\'s Garnet',0,'Created in 2006 and is recognition of gentles who have aided or done service directly for the Baron and/or Baroness.','2007-07-08',7,NULL,NULL,25),(770,'Phoenix\'s Rose Quartz',0,20,NULL,NULL,'Award of the Phoenix\'s Rose Quartz','Award of the Phoenix\'s Rose Quartz','Award of the Phoenix\'s Rose Quartz',0,'Created in 2006 and is given for acts and deeds of Courtesy, Chivalry or Honor.','2007-07-08',7,NULL,NULL,25),(771,'Chef d\'oeuvre',0,20,NULL,NULL,'Award of the Chef d\'oeuvre','Award of the Chef d\'oeuvre','Award of the Chef d\'oeuvre',0,'Created in 2006 and is given to individuals for skill in planning and cooking feasts.','2007-07-08',7,NULL,NULL,25),(772,'Guardians of the Saguaro',0,20,NULL,NULL,'Order of the Guardians of the Saguaro','Guardians of the Saguaro','Guardians of the Saguaro',0,'Given to those persons who consistently display exceptional courtesy and grace.','2007-02-01',7,'http://www.atenveldt.org/Heraldry/OrderofPrecedence/tabid/111/aid/125/Default.aspx',NULL,91),(773,'Silver Cloud',0,20,NULL,NULL,'Award of the Silver Cloud','Award of the Silver Cloud','Award of the Silver Cloud',0,'Given for consistent work in serving the needs of the barony.','2007-04-01',7,NULL,NULL,27),(774,'Eurus',0,20,NULL,NULL,'Award of the Eurus','Award of the Eurus','Award of the Eurus',0,'Given for a single noteworthy effort of service for or to the Barony. May be received multiple times.','2007-02-18',7,NULL,NULL,20),(775,'Notus',0,20,NULL,NULL,'Award of the Notus','Award of the Notus','Award of the Notus',0,'Given for a single wonder of Arts and Science within or for the Barony. May be received multiple times.','2007-02-18',7,NULL,NULL,20),(776,'Aeolus',0,20,NULL,NULL,'Order of the Aeolus','Order of the Aeolus','Order of the Aeolus',0,'For fighters under the age of 18 either for youth combat or for participation in regular SCA combat between ages 16 and 18.','2007-02-18',7,NULL,NULL,20),(777,'Hurt',0,20,NULL,NULL,'Award of the Hurt','Award of the Hurt','Award of the Hurt',0,'Given for those who have been injured in service to the Barony.','2007-02-18',7,NULL,NULL,20),(778,'Scirocco',0,20,NULL,NULL,'Award of the Scirocco','Award of the Scirocco','Award of the Scirocco',0,'Given for a single superb effort on the fighting field with or for the Barony. This award may be received multiple times.','2007-02-18',7,NULL,NULL,20),(779,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy','Baroness\' Award of Courtesy','Baroness\' Award of Courtesy',0,NULL,'2007-02-19',7,NULL,NULL,20),(780,'Sable Chevronels',0,20,NULL,NULL,'Order of the Sable Chevronels','Order of the Sable Chevronels','Order of the Sable Chevronels',0,'Given to those individuals who distinguish themselves through unselfish effort and service. The Chevronel, an ancient symbol denoting excellence, is the symbol for this order. Holders of this award are styled Companions of the Order of the Sable Chevronels and are entitled to place the initials CSC after their names.','2007-02-22',7,NULL,NULL,91),(781,'Retired Territorial Baronage (no arms)',1,18,NULL,'baron_sq.gif','Retired Territorial Barons/Baronesses','Territorial Baron, Retired','Territorial Baroness, Retired',0,'Landed Baronage is appointed by the Crown.  These are former Territorial Barons and Baronesses of the Known World.','2008-10-22',7,NULL,9,NULL),(782,'Amethyst Chalice',0,20,NULL,NULL,'Amethyst Chalice','Amethyst Chalice','Amethyst Chalice',0,'Given for selfless, unfailing loyalty, guidance and a consistently high quality of gracious assistance provided directly to, for and on behalf of the Baron and/or Baroness of Arn Hold.','2007-03-06',7,NULL,NULL,119),(783,'Cirque d\'Honour',0,20,NULL,NULL,'Cirque d\'Honour','Cirque d\'Honour','Cirque d\'Honour',0,'Presented to those good gentles that have achieved the honor of holding the title of Champion, within any of the various Championships, of the Barony of Arn Hold.  This award is presented upon their stepping down as Champion, as a thank you for their service to the Barony and as a memory of their time as a Baronial Champion.','2009-01-17',7,NULL,NULL,119),(784,'Jewel of Alces',0,21,NULL,NULL,'Jewel of Alces','Jewel of Alces','Jewel of Alces',0,'This is the Highest Award of Arn Hold.  It is given to those who consistently display extreme excellence in the giving of their time, talents, service, chivalry, assistance, active participation, courtesy, scholastic accomplishment, and are always providing unfailing support of this Barony and our populous; begin those who thereby set themselves apart as a shining example of the ideal citizen of Arn Hold.','2007-03-06',7,NULL,NULL,119),(785,'Service Performed Under Duress (The S.P.U.D.)',0,20,NULL,NULL,'Service Performed Under Duress (The S.P.U.D.)','Service Performed Under Duress (The S.P.U.D.)','Service Performed Under Duress (The S.P.U.D.)',0,'Given, in the spirit of good fun, for an individual act of service whereby the recipient did put forth a great deal of effort towards a particularly difficult, time-consuming, tedious, onerous and/or exhausting task, doing so graciously, willing, and without complaint.','2007-03-06',7,NULL,NULL,119),(786,'Tripsciore\'s Moufle',0,20,NULL,NULL,'Tripsciore\'s Moufle','Tripsciore\'s Moufle','Tripsciore\'s Moufle',0,'Given for excellence in the Arts and Sciences, as practiced in the Society for Creative Anachronism, in and for the Barony of Arn Hold.','2009-01-17',7,NULL,NULL,119),(787,'Azure Cloud',0,20,NULL,NULL,'Award of the Azure Cloud','Award of the Azure Cloud','Award of the Azure Cloud',0,'Given for consistent work in the arts and sciences.','2007-04-01',7,NULL,NULL,27),(788,'Silver Spoon',0,20,NULL,NULL,'Award of the Silver Spoon','Award of the Silver Spoon','Award of the Silver Spoon',0,'For Excellence in Feastocrating.','2007-04-01',7,NULL,NULL,27),(789,'Leather Bound Book',0,20,NULL,NULL,'Award of the Leather Bound Book','Award of the Leather Bound Book','Award of the Leather Bound Book',0,'For Excellence in Autocratting.','2007-04-01',7,NULL,NULL,27),(790,'Golden Shell',0,20,NULL,NULL,'Order of the Golden Shell','Companion of the Golden Shell','Companion of the Golden Shell',0,'The Golden Shell is the personal award of Martelle Von Charlottenburg during her tenure as Baroness of the Bright Hills to honor those who give exemplary service to the Coronet.  It is represented by a gold scallop shell on a green ribbon.','2007-05-14',7,NULL,NULL,32),(791,'Phoenix\'s Citrine',0,20,NULL,NULL,'Award of the Phoenix\'s Citrine','Award of the Phoenix\'s Citrine','Award of the Phoenix\'s Citrine',0,'Created in 2006 and recognizes efforts in teaching, organizing and in any other way furthering the arts in the Barony.','2007-07-08',7,NULL,NULL,25),(792,'Phoenix\'s Granite',0,20,NULL,NULL,'Award of the Phoenix\'s Granite','Award of the Phoenix\'s Granite','Award of the Phoenix\'s Granite',0,'Created in 2006 and is given to a fighter (of any form) for excellent service to the Barony on the field (displaying Baronial Colors, fighting to honor their Barony, marshalling, teaching etc).','2007-07-08',7,NULL,NULL,25),(793,'Phoenix\'s Pyrite',0,20,NULL,NULL,'Award of the Phoenix\'s Pyrite','Award of the Phoenix\'s Pyrite','Award of the Phoenix\'s Pyrite',0,'Created in 2006 and is given to individuals for service to the Barony above and beyond any sane reckoning.','2007-07-08',7,NULL,NULL,25),(794,'Phoenix\'s Emerald',0,20,NULL,NULL,'Award of the Phoenix\'s Emerald','Award of the Phoenix\'s Emerald','Award of the Phoenix\'s Emerald',0,'Created in 2006 and is given to a person who is highly and uniquely valuable to the Barony. One time achievement award.','2007-07-08',7,NULL,NULL,25),(795,'Phoenix\'s Amber',0,20,NULL,NULL,'Award of the Phoenix\'s Amber','Award of the Phoenix\'s Amber','Award of the Phoenix\'s Amber',0,'Created in 2006 and recognizes outstanding Arts & Sciences achievements within the Barony of the Sacred Stone by youth 17 and under.','2007-07-08',7,NULL,NULL,25),(796,'Phoenix\'s Onyx',0,20,NULL,NULL,'Award of the Phoenix\'s Onyx','Award of the Phoenix\'s Onyx','Award of the Phoenix\'s Onyx',0,'Created in 2006 and recognizes outstanding performance on the field in any form of Youth Marshal Activity, current and future.','2007-07-08',7,NULL,NULL,25),(797,'Phoenix\'s Peridot',0,20,NULL,NULL,'Award of the Phoenix\'s Peridot','Award of the Phoenix\'s Peridot','Award of the Phoenix\'s Peridot',0,'Created in 2006 and is given to recognize special contributions made by youth ages 11 to 17.','2007-07-08',7,NULL,NULL,25),(798,'Defenders of the Sacred Stone',0,20,NULL,NULL,'The Defenders of the Sacred Stone/Phoenix','The Defenders of the Sacred Stone/Phoenix','The Defenders of the Sacred Stone/Phoenix',0,'Created in 2006 and is given to recognize those who served Sacred Stone during their term as Champion by working to support the Barony both inside and outside the borders, in the area of which they were Champion.','2007-07-08',7,NULL,NULL,25),(799,'Baron\'s Award of Excellence',0,20,NULL,NULL,'Baron\'s Award of Excellence','Baron\'s Award of Excellence','Baron\'s Award of Excellence',0,NULL,'2007-07-24',7,NULL,NULL,35),(800,'Baroness\' Award of Courtesy',0,20,NULL,NULL,'Baroness\' Award of Courtesy','Baroness\' Award of Courtesy','Baroness\' Award of Courtesy',0,NULL,'2007-07-24',7,NULL,NULL,35),(801,'Crested Hatchling',0,20,NULL,NULL,'Order of the Crested Hatchling','Order of the Crested Hatchling','Order of the Crested Hatchling',0,'Recognizes excellence in children.','2007-07-25',7,NULL,NULL,26),(802,'Vexillum Atlantiae',0,18,NULL,'vexillum_atlantiae.gif','Award of the Vexillum Atlantiae','Award of the Vexillum Atlantiae','Award of the Vexillum Atlantiae',0,'The Vexillum Atlantiae (award of the banner)\r\nhonors and recognizes the ferocity and valor of a\r\ngroup of fighters as a whole, not as individuals.\r\nWhen they fight as a unit, the group will have the\r\nhonor of carrying the banner with the heraldry of the\r\naward into battle.','2009-06-08',7,NULL,NULL,8),(803,'Baronial Award of Excellence',0,20,NULL,NULL,'Baronial Award of Excellence','Baronial Award of Excellence','Baronial Award of Excellence',0,NULL,'2007-08-31',7,NULL,NULL,29),(804,'Purple Clarion',0,20,NULL,NULL,'Order of the Purpure Clarion','Companion of the Purple Clarion','Companion of the Purple Clarion',0,'Given to those persons who have displayed excellence in the performance, promotion and teaching of the arts and sciences.','2007-09-12',7,NULL,NULL,92),(805,'Silver Ivy',0,19,NULL,NULL,'Order of the Silver Ivy','Order of the Silver Ivy','Order of the Silver Ivy',0,'This is awarded to those who have served the Principality as Champion of the Mist and Champion\'s Consort.','2007-09-27',7,NULL,NULL,74),(806,'Sable Fret',0,20,NULL,NULL,'Sable Fret','Sable Fret','Sable Fret',0,'Baronial service award','2007-11-11',7,NULL,NULL,102),(807,'Palm of Atenveldt',0,20,NULL,NULL,'Order of the Palm of Atenveldt','Companion of the Palm of Atenveldt','Companion of the Palm of Atenveldt',0,'here shall exist in the Barony of Atenveldt an award, known as the Order of the Palm of Atenveldt, which will be given by the Baron and Baroness, subject to the pleasure of the Crown, to those persons who have served the Barony faithfully, above and beyond that service normally expected of the subjects of the Barony.','2008-02-28',7,NULL,NULL,92),(808,'Baroness\'s Cygnet',0,20,NULL,NULL,'Baroness\'s Cygnet','Baroness\'s Cygnet','Baroness\'s Cygnet',0,NULL,'2008-02-28',7,NULL,NULL,92),(809,'Wa\'a Oar',0,20,NULL,NULL,'Wa\'a Oar','Wa\'a Oar','Wa\'a Oar',0,NULL,'2008-04-20',7,NULL,NULL,101),(810,'Lion d\'Or',0,18,NULL,NULL,'Lion d\'Or','Lion d\'Or','Lion d\'Or',0,'Given to a fighter that has shown valor, chivalry and honor on the field of battle that day.','2008-04-27',7,NULL,NULL,11),(811,'Corolla Muralis',0,19,NULL,NULL,'Corolla Muralis',NULL,NULL,0,'\"Little Crowns of the Mists\", there are three of these: The Corolla Aulica, given for service (white ribbon); the Corolla Muralis, given for leadership and achievement in war (green ribbon); and the Corolla Vitae (blue ribbon), given to honor those who have given of their talents and skills to benefit the Principality. The token for the Corollae Nebulosae as a whole is a small cast pendant of a coronet within a bordure engrailed, the type of Corolla dependant on the color of the ribbon from which it is hung.','2008-04-27',7,NULL,NULL,74),(812,'Friendly Castle',0,19,NULL,NULL,'Order of the Friendly Castle',NULL,NULL,0,'This is given for hospitality. The token is a swan above an heraldic \"Friendly Castle\" (a two towered castle with its gate raised). This Order is a polling Order.','2008-04-27',7,NULL,NULL,73),(813,'Astrum Australis',0,21,NULL,NULL,'Order of the Astrum Australis','Companion of the Astrum Australis','Companion of the Astrum Australis',0,'Given for outstanding service','2008-04-27',7,NULL,NULL,117),(814,'Flame',0,20,NULL,NULL,'Order of the Flame','Order of the Flame','Order of the Flame',0,'Service to the Barony - This order is held in high prestige as this is for volunteer work not only within the barony but also the kingdom. The other members of the order vote on those that have been nominated.','2008-05-18',7,NULL,NULL,100),(815,'Defender of the Flame Armored Combat',0,20,NULL,NULL,'Order of the Defender of the Flame Armored Combat','Order of the Defender of the Flame Armored Combat','Order of the Defender of the Flame Armored Combat',0,'Membership in this order is voted upon by those who are already in the order. This is for those who have fought well and hard, who have given their time to others, etc.','2008-05-18',7,NULL,NULL,100),(816,'Wolf\'s Tooth',0,20,NULL,NULL,'Order of the Wolf\'s Tooth','Order of the Wolf\'s Tooth','Order of the Wolf\'s Tooth',0,'Combat - This order is not just for heavy weapons but for all forms of combat. This is given to those who consistently go to practices, help others learn the art of the weapon style, go to wars, etc.','2008-05-18',7,NULL,NULL,100),(817,'Augmented Flame',0,20,NULL,NULL,'Order of the Augmented Flame','Order of the Augmented Flame','Order of the Augmented Flame',0,'Continued Service to the Barony - similar to the Order of the Flame.','2008-05-18',7,NULL,NULL,100),(818,'King\'s Award of Excellence',0,18,NULL,NULL,'King\'s Award of Excellence','King\'s Award of Excellence','King\'s Award of Excellence',0,NULL,'2008-06-19',7,NULL,NULL,16),(819,'[Unnamed long-time service award]',0,20,NULL,NULL,NULL,NULL,NULL,0,'Created to honor not only Lord Adam of Erin\'s lifelong service but also to recognize Baronial members who give above and beyond the call of duty over a long period of time.','2008-08-20',7,NULL,NULL,34),(820,'Caer Mear',0,20,NULL,NULL,'Order of Caer Mear','Order of Caer Mear','Order of Caer Mear',0,'This is the most prestigious of Caer Mear\'s Awards, and exemplifies what it means to be from Caer Mear.  This award is given by the Baronage of Caer Mear only to those members of the barony who have served for any extraordinarily long amount of time. This Order was created by Baron Balynar Thorvaldsson.','2008-08-27',7,NULL,NULL,21),(821,'Merlon',0,20,NULL,NULL,'The Merlon of Caer Mear',NULL,NULL,0,'The Merlon (The highest point of a battlement on a castle wall) is given by the Baronage of Caer Mear, jointly or separately, for a one time act of exemplary effort in service, the arts, or arts martial. This award may be received multiple times and was created by Baron Bryce de Byram and Baroness Melisent la Ruse.','2008-09-23',7,NULL,NULL,21),(822,'Black Widow',0,18,NULL,NULL,'Order of the Black Widow',NULL,NULL,1,NULL,'2008-10-01',7,NULL,NULL,11),(823,'Jeweled Horn',0,18,NULL,NULL,'Order of the Jeweled Horn',NULL,NULL,0,'The Order of the Jeweled Horn shall consist of those individuals displaying exceptional courtesy, honor, chivalry, and nobility and who embody what is means to be from Gleann Abhann and a member of this Society.','2008-10-13',7,NULL,NULL,19),(824,'Diamond of Gleann Abhann',0,19,NULL,NULL,'Order of the Diamond of Gleann Abhann',NULL,NULL,1,'The Order of the Diamond of Gleann Abhann is presented, at the pleasure of the Coronet of Gleann Abhann, to past Princesses of the Principality.','2008-10-13',7,NULL,NULL,19),(825,'Unnamed Service Award (Shield of Storvik)',0,20,NULL,NULL,NULL,NULL,NULL,0,'An award that does not yet have a name that was to recognize the conspicuous service given as Seneschal, including particularly the fact that barony meetings have not been more than an hour in length, and all the business was handled in that time.','2010-02-22',7,NULL,NULL,22),(826,'Quiver',0,18,NULL,NULL,'Order of the Quiver','Quiver','Quiver',1,NULL,'2008-11-17',7,NULL,NULL,11),(827,'Golden Nutmeg',0,20,NULL,NULL,'Order of the Golden Nutmeg',NULL,NULL,0,'The Order of the Golden Nutmeg is awarded for excellence in cooking.','2008-12-20',7,NULL,NULL,28),(828,'Guide Star',0,19,NULL,NULL,'Guide Star','Guide Star','Guide Star',0,'Order of the Northshield Cross (also known as North Star, Guide Star, Northern Cross):\r\n    Membership in the order may be offered to those gentles who have served the Principality above and beyond the norm, either through service such as an officer (local or principality) or service to a group (autocratting, working at events, scribal efforts, etc.)','2009-01-11',7,NULL,NULL,18),(829,'Cygnet',0,19,NULL,NULL,'Cygnet','Cygnet','Cygnet',0,'This is an award given to younger members of the realm (under 16 years) for their contributions to the Principality of Cynagua. The token of this award is a black wooden swan.','2009-03-21',7,NULL,NULL,73),(830,'Pegasus',0,19,NULL,NULL,'Order of the Pegasus','Pegasus','Pegasus',0,'This is given to youth whose behavior and service are exemplary. The token is a pendant of a pegasus.','2009-03-21',7,NULL,NULL,74),(831,'Paragon of Merriment',0,18,NULL,NULL,'West Kingdom Paragons of Merriment','Paragon of Merriment','Paragon of Merriment',0,'The WKPM is given at the discretion of the Crown to those individuals who help create and support period entertainment and activities for the enjoyment of the populace and of the Kingdom. In particular those whose efforts enhance the festivities and evening revels through dance, music, performance arts, and any other social activity which may prove worthy for this honor. The token for this honor shall be a ribbon of festive colors with a leather roundel stamped with the initials of the award.','2009-03-21',7,NULL,NULL,1),(832,'Cynaguan Guard',0,18,NULL,NULL,'Cynaguan Guard','Cynaguan Guard','Cynaguan Guard',0,'Members of the Cynaguan Guard hold this honor for the duration of the reign of the Prince and Princess who admitted them to the honor. The duties will vary depending on the Royalty.','2009-03-21',7,NULL,NULL,73),(833,'Scutiferus Cynaguae (Shieldbearer of Cynagua)',0,19,NULL,NULL,'Scutiferus Cynaguae (Shieldbearer of Cynagua)','Scutiferus Cynaguae (Shieldbearer of Cynagua)','Scutiferus Cynaguae (Shieldbearer of Cynagua)',0,'The secondary service award given for exceptional service. The token of this award is a small bronze shield.','2009-03-21',7,NULL,NULL,73),(834,'Crystal Swan',0,19,NULL,NULL,'Order of the Crystal Swan',NULL,'Crystal Swan',0,'This is given to past Princesses of Cynagua. The token is a crystal swan.','2009-03-21',7,NULL,NULL,73),(835,'Swan\'s Heart',0,19,NULL,NULL,'Order of the Swan\'s Heart','Swan\'s Heart','Swan\'s Heart',0,'This is given to the Consort of the Black Swan, the token is a stone of rose quartz in the shape of a heart hung from a white ribbon.','2009-03-21',7,NULL,NULL,73),(836,'Cynaguan Medal of Honor',0,19,NULL,NULL,'Cynaguan Medal of Honor','Cynaguan Medal of Honor','Cynaguan Medal of Honor',0,'This is given by their Highnesses to those fighters who have demonstrated valor, bravery and skill in times of war. The token is a metal swan suspended from green and red ribbons.','2009-03-21',7,NULL,NULL,73),(837,'Black Swan',0,19,NULL,NULL,'Order of the Black Swan','Black Swan','Black Swan',0,'Runner up in the Coronet Tournament. The token is a triangular silver pendant marked with a silver swan holding a sword. The token is passed down to the newest member. A smaller version of the token is also given to the member to keep.','2009-03-21',7,NULL,NULL,73),(838,'Raptor\'s Talon',0,20,NULL,NULL,'Award of the Raptor\'s Talon','Raptor\'s Talon','Raptor\'s Talon',0,'For prowess on the list field.','2009-06-18',7,NULL,NULL,35),(839,'King\'s Cypher',0,18,NULL,NULL,'King\'s Cypher','King\'s Cypher','King\'s Cypher',0,'The King’s Cypher is awarded to those persons who have been thoughtful and helpful to the King during his reign. The token is a medallion, unique to the reign. A person might receive several Royal Cyphers from different reigns.','2009-11-01',7,NULL,NULL,17),(840,'Onyx Heart',0,20,NULL,NULL,'Order of the Onyx Heart','Onyx Heart','Onyx Heart',0,'Given to those gentles whose continued service and sacrifice has enriched the barony.','2010-10-10',7,NULL,NULL,26),(841,'Minerva\'s Fountain',0,20,NULL,NULL,'Order of Minerva\'s Fountain','Minerva\'s Fountain','Minerva\'s Fountain',0,'Given to those gentles who have shown excellence and continuing promise in the field of Arts and Sciences.','2010-06-02',7,NULL,NULL,26),(842,'Golden Guard',0,20,NULL,NULL,'Order of the Golden Guard','Golden Guard','Golden Guard',0,'Given to those gentles who have shown great prowess and continuing support of their martial community. (Attainable by all forms of the martial arts)','2010-06-02',7,NULL,NULL,26),(843,'Golden Wings of Icarus',0,20,NULL,NULL,'Award of the Golden Wings of Icarus','Golden Wings of Icarus','Golden Wings of Icarus',0,'Awarded  to those gentles who continuously serve the barony above and beyond the call of duty, always reaching for the sky.','2010-06-02',7,NULL,NULL,26),(844,'Mother of Pearl',0,20,NULL,NULL,'Order of Mother of Pearl','Mother of Pearl','Mother of Pearl',0,'Given to those gentles who show continuing support and succor to the Barony of Black Diamond, exceeding all expectations (\"Mom\" Award)','2010-06-19',7,NULL,NULL,26),(845,'Crystal Hourglass',0,20,NULL,NULL,'Award of the Crystal Hourglass','Crystal Hourglass','Crystal Hourglass',0,'Awarded to those who serve the Barony of Black Diamond (can be given more than once); does not need to be a member of the Barony.','2010-06-19',7,NULL,NULL,26),(846,'Black Diamond',0,20,NULL,NULL,'Order of the Black Diamond','Black Diamond','Black Diamond',0,'Awarded to an individual who shines as an example to all of the strength and purity of the Black Diamond.','2010-06-19',7,NULL,NULL,26),(847,'Diamond Chip',0,20,NULL,NULL,'Award of the Diamond Chip','Diamond Chip','Diamond Chip',0,'Given in recognition of individual feats of service or sacrifice. May be given more than once.','2010-10-10',7,NULL,NULL,26),(848,'Seraphic Star',0,20,NULL,NULL,'Order of the Seraphic Star','Companion of the Seraphic Star','Companion of the Seraphic Star',0,'Order of the Seraphic Star: Established in 1971 by Baron Sárkányi Gerö to recognize outstanding service to the Barony. It is a polling order. The very special award, when given, is bestowed at Angels Yule. Please send recommendations to the Principal of the Order.','2010-10-10',128,'http://www.sca-angels.org/history.php',NULL,148);
/*!40000 ALTER TABLE `award` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `award_group`
--

DROP TABLE IF EXISTS `award_group`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `award_group` (
  `award_group_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `award_group_name` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `award_file_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `award_file_name2` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `collective_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `website` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `award_blurb` text CHARACTER SET latin1,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`award_group_id`),
  KEY `FK_award_group__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_award_group__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `award_group`
--

LOCK TABLES `award_group` WRITE;
/*!40000 ALTER TABLE `award_group` DISABLE KEYS */;
INSERT INTO `award_group` VALUES (1,'Chivalry','knight.gif','m_at_arms.gif','Order of the Chivalry','','One becomes a member of the Chivalry through martial prowess on the field.  Knights swear fealty to the Crown.  Masters/Mistresses at Arms do not swear fealty to the Crown.',NULL,NULL),(2,'Rose','rose.gif',NULL,'Order of the Rose',NULL,'Consorts may be inducted into the Order of the Rose upon completion of a reign.',NULL,NULL),(3,'Court Baronage','cbaron_sq.gif',NULL,'Court Barons/Baronesses',NULL,NULL,NULL,NULL),(4,'Pearl','pearl.gif',NULL,'Order of the Pearl','http://pearls.atlantia.sca.org','One becomes a Pearl through teaching and excellence in the arts and sciences.',NULL,NULL),(5,'Kraken','kraken.gif',NULL,'Order of the Kraken',NULL,'One is awarded the Kraken for excellence in the martial arts.',NULL,NULL),(6,'Sea Stag','sea_stag.gif',NULL,'Order of the Sea Stag',NULL,'One becomes a Sea Stag through excellence in teaching the martial arts.',NULL,NULL),(7,'Yew Bow','yew_bow.gif',NULL,'Order of the Yew Bow',NULL,'One is awarded the Yew Bow for excellence in archery.',NULL,NULL),(8,'Golden Dolphin','golden_dolphin.gif',NULL,'Order of the Golden Dolphin','http://goldendolphins.atlantia.sca.org','One becomes a Golden Dolphin through excellence in service.',NULL,NULL),(9,'Retired Territorial Baronage','baron_sq.gif',NULL,'Retired Territorial Barons/Baronesses',NULL,'Landed Baronage is appointed by the Crown.  These are former Territorial Barons and Baronesses of the Known World.',NULL,NULL);
/*!40000 ALTER TABLE `award_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `baronage`
--

DROP TABLE IF EXISTS `baronage`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `baronage` (
  `baronage_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `baron_id` mediumint(8) unsigned DEFAULT NULL,
  `baroness_id` mediumint(8) unsigned DEFAULT NULL,
  `baronage_display` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `event_id` mediumint(8) unsigned DEFAULT NULL,
  `baronage_start_sequence` smallint(6) NOT NULL DEFAULT '0',
  `baronage_start_date` date DEFAULT NULL,
  `baronage_end_date` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  `branch_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`baronage_id`),
  KEY `FK_baronage_baron__atlantian` (`baron_id`),
  KEY `FK_baronage_baroness_atlantian` (`baroness_id`),
  KEY `FK_baronage__event` (`event_id`),
  KEY `FK_baronage__last_edited` (`last_updated_by`),
  KEY `FK_baronage__branch` (`branch_id`),
  CONSTRAINT `FK_baronage_baroness_atlantian` FOREIGN KEY (`baroness_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_baronage_baron__atlantian` FOREIGN KEY (`baron_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_baronage__branch` FOREIGN KEY (`branch_id`) REFERENCES `atlantia_branch`.`branch` (`branch_id`),
  CONSTRAINT `FK_baronage__event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  CONSTRAINT `FK_baronage__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=135 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Temporary table structure for view `branch`
--

DROP TABLE IF EXISTS `branch`;
/*!50001 DROP VIEW IF EXISTS `branch`*/;
/*!50001 CREATE TABLE `branch` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `date_dissolved` date,
  `inactive` tinyint(4),
  `name_reg_date` date,
  `blazon` text,
  `device_reg_date` date,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `is_atlantian` tinyint(4),
  `notes` text,
  `regional_group_id` mediumint(8) unsigned,
  `group_id` int(11),
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Temporary table structure for view `branch_type`
--

DROP TABLE IF EXISTS `branch_type`;
/*!50001 DROP VIEW IF EXISTS `branch_type`*/;
/*!50001 CREATE TABLE `branch_type` (
  `branch_type_id` mediumint(8) unsigned,
  `branch_type` varchar(50),
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Table structure for table `court_report`
--

DROP TABLE IF EXISTS `court_report`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `court_report` (
  `court_report_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_id` mediumint(8) unsigned DEFAULT NULL,
  `reign_id` mediumint(8) unsigned DEFAULT NULL,
  `principality_id` mediumint(8) unsigned DEFAULT NULL,
  `baronage_id` mediumint(8) unsigned DEFAULT NULL,
  `court_type` char(1) CHARACTER SET latin1 DEFAULT NULL,
  `court_date` date DEFAULT NULL,
  `court_time` tinyint(4) DEFAULT NULL,
  `herald` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `received_date` date DEFAULT NULL,
  `entered_date` date DEFAULT NULL,
  `notes` text CHARACTER SET latin1,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  `kingdom_id` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`court_report_id`),
  KEY `FK_court_report__event` (`event_id`),
  KEY `FK_court_report__reign` (`reign_id`),
  KEY `FK_court_report__principality` (`principality_id`),
  KEY `FK_court_report__baronage` (`baronage_id`),
  KEY `FK_court_report__last_edited` (`last_updated_by`),
  KEY `court_date` (`court_date`),
  KEY `received_date` (`received_date`),
  KEY `entered_date` (`entered_date`),
  KEY `FK_court_report__kingdom` (`kingdom_id`),
  CONSTRAINT `FK_court_report__baronage` FOREIGN KEY (`baronage_id`) REFERENCES `baronage` (`baronage_id`),
  CONSTRAINT `FK_court_report__event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  CONSTRAINT `FK_court_report__kingdom` FOREIGN KEY (`kingdom_id`) REFERENCES `atlantia_branch`.`branch` (`branch_id`),
  CONSTRAINT `FK_court_report__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_court_report__principality` FOREIGN KEY (`principality_id`) REFERENCES `principality` (`principality_id`),
  CONSTRAINT `FK_court_report__reign` FOREIGN KEY (`reign_id`) REFERENCES `reign` (`reign_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2054 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `event`
--

DROP TABLE IF EXISTS `event`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `event` (
  `event_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `event_name` varchar(100) CHARACTER SET latin1 DEFAULT NULL,
  `start_date` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  `end_date` date DEFAULT NULL,
  `branch_id` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY (`event_id`),
  KEY `FK_event__last_edited` (`last_updated_by`),
  KEY `event_name` (`event_name`),
  KEY `start_date` (`start_date`),
  KEY `end_date` (`end_date`),
  KEY `FK_event__branch` (`branch_id`),
  CONSTRAINT `FK_event__branch` FOREIGN KEY (`branch_id`) REFERENCES `atlantia_branch`.`branch` (`branch_id`),
  CONSTRAINT `FK_event__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=1292 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `precedence`
--

DROP TABLE IF EXISTS `precedence`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `precedence` (
  `type_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `precedence` smallint(5) unsigned NOT NULL DEFAULT '0',
  `display_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `award_file_name` varchar(255) CHARACTER SET latin1 DEFAULT NULL,
  `award_blurb` text CHARACTER SET latin1,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`type_id`),
  KEY `FK_precedence__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_precedence__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `precedence`
--

LOCK TABLES `precedence` WRITE;
/*!40000 ALTER TABLE `precedence` DISABLE KEYS */;
INSERT INTO `precedence` VALUES (1,'Monarch',1,'Their Majesties, King and Queen of Atlantia',NULL,NULL,NULL,NULL),(2,'Heir',2,'Their Highnesses, Prince and Princess of Atlantia',NULL,NULL,NULL,NULL),(3,'Coronet-Principality',3,'Their Highnesses, Prince and Princess of Principality',NULL,NULL,NULL,NULL),(4,'Heir-Principality',4,'Heir to Principality',NULL,NULL,NULL,NULL),(5,'Ducal',5,'Royal Peers - Dukes/Duchesses','duchy_sq.gif','One becomes a Duke or Duchess after ruling a kingdom twice.',NULL,NULL),(6,'County',6,'Royal Peers - Counts/Countesses','county_sq.gif','One becomes a Count or Countess after ruling a kingdom once.',NULL,NULL),(7,'Viscounty',7,'Royal Peers - Viscounts/Vicountesses','viscounty_sq.gif','One becomes a Viscount or Viscountess after ruling a principality once. These are from foreign principalities, or from the time when Atlantia was a principality of the East Kingdom. Atlantia has no principalities at this time.',NULL,NULL),(8,'Bestowed Peerage (PoA Level)',8,'Bestowed Peers',NULL,NULL,NULL,NULL),(9,'Patent of Arms',9,'Patent of Arms',NULL,NULL,NULL,NULL),(10,'Territorial Baronage',10,'Territorial Barons/Baronesses','baron_sq.gif',NULL,NULL,NULL),(11,'Court Baronage (GoA)',13,'Court Barons/Baronesses','cbaron_sq.gif',NULL,NULL,NULL),(12,'Order of High Merit (GoA Level)',12,'Orders of High Merit',NULL,NULL,NULL,NULL),(13,'Grant of Arms',14,'Grant of Arms',NULL,NULL,NULL,NULL),(14,'Kingdom Order of Merit (AoA Level)',15,'Kingdom Orders of Merit',NULL,NULL,NULL,NULL),(15,'Principality Order of Merit (AoA Level)',17,'Principality Orders of Merit',NULL,NULL,NULL,NULL),(16,'Court Baronage (AoA)',16,'Court Barons/Baronesses','cbaron_sq.gif',NULL,NULL,NULL),(17,'Award of Arms',19,'Award of Arms',NULL,NULL,NULL,NULL),(18,'Kingdom Award',20,'Kingdom Award Recipients',NULL,NULL,NULL,NULL),(19,'Principality Award',21,'Principality Award Recipients',NULL,NULL,NULL,NULL),(20,'Baronial Award',22,'Baronial Award Recipients',NULL,NULL,NULL,NULL),(21,'Baronial Order of Merit (AoA Level)',18,'Baronial Orders of Merit',NULL,NULL,NULL,NULL),(22,'Retired Territorial Baronage',11,'Retired Territorial Barons/Baronesses','baron_sq.gif',NULL,NULL,NULL);
/*!40000 ALTER TABLE `precedence` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `principality`
--

DROP TABLE IF EXISTS `principality`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `principality` (
  `principality_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `prince_id` mediumint(8) unsigned DEFAULT NULL,
  `princess_id` mediumint(8) unsigned DEFAULT NULL,
  `principality_display` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `event_id` mediumint(8) unsigned DEFAULT NULL,
  `principality_start_sequence` smallint(6) NOT NULL DEFAULT '0',
  `principality_start_date` date DEFAULT NULL,
  `principality_end_date` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`principality_id`),
  KEY `FK_principality_prince__atlantian` (`prince_id`),
  KEY `FK_principality_princess_atlantian` (`princess_id`),
  KEY `FK_principality__event` (`event_id`),
  KEY `FK_principality__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_principality_princess_atlantian` FOREIGN KEY (`princess_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_principality_prince__atlantian` FOREIGN KEY (`prince_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_principality__event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  CONSTRAINT `FK_principality__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `reign`
--

DROP TABLE IF EXISTS `reign`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `reign` (
  `reign_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `king_id` mediumint(8) unsigned DEFAULT NULL,
  `queen_id` mediumint(8) unsigned DEFAULT NULL,
  `monarchs_display` varchar(50) CHARACTER SET latin1 DEFAULT NULL,
  `event_id` mediumint(8) unsigned DEFAULT NULL,
  `reign_start_sequence` smallint(6) NOT NULL DEFAULT '0',
  `reign_start_date` date DEFAULT NULL,
  `reign_end_date` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`reign_id`),
  KEY `FK_reign_king__atlantian` (`king_id`),
  KEY `FK_reign_queen_atlantian` (`queen_id`),
  KEY `FK_reign__event` (`event_id`),
  KEY `FK_reign__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_reign_king__atlantian` FOREIGN KEY (`king_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_reign_queen_atlantian` FOREIGN KEY (`queen_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_reign__event` FOREIGN KEY (`event_id`) REFERENCES `event` (`event_id`),
  CONSTRAINT `FK_reign__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=61 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `scroll_status`
--

DROP TABLE IF EXISTS `scroll_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `scroll_status` (
  `scroll_status_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `scroll_status_code` char(1) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `scroll_status` varchar(25) CHARACTER SET latin1 NOT NULL DEFAULT '',
  PRIMARY KEY (`scroll_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `scroll_status`
--

LOCK TABLES `scroll_status` WRITE;
/*!40000 ALTER TABLE `scroll_status` DISABLE KEYS */;
INSERT INTO `scroll_status` VALUES (1,'P','Needed'),(2,'I','Assigned'),(3,'S','Complete'),(4,'N','Not required'),(5,'R','Requested');
/*!40000 ALTER TABLE `scroll_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `title`
--

DROP TABLE IF EXISTS `title`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `title` (
  `title_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `title_male` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `title_female` varchar(50) CHARACTER SET latin1 NOT NULL DEFAULT '',
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`title_id`),
  KEY `FK_title__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_title__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `title`
--

LOCK TABLES `title` WRITE;
/*!40000 ALTER TABLE `title` DISABLE KEYS */;
INSERT INTO `title` VALUES (1,'King','Queen',NULL,NULL),(2,'Prince','Princess',NULL,NULL),(3,'Duke','Duchess',NULL,NULL),(4,'Count','Countess',NULL,NULL),(5,'Viscount','Viscountess',NULL,NULL),(6,'Master','Mistress',NULL,NULL),(7,'Sir','Sir',NULL,NULL),(8,'Baron','Baroness',NULL,NULL),(9,'Lord','Lady',NULL,NULL);
/*!40000 ALTER TABLE `title` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `user_auth`
--

DROP TABLE IF EXISTS `user_auth`;
/*!50001 DROP VIEW IF EXISTS `user_auth`*/;
/*!50001 CREATE TABLE `user_auth` (
  `user_id` mediumint(8) unsigned,
  `atlantian_id` mediumint(8) unsigned,
  `username` varchar(50),
  `pass_word` varchar(50),
  `email` varchar(100),
  `first_name` varchar(50),
  `last_name` varchar(50),
  `sca_name` varchar(255),
  `account_request_date` date,
  `last_log` varchar(16),
  `client_ip` varchar(15),
  `chivalry` tinyint(4),
  `laurel` tinyint(4),
  `pelican` tinyint(4),
  `rose` tinyint(4),
  `whitescarf` tinyint(4),
  `pearl` tinyint(4),
  `dolphin` tinyint(4),
  `kraken` tinyint(4),
  `seastag` tinyint(4),
  `yewbow` tinyint(4),
  `chivalry_pend` tinyint(4),
  `laurel_pend` tinyint(4),
  `pelican_pend` tinyint(4),
  `rose_pend` tinyint(4),
  `whitescarf_pend` tinyint(4),
  `pearl_pend` tinyint(4),
  `dolphin_pend` tinyint(4),
  `kraken_pend` tinyint(4),
  `seastag_pend` tinyint(4),
  `yewbow_pend` tinyint(4),
  `chivalry_admin` tinyint(4),
  `laurel_admin` tinyint(4),
  `pelican_admin` tinyint(4),
  `rose_admin` tinyint(4),
  `whitescarf_admin` tinyint(4),
  `pearl_admin` tinyint(4),
  `dolphin_admin` tinyint(4),
  `kraken_admin` tinyint(4),
  `seastag_admin` tinyint(4),
  `yewbow_admin` tinyint(4),
  `seneschal_admin` tinyint(4),
  `youth_admin` tinyint(4),
  `exchequer_admin` tinyint(4),
  `herald_admin` tinyint(4),
  `marshal_admin` tinyint(4),
  `mol_admin` tinyint(4),
  `moas_admin` tinyint(4),
  `chronicler_admin` tinyint(4),
  `chirurgeon_admin` tinyint(4),
  `webminister_admin` tinyint(4),
  `chatelaine_admin` tinyint(4),
  `op_admin` tinyint(4),
  `backlog_admin` tinyint(4),
  `university_admin` tinyint(4),
  `award_admin` tinyint(4),
  `spike_admin` tinyint(4),
  `date_created` date,
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Current Database: `atlantia_branch`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `atlantia_branch` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `atlantia_branch`;

--
-- Temporary table structure for view `atlantian_barony`
--

DROP TABLE IF EXISTS `atlantian_barony`;
/*!50001 DROP VIEW IF EXISTS `atlantian_barony`*/;
/*!50001 CREATE TABLE `atlantian_barony` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `date_dissolved` date,
  `inactive` tinyint(4),
  `name_reg_date` date,
  `blazon` text,
  `device_reg_date` date,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `is_atlantian` tinyint(4),
  `notes` text,
  `regional_group_id` mediumint(8) unsigned,
  `group_id` int(11),
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Temporary table structure for view `atlantian_branch`
--

DROP TABLE IF EXISTS `atlantian_branch`;
/*!50001 DROP VIEW IF EXISTS `atlantian_branch`*/;
/*!50001 CREATE TABLE `atlantian_branch` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `date_dissolved` date,
  `inactive` tinyint(4),
  `name_reg_date` date,
  `device_reg_date` date,
  `blazon` text,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `notes` text,
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Table structure for table `branch`
--

DROP TABLE IF EXISTS `branch`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `branch` (
  `branch_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `branch` varchar(50) NOT NULL,
  `parent_branch_id` mediumint(8) unsigned DEFAULT NULL,
  `branch_type_id` mediumint(8) unsigned NOT NULL,
  `incipient` tinyint(4) NOT NULL DEFAULT '0',
  `ceremonial_date_founded` date DEFAULT NULL,
  `date_founded` date DEFAULT NULL,
  `date_dissolved` date DEFAULT NULL,
  `inactive` tinyint(4) NOT NULL DEFAULT '0',
  `name_reg_date` date DEFAULT NULL,
  `blazon` text,
  `device_reg_date` date DEFAULT NULL,
  `device_file_name` varchar(255) DEFAULT NULL,
  `device_file_credit` varchar(255) DEFAULT NULL,
  `website` varchar(100) DEFAULT NULL,
  `branch_area_description` text,
  `state_code` char(2) DEFAULT NULL,
  `display_order` mediumint(8) unsigned DEFAULT NULL,
  `is_atlantian` tinyint(4) NOT NULL DEFAULT '0',
  `notes` text,
  `regional_group_id` mediumint(8) unsigned DEFAULT NULL,
  `group_id` int(11) DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`branch_id`),
  KEY `FK_branch__parent` (`parent_branch_id`),
  KEY `FK_branch__branch_type` (`branch_type_id`),
  KEY `FK_branch__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_branch__branch_type` FOREIGN KEY (`branch_type_id`) REFERENCES `branch_type` (`branch_type_id`),
  CONSTRAINT `FK_branch__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_branch__parent` FOREIGN KEY (`parent_branch_id`) REFERENCES `branch` (`branch_id`)
) ENGINE=InnoDB AUTO_INCREMENT=149 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `branch`
--

LOCK TABLES `branch` WRITE;
/*!40000 ALTER TABLE `branch` DISABLE KEYS */;
INSERT INTO `branch` VALUES (1,'West',NULL,1,0,'1966-05-01','1966-05-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,100,0,NULL,1,NULL,NULL,NULL),(2,'East',NULL,1,0,'1968-06-01','1968-06-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,200,0,NULL,2,NULL,NULL,NULL),(3,'Middle',NULL,1,0,'1969-09-01','1969-09-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,300,0,NULL,3,NULL,NULL,NULL),(4,'Atenveldt',NULL,1,0,'1971-01-01','1971-01-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,400,0,NULL,4,NULL,NULL,NULL),(5,'Meridies',NULL,1,0,'1978-01-01','1978-01-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,500,0,NULL,5,NULL,NULL,NULL),(6,'Caid',NULL,1,0,'1978-06-01','1978-06-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,600,0,NULL,6,NULL,NULL,NULL),(7,'Ansteorra',NULL,1,0,'1979-06-01','1979-06-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,700,0,NULL,7,NULL,NULL,NULL),(8,'Atlantia',NULL,1,0,'1981-05-01','1976-12-01',NULL,0,'1981-04-01','Per pale argent and azure, on a fess wavy cotised counterchanged a crown vallery Or, overall a laurel wreath vert.','1981-07-01','atlantia.gif',NULL,NULL,'The District of Columbia, the states of Maryland, North Carolina, South Carolina, most of Virginia and a small portion of Georgia',NULL,1,1,NULL,8,NULL,NULL,NULL),(9,'An Tir',NULL,1,0,'1982-01-01','1982-01-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,800,0,NULL,9,NULL,NULL,NULL),(10,'Calontir',NULL,1,0,'1984-02-01','1984-02-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,900,0,NULL,10,NULL,NULL,NULL),(11,'Trimaris',NULL,1,0,'1985-09-01','1985-09-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1000,0,NULL,11,NULL,NULL,NULL),(12,'Ealdormere',NULL,1,0,'1986-06-01','1986-06-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1100,0,NULL,12,NULL,NULL,NULL),(13,'Outlands',NULL,1,0,'1986-06-01','1986-06-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1200,0,NULL,13,NULL,NULL,NULL),(14,'Drachenwald',NULL,1,0,'1993-06-01','1993-06-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1300,0,NULL,14,NULL,NULL,NULL),(15,'Artemisia',NULL,1,0,'1997-07-01','1997-07-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1400,0,NULL,15,NULL,NULL,NULL),(16,'Æthelmearc',NULL,1,0,'1997-09-01','1997-09-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1500,0,NULL,16,NULL,NULL,NULL),(17,'Lochac',NULL,1,0,'2002-07-01','2002-07-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1600,0,NULL,17,NULL,NULL,NULL),(18,'Northshield',NULL,1,0,'2004-10-01','2004-10-01',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1700,0,NULL,18,NULL,NULL,NULL),(19,'Gleann Abhann',NULL,1,0,'2005-11-05','2005-11-05',NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1800,0,NULL,112,NULL,NULL,NULL),(20,'Windmasters\' Hill',8,3,0,'1977-02-19','1977-01-01',NULL,0,'1979-08-01','Per chevron azure and vert, in chief two boreae addorsed and conjoined and in base a winged cat passant, forepaw extended, wings elevated and addorsed, all argent, within overall a laurel wreath Or.','1979-10-01','windmasters_hill.gif',NULL,'http://www.windmastershill.org','Almance, Caswell, Chatham, Cumberland, Durham, Franklin, Granville, Halifax, Harnett, Hoke, Johnston, Lee, Moore, Nash, Orange, Person, Robeson, Rockingham, Sampson, Scotland, Vance, Wake, Warren, Wayne and Wilson Counties','NC',2,1,NULL,19,1,NULL,NULL),(21,'Caer Mear',8,3,0,'1978-01-14','1977-01-01',NULL,0,'1997-10-01','Per fess gules and azure, in pale a triple-towered castle argent, portaled and lighted Or, and a bezant charged with a laurel wreath and surmounted by a sword proper.','1979-11-01','caer_mear.gif',NULL,'http://caermear.atlantia.sca.org','Cities of Colonial Heights, Hopewell, Petersburg, and Richmond & Albemarle, Amelia, Caroline, Charles City & Charlotte, Chesterfield, Dinwiddie, Fluvanna, Gloucester, Goochland, Hanover, Henrico, King and Queen, King William, Louisa, Mathews, Middlesex, New Kent, Powhatan, Prince George and Spotsylvania Counties','VA',3,1,NULL,20,2,NULL,NULL),(22,'Storvik',8,3,0,'1979-09-15','1979-09-15',NULL,0,'1980-01-01','Azure, on a pale wavy argent in chief a laurel wreath vert, overall a drakkar proper sailed argent, the sail charged with three pallets gules.','1980-01-01','storvik.gif',NULL,'http://storvik.atlantia.sca.org','District of Columbia, Prince Georges and Montgomery Counties','MD',4,1,NULL,21,3,NULL,NULL),(23,'Nottinghill Coill',8,3,0,'1980-01-12','1978-02-01',NULL,0,'1981-06-01','Or, a wake knot issuant by its base ends from a mount vert, overall a laurel wreath counterchanged.','1981-06-01','nottinghill_coill.gif',NULL,'http://www.nottinghillcoill.org','Abbeville, Aiken, Allendale, Bamberg, Barnwell, Calhoun, Chester, Clarendon, Colleton, Edgefield, Greenwood, Hampton, Jasper, Lancaster, McCormick, Newberry, Orangeburg, Saldua and York Counties','SC',5,1,NULL,22,4,NULL,NULL),(24,'Tir-y-Don',8,3,0,'1981-04-25','1981-04-25',NULL,0,'1982-04-01','Per bend sinister vert and azure, on a pile inverted throughout enarched issuant from dexter base argent a dolphin hauriant in base gules and in canton a laurel wreath Or.','1986-02-01','tir-y-don.gif',NULL,'http://www.tirydon.org','Cities of Hampton, Newport News and Poquoson & Gloucester, James City and York Counties','VA',6,1,NULL,23,5,NULL,NULL),(25,'Sacred Stone',8,3,0,'1982-09-06','1982-09-06',NULL,0,'1982-12-01','Vert, a double-headed phoenix and in chief a laurel wreath argent.','1982-12-01','sacred_stone.gif',NULL,'http://sacredstone.atlantia.sca.org','Polk, Rowan, Rutherford and Wilkes Counties','NC',7,1,NULL,24,6,NULL,NULL),(26,'Black Diamond',8,3,0,'1984-02-04','1984-02-04',NULL,0,'1986-01-01','Or, a lozenge within a laurel wreath sable.','1981-01-01','black_diamond.gif',NULL,'http://black-diamond.atlantia.sca.org','Cities of Bedford, Covington, Lexington and Lynchburg & Appomattox, Bedford, Campbell, Craig, Floyd, Giles, Montgomery, Pittsylvania, Pulaski, Radford, Roanoke, Rockbridge, Salem, Tazewll and Wise Counties','VA',8,1,NULL,25,7,NULL,NULL),(27,'Hidden Mountain',8,3,0,'1984-03-25','1984-03-25',NULL,0,'2006-06-01','Sable, a mountain erased voided between in chevron enhanced three clouds fesswise argent and in canton a laurel wreath Or.','1982-01-01','hidden_mountain.gif',NULL,'http://hiddenmountain.atlantia.sca.org','Beaufort, Colleton, Georgetown, Jasper, Orangeburg and Williamsburg Counties','SC',9,1,NULL,26,8,NULL,NULL),(28,'Marinus',8,3,0,'1987-09-26','1987-09-26',NULL,0,'1990-08-01','Argent chausse ploye per pale vert and azure, a trident sable its head environed of a laurel wreath vert.','2009-03-01','marinus.gif',NULL,'http://baronyofmarinus.org','Cities of Cheasapeake, Norfolk, Portsmouth, Suffolk and Virgina Beach and Isle of Wight Counties','VA',10,1,NULL,27,9,NULL,NULL),(29,'Lochmere',8,3,0,'1988-08-20','1988-08-01',NULL,0,'1989-05-01','Per fess engrailed argent and azure, a crab tergiant and a laurel wreath counterchanged.','1989-05-01','lochmere.gif',NULL,'http://lochmere.atlantia.sca.org','Anne Arundel and Howard Counties','MD',11,1,NULL,28,10,NULL,NULL),(30,'Ponte Alto',8,3,0,'1992-02-29','1992-02-29',NULL,0,'1992-11-01','Per pale sable and Or, in pale a single-arched bridge and a laurel wreath, counterchanged.','1991-05-01','ponte_alto.gif',NULL,'http://pontealto.atlantia.sca.org','Arlington and Fairfax Counties','VA',12,1,NULL,29,11,NULL,NULL),(31,'Dun Carraig',8,3,0,'1993-11-20','1993-11-20',NULL,0,'1994-12-01','Per chevron gules, crusilly bottony argent, and argent, in base a cross bottony within a laurel wreath gules.','1990-04-01','dun_carraig.gif',NULL,'http://www.duncarraig.net','Calvert, Charles and St. Mary\'s Counties','MD',13,1,NULL,30,12,NULL,NULL),(32,'Bright Hills',8,3,0,'1994-02-12','1987-05-01',NULL,0,'1989-07-01','Sable, a decrescent argent within a laurel wreath Or, a base indented of three points argent.','1989-07-01','bright_hills.gif',NULL,'http://brighthills.net','Baltimore, Carrol, Cecil and Harford Counties','MD',14,1,NULL,31,13,NULL,NULL),(33,'Stierbach',8,3,0,'1998-02-21','1998-02-21',NULL,0,'1999-10-01','Per fess embattled argent and gules, three bulls courant counterchanged, that in base within a laurel wreath argent.','1997-07-01','stierbach.gif',NULL,'http://stierbach.org','Clarke, Essex, Fairfax, Fauquier, Frederick, King George, Loudoun, Orange, Prince William, Rappahannock, Russell, Spotsylvania, Stafford, Warren and Westmoreland Counties','VA',15,1,NULL,32,14,NULL,NULL),(34,'Highland Foorde',8,3,0,'1999-06-12','1999-06-12',NULL,0,'1999-10-01','Gules, a compass star argent within a laurel wreath Or, a ford proper.','1993-01-01','highland_foorde.gif',NULL,'http://highland-foorde.atlantia.sca.org','Allegany, Frederick, Garrett and Washington Counties','MD',16,1,NULL,33,15,'2010-06-28',7),(35,'Hawkwood',8,3,0,'2004-06-19','2004-06-19',NULL,0,'2007-08-01','Counter-ermine, a vol Or within a laurel wreath vert.','1990-04-01','hawkwood.gif',NULL,'http://hawkwood.atlantia.sca.org','Buncombe, Cherokee, Clay, Graham, Haywood, Henderson, Jackson, Macon, Madison, Mcdowell, Polk, Rutherford, Swain, Transylvania and Yancey Counties','NC',17,1,NULL,34,16,NULL,NULL),(36,'Raven\'s Cove',8,3,0,'2010-09-18',NULL,NULL,0,'1990-04-01','Per saltire Or and sable, in cross three ravens close and a laurel wreath counterchanged.','1990-04-01','ravens_cove.gif','College of Scribes','http://ravenscove.atlantia.sca.org','Onslow County','NC',18,1,NULL,45,17,'2010-09-18',1),(37,'Roxbury Mill',8,4,0,NULL,NULL,NULL,0,'1995-03-01','Argent, two millrinds in cross within a laurel wreath vert.','1995-09-01',NULL,NULL,NULL,'Montgomery County','MD',30,1,NULL,35,23,NULL,NULL),(38,'Arindale',8,4,0,NULL,NULL,NULL,1,'1983-10-01','Per chevron sable and vert, a chevron and in base an eagle\'s head erased within a laurel wreath argent.','1984-01-01',NULL,NULL,NULL,NULL,NULL,90,1,NULL,128,NULL,NULL,NULL),(39,'Isenfir',8,4,0,NULL,NULL,NULL,0,'1979-08-01','Or, in pale, a sword inverted sable and a mountain couped of three peaks gules, all within a laurel wreath sable.','1990-07-01',NULL,NULL,NULL,'Cities of Charlotteville, Harrisonburg and Staunton & Albemarle, Greene, Madison, Nelson, Orange and Rockingham Counties','VA',39,1,NULL,44,22,NULL,NULL),(40,'Crannog Mor',8,4,0,NULL,NULL,'2008-01-26',1,'1990-04-01','Sable, two bears combattant and on a chief indented argent, three laurel wreaths gules.','1990-04-01',NULL,NULL,NULL,NULL,NULL,36,1,NULL,41,NULL,'2010-10-12',1),(41,'Cathanar',8,4,0,NULL,NULL,NULL,0,'1983-07-01','Vert, a sinister hawk\'s wing argent and in canton a laurel wreath Or.','1987-03-01',NULL,NULL,NULL,'Carteret and Craven Counties','NC',35,1,NULL,40,20,NULL,NULL),(42,'Berley Cort',8,4,0,NULL,NULL,NULL,0,'2006-02-01','Azure, a human head contourny, vested in a jester\'s hat within a laurel wreath, on a chief indented Or a natural whale naiant to sinister vert.','2006-02-01',NULL,NULL,NULL,'Cities of Suffold and Franklin & Greenville, Isle of Wight, Southhampton, Sussex and Surry Counties','VA',34,1,NULL,39,18,NULL,NULL),(43,'Border Vale Keep',8,4,0,NULL,'1986-04-01',NULL,0,'1985-04-01','Per bend sinister Or and gules, a tower sable, masoned Or, enflamed within a laurel wreath counterchanged.','1985-09-01',NULL,NULL,NULL,'City of Augusta','GA',33,1,NULL,38,19,NULL,NULL),(44,'Spiaggia Levantina',8,4,0,NULL,NULL,NULL,0,'1995-10-01','Purpure, a double headed eagle displayed argent, on a base barry wavy argent and sable a laurel wreath Or.','1996-10-01',NULL,NULL,NULL,'Eastern Shore of Maryland County','MD',32,1,NULL,37,25,NULL,NULL),(45,'Seareach',8,4,0,NULL,NULL,NULL,0,'1988-05-01','Azure, a sea lion naiant, maintaining a trident, within a laurel wreath and in chief three escallops, all Or.','1988-05-01',NULL,NULL,NULL,'Brunswick, Columbus, Duplin, New Hanover, Kure Beach, Onslow, Pender and Sampson Counties','NC',31,1,NULL,36,24,NULL,NULL),(46,'Drachentor',8,4,0,NULL,NULL,'2006-07-01',1,'1995-04-01','Or, a pall wavy azure between a laurel wreath and two dragon\'s heads couped respectant vert.','1994-02-01',NULL,NULL,NULL,NULL,NULL,91,1,NULL,132,NULL,NULL,NULL),(47,'Middlegate',25,6,0,NULL,NULL,NULL,0,'2009-04-01','Or, a portcullis and on a base gules a laurel wreath Or.','2009-04-01',NULL,NULL,'http://middlegate.atlantia.sca.org','Davidson, Guilford, Randolph, Rockingham and Stokes Counties','NC',37,1,NULL,42,35,NULL,NULL),(48,'Charlesbury Crossing',25,6,0,NULL,NULL,NULL,0,'2000-08-01','Sable, a horse statant argent within a laurel wreath Or.','2000-08-01',NULL,NULL,NULL,'Anson, Cabarrus, Mecklenburg, Stanly and Union Counties','NC',74,1,NULL,60,33,NULL,NULL),(49,'Crois Brigte',25,6,0,NULL,NULL,NULL,0,'2000-09-01','Per bend sinister argent and gules, a Saint Brigid\'s cross within a laurel wreath counterchanged.','2000-09-01',NULL,NULL,NULL,'Forsyth County','NC',75,1,NULL,61,34,NULL,NULL),(50,'Salesberie Glen',25,6,0,NULL,'2004-10-01',NULL,0,'2003-04-01','Gules platy, a laurel wreath Or.','2004-09-01',NULL,NULL,NULL,'Rowan County','NC',76,1,NULL,62,36,NULL,NULL),(51,'Attilium',20,6,0,NULL,NULL,NULL,0,'1982-12-01','Per fess embattled gules and argent, two crosses moline Or and a laurel wreath azure.','2002-09-01',NULL,NULL,NULL,'Bladen, Cumberland, Hoke, Robeson, Sampson and Scotland Counties','NC',77,1,NULL,63,26,NULL,NULL),(52,'Buckston-on-Eno',20,6,0,NULL,NULL,NULL,0,'1982-04-01','Per bend wavy vert and azure, a hart counterspringing argent, environed of a laurel wreath Or.','1979-08-01',NULL,NULL,NULL,'Durham and Granville Counties','NC',78,1,NULL,64,27,NULL,NULL),(53,'Elvegast',20,6,0,NULL,NULL,NULL,0,'1979-08-01','Per chevron azure and vert; in chief two aeoli with breaths conjoined at fess point argent; in base a laurel wreath Or.','1979-08-01',NULL,NULL,NULL,'Wake County','NC',79,1,NULL,65,28,NULL,NULL),(54,'Kapellenberg',20,6,0,NULL,NULL,NULL,0,'1981-06-01','Per chevron inverted argent and azure, a tower azure and a laurel wreath Or.','1982-10-01',NULL,NULL,NULL,'Durham and Orange Counties','NC',80,1,NULL,66,29,NULL,NULL),(55,'Nimenefeld',20,6,0,NULL,NULL,NULL,0,'2000-11-01','Gules, a garb within a laurel wreath and on a chief Or a demi-sun gules.','2006-03-01',NULL,NULL,NULL,'Harnett, Johnston and Wake Counties','NC',81,1,NULL,67,30,NULL,NULL),(56,'Abhainn Iarthair',33,6,0,NULL,'2010-01-23',NULL,0,'2005-07-01','Per fess wavy vert and argent, two stags trippant respectant and a laurel wreath counterchanged.','2005-12-01',NULL,NULL,NULL,'City of Winchester & Clarke, Frederick, Shenandoah and Warren Counties','VA',82,1,NULL,108,47,'2010-10-12',1),(57,'Iles des Diamants',23,6,0,NULL,'2008-07-12',NULL,0,'2006-02-01','Azure, a laurel wreath and two sea-lions combatant, one and two, on a chief wavy Or three escallops azure.','2006-12-01',NULL,NULL,NULL,'Beaufort County','SC',83,1,NULL,109,48,'2010-10-12',1),(58,'Baelfire Dunn',25,6,0,NULL,NULL,NULL,0,'1990-05-01','Per saltire vert and azure, a sun within a laurel wreath, all within a bordure Or.','1990-05-01',NULL,NULL,NULL,'Alexander, Burke, Caldwell, Catawba and Iredell Counties','NC',73,1,NULL,59,32,NULL,NULL),(59,'Aire Faucon',25,6,0,NULL,NULL,NULL,0,'1995-03-01','Gules, a falcon contourny sinister wing expanded and inverted perched on a falconer\'s glove reversed in chief three laurel wreaths Or.','1995-03-01',NULL,NULL,NULL,'Cleveland, Gaston, Lincoln and Rutherford Counties','NC',72,1,NULL,58,31,NULL,NULL),(60,'Caer Gelynniog',21,6,0,NULL,NULL,NULL,0,'2001-08-01','Purpure, on a tower argent a laurel wreath vert on a chief argent three apples vert.','2001-10-01',NULL,NULL,NULL,'City of Scottsville','VA',61,1,NULL,47,44,NULL,NULL),(61,'Sudentorre',33,6,0,NULL,'2005-01-01',NULL,0,'2004-03-01','Argent, a wooden door proper within and conjoined to an arch sable masoned argent, on a chief wavy azure a laurel wreath argent.','2005-03-01',NULL,NULL,NULL,'Caroline, Fredericksburg, King George, Spotsylvania and Stafford Counties','VA',63,1,NULL,49,46,NULL,NULL),(62,'Azurmont',26,6,0,NULL,NULL,'2010-01-23',1,'1992-11-01','Per chevron argent and azure, a laurel wreath counterchanged and in chief between its branches a mullet azure.','1994-01-01',NULL,NULL,NULL,'Botetourt and Roanoke Counties','VA',64,1,NULL,50,43,'2010-10-12',1),(63,'Rivers Point',21,6,0,NULL,'2004-07-01',NULL,0,'2001-08-01','Or, a pall wavy purpure in chief a tower sable overall a laurel wreath vert.','2001-08-01',NULL,NULL,NULL,'Cities of Colonial Heights, Fort Lee, Hopewell, and Richmond & Chesterfield, Dinwiddie and Petersburg Counties','VA',65,1,NULL,51,45,NULL,NULL),(64,'Cydllan Downs',23,6,0,NULL,NULL,NULL,0,'1982-07-01','Per pale indented argent and gules, a castle counterchanged within a laurel wreath counterchanged vert and argent.','1982-07-01',NULL,NULL,NULL,'Fairfield, Lexington and Richland Counties','SC',66,1,NULL,52,39,NULL,NULL),(65,'Falconcree',23,6,0,NULL,NULL,NULL,0,'1982-12-01','Per pale gules and Or, a falcon\'s head erased to sinister sable, beaked gules, within a laurel wreath, in chief a fillet counterchanged.','1982-12-01',NULL,NULL,NULL,'Cherokee, Greenville, Laurens, Spartanburg and Union Counties','SC',67,1,NULL,53,40,NULL,NULL),(66,'Ritterwald',23,6,0,NULL,NULL,NULL,0,'2001-04-01','Azure, a tilting lance bendwise sinister Or surmounted by a horse rampant argent, in canton a laurel wreath Or, a ford proper.','2001-04-01',NULL,NULL,NULL,'Aiken, Allendale, Barnwell and Edgefield Counties','SC',68,1,NULL,54,41,NULL,NULL),(67,'Saint Georges',23,6,0,NULL,NULL,NULL,0,'1999-02-01','Argent, a stag\'s head erased gules within a laurel wreath vert, in base three barrulets wavy azure.','2007-09-01',NULL,NULL,NULL,'Anderson, Oconee and Pickens Counties','SC',69,1,NULL,55,42,NULL,NULL),(68,'Misty Marsh by the Sea',27,6,0,NULL,NULL,NULL,0,'1990-12-01','Azure, on a pale argent a garb of cattails proper, overall a laurel wreath Or.','1993-07-01',NULL,NULL,NULL,'Clarendon, Dillon, Florence, Horry and Marion Counties','SC',70,1,NULL,56,37,NULL,NULL),(69,'Tear-Sea\'s Shore',27,6,0,NULL,NULL,NULL,0,'1980-10-01','Azure, a dexter flaunch Or and a sinister flaunch, in chief a wave erased argent, overall a laurel wreath vert.','1983-03-01',NULL,NULL,NULL,'Berkeley, Charleston, Colleton and Dorchester Counties','SC',71,1,NULL,57,38,NULL,NULL),(70,'Brockore Abbey',23,6,0,NULL,'2010-01-23',NULL,0,'2008-08-01','Purpure, on a bend sable fimbriated between two brocks rampant argent marked sable three laurel wreaths palewise argent.','2008-08-01',NULL,NULL,NULL,'Chesterfield, Darlington, Kershaw, Lee, Marlboro and Sumter Counties','SC',84,1,NULL,129,49,'2010-10-12',1),(71,'Rencester',24,7,0,NULL,NULL,NULL,0,'1991-12-01','Azure goutty d\'eau, a candle fesswise argent lit at both ends proper atop a candlestick, within a laurel wreath Or.','1992-12-01',NULL,NULL,NULL,'City of Williamsburg and James City','VA',60,1,NULL,46,51,NULL,NULL),(72,'Yarnvid',21,7,0,NULL,NULL,NULL,0,'1999-04-01','Argent, a harp reversed sable within a laurel wreath vert, on a chief sable three goblets argent.','1995-06-01',NULL,NULL,NULL,'City of Richmond','VA',62,1,NULL,48,50,NULL,NULL),(73,'Cynagua',1,2,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,101,0,NULL,68,NULL,NULL,NULL),(74,'Mists',1,2,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,102,0,NULL,69,NULL,NULL,NULL),(75,'Oertha',1,2,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,103,0,NULL,70,NULL,NULL,NULL),(76,'Sun',4,2,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,402,0,NULL,84,NULL,NULL,NULL),(77,'Far West',1,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,104,0,NULL,71,NULL,NULL,NULL),(78,'Carillion',2,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,206,0,NULL,119,NULL,NULL,NULL),(79,'Stonemarche',2,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,204,0,NULL,77,NULL,NULL,NULL),(80,'Myrkewoode',2,3,0,NULL,'1971-01-09',NULL,1,'1973-01-01','Ermine, a tree blasted and a chief wavy sable.','1973-01-01',NULL,NULL,NULL,NULL,NULL,205,0,NULL,111,NULL,NULL,NULL),(81,'Settmour Swamp',2,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,203,0,NULL,76,NULL,NULL,NULL),(82,'Carolingia',2,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,202,0,NULL,75,NULL,NULL,NULL),(83,'Beyond the Mountain',2,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,201,0,NULL,74,NULL,NULL,NULL),(84,'Flaming Gryphon',3,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,302,0,NULL,79,NULL,NULL,NULL),(85,'Middle Marches',3,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,303,0,NULL,80,NULL,NULL,NULL),(86,'Northwoods',3,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,304,0,NULL,81,NULL,NULL,NULL),(87,'Rivenstar',3,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,305,0,NULL,82,NULL,NULL,NULL),(88,'Shattered Crystal',3,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,306,0,NULL,120,NULL,NULL,NULL),(89,'Andelcrag',3,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,301,0,NULL,78,NULL,NULL,NULL),(90,'Tir Ysgithr',4,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,403,0,NULL,85,NULL,NULL,NULL),(91,'Mons Tonitrus',4,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,401,0,NULL,83,NULL,NULL,NULL),(92,'Atenveldt',4,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,'http://www.baronyofatenveldt.org/',NULL,NULL,404,0,NULL,126,NULL,NULL,NULL),(93,'Bryn Madoc',5,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,502,0,NULL,87,NULL,NULL,NULL),(94,'Axemoor',5,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,501,0,NULL,86,NULL,NULL,NULL),(95,'South Downs',5,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,505,0,NULL,90,NULL,NULL,NULL),(96,'Iron Mountain',5,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,506,0,NULL,123,NULL,NULL,NULL),(97,'Dreiburgen',6,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,602,0,NULL,116,NULL,NULL,NULL),(98,'Nordwache',6,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,603,0,NULL,117,NULL,NULL,NULL),(99,'Calafia',6,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,601,0,NULL,110,NULL,NULL,NULL),(100,'Starkhafn',6,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,606,0,NULL,131,NULL,NULL,NULL),(101,'Western Seas',6,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,'http://www.westernseas.org/',NULL,NULL,605,0,NULL,130,NULL,NULL,NULL),(102,'Altavia',6,3,0,NULL,'1983-05-14',NULL,0,NULL,NULL,NULL,NULL,NULL,'http://www.sca-altavia.org/',NULL,NULL,604,0,NULL,127,NULL,NULL,NULL),(103,'Stargate',7,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,702,0,NULL,114,NULL,NULL,NULL),(104,'Bordermarch',7,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,701,0,NULL,91,NULL,NULL,NULL),(105,'Aquaterra',9,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,803,0,NULL,113,NULL,NULL,NULL),(106,'Adiantum',9,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,801,0,NULL,92,NULL,NULL,NULL),(107,'Blatha An Oir',9,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,802,0,NULL,93,NULL,NULL,NULL),(108,'Forgotten Sea',10,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,901,0,NULL,94,NULL,NULL,NULL),(109,'An Crosaire',11,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1001,0,NULL,95,NULL,NULL,NULL),(110,'Wyvernwoode',11,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1003,0,NULL,97,NULL,NULL,NULL),(111,'Darkwater',11,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1002,0,NULL,96,NULL,NULL,NULL),(112,'Septentria',12,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1102,0,NULL,99,NULL,NULL,NULL),(113,'Ramshaven',12,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1101,0,NULL,98,NULL,NULL,NULL),(114,'Dragonsspine',13,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1203,0,NULL,102,NULL,NULL,NULL),(115,'Caerthe',13,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1201,0,NULL,100,NULL,NULL,NULL),(116,'al-Barran',13,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,'http://www.al-barran.org/',NULL,NULL,1204,0,NULL,121,NULL,NULL,NULL),(117,'Citadel of the Southern Pass',13,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1202,0,NULL,101,NULL,NULL,NULL),(118,'Knight\'s Crossing',14,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1301,0,NULL,103,NULL,NULL,NULL),(119,'Arn Hold',15,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1402,0,NULL,125,NULL,NULL,NULL),(120,'Loch Salann',15,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1401,0,NULL,104,NULL,NULL,NULL),(121,'Delftwood',16,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1504,0,NULL,118,NULL,NULL,NULL),(122,'Debatable Lands',16,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1503,0,NULL,115,NULL,NULL,NULL),(123,'Rhydderich Hael',16,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1501,0,NULL,105,NULL,NULL,NULL),(124,'Thescorre',16,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1502,0,NULL,106,NULL,NULL,NULL),(125,'Nordskogen',18,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1701,0,NULL,107,NULL,NULL,NULL),(126,'Caer Adamant',2,4,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,208,0,NULL,124,NULL,NULL,NULL),(127,'Mountain Freehold',2,4,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,207,0,NULL,122,NULL,NULL,NULL),(128,'Hammerhold',5,4,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,504,0,NULL,89,NULL,NULL,NULL),(129,'Glaedenfeld',5,4,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,503,0,NULL,88,NULL,NULL,NULL),(130,'Nant y Derwyddon',5,4,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,507,0,NULL,133,NULL,NULL,NULL),(131,'Sylvan Glen',16,4,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,1505,0,NULL,134,NULL,NULL,NULL),(132,'Vinhold',74,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,120,0,NULL,72,NULL,NULL,NULL),(133,'Winter\'s Gate',75,3,0,NULL,NULL,NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,130,0,NULL,73,NULL,NULL,NULL),(134,'Dinas Moryn',8,4,0,NULL,NULL,'1992-03-01',1,'1979-08-01','Per bend sinister vert and azure, a pile inverted throughout enarched issuant from dexter base and in canton a laurel wreath Or.','1979-08-01',NULL,NULL,NULL,NULL,NULL,99,1,NULL,NULL,NULL,'2010-04-12',1),(135,'Caer Cladach',8,4,0,NULL,'1976-10-01','1979-08-01',1,NULL,NULL,NULL,NULL,NULL,NULL,'Rockville, MD',NULL,88,1,NULL,NULL,NULL,'2010-04-12',1),(136,'Seagate',8,4,0,NULL,NULL,'1992-03-01',1,'1979-08-01','Per fess invected argent and azure, a portcullis sable fimbriated in base argent, in chief a laurel wreath vert.','1979-08-01',NULL,NULL,NULL,NULL,NULL,92,1,NULL,NULL,NULL,'2010-04-12',1),(137,'Curragh Mor',8,4,0,NULL,NULL,'1992-03-01',1,'1982-10-01','Per fess azure and vert, on a pile fesswise reversed throughout argent a mastless drakkar reversed, oars in action, proper, and in canton a laurel wreath Or.','1982-10-01',NULL,NULL,NULL,'USS Nimitz',NULL,93,1,NULL,NULL,NULL,'2010-04-12',1),(138,'Oak Clyffe',8,7,0,NULL,NULL,'1992-03-01',1,'1983-08-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,96,1,NULL,NULL,NULL,'2010-04-12',1),(139,'Hindscroft',25,6,0,NULL,NULL,'2009-03-01',1,'1980-12-01','Azure, eight keys in cross parted, addorsed in pairs, all conjoined at the base by links of chain, and the whole environed of a laurel wreath, all Or.','1980-12-01',NULL,NULL,NULL,NULL,NULL,85,1,NULL,NULL,NULL,'2010-04-12',1),(140,'St. Michael\'s Keep',23,6,0,NULL,NULL,'1992-03-01',1,'1983-03-01','Per pale vert and argent, a tower, a laurel wreath, and on a base wavy two bars wavy counterchanged.','1983-03-01',NULL,NULL,NULL,NULL,NULL,89,1,NULL,NULL,NULL,'2010-04-12',1),(141,'Caer Draigwyrdd',8,6,0,NULL,NULL,'1992-03-01',1,'1984-02-01',NULL,NULL,NULL,NULL,NULL,'Davidson College, Davidson, NC',NULL,94,1,NULL,NULL,NULL,'2010-04-12',1),(142,'Fnaedhom',8,6,0,NULL,NULL,'1992-03-01',1,'1980-12-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,95,1,NULL,NULL,NULL,'2010-04-12',1),(143,'Howling Wolf\'s Keep',8,4,0,NULL,NULL,'1992-03-01',1,'1988-08-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,97,1,NULL,NULL,NULL,'2010-04-12',1),(144,'Kestrel\'s Keep',24,6,0,NULL,NULL,'1987-05-01',1,'1982-12-01','Per bend argent and sable, a bend counter-compony gules and Or between a kestrel rising wings displayed proper, belled, and a laurel wreath Or surmounted by a tower argent.','1982-12-01',NULL,NULL,NULL,'Shaw AFB, Columbia, SC',NULL,98,1,NULL,NULL,NULL,'2010-04-12',1),(145,'Stormgate',8,4,0,NULL,NULL,'1992-03-01',1,'1982-01-01','Azure, a gateway between two towers, in chief two lightning bolts in saltire, all within a laurel wreath Or.','1982-01-01',NULL,NULL,NULL,NULL,NULL,86,1,NULL,NULL,NULL,'2010-04-12',1),(146,'Torhvassir',8,4,0,NULL,NULL,'1992-03-01',1,NULL,'Or, a chevron wavy azure between, in chief, a water wheel proper between two towers gules and in base a laurel wreath proper.',NULL,NULL,NULL,NULL,NULL,NULL,41,1,NULL,NULL,NULL,'2010-04-12',1),(147,'Wandering Lands',8,6,0,NULL,NULL,'1992-03-01',1,'1982-05-01',NULL,NULL,NULL,NULL,NULL,NULL,NULL,87,1,NULL,NULL,NULL,'2010-04-12',1),(148,'Angels',6,3,0,NULL,NULL,NULL,0,'1970-10-18','Gules, a standing seraph affronty proper, winged Or, haloed of a laurel wreath proper.','1977-11-01',NULL,NULL,'http://www.sca-angels.org/',NULL,NULL,607,0,'Current device registration may be February 1975 or earlier. Need to cross-check drawings in the Laurel files.',NULL,NULL,'2010-10-10',128);
/*!40000 ALTER TABLE `branch` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `branch_neighbor`
--

DROP TABLE IF EXISTS `branch_neighbor`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `branch_neighbor` (
  `branch_neighbor_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `branch1_id` mediumint(8) unsigned NOT NULL,
  `branch2_id` mediumint(8) unsigned NOT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`branch_neighbor_id`),
  KEY `FK_branch_neighbor__branch1` (`branch1_id`),
  KEY `FK_branch_neighbor__branch2` (`branch2_id`),
  KEY `FK_branch_neighbor__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_branch_neighbor__branch1` FOREIGN KEY (`branch1_id`) REFERENCES `branch` (`branch_id`),
  CONSTRAINT `FK_branch_neighbor__branch2` FOREIGN KEY (`branch2_id`) REFERENCES `branch` (`branch_id`),
  CONSTRAINT `FK_branch_neighbor__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=168 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `branch_type`
--

DROP TABLE IF EXISTS `branch_type`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `branch_type` (
  `branch_type_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `branch_type` varchar(50) NOT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`branch_type_id`),
  KEY `FK_branch_type__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_branch_type__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `branch_type`
--

LOCK TABLES `branch_type` WRITE;
/*!40000 ALTER TABLE `branch_type` DISABLE KEYS */;
INSERT INTO `branch_type` VALUES (1,'Kingdom',NULL,NULL),(2,'Principality',NULL,NULL),(3,'Barony',NULL,NULL),(4,'Shire',NULL,NULL),(5,'Stronghold',NULL,NULL),(6,'Canton',NULL,NULL),(7,'College',NULL,NULL);
/*!40000 ALTER TABLE `branch_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Temporary table structure for view `current_atlantian_barony`
--

DROP TABLE IF EXISTS `current_atlantian_barony`;
/*!50001 DROP VIEW IF EXISTS `current_atlantian_barony`*/;
/*!50001 CREATE TABLE `current_atlantian_barony` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `date_dissolved` date,
  `inactive` tinyint(4),
  `name_reg_date` date,
  `blazon` text,
  `device_reg_date` date,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `is_atlantian` tinyint(4),
  `notes` text,
  `regional_group_id` mediumint(8) unsigned,
  `group_id` int(11),
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Temporary table structure for view `current_atlantian_branch`
--

DROP TABLE IF EXISTS `current_atlantian_branch`;
/*!50001 DROP VIEW IF EXISTS `current_atlantian_branch`*/;
/*!50001 CREATE TABLE `current_atlantian_branch` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `name_reg_date` date,
  `device_reg_date` date,
  `blazon` text,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `notes` text,
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Temporary table structure for view `current_atlantian_branch_plus_kingdom`
--

DROP TABLE IF EXISTS `current_atlantian_branch_plus_kingdom`;
/*!50001 DROP VIEW IF EXISTS `current_atlantian_branch_plus_kingdom`*/;
/*!50001 CREATE TABLE `current_atlantian_branch_plus_kingdom` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `is_atlantian` tinyint(4),
  `name_reg_date` date,
  `device_reg_date` date,
  `blazon` text,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `notes` text,
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Temporary table structure for view `current_branch`
--

DROP TABLE IF EXISTS `current_branch`;
/*!50001 DROP VIEW IF EXISTS `current_branch`*/;
/*!50001 CREATE TABLE `current_branch` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `is_atlantian` tinyint(4),
  `name_reg_date` date,
  `device_reg_date` date,
  `blazon` text,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `notes` text,
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Temporary table structure for view `kingdom`
--

DROP TABLE IF EXISTS `kingdom`;
/*!50001 DROP VIEW IF EXISTS `kingdom`*/;
/*!50001 CREATE TABLE `kingdom` (
  `branch_id` mediumint(8) unsigned,
  `branch` varchar(50),
  `parent_branch_id` mediumint(8) unsigned,
  `branch_type_id` mediumint(8) unsigned,
  `incipient` tinyint(4),
  `ceremonial_date_founded` date,
  `date_founded` date,
  `date_dissolved` date,
  `inactive` tinyint(4),
  `name_reg_date` date,
  `blazon` text,
  `device_reg_date` date,
  `device_file_name` varchar(255),
  `device_file_credit` varchar(255),
  `website` varchar(100),
  `branch_area_description` text,
  `state_code` char(2),
  `display_order` mediumint(8) unsigned,
  `is_atlantian` tinyint(4),
  `notes` text,
  `regional_group_id` mediumint(8) unsigned,
  `group_id` int(11),
  `last_updated` date,
  `last_updated_by` mediumint(8) unsigned
) */;

--
-- Current Database: `atlantia_auth`
--

USE `atlantia_auth`;

--
-- Final view structure for view `public_atlantian`
--

/*!50001 DROP TABLE `public_atlantian`*/;
/*!50001 DROP VIEW IF EXISTS `public_atlantian`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `public_atlantian` AS select `atlantian`.`atlantian_id` AS `atlantian_id`,if(`atlantian`.`publish_name`,`atlantian`.`first_name`,NULL) AS `first_name`,if(`atlantian`.`publish_name`,`atlantian`.`middle_name`,NULL) AS `middle_name`,if(`atlantian`.`publish_name`,`atlantian`.`last_name`,NULL) AS `last_name`,if(`atlantian`.`publish_address`,`atlantian`.`address1`,NULL) AS `address1`,if(`atlantian`.`publish_address`,`atlantian`.`address2`,NULL) AS `address2`,if(`atlantian`.`publish_address`,`atlantian`.`city`,NULL) AS `city`,if(`atlantian`.`publish_address`,`atlantian`.`state`,NULL) AS `state`,if(`atlantian`.`publish_address`,`atlantian`.`zip`,NULL) AS `zip`,if(`atlantian`.`publish_address`,`atlantian`.`country`,NULL) AS `country`,if(`atlantian`.`publish_email`,`atlantian`.`email`,NULL) AS `email`,if(`atlantian`.`publish_alternate_email`,`atlantian`.`alternate_email`,NULL) AS `alternate_email`,if(`atlantian`.`publish_phone_home`,`atlantian`.`phone_home`,NULL) AS `phone_home`,if(`atlantian`.`publish_phone_mobile`,`atlantian`.`phone_mobile`,NULL) AS `phone_mobile`,if(`atlantian`.`publish_phone_work`,`atlantian`.`phone_work`,NULL) AS `phone_work`,if((`atlantian`.`publish_phone_home` or `atlantian`.`publish_phone_mobile` or `atlantian`.`publish_phone_work`),`atlantian`.`call_times`,NULL) AS `call_times`,`atlantian`.`gender` AS `gender`,`atlantian`.`deceased` AS `deceased`,`atlantian`.`deceased_date` AS `deceased_date`,`atlantian`.`inactive` AS `inactive`,`atlantian`.`website` AS `website`,`atlantian`.`biography` AS `biography`,`atlantian`.`sca_name` AS `sca_name`,`atlantian`.`preferred_sca_name` AS `preferred_sca_name`,`atlantian`.`name_reg_date` AS `name_reg_date`,`atlantian`.`alternate_names` AS `alternate_names`,`atlantian`.`blazon` AS `blazon`,`atlantian`.`device_reg_date` AS `device_reg_date`,`atlantian`.`device_file_name` AS `device_file_name`,`atlantian`.`device_file_credit` AS `device_file_credit`,`atlantian`.`membership_number` AS `membership_number`,`atlantian`.`expiration_date` AS `expiration_date`,`atlantian`.`revoked` AS `revoked`,`atlantian`.`revoked_date` AS `revoked_date`,`atlantian`.`branch_id` AS `branch_id`,`atlantian`.`picture_file_name` AS `picture_file_name`,`atlantian`.`picture_file_credit` AS `picture_file_credit`,`atlantian`.`heraldic_rank_id` AS `heraldic_rank_id`,`atlantian`.`heraldic_title` AS `heraldic_title`,`atlantian`.`heraldic_interests` AS `heraldic_interests` from `atlantian` */;

--
-- Current Database: `atlantia_op`
--

USE `atlantia_op`;

--
-- Final view structure for view `atlantian`
--

/*!50001 DROP TABLE `atlantian`*/;
/*!50001 DROP VIEW IF EXISTS `atlantian`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `atlantian` AS select `atlantia_auth`.`atlantian`.`atlantian_id` AS `atlantian_id`,`atlantia_auth`.`atlantian`.`first_name` AS `first_name`,`atlantia_auth`.`atlantian`.`middle_name` AS `middle_name`,`atlantia_auth`.`atlantian`.`last_name` AS `last_name`,`atlantia_auth`.`atlantian`.`address1` AS `address1`,`atlantia_auth`.`atlantian`.`address2` AS `address2`,`atlantia_auth`.`atlantian`.`city` AS `city`,`atlantia_auth`.`atlantian`.`state` AS `state`,`atlantia_auth`.`atlantian`.`zip` AS `zip`,`atlantia_auth`.`atlantian`.`country` AS `country`,`atlantia_auth`.`atlantian`.`email` AS `email`,`atlantia_auth`.`atlantian`.`alternate_email` AS `alternate_email`,`atlantia_auth`.`atlantian`.`phone_home` AS `phone_home`,`atlantia_auth`.`atlantian`.`phone_mobile` AS `phone_mobile`,`atlantia_auth`.`atlantian`.`phone_work` AS `phone_work`,`atlantia_auth`.`atlantian`.`call_times` AS `call_times`,`atlantia_auth`.`atlantian`.`gender` AS `gender`,`atlantia_auth`.`atlantian`.`deceased` AS `deceased`,`atlantia_auth`.`atlantian`.`deceased_date` AS `deceased_date`,`atlantia_auth`.`atlantian`.`inactive` AS `inactive`,`atlantia_auth`.`atlantian`.`website` AS `website`,`atlantia_auth`.`atlantian`.`biography` AS `biography`,`atlantia_auth`.`atlantian`.`op_notes` AS `op_notes`,`atlantia_auth`.`atlantian`.`sca_name` AS `sca_name`,`atlantia_auth`.`atlantian`.`preferred_sca_name` AS `preferred_sca_name`,`atlantia_auth`.`atlantian`.`name_reg_date` AS `name_reg_date`,`atlantia_auth`.`atlantian`.`alternate_names` AS `alternate_names`,`atlantia_auth`.`atlantian`.`blazon` AS `blazon`,`atlantia_auth`.`atlantian`.`device_reg_date` AS `device_reg_date`,`atlantia_auth`.`atlantian`.`device_file_name` AS `device_file_name`,`atlantia_auth`.`atlantian`.`device_file_credit` AS `device_file_credit`,`atlantia_auth`.`atlantian`.`membership_number` AS `membership_number`,`atlantia_auth`.`atlantian`.`expiration_date` AS `expiration_date`,`atlantia_auth`.`atlantian`.`expiration_date_pending` AS `expiration_date_pending`,`atlantia_auth`.`atlantian`.`revoked` AS `revoked`,`atlantia_auth`.`atlantian`.`revoked_date` AS `revoked_date`,`atlantia_auth`.`atlantian`.`branch_id` AS `branch_id`,`atlantia_auth`.`atlantian`.`picture_file_name` AS `picture_file_name`,`atlantia_auth`.`atlantian`.`picture_file_credit` AS `picture_file_credit`,`atlantia_auth`.`atlantian`.`publish_name` AS `publish_name`,`atlantia_auth`.`atlantian`.`publish_address` AS `publish_address`,`atlantia_auth`.`atlantian`.`publish_email` AS `publish_email`,`atlantia_auth`.`atlantian`.`publish_alternate_email` AS `publish_alternate_email`,`atlantia_auth`.`atlantian`.`publish_phone_home` AS `publish_phone_home`,`atlantia_auth`.`atlantian`.`publish_phone_mobile` AS `publish_phone_mobile`,`atlantia_auth`.`atlantian`.`publish_phone_work` AS `publish_phone_work`,`atlantia_auth`.`atlantian`.`background_check_date` AS `background_check_date`,`atlantia_auth`.`atlantian`.`background_check_result` AS `background_check_result`,`atlantia_auth`.`atlantian`.`heraldic_rank_id` AS `heraldic_rank_id`,`atlantia_auth`.`atlantian`.`heraldic_title` AS `heraldic_title`,`atlantia_auth`.`atlantian`.`heraldic_interests` AS `heraldic_interests`,`atlantia_auth`.`atlantian`.`date_created` AS `date_created`,`atlantia_auth`.`atlantian`.`last_updated` AS `last_updated`,`atlantia_auth`.`atlantian`.`last_updated_by` AS `last_updated_by` from `atlantia_auth`.`atlantian` */;

--
-- Final view structure for view `branch`
--

/*!50001 DROP TABLE `branch`*/;
/*!50001 DROP VIEW IF EXISTS `branch`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `branch` AS select `atlantia_branch`.`branch`.`branch_id` AS `branch_id`,`atlantia_branch`.`branch`.`branch` AS `branch`,`atlantia_branch`.`branch`.`parent_branch_id` AS `parent_branch_id`,`atlantia_branch`.`branch`.`branch_type_id` AS `branch_type_id`,`atlantia_branch`.`branch`.`incipient` AS `incipient`,`atlantia_branch`.`branch`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`atlantia_branch`.`branch`.`date_founded` AS `date_founded`,`atlantia_branch`.`branch`.`date_dissolved` AS `date_dissolved`,`atlantia_branch`.`branch`.`inactive` AS `inactive`,`atlantia_branch`.`branch`.`name_reg_date` AS `name_reg_date`,`atlantia_branch`.`branch`.`blazon` AS `blazon`,`atlantia_branch`.`branch`.`device_reg_date` AS `device_reg_date`,`atlantia_branch`.`branch`.`device_file_name` AS `device_file_name`,`atlantia_branch`.`branch`.`device_file_credit` AS `device_file_credit`,`atlantia_branch`.`branch`.`website` AS `website`,`atlantia_branch`.`branch`.`branch_area_description` AS `branch_area_description`,`atlantia_branch`.`branch`.`state_code` AS `state_code`,`atlantia_branch`.`branch`.`display_order` AS `display_order`,`atlantia_branch`.`branch`.`is_atlantian` AS `is_atlantian`,`atlantia_branch`.`branch`.`notes` AS `notes`,`atlantia_branch`.`branch`.`regional_group_id` AS `regional_group_id`,`atlantia_branch`.`branch`.`group_id` AS `group_id`,`atlantia_branch`.`branch`.`last_updated` AS `last_updated`,`atlantia_branch`.`branch`.`last_updated_by` AS `last_updated_by` from `atlantia_branch`.`branch` */;

--
-- Final view structure for view `branch_type`
--

/*!50001 DROP TABLE `branch_type`*/;
/*!50001 DROP VIEW IF EXISTS `branch_type`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `branch_type` AS select `atlantia_branch`.`branch_type`.`branch_type_id` AS `branch_type_id`,`atlantia_branch`.`branch_type`.`branch_type` AS `branch_type`,`atlantia_branch`.`branch_type`.`last_updated` AS `last_updated`,`atlantia_branch`.`branch_type`.`last_updated_by` AS `last_updated_by` from `atlantia_branch`.`branch_type` */;

--
-- Final view structure for view `user_auth`
--

/*!50001 DROP TABLE `user_auth`*/;
/*!50001 DROP VIEW IF EXISTS `user_auth`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `user_auth` AS select `atlantia_auth`.`user_auth`.`user_id` AS `user_id`,`atlantia_auth`.`user_auth`.`atlantian_id` AS `atlantian_id`,`atlantia_auth`.`user_auth`.`username` AS `username`,`atlantia_auth`.`user_auth`.`pass_word` AS `pass_word`,`atlantia_auth`.`user_auth`.`email` AS `email`,`atlantia_auth`.`user_auth`.`first_name` AS `first_name`,`atlantia_auth`.`user_auth`.`last_name` AS `last_name`,`atlantia_auth`.`user_auth`.`sca_name` AS `sca_name`,`atlantia_auth`.`user_auth`.`account_request_date` AS `account_request_date`,`atlantia_auth`.`user_auth`.`last_log` AS `last_log`,`atlantia_auth`.`user_auth`.`client_ip` AS `client_ip`,`atlantia_auth`.`user_auth`.`chivalry` AS `chivalry`,`atlantia_auth`.`user_auth`.`laurel` AS `laurel`,`atlantia_auth`.`user_auth`.`pelican` AS `pelican`,`atlantia_auth`.`user_auth`.`rose` AS `rose`,`atlantia_auth`.`user_auth`.`whitescarf` AS `whitescarf`,`atlantia_auth`.`user_auth`.`pearl` AS `pearl`,`atlantia_auth`.`user_auth`.`dolphin` AS `dolphin`,`atlantia_auth`.`user_auth`.`kraken` AS `kraken`,`atlantia_auth`.`user_auth`.`seastag` AS `seastag`,`atlantia_auth`.`user_auth`.`yewbow` AS `yewbow`,`atlantia_auth`.`user_auth`.`chivalry_pend` AS `chivalry_pend`,`atlantia_auth`.`user_auth`.`laurel_pend` AS `laurel_pend`,`atlantia_auth`.`user_auth`.`pelican_pend` AS `pelican_pend`,`atlantia_auth`.`user_auth`.`rose_pend` AS `rose_pend`,`atlantia_auth`.`user_auth`.`whitescarf_pend` AS `whitescarf_pend`,`atlantia_auth`.`user_auth`.`pearl_pend` AS `pearl_pend`,`atlantia_auth`.`user_auth`.`dolphin_pend` AS `dolphin_pend`,`atlantia_auth`.`user_auth`.`kraken_pend` AS `kraken_pend`,`atlantia_auth`.`user_auth`.`seastag_pend` AS `seastag_pend`,`atlantia_auth`.`user_auth`.`yewbow_pend` AS `yewbow_pend`,`atlantia_auth`.`user_auth`.`chivalry_admin` AS `chivalry_admin`,`atlantia_auth`.`user_auth`.`laurel_admin` AS `laurel_admin`,`atlantia_auth`.`user_auth`.`pelican_admin` AS `pelican_admin`,`atlantia_auth`.`user_auth`.`rose_admin` AS `rose_admin`,`atlantia_auth`.`user_auth`.`whitescarf_admin` AS `whitescarf_admin`,`atlantia_auth`.`user_auth`.`pearl_admin` AS `pearl_admin`,`atlantia_auth`.`user_auth`.`dolphin_admin` AS `dolphin_admin`,`atlantia_auth`.`user_auth`.`kraken_admin` AS `kraken_admin`,`atlantia_auth`.`user_auth`.`seastag_admin` AS `seastag_admin`,`atlantia_auth`.`user_auth`.`yewbow_admin` AS `yewbow_admin`,`atlantia_auth`.`user_auth`.`seneschal_admin` AS `seneschal_admin`,`atlantia_auth`.`user_auth`.`youth_admin` AS `youth_admin`,`atlantia_auth`.`user_auth`.`exchequer_admin` AS `exchequer_admin`,`atlantia_auth`.`user_auth`.`herald_admin` AS `herald_admin`,`atlantia_auth`.`user_auth`.`marshal_admin` AS `marshal_admin`,`atlantia_auth`.`user_auth`.`mol_admin` AS `mol_admin`,`atlantia_auth`.`user_auth`.`moas_admin` AS `moas_admin`,`atlantia_auth`.`user_auth`.`chronicler_admin` AS `chronicler_admin`,`atlantia_auth`.`user_auth`.`chirurgeon_admin` AS `chirurgeon_admin`,`atlantia_auth`.`user_auth`.`webminister_admin` AS `webminister_admin`,`atlantia_auth`.`user_auth`.`chatelaine_admin` AS `chatelaine_admin`,`atlantia_auth`.`user_auth`.`op_admin` AS `op_admin`,`atlantia_auth`.`user_auth`.`backlog_admin` AS `backlog_admin`,`atlantia_auth`.`user_auth`.`university_admin` AS `university_admin`,`atlantia_auth`.`user_auth`.`award_admin` AS `award_admin`,`atlantia_auth`.`user_auth`.`spike_admin` AS `spike_admin`,`atlantia_auth`.`user_auth`.`date_created` AS `date_created`,`atlantia_auth`.`user_auth`.`last_updated` AS `last_updated`,`atlantia_auth`.`user_auth`.`last_updated_by` AS `last_updated_by` from `atlantia_auth`.`user_auth` */;

--
-- Current Database: `atlantia_branch`
--

USE `atlantia_branch`;

--
-- Final view structure for view `atlantian_barony`
--

/*!50001 DROP TABLE `atlantian_barony`*/;
/*!50001 DROP VIEW IF EXISTS `atlantian_barony`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `atlantian_barony` AS select `branch`.`branch_id` AS `branch_id`,`branch`.`branch` AS `branch`,`branch`.`parent_branch_id` AS `parent_branch_id`,`branch`.`branch_type_id` AS `branch_type_id`,`branch`.`incipient` AS `incipient`,`branch`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`branch`.`date_founded` AS `date_founded`,`branch`.`date_dissolved` AS `date_dissolved`,`branch`.`inactive` AS `inactive`,`branch`.`name_reg_date` AS `name_reg_date`,`branch`.`blazon` AS `blazon`,`branch`.`device_reg_date` AS `device_reg_date`,`branch`.`device_file_name` AS `device_file_name`,`branch`.`device_file_credit` AS `device_file_credit`,`branch`.`website` AS `website`,`branch`.`branch_area_description` AS `branch_area_description`,`branch`.`state_code` AS `state_code`,`branch`.`display_order` AS `display_order`,`branch`.`is_atlantian` AS `is_atlantian`,`branch`.`notes` AS `notes`,`branch`.`regional_group_id` AS `regional_group_id`,`branch`.`group_id` AS `group_id`,`branch`.`last_updated` AS `last_updated`,`branch`.`last_updated_by` AS `last_updated_by` from `branch` where ((`branch`.`is_atlantian` = 1) and (`branch`.`branch_type_id` = 3)) */;

--
-- Final view structure for view `atlantian_branch`
--

/*!50001 DROP TABLE `atlantian_branch`*/;
/*!50001 DROP VIEW IF EXISTS `atlantian_branch`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `atlantian_branch` AS select `branch`.`branch_id` AS `branch_id`,`branch`.`branch` AS `branch`,`branch`.`parent_branch_id` AS `parent_branch_id`,`branch`.`branch_type_id` AS `branch_type_id`,`branch`.`incipient` AS `incipient`,`branch`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`branch`.`date_founded` AS `date_founded`,`branch`.`date_dissolved` AS `date_dissolved`,`branch`.`inactive` AS `inactive`,`branch`.`name_reg_date` AS `name_reg_date`,`branch`.`device_reg_date` AS `device_reg_date`,`branch`.`blazon` AS `blazon`,`branch`.`device_file_name` AS `device_file_name`,`branch`.`device_file_credit` AS `device_file_credit`,`branch`.`website` AS `website`,`branch`.`branch_area_description` AS `branch_area_description`,`branch`.`state_code` AS `state_code`,`branch`.`display_order` AS `display_order`,`branch`.`notes` AS `notes`,`branch`.`last_updated` AS `last_updated`,`branch`.`last_updated_by` AS `last_updated_by` from `branch` where (`branch`.`is_atlantian` = 1) */;

--
-- Final view structure for view `current_atlantian_barony`
--

/*!50001 DROP TABLE `current_atlantian_barony`*/;
/*!50001 DROP VIEW IF EXISTS `current_atlantian_barony`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `current_atlantian_barony` AS select `atlantian_barony`.`branch_id` AS `branch_id`,`atlantian_barony`.`branch` AS `branch`,`atlantian_barony`.`parent_branch_id` AS `parent_branch_id`,`atlantian_barony`.`branch_type_id` AS `branch_type_id`,`atlantian_barony`.`incipient` AS `incipient`,`atlantian_barony`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`atlantian_barony`.`date_founded` AS `date_founded`,`atlantian_barony`.`date_dissolved` AS `date_dissolved`,`atlantian_barony`.`inactive` AS `inactive`,`atlantian_barony`.`name_reg_date` AS `name_reg_date`,`atlantian_barony`.`blazon` AS `blazon`,`atlantian_barony`.`device_reg_date` AS `device_reg_date`,`atlantian_barony`.`device_file_name` AS `device_file_name`,`atlantian_barony`.`device_file_credit` AS `device_file_credit`,`atlantian_barony`.`website` AS `website`,`atlantian_barony`.`branch_area_description` AS `branch_area_description`,`atlantian_barony`.`state_code` AS `state_code`,`atlantian_barony`.`display_order` AS `display_order`,`atlantian_barony`.`is_atlantian` AS `is_atlantian`,`atlantian_barony`.`notes` AS `notes`,`atlantian_barony`.`regional_group_id` AS `regional_group_id`,`atlantian_barony`.`group_id` AS `group_id`,`atlantian_barony`.`last_updated` AS `last_updated`,`atlantian_barony`.`last_updated_by` AS `last_updated_by` from `atlantian_barony` where ((`atlantian_barony`.`inactive` = 0) and isnull(`atlantian_barony`.`date_dissolved`)) */;

--
-- Final view structure for view `current_atlantian_branch`
--

/*!50001 DROP TABLE `current_atlantian_branch`*/;
/*!50001 DROP VIEW IF EXISTS `current_atlantian_branch`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `current_atlantian_branch` AS select `atlantian_branch`.`branch_id` AS `branch_id`,`atlantian_branch`.`branch` AS `branch`,`atlantian_branch`.`parent_branch_id` AS `parent_branch_id`,`atlantian_branch`.`branch_type_id` AS `branch_type_id`,`atlantian_branch`.`incipient` AS `incipient`,`atlantian_branch`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`atlantian_branch`.`date_founded` AS `date_founded`,`atlantian_branch`.`name_reg_date` AS `name_reg_date`,`atlantian_branch`.`device_reg_date` AS `device_reg_date`,`atlantian_branch`.`blazon` AS `blazon`,`atlantian_branch`.`device_file_name` AS `device_file_name`,`atlantian_branch`.`device_file_credit` AS `device_file_credit`,`atlantian_branch`.`website` AS `website`,`atlantian_branch`.`branch_area_description` AS `branch_area_description`,`atlantian_branch`.`state_code` AS `state_code`,`atlantian_branch`.`display_order` AS `display_order`,`atlantian_branch`.`notes` AS `notes`,`atlantian_branch`.`last_updated` AS `last_updated`,`atlantian_branch`.`last_updated_by` AS `last_updated_by` from `atlantian_branch` where ((`atlantian_branch`.`inactive` = 0) and isnull(`atlantian_branch`.`date_dissolved`)) */;

--
-- Final view structure for view `current_atlantian_branch_plus_kingdom`
--

/*!50001 DROP TABLE `current_atlantian_branch_plus_kingdom`*/;
/*!50001 DROP VIEW IF EXISTS `current_atlantian_branch_plus_kingdom`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `current_atlantian_branch_plus_kingdom` AS select `current_branch`.`branch_id` AS `branch_id`,`current_branch`.`branch` AS `branch`,`current_branch`.`parent_branch_id` AS `parent_branch_id`,`current_branch`.`branch_type_id` AS `branch_type_id`,`current_branch`.`incipient` AS `incipient`,`current_branch`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`current_branch`.`date_founded` AS `date_founded`,`current_branch`.`is_atlantian` AS `is_atlantian`,`current_branch`.`name_reg_date` AS `name_reg_date`,`current_branch`.`device_reg_date` AS `device_reg_date`,`current_branch`.`blazon` AS `blazon`,`current_branch`.`device_file_name` AS `device_file_name`,`current_branch`.`device_file_credit` AS `device_file_credit`,`current_branch`.`website` AS `website`,`current_branch`.`branch_area_description` AS `branch_area_description`,`current_branch`.`state_code` AS `state_code`,`current_branch`.`display_order` AS `display_order`,`current_branch`.`notes` AS `notes`,`current_branch`.`last_updated` AS `last_updated`,`current_branch`.`last_updated_by` AS `last_updated_by` from `current_branch` where ((`current_branch`.`is_atlantian` = 1) or (`current_branch`.`branch_type_id` = 1)) */;

--
-- Final view structure for view `current_branch`
--

/*!50001 DROP TABLE `current_branch`*/;
/*!50001 DROP VIEW IF EXISTS `current_branch`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `current_branch` AS select `branch`.`branch_id` AS `branch_id`,`branch`.`branch` AS `branch`,`branch`.`parent_branch_id` AS `parent_branch_id`,`branch`.`branch_type_id` AS `branch_type_id`,`branch`.`incipient` AS `incipient`,`branch`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`branch`.`date_founded` AS `date_founded`,`branch`.`is_atlantian` AS `is_atlantian`,`branch`.`name_reg_date` AS `name_reg_date`,`branch`.`device_reg_date` AS `device_reg_date`,`branch`.`blazon` AS `blazon`,`branch`.`device_file_name` AS `device_file_name`,`branch`.`device_file_credit` AS `device_file_credit`,`branch`.`website` AS `website`,`branch`.`branch_area_description` AS `branch_area_description`,`branch`.`state_code` AS `state_code`,`branch`.`display_order` AS `display_order`,`branch`.`notes` AS `notes`,`branch`.`last_updated` AS `last_updated`,`branch`.`last_updated_by` AS `last_updated_by` from `branch` where ((`branch`.`inactive` = 0) and isnull(`branch`.`date_dissolved`)) */;

--
-- Final view structure for view `kingdom`
--

/*!50001 DROP TABLE `kingdom`*/;
/*!50001 DROP VIEW IF EXISTS `kingdom`*/;
/*!50001 CREATE ALGORITHM=UNDEFINED */

/*!50001 VIEW `kingdom` AS select `branch`.`branch_id` AS `branch_id`,`branch`.`branch` AS `branch`,`branch`.`parent_branch_id` AS `parent_branch_id`,`branch`.`branch_type_id` AS `branch_type_id`,`branch`.`incipient` AS `incipient`,`branch`.`ceremonial_date_founded` AS `ceremonial_date_founded`,`branch`.`date_founded` AS `date_founded`,`branch`.`date_dissolved` AS `date_dissolved`,`branch`.`inactive` AS `inactive`,`branch`.`name_reg_date` AS `name_reg_date`,`branch`.`blazon` AS `blazon`,`branch`.`device_reg_date` AS `device_reg_date`,`branch`.`device_file_name` AS `device_file_name`,`branch`.`device_file_credit` AS `device_file_credit`,`branch`.`website` AS `website`,`branch`.`branch_area_description` AS `branch_area_description`,`branch`.`state_code` AS `state_code`,`branch`.`display_order` AS `display_order`,`branch`.`is_atlantian` AS `is_atlantian`,`branch`.`notes` AS `notes`,`branch`.`regional_group_id` AS `regional_group_id`,`branch`.`group_id` AS `group_id`,`branch`.`last_updated` AS `last_updated`,`branch`.`last_updated_by` AS `last_updated_by` from `branch` where (`branch`.`branch_type_id` = 1) */;


--
-- Current Database: `atlantia_university`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `atlantia_university` /*!40100 DEFAULT CHARACTER SET utf8 */;

USE `atlantia_university`;

--
-- Table structure for table `announcement`
--

DROP TABLE IF EXISTS `announcement`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `announcement` (
  `announcement_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `announcement_date` date NOT NULL,
  `expiration_date` date DEFAULT NULL,
  `announcement` text NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`announcement_id`),
  KEY `FK_announcement__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_announcement__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `chancellor`
--

DROP TABLE IF EXISTS `chancellor`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `chancellor` (
  `chancellor_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `participant_id` mediumint(8) unsigned NOT NULL,
  `start_university_id` mediumint(8) unsigned DEFAULT NULL,
  `end_university_id` mediumint(8) unsigned DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`chancellor_id`),
  KEY `FK_chancellor__participant` (`participant_id`),
  KEY `FK_chancellor__university_start` (`start_university_id`),
  KEY `FK_chancellor__university_end` (`end_university_id`),
  KEY `FK_chancellor__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_chancellor__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_chancellor__participant` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`participant_id`),
  CONSTRAINT `FK_chancellor__university_end` FOREIGN KEY (`end_university_id`) REFERENCES `university` (`university_id`),
  CONSTRAINT `FK_chancellor__university_start` FOREIGN KEY (`start_university_id`) REFERENCES `university` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `course`
--

DROP TABLE IF EXISTS `course`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course` (
  `course_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `university_id` mediumint(8) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text,
  `course_number` varchar(20) DEFAULT NULL,
  `course_code` varchar(30) DEFAULT NULL,
  `start_time` time DEFAULT NULL,
  `end_time` time DEFAULT NULL,
  `hours` tinyint(3) unsigned DEFAULT NULL,
  `credits` tinyint(3) unsigned DEFAULT NULL,
  `capacity` tinyint(3) unsigned DEFAULT NULL,
  `cost` decimal(4,2) DEFAULT NULL,
  `requirements` varchar(100) DEFAULT NULL,
  `changes` varchar(100) DEFAULT NULL,
  `comments` text,
  `room_id` mediumint(8) unsigned DEFAULT NULL,
  `course_category_id` mediumint(8) unsigned DEFAULT NULL,
  `course_track_id` mediumint(8) unsigned DEFAULT NULL,
  `course_status_id` mediumint(8) unsigned NOT NULL,
  `old_course_id` mediumint(8) unsigned DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`course_id`),
  KEY `FK_course__university` (`university_id`),
  KEY `FK_course__room` (`room_id`),
  KEY `FK_course__course_category` (`course_category_id`),
  KEY `FK_course__course_track` (`course_track_id`),
  KEY `FK_course__course_status` (`course_status_id`),
  KEY `FK_course__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_course__course_category` FOREIGN KEY (`course_category_id`) REFERENCES `course_category` (`course_category_id`),
  CONSTRAINT `FK_course__course_status` FOREIGN KEY (`course_status_id`) REFERENCES `course_status` (`course_status_id`),
  CONSTRAINT `FK_course__course_track` FOREIGN KEY (`course_track_id`) REFERENCES `course_track` (`course_track_id`),
  CONSTRAINT `FK_course__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_course__room` FOREIGN KEY (`room_id`) REFERENCES `room` (`room_id`),
  CONSTRAINT `FK_course__university` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4742 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `course_category`
--

DROP TABLE IF EXISTS `course_category`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_category` (
  `course_category_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `course_category` varchar(30) NOT NULL,
  `course_category_code` varchar(2) NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`course_category_id`),
  KEY `FK_course_category__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_course_category__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `course_category`
--

LOCK TABLES `course_category` WRITE;
/*!40000 ALTER TABLE `course_category` DISABLE KEYS */;
INSERT INTO `course_category` VALUES (1,'Arts & Sciences','AS',NULL,NULL,NULL),(2,'Current Middle Ages','CM',NULL,NULL,NULL),(3,'Humanities','H',NULL,NULL,NULL),(4,'Heraldry','HE',NULL,NULL,NULL),(5,'History','HS',NULL,NULL,NULL),(6,'Martial Arts','MA',NULL,NULL,NULL),(7,'Music & Dance','MD',NULL,NULL,NULL),(8,'Trivium','T',NULL,NULL,NULL),(9,'Quadrivium','Q',NULL,NULL,NULL),(10,'Required','R',NULL,NULL,NULL),(11,'No Credit','NC',NULL,NULL,NULL);
/*!40000 ALTER TABLE `course_category` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_status`
--

DROP TABLE IF EXISTS `course_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_status` (
  `course_status_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `course_status` varchar(30) NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`course_status_id`),
  KEY `FK_course_status__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_course_status__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `course_status`
--

LOCK TABLES `course_status` WRITE;
/*!40000 ALTER TABLE `course_status` DISABLE KEYS */;
INSERT INTO `course_status` VALUES (1,'Approved',NULL,NULL,NULL),(2,'Pending',NULL,NULL,NULL),(3,'Canceled',NULL,NULL,NULL);
/*!40000 ALTER TABLE `course_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `course_track`
--

DROP TABLE IF EXISTS `course_track`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `course_track` (
  `course_track_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `course_track` varchar(50) NOT NULL,
  `university_id` mediumint(8) unsigned NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`course_track_id`),
  KEY `FK_course_track__university` (`university_id`),
  KEY `FK_course_track__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_course_track__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_course_track__university` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `degree_status`
--

DROP TABLE IF EXISTS `degree_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `degree_status` (
  `degree_status_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `degree_status` varchar(30) NOT NULL,
  `degree_status_code` char(1) NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`degree_status_id`),
  KEY `FK_degree_status__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_degree_status__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `degree_status`
--

LOCK TABLES `degree_status` WRITE;
/*!40000 ALTER TABLE `degree_status` DISABLE KEYS */;
INSERT INTO `degree_status` VALUES (1,'Earned','E',NULL,NULL,NULL),(2,'Printed','P',NULL,NULL,NULL),(3,'Delivered','D',NULL,NULL,NULL);
/*!40000 ALTER TABLE `degree_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `participant`
--

DROP TABLE IF EXISTS `participant`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `participant` (
  `participant_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `university_participant_id` mediumint(8) unsigned DEFAULT NULL,
  `university_participant_id2` mediumint(8) unsigned DEFAULT NULL,
  `user_id` mediumint(8) unsigned DEFAULT NULL,
  `atlantian_id` mediumint(8) unsigned DEFAULT NULL,
  `sca_name` varchar(255) DEFAULT NULL,
  `last_university_id` mediumint(8) unsigned DEFAULT NULL,
  `b_old_university_id` mediumint(8) unsigned DEFAULT NULL,
  `b_old_degree_status_id` mediumint(8) unsigned DEFAULT NULL,
  `b_university_id` mediumint(8) unsigned DEFAULT NULL,
  `b_degree_status_id` mediumint(8) unsigned DEFAULT NULL,
  `f_university_id` mediumint(8) unsigned DEFAULT NULL,
  `f_degree_status_id` mediumint(8) unsigned DEFAULT NULL,
  `m_university_id` mediumint(8) unsigned DEFAULT NULL,
  `m_degree_status_id` mediumint(8) unsigned DEFAULT NULL,
  `d_university_id` mediumint(8) unsigned DEFAULT NULL,
  `d_degree_status_id` mediumint(8) unsigned DEFAULT NULL,
  `total_university_classes_taken` smallint(6) NOT NULL DEFAULT '0',
  `total_university_classes_taught` smallint(6) NOT NULL DEFAULT '0',
  `total_university_credits_taken` smallint(6) NOT NULL DEFAULT '0',
  `total_university_credits_taught` smallint(6) NOT NULL DEFAULT '0',
  `total_collegium_classes_taken` smallint(6) NOT NULL DEFAULT '0',
  `total_collegium_classes_taught` smallint(6) NOT NULL DEFAULT '0',
  `total_collegium_credits_taken` smallint(6) NOT NULL DEFAULT '0',
  `total_collegium_credits_taught` smallint(6) NOT NULL DEFAULT '0',
  `total_university_classes` smallint(6) NOT NULL DEFAULT '0',
  `total_university_credits` smallint(6) NOT NULL DEFAULT '0',
  `total_collegium_classes` smallint(6) NOT NULL DEFAULT '0',
  `total_collegium_credits` smallint(6) NOT NULL DEFAULT '0',
  `total_classes` smallint(6) NOT NULL DEFAULT '0',
  `total_credits` smallint(6) NOT NULL DEFAULT '0',
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`participant_id`),
  UNIQUE KEY `UK_participant_user` (`user_id`),
  UNIQUE KEY `UK_participant_atlantian` (`atlantian_id`),
  KEY `FK_participant__university_last` (`last_university_id`),
  KEY `FK_participant__university_b_old` (`b_old_university_id`),
  KEY `FK_participant__degree_status_b_old` (`b_old_degree_status_id`),
  KEY `FK_participant__university_b` (`b_university_id`),
  KEY `FK_participant__degree_status_b` (`b_degree_status_id`),
  KEY `FK_participant__university_f` (`f_university_id`),
  KEY `FK_participant__degree_status_f` (`f_degree_status_id`),
  KEY `FK_participant__university_m` (`m_university_id`),
  KEY `FK_participant__degree_status_m` (`m_degree_status_id`),
  KEY `FK_participant__university_d` (`d_university_id`),
  KEY `FK_participant__degree_status_d` (`d_degree_status_id`),
  KEY `FK_participant__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_participant__atlantian` FOREIGN KEY (`atlantian_id`) REFERENCES `atlantia_auth`.`atlantian` (`atlantian_id`),
  CONSTRAINT `FK_participant__degree_status_b` FOREIGN KEY (`b_degree_status_id`) REFERENCES `degree_status` (`degree_status_id`),
  CONSTRAINT `FK_participant__degree_status_b_old` FOREIGN KEY (`b_old_degree_status_id`) REFERENCES `degree_status` (`degree_status_id`),
  CONSTRAINT `FK_participant__degree_status_d` FOREIGN KEY (`d_degree_status_id`) REFERENCES `degree_status` (`degree_status_id`),
  CONSTRAINT `FK_participant__degree_status_f` FOREIGN KEY (`f_degree_status_id`) REFERENCES `degree_status` (`degree_status_id`),
  CONSTRAINT `FK_participant__degree_status_m` FOREIGN KEY (`m_degree_status_id`) REFERENCES `degree_status` (`degree_status_id`),
  CONSTRAINT `FK_participant__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_participant__university_b` FOREIGN KEY (`b_university_id`) REFERENCES `university` (`university_id`),
  CONSTRAINT `FK_participant__university_b_old` FOREIGN KEY (`b_old_university_id`) REFERENCES `university` (`university_id`),
  CONSTRAINT `FK_participant__university_d` FOREIGN KEY (`d_university_id`) REFERENCES `university` (`university_id`),
  CONSTRAINT `FK_participant__university_f` FOREIGN KEY (`f_university_id`) REFERENCES `university` (`university_id`),
  CONSTRAINT `FK_participant__university_last` FOREIGN KEY (`last_university_id`) REFERENCES `university` (`university_id`),
  CONSTRAINT `FK_participant__university_m` FOREIGN KEY (`m_university_id`) REFERENCES `university` (`university_id`),
  CONSTRAINT `FK_participant__user` FOREIGN KEY (`user_id`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5250 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `participant_type`
--

DROP TABLE IF EXISTS `participant_type`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `participant_type` (
  `participant_type_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `participant_type` varchar(30) NOT NULL,
  `participant_type_code` char(1) NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`participant_type_id`),
  KEY `FK_participant_type__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_participant_type__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `participant_type`
--

LOCK TABLES `participant_type` WRITE;
/*!40000 ALTER TABLE `participant_type` DISABLE KEYS */;
INSERT INTO `participant_type` VALUES (1,'Instructor','I',NULL,NULL,NULL),(2,'Student','S',NULL,NULL,NULL);
/*!40000 ALTER TABLE `participant_type` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registration`
--

DROP TABLE IF EXISTS `registration`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `registration` (
  `registration_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `course_id` mediumint(8) unsigned NOT NULL,
  `participant_id` mediumint(8) unsigned NOT NULL,
  `participant_type_id` mediumint(8) unsigned NOT NULL,
  `registration_status_id` mediumint(8) unsigned NOT NULL,
  `old_registration_id` mediumint(8) unsigned DEFAULT NULL,
  `old_registration_id2` mediumint(8) unsigned DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`registration_id`),
  UNIQUE KEY `UK_registration_course_participant` (`participant_id`,`course_id`),
  KEY `FK_registration__course` (`course_id`),
  KEY `FK_registration__participant_type` (`participant_type_id`),
  KEY `FK_registration__registration_status` (`registration_status_id`),
  KEY `FK_registration__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_registration__course` FOREIGN KEY (`course_id`) REFERENCES `course` (`course_id`),
  CONSTRAINT `FK_registration__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_registration__participant` FOREIGN KEY (`participant_id`) REFERENCES `participant` (`participant_id`),
  CONSTRAINT `FK_registration__participant_type` FOREIGN KEY (`participant_type_id`) REFERENCES `participant_type` (`participant_type_id`),
  CONSTRAINT `FK_registration__registration_status` FOREIGN KEY (`registration_status_id`) REFERENCES `registration_status` (`registration_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=48169 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Table structure for table `registration_status`
--

DROP TABLE IF EXISTS `registration_status`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `registration_status` (
  `registration_status_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `registration_status` varchar(30) NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`registration_status_id`),
  KEY `FK_registration_status__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_registration_status__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

--
-- Dumping data for table `registration_status`
--

LOCK TABLES `registration_status` WRITE;
/*!40000 ALTER TABLE `registration_status` DISABLE KEYS */;
INSERT INTO `registration_status` VALUES (1,'Pre-Registered',NULL,NULL,NULL),(2,'Attended',NULL,NULL,NULL),(3,'Wait List',NULL,NULL,NULL);
/*!40000 ALTER TABLE `registration_status` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `room`
--

DROP TABLE IF EXISTS `room`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `room` (
  `room_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `room` varchar(10) NOT NULL,
  `university_id` mediumint(8) unsigned NOT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`room_id`),
  KEY `FK_room__university` (`university_id`),
  KEY `FK_room__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_room__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_room__university` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `university`
--

DROP TABLE IF EXISTS `university`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `university` (
  `university_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `branch_id` mediumint(8) unsigned DEFAULT NULL,
  `university_date` date DEFAULT NULL,
  `university_code` varchar(10) NOT NULL,
  `is_university` tinyint(4) NOT NULL DEFAULT '1',
  `track_proposal_date` date DEFAULT NULL,
  `individual_proposal_date` date DEFAULT NULL,
  `publish_date` date DEFAULT NULL,
  `closed_date` date DEFAULT NULL,
  `total_students` smallint(6) DEFAULT NULL,
  `total_teachers` smallint(6) DEFAULT NULL,
  `total_attendees` smallint(6) DEFAULT NULL,
  `total_newcomers` smallint(6) DEFAULT NULL,
  `total_classes` smallint(6) DEFAULT NULL,
  `event_id` varchar(8) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`university_id`),
  UNIQUE KEY `UK_university_code` (`university_code`),
  KEY `FK_university__branch` (`branch_id`),
  KEY `FK_university__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_university__branch` FOREIGN KEY (`branch_id`) REFERENCES `atlantia_branch`.`branch` (`branch_id`),
  CONSTRAINT `FK_university__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=97 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;


--
-- Table structure for table `university_statistics`
--

DROP TABLE IF EXISTS `university_statistics`;
SET @saved_cs_client     = @@character_set_client;
SET character_set_client = utf8;
CREATE TABLE `university_statistics` (
  `university_statistics_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `university_id` mediumint(8) unsigned NOT NULL,
  `course_category_id` mediumint(8) unsigned DEFAULT NULL,
  `total_classes` smallint(6) DEFAULT NULL,
  `date_created` date DEFAULT NULL,
  `last_updated` date DEFAULT NULL,
  `last_updated_by` mediumint(8) unsigned DEFAULT NULL,
  PRIMARY KEY (`university_statistics_id`),
  KEY `FK_university_statistics__university` (`university_id`),
  KEY `FK_university_statistics__course_category` (`course_category_id`),
  KEY `FK_university_statistics_category__last_edited` (`last_updated_by`),
  CONSTRAINT `FK_university_statistics_category__last_edited` FOREIGN KEY (`last_updated_by`) REFERENCES `atlantia_auth`.`user_auth` (`user_id`),
  CONSTRAINT `FK_university_statistics__course_category` FOREIGN KEY (`course_category_id`) REFERENCES `course_category` (`course_category_id`),
  CONSTRAINT `FK_university_statistics__university` FOREIGN KEY (`university_id`) REFERENCES `university` (`university_id`)
) ENGINE=InnoDB AUTO_INCREMENT=54446 DEFAULT CHARSET=utf8;
SET character_set_client = @saved_cs_client;

/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2010-10-17  2:47:39
