
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
  `01_age` int(11) DEFAULT NULL,
  `01_gender` enum('female','male','transgender-ftm','transgender-mtf','genderqueer','androgynous','intersex') DEFAULT NULL,
  `01_race` enum('native-american','asian','hawaiian','black','white','mixed-race','other','skip') DEFAULT NULL,
  `01_alcohol_last_12mths` int(1) unsigned DEFAULT NULL,
  `01_ethnicity` enum('hispanic-latino','not-hispanic-latino','skip') DEFAULT NULL,
  `01_where` enum('dorm','with-parents','with-roommates') DEFAULT NULL,
  `01_parents` int(1) unsigned DEFAULT NULL,
  `01_history` enum('uf-only','transfered') DEFAULT NULL,
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
  `03_past_4wk_drinks_sun` int(11) DEFAULT NULL,
  `03_past_4wk_drinks_mon` int(11) DEFAULT NULL,
  `03_past_4wk_drinks_tue` int(11) DEFAULT NULL,
  `03_past_4wk_drinks_wed` int(11) DEFAULT NULL,
  `03_past_4wk_drinks_thu` int(11) DEFAULT NULL,
  `03_past_4wk_drinks_fri` int(11) DEFAULT NULL,
  `03_past_4wk_drinks_sat` int(11) DEFAULT NULL,
  `03_past_4wk_std_drinks_sun` int(11) DEFAULT NULL,
  `03_past_4wk_std_drinks_mon` int(11) DEFAULT NULL,
  `03_past_4wk_std_drinks_tue` int(11) DEFAULT NULL,
  `03_past_4wk_std_drinks_wed` int(11) DEFAULT NULL,
  `03_past_4wk_std_drinks_thu` int(11) DEFAULT NULL,
  `03_past_4wk_std_drinks_fri` int(11) DEFAULT NULL,
  `03_past_4wk_std_drinks_sat` int(11) DEFAULT NULL,
  `03_past_4wk_largest_number_single_occasion` int(11) DEFAULT NULL,
  `03_past_4wk_hours_amount_drank` int(11) DEFAULT NULL,
  `03_body_height_cm` float DEFAULT NULL,
  `03_body_weight_kg` float DEFAULT NULL,
  `04_difficult_to_limit` enum('no','yes','skip') DEFAULT NULL,
  `04_start_drinking_after_deciding_not_to` enum('no','yes','skip') DEFAULT NULL,
  `04_end_up_drinking_more` enum('no','yes','skip') DEFAULT NULL,
  `04_cut_down_drinking` enum('no','yes','skip') DEFAULT NULL,
  `04_drink_when_causing_problems` enum('no','yes','skip') DEFAULT NULL,
  `04_stop_drinking_after_two_drinks` enum('no','yes','skip') DEFAULT NULL,
  `04_stop_drinking_after_drunk` enum('no','yes','skip') DEFAULT NULL,
  `04_irresistible_urge_continue_drinking` enum('no','yes','skip') DEFAULT NULL,
  `04_difficult_to_resist_drinking` enum('no','yes','skip') DEFAULT NULL,
  `04_able_to_slow_drinking` enum('no','yes','skip') DEFAULT NULL,
  `05_embarassing_things` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_hangover` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_sick` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_end_up_drinking_without_planning` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_take_foolish_risks` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_pass_out` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_need_larger_amounts_to_feel_effect` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_impulsive_things` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_memory_loss` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_drive_unsafely` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_miss_work_or_class` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_regretted_sexual_situations` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_difficult_to_limit` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_become_rude` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_wake_up_unexpected_place` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_feel_bad` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_lack_of_energy` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_suffered_work_quality` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_spend_too_much_time_drinking` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_neglect_obligations` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_relationship_problems` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_overweight` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_harmed_physical_appearance` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `05_need_drink_before_breakfast` enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL,
  `06_count_drinks` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_set_number_drinks` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_eat_before` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_space_drinks_out` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_alternate_drinks` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_drink_for_quality` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_avoid_drinking_games` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_have_a_reliable_driver` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_preplan_transportation` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_dst_protection` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `06_watch_out_for_each_other` enum('never', 'almost-never', 'sort-time', 'half-time', 'most-time', 'almost-always', 'always', 'skip') DEFAULT NULL,
  `07_cut_down_drinking` int(11) DEFAULT NULL,
  `07_stop_drinking` int(11) DEFAULT NULL,
  `08_tobacco_use` enum('never', 'used_to_smoke_regularly', 'occasionally', 'regularly') DEFAULT NULL,
  `08_tobacco_frequency` int(11) DEFAULT NULL,
  `08_tobacco_init` int(11) DEFAULT NULL,
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

