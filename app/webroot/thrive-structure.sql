# ************************************************************
# Sequel Pro SQL dump
# Version 4004
#
# http://www.sequelpro.com/
# http://code.google.com/p/sequel-pro/
#
# Host: localhost (MySQL 5.5.29)
# Database: thrive
# Generation Time: 2013-10-30 01:29:28 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table entries
# ------------------------------------------------------------

DROP TABLE IF EXISTS `entries`;

CREATE TABLE `entries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `started` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  `token` varchar(255) NOT NULL DEFAULT '',
  `00_participant_name` text NOT NULL,
  `01_course_studying` varchar(30) DEFAULT NULL,
  `01_hours_per_week` enum('gt-10','lt-10') DEFAULT NULL,
  `01_age` int(11) DEFAULT NULL COMMENT '18-25',
  `01_gender` enum('female','male','transgender-ftm','transgender-mtf','genderqueer','androgynous','intersex') DEFAULT NULL,
  `01_sexual_orientation` enum('m','mostly-m','f','mostly-f','equally-mf','unsure','skip') DEFAULT NULL,
  `01_alcohol_last_12mths` int(1) unsigned DEFAULT NULL,
  `02_how_often_drink_alcohol` enum('never','lt-1pm','1pm','1p2w','1pw','2-3pw','4pw') DEFAULT NULL,
  `02_how_many_on_typical_day` int(11) DEFAULT NULL,
  `02_how_often_six_or_more` enum('never','1-2py','lt-1pm','1pm','1pw','1pd') DEFAULT NULL,
  `02_past_year_how_often_unable_to_stop` enum('never','lt-1pm','1pm','1pw','1pd') DEFAULT NULL,
  `02_past_year_how_often_failed_expectations` enum('never','lt-1pm','1pm','1pw','1pd') DEFAULT NULL,
  `02_past_year_needed_morning_drink` enum('never','lt-1pm','1pm','1pw','1pd') DEFAULT NULL,
  `02_past_year_how_often_remorseful` enum('never','lt-1pm','1pm','1pw','1pd') DEFAULT NULL,
  `02_past_year_how_often_unable_to_remember` enum('never','lt-1pm','1pm','1pw','1pd') DEFAULT NULL,
  `02_been_injured_or_injured_someone` enum('no','yes-nly','yes-ly') DEFAULT NULL,
  `02_others_concerned_about_my_drinking` enum('no','yes-nly','yes-ly') DEFAULT NULL,
  `03_past_4wk_consumed_alcohol` int(1) DEFAULT NULL,
  `03_past_4wk_largest_number_single_occasion` int(11) DEFAULT NULL,
  `03_past_4wk_hours_amount_drank` int(11) DEFAULT NULL,
  `03_body_height_cm` float DEFAULT NULL,
  `03_body_weight_kg` float DEFAULT NULL,
  `04_hangover` enum('no','yes','skip') DEFAULT NULL,
  `04_emotional_outburst` enum('no','yes','skip') DEFAULT NULL,
  `04_vomiting` enum('no','yes','skip') DEFAULT NULL,
  `04_heated_argument` enum('no','yes','skip') DEFAULT NULL,
  `04_physically_aggressive` enum('no','yes','skip') DEFAULT NULL,
  `04_blackouts` enum('no','yes','skip') DEFAULT NULL,
  `04_inability_to_pay_bills` enum('no','yes','skip') DEFAULT NULL,
  `04_unprotected_sex` enum('no','yes','skip') DEFAULT NULL,
  `04_sexual_situation_not_happy_about` enum('no','yes','skip') DEFAULT NULL,
  `04_sexual_encounter_later_regretted` enum('no','yes','skip') DEFAULT NULL,
  `04_injury_requiring_medical_attention` enum('no','yes','skip') DEFAULT NULL,
  `04_drove_car_unsafely` enum('no','yes','skip') DEFAULT NULL,
  `04_passenger_of_unsafe_driver` enum('no','yes','skip') DEFAULT NULL,
  `04_stole_property` enum('no','yes','skip') DEFAULT NULL,
  `04_committed_vandalism` enum('no','yes','skip') DEFAULT NULL,
  `04_removed_or_banned_from_pub_club` enum('no','yes','skip') DEFAULT NULL,
  `04_arrested` enum('no','yes','skip') DEFAULT NULL,
  `callback_requested` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;




/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
