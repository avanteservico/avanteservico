-- MariaDB dump 10.19  Distrib 10.4.32-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: avante_servico
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
-- Current Database: `avante_servico`
--

CREATE DATABASE /*!32312 IF NOT EXISTS*/ `avante_servico` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;

USE `avante_servico`;

--
-- Table structure for table `materials`
--

DROP TABLE IF EXISTS `materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `materials` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `purchase_date` date NOT NULL,
  `is_paid` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  CONSTRAINT `fk_materials_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `materials`
--

LOCK TABLES `materials` WRITE;
/*!40000 ALTER TABLE `materials` DISABLE KEYS */;
INSERT INTO `materials` VALUES (2,1,'Lanche Noturno  - Aneilton',80.00,'2025-12-08',1,'2026-02-09 09:35:07'),(4,1,'Combustível - Jerri',100.00,'2025-12-16',1,'2026-02-09 09:41:34');
/*!40000 ALTER TABLE `materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `people`
--

DROP TABLE IF EXISTS `people`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `people` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `nickname` varchar(100) DEFAULT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `role` varchar(100) DEFAULT NULL,
  `service_type` enum('daily','contract','production') DEFAULT 'daily',
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `people`
--

LOCK TABLES `people` WRITE;
/*!40000 ALTER TABLE `people` DISABLE KEYS */;
INSERT INTO `people` VALUES (1,'Jerrie Sales de Souza','Jerrie','','Coordenador','','Gestão da Obra','2026-02-07 23:13:23'),(2,'Aneilton Manoel da Cruz','Nei','','Coordenador','','Gestão de Obra','2026-02-07 23:15:41'),(3,'Maciel dos Santos Silva','Ciel','','Ajudante de Pedreiro','','','2026-02-09 09:27:28'),(4,'Ruan Pablo Santos Machado','Ruan','','Ajudante de Pedreiro','','','2026-02-09 09:28:45'),(5,'Gustavo Pereira dos Santos','Gustavo','','Ajudante de Pedreiro','','','2026-02-09 09:29:59'),(6,'Reginaldo Camilo dos Santos','Nego Regi','','Ajudante de Pedreiro','','','2026-02-09 09:30:56'),(7,'Valdson Jeanmonod Luz','Dison','','Ajudante de Pedreiro','','','2026-02-09 09:32:01'),(8,'Fabio Silva dos Santos','Fabio','','Ajudante de Pedreiro','','','2026-02-09 09:33:39'),(9,'Marcelo Coelho de Oliveira','Marcelo','','Ajudante de Pedreiro','','','2026-02-09 09:39:49'),(10,'José Ramon Conceição','Ramon Eletricista','','Instalador de Forro','','Instalação de Forro e Reboco de sala','2026-02-09 10:14:32'),(11,'Eugenio Pacelli','Topa Tudo','','Aluguel de Máquinas','','Aluguel de Máquinas diversas para obras','2026-02-09 10:19:23'),(12,'Rodrigo Souza Araujo','Rodrigo','','Ajudante de Pedreiro','','Reboco de Sala','2026-02-09 10:22:28'),(13,'Reidinel Medeiros dos Santos','Natival','','Pedreiro','','','2026-02-09 10:23:30'),(14,'Raique Silva dos Santos','Raique','','Prestador de serviço','','Definir o tipo de serviço que foi','2026-02-09 10:27:23'),(15,'Arisvaldo Lopes Martins','Ari','','Pedreiro','','','2026-02-09 10:28:09'),(16,'Alexsandro Bispo de Jesus','Alexsandro','','Ajudante de Pedreiro','','','2026-02-09 10:29:50'),(17,'Leandro Rocha Oliveira','Leandro','','Ajudante de Pedreiro','','','2026-02-09 10:39:35'),(18,'Roberio Leandro Cerqueira Avila','Roberio','','Prestador de serviço','','','2026-02-09 10:40:57'),(19,'Geovane Lucio dos Santos','Geovane','','Prestador de serviço','','','2026-02-09 10:42:51'),(20,'Ronivaldo Jesus dos Santos','Ronivaldo','','Ajudante de Pedreiro','','','2026-02-09 12:09:33'),(21,'Erivelton de Jesus Alves','Erivelton Caboco','','Pedreiro','','','2026-02-09 12:10:13'),(22,'Ednaldo Alves','Caboco','','Pedreiro','','Assentamento de cerâmica','2026-02-09 12:16:58'),(23,'Ajudante Jerrie','','','Ajudante de Pedreiro','','pago na conta de jerrie','2026-02-09 12:20:30'),(24,'Givaldo de Jesus','','','Prestador de serviço','','','2026-02-09 12:25:53'),(25,'Davi Porto Farias','Davi','','Prestador de serviço','','','2026-02-09 12:29:32'),(26,'Gedson Antunes Souza','Gedson','','Prestador de serviço','','analisar','2026-02-09 12:39:18'),(27,'Gabriel Ronaldy da Silva Santana','gabriel','','Ajudante de Pedreiro','','','2026-02-09 12:43:30'),(28,'Ailton Silva Costa','Vira Bicho','','Pedreiro','','','2026-02-09 12:50:09'),(29,'Jocimar Nascimento Brandão','Jocimar','','Prestador de serviço','','','2026-02-09 12:54:40'),(30,'Silvio Reis Novais de Sousa','Silvio','','Pedreiro','','','2026-02-09 13:08:37'),(31,'Vinicius Santos de Jesus','Vinicius','','Ajudante de Pedreiro','','','2026-02-09 13:09:25'),(32,'Perimetral acabamento - Diversos','Perimetral Acabamentos','','Prestador de serviço','','Diversos','2026-02-09 13:11:37'),(33,'Outlet das Tintas - Diversos','Outlet das Tintas','','Prestador de serviço','','','2026-02-09 13:17:17'),(34,'Riquelmy Jesus da Silva','Riquelmy','','Ajudante de Pedreiro','','','2026-02-09 13:18:47'),(35,'Elenildo Pereira','','','Ajudante de Pedreiro','','','2026-02-09 13:22:39'),(36,'Zé Carlos Material de Const','Zé Carlos','','Prestador de serviço','','','2026-02-09 13:27:02'),(37,'Genivaldo de Jesus dos Santos','Genivaldo','','Prestador de serviço','','','2026-02-09 13:33:32'),(38,'Lidemberg Pintor','Berg','','Pintor','','R$ 12,00 o metro quadrado = R$ 12.836,64 referente a 1.069,72 metros quadrados de telhado','2026-02-09 14:10:17'),(39,'Duda Vidros','Duda Vidros','','Vidraceiro','','Instalação de portas de alumínio, fornecimento de soleiras e troca de janela de vidro lateral','2026-02-09 14:22:58'),(40,'Diversos Materiais pagos','','','Prestador de serviço','','Diversos materiais pagos','2026-02-09 14:46:18');
/*!40000 ALTER TABLE `people` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person_payments`
--

DROP TABLE IF EXISTS `person_payments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person_payments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `person_id` int(11) NOT NULL,
  `work_id` int(11) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` date NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `is_paid` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `person_id` (`person_id`),
  KEY `work_id` (`work_id`),
  CONSTRAINT `fk_person_payments_person` FOREIGN KEY (`person_id`) REFERENCES `people` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_person_payments_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=136 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person_payments`
--

LOCK TABLES `person_payments` WRITE;
/*!40000 ALTER TABLE `person_payments` DISABLE KEYS */;
INSERT INTO `person_payments` VALUES (2,3,1,300.00,'2025-12-05','pagamento',1,'2026-02-09 09:28:18'),(3,4,1,270.00,'2025-12-05','pagamento',1,'2026-02-09 09:29:21'),(4,5,1,270.00,'2025-12-05','pagamento',1,'2026-02-09 09:30:25'),(5,6,1,270.00,'2025-12-05','pagamento',1,'2026-02-09 09:31:19'),(6,7,1,300.00,'2025-12-05','pagamento',1,'2026-02-09 09:32:18'),(7,2,1,400.00,'2025-12-06','pagamento',1,'2026-02-09 09:32:51'),(8,8,1,550.00,'2025-12-07','pagamento',1,'2026-02-09 09:34:01'),(9,3,1,400.00,'2025-12-12','pagamento',1,'2026-02-09 09:36:19'),(10,6,1,360.00,'2025-12-12','pagamento',1,'2026-02-09 09:36:55'),(11,4,1,360.00,'2025-12-12','pagamento',1,'2026-02-09 09:37:18'),(12,5,1,360.00,'2025-12-12','pagamento',1,'2026-02-09 09:37:51'),(13,2,1,400.00,'2025-12-12','pagamento',1,'2026-02-09 09:38:18'),(14,1,1,800.00,'2025-12-12','pagamento 02 semanas',1,'2026-02-09 09:38:58'),(15,7,1,400.00,'2025-12-12','pagamento',1,'2026-02-09 09:39:21'),(16,9,1,360.00,'2025-12-13','pagamento',1,'2026-02-09 09:40:16'),(17,2,1,400.00,'2025-12-19','pagamento',1,'2026-02-09 10:07:32'),(18,1,1,400.00,'2025-12-19','pagamento',1,'2026-02-09 10:07:56'),(19,9,1,360.00,'2025-12-19','pagamento',1,'2026-02-09 10:08:20'),(20,6,1,450.00,'2025-12-19','pagamento',1,'2026-02-09 10:08:46'),(21,4,1,360.00,'2025-12-19','pagamento',1,'2026-02-09 10:09:19'),(22,5,1,360.00,'2025-12-19','pagamento',1,'2026-02-09 10:09:41'),(23,3,1,650.00,'2025-12-19','pagamento',1,'2026-02-09 10:10:06'),(24,7,1,500.00,'2025-12-19','pagamento',1,'2026-02-09 10:11:57'),(25,10,1,1400.00,'2025-12-20','Revisão do forro na escola',1,'2026-02-09 10:14:56'),(26,10,1,300.00,'2025-12-21','Reboco de 01 sala',1,'2026-02-09 10:15:33'),(27,11,1,1880.85,'2025-12-23','Aluguel de andaimes e Martelete',1,'2026-02-09 10:20:02'),(28,3,1,200.00,'2025-12-24','pagamento',1,'2026-02-09 10:21:44'),(29,12,1,1500.00,'2025-12-24','Reboco de 05 salas',1,'2026-02-09 10:22:53'),(30,13,1,300.00,'2025-12-24','Reboco de 01 sala',1,'2026-02-09 10:23:55'),(31,6,1,180.00,'2025-12-24','pagamento',1,'2026-02-09 10:24:21'),(32,9,1,180.00,'2025-12-24','pagamento',1,'2026-02-09 10:24:46'),(33,14,1,392.00,'2025-12-26','pagamento',1,'2026-02-09 10:27:47'),(34,15,1,250.00,'2025-12-26','pagamento',1,'2026-02-09 10:28:37'),(35,15,1,500.00,'2025-12-26','pagamento',1,'2026-02-09 10:29:11'),(36,16,1,600.00,'2025-12-26','Reboco de 02 sala',1,'2026-02-09 10:30:21'),(37,2,1,400.00,'2025-12-26','pagamento',1,'2026-02-09 10:36:08'),(38,1,1,400.00,'2025-12-26','pagamento',1,'2026-02-09 10:36:40'),(39,10,1,300.00,'2025-12-26','Reboco de 01 sala',1,'2026-02-09 10:37:59'),(40,7,1,200.00,'2025-12-26','pagamento',1,'2026-02-09 10:38:42'),(41,17,1,920.00,'2025-12-27','pagamento',1,'2026-02-09 10:39:57'),(42,18,1,250.00,'2025-12-29','pagamento',1,'2026-02-09 10:41:18'),(43,19,1,250.00,'2025-12-29','pagamento',1,'2026-02-09 10:43:14'),(44,16,1,600.00,'2025-12-29','pagamento',1,'2026-02-09 10:44:31'),(45,16,1,70.00,'2025-12-29','pagamento',1,'2026-02-09 10:44:47'),(46,19,1,80.00,'2025-12-29','pagamento',1,'2026-02-09 10:45:10'),(47,19,1,280.00,'2025-12-29','pagamento',1,'2026-02-09 12:05:57'),(48,16,1,600.00,'2025-12-29','pagamento',1,'2026-02-09 12:06:28'),(49,16,1,70.00,'2025-12-29','pagamento',1,'2026-02-09 12:07:21'),(50,19,1,70.00,'2025-12-29','pagamento',1,'2026-02-09 12:08:23'),(51,20,1,480.00,'2025-12-29','pagamento',1,'2026-02-09 12:09:52'),(52,21,1,2289.60,'2025-12-29','Assentamento de cerâmica',1,'2026-02-09 12:10:46'),(53,20,1,648.00,'2025-12-30','pagamento',1,'2026-02-09 12:12:03'),(54,22,1,2289.60,'2025-12-31','Assentamento de cerâmica',1,'2026-02-09 12:17:28'),(55,20,1,312.00,'2025-12-31','pagamento',1,'2026-02-09 12:18:05'),(56,20,1,100.00,'2025-12-31','pagamento',1,'2026-02-09 12:18:24'),(57,7,1,400.00,'2025-12-31','pagamento',1,'2026-02-09 12:18:56'),(58,6,1,450.00,'2025-12-31','pagamento',1,'2026-02-09 12:19:21'),(59,9,1,720.00,'2025-12-31','pagamento',1,'2026-02-09 12:19:44'),(60,23,1,360.00,'2025-12-31','pagamento',1,'2026-02-09 12:20:49'),(61,9,1,90.00,'2025-12-31','pagamento',1,'2026-02-09 12:21:18'),(62,22,1,2289.60,'2026-01-02','Assentamento de cerâmica',1,'2026-02-09 12:24:11'),(63,21,1,2289.60,'2026-01-02','Assentamento de cerâmica',1,'2026-02-09 12:24:40'),(64,24,1,3000.00,'2026-01-03','pagamento',1,'2026-02-09 12:26:18'),(65,2,1,400.00,'2026-01-03','pagamento',1,'2026-02-09 12:26:42'),(66,1,1,400.00,'2026-01-03','pagamento',1,'2026-02-09 12:27:01'),(67,13,1,1200.00,'2026-01-06','pagamento',1,'2026-02-09 12:27:33'),(68,25,1,500.00,'2026-01-07','pagamento',1,'2026-02-09 12:29:50'),(69,24,1,300.00,'2026-01-07','pagamento',1,'2026-02-09 12:30:11'),(70,22,1,2289.60,'2026-01-08','Assentamento de cerâmica - Eliana de jesus Alves',1,'2026-02-09 12:32:15'),(71,21,1,2289.60,'2026-01-09','Assentamento de cerâmica - Ludmila de Oliveira',1,'2026-02-09 12:34:23'),(72,21,1,2289.60,'2026-01-09','Assentamento de cerâmica',1,'2026-02-09 12:35:09'),(73,25,1,800.00,'2026-01-09','pagamento',1,'2026-02-09 12:36:41'),(74,2,1,400.00,'2026-01-09','pagamento',1,'2026-02-09 12:37:05'),(75,1,1,400.00,'2026-01-09','pagamento',1,'2026-02-09 12:38:00'),(76,26,1,430.00,'2026-01-10','pagamento',1,'2026-02-09 12:39:58'),(77,7,1,500.00,'2026-01-10','pagamento',1,'2026-02-09 12:41:59'),(78,6,1,450.00,'2026-01-10','pagamento',1,'2026-02-09 12:42:26'),(79,4,1,450.00,'2026-01-10','pagamento',1,'2026-02-09 12:43:02'),(80,27,1,250.00,'2026-01-10','pagamento',1,'2026-02-09 12:43:52'),(81,3,1,550.00,'2026-01-10','pagamento',1,'2026-02-09 12:44:23'),(82,22,1,2289.60,'2026-01-13','Assentamento de cerâmica - Eliana de jesus Alves',1,'2026-02-09 12:47:18'),(83,25,1,520.00,'2026-01-13','pagamento',1,'2026-02-09 12:47:43'),(84,28,1,2759.70,'2026-01-16','Assentamento de cerâmica',1,'2026-02-09 12:50:34'),(85,21,1,1809.70,'2026-01-15','pagamento',1,'2026-02-09 12:51:06'),(86,1,1,500.00,'2026-01-16','pagamento',1,'2026-02-09 12:53:01'),(87,2,1,400.00,'2026-01-16','pagamento',1,'2026-02-09 12:53:27'),(88,29,1,2000.00,'2026-01-16','pagamento',1,'2026-02-09 12:55:05'),(89,25,1,900.00,'2026-01-16','pagamento',1,'2026-02-09 12:56:29'),(90,25,1,920.00,'2026-01-16','pagamento',1,'2026-02-09 12:56:40'),(91,13,1,1999.75,'2026-01-17','pagamento',1,'2026-02-09 12:57:15'),(92,3,1,400.00,'2026-01-17','pagamento',1,'2026-02-09 12:57:37'),(93,7,1,400.00,'2026-01-17','pagamento',1,'2026-02-09 12:58:00'),(94,6,1,360.00,'2026-01-17','pagamento',1,'2026-02-09 12:58:35'),(95,30,1,2613.00,'2026-01-17','pagamento',1,'2026-02-09 13:09:01'),(96,31,1,450.00,'2026-01-18','pagamento',1,'2026-02-09 13:09:45'),(97,32,1,17200.00,'2026-01-19','pagamento',1,'2026-02-09 13:12:03'),(98,7,1,110.00,'2026-01-19','pagamento',1,'2026-02-09 13:13:32'),(99,25,1,500.00,'2026-01-20','pagamento',1,'2026-02-09 13:14:24'),(100,26,1,960.00,'2026-01-22','pagamento',1,'2026-02-09 13:16:31'),(101,33,1,470.00,'2026-01-22','pagamento',1,'2026-02-09 13:17:39'),(102,28,1,4312.50,'2026-01-22','Assentamento de cerâmica',1,'2026-02-09 13:18:12'),(103,34,1,250.00,'2026-01-22','pagamento',1,'2026-02-09 13:19:09'),(104,2,1,400.00,'2026-01-23','pagamento',1,'2026-02-09 13:19:58'),(105,1,1,500.00,'2026-01-23','pagamento',1,'2026-02-09 13:20:20'),(106,33,1,129.00,'2026-01-24','pagamento',1,'2026-02-09 13:20:44'),(107,31,1,337.00,'2026-01-24','pagamento',1,'2026-02-09 13:21:10'),(108,27,1,450.00,'2026-01-24','pagamento',1,'2026-02-09 13:22:11'),(109,35,1,150.00,'2026-01-24','pagamento',1,'2026-02-09 13:22:53'),(110,13,1,1000.00,'2026-01-24','pagamento',1,'2026-02-09 13:23:18'),(111,21,1,2781.00,'2026-01-26','Assentamento de cerâmica',1,'2026-02-09 13:23:52'),(112,11,1,243.00,'2026-01-26','Aluguel de andaimes',1,'2026-02-09 13:25:52'),(113,21,1,810.00,'2026-01-27','pagamento',1,'2026-02-09 13:26:19'),(114,36,1,1988.00,'2026-01-27','pagamento',1,'2026-02-09 13:27:26'),(115,28,1,300.00,'2026-01-29','pagamento',1,'2026-02-09 13:28:54'),(116,7,1,700.00,'2026-01-30','pagamento',1,'2026-02-09 13:30:36'),(117,33,1,90.00,'2026-01-31','pagamento',1,'2026-02-09 13:31:22'),(118,1,1,500.00,'2026-01-31','pagamento',1,'2026-02-09 13:31:45'),(119,2,1,400.00,'2026-01-31','pagamento',1,'2026-02-09 13:32:31'),(120,30,1,2500.00,'2026-01-31','pagamento',1,'2026-02-09 13:33:03'),(121,37,1,1000.00,'2026-01-31','pagamento',1,'2026-02-09 13:34:09'),(122,29,1,2000.00,'2026-02-03','Elétrica',1,'2026-02-09 14:07:55'),(123,38,1,1500.00,'2025-12-29','Pagamento em dinheiro',1,'2026-02-09 14:10:46'),(124,38,1,3500.00,'2026-02-03','Pagamento - Geniele da Silva S',1,'2026-02-09 14:11:32'),(125,38,1,3500.00,'2026-02-03','Pagamento - Marcelo da Silva S',1,'2026-02-09 14:11:58'),(126,37,1,1250.00,'2026-02-03','Instalação de forro',1,'2026-02-09 14:16:59'),(127,28,1,300.00,'2026-02-05','pagamento',1,'2026-02-09 14:20:33'),(128,39,1,4095.00,'2026-02-06','pagamento',1,'2026-02-09 14:23:26'),(129,39,1,4095.00,'2026-02-12','pagamento',0,'2026-02-09 14:23:44'),(130,30,1,2000.00,'2026-02-09','pagamento',1,'2026-02-09 14:24:23'),(131,1,1,500.00,'2026-02-09','pagamento',1,'2026-02-09 14:24:52'),(132,2,1,400.00,'2026-02-09','pagamento',1,'2026-02-09 14:25:10'),(133,27,1,400.00,'2026-02-09','pagamento',1,'2026-02-09 14:26:29'),(134,38,1,4336.34,'2026-02-13','R$ 12.836,64 (R$ 8.500,00 PG)',0,'2026-02-09 14:32:28'),(135,40,1,23876.01,'2026-02-09','pagamento',1,'2026-02-09 14:46:46');
/*!40000 ALTER TABLE `person_payments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `revenues`
--

DROP TABLE IF EXISTS `revenues`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `revenues` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `service_id` int(11) DEFAULT NULL,
  `description` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `received_date` date NOT NULL,
  `status` enum('received','to_receive') DEFAULT 'to_receive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `fk_revenues_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_revenues_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `revenues`
--

LOCK TABLES `revenues` WRITE;
/*!40000 ALTER TABLE `revenues` DISABLE KEYS */;
INSERT INTO `revenues` VALUES (2,1,1,'Recebimento: Revestimento',40000.00,'2026-02-08','received','2026-02-08 10:36:30'),(3,1,2,'Recebimento: Telhado',40000.00,'2026-02-08','received','2026-02-08 10:37:10');
/*!40000 ALTER TABLE `revenues` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percentage_work` decimal(5,2) DEFAULT 0.00,
  `value` decimal(10,2) DEFAULT 0.00,
  `executed_percentage` decimal(5,2) DEFAULT 0.00,
  `paid_value` decimal(10,2) DEFAULT 0.00,
  `status` enum('pendente','finalizado') DEFAULT 'pendente',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  CONSTRAINT `fk_services_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,1,'Revestimento',20.00,40836.26,100.00,40000.00,'finalizado','2026-02-07 21:56:54'),(2,1,'Telhado',20.00,40836.26,100.00,40000.00,'finalizado','2026-02-07 22:14:31'),(3,1,'Elétrica',20.00,40836.26,100.00,0.00,'finalizado','2026-02-07 22:19:31'),(4,1,'Pintura',20.00,40836.26,60.00,0.00,'pendente','2026-02-07 22:19:54'),(5,1,'Instalações Hidrosanitárias',10.00,20418.13,75.00,0.00,'pendente','2026-02-07 22:20:12'),(6,1,'Serviços Diversos',10.00,20418.13,58.00,0.00,'pendente','2026-02-07 22:20:29');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sub_services`
--

DROP TABLE IF EXISTS `sub_services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `sub_services` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `service_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `percentage_service` decimal(5,2) DEFAULT 0.00,
  `value` decimal(10,2) DEFAULT 0.00,
  `executed_percentage` decimal(5,2) DEFAULT 0.00,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  CONSTRAINT `fk_sub_services_service` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sub_services`
--

LOCK TABLES `sub_services` WRITE;
/*!40000 ALTER TABLE `sub_services` DISABLE KEYS */;
INSERT INTO `sub_services` VALUES (1,5,'Instalação de Pia Cozinha',20.00,4083.63,100.00,'2026-02-07 22:36:22'),(2,5,'Instalação de Pia - Lava Pano',15.00,3062.72,0.00,'2026-02-07 22:36:39'),(3,5,'Revisão de banheiro Masculino e Femino',40.00,8167.25,100.00,'2026-02-07 22:37:03'),(4,5,'Revisão Banheiro Administrativo',15.00,3062.72,100.00,'2026-02-07 22:37:20'),(5,5,'Instalação de Caixa de Gordura Cozinha',10.00,2041.81,0.00,'2026-02-07 22:41:09'),(6,6,'Calçada frente escola',30.00,6125.44,55.00,'2026-02-07 22:49:36'),(7,6,'Calçada fundo Escola',30.00,6125.44,60.00,'2026-02-07 22:49:52'),(8,6,'Instalação de Grelha Pátio',20.00,4083.63,100.00,'2026-02-07 22:50:29'),(9,6,'Instalação de serviços diversos',20.00,4083.63,17.50,'2026-02-07 22:51:13');
/*!40000 ALTER TABLE `sub_services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tasks`
--

DROP TABLE IF EXISTS `tasks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tasks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text DEFAULT NULL,
  `status` enum('todo','in_progress','done') DEFAULT 'todo',
  `priority` enum('low','medium','high') DEFAULT 'medium',
  `deadline` date DEFAULT NULL,
  `responsible_id` int(11) DEFAULT NULL,
  `column_index` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `work_id` (`work_id`),
  KEY `responsible_id` (`responsible_id`),
  CONSTRAINT `fk_tasks_responsible` FOREIGN KEY (`responsible_id`) REFERENCES `people` (`id`) ON DELETE SET NULL,
  CONSTRAINT `fk_tasks_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tasks`
--

LOCK TABLES `tasks` WRITE;
/*!40000 ALTER TABLE `tasks` DISABLE KEYS */;
INSERT INTO `tasks` VALUES (1,1,'Instalação de Caixa de Gordura','Instalar caixa de gordura na cozinha','todo','medium','2026-02-13',1,0,'2026-02-07 23:14:47'),(2,1,'Instalação de Janela de Vidro no AEE','','todo','medium','2026-02-19',2,0,'2026-02-07 23:15:13');
/*!40000 ALTER TABLE `tasks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_permissions`
--

DROP TABLE IF EXISTS `user_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `resource` varchar(50) NOT NULL,
  `can_list` tinyint(1) DEFAULT 0,
  `can_create` tinyint(1) DEFAULT 0,
  `can_read` tinyint(1) DEFAULT 0,
  `can_update` tinyint(1) DEFAULT 0,
  `can_delete` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `fk_user_permissions` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_permissions`
--

LOCK TABLES `user_permissions` WRITE;
/*!40000 ALTER TABLE `user_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','manager','user') DEFAULT 'user',
  `must_change_password` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrador','avanteservico@gmail.com','$2y$10$gXQcJI1rBayWKLr5g9.dd.bOeWTwaXFLPxOIeXcWv/eVamYdrQqyi','admin',0,'2026-02-07 20:34:54'),(2,'Neris Farias','nerisfarias@gmail.com','$2y$10$Btasy3bFD6yAhgBNjT.dEOZ6rOCeonlH5df3ISIjAXTcUt4lnq0NW','user',0,'2026-02-08 01:19:59'),(3,'Ingrid Docilio','dociliofarias@gmail.com','$2y$10$f3325LYdfnb5ujhq43szh.oeei4W0oEicZvJjRXB44G4SPAcD9Kaa','user',1,'2026-02-08 18:52:58');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `works`
--

DROP TABLE IF EXISTS `works`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `works` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `address` text DEFAULT NULL,
  `reference_point` text DEFAULT NULL,
  `total_value` decimal(10,2) DEFAULT 0.00,
  `start_date` date DEFAULT NULL,
  `end_date_prediction` date DEFAULT NULL,
  `status` enum('active','completed','paused','canceled') DEFAULT 'active',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `works`
--

LOCK TABLES `works` WRITE;
/*!40000 ALTER TABLE `works` DISABLE KEYS */;
INSERT INTO `works` VALUES (1,'Reforma Escola José de Anchieta','Bairro Várzea Alegre','Várzea Alegre',204181.32,'2025-12-04','2026-02-14','active','2026-02-07 21:55:46');
/*!40000 ALTER TABLE `works` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-02-09 21:19:29
