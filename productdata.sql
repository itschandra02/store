/*
SQLyog Professional
MySQL - 8.0.25-0ubuntu0.20.10.1 : Database - ari_store
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `product_data` */

CREATE TABLE `product_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` int NOT NULL DEFAULT '0',
  `discount` int NOT NULL DEFAULT '0',
  `layanan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'diamond',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `product_data_product_id_foreign` (`product_id`),
  CONSTRAINT `product_data_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `product_data` */

insert  into `product_data`(`id`,`product_id`,`name`,`price`,`discount`,`layanan`,`type_data`,`created_at`,`updated_at`) values (1,1,'86 Diamonds',18131,0,'','diamond','2021-06-16 16:25:15','2021-06-26 23:00:46'),(2,1,'172 Diamonds',34812,0,'','diamond','2021-06-16 16:25:15','2021-06-16 20:33:16'),(3,1,'344 Diamonds',69625,0,'23,23','diamond','2021-06-16 20:34:25','2021-06-16 20:34:25'),(4,1,'429 Diamonds',87727,0,'23,25','diamond','2021-06-16 20:35:09','2021-06-16 20:35:09'),(5,1,'514 Diamonds',105830,0,'25,25','diamond','2021-06-16 20:35:37','2021-06-16 20:35:37'),(6,1,'601 Diamonds',122540,0,'25,23,23','diamond','2021-06-16 20:36:35','2021-06-16 20:36:35'),(7,1,'706 Diamonds',139250,0,'26','diamond','2021-06-16 20:37:01','2021-06-16 20:37:01'),(8,1,'792 Diamonds',156795,0,'26,13','diamond','2021-06-16 20:38:17','2021-06-16 20:40:19'),(9,1,'878 Diamonds',174062,0,'26,23','diamond','2021-06-16 20:39:06','2021-06-16 20:39:06'),(10,1,'963 Diamonds',192165,0,'26,25','diamond','2021-06-16 20:41:33','2021-06-16 20:41:33'),(11,1,'1050 Diamonds',208875,0,'26,23,23','diamond','2021-06-16 20:43:19','2021-06-16 20:43:19'),(12,1,'1135 Diamonds',226977,0,'26,25,23','diamond','2021-06-16 20:44:57','2021-06-16 20:44:57'),(13,1,'1220 Diamonds',245080,0,'26,25,25','diamond','2021-06-16 20:45:24','2021-06-16 20:45:24'),(14,1,'1307 Diamonds',261790,0,'26,25,23,23','diamond','2021-06-16 20:46:02','2021-06-16 20:46:02'),(15,1,'1412 Diamonds',278500,0,'26,26','diamond','2021-06-16 20:47:49','2021-06-16 20:47:49'),(16,1,'1498 Diamonds',296045,0,'26,26,13','diamond','2021-06-16 20:48:28','2021-06-16 20:48:28'),(17,1,'1584 Diamonds',313591,0,'26,26,13','diamond','2021-06-16 20:49:57','2021-06-16 20:49:57'),(18,1,'1669 Diamonds',331415,0,'26,26,25','diamond','2021-06-16 20:50:37','2021-06-16 20:50:37'),(19,1,'1756 Diamonds',348125,0,'26,26,23,23','diamond','2021-06-16 20:51:18','2021-06-16 20:51:18'),(20,1,'1841 Diamonds',366227,0,'26,26,25,23','diamond','2021-06-16 20:52:09','2021-06-16 20:52:09'),(21,1,'1926 Diamonds',384330,0,'26,26,25,25','diamond','2021-06-16 20:52:37','2021-06-16 20:52:37'),(22,1,'2012 Diamonds',401875,0,'26,26,25,25,13','diamond','2021-06-16 20:53:15','2021-06-16 20:53:15'),(23,1,'2195 Diamonds',413572,0,'27','diamond','2021-06-16 20:53:47','2021-06-16 20:53:47'),(24,1,'2281 Diamonds',431118,0,'27,13','diamond','2021-06-16 20:54:46','2021-06-16 20:54:46'),(25,1,'2539 Diamonds',491552,0,'27,23,23','diamond','2021-06-16 20:57:16','2021-06-16 20:57:16'),(26,1,'2900 Diamonds',552822,0,'27,26','diamond','2021-06-16 20:57:47','2021-06-16 20:57:47'),(27,1,'3072 Diamonds',587635,0,'27,26,23','diamond','2021-06-16 20:58:31','2021-06-16 20:58:31'),(28,1,'3688 Diamonds',687895,0,'28','diamond','2021-06-16 20:58:58','2021-06-16 20:58:58'),(29,1,'4032 Diamonds',738025,0,'28,23,23','diamond','2021-06-16 20:59:28','2021-06-16 20:59:28'),(30,1,'4388 Diamonds',827145,0,'27,27','diamond','2021-06-16 20:59:50','2021-06-16 20:59:50'),(31,1,'5532 Diamonds',1033235,0,'29','diamond','2021-06-16 21:01:11','2021-06-16 21:01:11'),(32,1,'6238 Diamonds',1172485,0,'29,26','diamond','2021-06-16 21:01:54','2021-06-16 21:01:54'),(33,1,'7376 Diamonds',1375790,0,'28,28','diamond','2021-06-16 21:02:31','2021-06-16 21:02:31'),(35,1,'8432 Diamonds',1738675,0,'29,27,13','diamond','2021-06-16 21:04:14','2021-06-16 21:04:14'),(36,1,'Starlight Member',116970,0,'32','diamond','2021-06-16 21:13:31','2021-06-16 21:13:31'),(37,1,'Twilight Pass',116970,0,'33','diamond','2021-06-16 21:13:53','2021-06-16 21:13:53'),(38,1,'Starlight Plus',261790,0,'34','diamond','2021-06-16 21:14:17','2021-06-16 21:14:17');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
