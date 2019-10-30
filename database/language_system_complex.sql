-- MySQL dump 10.13  Distrib 5.6.24, for osx10.8 (x86_64)
--
-- Host: 127.0.0.1    Database: language_system
-- ------------------------------------------------------
-- Server version	5.5.5-10.0.27-MariaDB

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
-- Table structure for table `complex`
--

DROP TABLE IF EXISTS `complex`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `complex` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(256) DEFAULT NULL,
  `step` int(11) DEFAULT NULL,
  `job` varchar(256) DEFAULT NULL,
  `input1` varchar(1) DEFAULT NULL,
  `input2` varchar(1) DEFAULT NULL,
  `input3` varchar(1) DEFAULT NULL,
  `input4` varchar(1) DEFAULT NULL,
  `input5` varchar(1) DEFAULT NULL,
  `input6` varchar(1) DEFAULT NULL,
  `input7` varchar(1) DEFAULT NULL,
  `input8` varchar(1) DEFAULT NULL,
  `previous` varchar(8) DEFAULT NULL,
  `set1` varchar(256) DEFAULT NULL,
  `set2` varchar(256) DEFAULT NULL,
  `set3` varchar(256) DEFAULT NULL,
  `set4` varchar(256) DEFAULT NULL,
  `set5` varchar(256) DEFAULT NULL,
  `set6` varchar(256) DEFAULT NULL,
  `set7` varchar(256) DEFAULT NULL,
  `set8` varchar(256) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=55 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `complex`
--

LOCK TABLES `complex` WRITE;
/*!40000 ALTER TABLE `complex` DISABLE KEYS */;
INSERT INTO `complex` VALUES (1,'TranscribeEnglishAndTranslateToGerman',1,'transcribe.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',NULL,NULL,NULL,NULL,NULL,NULL),(2,'TranscribeEnglishAndTranslateToGerman',2,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','de',NULL,NULL,NULL,NULL),(3,'TranscribeEnglishAndTranslateToFrench',1,'transcribe.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',NULL,NULL,NULL,NULL,NULL,NULL),(4,'TranscribeEnglishAndTranslateToFrench',2,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en','fr',NULL,NULL,NULL,NULL),(5,'TranscribeEnglishAndTranslateToSpanish',1,'transcribe.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',NULL,NULL,NULL,NULL,NULL,NULL),(6,'TranscribeEnglishAndTranslateToSpanish',2,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en','es',NULL,NULL,NULL,NULL),(7,'TranscribeEnglishAndTranslateToGermanFrenchAndSpanish',1,'transcribe.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',NULL,NULL,NULL,NULL,NULL,NULL),(8,'TranscribeEnglishAndTranslateToGermanFrenchAndSpanish',2,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','de',NULL,NULL,NULL,NULL),(9,'TranscribeEnglishAndTranslateToGermanFrenchAndSpanish',3,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','fr',NULL,NULL,NULL,NULL),(10,'TranscribeEnglishAndTranslateToGermanFrenchAndSpanish',4,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','es',NULL,NULL,NULL,NULL),(11,'TranscribeEnglishTranslateToGermanAndFrenchAndRenderSubtitles',1,'transcribe.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',NULL,NULL,NULL,NULL,NULL,NULL),(12,'TranscribeEnglishTranslateToGermanAndFrenchAndRenderSubtitles',2,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','de',NULL,NULL,NULL,NULL),(13,'TranscribeEnglishTranslateToGermanAndFrenchAndRenderSubtitles',3,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','fr',NULL,NULL,NULL,NULL),(14,'TranscribeEnglishTranslateToGermanAndFrenchAndRenderSubtitles',4,'subtitle_rendering.php',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,2,NULL,'#file#',NULL,NULL,NULL,NULL,NULL,NULL),(15,'TranscribeEnglishTranslateToGermanAndFrenchAndRenderSubtitles',5,'subtitle_rendering.php',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,3,NULL,'#file#',NULL,NULL,NULL,NULL,NULL,NULL),(17,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',1,'transcribe.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'en',NULL,NULL,NULL,NULL,NULL,NULL),(18,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',2,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','de ',NULL,NULL,NULL,NULL),(19,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',3,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','fr',NULL,NULL,NULL,NULL),(20,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',4,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','es',NULL,NULL,NULL,NULL),(21,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',5,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','ru',NULL,NULL,NULL,NULL),(22,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',6,'translate.php',NULL,2,NULL,NULL,NULL,NULL,NULL,NULL,1,NULL,NULL,'en','zh-CN',NULL,NULL,NULL,NULL),(23,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',7,'subtitle_rendering.php',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,2,NULL,'#file#',NULL,NULL,NULL,NULL,NULL,NULL),(24,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',8,'subtitle_rendering.php',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,3,NULL,'#file#',NULL,NULL,NULL,NULL,NULL,NULL),(25,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',9,'subtitle_rendering.php',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,4,NULL,'#file#',NULL,NULL,NULL,NULL,NULL,NULL),(26,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',10,'subtitle_rendering.php',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,5,NULL,'#file#',NULL,NULL,NULL,NULL,NULL,NULL),(27,'TranscribeEnglishTranslateToGermanFrenchSpanishRussianAndChineseAndRenderSubtitles',11,'subtitle_rendering.php',NULL,NULL,2,NULL,NULL,NULL,NULL,NULL,6,NULL,'#file#',NULL,NULL,NULL,NULL,NULL,NULL),(28,'TranslateEnglishToGermanAndFrench',1,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','de',NULL,NULL,NULL,NULL),(29,'TranslateEnglishToGermanAndFrench',2,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','fr',NULL,NULL,NULL,NULL),(30,'TranslateEnglishToGermanFrenchSpanishRussianAndChinese',1,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','de',NULL,NULL,NULL,NULL),(31,'TranslateEnglishToGermanFrenchSpanishRussianAndChinese',2,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','fr',NULL,NULL,NULL,NULL),(32,'TranslateEnglishToGermanFrenchSpanishRussianAndChinese',3,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','es',NULL,NULL,NULL,NULL),(33,'TranslateEnglishToGermanFrenchSpanishRussianAndChinese',4,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','ru',NULL,NULL,NULL,NULL),(34,'TranslateEnglishToGermanFrenchSpanishRussianAndChinese',5,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','zh-CN',NULL,NULL,NULL,NULL),(35,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',1,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','zh-CN',NULL,NULL,NULL,NULL),(36,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',2,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','hi',NULL,NULL,NULL,NULL),(37,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',3,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','es',NULL,NULL,NULL,NULL),(38,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',4,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','fr',NULL,NULL,NULL,NULL),(39,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',5,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','ar',NULL,NULL,NULL,NULL),(40,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',6,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','bn',NULL,NULL,NULL,NULL),(41,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',7,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','ru',NULL,NULL,NULL,NULL),(42,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',8,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','pt',NULL,NULL,NULL,NULL),(43,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',9,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','id',NULL,NULL,NULL,NULL),(44,'TranslateEnglishToChineseHindiSpanishFrenchArabicBengaliRussianPortugueseIndonesianAndUrdu',10,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','ur',NULL,NULL,NULL,NULL),(45,'TranslateEnglishToMajorEuropeanLanguages',1,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','es',NULL,NULL,NULL,NULL),(46,'TranslateEnglishToMajorEuropeanLanguages',2,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','fr',NULL,NULL,NULL,NULL),(47,'TranslateEnglishToMajorEuropeanLanguages',3,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','ru',NULL,NULL,NULL,NULL),(48,'TranslateEnglishToMajorEuropeanLanguages',4,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','de',NULL,NULL,NULL,NULL),(49,'TranslateEnglishToMajorEuropeanLanguages',5,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','tr',NULL,NULL,NULL,NULL),(50,'TranslateEnglishToMajorEuropeanLanguages',6,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','it',NULL,NULL,NULL,NULL),(51,'TranslateEnglishToMajorEuropeanLanguages',7,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','uk',NULL,NULL,NULL,NULL),(52,'TranslateEnglishToMajorEuropeanLanguages',8,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','pl',NULL,NULL,NULL,NULL),(53,'TranslateEnglishToMajorEuropeanLanguages',9,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','nl',NULL,NULL,NULL,NULL),(54,'TranslateEnglishToMajorEuropeanLanguages',10,'translate.php',NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'#subtitles#','en','ro',NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `complex` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2019-08-08 13:38:35
