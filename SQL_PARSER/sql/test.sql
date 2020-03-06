-- MariaDB dump 10.17  Distrib 10.4.11-MariaDB, for Win64 (AMD64)
--
-- Host: localhost    Database: flashassistance
-- ------------------------------------------------------
-- Server version	10.4.11-MariaDB

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
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `client` (
  `idClient` varchar(45) NOT NULL,
  `idPerson` varchar(45) NOT NULL,
  PRIMARY KEY (`idClient`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `client`
--

LOCK TABLES `client` WRITE;
/*!40000 ALTER TABLE `client` DISABLE KEYS */;
/*!40000 ALTER TABLE `client` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `log`
--

DROP TABLE IF EXISTS `log`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `log` (
  `idLog` int(11) NOT NULL AUTO_INCREMENT,
  `dateInterv` date NOT NULL,
  `service` int(11) NOT NULL,
  `ponctu` tinyint(1) NOT NULL,
  PRIMARY KEY (`idLog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `log`
--

LOCK TABLES `log` WRITE;
/*!40000 ALTER TABLE `log` DISABLE KEYS */;
/*!40000 ALTER TABLE `log` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `orders` (
  `idOrder` int(11) NOT NULL AUTO_INCREMENT,
  `price` float NOT NULL,
  `idClient` int(11) NOT NULL,
  `idService` int(11) NOT NULL,
  `fees` int(11) NOT NULL,
  PRIMARY KEY (`idOrder`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `orders`
--

LOCK TABLES `orders` WRITE;
/*!40000 ALTER TABLE `orders` DISABLE KEYS */;
/*!40000 ALTER TABLE `orders` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `person`
--

DROP TABLE IF EXISTS `person`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `person` (
  `firstName` varchar(50) NOT NULL,
  `lastName` varchar(50) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phoneNumber` varchar(10) NOT NULL,
  `password` varchar(255) NOT NULL,
  `idPerson` varchar(45) NOT NULL,
  `function` varchar(50) NOT NULL,
  `localisation` varchar(50) NOT NULL,
  PRIMARY KEY (`idPerson`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `person`
--

LOCK TABLES `person` WRITE;
/*!40000 ALTER TABLE `person` DISABLE KEYS */;
INSERT INTO `person` VALUES ('a','b','c','d','e','02bb5045-0977-472f-bf62-5c5667fd2558','f','Paris');
INSERT INTO `person` VALUES ('azeaz','eaze','aez','eaz','aez','0ae01a3c-1bde-4258-b276-5dbf59e15704','eaz','Paris');
INSERT INTO `person` VALUES ('eaz','aze','aze','eazeza','eaz','0bf25ce2-417d-4e2d-b968-076471a12ec2','eza','Nantes');
INSERT INTO `person` VALUES ('aze','zae','eaz','ez','ezaez','0fb33a0f-48e3-4538-ad0b-0e2b6bbf3077','aze','Paris');
INSERT INTO `person` VALUES ('a','b','c','d','e','144f21db-74cf-4e3b-8811-33426f182b9b','f','Nantes');
INSERT INTO `person` VALUES ('az','za','azeeaz','aze','eaz','16de1d41-32a8-439a-a42c-5f830f333499','eaz','Paris');
INSERT INTO `person` VALUES ('a','','','','','186837ac-3124-4a75-89dd-05cf38872309','','');
INSERT INTO `person` VALUES ('sza','sa','as','azf','fza','19c532c9-3558-43ac-ac74-67197d2529be','azf','Nantes');
INSERT INTO `person` VALUES ('aeaz','eza','eza','eaz','eaez','1ee40b13-40f2-43f5-82af-4f2a3be1322a','aze','Paris');
INSERT INTO `person` VALUES ('a','b','csd','csdcds','cs','1f673e8c-4071-463b-b9eb-314374532c4f','csd','Paris');
INSERT INTO `person` VALUES ('eaz','eaz','aze','zea','zea','2aab5611-56a3-4b5a-94d7-459862ae316f','eaz','Paris');
INSERT INTO `person` VALUES ('David','C.','David@gmail.com','0678314212','AZERTY','34690af4-1399-467a-8d84-578d33f10c3d','','');
INSERT INTO `person` VALUES ('Thomas','D.','Thomas@gmail.com','1231','eZEZRR','3cef5168-0308-45c2-8711-1138338f3028','','');
INSERT INTO `person` VALUES ('casa','sa','sasa','sasa','sasa','3d1913c4-766a-49dd-a2eb-4a64718b2790','ssa','Marseille');
INSERT INTO `person` VALUES ('Luis','MIRANDA','L@gmail.com','0987654321','test','487033cb-1246-4ec4-bd07-3d053996739b','idki','Paris');
INSERT INTO `person` VALUES ('aze','aez','eazeaz','aze','aez','4aec26af-4a74-445b-99f3-0afa000135af','eaz','Paris');
INSERT INTO `person` VALUES ('aez','aez','eaz','eaz','eaz','4ccd5545-4e26-4fdf-b3c5-4e5d7d11368a','eazPa','Paris');
INSERT INTO `person` VALUES ('a','b','c','de','e','55ad4db7-00f7-4235-b9a9-5c5432fa2d88','f','Marseille');
INSERT INTO `person` VALUES ('aez','aez','aezaze','aez','eazzae','5d8677c2-653f-445d-bb0b-584b7f5c6012','eaz','Paris');
INSERT INTO `person` VALUES ('Thomas','SAMAAN','t@skype.2020','DESLETTRES','MOTDEPASSE','5e365677-5e4c-4075-a574-7be210be7568','DU C','Paris');
INSERT INTO `person` VALUES ('WORKER','WORKER123','WORKER@WORKER.com','1234','WORKER123','66f7033e-1545-402b-bda0-784c4d7771de','WORKERLOL','Tours');
INSERT INTO `person` VALUES ('xpto','E.','xpto@xD.com','1232141','ROOT','681d43e2-77ec-49b3-94f5-3e476cfc30ae','','');
INSERT INTO `person` VALUES ('zaee','aze','eza','eaz','eza','6ff53b6c-44a8-48fa-8128-1b5408562fee','eaz','Paris');
INSERT INTO `person` VALUES ('Thomas','Julien','sananes@esgi.qrcode','914005683','$argon2id$v=19$m=65536,t=4,p=1$aEo1cmQuMWFMbjFqd3RxbA$nAQhYZazJ4gnqXOgxM8BwbPzxC0BRdkVoEF1kmT1R+M','71b5366b-a833-42c4-853a-0210cf9a8767','','');
INSERT INTO `person` VALUES ('az','eazeza','eaz','ezaeza','ezae','77201e9e-2e6d-475c-b849-6cac2bca3410','eaz','Paris');
INSERT INTO `person` VALUES ('MARIA','AMELIA','A@gmail.com','12121','21313','7aae35b8-49b3-4dba-9631-306017f43039','123123','Paris');
INSERT INTO `person` VALUES ('Albert','L.','Alb@yahoo.fr','124214214','ADMIN123','7cf1328e-39fb-4d3e-a030-042922a24222','','');
INSERT INTO `person` VALUES ('E.','L.','c','PHONE','e','7d83612f-093f-4911-a53d-0d901e397c1d','f','Nantes');
INSERT INTO `person` VALUES ('Luis','MIRANDA','test@root.com','0798654312','$argon2id$v=19$m=65536,t=4,p=1$TWhuVllRTWZKZEguc2puaA$qlWFSKeQCb5TlE8V+t2nuHZlvUK1s3YavkLYlho9vg0','aea5e777-a891-4685-ae86-ebbf1563bdff','','');
INSERT INTO `person` VALUES ('Luis','MIRANDA','root@root.com','0603152112','$argon2id$v=19$m=65536,t=4,p=1$dWVRUUdyQ2lxNzVndWpLMg$K9pqSMOFPlLY60eWO17zVYrxlpVhVMy3xz8TrmZSAis','d4aad2c0-3641-4375-8875-ac7dc6d5a082','','');
INSERT INTO `person` VALUES ('Test','Dzed','test@test.com','0603154150','$argon2id$v=19$m=65536,t=4,p=1$VzBpZ2pPempicFRrUlNsRw$Gi2jAbDVsEysoLkYzn82GiBTCdfnJzOyGYzJDuSiqUs','eb616941-34c6-400b-ae7c-d36cd08d8eeb','','');
/*!40000 ALTER TABLE `person` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `service`
--

DROP TABLE IF EXISTS `service`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service` (
  `idService` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `demo` tinyint(1) NOT NULL,
  `price` double NOT NULL,
  `category` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`idService`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `service`
--

LOCK TABLES `service` WRITE;
/*!40000 ALTER TABLE `service` DISABLE KEYS */;
INSERT INTO `service` VALUES (1,'Child Care',0,64.99,'Care');
INSERT INTO `service` VALUES (2,'Lawn Mower',0,159.99,'Gardening');
/*!40000 ALTER TABLE `service` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `subscription`
--

DROP TABLE IF EXISTS `subscription`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `subscription` (
  `idSub` int(11) NOT NULL AUTO_INCREMENT,
  `nameSub` varchar(50) NOT NULL,
  PRIMARY KEY (`idSub`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `subscription`
--

LOCK TABLES `subscription` WRITE;
/*!40000 ALTER TABLE `subscription` DISABLE KEYS */;
/*!40000 ALTER TABLE `subscription` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `worker`
--

DROP TABLE IF EXISTS `worker`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `worker` (
  `idWorker` varchar(45) NOT NULL,
  `qrCode` varchar(255) NOT NULL,
  `idPerson` varchar(45) NOT NULL,
  PRIMARY KEY (`idWorker`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `worker`
--

LOCK TABLES `worker` WRITE;
/*!40000 ALTER TABLE `worker` DISABLE KEYS */;
INSERT INTO `worker` VALUES ('01b47c4e-5d11-4455-a2f1-46a014ea160a','qrcode.bmp','77201e9e-2e6d-475c-b849-6cac2bca3410');
INSERT INTO `worker` VALUES ('01f63a8d-5a72-4d7b-bf80-3da468302f5f','qrcode.bmp','2aab5611-56a3-4b5a-94d7-459862ae316f');
INSERT INTO `worker` VALUES ('07a90d0b-4cb6-469e-b28e-03e7325971d3','qrcode.bmp','66f7033e-1545-402b-bda0-784c4d7771de');
INSERT INTO `worker` VALUES ('0d861bfb-186a-4e95-8ada-6e701d0c16dc','qrcode.bmp','55ad4db7-00f7-4235-b9a9-5c5432fa2d88');
INSERT INTO `worker` VALUES ('113c529f-6a30-4b14-a249-5a7c382369da','qrcode.bmp','5df33241-2e4c-4732-8692-0ae30f557a10');
INSERT INTO `worker` VALUES ('11dc0629-304f-40c9-889e-6333300f4091','qrcode.bmp','1a3248cf-4eac-45fb-9df4-6b0311896070');
INSERT INTO `worker` VALUES ('11f84e1c-5bd6-4dd9-892f-3dda784a5a19','qrcode.bmp','3cef5168-0308-45c2-8711-1138338f3028');
INSERT INTO `worker` VALUES ('166507c6-3e97-4ed3-894e-1cb60f480bc7','qrcode.bmp','1ee40b13-40f2-43f5-82af-4f2a3be1322a');
INSERT INTO `worker` VALUES ('1ac27a13-78ab-4c1b-b0de-45ae47730b9a','qrcode.bmp','144f21db-74cf-4e3b-8811-33426f182b9b');
INSERT INTO `worker` VALUES ('1b067db3-6d99-4b51-b8cb-7d402ae51556','qrcode.bmp','4aec26af-4a74-445b-99f3-0afa000135af');
INSERT INTO `worker` VALUES ('1e3c3535-77b3-4481-aa2b-2e5c243f2af9','qrcode.bmp','16de1d41-32a8-439a-a42c-5f830f333499');
INSERT INTO `worker` VALUES ('22ad4006-0d1b-4142-aff5-0e32362825f1','qrcode.bmp','7aae35b8-49b3-4dba-9631-306017f43039');
INSERT INTO `worker` VALUES ('27bd19ec-5b8b-4083-ba54-25e71e936703','qrcode.bmp','1f673e8c-4071-463b-b9eb-314374532c4f');
INSERT INTO `worker` VALUES ('3078468b-142b-422c-a1c5-054a1a4661c3','qrcode.bmp','628e3890-4a4f-4ab1-8395-206b14277ec5');
INSERT INTO `worker` VALUES ('34d73633-0155-4e71-9c64-615c574056e3','qrcode.bmp','02bb5045-0977-472f-bf62-5c5667fd2558');
INSERT INTO `worker` VALUES ('38361486-40b1-499b-947a-6fa66f550fab','qrcode.bmp','0ae01a3c-1bde-4258-b276-5dbf59e15704');
INSERT INTO `worker` VALUES ('3b923e5f-68aa-484d-b48b-7d5b6e184d85','qrcode.bmp','5d8677c2-653f-445d-bb0b-584b7f5c6012');
INSERT INTO `worker` VALUES ('3d281c27-6ab2-4a82-bc68-583c4e240309','qrcode.bmp','7d83612f-093f-4911-a53d-0d901e397c1d');
INSERT INTO `worker` VALUES ('3d5321ef-6faa-45fa-ba54-7cd4047c2d9c','qrcode.bmp','3d1913c4-766a-49dd-a2eb-4a64718b2790');
INSERT INTO `worker` VALUES ('414e28f3-3ed8-4c04-bd31-350519574f67','qrcode.bmp','7cf1328e-39fb-4d3e-a030-042922a24222');
INSERT INTO `worker` VALUES ('4693106d-1a98-4fef-8640-0ace36e74b6c','qrcode.bmp','6a684a10-7e22-4871-9b03-6a2f592e017a');
INSERT INTO `worker` VALUES ('474d3f2b-03c3-4857-89a5-599a60bd769a','qrcode.bmp','487033cb-1246-4ec4-bd07-3d053996739b');
INSERT INTO `worker` VALUES ('4a2f455a-0fa0-40d3-ab33-01d17a10748f','qrcode.bmp','6ff53b6c-44a8-48fa-8128-1b5408562fee');
INSERT INTO `worker` VALUES ('52456ba5-4e90-498e-bd3e-49ef52203cad','qrcode.bmp','186837ac-3124-4a75-89dd-05cf38872309');
INSERT INTO `worker` VALUES ('54ba2dce-5815-4d73-8453-568a61d576bb','qrcode.bmp','4ccd5545-4e26-4fdf-b3c5-4e5d7d11368a');
INSERT INTO `worker` VALUES ('59f859e9-1a1f-40b0-8717-0cb2708f61b3','qrcode.bmp','0a520682-6cbd-4cce-abfd-127922c6734e');
INSERT INTO `worker` VALUES ('5f9e48d0-3ea5-41a6-a8ce-494f59445094','qrcode.bmp','04857feb-1715-4d30-b576-31fb42776c50');
INSERT INTO `worker` VALUES ('664e3b75-47c7-433c-937b-63192f6a0596','qrcode.bmp','530771e3-3d22-41c6-9bcc-32c571c37439');
INSERT INTO `worker` VALUES ('66b77e41-2a41-40fe-b26c-698d0965097e','qrcode.bmp','0fb33a0f-48e3-4538-ad0b-0e2b6bbf3077');
INSERT INTO `worker` VALUES ('694334b8-5480-434e-a84c-1d30557e01e4','qrcode.bmp','6b6e3101-7d20-4d05-8979-2e624a1175c4');
INSERT INTO `worker` VALUES ('6ac63052-35d6-478d-903d-262a1fa42e88','qrcode.bmp','681d43e2-77ec-49b3-94f5-3e476cfc30ae');
INSERT INTO `worker` VALUES ('734f1e0b-554a-4cb0-9b5e-36f91b8646b5','qrcode.bmp','0bf25ce2-417d-4e2d-b968-076471a12ec2');
INSERT INTO `worker` VALUES ('7aa1099b-1c18-4a0a-97bf-1a0879c542d6','qrcode.bmp','19c532c9-3558-43ac-ac74-67197d2529be');
INSERT INTO `worker` VALUES ('7f157795-07d4-4a12-a63f-3e0c747955aa','qrcode.bmp','34690af4-1399-467a-8d84-578d33f10c3d');
INSERT INTO `worker` VALUES ('7f162830-3270-4eaa-95cc-5c9362f605e7','qrcode.bmp','5e365677-5e4c-4075-a574-7be210be7568');
/*!40000 ALTER TABLE `worker` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-02-27 13:35:03
