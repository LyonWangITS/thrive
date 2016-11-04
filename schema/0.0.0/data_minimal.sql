-- phpMyAdmin SQL Dump
-- version 4.2.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: Mar 11, 2015 at 11:00 AM
-- Server version: 5.5.38
-- PHP Version: 5.6.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `thrive`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE `accounts` (
	`id` int(11) unsigned NOT NULL,
	`name` varchar(255) DEFAULT NULL,
	`role_id` int(10) unsigned DEFAULT NULL,
	`email` varchar(255) NOT NULL,
	`phone` varchar(255) DEFAULT NULL,
	`password` varchar(255) NOT NULL,
	`reset_code` varchar(255) DEFAULT NULL,
	`partner_id` int(10) unsigned DEFAULT NULL,
	`is_admin` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `name`, `role_id`, `email`, `phone`, `password`, `reset_code`, `partner_id`, `is_admin`) VALUES
	(1, 'Admin', NULL, 'admin@example.com', NULL, 'fda1172b8d04cf94e7f9f9c776dd4f11656f517f', NULL, NULL, 1),
	(2, 'John Smith', 1, 'demo@example.com', NULL, 'fda1172b8d04cf94e7f9f9c776dd4f11656f517f', NULL, 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `entries`
--

CREATE TABLE `entries` (
	`id` int(11) unsigned NOT NULL,
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
	`rating_ready_talk_professional` int(2) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `lu_partner_states`
--

CREATE TABLE `lu_partner_states` (
	`id` int(10) unsigned NOT NULL,
	`name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `lu_partner_states`
--

INSERT INTO `lu_partner_states` (`id`, `name`) VALUES
	(1, 'Unapproved'),
	(2, 'Approved'),
	(3, 'Deleted');

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
	`id` int(11) unsigned NOT NULL,
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
	`created` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`id`, `name`, `slug`, `website`, `logo_path`, `welcome_text`, `confidentiality_text`, `is_staff_student`, `is_adis_enabled`, `is_year_level_question_enabled`, `is_on_campus_question_enabled`, `is_from_question_enabled`, `is_feedback_enabled`, `lu_partner_state_id`, `created`) VALUES
	(1, 'Demo University', 'demo', 'http://www.curtin.edu.au/', '/images/partners/1.png', NULL, 'The survey is being conducted by the Western Australian Centre for Health Promotion Research (WACHPR) to explore the use of alcohol by Polytechnic West students. However, the survey is independent, not connected to Polytechnic West student services and completely anonymous.\r\n\r\nThis study has been approved by the Curtin University Human Research Ethics Committee (Approval Number HR70/2013). The Committee is comprised of members of the public, academics, lawyers, doctors and pastoral carers. If needed, verification of approval can be obtained either by writing to the Curtin University Human Research Ethics Committee, c/- Office of Research and Development, Curtin University, GPO Box U1987, Perth 6845 or by telephoning 9266 9223 or by emailing hrec@curtin.edu.au.', 1, 0, 1, 1, 1, 1, 2, '2014-02-03 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `pending_changes`
--

CREATE TABLE `pending_changes` (
	`id` int(10) unsigned NOT NULL,
	`partner_id` int(10) unsigned NOT NULL,
	`data` text NOT NULL,
	`logo_path` varchar(255) DEFAULT NULL,
	`created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
	`id` int(10) unsigned NOT NULL,
	`name` varchar(255) NOT NULL,
	`order` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `order`) VALUES
	(1, 'Researcher', 1),
	(2, 'Health service provider', 2),
	(3, 'Management/Executive', 3);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
	`id` int(10) unsigned NOT NULL,
	`partner_id` int(10) unsigned NOT NULL,
	`name` varchar(255) NOT NULL,
	`contact_numbers` text NOT NULL,
	`address` text NOT NULL,
	`opening_hours` text NOT NULL,
	`fees` varchar(255) NOT NULL,
	`website` varchar(255) DEFAULT NULL,
	`additional_info` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accounts`
--
ALTER TABLE `accounts`
ADD PRIMARY KEY (`id`), ADD KEY `role_id` (`role_id`), ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `entries`
--
ALTER TABLE `entries`
ADD PRIMARY KEY (`id`), ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `lu_partner_states`
--
ALTER TABLE `lu_partner_states`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
ADD PRIMARY KEY (`id`), ADD KEY `lu_partner_state_id` (`lu_partner_state_id`);

--
-- Indexes for table `pending_changes`
--
ALTER TABLE `pending_changes`
ADD PRIMARY KEY (`id`), ADD KEY `partner_id` (`partner_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
ADD PRIMARY KEY (`id`), ADD KEY `partner_id` (`partner_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `accounts`
--
ALTER TABLE `accounts`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `entries`
--
ALTER TABLE `entries`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
MODIFY `id` int(11) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `pending_changes`
--
ALTER TABLE `pending_changes`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
MODIFY `id` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `accounts`
--
ALTER TABLE `accounts`
ADD CONSTRAINT `accounts_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`),
ADD CONSTRAINT `accounts_ibfk_2` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`);

--
-- Constraints for table `entries`
--
ALTER TABLE `entries`
ADD CONSTRAINT `entries_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

--
-- Constraints for table `partners`
--
ALTER TABLE `partners`
ADD CONSTRAINT `partners_ibfk_1` FOREIGN KEY (`lu_partner_state_id`) REFERENCES `lu_partner_states` (`id`);

--
-- Constraints for table `pending_changes`
--
ALTER TABLE `pending_changes`
ADD CONSTRAINT `pending_changes_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);

--
-- Constraints for table `services`
--
ALTER TABLE `services`
ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`partner_id`) REFERENCES `partners` (`id`);
