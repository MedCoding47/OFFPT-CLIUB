-- MySQL dump 10.13  Distrib 8.0.28, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: gest_club
-- ------------------------------------------------------
-- Server version	8.0.28

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
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
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activities` (
  `id` int NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` datetime NOT NULL,
  `type` enum('Social Activities','Exclusive Events','Donate & Volunteer') NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activities`
--

LOCK TABLES `activities` WRITE;
/*!40000 ALTER TABLE `activities` DISABLE KEYS */;
INSERT INTO `activities` VALUES (3,'el houz seiseme','L\'Office de la Formation Professionnelle et de la Promotion du Travail (OFPPT) du Maroc a joué un rôle significatif dans l\'aide apportée suite au séisme qui a frappé la région d\'Al Haouz. Voici une description détaillée des actions et initiatives prises par l\'OFPPT :\r\n\r\nMobilisation des Ressources Humaines et Matérielles\r\nL\'OFPPT a rapidement mobilisé ses équipes et ressources pour apporter une aide immédiate et efficace aux victimes du séisme. \r\n','2024-06-24 14:03:00','Social Activities','https://static.medias24.com/content/uploads/2023/09/11/376830536_640905634797540_7421061514485206225_n.jpg?x56132'),(4,'Iftars ramadan','L\'OFPPT organise des campagnes de distribution de paniers alimentaires pour les familles démunies. Ces paniers contiennent des produits de première nécessité tels que du riz, de la farine, de l\'huile, du sucre, du thé, des dattes, et d\'autres denrées de base pour soutenir les familles pendant le mois de jeûne.\r\n\r\nIftars Collectifs\r\n','2024-06-04 19:19:00','Donate & Volunteer','https://pbs.twimg.com/media/EV05mLXXkAEIZd5.jpg'),(5,'don de sang','l\'Office de la Formation Professionnelle et de la Promotion du Travail (OFPPT) joue un rôle crucial en organisant des campagnes de don de sang en collaboration avec des centres de transfusion sanguine à travers le pays. Ces initiatives altruistes visent à mobiliser les étudiants, le personnel éducatif et administratif, ainsi que la communauté environnante pour participer à une cause noble et vitale : le don de sang.\r\n\r\n','2024-08-03 08:00:00','Social Activities','https://media.licdn.com/dms/image/D4E22AQEexVmv8mFhYw/feedshare-shrink_800/0/1698750287763?e=2147483647&v=beta&t=3V8W-39cI_OvMMTikntgWk_MIf_xjvkKNfP4Y6GaDsw'),(7,'test','test','2024-08-09 08:00:00','Social Activities','https://pbs.twimg.com/media/EV05mLXXkAEIZd5.jpg');
/*!40000 ALTER TABLE `activities` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `activity_images`
--

DROP TABLE IF EXISTS `activity_images`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `activity_images` (
  `id` int NOT NULL AUTO_INCREMENT,
  `activity_id` int NOT NULL,
  `image_url` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `activity_id` (`activity_id`),
  CONSTRAINT `activity_images_ibfk_1` FOREIGN KEY (`activity_id`) REFERENCES `activities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `activity_images`
--

LOCK TABLES `activity_images` WRITE;
/*!40000 ALTER TABLE `activity_images` DISABLE KEYS */;
/*!40000 ALTER TABLE `activity_images` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `adherents`
--

DROP TABLE IF EXISTS `adherents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `adherents` (
  `CodeAdhrents` int NOT NULL AUTO_INCREMENT,
  `Coderesponsable` int DEFAULT NULL,
  `CodeClub` int DEFAULT NULL,
  `Nom` varchar(30) DEFAULT NULL,
  `prenom` varchar(30) DEFAULT NULL,
  `telephone` varchar(30) DEFAULT NULL,
  `pwd` varchar(45) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `fielere` enum('DD','DI','GE') DEFAULT NULL,
  `valide` tinyint(1) DEFAULT (false),
  `picture` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`CodeAdhrents`),
  KEY `Coderesponsable` (`Coderesponsable`),
  KEY `CodeClub` (`CodeClub`),
  CONSTRAINT `adherents_ibfk_1` FOREIGN KEY (`Coderesponsable`) REFERENCES `responsable` (`Code`),
  CONSTRAINT `adherents_ibfk_2` FOREIGN KEY (`CodeClub`) REFERENCES `club` (`CodeClub`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `adherents`
--

LOCK TABLES `adherents` WRITE;
/*!40000 ALTER TABLE `adherents` DISABLE KEYS */;
INSERT INTO `adherents` VALUES (15,NULL,2,'elhtab','soufian','0607302999','123123','soufian@gmail.com','DI',1,'pic.png'),(16,NULL,1,'AYAT','mohamed','0607302999','123123','mohamedayat148@gmail.com','DD',1,'download (2).jpg'),(18,NULL,2,'ahmed','show','0607302999','0123456','ahmeddowsari@gmail.com','GE',1,NULL),(27,NULL,3,'yasser','nouach','0607302999','123123','soufian@gmail.com','DD',1,NULL),(28,NULL,4,'saad','moubarik','0607302999','123123','soufian@gmail.com','DD',1,NULL),(29,NULL,5,'charif','mohamed','0607302999','123123','charif@gmail.com','GE',1,NULL),(30,NULL,3,'test','test','0607302999','1234','test@gmail.com','DD',1,'download (2).jpg');
/*!40000 ALTER TABLE `adherents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `club`
--

DROP TABLE IF EXISTS `club`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `club` (
  `CodeClub` int NOT NULL AUTO_INCREMENT,
  `Libelle` varchar(255) DEFAULT NULL,
  `CodeResp` int DEFAULT NULL,
  PRIMARY KEY (`CodeClub`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `club`
--

LOCK TABLES `club` WRITE;
/*!40000 ALTER TABLE `club` DISABLE KEYS */;
INSERT INTO `club` VALUES (1,'Gaming Guild',1),(2,'Fitness Fanatics',2),(3,'Bookworms Society',3),(4,'Art Appreciation Club',4),(5,'Music Melodies Club',5);
/*!40000 ALTER TABLE `club` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evenements`
--

DROP TABLE IF EXISTS `evenements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `evenements` (
  `code` int NOT NULL AUTO_INCREMENT,
  `CodeClub` int DEFAULT NULL,
  `jourP` date DEFAULT NULL,
  `DateR` date DEFAULT NULL,
  `Description` text,
  `Observation` text,
  `picture_path` varchar(255) DEFAULT NULL,
  `nom_event` varchar(255) NOT NULL,
  PRIMARY KEY (`code`),
  KEY `CodeClub` (`CodeClub`),
  CONSTRAINT `evenements_ibfk_1` FOREIGN KEY (`CodeClub`) REFERENCES `club` (`CodeClub`)
) ENGINE=InnoDB AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evenements`
--

LOCK TABLES `evenements` WRITE;
/*!40000 ALTER TABLE `evenements` DISABLE KEYS */;
INSERT INTO `evenements` VALUES (38,1,'2024-06-19','2024-06-19','Organisez un tournoi de jeux vidéo avec des catégories pour différents types de jeux (FPS, MOBA, sports, etc.). Les participants peuvent s\'affronter pour des prix.',' Événement compétitif pour les passionnés de jeux vidéo.','images/E-sports Game Room Design And Decoration Esports Gaming Room E-sports Gaming Hotel - Buy E-sports Game Room Design And Decoration,E-sports Gaming Room,E-sports Gaming Hotel Product on Alibaba_com.jpg','Tournoi de Jeu Vidéo'),(39,1,'2024-06-27','2024-06-29','Une nuit entière dédiée aux jeux en réseau local où les membres peuvent apporter leurs propres ordinateurs ou consoles et jouer ensemble.','Événement social et amusant.','images/Luxury Gaming Room Idea l game room setup l game room decor l game room lighting l GTA l PUBG.jpg',' Nuit de Lan Party'),(40,2,'2024-07-03','2024-07-03','Un entraînement de haute intensité en plein air dirigé par un coach professionnel. Idéal pour tous les niveaux de forme physique.','Activité de remise en forme intense.\r\n','images/The Battle Royal Team Building Workout.jpg','Bootcamp en Plein Air'),(41,2,'2024-06-24','2024-06-25','Séance de yoga en groupe pour améliorer la flexibilité, la force et la relaxation. Convient à tous les niveaux.','Activité de bien-être.','images/Yoga Poses for Your Body and Mind.jpg','Cours de Yoga en Groupe'),(42,3,'2024-06-19','2024-06-20','Réunion mensuelle où les membres discutent d\'un livre sélectionné à l\'avance. Discussions profondes et échanges d\'idées.','Activité sociale et intellectuelle.','images/de casa al club.jpg','Club de Lecture Mensuel'),(43,4,'2024-06-26','2024-06-28','Visite guidée d\'une galerie d\'art locale avec des explications sur les œuvres exposées. Discussion avec des artistes.','Activité culturelle.','images/download (1).jpg','Visite de Galerie d\'Art'),(44,3,'2024-06-20','2024-06-24','Atelier interactif pour améliorer les compétences en écriture créative. Animé par un auteur local.','Développement des compétences littéraires.','images/Process - Product Design and Engineering Services.jpg','Atelier d\'Écriture Créative'),(45,4,'2024-06-17','2024-06-20','Atelier de peinture où les membres peuvent apprendre différentes techniques et créer leurs propres œuvres. Matériel fourni.','Activité pratique et créative.','images/L\'atelier aux couleurs.jpg','Atelier de Peinture'),(46,5,'2024-06-21','2024-06-25','Session de jam ouverte où les membres peuvent apporter leurs instruments et jouer ensemble, partager des idées et improviser.','Activité musicale et collaborative.','images/9ae0b93e-a726-4615-ad17-19fc6d157f79.jpg',' Jam Session'),(47,5,'2024-06-20','2024-06-27','Concert organisé par les membres du club où chacun peut se produire devant les autres. Encouragement et feedback constructif.','Événement de performance.','images/CONCERT AESTHETIC.jpg','Concert de Membres');
/*!40000 ALTER TABLE `evenements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventparticipants`
--

DROP TABLE IF EXISTS `eventparticipants`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventparticipants` (
  `id` int NOT NULL AUTO_INCREMENT,
  `CodeAdhrents` int DEFAULT NULL,
  `event_id` int DEFAULT NULL,
  `payment_status` enum('paid','unpaid') DEFAULT 'unpaid',
  PRIMARY KEY (`id`),
  KEY `CodeAdhrents` (`CodeAdhrents`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `eventparticipants_ibfk_1` FOREIGN KEY (`CodeAdhrents`) REFERENCES `adherents` (`CodeAdhrents`),
  CONSTRAINT `eventparticipants_ibfk_2` FOREIGN KEY (`event_id`) REFERENCES `evenements` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventparticipants`
--

LOCK TABLES `eventparticipants` WRITE;
/*!40000 ALTER TABLE `eventparticipants` DISABLE KEYS */;
INSERT INTO `eventparticipants` VALUES (12,15,41,'paid'),(13,15,40,'paid'),(14,16,38,'paid'),(15,16,39,'paid');
/*!40000 ALTER TABLE `eventparticipants` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `eventphotos`
--

DROP TABLE IF EXISTS `eventphotos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `eventphotos` (
  `id` int NOT NULL AUTO_INCREMENT,
  `event_id` int NOT NULL,
  `photo_path` varchar(255) NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `approved` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `event_id` (`event_id`),
  CONSTRAINT `eventphotos_ibfk_1` FOREIGN KEY (`event_id`) REFERENCES `evenements` (`code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `eventphotos`
--

LOCK TABLES `eventphotos` WRITE;
/*!40000 ALTER TABLE `eventphotos` DISABLE KEYS */;
/*!40000 ALTER TABLE `eventphotos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `messages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sender_id` int DEFAULT NULL,
  `receiver_id` int DEFAULT NULL,
  `message` text,
  `timestamp` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
INSERT INTO `messages` VALUES (1,16,1,'salam','2024-06-01 15:49:38'),(2,7,1,'hhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhhh','2024-06-01 15:49:54'),(3,16,1,'how can i help u','2024-06-01 15:53:59'),(4,16,1,'cc\n','2024-06-01 15:55:21'),(5,19,1,'khoya golia','2024-06-01 15:56:19'),(6,19,1,'ngolik','2024-06-01 15:56:44'),(7,19,1,'mmmmmmmmmmmm','2024-06-01 16:12:48'),(8,19,1,'hhhhhhhhhhhhh','2024-06-01 16:12:57'),(9,19,1,'nnnnnnnnnnnnnnnnnnn','2024-06-01 16:13:01'),(10,19,1,'hhhhhhhhhhhh\n','2024-06-01 16:13:32'),(11,16,1,'heey','2024-06-01 16:15:02'),(12,7,1,'hey','2024-06-01 16:15:19'),(13,16,1,'hhhhhhhhhhhhhhhh','2024-06-01 16:15:46'),(14,16,1,'mlk\n','2024-06-01 16:15:56'),(15,16,1,'wa lhmaaaaaaaaaaaaa9','2024-06-01 16:16:11'),(16,16,1,'golia','2024-06-01 16:18:16'),(17,16,1,'la fac wla kolia hhhhhhhhhhhhhh','2024-06-01 16:18:32'),(18,7,1,'golia\n','2024-06-01 16:45:00'),(19,16,1,'salam','2024-06-01 16:45:30'),(20,16,1,'oui','2024-06-01 16:59:44'),(21,16,1,'hhhhh','2024-06-01 17:23:30'),(22,16,1,'golia','2024-06-01 17:26:11'),(23,22,1,'MERCI !','2024-06-01 18:48:42'),(24,22,1,'§§\n','2024-06-01 18:50:00'),(25,22,1,'DE RIEN','2024-06-01 18:50:12'),(26,19,1,'heey','2024-06-02 09:34:07'),(27,19,1,'i wanna now why','2024-06-02 09:34:24'),(28,16,1,'salam','2024-06-02 09:43:33'),(29,16,1,'zzz','2024-06-02 09:44:00'),(30,22,1,'how can i help u','2024-06-02 18:20:05'),(31,16,1,'khoya','2024-06-02 18:23:08'),(32,16,1,'oui khoya','2024-06-02 18:23:24'),(33,16,1,'3fk bdl bghit nbdl club diali','2024-06-02 18:24:30'),(34,16,1,'hey','2024-06-02 18:37:54'),(35,16,1,'yes\n','2024-06-02 18:38:08'),(36,19,1,'heey','2024-06-02 18:38:41'),(37,19,1,'oui\n','2024-06-02 18:39:11'),(38,19,1,'salam','2024-06-02 18:44:57'),(39,19,1,'oui khoya','2024-06-02 18:45:12'),(40,19,1,'salam khoya','2024-06-03 10:34:45'),(41,19,1,'hey','2024-06-03 10:50:43'),(42,19,1,'heey','2024-06-03 11:00:22'),(43,19,1,'oui','2024-06-03 11:01:06'),(44,19,1,'hey','2024-06-03 11:06:11'),(45,19,1,'haaaaaaaaaaaaay youssef','2024-06-03 11:11:16'),(46,19,1,'bonjour','2024-06-03 11:18:42'),(47,16,1,'heey','2024-06-03 11:50:04'),(48,16,1,'heey','2024-06-03 14:54:53'),(49,16,1,'oui comment\n','2024-06-03 14:55:10'),(50,16,1,'hhhh','2024-06-03 15:02:31'),(51,16,1,'bbb','2024-06-03 15:02:51'),(52,16,1,'heey','2024-06-04 10:20:31'),(53,16,1,'oui how can i help u','2024-06-04 10:20:47'),(54,16,1,'heey','2024-06-04 10:25:22'),(55,16,1,'salam','2024-06-05 06:51:54'),(56,15,1,'hey','2024-06-05 13:32:03'),(57,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:11'),(58,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:13'),(59,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:13'),(60,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:17'),(61,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:17'),(62,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:17'),(63,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:18'),(64,7,NULL,'tell me where can i find the event\n','2024-06-05 13:33:18'),(65,15,1,'kk','2024-06-05 13:33:51'),(66,16,1,'heeeey','2024-06-05 13:47:28'),(67,16,1,'salam','2024-06-05 14:58:00'),(68,16,1,'heey','2024-06-05 15:23:15'),(69,16,1,'heey','2024-06-05 15:23:16'),(70,16,1,'heey','2024-06-05 15:23:16'),(71,16,1,'heey','2024-06-05 15:23:16'),(72,16,1,'heey','2024-06-05 15:23:16'),(73,16,1,'heey','2024-06-05 15:23:16'),(74,16,1,'salam','2024-06-05 15:24:15');
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `paiements`
--

DROP TABLE IF EXISTS `paiements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `paiements` (
  `CodeClub` int NOT NULL,
  `prix` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`CodeClub`),
  CONSTRAINT `paiements_ibfk_1` FOREIGN KEY (`CodeClub`) REFERENCES `club` (`CodeClub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `paiements`
--

LOCK TABLES `paiements` WRITE;
/*!40000 ALTER TABLE `paiements` DISABLE KEYS */;
/*!40000 ALTER TABLE `paiements` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_resets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `expires` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `password_resets`
--

LOCK TABLES `password_resets` WRITE;
/*!40000 ALTER TABLE `password_resets` DISABLE KEYS */;
INSERT INTO `password_resets` VALUES (1,'mohamedayat148@gmail.com','c7549a8ae6528cc8c9361b244e986a8656bfe8cd39c5256018ca32cffcecfad5ec28b192320d5c9554ac561cf56a0490d32a','2024-06-01 23:53:26');
/*!40000 ALTER TABLE `password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `responsable`
--

DROP TABLE IF EXISTS `responsable`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `responsable` (
  `Code` int NOT NULL AUTO_INCREMENT,
  `Nom` varchar(255) DEFAULT NULL,
  `Email` varchar(255) DEFAULT NULL,
  `Address` varchar(255) DEFAULT NULL,
  `Role` varchar(50) DEFAULT NULL,
  `DateOfBirth` date DEFAULT NULL,
  `Gender` char(1) DEFAULT NULL,
  `Phone` varchar(15) DEFAULT NULL,
  `pwd` varchar(45) DEFAULT NULL,
  PRIMARY KEY (`Code`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `responsable`
--

LOCK TABLES `responsable` WRITE;
/*!40000 ALTER TABLE `responsable` DISABLE KEYS */;
INSERT INTO `responsable` VALUES (7,'mohamed ayat','mohamedayat148@gmail.com','RES AL FERDAOUS IMM 232 APT 16 OULFA CASA','responsable','2024-05-31','m','0607302999','2004Ayat');
/*!40000 ALTER TABLE `responsable` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reviews`
--

DROP TABLE IF EXISTS `reviews`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `reviews` (
  `id` int NOT NULL AUTO_INCREMENT,
  `CodeAdhrents` int DEFAULT NULL,
  `event_code` int DEFAULT NULL,
  `review` text,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `CodeAdhrents` (`CodeAdhrents`),
  KEY `event_code` (`event_code`),
  CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`CodeAdhrents`) REFERENCES `adherents` (`CodeAdhrents`),
  CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`event_code`) REFERENCES `evenements` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reviews`
--

LOCK TABLES `reviews` WRITE;
/*!40000 ALTER TABLE `reviews` DISABLE KEYS */;
INSERT INTO `reviews` VALUES (10,16,38,'bonne evenment','2024-06-05 11:42:19'),(11,15,39,'belle evenment','2024-06-05 11:45:02'),(12,30,42,'bon !','2024-06-05 16:13:38');
/*!40000 ALTER TABLE `reviews` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-06-05 18:32:48
