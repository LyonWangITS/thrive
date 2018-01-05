
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
INSERT INTO `entries` VALUES (1,1,'2017-06-14 13:42:03','2017-06-14 13:45:45','Q0lf6slDZOGaPHYhSHc7P9wBlNA21a3I',0,1234,'Philip',22,'male','hawaiian','not-hispanic-latino','dorm','1pw','Rex','The Beatles','ar',45,'never','lt-1pm','lt-1pm','lt-1pm','lt-1pm','lt-1pm','yes-nly','yes-nly',1,1,2,3,4,3,2,1,10,11,12,13,14,15,16,1,1,180.34,78.0178,'no','no','no','no','no','no','no','no','no','no','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never',5,5,'never',5,5,11,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `entries` ENABLE KEYS */;

/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'Demo University','demo','http://www.curtin.edu.au/','/images/partners/1.png',NULL,'The survey is being conducted by the Western Australian Centre for Health Promotion Research (WACHPR) to explore the use of alcohol by Polytechnic West students. However, the survey is independent, not connected to Polytechnic West student services and completely anonymous.\r\n\r\nThis study has been approved by the Curtin University Human Research Ethics Committee (Approval Number HR70/2013). The Committee is comprised of members of the public, academics, lawyers, doctors and pastoral carers. If needed, verification of approval can be obtained either by writing to the Curtin University Human Research Ethics Committee, c/- Office of Research and Development, Curtin University, GPO Box U1987, Perth 6845 or by telephoning 9266 9223 or by emailing hrec@curtin.edu.au.',1,0,1,1,1,1,2,'2014-02-03 00:00:00');
INSERT INTO `partners` VALUES (2,'UF','uf','http://www.ufl.edu/','/images/partners/2.png',NULL,'',0,0,0,0,0,0,2,'2017-12-22 11:44:59');
/*!40000 ALTER TABLE `partners` ENABLE KEYS */;

/*!40000 ALTER TABLE `pending_changes` DISABLE KEYS */;
/*!40000 ALTER TABLE `pending_changes` ENABLE KEYS */;

/*!40000 ALTER TABLE `services` DISABLE KEYS */;
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

