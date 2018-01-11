
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
-- hashed passwords are sha1 of the salt string concatenated with the clear text password. e.g.,
-- select sha1(concat('hfsd8f7hF7SDH*(#S7DHF78fshd88S8D76&^FSDsd' , 'password')) as hashpass from dual;
-- or
-- update accounts set password =  sha1(concat('hfsd8f7hF7SDH*(#S7DHF78fshd88S8D76&^FSDsd' , 'password'));
INSERT INTO `accounts` VALUES (1,'Admin',NULL,'cts-it-all@ctsi.ufl.edu',NULL,'password',NULL,NULL,1);
INSERT INTO `accounts` VALUES (2,'Robert Leeman',1,'robert.leeman@ufl.edu',NULL,'password',NULL,1,0);
/*!40000 ALTER TABLE `accounts` ENABLE KEYS */;

/*!40000 ALTER TABLE `entries` DISABLE KEYS */;
INSERT INTO `entries` VALUES (1,1,'2017-06-14 13:42:03','2017-06-14 13:45:45','Q0lf6slDZOGaPHYhSHc7P9wBlNA21a3I',0,'Philip',22,'male','hawaiian',1,'not-hispanic-latino','dorm',0,'uf-only','1pw',1,'never','lt-1pm','lt-1pm','lt-1pm','lt-1pm','lt-1pm','yes-nly','yes-nly',1,1,2,3,4,3,2,1,10,11,12,13,14,15,16,1,1,180.34,78.0178,'no','no','no','no','no','no','no','no','no','no','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never','never',5,5,'never',5,5,11,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `entries` ENABLE KEYS */;

/*!40000 ALTER TABLE `partners` DISABLE KEYS */;
INSERT INTO `partners` VALUES (1,'UF','uf','','',NULL,'',0,0,0,0,0,1,2,'2017-10-19 16:19:59');
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

