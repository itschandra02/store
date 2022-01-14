/*
SQLyog Professional
MySQL - 8.0.25-0ubuntu0.20.04.1 : Database - ari_store
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
/*Table structure for table `admins` */

DROP TABLE IF EXISTS `admins`;

CREATE TABLE `admins` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `profile_pic` text COLLATE utf8mb4_unicode_ci,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'administrator',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `admins` */

insert  into `admins`(`id`,`username`,`email`,`password`,`profile_pic`,`status`,`created_at`,`updated_at`) values (1,'admin','arisawali2014@gmail.com','$2y$10$oNiboVOI2vjjKBZqID8nqO2K15KWlxhF1suiwM8qI5yOqHm/T2Ju2','https://avatars.githubusercontent.com/u/31904944?v=4','administrator','2021-07-09 03:01:50','2021-07-09 03:01:50');

/*Table structure for table `carousels` */

DROP TABLE IF EXISTS `carousels`;

CREATE TABLE `carousels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `link` text COLLATE utf8mb4_unicode_ci,
  `img` text COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `carousels` */

/*Table structure for table `data_deletion` */

DROP TABLE IF EXISTS `data_deletion`;

CREATE TABLE `data_deletion` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `provider` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `balance` int DEFAULT NULL,
  `code` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `data_deletion` */

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

insert  into `failed_jobs`(`id`,`uuid`,`connection`,`queue`,`payload`,`exception`,`failed_at`) values (1,'37365561-b7b6-4a77-9395-2d4b0232a89a','database','default','{\"uuid\":\"37365561-b7b6-4a77-9395-2d4b0232a89a\",\"displayName\":\"App\\\\Jobs\\\\SmileOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SmileOrderJob\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\SmileOrderJob\\\":13:{s:17:\\\"\\u0000*\\u0000invoice_number\\\";i:67318223908;s:7:\\\"\\u0000*\\u0000data\\\";a:1:{i:0;a:3:{s:2:\\\"id\\\";s:9:\\\"917666868\\\";s:6:\\\"server\\\";s:5:\\\"12622\\\";s:6:\\\"amount\\\";s:3:\\\"257\\\";}}s:9:\\\"\\u0000*\\u0000idakun\\\";i:6;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Jobs\\SmileOrderJob has been attempted too many times or run too long. The job may have previously timed out. in /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:717\nStack trace:\n#0 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(486): Illuminate\\Queue\\Worker->maxAttemptsExceededException()\n#1 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(400): Illuminate\\Queue\\Worker->markJobAsFailedIfAlreadyExceedsMaxAttempts()\n#2 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(360): Illuminate\\Queue\\Worker->process()\n#3 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(158): Illuminate\\Queue\\Worker->runJob()\n#4 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon()\n#5 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#6 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#7 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#8 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#9 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#10 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/Container.php(611): Illuminate\\Container\\BoundMethod::call()\n#11 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Console/Command.php(136): Illuminate\\Container\\Container->call()\n#12 /var/www/html/ari_store/vendor/symfony/console/Command/Command.php(256): Illuminate\\Console\\Command->execute()\n#13 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Console/Command.php(121): Symfony\\Component\\Console\\Command\\Command->run()\n#14 /var/www/html/ari_store/vendor/symfony/console/Application.php(971): Illuminate\\Console\\Command->run()\n#15 /var/www/html/ari_store/vendor/symfony/console/Application.php(290): Symfony\\Component\\Console\\Application->doRunCommand()\n#16 /var/www/html/ari_store/vendor/symfony/console/Application.php(166): Symfony\\Component\\Console\\Application->doRun()\n#17 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Console/Application.php(92): Symfony\\Component\\Console\\Application->run()\n#18 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(129): Illuminate\\Console\\Application->run()\n#19 /var/www/html/ari_store/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle()\n#20 {main}','2021-07-10 21:56:46'),(2,'efbf6d3b-7e03-42e1-829e-27c425377125','database','default','{\"uuid\":\"efbf6d3b-7e03-42e1-829e-27c425377125\",\"displayName\":\"App\\\\Jobs\\\\SmileOrderJob\",\"job\":\"Illuminate\\\\Queue\\\\CallQueuedHandler@call\",\"maxTries\":null,\"maxExceptions\":null,\"backoff\":null,\"timeout\":null,\"retryUntil\":null,\"data\":{\"commandName\":\"App\\\\Jobs\\\\SmileOrderJob\",\"command\":\"O:22:\\\"App\\\\Jobs\\\\SmileOrderJob\\\":13:{s:17:\\\"\\u0000*\\u0000invoice_number\\\";i:24567300921;s:7:\\\"\\u0000*\\u0000data\\\";a:1:{i:0;a:3:{s:2:\\\"id\\\";s:9:\\\"100975707\\\";s:6:\\\"server\\\";s:4:\\\"2517\\\";s:6:\\\"amount\\\";s:2:\\\"86\\\";}}s:9:\\\"\\u0000*\\u0000idakun\\\";i:5;s:3:\\\"job\\\";N;s:10:\\\"connection\\\";N;s:5:\\\"queue\\\";N;s:15:\\\"chainConnection\\\";N;s:10:\\\"chainQueue\\\";N;s:19:\\\"chainCatchCallbacks\\\";N;s:5:\\\"delay\\\";N;s:11:\\\"afterCommit\\\";N;s:10:\\\"middleware\\\";a:0:{}s:7:\\\"chained\\\";a:0:{}}\"}}','Illuminate\\Queue\\MaxAttemptsExceededException: App\\Jobs\\SmileOrderJob has been attempted too many times or run too long. The job may have previously timed out. in /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php:717\nStack trace:\n#0 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(199): Illuminate\\Queue\\Worker->maxAttemptsExceededException()\n#1 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Handler/CurlFactory.php(560): Illuminate\\Queue\\Worker->Illuminate\\Queue\\{closure}()\n#2 [internal function]: GuzzleHttp\\Handler\\CurlFactory::GuzzleHttp\\Handler\\{closure}()\n#3 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Handler/CurlHandler.php(44): curl_exec()\n#4 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Handler/Proxy.php(28): GuzzleHttp\\Handler\\CurlHandler->__invoke()\n#5 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Handler/Proxy.php(48): GuzzleHttp\\Handler\\Proxy::GuzzleHttp\\Handler\\{closure}()\n#6 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php(751): GuzzleHttp\\Handler\\Proxy::GuzzleHttp\\Handler\\{closure}()\n#7 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php(721): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}()\n#8 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php(707): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}()\n#9 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/PrepareBodyMiddleware.php(64): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}()\n#10 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Middleware.php(37): GuzzleHttp\\PrepareBodyMiddleware->__invoke()\n#11 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/RedirectMiddleware.php(71): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}()\n#12 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Middleware.php(61): GuzzleHttp\\RedirectMiddleware->__invoke()\n#13 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/HandlerStack.php(75): GuzzleHttp\\Middleware::GuzzleHttp\\{closure}()\n#14 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Client.php(331): GuzzleHttp\\HandlerStack->__invoke()\n#15 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Client.php(168): GuzzleHttp\\Client->transfer()\n#16 /var/www/html/ari_store/vendor/guzzlehttp/guzzle/src/Client.php(187): GuzzleHttp\\Client->requestAsync()\n#17 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php(609): GuzzleHttp\\Client->request()\n#18 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Support/helpers.php(234): Illuminate\\Http\\Client\\PendingRequest->Illuminate\\Http\\Client\\{closure}()\n#19 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php(624): retry()\n#20 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Http/Client/PendingRequest.php(528): Illuminate\\Http\\Client\\PendingRequest->send()\n#21 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Http/Client/Factory.php(350): Illuminate\\Http\\Client\\PendingRequest->post()\n#22 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php(261): Illuminate\\Http\\Client\\Factory->__call()\n#23 /var/www/html/ari_store/app/Jobs/SmileOrderJob.php(125): Illuminate\\Support\\Facades\\Facade::__callStatic()\n#24 /var/www/html/ari_store/app/Jobs/SmileOrderJob.php(89): App\\Jobs\\SmileOrderJob->sendWhatsapp()\n#25 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): App\\Jobs\\SmileOrderJob->handle()\n#26 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#27 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#28 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#29 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/Container.php(611): Illuminate\\Container\\BoundMethod::call()\n#30 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(128): Illuminate\\Container\\Container->call()\n#31 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(128): Illuminate\\Bus\\Dispatcher->Illuminate\\Bus\\{closure}()\n#32 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#33 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(132): Illuminate\\Pipeline\\Pipeline->then()\n#34 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(118): Illuminate\\Bus\\Dispatcher->dispatchNow()\n#35 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(128): Illuminate\\Queue\\CallQueuedHandler->Illuminate\\Queue\\{closure}()\n#36 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}()\n#37 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(120): Illuminate\\Pipeline\\Pipeline->then()\n#38 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(70): Illuminate\\Queue\\CallQueuedHandler->dispatchThroughMiddleware()\n#39 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(98): Illuminate\\Queue\\CallQueuedHandler->call()\n#40 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(410): Illuminate\\Queue\\Jobs\\Job->fire()\n#41 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(360): Illuminate\\Queue\\Worker->process()\n#42 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(158): Illuminate\\Queue\\Worker->runJob()\n#43 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(117): Illuminate\\Queue\\Worker->daemon()\n#44 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(101): Illuminate\\Queue\\Console\\WorkCommand->runWorker()\n#45 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\\Queue\\Console\\WorkCommand->handle()\n#46 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/Util.php(40): Illuminate\\Container\\BoundMethod::Illuminate\\Container\\{closure}()\n#47 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(93): Illuminate\\Container\\Util::unwrapIfClosure()\n#48 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(37): Illuminate\\Container\\BoundMethod::callBoundMethod()\n#49 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Container/Container.php(611): Illuminate\\Container\\BoundMethod::call()\n#50 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Console/Command.php(136): Illuminate\\Container\\Container->call()\n#51 /var/www/html/ari_store/vendor/symfony/console/Command/Command.php(256): Illuminate\\Console\\Command->execute()\n#52 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Console/Command.php(121): Symfony\\Component\\Console\\Command\\Command->run()\n#53 /var/www/html/ari_store/vendor/symfony/console/Application.php(971): Illuminate\\Console\\Command->run()\n#54 /var/www/html/ari_store/vendor/symfony/console/Application.php(290): Symfony\\Component\\Console\\Application->doRunCommand()\n#55 /var/www/html/ari_store/vendor/symfony/console/Application.php(166): Symfony\\Component\\Console\\Application->doRun()\n#56 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Console/Application.php(92): Symfony\\Component\\Console\\Application->run()\n#57 /var/www/html/ari_store/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(129): Illuminate\\Console\\Application->run()\n#58 /var/www/html/ari_store/artisan(37): Illuminate\\Foundation\\Console\\Kernel->handle()\n#59 {main}','2021-07-13 19:21:37');

/*Table structure for table `form_inputs` */

DROP TABLE IF EXISTS `form_inputs`;

CREATE TABLE `form_inputs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `placeholder` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `form_inputs_product_id_foreign` (`product_id`),
  CONSTRAINT `form_inputs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `form_inputs` */

insert  into `form_inputs`(`id`,`product_id`,`name`,`value`,`type`,`placeholder`,`created_at`,`updated_at`) values (1,1,'userId','User ID','number','Please Input User ID','2021-07-09 03:01:50','2021-07-09 03:01:50'),(2,1,'serverid','Server ID','number','Please Input Server ID','2021-07-09 03:01:50','2021-07-09 03:01:50'),(3,2,'userid','User ID','text','User ID','2021-07-14 04:55:44','2021-07-14 04:55:44');

/*Table structure for table `invoices` */

DROP TABLE IF EXISTS `invoices`;

CREATE TABLE `invoices` (
  `invoice_number` bigint NOT NULL,
  `payment_ref` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user` bigint unsigned NOT NULL,
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
  `expired_at` timestamp NOT NULL DEFAULT ((now() + interval 60 minutes)),
  PRIMARY KEY (`invoice_number`),
  KEY `invoices_user_foreign` (`user`),
  CONSTRAINT `invoices_user_foreign` FOREIGN KEY (`user`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `invoices` */

insert  into `invoices`(`invoice_number`,`payment_ref`,`user`,`product_data_id`,`product_data_name`,`product_id`,`product_name`,`price`,`fee`,`rates`,`discount`,`type_data`,`user_input`,`payment_method`,`status`,`created_at`,`expired_at`) values (24567300921,NULL,5,3,'344 Diamonds',1,'Mobile Legends',70464,0,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"100975707\"},{\"name\":\"serverid\",\"value\":\"2517\"}]','saldo','DONE','2021-07-13 12:20:36','2021-07-14 12:20:36'),(29975235195,NULL,7,1,'86 Diamonds',1,'Mobile Legends',17757,589,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"168814426\"},{\"name\":\"serverid\",\"value\":\"2589\"}]','bca','DONE','2021-07-12 01:38:38','2021-07-13 01:38:38'),(32996214548,'3963494',6,39,'257 Diamonds',1,'Mobile Legends',53553,616,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"917666868\"},{\"name\":\"serverid\",\"value\":\"12622\"}]','qris','EXPIRED','2021-07-10 14:02:52','2021-07-11 14:02:52'),(54997648160,NULL,5,151,'TOPUP300000',152,'Top Up 300000',300000,706,1,0,NULL,'','bca','PAID','2021-07-13 13:05:34','2021-07-14 13:05:34'),(67318223908,NULL,6,39,'257 Diamonds',1,'Mobile Legends',53553,405,1,0,NULL,'[{\"name\":\"userId\",\"value\":\"917666868\"},{\"name\":\"serverid\",\"value\":\"12622\"}]','bca','DONE','2021-07-10 14:08:08','2021-07-11 14:08:08'),(85841755626,NULL,5,151,'TOPUP100000',152,'Top Up 100000',100000,806,1,0,NULL,'','bca','PAID','2021-07-11 04:49:34','2021-07-12 04:49:34');

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

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
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values (1,'2014_10_00_000000_create_settings_table',1),(2,'2014_10_00_000001_add_group_column_on_settings_table',1),(3,'2014_10_12_000000_create_users_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2021_04_13_090030_create_products_table',1),(6,'2021_04_13_090505_create_product_data_table',1),(7,'2021_04_13_092219_create_invoices_table',1),(8,'2021_04_13_100348_create_temp_otp_table',1),(9,'2021_04_13_100651_create_admins_table',1),(10,'2021_04_19_043331_create_carousel_table',1),(11,'2021_06_02_091045_create_form_table',1),(12,'2021_06_03_095801_create_data_deletion_table',1),(13,'2021_06_10_083102_create_whatsapp_gate_table',1),(14,'2021_06_15_021413_create_paygate_table',1),(15,'2021_06_15_033116_create_usertype_table',1),(16,'2021_06_16_062409_create_mutation_table',1),(17,'2021_06_29_113342_create_jobs_table',1),(18,'2021_06_29_132647_create_smile_acc_table',1);

/*Table structure for table `mutation` */

DROP TABLE IF EXISTS `mutation`;

CREATE TABLE `mutation` (
  `bank` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mutationDate` date DEFAULT NULL,
  `mutationNote` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mutationStatus` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `mutationAmount` bigint DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `mutation` */

insert  into `mutation`(`bank`,`mutationDate`,`mutationNote`,`mutationStatus`,`mutationAmount`,`created_at`,`updated_at`) values ('bca','2021-06-09','TARIKAN ATM 09- 06; 6019007507897487','DB',100000,'2021-07-09 04:10:03','2021-07-09 16:50:03'),('bca','2021-06-14','TARIKAN ATM 14- 06; 089651157752','DB',100000,'2021-07-09 04:10:03','2021-07-14 16:50:02'),('bca','2021-06-14','TRSF E-BANKING CR; 1206- FTSCY- WS95051; 100000.00; 2021061273979862; TRFDN-AISYAH FITRI; ESPAY DEBIT INDONE;','CR',100000,'2021-07-09 04:10:03','2021-07-14 16:50:02'),('bca','2021-06-14','TARIKAN ATM 13- 06; 6019007507897487','DB',200000,'2021-07-09 04:10:03','2021-07-14 16:50:02'),('bca','2021-06-14','SWITCHING CR; TRANSFER DR 523 SNRBukuKas JL. JEND. S','CR',10000,'2021-07-09 04:10:03','2021-07-14 16:50:02'),('bca','2021-06-15','KARTU DEBIT 15- 06; KFC BOX SUNTER 5186019007507897487','DB',34500,'2021-07-09 04:10:03','2021-07-15 16:50:02'),('bca','2021-06-17','TRANSAKSI DEBIT; TGL: 0616 QR 918 Kebab Turki Sunter','DB',14000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-17','TRSF E-BANKING DB; 1706- FTFVA- WS95031; 27777- I.SAKU; -; -; 089651157752;','DB',62000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-17','KR OTOMATIS; TX155685AUTOCR-IR GOOGLE PAYMENT CORUSD2.43 GOOGLE MERCHANT - ','CR',34442,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-17','TRSF E-BANKING DB; 1706- FTFVA- WS95031; 12208- SHOPEEPAY; -; -; 9651157752;','DB',34000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-18','SWITCHING CR; TRANSFER DR 213 MUHAMAD ARI SAWALIBTPN','CR',100000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-18','TARIKAN ATM 18- 06; 089651157752','DB',100000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-18','BIAYA ADM;','DB',10768,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-21','SWITCHING CR; TANGGAL :19- 06 TRANSFER DR 213 MUHAMAD ARI SAWALIBTPN','CR',100000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-21','TRSF E-BANKING CR; 1906- FTSCY- WS95051; 160000.00; 2021061953665021; TRFDN-MUHAMAD ARI; ESPAY DEBIT INDONE;','CR',160000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-21','TARIKAN ATM 19- 06; 089651157752','DB',250000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-21','DB OTOMATIS; B.ADM.KRG BYR 0621','DB',3231,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-25','TRSF E-BANKING CR; 2506- FTSCY- WS95051; 110000.00; 2021062517125262; TRFDN-AISYAH FITRI; ESPAY DEBIT INDONE;','CR',110000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-25','TARIKAN ATM 25- 06; 6019007507897487','DB',100000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-28','SWITCHING CR; TANGGAL :25- 06 TRANSFER DR 213 MUHAMAD ARI SAWALIBTPN','CR',100000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-28','TARIKAN ATM 28- 06; 6019007507897487','DB',100000,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-28','KR OTOMATIS; SMEMFTS EFT33609 INDOMARCO PRISMATA2015213379 00012111','CR',4139900,'2021-07-09 04:10:03','2021-07-16 02:00:03'),('bca','2021-06-28','TRSF E-BANKING DB; 2806- FTFVA- WS95031; 11281- HOME CREDIT; -; -; 4100103834;','DB',1480900,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-28','TRSF E-BANKING DB; 2806- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',650000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-28','TRSF E-BANKING DB; 2806- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',124000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-28','TRSF E-BANKING DB; 2806- FTFVA- WS95031; 12308- SPAYLATER; -; -; 02000909573;','DB',253891,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-29','KARTU DEBIT 29- 06; IDM PC T001-ANCOL 6019007507897487','DB',20700,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-29','TRSF E-BANKING DB; 2906- FTFVA- WS95221; 61001- ONEKLIK GOPA; -; -; 4E837A57C5CA475880;','DB',226700,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-29','TRSF E-BANKING DB; 06- 29 95031; DANIEL BAGUS SANTO;','DB',294500,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-29','TRSF E-BANKING DB; 2906- FTFVA- WS95221; 61001- ONEKLIK GOPA; -; -; 795F530F4BD54A97B8;','DB',101000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-29','TRSF E-BANKING CR; 06- 29 ZB861; HENDRA WIJAYA;','CR',222867,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-06-30','TRSF E-BANKING DB; 3006- FTFVA- WS95221; 61001- ONEKLIK GOPA; -; -; 14CC898A07714736F0;','DB',22000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-01','SWITCHING CR; TRANSFER DR 213 MUHAMAD ARI SAWALIBTPN','CR',50000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-01','TRSF E-BANKING DB; 0107- FTFVA- WS95031; 27777- I.SAKU; -; -; 089651157752;','DB',50000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-01','TRSF E-BANKING DB; 0107- FTFVA- WS95031; 39010- DANA; -; -; 89651157752;','DB',500000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-02','TARIKAN ATM 02- 07; 6019007507897487','DB',100000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-05','TRSF E-BANKING DB; 0407- FTFVA- WS95031; 12208- SHOPEEPAY; -; -; 9651157752;','DB',25000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-05','TRSF E-BANKING CR; 07- 05 95031; REZA FADILLA RAHMA;','CR',18783,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-06','SWITCHING CR; TRANSFER DR 523 SNRBukuKas JL. JEND. S','CR',36779,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-07','TARIKAN ATM 07- 07; 6019007507897487','DB',100000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-09','TRSF E-BANKING DB; 0807- FTFVA- WS95031; 12208- SHOPEEPAY; -; -; 9651157752;','DB',71405,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-09','TRSF E-BANKING DB; 0807- FTFVA- WS95031; 12208- SHOPEEPAY; -; -; 9651157752;','DB',10000,'2021-07-09 04:10:04','2021-07-16 02:00:03'),('bca','2021-07-10','TRSF E-BANKING CR; 1007- FTSCY- WS95051; 230000.00; 2021071085986821; TRFDN-MUHAMAD ARI; ESPAY DEBIT INDONE;','CR',230000,'2021-07-10 07:20:02','2021-07-10 16:50:02'),('bca','2021-07-10','TARIKAN ATM; TARIKAN ATM 10- 07 6019007507897487','DB',150000,'2021-07-10 08:00:02','2021-07-10 16:50:02'),('bca','2021-07-10','SWITCHING CR; TANGGAL :10- 07 TRANSFER DR 886 JANNATUL QORIATUS Dana','CR',53958,'2021-07-10 14:10:02','2021-07-10 16:50:02'),('bca','2021-07-10','TRSF E-BANKING DB; 07- 10 95031; ERICK WILSON;','DB',57777,'2021-07-10 16:40:02','2021-07-10 16:50:02'),('bca','2021-07-11','TRSF E-BANKING CR; 1007- FTSCY- WS95051; 230000.00; 2021071085986821; TRFDN-MUHAMAD ARI; ESPAY DEBIT INDONE;','CR',230000,'2021-07-10 17:00:02','2021-07-11 16:50:03'),('bca','2021-07-11','TARIKAN ATM; TARIKAN ATM 10- 07 6019007507897487','DB',150000,'2021-07-10 17:00:02','2021-07-11 16:50:03'),('bca','2021-07-11','SWITCHING CR; TANGGAL :10- 07 TRANSFER DR 886 JANNATUL QORIATUS Dana','CR',53958,'2021-07-10 17:00:02','2021-07-11 16:50:03'),('bca','2021-07-11','TRSF E-BANKING DB; 07- 10 95031; ERICK WILSON;','DB',57777,'2021-07-10 17:00:02','2021-07-11 16:50:03'),('bca','2021-07-11','TRSF E-BANKING CR; 07- 11 95031; MARISA ADINDA RACH;','CR',100000,'2021-07-11 05:00:02','2021-07-11 16:50:03'),('bca','2021-07-11','TRSF E-BANKING DB; 07- 11 95031; VINCENT LEONARDO;','DB',279000,'2021-07-11 05:30:03','2021-07-11 16:50:03'),('bca','2021-07-11','TARIKAN ATM; TARIKAN ATM 11- 07 6019007507897487','DB',100000,'2021-07-11 09:10:03','2021-07-11 16:50:03'),('bca','2021-07-12','TRSF E-BANKING CR; 1007- FTSCY- WS95051; 230000.00; 2021071085986821; TRFDN-MUHAMAD ARI; ESPAY DEBIT INDONE;','CR',230000,'2021-07-11 17:00:03','2021-07-16 02:00:03'),('bca','2021-07-12','TARIKAN ATM 10- 07; 6019007507897487','DB',150000,'2021-07-11 17:00:03','2021-07-16 02:00:03'),('bca','2021-07-12','SWITCHING CR; TANGGAL :10- 07 TRANSFER DR 886 JANNATUL QORIATUS Dana','CR',53958,'2021-07-11 17:00:03','2021-07-16 02:00:03'),('bca','2021-07-12','TRSF E-BANKING DB; 07- 10 95031; ERICK WILSON;','DB',57777,'2021-07-11 17:00:03','2021-07-16 02:00:03'),('bca','2021-07-12','TRSF E-BANKING CR; 07- 11 95031; MARISA ADINDA RACH;','CR',100000,'2021-07-11 17:00:03','2021-07-16 02:00:03'),('bca','2021-07-12','TRSF E-BANKING DB; 07- 11 95031; VINCENT LEONARDO;','DB',279000,'2021-07-11 17:00:03','2021-07-16 02:00:03'),('bca','2021-07-12','TARIKAN ATM 11- 07; 6019007507897487','DB',100000,'2021-07-11 17:00:03','2021-07-16 02:00:03'),('bca','2021-07-12','TRSF E-BANKING CR; 07- 12 95031; TOMY RAMADHAN;','CR',18346,'2021-07-12 01:40:02','2021-07-16 02:00:03'),('bca','2021-07-13','TRSF E-BANKING CR; 07- 13 95031; MARISA ADINDA RACH;','CR',300706,'2021-07-13 13:10:02','2021-07-16 02:00:03'),('bca','2021-07-13','TARIKAN ATM; TARIKAN ATM 13- 07 6019007507897487','DB',50000,'2021-07-13 15:10:02','2021-07-13 16:00:02'),('bca','2021-07-14','TARIKAN ATM 13- 07; 6019007507897487','DB',50000,'2021-07-13 17:00:02','2021-07-16 02:00:03'),('bca','2021-07-14','TARIKAN ATM 14- 07; 089651157752','DB',100000,'2021-07-14 11:50:03','2021-07-16 02:00:03');

/*Table structure for table `paygate` */

DROP TABLE IF EXISTS `paygate`;

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

/*Data for the table `paygate` */

insert  into `paygate`(`payment`,`norek`,`name`,`username`,`password`,`token`,`image`,`status`,`created_at`,`updated_at`) values ('bca','8100802172','MUHAMAD ARI SAWALI','UHAMADAR3432','200199',NULL,'https://cdnlogo.com/logos/b/32/bca-bank-central-asia.svg',1,'2021-07-09 03:01:50','2021-07-09 03:01:50'),('qris','296332',NULL,NULL,NULL,'NjMxMTg0MjpoUVJkbjlReGI2VndEbWdVeVlXY0dNd1M=','https://seeklogo.com/images/Q/quick-response-code-indonesia-standard-qris-logo-F300D5EB32-seeklogo.com.png',1,'2021-07-09 03:01:50','2021-07-09 03:01:50');

/*Table structure for table `product_data` */

DROP TABLE IF EXISTS `product_data`;

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
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `product_data` */

insert  into `product_data`(`id`,`product_id`,`name`,`price`,`discount`,`layanan`,`type_data`,`created_at`,`updated_at`) values (1,1,'86 Diamonds',18110,0,'86','diamond','2021-07-09 03:01:50','2021-07-13 13:27:13'),(2,1,'172 Diamonds',35932,0,'172','diamond','2021-07-09 03:01:50','2021-07-13 13:27:13'),(3,1,'344 Diamonds',71863,0,'172,172','diamond','2021-06-16 13:34:25','2021-07-13 13:37:36'),(4,1,'429 Diamonds',90547,0,'172,257','diamond','2021-06-16 13:35:09','2021-07-13 13:27:13'),(5,1,'514 Diamonds',109231,0,'257,257','diamond','2021-06-16 13:35:37','2021-07-13 13:27:13'),(6,1,'601 Diamonds',126478,0,'257,172,172','diamond','2021-06-16 13:36:35','2021-07-13 13:27:13'),(7,1,'706 Diamonds',143725,0,'706','diamond','2021-06-16 13:37:01','2021-07-13 13:27:13'),(8,1,'792 Diamonds',161834,0,'706,86','diamond','2021-06-16 13:38:17','2021-07-13 13:27:13'),(9,1,'878 Diamonds',179656,0,'706,172','diamond','2021-06-16 13:39:06','2021-07-13 13:27:13'),(10,1,'963 Diamonds',198340,0,'706,257','diamond','2021-06-16 13:41:33','2021-07-13 13:27:13'),(11,1,'1050 Diamonds',215587,0,'706,172,172','diamond','2021-06-16 13:43:19','2021-07-13 13:27:13'),(12,1,'1135 Diamonds',234271,0,'706,257,172','diamond','2021-06-16 13:44:57','2021-07-13 13:27:13'),(13,1,'1220 Diamonds',252956,0,'706,257,257','diamond','2021-06-16 13:45:24','2021-07-13 13:27:13'),(14,1,'1307 Diamonds',270203,0,'706,257,172,172','diamond','2021-06-16 13:46:02','2021-07-13 13:27:13'),(15,1,'1412 Diamonds',287449,0,'706,706','diamond','2021-06-16 13:47:49','2021-07-13 13:27:13'),(16,1,'1498 Diamonds',305559,0,'706,706,86','diamond','2021-06-16 13:48:28','2021-07-13 13:27:13'),(17,1,'1584 Diamonds',323381,0,'706,706,172','diamond','2021-06-16 13:49:57','2021-07-13 13:27:13'),(18,1,'1669 Diamonds',342065,0,'706,706,257','diamond','2021-06-16 13:50:37','2021-07-13 13:27:13'),(19,1,'1756 Diamonds',359312,0,'706,706,172,172','diamond','2021-06-16 13:51:18','2021-07-13 13:27:13'),(20,1,'1841 Diamonds',377996,0,'706,706,257,172','diamond','2021-06-16 13:52:09','2021-07-13 13:27:13'),(21,1,'1926 Diamonds',396680,0,'706,706,257,257','diamond','2021-06-16 13:52:37','2021-07-13 13:27:13'),(22,1,'2012 Diamonds',414789,0,'706,706,257,257,86','diamond','2021-06-16 13:53:15','2021-07-13 13:27:13'),(23,1,'2195 Diamonds',431174,0,'2195','diamond','2021-06-16 13:53:47','2021-07-13 13:27:13'),(24,1,'2281 Diamonds',449283,0,'2195,86','diamond','2021-06-16 13:54:46','2021-07-13 13:27:13'),(25,1,'2539 Diamonds',503036,0,'2195,172,172','diamond','2021-06-16 13:57:16','2021-07-13 13:27:13'),(26,1,'2900 Diamonds',574898,0,'2195,706','diamond','2021-06-16 13:57:47','2021-07-13 13:27:13'),(27,1,'3072 Diamonds',610830,0,'2195,706,172','diamond','2021-06-16 13:58:31','2021-07-13 13:27:13'),(28,1,'3688 Diamonds',718623,0,'3688','diamond','2021-06-16 13:58:58','2021-07-13 13:27:13'),(29,1,'4032 Diamonds',790485,0,'3688,172,172','diamond','2021-06-16 13:59:28','2021-07-13 13:27:13'),(30,1,'4388 Diamonds',862347,0,'2195,2195','diamond','2021-06-16 13:59:50','2021-07-13 13:27:13'),(31,1,'5532 Diamonds',1077934,0,'5532','diamond','2021-06-16 14:01:11','2021-07-13 13:27:13'),(32,1,'6238 Diamonds',1221659,0,'5532,706','diamond','2021-06-16 14:01:54','2021-07-13 13:27:13'),(33,1,'7376 Diamonds',1437245,0,'3688,3688','diamond','2021-06-16 14:02:31','2021-07-13 13:27:13'),(35,1,'8432 Diamonds',1527217,0,'5532,2195,86','diamond','2021-06-16 14:04:14','2021-07-13 13:27:13'),(36,1,'Starlight Member',118717,0,'Starlight','diamond','2021-06-16 14:13:31','2021-07-13 13:27:13'),(37,1,'Twilight Pass',118717,0,'Twilight','diamond','2021-06-16 14:13:53','2021-07-13 13:27:13'),(38,1,'Starlight Plus',270203,0,'Starlight Plus','diamond','2021-06-16 14:14:17','2021-07-13 13:27:13'),(39,1,'257 Diamonds',54616,0,'257','diamond','2021-07-07 09:25:42','2021-07-13 13:27:13'),(40,1,'9288 Diamonds',1796557,0,'9288','diamond','2021-07-07 09:26:24','2021-07-13 13:27:13'),(41,2,'60 Candy',14000,0,NULL,'diamond','2021-07-14 04:56:17','2021-07-14 07:54:30'),(42,2,'180 Candy',44000,0,NULL,'diamond','2021-07-14 05:07:24','2021-07-16 01:48:59'),(43,2,'316 Candy',70000,0,NULL,'diamond','2021-07-14 05:07:49','2021-07-16 01:49:07'),(44,2,'718 Candy',134500,0,NULL,'diamond','2021-07-14 05:08:57','2021-07-16 01:50:05'),(45,2,'1368 Candy',268000,0,NULL,'diamond','2021-07-14 05:09:18','2021-07-16 01:50:35'),(46,2,'2118 Candy',434500,0,NULL,'diamond','2021-07-14 05:10:38','2021-07-16 01:51:05'),(47,2,'3548 Candy',674500,0,NULL,'diamond','2021-07-14 05:10:55','2021-07-16 01:51:25'),(48,2,'7048 Candy',1328000,0,NULL,'diamond','2021-07-14 05:11:15','2021-07-16 01:51:45');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`subtitle`,`description`,`thumbnail`,`slug`,`active`,`use_input`,`created_at`,`updated_at`) values (1,'Mobile Legends','Diamond Fast','<p>Cukup memasukan User ID dan Server ID, pilih nominal diamond yang \ndiinginkan, lakukan pembayaran. Diamonds Akan bertambah langsung ke akun\n    Mobile Legends Anda setelah pembayaran berhasil.\n<span style=\"font-weight: bold;\">Proses diamond <span style=\"color: rgb(255, 0, 0);\">5-30 detik</span> setelah pembayaran berhasil (otomatis)<br></span></p>\n            ','https://play-lh.googleusercontent.com/ha1vofCWS5lFhVe0gabwIetwjT4fUY5d6iDOP10KWRwnXci8lWI3ClxrqjoRuPZidg=s180-rw','mobile-legends',1,1,'2021-07-09 03:01:50','2021-07-09 03:01:50'),(2,'Sausage Man','Candies','<div>Top up Sausage Man Proses 5-15 Menit! Cukup masukan UserID Sausage Man Anda, pilih jumlah Candies yang Anda inginkan, selesaikan pembayaran, dan Tunggu Candies akan secara langsung ditambahkan ke akun Sausage Man Anda.</div>\n','https://mangari.store/assets/img/54c999a572b6245171632d1ff677f0bb_360.png','sausage-man-candies',1,1,'2021-07-14 04:55:44','2021-07-14 04:55:44');

/*Table structure for table `settings` */

DROP TABLE IF EXISTS `settings`;

CREATE TABLE `settings` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `val` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `settings` */

insert  into `settings`(`id`,`name`,`val`,`created_at`,`updated_at`,`group`) values (1,'app_name','MangAri Store',NULL,NULL,'default'),(2,'logo','app/uuSIMSUqx21uVGEqlu4XCBPfGeE33NrBI0unTudY.png',NULL,'2021-07-09 10:48:56','default'),(3,'favicon','app/iIJ1ZTbKp1wQnAMI7fyYSCsorc0CyOXnDXeTd1XO.png',NULL,'2021-07-09 10:48:56','default'),(4,'description','MangAri Store adalah sebuah website tempat Top-up murah, aman dan terpercaya. Memiliki metode pembayaran lebih gampang dan terpercaya',NULL,NULL,'default'),(5,'company_name','Laskarmedia',NULL,NULL,'default'),(6,'fb_id',NULL,'2021-07-09 10:48:56','2021-07-09 10:48:56','default'),(7,'fb_secret',NULL,'2021-07-09 10:48:56','2021-07-09 10:48:56','default'),(8,'wahost','https://ari-wagate.herokuapp.com','2021-07-09 10:48:56','2021-07-09 10:48:56','default'),(9,'wagroup','6281414194417-1613753307@g.us','2021-07-09 10:48:56','2021-07-09 10:53:45','default');

/*Table structure for table `smile_acc` */

DROP TABLE IF EXISTS `smile_acc`;

CREATE TABLE `smile_acc` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `smile_acc` */

insert  into `smile_acc`(`id`,`type`,`username`,`password`,`is_active`,`created_at`,`updated_at`) values (1,'vk','6285155060559','arivk123123',1,'2021-07-09 04:28:45','2021-07-09 04:28:53');

/*Table structure for table `temp_otp` */

DROP TABLE IF EXISTS `temp_otp`;

CREATE TABLE `temp_otp` (
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `otp` int NOT NULL,
  `otp_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `temp_otp` */

insert  into `temp_otp`(`username`,`otp`,`otp_type`) values ('asep.manda',6698,'regist'),('dzhiya.ulhaq',2790,'regist'),('dzhiya.ulhaq',9175,'login'),('tomyramadhan',7030,'order_add'),('arisawali2014',2124,'login');

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

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
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`username`,`email`,`number`,`password`,`balance`,`status`,`last_login`,`expire_seller_at`,`avatar`,`provider`,`provider_id`,`access_token`,`remember_token`,`created_at`,`updated_at`) values (1,'Ari Sawali','arisawali2014','arisawali2014@gmail.com','6289651157752','',0,'member','2021-07-09 03:01:50','2021-07-09 03:01:50','https://image.flaticon.com/icons/png/512/149/149071.png',NULL,NULL,NULL,NULL,'2021-07-09 03:01:50','2021-07-09 03:01:50'),(2,'Ari Sawalii','arisawalii','arisawali2020@gmail.com','6289651157752','',0,'member','2021-07-09 03:55:04','2021-07-09 03:55:04','https://graph.facebook.com/v3.3/202936108350806/picture?type=normal','facebook','202936108350806','EAANmmujkrjsBAJXv00WvZAm9wjwMQ3s8taXDIQXijBP7AJBmMhmxdwfNmWO3ZCUquv497Ky6oTbaT2LEsjZCwhgTSlBdPxRzez3KaM1ds6ZBe1HFIuhMBTZBpwbPB3mHoblJyrZBZACzZAnip4fBmJrRqtMRJoAdRZCdf3WGE9TlqiClyrZBJLhGWX',NULL,'2021-07-09 03:55:04','2021-07-12 01:43:17'),(3,'Purwohadi Sulampoko','purwohadisulampoko','purwohadisulampoko@gmail.com','','',0,'member','2021-07-09 04:20:41','2021-07-09 04:20:41','https://lh3.googleusercontent.com/a-/AOh14GjHf47lyDrphxbXxekC98sOLpAtvZiSw2snhwaR_Q=s96-c','google','116940077576913416862','ya29.a0ARrdaM96G9EZTFyPlyyikyOP0DOI3c_yRHjs_1MHHlQ_OAg21rJQq22-Wr8XKyQ4jrVSoh9Ijvx_pdkse_3UNTSx_9IYDCs5dD5TqifKa1RbrtT5OABTs6ISjJK4KDEEfMOHbUJZenK7hs7DsHqb56nrbzml',NULL,'2021-07-09 04:20:41','2021-07-09 04:20:41'),(4,'Ari Sawali','arisawali','arisawali2021@gmail.com','','',0,'member','2021-07-09 04:23:46','2021-07-09 04:23:46','https://lh3.googleusercontent.com/a/AATXAJyRg632rLEYEHTCFCy1ClrWVCtjmbKVwaeEbtje=s96-c','google','111362203241287348363','ya29.a0ARrdaM-uydG5IXqf0p1wNSFaJ9Hrou9P-MdpOAL-auaaSOreWasHTdFH_tso8AVBaRzNEjiy067g_Ioq04XkyGTSrwyzfgqSebbCyrOmv12Af-HLAqPlAdl3oTKt-fuvorwHATEeBmehm1ThepmH3tLj6VQhGA',NULL,'2021-07-09 04:23:46','2021-07-09 04:23:46'),(5,'Dzhiya','dzhiya.ulhaq','dzhiyaulhaq56@gmail.com','6283870353508','',329536,'member','2021-07-09 09:42:09','2021-07-09 09:42:09','https://image.flaticon.com/icons/png/512/149/149071.png',NULL,NULL,NULL,NULL,'2021-07-09 09:42:09','2021-07-13 13:10:02'),(6,'Virgo','virgo','virgooverdoze@gmail.com','6282234117891','',0,'member','2021-07-10 14:01:35','2021-07-10 14:01:35','https://lh3.googleusercontent.com/a-/AOh14GizilyjLDZTRe_OO7LW8AoOX-_SluyByr2qC3GW=s96-c','google','100866689485687250397','ya29.a0ARrdaM_7ItbvS3unmKDKhvyhYE_PALKBmMJlaPSHSVpDSztXIctQZS_jXRCTCTepBXTIlWlWXbNCwXPQ5fBI6H6FJVuFTVHGz2_nmj4iZRdNZBJ8uR_75o52R8F0okGOy5wZuaO6YHv8ZeKtSwdRd16egmyf',NULL,'2021-07-10 14:01:35','2021-07-10 14:01:52'),(7,'Reni Aya','reniaya','reniaya04@gmail.com','6282210530210','',0,'member','2021-07-12 01:36:31','2021-07-12 01:36:31','https://lh3.googleusercontent.com/a/AATXAJyVkXklHWMMJ6G5uAbIfLBksD0rACgUgrif8UAO=s96-c','google','102538508066027067284','ya29.a0ARrdaM-N6Wby7anoyY2yCiU-Rnvko_jR6fru-eg1HBzU6Y2oaVVSF0-spY1mE3BvhR3LX9lDYRC0SogtW2l_B-7VGV5UZPqwQ03_3lyDHIxjnkSrXT7DKbQv-PrFhs6LpqO3EjofknTK2d_iIsEXdxT4PhZ2Vw',NULL,'2021-07-12 01:36:31','2021-07-15 01:31:47'),(8,'tomy ramadhan','tomyramadhan','ramadhan.tomy38@gmail.com','62822112981','',0,'member','2021-07-12 03:21:01','2021-07-12 03:21:01','https://lh3.googleusercontent.com/a/AATXAJxchWZydY1AR9yzUcBaftgDDAv7IGeXIBTCr3DL=s96-c','google','106830374409379436548','ya29.a0ARrdaM_msoRumlGz8S7gdtHBNi724i8obaMpOHENiw1x_ooUNZ4JH0CxbKdL_qya9766Gbruni-hAFiG_0MudkpjLwKq7GErkP7K5miK4DmVMgUJU6k3qV8D5IG16H19mpiYLoDoPYLZVL2_ddW5iL3P_m5g',NULL,'2021-07-12 03:21:01','2021-07-12 03:21:11'),(9,'ikhsan Firdaus','ikhsanfirdaus','ikhsanf0314@gmail.com','','',0,'member','2021-07-14 22:20:09','2021-07-14 22:20:09','https://lh3.googleusercontent.com/a/AATXAJyKvaXY0TeVeCNafqCw8xGAkeG3M60grkUpbrPq=s96-c','google','113265937845291991090','ya29.a0ARrdaM9ewry0nJFN_1__K4QXzj21amvx5G-mOhSJ09yCtHn28Dx1NQ_bRFZTdsXQIIsByB9zb0aTJ4fE4mUY1MN7khalVbJ-N6Eg6FEoGv0v72C8EC22eiMzUsv4AM3IsZnUrU0jGDs9yZBJDFfFxAY7xgw8',NULL,'2021-07-14 22:20:09','2021-07-14 22:20:09'),(10,'ronal Simangunsongg','ronalsimangunsongg','ronalsimangunsong777@gmail.com','6282138292677','',0,'member','2021-07-15 18:34:29','2021-07-15 18:34:29','https://lh3.googleusercontent.com/a/AATXAJwY3CqP5gd4zAF7xYKSGAbIqpjv2BHfYkwiN3gw=s96-c','google','116675896853034988538','ya29.a0ARrdaM99djZIHbL01khr1t9f7VU6UbkQ_sxhqfUR-4PMLJy8xUr2m2Xf8WajSSH7mkCpezZVbMnZjjl6y9pKKZqcrU2NkmvkOkNFZTLCwNVGQXgy6iCfW5xQ6pidzePz_y5xhY3m_LEbqg1GX88vIDgR9PYi',NULL,'2021-07-15 18:34:29','2021-07-15 18:35:01');

/*Table structure for table `usertype` */

DROP TABLE IF EXISTS `usertype`;

CREATE TABLE `usertype` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `discount` int NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `usertype` */

insert  into `usertype`(`id`,`type`,`discount`) values (1,'member',0),(2,'reseller',2);

/*Table structure for table `wagate` */

DROP TABLE IF EXISTS `wagate`;

CREATE TABLE `wagate` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth` longtext COLLATE utf8mb4_unicode_ci,
  `user` longtext COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `wagate` */

insert  into `wagate`(`id`,`auth`,`user`,`created_at`) values ('dsj','{\"clientID\":\"36Y7HlNlbqAQW6xGuNBw2g==\",\"serverToken\":\"1@82GlMi3eKbkFK5kwrxGCwjM5gdXiEAsnIXM6AjoSMCQZ8zLUyOTv\\/tLSHghkA52OuTWKzplTr2F0AQ==\",\"clientToken\":\"tBhOdSH45K8YtK7PKnBhwlJoxnRFhELarOjFsze6XaY=\",\"encKey\":\"aOqI5dusMxqh0izcIQ4BNOgILgW4xY2HTNjd3Li1gQE=\",\"macKey\":\"d4iOhIstne91erMVGtcq+J3fKoUujljzLkJ761JRAU0=\"}','{\"jid\":\"6285155060559@s.whatsapp.net\",\"name\":\"ARI-OTP\",\"phone\":{\"wa_version\":\"2.21.12.21\",\"mcc\":\"510\",\"mnc\":\"089\",\"os_version\":\"10\",\"device_manufacturer\":\"Xiaomi\",\"device_model\":\"platina\",\"os_build_number\":\"QKQ1.190910.002 test-keys\"},\"imgUrl\":null}','2021-07-09 03:49:40');

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
