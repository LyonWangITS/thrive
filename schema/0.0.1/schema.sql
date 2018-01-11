
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
DROP TABLE IF EXISTS `accounts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `accounts` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `role_id` int(10) unsigned DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `reset_code` varchar(255) DEFAULT NULL,
  `partner_id` int(10) unsigned DEFAULT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `partner_id` (`partner_id`),
  CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
  CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `entries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `entries` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `partner_id` int(11) unsigned DEFAULT NULL,
  `started` datetime DEFAULT NULL,
  `completed` datetime DEFAULT NULL,
  `token` varchar(255) NOT NULL DEFAULT '',
  `is_test` int(1) NOT NULL DEFAULT '0',
  `00_participant_name` text NOT NULL,
  `01_course_studying` varchar(30) DEFAULT NULL,
  `01_staff_student` enum('staff','student') DEFAULT 'student',
  `01_hours_per_week` enum('gt-10','lt-10') DEFAULT NULL,
  `01_age` int(11) DEFAULT NULL,
  `01_gender` enum('female','male','transgender-ftm','transgender-mtf','genderqueer','androgynous','intersex') DEFAULT NULL,
  `01_sexual_orientation` enum('m','mostly-m','f','mostly-f','equally-mf','unsure','skip') DEFAULT NULL,
  `01_year_level` enum('1st-year','2nd-year','3rd-year','4th-year','postgraduate','not-applicable') DEFAULT NULL,
  `01_on_campus` int(1) unsigned DEFAULT NULL,
  `01_where_from` enum('perth-metro','regional-wa','other-state','international') DEFAULT NULL,
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
  `audit_score` int(3) unsigned DEFAULT NULL,
  `callback_requested` int(1) DEFAULT NULL,
  `rating_important_reduce_drinking` int(2) unsigned DEFAULT NULL,
  `rating_confident_reduce_drinking` int(2) unsigned DEFAULT NULL,
  `rating_important_talk_professional` int(2) unsigned DEFAULT NULL,
  `rating_ready_talk_professional` int(2) unsigned DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partner_id` (`partner_id`),
  CONSTRAINT `entries_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `lu_partner_states`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `lu_partner_states` (
  `id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `partners`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `partners` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL COMMENT 'Subdomain or directory path, so no spaces, special characters, etc',
  `website` varchar(255) DEFAULT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `welcome_text` text,
  `confidentiality_text` text,
  `is_staff_student` tinyint(1) NOT NULL DEFAULT '0',
  `is_adis_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_year_level_question_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_on_campus_question_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_from_question_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `is_feedback_enabled` tinyint(1) NOT NULL DEFAULT '0',
  `lu_partner_state_id` int(10) unsigned NOT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lu_partner_state_id` (`lu_partner_state_id`),
  CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`lu_partner_state_id`) REFERENCES `lu_partner_states` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `pending_changes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pending_changes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partner_id` int(10) unsigned NOT NULL,
  `data` text NOT NULL,
  `logo_path` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `partner_id` (`partner_id`),
  CONSTRAINT `pending_changes_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `roles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `order` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `partner_id` int(10) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `contact_numbers` text NOT NULL,
  `address` text NOT NULL,
  `opening_hours` text NOT NULL,
  `fees` varchar(255) NOT NULL,
  `website` varchar(255) DEFAULT NULL,
  `additional_info` text,
  PRIMARY KEY (`id`),
  KEY `partner_id` (`partner_id`),
  CONSTRAINT `services_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

