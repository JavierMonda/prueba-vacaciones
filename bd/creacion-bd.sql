CREATE DATABASE  IF NOT EXISTS `vacaciones` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `vacaciones`;
-- MySQL dump 10.15  Distrib 10.0.31-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: vacaciones
-- ------------------------------------------------------
-- Server version	10.0.31-MariaDB-0ubuntu0.16.04.2

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

--
-- Table structure for table `Ausencia`
--

DROP TABLE IF EXISTS `Ausencia`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Ausencia` (
  `idAusencia` int(11) NOT NULL AUTO_INCREMENT,
  `fechaAusencia` date NOT NULL,
  `tipoAusencia` enum('baja','vacaciones','absentismo','permiso') CHARACTER SET utf8 NOT NULL,
  `descripcion` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `DNIAusencia` char(9) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idAusencia`),
  KEY `fk_DNIAusencia_idx` (`DNIAusencia`),
  CONSTRAINT `fk_DNIAusencia` FOREIGN KEY (`DNIAusencia`) REFERENCES `Trabajador` (`DNI`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Ausencia`
--

LOCK TABLES `Ausencia` WRITE;
/*!40000 ALTER TABLE `Ausencia` DISABLE KEYS */;
INSERT INTO `Ausencia` VALUES (1,'2017-07-25','baja','baja médica','88888888R'),(2,'2017-07-26','permiso','El trabajador se tomó un permiso','44444444R'),(3,'2017-07-31','vacaciones','vacaciones','88888888R'),(4,'2017-07-25','permiso','permiso','88888888R'),(5,'2017-08-09','vacaciones','unos dias de vacaciones','88888888R'),(6,'2017-08-14','absentismo','El trabajador no ha venido y no ha justificado la ausencia','11111111R'),(7,'2017-08-15','permiso','permiso','11111111R'),(8,'2017-08-16','permiso','permiso','11111111R'),(9,'2017-08-16','permiso','permiso','11111111R'),(10,'2017-08-16','vacaciones','vacaciones','55555555R'),(11,'2017-08-16','vacaciones','vacaciones','55555555R'),(12,'2017-08-16','vacaciones','vacaciones','55555555R'),(13,'2017-08-14','absentismo','El trabajador no ha venido y no ha justificado la ausencia','88888888R'),(14,'2017-08-04','baja','se puso malo','11111111R');
/*!40000 ALTER TABLE `Ausencia` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Centro`
--

DROP TABLE IF EXISTS `Centro`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Centro` (
  `idCentro` int(2) NOT NULL AUTO_INCREMENT,
  `nombreCentro` varchar(45) CHARACTER SET utf8 NOT NULL,
  `CIFCentro` char(9) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`idCentro`),
  KEY `fk_CIFCentro_idx` (`CIFCentro`),
  CONSTRAINT `fk_CIFCentro` FOREIGN KEY (`CIFCentro`) REFERENCES `Empresa` (`CIF`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Centro`
--

LOCK TABLES `Centro` WRITE;
/*!40000 ALTER TABLE `Centro` DISABLE KEYS */;
INSERT INTO `Centro` VALUES (1,'Vivero','11111111A'),(2,'Lajita','22222222B');
/*!40000 ALTER TABLE `Centro` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Datafonos`
--

DROP TABLE IF EXISTS `Datafonos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Datafonos` (
  `numTPV` varchar(20) CHARACTER SET utf8 NOT NULL,
  `numComercio` varchar(45) CHARACTER SET utf8 NOT NULL,
  `banco` varchar(45) CHARACTER SET utf8 NOT NULL,
  `conexion` enum('gprs','ethernet') CHARACTER SET utf8 NOT NULL,
  `idCentroDatafonos` int(2) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`numTPV`),
  KEY `fk_idCentroDatafonos_idx` (`idCentroDatafonos`),
  CONSTRAINT `fk_idCentroDatafonos` FOREIGN KEY (`idCentroDatafonos`) REFERENCES `Centro` (`idCentro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Datafonos`
--

LOCK TABLES `Datafonos` WRITE;
/*!40000 ALTER TABLE `Datafonos` DISABLE KEYS */;
INSERT INTO `Datafonos` VALUES ('04380103144','061213500','Popular','ethernet',1);
/*!40000 ALTER TABLE `Datafonos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Departamento`
--

DROP TABLE IF EXISTS `Departamento`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Departamento` (
  `nombreDepartamento` varchar(45) CHARACTER SET utf8 NOT NULL,
  `TlfDepartamento` char(9) CHARACTER SET utf8 NOT NULL,
  `JefeDepartamento` varchar(45) CHARACTER SET utf8 NOT NULL,
  `idCentroDepartamento` int(2) NOT NULL AUTO_INCREMENT,
  PRIMARY KEY (`nombreDepartamento`),
  KEY `fk_idCentroDepartamento_idx` (`idCentroDepartamento`),
  CONSTRAINT `fk_idCentroDepartamento` FOREIGN KEY (`idCentroDepartamento`) REFERENCES `Centro` (`idCentro`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Departamento`
--

LOCK TABLES `Departamento` WRITE;
/*!40000 ALTER TABLE `Departamento` DISABLE KEYS */;
INSERT INTO `Departamento` VALUES ('At. clientes','928222222','Juana Sánchez',2),('Cocina','928111111','Juan Morales',1);
/*!40000 ALTER TABLE `Departamento` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Empresa`
--

DROP TABLE IF EXISTS `Empresa`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Empresa` (
  `CIF` char(9) CHARACTER SET utf8 NOT NULL,
  `nombreEmpresa` varchar(90) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`CIF`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Empresa`
--

LOCK TABLES `Empresa` WRITE;
/*!40000 ALTER TABLE `Empresa` DISABLE KEYS */;
INSERT INTO `Empresa` VALUES ('11111111A','Empresa A'),('22222222B','Empresa B'),('33333333C','Empresa C');
/*!40000 ALTER TABLE `Empresa` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Trabajador`
--

DROP TABLE IF EXISTS `Trabajador`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Trabajador` (
  `DNI` char(9) CHARACTER SET utf8 NOT NULL,
  `Foto` varchar(90) CHARACTER SET utf8 DEFAULT NULL,
  `nombreApellidos` varchar(45) CHARACTER SET utf8 NOT NULL,
  `FechaIni` date NOT NULL,
  `FechaFin` date NOT NULL,
  `Observaciones` text CHARACTER SET utf8,
  `tipoContrato` varchar(45) CHARACTER SET utf8 NOT NULL,
  `vacaciones` int(11) NOT NULL DEFAULT '30',
  `nombreDepartamentoTrabajador` varchar(45) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`DNI`),
  KEY `fk_nombreDepartamentoTrabajador_idx` (`nombreDepartamentoTrabajador`),
  CONSTRAINT `fk_nombreDepartamentoTrabajador` FOREIGN KEY (`nombreDepartamentoTrabajador`) REFERENCES `Departamento` (`nombreDepartamento`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Trabajador`
--

LOCK TABLES `Trabajador` WRITE;
/*!40000 ALTER TABLE `Trabajador` DISABLE KEYS */;
INSERT INTO `Trabajador` VALUES ('11111111R','C:/Misarchivos/foto3.jpg','Leticia Gallego','2017-01-01','2017-12-31','','Prácticas',0,'At. clientes'),('33333333R','C:/Misarchivos/foto4.jpg','Aurelia','2017-01-01','2017-12-31','','Prácticas',93,'At. clientes'),('44444444R','C:/Misarchivos/foto2.jpg','Miguel Herrera','2017-01-01','2017-12-31','','Prácticas',0,'Cocina'),('55555555R','C:/Misarchivos/foto5.jpg','Pepe','2017-01-01','2017-12-31','','Prácticas',93,'At. clientes'),('88888888R','','Javier Jiménez García','2017-07-06','2017-12-29','Nuevo','fijo',14,'At. clientes'),('99999999R','','Juan Heredia','2017-08-16','2017-12-31','','eventual',11,'Cocina');
/*!40000 ALTER TABLE `Trabajador` ENABLE KEYS */;
UNLOCK TABLES;
/*!50003 SET @saved_cs_client      = @@character_set_client */ ;
/*!50003 SET @saved_cs_results     = @@character_set_results */ ;
/*!50003 SET @saved_col_connection = @@collation_connection */ ;
/*!50003 SET character_set_client  = utf8 */ ;
/*!50003 SET character_set_results = utf8 */ ;
/*!50003 SET collation_connection  = utf8_general_ci */ ;
/*!50003 SET @saved_sql_mode       = @@sql_mode */ ;
/*!50003 SET sql_mode              = '' */ ;
DELIMITER ;;
/*!50003 CREATE*/ /*!50017 DEFINER=`platy`@`localhost`*/ /*!50003 TRIGGER diasVacaciones BEFORE INSERT ON Trabajador FOR EACH ROW
BEGIN
    SET NEW.vacaciones = ROUND(DATEDIFF(NEW.fechaFin,NEW.fechaIni) * 0.082,0);
END */;;
DELIMITER ;
/*!50003 SET sql_mode              = @saved_sql_mode */ ;
/*!50003 SET character_set_client  = @saved_cs_client */ ;
/*!50003 SET character_set_results = @saved_cs_results */ ;
/*!50003 SET collation_connection  = @saved_col_connection */ ;

--
-- Table structure for table `TrabajadorTlf`
--

DROP TABLE IF EXISTS `TrabajadorTlf`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `TrabajadorTlf` (
  `DNITrabajadorTlf` char(9) CHARACTER SET utf8 NOT NULL,
  `TlfTrabajador` char(9) CHARACTER SET utf8 NOT NULL,
  PRIMARY KEY (`DNITrabajadorTlf`,`TlfTrabajador`),
  CONSTRAINT `fk_DNITrabajadorTlf` FOREIGN KEY (`DNITrabajadorTlf`) REFERENCES `Trabajador` (`DNI`) ON DELETE NO ACTION ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `TrabajadorTlf`
--

LOCK TABLES `TrabajadorTlf` WRITE;
/*!40000 ALTER TABLE `TrabajadorTlf` DISABLE KEYS */;
INSERT INTO `TrabajadorTlf` VALUES ('11111111R','666444444'),('44444444R','666333333'),('88888888R','666111111'),('88888888R','666222222');
/*!40000 ALTER TABLE `TrabajadorTlf` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `Trabajos`
--

DROP TABLE IF EXISTS `Trabajos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `Trabajos` (
  `idTrabajos` int(11) NOT NULL AUTO_INCREMENT,
  `fechaTrabajos` date NOT NULL,
  `horaIni` time NOT NULL,
  `horaFin` time NOT NULL,
  `zona` varchar(45) CHARACTER SET utf8 NOT NULL,
  `descripcionTrabajos` text CHARACTER SET utf8 NOT NULL,
  `DNITrabajos` char(9) CHARACTER SET utf8 NOT NULL,
  `nombreTrabajador` varchar(45) CHARACTER SET utf8 NOT NULL,
  `horasExtras` int(11) DEFAULT NULL,
  PRIMARY KEY (`idTrabajos`),
  KEY `fk_DNITrabajos_idx` (`DNITrabajos`),
  CONSTRAINT `fk_DNITrabajos` FOREIGN KEY (`DNITrabajos`) REFERENCES `Trabajador` (`DNI`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_spanish_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `Trabajos`
--

LOCK TABLES `Trabajos` WRITE;
/*!40000 ALTER TABLE `Trabajos` DISABLE KEYS */;
INSERT INTO `Trabajos` VALUES (1,'2017-07-26','09:00:00','10:00:00','patio','configurar algo','88888888R','',NULL),(2,'2017-07-26','09:00:00','10:00:00','patio','configurar algo','88888888R','',NULL),(3,'2017-07-28','08:00:00','10:00:00','Entrada','Construir muro en la entrada del zoo','88888888R','Javier Jiménez García',NULL),(4,'2017-07-28','08:00:00','17:00:00','Fuente entrada','Llenar la fuente de agua','88888888R','Julián',1),(5,'2017-07-28','08:00:00','16:00:00','Leones Marino','Reparar la manguera de 32','88888888R','Nino',2);
/*!40000 ALTER TABLE `Trabajos` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-08-16 15:12:10
