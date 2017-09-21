DROP TABLE IF EXISTS `_form_data`;
CREATE TABLE `_form_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `form` varchar(255) NOT NULL DEFAULT '',
  `type` ENUM ('filter', 'columns') NOT NULL,
  `data` TEXT NULL,
  PRIMARY KEY (`id`),
  KEY (`form`),
  KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


-- MySQL dump 10.13  Distrib 5.6.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: yiitest
-- ------------------------------------------------------
-- Server version	5.6.31-0ubuntu0.15.10.1

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
-- Table structure for table `_all_tables`
--

DROP TABLE IF EXISTS `_all_tables`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_all_tables` (
  `idid` int(10) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notion` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hierarchy` int(1) NOT NULL,
  `module` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`idid`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_all_tables`
--

LOCK TABLES `_all_tables` WRITE;
/*!40000 ALTER TABLE `_all_tables` DISABLE KEYS */;
INSERT INTO `_all_tables` VALUES (1,'counterparties','counterparties','List of the counterparties',0,'core','user'),(2,'banks','banks','List of the banks',0,'core','user'),(3,'regions_name','regions_name','List of the regions name',0,'core','user'),(4,'regions','regions','List of the regions',1,'core','user'),(5,'macroregions_geo','macroregions_geo','List of the macroregions_geo',1,'core','user'),(6,'macroregions_kom','macroregions_kom','List of the macroregions_kom',1,'core','user'),(7,'countries','countries','List of the countries',1,'core','user');
/*!40000 ALTER TABLE `_all_tables` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-20 16:30:35




-- MySQL dump 10.13  Distrib 5.6.31, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: yiitest
-- ------------------------------------------------------
-- Server version	5.6.31-0ubuntu0.15.10.1

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
-- Table structure for table `_all_columns`
--

DROP TABLE IF EXISTS `_all_columns`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `_all_columns` (
  `idid` int(10) NOT NULL AUTO_INCREMENT,
  `id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `table_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `notion` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `default` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `periodic` int(1) DEFAULT NULL,
  `purpose` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `index` int(1) DEFAULT NULL,
  `required` int(1) DEFAULT NULL,
  `show_def` int(1) DEFAULT NULL,
  `system` int(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`idid`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `_all_columns`
--

LOCK TABLES `_all_columns` WRITE;
/*!40000 ALTER TABLE `_all_columns` DISABLE KEYS */;
INSERT INTO `_all_columns` VALUES (1,'name_official','counterparties','name_official','name_official','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(2,'subject_type','counterparties','sybject_type','sybject_type','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(3,'name_original','banks','name_original','name_original','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(4,'counterparties_id','banks','counterparties_id','Link to counterparties_id','counterparties.id',NULL,NULL,NULL,NULL,NULL,NULL,1),(5,'swift','banks',NULL,NULL,'varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(6,'name_original','regions','name_original','Original name','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(8,'name_original','regions_name','name_original','Original name','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(9,'countries_id','regions_name','countries','Link to countries_id','countries.id',NULL,NULL,NULL,NULL,NULL,NULL,1),(10,'name_original','countries','name_original','Original name','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(11,'iso2','countries','iso2','iso2','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(12,'iso3','countries','iso3','iso3','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(13,'name_post_index','countries','name_post_index','name_post_index','varchar(255)',NULL,NULL,NULL,NULL,NULL,NULL,1),(14,'macroregions_geo_id','countries','macroregions_geo','Link to macroregions_geo','macroregions_geo.id',NULL,NULL,NULL,NULL,NULL,NULL,1),(15,'macroregions_kom_id','countries','macroregions_kom','Link to macroregions_kom','macroregions_kom.id',NULL,NULL,NULL,NULL,NULL,NULL,1),(16,'countries_id','regions','countries','Link to countries_id','countries.id',NULL,NULL,NULL,NULL,NULL,NULL,1);
/*!40000 ALTER TABLE `_all_columns` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-09-20 19:12:36


DROP TABLE IF EXISTS `_form_data`;
CREATE TABLE `_form_data` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `form` varchar(255) NOT NULL DEFAULT '',
  `type` ENUM ('filter', 'columns') NOT NULL,
  `data` TEXT NULL,
  PRIMARY KEY (`id`),
  KEY (`form`),
  KEY (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


--
-- Table structure for table `address_type`
--

CREATE TABLE `address_type` (
  `id` int(10) UNSIGNED NOT NULL,
  `code` varchar(255) DEFAULT NULL,
  `notion` varchar(255) NOT NULL DEFAULT '',
  `type` enum('registry','logistic','other') NOT NULL,
  `status` tinyint(3) UNSIGNED NOT NULL DEFAULT '1',
  `parent` int(10) UNSIGNED DEFAULT NULL,
  `group` tinyint(3) UNSIGNED NOT NULL DEFAULT '0',
  `predefined` int(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `address_type`
--

INSERT INTO `address_type` (`id`, `code`, `notion`, `type`, `status`, `parent`, `group`, `predefined`) VALUES
(1, '1', 'addr 1', 'logistic', 2, NULL, 0, 1),
(2, '2', 'caddr 2', 'logistic', 3, NULL, 0, 0),
(3, '3', 'grp 1', 'registry', 1, NULL, 1, 0),
(4, '4', 'addr 1 level 2', 'registry', 1, 3, 0, 0),
(5, '5', 'grp 2', 'registry', 1, NULL, 1, 0),
(6, '6', 'addr 2 level 2', 'other', 3, 5, 0, 0),
(7, '7', 'subgroup 1', 'registry', 1, 3, 1, 0),
(8, '8', 'subgroup 2', 'registry', 1, 5, 1, 0),
(9, '9', 'subsubgroup 1', 'registry', 1, 7, 1, 0),
(10, '10', 'subsubgroup 2', 'registry', 1, 8, 1, 0),
(11, '11', '1111', 'logistic', 1, 9, 0, 0),
(12, '12', '123', 'logistic', 1, NULL, 0, 1),
(13, '13', '45454', 'registry', 3, NULL, 0, 0),
(14, '14', '������', 'logistic', 1, 9, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `address_type`
--
ALTER TABLE `address_type`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `title` (`notion`),
  ADD UNIQUE KEY `code` (`code`),
  ADD KEY `type` (`type`),
  ADD KEY `is_group` (`group`),
  ADD KEY `status` (`status`),
  ADD KEY `group_id` (`parent`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `address_type`
--
ALTER TABLE `address_type`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `address_type`
--
ALTER TABLE `address_type`
  ADD CONSTRAINT `address_type_ibfk_1` FOREIGN KEY (`parent`) REFERENCES `address_type` (`id`) ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
