
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

/*!40000 ALTER TABLE `accounts` DISABLE KEYS */;
INSERT INTO `accounts` VALUES (1,'Admin',NULL,'admin@example.com',NULL,'fda1172b8d04cf94e7f9f9c776dd4f11656f517f',NULL,NULL,1);
INSERT INTO `accounts` VALUES (2,'John Smith',1,'demo@example.com',NULL,'fda1172b8d04cf94e7f9f9c776dd4f11656f517f',NULL,1,0);
INSERT INTO `accounts` VALUES (3,'Albert',1,'albert@example.com',NULL,'fda1172b8d04cf94e7f9f9c776dd4f11656f517f',NULL,2,0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

/*!40000 ALTER TABLE `entries` DISABLE KEYS */;
INSERT INTO `entries` VALUES (2,2,'2018-01-11 18:52:52','2018-01-11 18:57:57','zvGePAARiqxVfKtqAW6kXguxzvWE7KAw',0,'Philip',1245,24,'male','asian','not-hispanic-latino','with-parents','flops','Molly Hatchet','ri',35,'agree-strongly','agree-somewhat','disagree-somewhat','disagree-strongly','disagree-somewhat','agree-somewhat','agree-strongly','agree-somewhat','disagree-somewhat','disagree-strongly','disagree-somewhat','agree-somewhat','agree-strongly','agree-somewhat','disagree-somewhat','disagree-strongly','disagree-somewhat','agree-somewhat','agree-strongly','agree-somewhat','1pm',1,'1-2py','lt-1pm','lt-1pm','lt-1pm','lt-1pm','lt-1pm','yes-nly','yes-nly',1,1,1,1,1,1,1,1,1,0,1,0,1,0,2,2,180.34,79.3786,'never','rarely','sometimes','often','always','skip','always','often','sometimes','rarely','yes','no','skip','no','yes','no','skip','no','yes','no','skip','no','yes','no','skip','no','yes','no','skip','no','yes','no','skip','no','never','almost-never','some-time','half-time','most-time','almost-always','always','skip','always','almost-always','most-time',2,3,'occasionally',2,30,11,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `entries` ENABLE KEYS */;

/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'Demo University','demo','http://www.curtin.edu.au/','/images/partners/1.png',NULL,'The survey is being conducted by the Western Australian Centre for Health Promotion Research (WACHPR) to explore the use of alcohol by Polytechnic West students. However, the survey is independent, not connected to Polytechnic West student services and completely anonymous.\r\n\r\nThis study has been approved by the Curtin University Human Research Ethics Committee (Approval Number HR70/2013). The Committee is comprised of members of the public, academics, lawyers, doctors and pastoral carers. If needed, verification of approval can be obtained either by writing to the Curtin University Human Research Ethics Committee, c/- Office of Research and Development, Curtin University, GPO Box U1987, Perth 6845 or by telephoning 9266 9223 or by emailing hrec@curtin.edu.au.',1,0,1,1,1,1,2,'2014-02-03 00:00:00');
INSERT INTO `partners` VALUES (2,'UF','uf','http://www.ufl.edu/','/images/partners/2.png',NULL,'',0,0,0,0,0,0,2,'2017-12-22 11:44:59');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;

/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,2,'Meridian Behavioral Health Center','(800) 330-5615, (352) 374-5615','','','','http://mbhci.org','Meridian is a private, non-profit organization. They are committed to enhancing health and wellness for all those with whom they come in contact. Whether you are looking to improve your sense of well-being, gain a performance edge, or deal with a mental illness or substance use issue, they have staff and services to meet your needs.');
INSERT INTO `services` VALUES (2,2,'Florida Recovery Center','(855) 265-4FRC','','','','https://floridarecoverycenter.ufhealth.org','Florida Recovery Center is a treatment center that is run by UF Health. They provide all levels of care for people suffering from drug addiction or alcohol addiction who need drug rehab or alcohol treatment. The staff can provide medical consults, comprehensive labs and psychological testing for people who have an addiction and/or other psychiatric conditions.');
INSERT INTO `services` VALUES (3,2,'Information about research studies at the University of Florida','','','','','https://www.ctsi.ufl.edu/community/become-a-research-participant, https://ufhealth.org/research-studies-clinical-trials','');
INSERT INTO `services` VALUES (4,2,'\"Rethinking Drinking\" website','','','','','https://www.rethinkingdrinking.niaaa.nih.gov','This is an interactive website offered by the National Institute on Alcohol Abuse and Alcoholism. You can find out more about your level of risk and get useful tips to reduce your drinking');
INSERT INTO `services` VALUES (5,2,'Other referrals','352-214-4047','','','','','Any questions or interested in additional referrals? Call us at 352-214-4047 or email us at anchorsresearch@hhp.ufl.edu. If you call, you do not need to give your name.');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;

/*!40000 ALTER TABLE `pending_changes` DISABLE KEYS */;
/*!40000 ALTER TABLE `pending_changes` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

