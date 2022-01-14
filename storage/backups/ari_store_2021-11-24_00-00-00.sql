-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: ari_store
-- ------------------------------------------------------
-- Server version	8.0.19

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'administrator',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `admins`
--

LOCK TABLES `admins` WRITE;
/*!40000 ALTER TABLE `admins` DISABLE KEYS */;
INSERT INTO `admins` VALUES (1,'admin','arisawali2020@gmail.com','$2y$10$AwNGD8b89Fcl32jwo2j0FuwxBZ8wgBJ7M4HiDLMPgjcaSMjnmVlga','https://telegra.ph/file/afff078d543e562fdd2f8.png','administrator','2021-10-04 08:38:35','2021-11-15 03:32:18','Ari Sawali','6289651157752');
/*!40000 ALTER TABLE `admins` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `auto_order_acc`
--

DROP TABLE IF EXISTS `auto_order_acc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `auto_order_acc` (
  `account` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `cookie` text COLLATE utf8mb4_unicode_ci,
  `token` text COLLATE utf8mb4_unicode_ci,
  `otp_key` text COLLATE utf8mb4_unicode_ci,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `product_id` int NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `auto_order_acc`
--

LOCK TABLES `auto_order_acc` WRITE;
/*!40000 ALTER TABLE `auto_order_acc` DISABLE KEYS */;
INSERT INTO `auto_order_acc` VALUES ('smile',NULL,NULL,'4jspqcoic3nhnkksvdumeomha1',NULL,NULL,1,1),('kiosgamer','kinterstore1','Arvinfk711@',NULL,'74004746515bb2346e9c8be064684ecc21981fcee27c47a89c16fa9f8f410272','6LENCRPSOOTCYIYJ',1,2),('kiosgamercodm','amishopee','AsdgF32!',NULL,'e5e0056c780ffc1eec0de728225ab19068feab70b3a252470acb1051dd2986eb',NULL,1,8),('kiosgameraov','amishopee','AsdgF32!',NULL,'6cbe73ae2256a5831f50666704ade06a3840b4144cd23e604f665c345973bad2','LFVMPKUXK5JMI44L',1,9);
/*!40000 ALTER TABLE `auto_order_acc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `carousels`
--

DROP TABLE IF EXISTS `carousels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `carousels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `img` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '1',
  `ordered` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `carousels`
--

LOCK TABLES `carousels` WRITE;
/*!40000 ALTER TABLE `carousels` DISABLE KEYS */;
/*!40000 ALTER TABLE `carousels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categories`
--

DROP TABLE IF EXISTS `categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categories` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ordered` int NOT NULL DEFAULT '0',
  `active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (1,'fast','Instant',NULL,'2021-10-25 09:51:40','2021-11-15 07:26:30',1,1),(2,'voucher','Voucher Kilat',NULL,'2021-11-15 04:22:16','2021-11-15 07:26:30',2,1);
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_deletion`
--

DROP TABLE IF EXISTS `data_deletion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `data_deletion` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` int DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_deletion`
--

LOCK TABLES `data_deletion` WRITE;
/*!40000 ALTER TABLE `data_deletion` DISABLE KEYS */;
/*!40000 ALTER TABLE `data_deletion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
INSERT INTO `failed_jobs` VALUES (19,'e4bee395-1ffd-42cf-832b-a7b611a27d71','database','default','{\"uuid\":\"e4bee395-1ffd-42cf-832b-a7b611a27d71\",\"displayName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\KiosGamerOrderJob\\\":13:{s:17:\\\"\\u0000*\\u0000invoice_number\\\";i:88847483743;s:7:\\\"\\u0000*\\u0000data\\\";a:1:{i:0;a:3:{s:2:\\\"id\\\";s:16:\\\"1904997580014749\\\";s:6:\\\"amount\\\";s:2:\\\"40\\\";s:4:\\\"game\\\";s:3:\\\"aov\\\";}}s:9:\\\"\\u0000*\\u0000idakun\\\";s:13:\\\"6289651157752\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Undefined index: result in C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php:73\nStack trace:\n#0 C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php(73): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'C:\\\\xampp\\\\htdocs...\', 73, Array)\n#1 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KiosGamerOrderJob->handle()\n#2 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#4 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#5 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#6 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#7 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#8 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#9 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(118): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KiosGamerOrderJob), false)\n#11 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#12 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#13 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KiosGamerOrderJob))\n#15 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#16 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(410): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(360): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(158): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#21 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#24 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#25 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#26 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#27 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Command\\Command.php(256): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(971): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(290): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(166): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(92): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 C:\\xampp\\htdocs\\ari_store\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 {main}','2021-11-19 10:09:11'),(20,'07f48f61-8e3b-451c-9960-a39890777dc7','database','default','{\"uuid\":\"07f48f61-8e3b-451c-9960-a39890777dc7\",\"displayName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\KiosGamerOrderJob\\\":13:{s:17:\\\"\\u0000*\\u0000invoice_number\\\";i:88847483743;s:7:\\\"\\u0000*\\u0000data\\\";a:1:{i:0;a:3:{s:2:\\\"id\\\";s:16:\\\"1904997580014749\\\";s:6:\\\"amount\\\";s:2:\\\"40\\\";s:4:\\\"game\\\";s:3:\\\"aov\\\";}}s:9:\\\"\\u0000*\\u0000idakun\\\";s:13:\\\"6289651157752\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Undefined index: result in C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php:73\nStack trace:\n#0 C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php(73): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'C:\\\\xampp\\\\htdocs...\', 73, Array)\n#1 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KiosGamerOrderJob->handle()\n#2 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#4 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#5 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#6 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#7 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#8 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#9 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(118): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KiosGamerOrderJob), false)\n#11 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#12 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#13 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KiosGamerOrderJob))\n#15 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#16 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(410): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(360): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(158): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#21 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#24 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#25 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#26 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#27 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Command\\Command.php(256): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(971): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(290): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(166): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(92): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 C:\\xampp\\htdocs\\ari_store\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 {main}','2021-11-19 10:12:03'),(21,'576c019b-37e1-438e-83d6-4d9cde3d71aa','database','default','{\"uuid\":\"576c019b-37e1-438e-83d6-4d9cde3d71aa\",\"displayName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\KiosGamerOrderJob\\\":13:{s:17:\\\"\\u0000*\\u0000invoice_number\\\";i:88847483743;s:7:\\\"\\u0000*\\u0000data\\\";a:1:{i:0;a:3:{s:2:\\\"id\\\";s:16:\\\"1904997580014749\\\";s:6:\\\"amount\\\";s:2:\\\"40\\\";s:4:\\\"game\\\";s:3:\\\"aov\\\";}}s:9:\\\"\\u0000*\\u0000idakun\\\";s:13:\\\"6289651157752\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Undefined index: result in C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php:73\nStack trace:\n#0 C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php(73): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'C:\\\\xampp\\\\htdocs...\', 73, Array)\n#1 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KiosGamerOrderJob->handle()\n#2 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#4 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#5 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#6 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#7 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#8 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#9 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(118): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KiosGamerOrderJob), false)\n#11 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#12 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#13 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KiosGamerOrderJob))\n#15 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#16 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(410): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(360): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(158): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#21 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#24 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#25 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#26 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#27 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Command\\Command.php(256): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(971): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(290): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(166): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(92): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 C:\\xampp\\htdocs\\ari_store\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 {main}','2021-11-19 10:12:08'),(22,'90c7a78e-474e-420d-a545-cfee97125240','database','default','{\"uuid\":\"90c7a78e-474e-420d-a545-cfee97125240\",\"displayName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\KiosGamerOrderJob\\\":13:{s:17:\\\"\\u0000*\\u0000invoice_number\\\";i:88847483743;s:7:\\\"\\u0000*\\u0000data\\\";a:1:{i:0;a:3:{s:2:\\\"id\\\";s:16:\\\"1904997580014749\\\";s:6:\\\"amount\\\";s:2:\\\"40\\\";s:4:\\\"game\\\";s:3:\\\"aov\\\";}}s:9:\\\"\\u0000*\\u0000idakun\\\";s:13:\\\"6289651157752\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Undefined index: result in C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php:74\nStack trace:\n#0 C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php(74): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'C:\\\\xampp\\\\htdocs...\', 74, Array)\n#1 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KiosGamerOrderJob->handle()\n#2 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#4 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#5 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#6 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#7 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#8 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#9 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(118): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KiosGamerOrderJob), false)\n#11 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#12 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#13 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KiosGamerOrderJob))\n#15 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#16 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(410): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(360): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(158): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#21 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#24 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#25 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#26 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#27 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Command\\Command.php(256): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(971): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(290): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(166): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(92): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 C:\\xampp\\htdocs\\ari_store\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 {main}','2021-11-19 10:14:02'),(23,'04057282-059a-4fd8-a413-bca8c06a1526','database','default','{\"uuid\":\"04057282-059a-4fd8-a413-bca8c06a1526\",\"displayName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\KiosGamerOrderJob\",\"command\":\"O:26:\\\"App\\\\Jobs\\\\KiosGamerOrderJob\\\":13:{s:17:\\\"\\u0000*\\u0000invoice_number\\\";i:88847483743;s:7:\\\"\\u0000*\\u0000data\\\";a:1:{i:0;a:3:{s:2:\\\"id\\\";s:16:\\\"1904997580014749\\\";s:6:\\\"amount\\\";s:2:\\\"40\\\";s:4:\\\"game\\\";s:3:\\\"aov\\\";}}s:9:\\\"\\u0000*\\u0000idakun\\\";s:13:\\\"6289651157752\\\";s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}','ErrorException: Undefined index: result in C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php:74\nStack trace:\n#0 C:\\xampp\\htdocs\\ari_store\\app\\Jobs\\KiosGamerOrderJob.php(74): Illuminate\\Foundation\\Bootstrap\\HandleExceptions->handleError(8, \'Undefined index...\', \'C:\\\\xampp\\\\htdocs...\', 74, Array)\n#1 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): App\\Jobs\\KiosGamerOrderJob->handle()\n#2 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#3 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#4 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#5 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#6 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(128): Illuminate\\Container\\Container->call(Array)\n#7 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#8 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#9 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Bus\\Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#10 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(118): Illuminate\\Bus\\Dispatcher->dispatchNow(Object(App\\Jobs\\KiosGamerOrderJob), false)\n#11 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#12 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(App\\Jobs\\KiosGamerOrderJob))\n#13 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))\n#14 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(App\\Jobs\\KiosGamerOrderJob))\n#15 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Jobs\\Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Array)\n#16 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(410): Illuminate\\Queue\\Jobs\\Job->fire()\n#17 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(360): Illuminate\\Queue\\Worker->process(\'database\', Object(Illuminate\\Queue\\Jobs\\DatabaseJob), Object(Illuminate\\Queue\\WorkerOptions))\n#18 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Worker.php(158): Illuminate\\Queue\\Worker->runJob(Object(Illuminate\\Queue\\Jobs\\DatabaseJob), \'database\', Object(Illuminate\\Queue\\WorkerOptions))\n#19 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon(\'database\', \'default\', Object(Illuminate\\Queue\\WorkerOptions))\n#20 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Queue\\Console\\WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker(\'database\', \'default\')\n#21 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#22 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#23 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure(Object(Closure))\n#24 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod(Object(Illuminate\\Foundation\\Application), Array, Object(Closure))\n#25 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Container\\Container.php(611): Illuminate\\Container\\BoundMethod::call(Object(Illuminate\\Foundation\\Application), Array, Array, NULL)\n#26 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(136): Illuminate\\Container\\Container->call(Array)\n#27 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Command\\Command.php(256): Illuminate\\Console\\Command->execute(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#28 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Command.php(121): Symfony\\Component\\Console\\Command\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Illuminate\\Console\\OutputStyle))\n#29 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(971): Illuminate\\Console\\Command->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#30 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(290): Symfony\\Component\\Console\\Application->doRunCommand(Object(Illuminate\\Queue\\Console\\WorkCommand), Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#31 C:\\xampp\\htdocs\\ari_store\\vendor\\symfony\\console\\Application.php(166): Symfony\\Component\\Console\\Application->doRun(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#32 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Console\\Application.php(92): Symfony\\Component\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#33 C:\\xampp\\htdocs\\ari_store\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Console\\Kernel.php(129): Illuminate\\Console\\Application->run(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#34 C:\\xampp\\htdocs\\ari_store\\artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle(Object(Symfony\\Component\\Console\\Input\\ArgvInput), Object(Symfony\\Component\\Console\\Output\\ConsoleOutput))\n#35 {main}','2021-11-19 10:19:03');
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `form_inputs`
--

DROP TABLE IF EXISTS `form_inputs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `form_inputs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `placeholder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ordered` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `form_inputs_product_id_foreign` (`product_id`),
  CONSTRAINT `form_inputs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `form_inputs`
--

LOCK TABLES `form_inputs` WRITE;
/*!40000 ALTER TABLE `form_inputs` DISABLE KEYS */;
INSERT INTO `form_inputs` VALUES (1,1,'userId','User ID','number','Please Input User ID','2021-10-04 08:38:36','2021-10-04 08:38:36',0),(2,1,'serverid','Server ID','number','Please Input Server ID','2021-10-04 08:38:36','2021-10-04 08:38:36',0),(4,3,'userid','User ID','text','User ID','2021-10-08 03:07:15','2021-10-08 03:07:15',0),(8,2,'userId','User ID','number','User ID','2021-10-28 07:33:42','2021-10-28 07:33:42',0),(10,8,'openid','Open ID','number','Open ID','2021-11-12 03:15:15','2021-11-12 03:15:15',0),(11,9,'openID','Open ID','number','Open ID','2021-11-19 04:28:22','2021-11-19 04:28:22',0);
/*!40000 ALTER TABLE `form_inputs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `invoices`
--

DROP TABLE IF EXISTS `invoices`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `invoices` (
  `invoice_number` bigint NOT NULL,
  `payment_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` bigint unsigned DEFAULT NULL,
  `number` bigint DEFAULT NULL,
  `product_data_id` int NOT NULL,
  `product_data_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `product_id` int NOT NULL,
  `product_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` bigint NOT NULL,
  `fee` int NOT NULL DEFAULT '0',
  `rates` int NOT NULL DEFAULT '1',
  `discount` int NOT NULL DEFAULT '0',
  `type_data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_input` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expired_at` timestamp NOT NULL DEFAULT ((now() + interval 1 day)),
  PRIMARY KEY (`invoice_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `invoices`
--

LOCK TABLES `invoices` WRITE;
/*!40000 ALTER TABLE `invoices` DISABLE KEYS */;
INSERT INTO `invoices` VALUES (176464,NULL,1,NULL,151,'TOPUP90000',152,'Top Up 90000',90000,864,1,0,NULL,'','bca','PAID','2021-11-23 08:05:03','2021-11-24 08:05:03'),(256487,NULL,1,NULL,151,'TOPUP20000',152,'Top Up 20000',20000,388,1,0,NULL,'','bca','PENDING','2021-11-23 08:01:15','2021-11-24 08:01:15'),(591297,NULL,1,NULL,5,'60 Candy',3,'Sausage Man',13000,492,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','PENDING','2021-11-23 08:00:41','2021-11-24 08:00:41'),(10133598566,'T69361175449IRXDZ',1,NULL,151,'TOPUP300000',152,'Top Up 300000',300000,2850,1,0,NULL,'','tripay-QRISC','EXPIRED','2021-10-15 02:25:10','2021-10-16 02:25:10'),(12985178567,'T69361171304PZVZR',NULL,6289651157752,6,'9288 Diamonds',1,'Mobile Legends',15855,861,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','tripay-QRISC','EXPIRED','2021-10-14 01:05:43','2021-10-15 01:05:43'),(18312525470,NULL,1,NULL,151,'TOPUP10000',152,'Top Up 10000',10000,373,1,0,NULL,'','bca','PAID','2021-11-15 03:23:05','2021-11-16 03:23:05'),(23447828481,NULL,NULL,6289651157752,2,'172 Diamonds',1,'Mobile Legends',34500,682,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','bca','PROGRESS','2021-11-12 03:25:19','2021-11-13 03:25:19'),(25196553189,NULL,NULL,6289651157752,5,'60 Candy',3,'Sausage Man',13841,415,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','EXPIRED','2021-10-11 06:34:46','2021-10-12 06:34:46'),(25303847219,NULL,1,NULL,6,'9288 Diamonds',1,'Mobile Legends',0,377,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','bca','EXPIRED','2021-10-25 08:59:38','2021-10-26 08:59:38'),(26276877466,'T69361175450ZYRJY',1,NULL,151,'TOPUP300000',152,'Top Up 300000',300000,2850,1,0,NULL,'','tripay-QRISC','EXPIRED','2021-10-15 02:25:44','2021-10-16 02:25:44'),(34730981708,NULL,NULL,6289651157752,5,'60 Candy',3,'Sausage Man',13841,587,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','EXPIRED','2021-10-13 02:45:29','2021-10-14 02:45:29'),(36059632304,NULL,1,NULL,12,'1 bulan',7,'Netflix',20000,462,1,0,NULL,'','bca','DONE','2021-10-29 17:43:01','2021-10-30 17:43:01'),(36193453668,NULL,NULL,6289651157752,12,'1 bulan',7,'Netflix',20000,368,1,0,NULL,'null','bca','EXPIRED','2021-10-29 17:43:47','2021-10-30 17:43:47'),(37903485692,'T69361151552UOZOA',1,NULL,5,'60 Candy',3,'Sausage Man',13000,4250,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','tripay-BCAVA','EXPIRED','2021-10-08 08:01:16','2021-10-09 08:01:16'),(41356164359,'T69361151364TC5XC',1,NULL,5,'60 Candy',3,'Sausage Man',13000,841,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','tripay-QRISC','EXPIRED','2021-10-08 06:57:35','2021-10-09 06:57:35'),(43956417129,NULL,1,NULL,151,'TOPUP300000',152,'Top Up 300000',300000,739,1,0,NULL,'','tripay-QRISC','EXPIRED','2021-10-15 02:15:56','2021-10-16 02:15:56'),(45272317798,NULL,1,NULL,11,'35000',6,'Steam Voucher',36000,0,1,0,NULL,'','saldo','DONE','2021-10-29 02:42:48','2021-10-30 02:42:48'),(50468416245,NULL,1,NULL,4,'5 Diamond',2,'Free Fire',0,823,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"4079848840\"}]','bca','EXPIRED','2021-10-07 07:30:15','2021-10-08 07:30:15'),(55562119099,NULL,1,NULL,11,'35000',6,'Steam Voucher',36000,0,1,0,NULL,'','saldo','DONE','2021-10-29 02:13:51','2021-10-30 02:13:51'),(61127066385,NULL,NULL,6289651157752,5,'60 Candy',3,'Sausage Man',13841,894,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','EXPIRED','2021-10-11 06:11:18','2021-10-12 06:11:18'),(61759184533,NULL,NULL,6289651157752,5,'60 Candy',3,'Sausage Man',13841,177,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','EXPIRED','2021-10-13 02:42:06','2021-10-14 02:42:06'),(62901415701,NULL,1,NULL,1,'86 Diamonds',1,'Mobile Legends',17000,384,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','bca','DONE','2021-10-04 08:39:43','2021-10-05 08:39:43'),(64061605502,NULL,1,NULL,6,'9288 Diamonds',1,'Mobile Legends',15021,320,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','bca','EXPIRED','2021-10-25 08:24:08','2021-10-26 08:24:08'),(68576792717,'1976808',1,NULL,1,'86 Diamonds',1,'Mobile Legends',17000,860,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','bca','DONE','2021-10-04 08:38:36','2021-10-05 08:38:36'),(71854980077,NULL,1,NULL,5,'60 Candy',3,'Sausage Man',13000,733,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','EXPIRED','2021-10-15 03:26:03','2021-10-16 03:26:03'),(73842864241,NULL,NULL,6289651157752,5,'60 Candy',3,'Sausage Man',13841,907,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','EXPIRED','2021-10-13 02:43:43','2021-10-14 02:43:43'),(78798516108,NULL,1,NULL,5,'60 Candy',3,'Sausage Man',13000,763,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','PAID','2021-11-23 07:18:03','2021-11-24 07:18:03'),(80835951066,NULL,1,NULL,4,'5 Diamond',2,'Free Fire',0,351,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"4079848840\"}]','bca','EXPIRED','2021-10-07 03:45:00','2021-10-08 03:45:00'),(82749838398,NULL,1,NULL,14,'CP × 106 + Bonus 6',8,'Call of Duty Mobile',18150,806,1,0,NULL,'[{\"name\":\"openid\",\"value\":\"6740385566860608233\"}]','bca','DONE','2021-11-17 07:58:22','2021-11-18 07:58:22'),(84672553794,NULL,1,NULL,11,'35000',6,'Steam Voucher',36000,0,1,0,NULL,'','saldo','DONE','2021-10-29 02:52:33','2021-10-30 02:52:33'),(85510321948,NULL,1,NULL,6,'9288 Diamonds',1,'Mobile Legends',15021,810,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','bca','EXPIRED','2021-10-25 08:25:10','2021-10-26 08:25:10'),(86043706481,NULL,1,NULL,12,'1 bulan',7,'Netflix',20000,655,1,0,NULL,'','bca','DONE','2021-10-29 04:27:03','2021-10-30 04:27:03'),(87116222275,NULL,1,NULL,13,'CP × 53',8,'Call of Duty Mobile',9075,0,1,0,NULL,'[{\"name\":\"openid\",\"value\":\"6740385566860608233\"}]','saldo','DONE','2021-11-18 03:10:54','2021-11-19 03:10:54'),(87916878370,NULL,1,NULL,6,'9288 Diamonds',1,'Mobile Legends',15021,609,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','bca','EXPIRED','2021-10-25 08:22:06','2021-10-26 08:22:06'),(88347636483,NULL,NULL,6289651157752,5,'60 Candy',3,'Sausage Man',13000,510,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','DONE','2021-11-17 03:40:56','2021-11-18 03:40:56'),(88847483743,NULL,1,NULL,15,'40 Voucher',9,'Arena of Valor',15000,0,1,0,NULL,'[{\"name\":\"openID\",\"value\":\"1904997580014749\"}]','saldo','DONE','2021-11-19 10:08:45','2021-11-20 10:08:45'),(89167177948,NULL,NULL,6289651157752,12,'1 bulan',7,'Netflix',20000,330,1,0,NULL,'','bca','DONE','2021-10-29 17:45:46','2021-10-30 17:45:46'),(89269088120,NULL,NULL,6289651157752,5,'60 Candy',3,'Sausage Man',13841,594,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"7yisre\"}]','bca','EXPIRED','2021-10-13 02:35:38','2021-10-14 02:35:38'),(92546080095,NULL,1,NULL,1,'86 Diamonds',1,'Mobile Legends',0,0,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"30723382\"},{\"name\":\"serverid\",\"value\":\"2043\"}]','saldo','DONE','2021-11-19 09:53:53','2021-11-20 09:53:53'),(95736009231,NULL,1,NULL,11,'35000',6,'Steam Voucher',36000,0,1,0,NULL,'','saldo','EXPIRED','2021-10-29 02:09:25','2021-10-30 02:09:25'),(96877701313,NULL,1,NULL,11,'35000',6,'Steam Voucher',36000,0,1,0,NULL,'','saldo','EXPIRED','2021-10-29 02:10:05','2021-10-30 02:10:05'),(97260847858,NULL,1,NULL,11,'35000',6,'Steam Voucher',36000,0,1,0,NULL,'','saldo','EXPIRED','2021-10-29 02:08:02','2021-10-30 02:08:02'),(98726953786,NULL,NULL,6289651157752,4,'5 Diamond',2,'Free Fire',0,194,1,0,NULL,'[{\"name\":\"userid\",\"value\":\"4079848840\"}]','bca','EXPIRED','2021-10-07 07:27:15','2021-10-08 07:27:15'),(99976058028,NULL,NULL,6289651157752,12,'1 bulan',7,'Netflix',20000,146,1,0,NULL,'null','bca','EXPIRED','2021-10-29 17:43:19','2021-10-30 17:43:19');
/*!40000 ALTER TABLE `invoices` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `jobs`
--

DROP TABLE IF EXISTS `jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `jobs`
--

LOCK TABLES `jobs` WRITE;
/*!40000 ALTER TABLE `jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (39,'2014_10_00_000000_create_settings_table',1),(40,'2014_10_00_000001_add_group_column_on_settings_table',1),(41,'2014_10_12_000000_create_users_table',1),(42,'2019_08_19_000000_create_failed_jobs_table',1),(43,'2021_04_13_090030_create_products_table',1),(44,'2021_04_13_090505_create_product_data_table',1),(45,'2021_04_13_092219_create_invoices_table',1),(46,'2021_04_13_100348_create_temp_otp_table',1),(47,'2021_04_13_100651_create_admins_table',1),(48,'2021_04_19_043331_create_carousel_table',1),(49,'2021_06_02_091045_create_form_table',1),(50,'2021_06_03_095801_create_data_deletion_table',1),(51,'2021_06_10_083102_create_whatsapp_gate_table',1),(52,'2021_06_15_021413_create_paygate_table',1),(53,'2021_06_15_033116_create_usertype_table',1),(54,'2021_06_16_062409_create_mutation_table',1),(55,'2021_06_29_113342_create_jobs_table',1),(56,'2021_06_29_132647_create_smile_acc_table',1),(57,'2021_10_06_081841_update_table_product_data',2),(58,'2021_10_06_085617_update_table_admins',3),(59,'2021_10_12_103319_update_table_carousels',4),(63,'2021_10_13_114604_create_table_temp_forgot',5),(67,'2021_10_19_151427_create_table_auto_order_acc',6),(68,'2021_10_25_161921_update_table_product_and_auto_order_acc',7),(70,'2021_10_25_164424_create_table_categories',8),(72,'2021_10_26_104056_create_table_voucher_data',9),(73,'2021_11_12_164434_update_all_table_with_ordered',10),(74,'2021_11_15_112923_adding_active_state_to_categories',11);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mutation`
--

DROP TABLE IF EXISTS `mutation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mutation` (
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mutationDate` date DEFAULT NULL,
  `mutationNote` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mutationStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mutationAmount` bigint DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mutation`
--

LOCK TABLES `mutation` WRITE;
/*!40000 ALTER TABLE `mutation` DISABLE KEYS */;
INSERT INTO `mutation` VALUES ('bca','2021-09-28','KR OTOMATIS; SMEMFTS EFT32794 INDOMARCO PRISMATA2015213379 00012111','CR',3956100,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95031; 11281- HOME CREDIT; -; -; 4100103834;','DB',1480900,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',650000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95221; 61001- ONEKLIK GOPA; -; -; 10FD6625D18C4F64D8;','DB',321520,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95031; 12308- SPAYLATER; -; -; 07201066741;','DB',101852,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95031; 39988- BY.U; -; -; 000000000004704217;','DB',120000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',100000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TARIKAN ATM 28- 09; 089651157752','DB',250000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',150000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING CR; 2809- FTSCY- WS95051; 100000.00; 2021092843047021; TRFDN-MUHAMAD ARI; ESPAY DEBIT INDONE;','CR',100000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING CR; 2809- FTSCY- WS95051; 150000.00; 2021092848704921; TRFDN-MUHAMAD ARI; ESPAY DEBIT INDONE;','CR',150000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','TRSF E-BANKING DB; 2809- FTFVA- WS95221; 61001- ONEKLIK GOPA; -; -; 7E6CDF5DBB6D463348;','DB',50000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-28','KARTU DEBIT 28- 09; RICHEESE FACTORY S6019007507897487','DB',90000,'2021-10-27 07:46:39','2021-10-27 07:46:39'),('bca','2021-09-29','TRSF E-BANKING DB; 2909- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',100000,'2021-10-27 07:46:39','2021-10-29 07:00:03'),('bca','2021-10-01','TARIKAN ATM 01- 10; 6019007507897487','DB',100000,'2021-10-27 07:46:39','2021-10-31 16:50:02'),('bca','2021-10-01','TARIKAN ATM 01- 10; 6019007507897487','DB',50000,'2021-10-27 07:46:39','2021-10-31 16:50:02'),('bca','2021-10-01','TRANSAKSI DEBIT; TGL: 1001 QR 912 Thai Tea yuk','DB',5000,'2021-10-27 07:46:39','2021-10-31 16:50:02'),('bca','2021-10-04','KARTU DEBIT 02- 10; IDM T0GH-CIKUYA BA6019007507897487','DB',361000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','SETORAN VIA CDM; TANGGAL :02- 10 02- 10 WSID:Z0JM1 MUHAMAD ARI SAWALI','CR',300000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TRSF E-BANKING DB; 10- 02 95031; VAPE; SENDI MUHAMAD IKHS;','DB',250000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TRANSAKSI DEBIT; TGL: 1002 QR 911 KAI','DB',90000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','SWITCHING CR; TANGGAL :02- 10 TRANSFER DR 886 AISYAH FITRI KANIADana','CR',100000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TRANSAKSI DEBIT; TGL: 1003 QR 153 RAPID ANTIGEN STAS','DB',45000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TRANSAKSI DEBIT; TGL: 1003 QR 912 Thai Tea yuk','DB',16000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TARIKAN ATM 04- 10; 6019007507897487','DB',50000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TRSF E-BANKING CR; 10- 04 95031; DP MOBIL; FAHMI FADILAH;','CR',500000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','DB OTOMATIS; B.ADM.KRG BYR 0921','DB',2032,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TRSF E-BANKING CR; 0410- FTSCY- WS95051; 120000.00; 2021100404269521; TRFDN-MUHAMAD ARI; ESPAY DEBIT INDONE;','CR',120000,'2021-10-27 07:46:39','2021-11-01 06:00:01'),('bca','2021-10-04','TRSF E-BANKING DB; 10- 04 95031; SENDI MUHAMAD IKHS;','DB',20000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-04','TRSF E-BANKING DB; 0410- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-05','TARIKAN ATM 05- 10; 6019007507897487','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-07','TRSF E-BANKING CR; 0710- FTSCY- WS95051; 600000.00; 2021100721370462; TRFDN-AISYAH FITRI; ESPAY DEBIT INDONE;','CR',600000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-07','TRSF E-BANKING DB; 0710- FTFVA- WS95031; 70001- GO-PAY CUSTO; -; -; 089651157752;','DB',601000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-08','TARIKAN ATM 08- 10; 6019007507897487','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-08','TRSF E-BANKING CR; 10- 08 95031; P2; FAHMI FADILAH;','CR',1000000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-08','TRSF E-BANKING DB; 0810- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',200000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-08','TRANSAKSI DEBIT; TGL: 1008 QR 912 Thai Tea yuk','DB',5000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-11','TARIKAN ATM 10- 10; 089651157752','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-11','SETORAN VIA CDM; 11- 10 WSID:ZN7L1 MUHAMAD ARI SAWALI','CR',1000000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-12','BIAYA KARTU ATM; BIAYA KARTU ATM','DB',10000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-12','TRSF E-BANKING DB; 1210- FTFVA- WS95031; 70001- GO-PAY CUSTO; -; -; 089651157752;','DB',81000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-12','TARIKAN ATM 12- 10; 5379412081021023','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-13','TARIKAN ATM 13- 10; 5379412081021023','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-14','TRSF E-BANKING DB; 1410- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-14','TRSF E-BANKING CR; 1410- FTSCY- WS95051; 80000.00; 2021101404571962; TRFDN-AISYAH FITRI; ESPAY DEBIT INDONE;','CR',80000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-15','SWITCHING DB; TRANSFER KE 542 MUHAMAD ARI SAWALIM-BCA','DB',1000000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-15','SWITCHING DB; BIAYA TXN KE 542 MUHAMAD ARI SAWALIM-BCA','DB',6500,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-15','TRSF E-BANKING CR; 10- 15 95031; FAHMI FADILAH;','CR',1000000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-15','SWITCHING DB; TRANSFER KE 542 MUHAMAD ARI SAWALIM-BCA','DB',1300000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-15','TARIKAN ATM 15- 10; 5379412081021023','DB',250000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-15','BIAYA ADM;','DB',15000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-18','TRSF E-BANKING CR; 10- 15 95031; NUHUN NYAA; ADI SULAEMAN;','CR',300000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-18','KARTU DEBIT 16- 10; IDM F1IL CIPAKU 5379412081021023','DB',110000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-18','TARIKAN ATM 18- 10; 5379412081021023','DB',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-18','KARTU DEBIT 17- 10; IDM TNHF-PADAULUN-5379412081021023','DB',160800,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-18','SWITCHING CR; TRANSFER DR 542 MUHAMAD ARI SAWALIACCOUNT INQ','CR',100000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-18','TRSF E-BANKING DB; 1810- FTFVA- WS95031; 12208- SHOPEEPAY; -; -; 9651157752;','DB',40500,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-21','SWITCHING CR; TANGGAL :20- 10 TRANSFER DR 542 MUHAMAD ARI SAWALIACCOUNT INQ','CR',200000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-21','TARIKAN ATM 20- 10; 5379412081021023','DB',200000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-27','SWITCHING CR; TANGGAL :26- 10 TRANSFER DR MULYATI INTERNET BA','CR',500000,'2021-10-27 07:46:40','2021-11-01 06:00:01'),('bca','2021-10-28','KR OTOMATIS; SMEMFTS EFT70644 INDOMARCO PRISMATA2015213379 00012111','CR',3814100,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','TRSF E-BANKING CR; 10- 28 Z4UY1; EKO SUPRIANTO;','CR',200000,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','TARIKAN ATM 28- 10; 5379412081021023','DB',100000,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','TRSF E-BANKING CR; 10- 28 95031; SHOPEE; SENDI MUHAMAD IKHS;','CR',113000,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','SWITCHING CR; TRANSFER DR 542 MUHAMAD ARI SAWALIACCOUNT INQ','CR',2000000,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','TRSF E-BANKING DB; 2810- FTFVA- WSZN7L1; 12608- SHOPEE; -; -; 9651157752;','DB',4916600,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','TRSF E-BANKING DB; 2810- FTFVA- WS95031; 12308- SPAYLATER; -; -; 07601127215;','DB',681736,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','TRSF E-BANKING DB; 2810- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',650000,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-28','TRSF E-BANKING DB; 2810- FTFVA- WS95031; 70022- PAYLATER AB; -; -; 094226;','DB',125000,'2021-10-29 02:40:02','2021-11-01 06:00:01'),('bca','2021-10-29','TARIKAN ATM 29- 10; 5379412081021023','DB',100000,'2021-10-29 17:50:02','2021-11-01 06:00:01'),('bca','2021-10-30','TRANSAKSI DEBIT; TGL: 1030 QR 915 00000.00Thai Tea Y','DB',8000,'2021-10-30 12:50:02','2021-10-30 16:50:03'),('bca','2021-10-31','TRANSAKSI DEBIT; TGL: 1030 QR 915 00000.00Thai Tea Y','DB',8000,'2021-10-30 17:00:01','2021-10-31 16:50:02'),('bca','2021-11-01','TRANSAKSI DEBIT; TGL: 1030 QR 915 00000.00Thai Tea Y','DB',8000,'2021-10-31 17:00:02','2021-11-01 06:00:01');
/*!40000 ALTER TABLE `mutation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paygate`
--

DROP TABLE IF EXISTS `paygate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paygate` (
  `payment` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `norek` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paygate`
--

LOCK TABLES `paygate` WRITE;
/*!40000 ALTER TABLE `paygate` DISABLE KEYS */;
INSERT INTO `paygate` VALUES ('bca','8100802172','MUHAMAD ARI SAWALI','UHAMADAR3432','402999',NULL,'https://cdnlogo.com/logos/b/32/bca-bank-central-asia.svg',1,'2021-10-04 08:38:36','2021-10-27 07:46:16'),('qris','296332',NULL,NULL,NULL,'NjMxMTg0MjpoUVJkbjlReGI2VndEbWdVeVlXY0dNd1M=','https://seeklogo.com/images/Q/quick-response-code-indonesia-standard-qris-logo-F300D5EB32-seeklogo.com.png',1,'2021-10-04 08:38:36','2021-10-04 08:38:36'),('tripay','T7856',NULL,'IxavfEkUoEvzpjbfIZL4FpeF7UGXCRAd3UZh26Yi',NULL,'k2sup-zVgYX-zJhwP-iev50-Kt8KQ',NULL,1,'2021-10-08 02:35:49','2021-11-17 09:03:38');
/*!40000 ALTER TABLE `paygate` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `product_data`
--

DROP TABLE IF EXISTS `product_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
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
  `active` tinyint(1) DEFAULT '1',
  `role_prices` longtext COLLATE utf8mb4_unicode_ci,
  `ordered` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `product_data_product_id_foreign` (`product_id`),
  CONSTRAINT `product_data_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `product_data`
--

LOCK TABLES `product_data` WRITE;
/*!40000 ALTER TABLE `product_data` DISABLE KEYS */;
INSERT INTO `product_data` VALUES (1,1,'86 Diamonds',17000,0,'86','diamond','2021-10-04 08:38:36','2021-11-18 03:09:00',1,'[{\"name\":\"member\",\"price\":\"15000\"},{\"name\":\"reseller\",\"price\":\"79764\"},{\"name\":\"silver\",\"price\":0},{\"name\":\"gold\",\"price\":0}]',3),(2,1,'172 Diamonds',34500,0,'172','diamond','2021-10-04 08:38:36','2021-11-18 03:09:00',1,'[{\"name\":\"member\",\"price\":\"34500\"},{\"name\":\"reseller\",\"price\":\"151254\"}]',4),(4,2,'5 Diamond',1000,1,'5','diamond','2021-10-06 06:49:45','2021-11-18 03:08:54',1,'[{\"name\":\"member\",\"price\":\"900\"},{\"name\":\"reseller\",\"price\":\"800\"},{\"name\":\"silver\",\"price\":0},{\"name\":\"gold\",\"price\":0}]',1),(5,3,'60 Candy',13000,1,NULL,'diamond','2021-10-08 03:07:43','2021-11-18 03:09:00',1,'[{\"name\":\"member\",\"price\":\"125123123\"},{\"name\":\"reseller\",\"price\":\"0\"}]',6),(6,1,'9288 Diamonds',15000,1,'9288','diamond','2021-10-14 01:03:11','2021-11-18 03:09:00',1,'[{\"name\":\"member\",\"price\":\"15021\"},{\"name\":\"reseller\",\"price\":0}]',5),(7,2,'720 Diamond',90000,1,'720','diamond','2021-10-22 07:21:33','2021-11-18 03:09:00',1,'[{\"name\":\"member\",\"price\":0},{\"name\":\"reseller\",\"price\":\"85000\"},{\"name\":\"silver\",\"price\":0},{\"name\":\"gold\",\"price\":0}]',2),(11,6,'35000',36000,1,NULL,'voucher','2021-10-27 08:07:32','2021-11-15 01:46:09',1,NULL,9),(12,7,'1 bulan',20000,1,NULL,'voucher','2021-10-29 04:18:02','2021-11-15 01:46:09',1,NULL,10),(13,8,'CP × 53',9075,1,'53','diamond','2021-11-12 03:17:35','2021-11-17 06:03:07',1,NULL,7),(14,8,'CP × 106 + Bonus 6',18150,1,'112','diamond','2021-11-12 03:18:07','2021-11-15 01:46:26',1,NULL,8),(15,9,'40 Voucher',15000,1,'40','diamond','2021-11-19 04:31:32','2021-11-19 04:31:32',1,NULL,0);
/*!40000 ALTER TABLE `product_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `products`
--

DROP TABLE IF EXISTS `products`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `subtitle` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `thumbnail` text COLLATE utf8mb4_unicode_ci,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL DEFAULT '0',
  `use_input` tinyint(1) NOT NULL DEFAULT '0',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `category` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci DEFAULT 'regular',
  `ordered` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `products`
--

LOCK TABLES `products` WRITE;
/*!40000 ALTER TABLE `products` DISABLE KEYS */;
INSERT INTO `products` VALUES (1,'Mobile Legends','Diamond Fast','<p>Cukup memasukan User ID dan Server ID, pilih nominal diamond yang \ndiinginkan, lakukan pembayaran. Diamonds Akan bertambah langsung ke akun\n    Mobile Legends Anda setelah pembayaran berhasil.\n<span style=\"font-weight: bold;\">Proses diamond <span style=\"color: rgb(255, 0, 0);\">5-30 detik</span> setelah pembayaran berhasil (otomatis)<br></span></p>\n','https://play-lh.googleusercontent.com/ha1vofCWS5lFhVe0gabwIetwjT4fUY5d6iDOP10KWRwnXci8lWI3ClxrqjoRuPZidg=s180-rw','mobile-legends-diamond-fast',1,1,'2021-10-04 08:38:36','2021-11-15 09:18:23','fast',1),(2,'Free Fire','Fast Diamonds','<p>Fast Diamonds</p>\n','https://telegra.ph/file/4a1168ac7bba27802555c.jpg','free-fire-fast-diamonds',1,1,'2021-10-06 06:37:06','2021-11-15 09:18:23','fast',2),(3,'Sausage Man','Candys','<p>Fast Candys</p>\n','https://telegra.ph/file/644e9194134b5fcc315ce.png','sausage-man-candys',1,1,'2021-10-08 03:07:15','2021-11-15 01:45:38','regular',4),(6,'Steam Voucher','Voucher murah!','<p>Voucher murah!</p>\n','https://telegra.ph/file/25ad3f672487fee6f784d.png','steam-voucher-voucher-murah',1,0,'2021-10-27 08:02:45','2021-11-15 07:23:16','voucher',6),(7,'Netflix','Akun Neflix shared premium','<p>Akun Neflix shared premium</p>\n','https://telegra.ph/file/ef932b8846d7851221e43.jpg','netflix-akun-neflix-shared-premium',1,0,'2021-10-29 04:15:40','2021-11-15 07:23:16','voucher',5),(8,'Call of Duty Mobile','Codm Point','<div>Layanan Ini Aktif 24 Jam dan Pengiriman Otomatis<ol><li>Masukkan <b>Open ID</b> akun Call Of Duty Mobile Anda</li><li>Pilih <b>Nominal Top Up</b></li><li>Pilih <b>Metode Pembayaran</b></li><li>Masukkan <b>Nomor WhatsApp</b> untuk notifikasi</li><li>Pilih <b>Beli Sekarang</b></li><li>Lakukan Pembayaran <b>sesuai yang dipilih</b></li><li>Pilihan Top Up Anda akan masuk secara otomatis</li></ol></div>\n','https://telegra.ph/file/b5b87817a98a77e3fd0f7.png','call-of-duty-mobile-codm-point',1,1,'2021-11-12 03:15:15','2021-11-15 09:18:23','fast',3),(9,'Arena of Valor','Aov Voucher','<p>AOV</p>\n','https://telegra.ph/file/02b7a12e572e3d0e931fa.jpg','arena-of-valor-aov-voucher',1,1,'2021-11-19 04:28:22','2021-11-19 04:28:22','fast',0);
/*!40000 ALTER TABLE `products` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `settings`
--

DROP TABLE IF EXISTS `settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `val` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `settings`
--

LOCK TABLES `settings` WRITE;
/*!40000 ALTER TABLE `settings` DISABLE KEYS */;
INSERT INTO `settings` VALUES (1,'app_name','Ari Store',NULL,NULL,'default'),(2,'logo','https://telegra.ph/file/e07aae10574984e69f416.png',NULL,'2021-10-05 03:48:47','default'),(3,'favicon','https://telegra.ph/file/1b1d222db208d6d977baa.png',NULL,'2021-10-06 06:52:50','default'),(4,'description','Ari Store adalah sebuah website tempat Top-up murah, aman dan terpercaya. Memiliki metode pembayaran lebih gampang dan terpercaya',NULL,NULL,'default'),(5,'company_name','Laskarmedia',NULL,NULL,'default'),(6,'fb_id',NULL,'2021-10-05 03:48:47','2021-10-05 03:48:47','default'),(7,'fb_secret',NULL,'2021-10-05 03:48:47','2021-10-05 03:48:47','default'),(8,'wahost','https://ari-wagate.herokuapp.com','2021-10-05 03:48:47','2021-11-15 04:53:11','default'),(9,'wagroup','6281414194417-1613753307@g.us','2021-10-05 03:48:47','2021-11-17 07:58:17','default'),(10,'captcha_sitekey','6LcDpLccAAAAAF0L73K829tVDOBOEWxtcvQp_8VX','2021-10-08 03:27:51','2021-10-08 03:27:51','default'),(11,'captcha_secret','6LcDpLccAAAAABS5JRIykdfUgklga6NrterJl8YD','2021-10-08 03:27:51','2021-10-08 03:27:51','default'),(12,'autoapi','https://ari-smile.herokuapp.com','2021-10-13 03:25:41','2021-11-15 04:53:11','default'),(13,'2captcha','8d19b37d81678b3bd0c2897c025e6ab3','2021-10-22 06:34:03','2021-10-25 07:17:52','default'),(14,'anticaptcha','c07cd9f7cb01c4274e40ef22f0f0fc73','2021-10-22 06:34:03','2021-10-22 06:34:03','default'),(15,'server_img','1','2021-11-15 04:53:11','2021-11-15 04:53:11','default');
/*!40000 ALTER TABLE `settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `smile_acc`
--

DROP TABLE IF EXISTS `smile_acc`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `smile_acc` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `smile_acc`
--

LOCK TABLES `smile_acc` WRITE;
/*!40000 ALTER TABLE `smile_acc` DISABLE KEYS */;
INSERT INTO `smile_acc` VALUES (1,'vk','6285155060559','arivk123123',1,'2021-10-04 08:42:43','2021-10-04 08:43:04');
/*!40000 ALTER TABLE `smile_acc` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_forgot`
--

DROP TABLE IF EXISTS `temp_forgot`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temp_forgot` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1',
  `expired_at` timestamp NOT NULL DEFAULT ((now() + interval 1 day)),
  PRIMARY KEY (`id`),
  UNIQUE KEY `temp_forgot_token_unique` (`token`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_forgot`
--

LOCK TABLES `temp_forgot` WRITE;
/*!40000 ALTER TABLE `temp_forgot` DISABLE KEYS */;
INSERT INTO `temp_forgot` VALUES (1,'arisawali2014','ec1e99d7-28e8-4e43-b65e-4b5adc561251','6289651157752','Forgot Password for arisawali2014',1,'2021-10-14 06:20:22');
/*!40000 ALTER TABLE `temp_forgot` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `temp_otp`
--

DROP TABLE IF EXISTS `temp_otp`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `temp_otp` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` int NOT NULL,
  `otp_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `temp_otp`
--

LOCK TABLES `temp_otp` WRITE;
/*!40000 ALTER TABLE `temp_otp` DISABLE KEYS */;
INSERT INTO `temp_otp` VALUES ('arisawali2014',4899,'login'),('ari2',4480,'regist');
/*!40000 ALTER TABLE `temp_otp` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `balance` int NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'member',
  `last_login` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expire_seller_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `avatar` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT 'https://image.flaticon.com/icons/png/512/149/149071.png',
  `provider` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `provider_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `access_token` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ordered` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Ari Sawali','arisawali2014','arisawali2014@gmail.com','6289651157752','$2y$10$uhv07KfEjWKblxIIsKjKqOB9tS8cfmHPO94U/H8NLXoKC7MB5ZvRC',100000,'gold','2021-11-23 07:11:02','2021-10-04 08:38:36','http://127.0.0.1:8000/assets/images/profile/APm1k.jpg',NULL,NULL,NULL,NULL,'2021-10-04 08:38:36','2021-11-23 08:07:20',0);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usertype`
--

DROP TABLE IF EXISTS `usertype`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usertype` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usertype`
--

LOCK TABLES `usertype` WRITE;
/*!40000 ALTER TABLE `usertype` DISABLE KEYS */;
INSERT INTO `usertype` VALUES (1,'member',0),(2,'reseller',2),(3,'silver',0),(4,'gold',0);
/*!40000 ALTER TABLE `usertype` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `voucher_data`
--

DROP TABLE IF EXISTS `voucher_data`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `voucher_data` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_data_id` bigint NOT NULL,
  `data` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `used` tinyint(1) NOT NULL DEFAULT '0',
  `purchased` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `purchased_at` timestamp NULL DEFAULT NULL,
  `expired_at` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `voucher_data`
--

LOCK TABLES `voucher_data` WRITE;
/*!40000 ALTER TABLE `voucher_data` DISABLE KEYS */;
INSERT INTO `voucher_data` VALUES (1,11,'ABC-DEF-GHI','<p>Berikut adalah voucher steam yang anda dapatkan:</p><p>silahkan klaim&nbsp;ABC-DEF-GHI</p>','purchased',1,'96877701313','2021-10-29 02:10:05','2021-10-31','2021-10-27 08:07:32','2021-10-29 02:10:05'),(2,11,'QWE-RTY-UIO','<p>Berikut adalah voucher steam yang anda dapatkan:</p><p>silahkan klaim&nbsp;QWE-RTY-UIO</p>','purchased',1,'55562119099','2021-10-29 02:13:51','2021-10-30','2021-10-27 08:07:32','2021-10-29 02:13:51'),(3,11,'ZXC-VBN-MAS','<p>Berikut adalah voucher steam&nbsp;ZXC-VBN-MAS</p>','purchased',1,'45272317798','2021-10-29 02:42:48','2021-10-31','2021-10-28 06:54:10','2021-10-29 02:42:48'),(6,12,'kasnf@gmail.com:123','<p>kasnf@gmail.com:123<br></p>','purchased',1,'36059632304','2021-10-29 17:47:53','2021-10-31','2021-10-29 17:40:16','2021-10-29 17:47:53');
/*!40000 ALTER TABLE `voucher_data` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wagate`
--

DROP TABLE IF EXISTS `wagate`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `wagate` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth` longtext COLLATE utf8mb4_unicode_ci,
  `user` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wagate`
--

LOCK TABLES `wagate` WRITE;
/*!40000 ALTER TABLE `wagate` DISABLE KEYS */;
INSERT INTO `wagate` VALUES ('xnB','{\"clientID\":\"EYHK4uEjyCXX5isW0HJ6mg==\",\"serverToken\":\"1@+2jKFJwrROz0HGNqwmBfrJCk0KVWudmrUY\\/L49Qq0\\/kzZbkPSLe+hWwkE0VfLrOWzZWAQNN6DHhqAw==\",\"clientToken\":\"JS5leL+MMmiHsGpkyqCShOwBo7ysBS0Kj7gv2zO9zGo=\",\"encKey\":\"9GcvhS77auvB5EAwU7NDKD5urSH+3pKFT8mfn1yT7ac=\",\"macKey\":\"wVorNZdaB6S390Wy3oCSmHG+WQBWEyx\\/4iA0rRP9QAE=\"}','{\"jid\":\"6285155060559@s.whatsapp.net\",\"name\":\"ARI-OTP\",\"phone\":{\"wa_version\":\"2.21.22.26\",\"mcc\":\"510\",\"mnc\":\"089\",\"os_version\":\"11\",\"device_manufacturer\":\"Xiaomi\",\"device_model\":\"alioth\",\"os_build_number\":\"RKQ1.200826.002 test-keys\"},\"imgUrl\":null}','2021-11-17 07:57:35');
/*!40000 ALTER TABLE `wagate` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2021-11-24  0:00:16
