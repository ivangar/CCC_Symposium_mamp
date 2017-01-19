# ************************************************************
# Sequel Pro SQL dump
# Version 4096
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: 127.0.0.1 (MySQL 5.5.29)
# Database: rep_zone
# Generation Time: 2016-10-25 18:30:42 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table address
# ------------------------------------------------------------

DROP TABLE IF EXISTS `address`;

CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `street_address` varchar(100) DEFAULT NULL,
  `suite` varchar(20) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `province` varchar(50) DEFAULT NULL,
  `postal_code` varchar(50) DEFAULT NULL,
  `telephone` varchar(50) DEFAULT NULL,
  `fax` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table agendas
# ------------------------------------------------------------

DROP TABLE IF EXISTS `agendas`;

CREATE TABLE `agendas` (
  `agenda_id` int(11) NOT NULL AUTO_INCREMENT,
  `arrrival_meal_time` time DEFAULT NULL,
  `QA_time` time DEFAULT NULL,
  `program_end_time` time DEFAULT NULL,
  PRIMARY KEY (`agenda_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table events
# ------------------------------------------------------------

DROP TABLE IF EXISTS `events`;

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL AUTO_INCREMENT,
  `event_date` date DEFAULT NULL,
  `event_time` time DEFAULT NULL,
  `location` varchar(300) DEFAULT NULL,
  `attendees` int(11) DEFAULT NULL,
  `catering` varchar(50) DEFAULT NULL,
  `rep_id` int(11) NOT NULL,
  `agenda_id` int(11) DEFAULT NULL,
  `moderator_id` int(11) DEFAULT NULL,
  `folder_id` varchar(10) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`event_id`),
  KEY `agendas_events_CON` (`agenda_id`),
  KEY `moderators_events_CON` (`moderator_id`),
  KEY `reps_events_CON` (`rep_id`),
  KEY `status_events_CON` (`status`),
  CONSTRAINT `agendas_events_CON` FOREIGN KEY (`agenda_id`) REFERENCES `agendas` (`agenda_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `moderators_events_CON` FOREIGN KEY (`moderator_id`) REFERENCES `moderators` (`moderator_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT `reps_events_CON` FOREIGN KEY (`rep_id`) REFERENCES `reps` (`rep_id`) ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table moderators
# ------------------------------------------------------------

DROP TABLE IF EXISTS `moderators`;

CREATE TABLE `moderators` (
  `moderator_id` int(11) NOT NULL AUTO_INCREMENT,
  `mod_name` varchar(150) DEFAULT NULL,
  `mod_credentials` varchar(100) DEFAULT NULL,
  `mod_email` varchar(100) DEFAULT NULL,
  `mod_institution` varchar(200) DEFAULT NULL,
  `honorarium` varchar(50) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `folder_id` varchar(10) DEFAULT NULL,
  `coi_form` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`moderator_id`),
  KEY `address_moderators_CON` (`address_id`),
  CONSTRAINT `address_moderators_CON` FOREIGN KEY (`address_id`) REFERENCES `address` (`address_id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table reps
# ------------------------------------------------------------

DROP TABLE IF EXISTS `reps`;

CREATE TABLE `reps` (
  `rep_id` int(11) NOT NULL AUTO_INCREMENT,
  `rep_name` varchar(100) DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `email` varchar(250) NOT NULL DEFAULT '',
  `phone` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`rep_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



# Dump of table status
# ------------------------------------------------------------

DROP TABLE IF EXISTS `status`;

CREATE TABLE `status` (
  `status` int(11) NOT NULL AUTO_INCREMENT,
  `status` varchar(50) DEFAULT NULL,
  `value` int(9) DEFAULT NULL,
  PRIMARY KEY (`status`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
