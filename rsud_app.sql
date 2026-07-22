-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: rsud_app
-- ------------------------------------------------------
-- Server version	10.4.32-MariaDB

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `activities`
--

DROP TABLE IF EXISTS `activities`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `activities` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `action` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `subject_type` varchar(255) DEFAULT NULL,
  `subject_id` bigint(20) unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `activities_user_id_foreign` (`user_id`),
  KEY `activities_subject_type_subject_id_index` (`subject_type`,`subject_id`),
  CONSTRAINT `activities_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `complaints`
--

DROP TABLE IF EXISTS `complaints`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complaints` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `status` enum('baru','diproses','selesai') NOT NULL DEFAULT 'baru',
  `admin_response` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complaints`
--

LOCK TABLES `complaints` WRITE;
/*!40000 ALTER TABLE `complaints` DISABLE KEYS */;
INSERT INTO `complaints` VALUES (1,'Budi Setiawan','budi@example.com','081234567890','Pelayanan Medis','Saya ingin menyampaikan bahwa pelayanan di IGD perlu ditingkatkan. Waktu tunggu pasien terlalu lama.','baru',NULL,'2026-05-14 20:52:17','2026-05-14 20:52:17');
/*!40000 ALTER TABLE `complaints` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `departments`
--

DROP TABLE IF EXISTS `departments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `departments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `consultation_fee` decimal(12,2) DEFAULT NULL COMMENT 'Tarif konsultasi default untuk poli ini',
  `code` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `departments`
--

LOCK TABLES `departments` WRITE;
/*!40000 ALTER TABLE `departments` DISABLE KEYS */;
INSERT INTO `departments` VALUES (6,'Poliklinik Penyakit Dalam',NULL,NULL,NULL,'Pemeriksaan dan penanganan penyakit organ dalam.','aktif','2026-05-06 22:49:28','2026-05-06 22:49:28'),(7,'Poliklinik Anak',NULL,NULL,NULL,'Pelayanan kesehatan khusus bayi, anak, dan remaja.','aktif','2026-05-06 22:49:28','2026-05-06 22:49:28'),(8,'Poliklinik Kandungan',NULL,NULL,NULL,'Pelayanan kesehatan ibu hamil dan kandungan (Obgyn).','aktif','2026-05-06 22:49:28','2026-05-06 22:49:28'),(9,'Poliklinik Saraf',NULL,NULL,NULL,'Pelayanan medis untuk sistem saraf dan otak.','aktif','2026-05-06 23:01:27','2026-05-06 23:01:27'),(10,'Poliklinik Bedah',NULL,NULL,NULL,NULL,'aktif','2026-06-17 17:23:47','2026-06-17 17:23:47'),(11,'Laboratorium',NULL,NULL,NULL,NULL,'aktif','2026-06-17 17:23:47','2026-06-17 17:23:47'),(12,'UGD',NULL,NULL,NULL,'Unit Gawat Darurat','aktif','2026-06-17 17:28:31','2026-06-17 17:28:31'),(13,'Radiologi',NULL,NULL,NULL,'Pelayanan radiologi dan pencitraan medis.','aktif','2026-06-17 17:45:25','2026-06-17 17:45:25'),(14,'Kamar Operasi (OK)',NULL,NULL,NULL,'Instalasi Bedah Sentral / Kamar Operasi.','aktif','2026-06-17 17:51:53','2026-06-17 17:51:53');
/*!40000 ALTER TABLE `departments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctor_schedules`
--

DROP TABLE IF EXISTS `doctor_schedules`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctor_schedules` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `day_of_week` tinyint(4) NOT NULL COMMENT '1=Senin, 7=Minggu',
  `start_time` time NOT NULL,
  `end_time` time NOT NULL,
  `max_patients` smallint(5) unsigned NOT NULL DEFAULT 20,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctor_schedules_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `doctor_schedules_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=850 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctor_schedules`
--

LOCK TABLES `doctor_schedules` WRITE;
/*!40000 ALTER TABLE `doctor_schedules` DISABLE KEYS */;
INSERT INTO `doctor_schedules` VALUES (2,3,1,'08:00:00','12:00:00',50,1,'2026-05-14 08:10:14','2026-05-14 08:10:14'),(3,3,5,'08:00:00','12:00:00',50,1,'2026-05-14 08:10:14','2026-05-14 08:10:14'),(770,16,1,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(771,16,2,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(772,16,3,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(773,16,4,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(774,16,5,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(775,16,6,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(776,16,7,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(777,17,1,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(778,17,2,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(779,17,3,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(780,17,4,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(781,17,5,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(782,17,6,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(783,17,7,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(784,18,1,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(785,18,2,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(786,18,3,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(787,18,4,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(788,18,5,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(789,18,6,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(790,18,7,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(791,4,1,'07:45:00','16:30:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(792,4,2,'07:45:00','16:30:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(793,4,3,'07:45:00','16:30:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(794,4,4,'07:45:00','16:30:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(795,4,5,'06:30:00','11:30:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(796,19,1,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(797,19,2,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(798,19,3,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(799,19,4,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(800,19,5,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(801,19,6,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(802,19,7,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(803,20,1,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(804,20,2,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(805,20,3,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(806,20,4,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(807,20,5,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(808,20,6,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(809,20,7,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(810,21,1,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(811,21,2,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(812,21,3,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(813,21,4,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(814,21,5,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(815,21,6,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(816,21,7,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(817,28,1,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(818,28,2,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(819,28,3,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(820,28,4,'07:45:00','08:30:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(821,28,5,'06:30:00','08:30:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(822,7,1,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(823,7,2,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(824,7,3,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(825,7,4,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(826,7,5,'08:00:00','11:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(827,8,1,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(828,8,2,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(829,8,3,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(830,8,4,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(831,8,5,'08:00:00','11:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(832,23,1,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(833,23,2,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(834,23,3,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(835,23,4,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(836,23,5,'08:00:00','11:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(837,24,1,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(838,24,2,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(839,24,3,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(840,24,4,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(841,24,5,'08:00:00','14:00:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(845,27,1,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(846,27,2,'00:00:00','23:59:00',20,1,'2026-06-17 18:12:08','2026-06-17 18:12:08'),(847,29,1,'08:00:00','14:00:00',50,1,'2026-06-17 18:52:15','2026-06-17 18:52:15'),(848,29,2,'08:00:00','14:00:00',50,1,'2026-06-17 18:52:15','2026-06-17 18:52:15'),(849,29,3,'08:00:00','14:00:00',50,1,'2026-06-17 18:52:15','2026-06-17 18:52:15');
/*!40000 ALTER TABLE `doctor_schedules` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `doctors`
--

DROP TABLE IF EXISTS `doctors`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `doctors` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `specialization` varchar(255) DEFAULT NULL,
  `specialist` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `consultation_fee` decimal(12,2) DEFAULT NULL COMMENT 'Tarif konsultasi khusus dokter ini (opsional, override tarif poli)',
  `email` varchar(255) DEFAULT NULL,
  `str_number` varchar(50) DEFAULT NULL,
  `sip_number` varchar(50) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `department_id` bigint(20) unsigned DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `employee_code` varchar(20) DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `doctors_department_id_foreign` (`department_id`),
  KEY `doctors_user_id_foreign` (`user_id`),
  CONSTRAINT `doctors_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `doctors_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=30 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `doctors`
--

LOCK TABLES `doctors` WRITE;
/*!40000 ALTER TABLE `doctors` DISABLE KEYS */;
INSERT INTO `doctors` VALUES (1,'Dr. Richard','Gigi','Gigi','123',NULL,NULL,NULL,NULL,NULL,1,NULL,'2026-04-17 01:23:01','2026-06-10 00:39:31',NULL,NULL,NULL,'2026-06-10 00:39:31'),(2,'Dr. Stevi','Anak','Anak','2',NULL,NULL,NULL,NULL,NULL,1,NULL,'2026-04-17 03:37:23','2026-06-10 00:39:26',NULL,NULL,NULL,'2026-06-10 00:39:26'),(3,'dr. Renata Queen Victoria Muchaimin','Spesialis Anak','Spesialis Anak','0897675754678',NULL,'renata@gmail.com','123','123',NULL,1,NULL,'2026-05-07 22:47:43','2026-05-07 22:47:43',7,NULL,'DOK-003',NULL),(4,'dr. Sabriani Pontoh','Dokter Ahli Pertama','Dokter Ahli Pertama','082919570166',NULL,'drsabrianipontoh@rsud.com',NULL,NULL,NULL,1,'PPPK','2026-06-17 17:23:48','2026-06-17 17:28:32',12,5,'DOK-002',NULL),(7,'dr. Juwita D. Pratiwi, Sp.B','Dokter Spesialis Bedah','Dokter Spesialis Bedah','081654432767',NULL,'drjuwitadpratiwispb@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:23:49','2026-06-17 17:28:32',10,8,'DOK-005',NULL),(8,'dr. Budi Parabang, Sp.PK','Dokter Spesialis Patologi Klinik','Dokter Spesialis Patologi Klinik','089221107488',NULL,'drbudiparabangsppk@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:23:49','2026-06-17 18:12:08',11,9,'DOK-006',NULL),(15,'dr. Moh. Dawam Ansori','Dokter Ahli Muda','Dokter Ahli Muda','085618913412',NULL,'drmohdawamansori@rsud.com',NULL,NULL,NULL,0,'PNS','2026-06-17 17:32:59','2026-06-17 17:32:59',12,16,'DOK-006',NULL),(16,'dr. Ayu Fitria Panawar','Dokter Ahli Pertama','Dokter Ahli Pertama','086217416543',NULL,'drayufitriapanawar@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:32:59','2026-06-17 17:32:59',12,17,'DOK-007',NULL),(17,'dr. Ivana Esther Baharutan','Dokter Ahli Pertama','Dokter Ahli Pertama','089187530279',NULL,'drivanaestherbaharutan@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:33:00','2026-06-17 17:33:00',12,18,'DOK-008',NULL),(18,'dr. Polii Reiner Caesardo','Dokter Ahli Pertama','Dokter Ahli Pertama','083933179195',NULL,'drpoliireinercaesardo@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:33:00','2026-06-17 17:33:00',12,19,'DOK-009',NULL),(19,'dr. Christo F.N Bawelle','Dokter Umum','Dokter Umum','087598208115',NULL,'drchristofnbawelle@rsud.com',NULL,NULL,NULL,1,'KONTRAK BLUD','2026-06-17 17:33:00','2026-06-17 17:33:00',12,20,'DOK-010',NULL),(20,'dr. Nur Magfira Lasena','Dokter Umum','Dokter Umum','081080596622',NULL,'drnurmagfiralasena@rsud.com',NULL,NULL,NULL,1,'KONTRAK BLUD','2026-06-17 17:33:00','2026-06-17 17:33:00',12,21,'DOK-011',NULL),(21,'dr. Teddy Unsulangi','Dokter Umum','Dokter Umum','087328584548',NULL,'drteddyunsulangi@rsud.com',NULL,NULL,NULL,1,'KONTRAK BLUD','2026-06-17 17:33:01','2026-06-17 17:33:01',12,22,'DOK-012',NULL),(23,'dr. Jackli Liow, Sp.A','Dokter Spesialis Anak','Dokter Spesialis Anak','085436028310',NULL,'drjackliliowspa@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:42:22','2026-06-17 17:42:22',7,24,'DOK-013',NULL),(24,'dr. Teddy M. Herman, Sp.Rad','Dokter Spesialis Radiologi','Dokter Spesialis Radiologi','084135634474',NULL,'drteddymhermansprad@rsud.com',NULL,NULL,NULL,1,'KONTRAK BLUD','2026-06-17 17:45:26','2026-06-17 18:12:08',13,25,'DOK-014',NULL),(27,'dr. Muh. Rizki Ramdan Sarson, Sp.An','Dokter Spesialis Anestesi','Dokter Spesialis Anestesi','081613190381',NULL,'drmuhrizkiramdansarsonspan@rsud.com',NULL,NULL,NULL,1,'KONTRAK BLUD','2026-06-17 17:53:11','2026-06-17 17:53:11',14,28,'DOK-016',NULL),(28,'dr. Fitri Olga Latamu, Sp.PD','Dokter Spesialis Penyakit Dalam','Dokter Spesialis Penyakit Dalam','088301930204',NULL,'drfitriolgalatamusppd@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:55:52','2026-06-17 17:55:52',6,29,'DOK-016',NULL),(29,'dr. Rahma Audry Fitriany, Sp. OG','Dokter Spesialis Obstetri & Ginekologi','Dokter Spesialis Obstetri & Ginekologi','083112204566',NULL,'drrahmaaudryfitrianyspog@rsud.com',NULL,NULL,NULL,1,'PNS','2026-06-17 17:57:49','2026-06-17 17:57:49',8,30,'DOK-016',NULL);
/*!40000 ALTER TABLE `doctors` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `failed_jobs`
--

DROP TABLE IF EXISTS `failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `failed_jobs`
--

LOCK TABLES `failed_jobs` WRITE;
/*!40000 ALTER TABLE `failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inpatients`
--

DROP TABLE IF EXISTS `inpatients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `inpatients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `registration_id` bigint(20) unsigned DEFAULT NULL,
  `patient_id` bigint(20) unsigned NOT NULL,
  `room_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `admission_date` datetime NOT NULL,
  `discharge_date` datetime DEFAULT NULL,
  `status` enum('admitted','discharged') NOT NULL DEFAULT 'admitted',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `inpatients_registration_id_foreign` (`registration_id`),
  KEY `inpatients_patient_id_foreign` (`patient_id`),
  KEY `inpatients_room_id_foreign` (`room_id`),
  KEY `inpatients_doctor_id_foreign` (`doctor_id`),
  CONSTRAINT `inpatients_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  CONSTRAINT `inpatients_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`),
  CONSTRAINT `inpatients_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`),
  CONSTRAINT `inpatients_room_id_foreign` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inpatients`
--

LOCK TABLES `inpatients` WRITE;
/*!40000 ALTER TABLE `inpatients` DISABLE KEYS */;
/*!40000 ALTER TABLE `inpatients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medical_records`
--

DROP TABLE IF EXISTS `medical_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medical_records` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `record_date` date NOT NULL,
  `complaint` text NOT NULL,
  `diagnosis` text NOT NULL,
  `treatment` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `subjective` text DEFAULT NULL,
  `objective` text DEFAULT NULL,
  `blood_pressure` varchar(20) DEFAULT NULL,
  `temperature` decimal(4,1) DEFAULT NULL,
  `weight` decimal(5,2) DEFAULT NULL,
  `height` decimal(5,2) DEFAULT NULL,
  `assessment` text DEFAULT NULL,
  `plan` text DEFAULT NULL,
  `icd10_code` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medical_records_patient_id_foreign` (`patient_id`),
  KEY `medical_records_doctor_id_foreign` (`doctor_id`),
  KEY `medical_records_department_id_foreign` (`department_id`),
  CONSTRAINT `medical_records_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`),
  CONSTRAINT `medical_records_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`),
  CONSTRAINT `medical_records_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medical_records`
--

LOCK TABLES `medical_records` WRITE;
/*!40000 ALTER TABLE `medical_records` DISABLE KEYS */;
INSERT INTO `medical_records` VALUES (1,2,4,12,'2026-06-18','Sakit','Acute','Di berikan obat dan edukasi','2026-06-18 05:16:33','2026-06-18 05:16:33',NULL,'Sakit','sakit','120/80',35.0,60.00,165.00,'Acute','Di berikan obat dan edukasi','j123'),(3,3,21,12,'2026-06-19','Sakit Kepala','Demam','-','2026-06-18 19:46:36','2026-06-18 19:46:36',NULL,'Sakit Kepala','-','120/80',36.5,60.60,170.00,'Demam','-','J06.9'),(4,1,8,11,'2026-07-02','sakit','Acute','tidak ada','2026-07-01 11:32:04','2026-07-01 11:32:04',NULL,'sakit','-','120/80',36.0,60.00,165.00,'Acute','tidak ada','j123');
/*!40000 ALTER TABLE `medical_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_categories`
--

DROP TABLE IF EXISTS `medicine_categories`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine_categories` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(10) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicine_categories_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_categories`
--

LOCK TABLES `medicine_categories` WRITE;
/*!40000 ALTER TABLE `medicine_categories` DISABLE KEYS */;
INSERT INTO `medicine_categories` VALUES (1,'Antibiotik','ANT','Obat untuk mengatasi infeksi bakteri.',1,'2026-05-06 22:49:28','2026-05-06 22:49:28'),(2,'Analgesik','ALG','Obat pereda nyeri.',1,'2026-05-06 22:49:28','2026-05-06 22:49:28'),(3,'Vitamin & Suplemen','VIT','Membantu menjaga dan memulihkan daya tahan tubuh.',1,'2026-05-06 22:49:28','2026-05-06 22:49:28'),(4,'Pencernaan','PNC','Obat untuk masalah lambung dan pencernaan.',1,'2026-05-06 22:49:28','2026-05-06 22:49:28'),(5,'Pernapasan','PRN','Obat untuk asma, batuk, dan masalah pernapasan lainnya.',1,'2026-05-06 22:49:28','2026-05-06 22:49:28');
/*!40000 ALTER TABLE `medicine_categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicine_stocks`
--

DROP TABLE IF EXISTS `medicine_stocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicine_stocks` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `warehouse` varchar(255) NOT NULL DEFAULT 'GUDANG UTAMA',
  `quantity` int(11) NOT NULL DEFAULT 0,
  `batch_number` varchar(255) DEFAULT NULL,
  `expiry_date` date DEFAULT NULL,
  `hpp` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `medicine_stocks_medicine_id_foreign` (`medicine_id`),
  CONSTRAINT `medicine_stocks_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicine_stocks`
--

LOCK TABLES `medicine_stocks` WRITE;
/*!40000 ALTER TABLE `medicine_stocks` DISABLE KEYS */;
INSERT INTO `medicine_stocks` VALUES (1,1,'GUDANG UTAMA',992,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-07-01 11:25:57'),(2,2,'GUDANG UTAMA',999,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-07-01 11:23:59'),(3,3,'GUDANG UTAMA',987,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-07-01 11:32:32'),(4,4,'GUDANG UTAMA',1000,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-06-18 05:22:39'),(5,5,'GUDANG UTAMA',992,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-06-18 05:23:31'),(6,6,'GUDANG UTAMA',1000,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-06-18 05:22:39'),(7,7,'GUDANG UTAMA',1000,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-06-18 05:22:39'),(8,8,'GUDANG UTAMA',1000,'AUTO-20260618','2028-06-18',0.00,'2026-06-18 05:22:39','2026-06-18 05:22:39');
/*!40000 ALTER TABLE `medicine_stocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `medicines`
--

DROP TABLE IF EXISTS `medicines`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `medicines` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `category_id` bigint(20) unsigned DEFAULT NULL,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `unit` varchar(255) NOT NULL DEFAULT 'PCS',
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `description` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `medicines_code_unique` (`code`),
  KEY `medicines_category_id_foreign` (`category_id`),
  CONSTRAINT `medicines_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `medicine_categories` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `medicines`
--

LOCK TABLES `medicines` WRITE;
/*!40000 ALTER TABLE `medicines` DISABLE KEYS */;
INSERT INTO `medicines` VALUES (1,NULL,'OBT001','Paracetamol 500mg','TABLET',2500.00,'Obat penurun demam dan nyeri',1,'2026-04-23 23:46:34','2026-05-06 22:53:26'),(2,NULL,'OBT002','Amoxicillin 500mg','KAPSUL',5000.00,'Antibiotic untuk infeksi',1,'2026-04-23 23:46:34','2026-05-06 22:53:26'),(3,NULL,'OBT003','Vitamin C 1000mg','TABLET',15000.00,'Vitamin C untuk daya tahan tubuh',1,'2026-04-23 23:46:34','2026-05-06 22:53:26'),(4,NULL,'OBT004','Ibuprofen 200mg','TABLET',3000.00,'Obat anti-inflamasi',1,'2026-04-23 23:46:34','2026-05-06 22:53:26'),(5,NULL,'OBT005','Antacida','TABLET',2000.00,'Untuk masalah pencernaan',1,'2026-04-23 23:46:34','2026-05-06 22:53:26'),(6,NULL,'OBT006','Chlorpheniramine 2mg','TABLET',1500.00,'Antihistamin untuk alergi',1,'2026-04-23 23:46:34','2026-05-06 22:53:26'),(7,NULL,'OBT007','Metformin 500mg','TABLET',8000.00,'Untuk diabetes tipe 2',1,'2026-04-23 23:46:34','2026-05-06 22:53:26'),(8,NULL,'OBT008','Omeprazole 20mg','KAPSUL',12000.00,'Untuk asam lambung',1,'2026-04-23 23:46:34','2026-05-06 22:53:26');
/*!40000 ALTER TABLE `medicines` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=48 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_users_table',1),(2,'2014_10_12_100000_create_password_reset_tokens_table',1),(3,'2019_08_19_000000_create_failed_jobs_table',1),(4,'2019_12_14_000001_create_personal_access_tokens_table',1),(5,'2026_04_14_101731_create_doctors_table',2),(6,'2026_04_14_101731_create_patients_table',2),(7,'2026_04_14_101732_create_departments_table',2),(8,'2026_04_14_101732_create_registrations_table',2),(9,'2026_04_17_084527_add_fields_to_departments_table',3),(10,'2026_04_17_092612_add_department_id_to_doctors_table',4),(11,'2026_04_17_114501_create_medical_records_table',5),(12,'2026_04_24_000001_create_medicines_table',6),(13,'2026_04_24_000002_create_suppliers_table',6),(14,'2026_04_24_000003_create_medicine_stocks_table',6),(15,'2026_04_24_000004_create_purchase_orders_table',6),(16,'2026_04_24_000005_create_purchase_order_items_table',6),(17,'2026_05_07_050615_add_role_fields_to_users_table',7),(18,'2026_05_07_055404_add_complete_fields_to_patients_table',8),(19,'2026_05_07_055415_add_complete_fields_to_doctors_table',9),(20,'2026_05_07_055522_create_doctor_schedules_table',9),(21,'2026_05_07_055522_create_medicine_categories_table',9),(22,'2026_05_07_055523_create_payments_table',9),(23,'2026_05_07_055523_create_prescriptions_table',9),(24,'2026_05_07_055524_create_payment_items_table',9),(25,'2026_05_07_061500_create_news_table',10),(26,'2026_05_07_061501_create_activities_table',10),(27,'2026_05_07_062000_add_fields_to_registrations_table',10),(28,'2026_05_07_062001_add_category_id_to_medicines_table',10),(29,'2026_05_07_120000_add_is_dispensed_to_prescriptions_table',11),(30,'2026_05_07_120000_create_rooms_table',12),(31,'2026_05_15_000001_create_complaints_table',13),(32,'2026_06_05_054826_add_referral_fields_to_registrations_table',14),(33,'2026_06_09_140642_add_soft_deletes_and_fix_foreign_keys',15),(34,'2026_06_09_141150_modify_payments_table_for_pharmacy_sale',16),(35,'2026_06_09_141154_add_soap_fields_to_medical_records',16),(36,'2026_06_09_142658_add_price_to_rooms_table',17),(37,'2026_06_09_142704_create_inpatients_table',17),(38,'2026_06_10_165300_add_complete_fields_to_patients_table',18),(39,'2026_06_18_133910_add_kasir_role_to_users_table',19),(40,'2026_06_18_135437_add_super_admin_role_to_users_table',20),(41,'2026_06_18_173412_add_building_and_floor_to_rooms_table',21),(42,'2026_06_18_174925_drop_price_per_night_from_rooms_table',22),(43,'2026_06_18_180033_add_extended_fields_to_registrations_table',23),(44,'2026_06_21_114847_create_wards_table',24),(45,'2026_07_02_030900_add_farmasi_role_to_users_table',25),(46,'2026_07_02_034500_add_consultation_fee_to_doctors_and_departments',26),(47,'2026_07_05_183900_add_ward_id_to_rooms_table',27);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `news`
--

DROP TABLE IF EXISTS `news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `news` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `author_id` bigint(20) unsigned DEFAULT NULL,
  `status` enum('draft','published','archived') NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `news_slug_unique` (`slug`),
  KEY `news_author_id_foreign` (`author_id`),
  CONSTRAINT `news_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `news`
--

LOCK TABLES `news` WRITE;
/*!40000 ALTER TABLE `news` DISABLE KEYS */;
/*!40000 ALTER TABLE `news` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_reset_tokens`
--

LOCK TABLES `password_reset_tokens` WRITE;
/*!40000 ALTER TABLE `password_reset_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `password_reset_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `patients`
--

DROP TABLE IF EXISTS `patients`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `patients` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_code` varchar(20) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `nik` varchar(255) NOT NULL,
  `bpjs_number` varchar(20) DEFAULT NULL,
  `blood_type` enum('A','B','AB','O','A+','A-','B+','B-','AB+','AB-','O+','O-') DEFAULT NULL,
  `birth_date` date NOT NULL,
  `birth_place` varchar(255) DEFAULT NULL,
  `gender` varchar(255) NOT NULL,
  `religion` varchar(255) DEFAULT NULL,
  `marital_status` varchar(255) DEFAULT NULL,
  `education` varchar(255) DEFAULT NULL,
  `occupation` varchar(255) DEFAULT NULL,
  `address` text NOT NULL,
  `rt_rw` varchar(255) DEFAULT NULL,
  `kelurahan` varchar(255) DEFAULT NULL,
  `kecamatan` varchar(255) DEFAULT NULL,
  `kabupaten` varchar(255) DEFAULT NULL,
  `provinsi` varchar(255) DEFAULT NULL,
  `postal_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `emergency_contact_name` varchar(255) DEFAULT NULL,
  `emergency_contact_phone` varchar(255) DEFAULT NULL,
  `emergency_contact_relation` varchar(255) DEFAULT NULL,
  `photo` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `user_id` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `allergy_notes` text DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `patients_nik_unique` (`nik`),
  UNIQUE KEY `patients_patient_code_unique` (`patient_code`),
  KEY `patients_user_id_foreign` (`user_id`),
  CONSTRAINT `patients_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `patients`
--

LOCK TABLES `patients` WRITE;
/*!40000 ALTER TABLE `patients` DISABLE KEYS */;
INSERT INTO `patients` VALUES (1,'RSU-2026-0001','Monkey Luffy','2838291928384938',NULL,NULL,'2001-06-10',NULL,'L',NULL,NULL,NULL,NULL,'Daftar Online',NULL,NULL,NULL,NULL,NULL,NULL,'123',NULL,NULL,NULL,NULL,NULL,1,'2026-06-10 00:45:27','2026-06-10 00:45:27',NULL,NULL,NULL,NULL),(2,'RSU-2026-0002','Roronoa Zoro','123','123','A','2007-08-24',NULL,'L',NULL,NULL,NULL,NULL,'Greenland',NULL,NULL,NULL,NULL,NULL,NULL,'1123','zoro@gmail.com',NULL,NULL,NULL,NULL,0,'2026-06-18 04:53:35','2026-06-18 04:53:35',NULL,NULL,NULL,NULL),(3,'RSU-2026-0003','Zefanya Mandagi','1111111111111111',NULL,'O','2004-06-14','Manado','L','Kristen','Belum Kawin','SMA/SMK/Sederajat','Wirausaha','Jl. Manado','001/002','Manado','Manado','Manado','Sulawesi Utara',NULL,'11111111','zefa@gmail.com','Renata','22222222','Teman',NULL,1,'2026-06-18 19:05:02','2026-06-18 19:05:02',NULL,'-','-',NULL);
/*!40000 ALTER TABLE `patients` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payment_items`
--

DROP TABLE IF EXISTS `payment_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payment_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_id` bigint(20) unsigned NOT NULL,
  `description` varchar(255) NOT NULL,
  `quantity` int(10) unsigned NOT NULL DEFAULT 1,
  `price` decimal(12,2) NOT NULL DEFAULT 0.00,
  `subtotal` decimal(12,2) NOT NULL DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `payment_items_payment_id_foreign` (`payment_id`),
  CONSTRAINT `payment_items_payment_id_foreign` FOREIGN KEY (`payment_id`) REFERENCES `payments` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payment_items`
--

LOCK TABLES `payment_items` WRITE;
/*!40000 ALTER TABLE `payment_items` DISABLE KEYS */;
INSERT INTO `payment_items` VALUES (1,1,'Biaya Konsultasi Dr. Richard',1,150000.00,150000.00,'2026-05-07 01:58:16','2026-05-07 01:58:16'),(2,2,'Biaya Konsultasi dr. Sabriani Pontoh',1,150000.00,150000.00,'2026-06-18 05:24:01','2026-06-18 05:24:01'),(3,2,'Obat: Antacida',8,2000.00,16000.00,'2026-06-18 05:24:01','2026-06-18 05:24:01'),(4,3,'Biaya Konsultasi dr. Teddy Unsulangi',1,150000.00,150000.00,'2026-06-18 19:47:20','2026-06-18 19:47:20'),(5,3,'Obat: Paracetamol 500mg',8,2500.00,20000.00,'2026-06-18 19:47:20','2026-06-18 19:47:20'),(6,3,'Obat: Vitamin C 1000mg',8,15000.00,120000.00,'2026-06-18 19:47:20','2026-06-18 19:47:20'),(7,4,'Amoxicillin 500mg (OBT002)',1,5000.00,5000.00,'2026-07-01 11:23:59','2026-07-01 11:23:59'),(9,6,'Biaya Konsultasi dr. Renata Queen Victoria Muchaimin',1,150000.00,150000.00,'2026-07-01 11:34:18','2026-07-01 11:34:18'),(10,9,'Biaya Konsultasi dr. Budi Parabang, Sp.PK',1,150000.00,150000.00,'2026-07-01 11:38:47','2026-07-01 11:38:47'),(11,9,'Obat: Vitamin C 1000mg',5,15000.00,75000.00,'2026-07-01 11:38:47','2026-07-01 11:38:47');
/*!40000 ALTER TABLE `payment_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `payments`
--

DROP TABLE IF EXISTS `payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `payments` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `payment_type` enum('registration','pharmacy_sale','other') NOT NULL DEFAULT 'registration',
  `registration_id` bigint(20) unsigned DEFAULT NULL,
  `invoice_number` varchar(30) NOT NULL,
  `total_amount` decimal(12,2) NOT NULL DEFAULT 0.00,
  `payment_method` enum('cash','bpjs','insurance','transfer','debit','credit') NOT NULL DEFAULT 'cash',
  `status` enum('pending','paid','partial','cancelled') NOT NULL DEFAULT 'pending',
  `paid_at` timestamp NULL DEFAULT NULL,
  `processed_by` bigint(20) unsigned DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `patient_id` bigint(20) unsigned DEFAULT NULL,
  `customer_name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `payments_invoice_number_unique` (`invoice_number`),
  KEY `payments_processed_by_foreign` (`processed_by`),
  KEY `payments_registration_id_foreign` (`registration_id`),
  KEY `payments_patient_id_foreign` (`patient_id`),
  CONSTRAINT `payments_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_processed_by_foreign` FOREIGN KEY (`processed_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `payments_registration_id_foreign` FOREIGN KEY (`registration_id`) REFERENCES `registrations` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `payments`
--

LOCK TABLES `payments` WRITE;
/*!40000 ALTER TABLE `payments` DISABLE KEYS */;
INSERT INTO `payments` VALUES (1,'registration',114,'INV-202605-0001',150000.00,'transfer','paid','2026-05-07 01:58:34',1,NULL,'2026-05-07 01:58:16','2026-05-07 01:58:34',NULL,NULL),(2,'registration',2,'INV-202606-0002',166000.00,'transfer','paid','2026-06-18 05:26:50',1,NULL,'2026-06-18 05:24:01','2026-06-18 05:26:50',NULL,NULL),(3,'registration',3,'INV-202606-0003',290000.00,'cash','paid','2026-06-18 19:48:23',32,NULL,'2026-06-18 19:47:20','2026-06-18 19:48:23',NULL,NULL),(4,'pharmacy_sale',NULL,'INV-AP-1782933839-57',5000.00,'cash','paid','2026-07-01 11:23:59',31,NULL,'2026-07-01 11:23:59','2026-07-01 11:23:59',NULL,'Pembeli Umum (Apotek)'),(6,'registration',1,'INV-202607-0006',150000.00,'cash','pending',NULL,NULL,NULL,'2026-07-01 11:34:18','2026-07-01 11:34:18',NULL,NULL),(9,'registration',4,'INV-202607-0007',225000.00,'cash','paid','2026-07-01 11:41:16',31,NULL,'2026-07-01 11:38:47','2026-07-01 11:41:16',NULL,NULL);
/*!40000 ALTER TABLE `payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `personal_access_tokens`
--

DROP TABLE IF EXISTS `personal_access_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `personal_access_tokens`
--

LOCK TABLES `personal_access_tokens` WRITE;
/*!40000 ALTER TABLE `personal_access_tokens` DISABLE KEYS */;
/*!40000 ALTER TABLE `personal_access_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `prescriptions`
--

DROP TABLE IF EXISTS `prescriptions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `prescriptions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `medical_record_id` bigint(20) unsigned NOT NULL,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `quantity` int(10) unsigned NOT NULL,
  `dosage` varchar(255) NOT NULL,
  `instructions` varchar(255) DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `is_dispensed` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `prescriptions_medical_record_id_foreign` (`medical_record_id`),
  KEY `prescriptions_medicine_id_foreign` (`medicine_id`),
  CONSTRAINT `prescriptions_medical_record_id_foreign` FOREIGN KEY (`medical_record_id`) REFERENCES `medical_records` (`id`) ON DELETE CASCADE,
  CONSTRAINT `prescriptions_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `prescriptions`
--

LOCK TABLES `prescriptions` WRITE;
/*!40000 ALTER TABLE `prescriptions` DISABLE KEYS */;
INSERT INTO `prescriptions` VALUES (1,1,5,8,'3x1',NULL,NULL,1,'2026-06-18 05:16:33','2026-06-18 05:23:31'),(2,3,1,8,'3x1','Sesudah Makan',NULL,1,'2026-06-18 19:46:36','2026-07-01 11:25:57'),(3,3,3,8,'3x1','Sesudah Makan',NULL,1,'2026-06-18 19:46:36','2026-07-01 11:25:57'),(4,4,3,5,'3x1','Sesudah Makan',NULL,1,'2026-07-01 11:32:04','2026-07-01 11:32:32');
/*!40000 ALTER TABLE `prescriptions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_order_items`
--

DROP TABLE IF EXISTS `purchase_order_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_order_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `purchase_order_id` bigint(20) unsigned NOT NULL,
  `medicine_id` bigint(20) unsigned NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(255) NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `subtotal` decimal(15,2) NOT NULL,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `hpp` decimal(12,2) NOT NULL,
  `hpp_with_tax` decimal(12,2) NOT NULL,
  `expiry_date` date DEFAULT NULL,
  `batch_number` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `purchase_order_items_purchase_order_id_foreign` (`purchase_order_id`),
  KEY `purchase_order_items_medicine_id_foreign` (`medicine_id`),
  CONSTRAINT `purchase_order_items_medicine_id_foreign` FOREIGN KEY (`medicine_id`) REFERENCES `medicines` (`id`) ON DELETE CASCADE,
  CONSTRAINT `purchase_order_items_purchase_order_id_foreign` FOREIGN KEY (`purchase_order_id`) REFERENCES `purchase_orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_order_items`
--

LOCK TABLES `purchase_order_items` WRITE;
/*!40000 ALTER TABLE `purchase_order_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_order_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `purchase_orders`
--

DROP TABLE IF EXISTS `purchase_orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `purchase_orders` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `po_number` varchar(255) NOT NULL,
  `invoice_number` varchar(255) DEFAULT NULL,
  `invoice_date` date DEFAULT NULL,
  `supplier_id` bigint(20) unsigned NOT NULL,
  `warehouse` varchar(255) NOT NULL DEFAULT 'GUDANG UTAMA',
  `payment_type` enum('TUNAI','KREDIT') NOT NULL DEFAULT 'TUNAI',
  `subtotal` decimal(15,2) NOT NULL DEFAULT 0.00,
  `discount_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `discount_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `tax_percent` decimal(5,2) NOT NULL DEFAULT 0.00,
  `tax_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total` decimal(15,2) NOT NULL DEFAULT 0.00,
  `status` enum('DRAFT','CONFIRMED','RECEIVED','CANCELLED') NOT NULL DEFAULT 'DRAFT',
  `notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `purchase_orders_po_number_unique` (`po_number`),
  KEY `purchase_orders_supplier_id_foreign` (`supplier_id`),
  CONSTRAINT `purchase_orders_supplier_id_foreign` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `purchase_orders`
--

LOCK TABLES `purchase_orders` WRITE;
/*!40000 ALTER TABLE `purchase_orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `purchase_orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrations`
--

DROP TABLE IF EXISTS `registrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `registrations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `patient_id` bigint(20) unsigned NOT NULL,
  `doctor_id` bigint(20) unsigned NOT NULL,
  `department_id` bigint(20) unsigned NOT NULL,
  `queue_number` varchar(10) DEFAULT NULL,
  `registration_date` date NOT NULL,
  `visit_type` varchar(20) NOT NULL DEFAULT 'baru',
  `status` enum('waiting','serving','done','cancelled') NOT NULL DEFAULT 'waiting',
  `payment_method` varchar(255) NOT NULL DEFAULT 'umum',
  `referral_number` varchar(255) DEFAULT NULL,
  `referral_file_path` varchar(255) DEFAULT NULL,
  `bpjs_class` varchar(5) DEFAULT NULL,
  `sep_number` varchar(50) DEFAULT NULL,
  `referral_origin` varchar(255) DEFAULT NULL,
  `complaint` text DEFAULT NULL,
  `initial_diagnosis` text DEFAULT NULL,
  `registration_notes` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `registrations_patient_id_foreign` (`patient_id`),
  KEY `registrations_doctor_id_foreign` (`doctor_id`),
  KEY `registrations_department_id_foreign` (`department_id`),
  CONSTRAINT `registrations_department_id_foreign` FOREIGN KEY (`department_id`) REFERENCES `departments` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registrations_doctor_id_foreign` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`id`) ON DELETE CASCADE,
  CONSTRAINT `registrations_patient_id_foreign` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrations`
--

LOCK TABLES `registrations` WRITE;
/*!40000 ALTER TABLE `registrations` DISABLE KEYS */;
INSERT INTO `registrations` VALUES (1,1,3,7,'P-001','2026-06-10','baru','done','bpjs','1111111111111111111','referrals/gsdD3IEnZX7dNJGlNrSbThaHNbKuNzgNgXNa0wZF.png',NULL,NULL,NULL,'Demam',NULL,NULL,'2026-06-10 00:45:27','2026-07-01 11:28:01'),(2,2,4,12,'UA-001','2026-06-18','baru','done','umum',NULL,NULL,NULL,NULL,NULL,'Sakit',NULL,NULL,'2026-06-18 05:02:51','2026-06-18 05:16:33'),(3,3,21,12,'UA-001','2026-06-19','baru','done','umum',NULL,NULL,NULL,NULL,NULL,'Sakit Kepala','Demam',NULL,'2026-06-18 19:06:55','2026-06-18 19:46:36'),(4,1,8,11,'LA-001','2026-07-01','lama','serving','umum',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2026-07-01 11:29:01','2026-07-01 11:30:19');
/*!40000 ALTER TABLE `registrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rooms`
--

DROP TABLE IF EXISTS `rooms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `rooms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `ward_id` bigint(20) unsigned DEFAULT NULL,
  `building` varchar(255) DEFAULT NULL,
  `floor` varchar(255) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `room_class` varchar(255) NOT NULL,
  `total_beds` int(11) NOT NULL DEFAULT 0,
  `occupied_beds` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rooms_ward_id_foreign` (`ward_id`),
  CONSTRAINT `rooms_ward_id_foreign` FOREIGN KEY (`ward_id`) REFERENCES `wards` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rooms`
--

LOCK TABLES `rooms` WRITE;
/*!40000 ALTER TABLE `rooms` DISABLE KEYS */;
INSERT INTO `rooms` VALUES (1,NULL,'Gedung 4','Lantai 1','Mawar','VVIP',4,0,'2026-06-21 04:05:52','2026-06-21 04:05:52',NULL),(2,NULL,'Gedung 4 Lantai','Lantai 3','Flamboyan 2','VVIP',2,0,'2026-07-05 02:25:07','2026-07-05 02:25:07',NULL),(4,NULL,'Gedung 4 Lantai','Lantai 3','Anggrek 1','VVIP',1,0,'2026-07-05 02:31:06','2026-07-05 02:31:06',NULL),(6,10,'Gedung 4 Lantai','Lantai 1','Bougenville 1','VIP',1,0,'2026-07-12 19:19:16','2026-07-12 19:19:16',NULL),(7,10,'Gedung 4 Lantai','Lantai 1','Bougenville 1','Kelas I',2,0,'2026-07-12 19:19:31','2026-07-12 19:19:31',NULL),(8,11,'Gedung 4 Lantai','Lantai 1','Bougenville 2','Kelas III',4,0,'2026-07-12 19:20:01','2026-07-12 19:20:01',NULL);
/*!40000 ALTER TABLE `rooms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `suppliers`
--

DROP TABLE IF EXISTS `suppliers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `suppliers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `phone` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `contact_person` varchar(255) DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `suppliers_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `suppliers`
--

LOCK TABLES `suppliers` WRITE;
/*!40000 ALTER TABLE `suppliers` DISABLE KEYS */;
INSERT INTO `suppliers` VALUES (1,'SUP001','PT. Pharma Indonesia','Jl. Merdeka No. 123, Jakarta','021-123456','info@pharma.com','Budi Santoso',1,'2026-04-23 23:46:33','2026-04-23 23:46:33'),(2,'SUP002','CV. Medika Jaya','Jl. Ahmad Yani No. 45, Surabaya','031-234567','cs@medika.com','Siti Nurhaliza',1,'2026-04-23 23:46:34','2026-04-23 23:46:34'),(3,'SUP003','PT. Kesehatan Mandiri','Jl. Sudirman No. 67, Bandung','022-345678','sales@kesehatan.com','Ahmad Wijaya',1,'2026-04-23 23:46:34','2026-04-23 23:46:34');
/*!40000 ALTER TABLE `suppliers` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `role` enum('admin','doctor','petugas','patient','kasir','super_admin','farmasi') NOT NULL DEFAULT 'petugas',
  `phone` varchar(20) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=36 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator RSUD','admin@rsud.com','admin','081234567890',NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-05-06 21:13:30','2026-07-05 02:07:20'),(2,'Dr. Ahmad Fauzan, Sp.PD','dokter@rsud.com','doctor','081234567891',NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-05-06 21:13:30','2026-07-05 02:07:20'),(3,'Budi Santoso','petugas@rsud.com','petugas','081234567892',NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-05-06 21:13:30','2026-07-05 02:07:20'),(4,'Siti Aminah','pasien@rsud.com','patient','081234567893',NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-05-06 21:13:30','2026-07-05 02:07:20'),(5,'dr. Sabriani Pontoh','drsabrianipontoh@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:23:48','2026-07-05 02:07:20'),(6,'dr. Ayu Fitria Panuwa','drayufitriapanuwa@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:23:48','2026-07-05 02:07:20'),(7,'dr. Fini Olica Lalamu, Sp.PD','drfiniolicalalamusppd@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:23:49','2026-07-05 02:07:20'),(8,'dr. Juwita D. Pratiwi, Sp.B','drjuwitadpratiwispb@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:23:49','2026-07-05 02:07:20'),(9,'dr. Budi Parabang, Sp.PK','drbudiparabangsppk@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:23:49','2026-07-05 02:07:20'),(10,'dr. Jacki L. Liow, Sp.A','drjackilliowspa@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:23:49','2026-07-05 02:07:20'),(11,'dr. Moh. Darsan Ansari','drmohdarsanansari@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:28:31','2026-07-05 02:07:20'),(12,'dr. Ivana Esther Baransano','drivanaestherbaransano@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:28:31','2026-07-05 02:07:20'),(13,'dr. Toti Reiner Cassardo','drtotireinercassardo@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:28:32','2026-07-05 02:07:20'),(14,'dr. Nur Ragitta Lasena','drnurragittalasena@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:28:32','2026-07-05 02:07:20'),(15,'dr. Yessy Urulangon','dryessyurulangon@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:28:32','2026-07-05 02:07:20'),(16,'dr. Moh. Dawam Ansori','drmohdawamansori@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:32:59','2026-07-05 02:07:20'),(17,'dr. Ayu Fitria Panawar','drayufitriapanawar@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:32:59','2026-07-05 02:07:20'),(18,'dr. Ivana Esther Baharutan','drivanaestherbaharutan@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:33:00','2026-07-05 02:07:20'),(19,'dr. Polii Reiner Caesardo','drpoliireinercaesardo@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:33:00','2026-07-05 02:07:20'),(20,'dr. Christo F.N Bawelle','drchristofnbawelle@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:33:00','2026-07-05 02:07:20'),(21,'dr. Nur Magfira Lasena','drnurmagfiralasena@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:33:00','2026-07-05 02:07:20'),(22,'dr. Teddy Unsulangi','drteddyunsulangi@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:33:01','2026-07-05 02:07:20'),(23,'dr. Fitri Olga Lalamu, Sp.PD','drfitriolgalalamusppd@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:42:21','2026-07-05 02:07:20'),(24,'dr. Jackli Liow, Sp.A','drjackliliowspa@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:42:22','2026-07-05 02:07:20'),(25,'dr. Teddy M. Herman, Sp.Rad','drteddymhermansprad@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:45:26','2026-07-05 02:07:20'),(26,'dr. Ramna Audry Pinary, Sp.OG','drramnaaudrypinaryspog@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:49:52','2026-07-05 02:07:20'),(27,'dr. Muh. Rizki Ramdan Saezon, Sp.An','drmuhrizkiramdansaezonspan@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:51:53','2026-07-05 02:07:20'),(28,'dr. Muh. Rizki Ramdan Sarson, Sp.An','drmuhrizkiramdansarsonspan@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:53:11','2026-07-05 02:07:20'),(29,'dr. Fitri Olga Latamu, Sp.PD','drfitriolgalatamusppd@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:55:52','2026-07-05 02:07:20'),(30,'dr. Rahma Audry Fitriany, Sp. OG','drrahmaaudryfitrianyspog@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-17 17:57:49','2026-07-05 02:07:20'),(31,'Petugas Kasir','kasir@rsud.com','kasir',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-18 05:42:45','2026-07-05 02:07:20'),(32,'Super Administrator','superadmin@rsud.com','super_admin',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-06-18 05:58:07','2026-07-05 02:07:20'),(33,'Zefanya','dokter1@rsud.com','doctor',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-07-01 10:47:43','2026-07-05 02:07:20'),(35,'Renata','farmasi@rsud.com','farmasi',NULL,NULL,1,NULL,'$2y$12$nPqKb2iqoGJMiT3IJoQbleWxiF7I.pxfR/VkIDiA6cF/QcdJjDmj6',NULL,'2026-07-01 11:10:38','2026-07-05 02:07:20');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `wards`
--

DROP TABLE IF EXISTS `wards`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `wards` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `building` varchar(255) NOT NULL,
  `floor` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `max_capacity` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `wards`
--

LOCK TABLES `wards` WRITE;
/*!40000 ALTER TABLE `wards` DISABLE KEYS */;
INSERT INTO `wards` VALUES (1,'Gedung 4 Lantai','Lantai 3','Anggrek 1',1,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(3,'Gedung 4 Lantai','Lantai 3','Flamboyan 1',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(4,'Gedung 4 Lantai','Lantai 3','Flamboyan 2',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(5,'Gedung 4 Lantai','Lantai 2','Tulip 1',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(6,'Gedung 4 Lantai','Lantai 2','Tulip 2',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(7,'Gedung 4 Lantai','Lantai 2','Lily',3,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(8,'Gedung 4 Lantai','Lantai 2','Sakura 1',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(9,'Gedung 4 Lantai','Lantai 2','Sakura 2',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(10,'Gedung 4 Lantai','Lantai 1','Bougenville 1',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(11,'Gedung 4 Lantai','Lantai 1','Bougenville 2',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(12,'Gedung 4 Lantai','Lantai 1','Raflesia',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(13,'Gedung 4 Lantai','Lantai 1','Ruangan Immunocompromised',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(14,'Gedung 4 Lantai','Lantai 1','Teratai 1',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(15,'Gedung 4 Lantai','Lantai 1','Teratai 2',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(16,'Gedung Rawat Inap Bedah','-','Dahlia 1',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(17,'Gedung Rawat Inap Bedah','-','Dahlia 2',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(18,'Gedung Rawat Inap Bedah','-','Melati',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(19,'Gedung Rawat Inap Bedah','-','Mawar',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(20,'Gedung Isolasi','-','Cendrawasih',1,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(21,'Gedung Isolasi','-','Maleo',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(22,'Gedung Isolasi','-','Merak 1',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(23,'Gedung Isolasi','-','Merak 2',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(24,'Gedung Isolasi','-','Merpati',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(25,'Gedung PONEK','Lantai 2','Lavender 1',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(26,'Gedung PONEK','Lantai 2','Lavender 2',4,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(27,'Gedung PONEK','Lantai 2','Lavender 3',3,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(28,'Gedung PONEK','Lantai 2','Lavender 4',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(29,'Gedung PONEK','Lantai 2','Lavender 5',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(30,'Gedung PONEK','Lantai 2','Asoka 1',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(31,'Gedung PONEK','Lantai 2','Asoka 2',2,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(32,'Gedung PONEK','Lantai 2','Edelweis 1',1,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(33,'Gedung PONEK','Lantai 2','Edelweis 2',1,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(34,'Gedung PONEK','Lantai 2','Edelweis 3',1,'2026-06-21 04:03:40','2026-06-21 04:03:40'),(35,'Gedung PONEK','Lantai 2','Ruangan NICU',4,'2026-06-21 04:03:40','2026-06-21 04:03:40');
/*!40000 ALTER TABLE `wards` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-07-17 13:42:56
