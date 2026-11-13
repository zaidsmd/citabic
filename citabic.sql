-- MySQL dump 10.13  Distrib 8.0.46, for Linux (x86_64)
--
-- Host: localhost    Database: citabic
-- ------------------------------------------------------
-- Server version	8.0.46-0ubuntu0.24.04.4

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
-- Table structure for table `app_settings`
--

DROP TABLE IF EXISTS `app_settings`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `app_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `app_settings_key_unique` (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `app_settings`
--

LOCK TABLES `app_settings` WRITE;
/*!40000 ALTER TABLE `app_settings` DISABLE KEYS */;
/*!40000 ALTER TABLE `app_settings` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approach_item_translations`
--

DROP TABLE IF EXISTS `approach_item_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `approach_item_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `approach_item_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `approach_item_translations_approach_item_id_locale_unique` (`approach_item_id`,`locale`),
  CONSTRAINT `approach_item_translations_approach_item_id_foreign` FOREIGN KEY (`approach_item_id`) REFERENCES `approach_items` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approach_item_translations`
--

LOCK TABLES `approach_item_translations` WRITE;
/*!40000 ALTER TABLE `approach_item_translations` DISABLE KEYS */;
/*!40000 ALTER TABLE `approach_item_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `approach_items`
--

DROP TABLE IF EXISTS `approach_items`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `approach_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `color` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `approach_items`
--

LOCK TABLES `approach_items` WRITE;
/*!40000 ALTER TABLE `approach_items` DISABLE KEYS */;
INSERT INTO `approach_items` VALUES (1,'blue','chart-bar',0,'2026-03-17 15:34:57','2026-03-17 15:34:57'),(2,'blue','chart-bar',0,'2026-03-17 15:35:05','2026-03-17 15:35:05'),(3,'blue','signal',0,'2026-03-17 15:36:08','2026-03-17 15:36:08'),(4,'coral','signal',0,'2026-03-17 15:37:40','2026-03-17 15:37:40');
/*!40000 ALTER TABLE `approach_items` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache`
--

DROP TABLE IF EXISTS `cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache`
--

LOCK TABLES `cache` WRITE;
/*!40000 ALTER TABLE `cache` DISABLE KEYS */;
INSERT INTO `cache` VALUES ('laravel-cache-blog_listing:fr:index:d41d8cd98f00b204e9800998ecf8427e:p1:pp6:v5','a:5:{s:5:\"posts\";O:42:\"Illuminate\\Pagination\\LengthAwarePaginator\":12:{s:8:\"\0*\0items\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;a:38:{s:2:\"id\";i:2;s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:7:\"content\";s:0:\"\";s:14:\"featured_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:6:\"status\";s:9:\"published\";s:12:\"published_at\";s:27:\"2026-03-27T22:24:08.000000Z\";s:12:\"reading_time\";i:0;s:5:\"views\";i:0;s:8:\"featured\";b:1;s:14:\"allow_comments\";b:0;s:10:\"meta_title\";s:60:\"Le BTP au Maroc : Horizon 2030 et Essor du Secteur | CITABIC\";s:16:\"meta_description\";s:154:\"Découvrez comment la CAN 2025 et le Mondial 2030 propulsent le BTP au Maroc. Focus sur 140 Mrd DH d\'investissements et l\'expertise certifiée de CITABIC.\";s:13:\"meta_keywords\";s:113:\"Secteur BTP Maroc, Infrastructure CAN 2025, Investissement BTP Maroc, Construction Casablanca Tanger, CITABIC BTP\";s:13:\"focus_keyword\";s:14:\"BTP Maroc 2030\";s:13:\"canonical_url\";s:81:\"http://127.0.0.1:8000/blog/le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:8:\"og_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:14:\"og_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:8:\"og_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:13:\"twitter_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:19:\"twitter_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:13:\"twitter_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:12:\"twitter_card\";s:19:\"summary_large_image\";s:12:\"robots_index\";b:1;s:13:\"robots_follow\";b:1;s:11:\"schema_type\";s:7:\"Article\";s:11:\"schema_json\";N;s:12:\"translations\";a:1:{s:2:\"en\";a:2:{s:5:\"title\";s:64:\"Morocco: An Open-Air Construction Site Towards the 2030 Deadline\";s:7:\"excerpt\";s:234:\"The construction industry in Morocco is booming with the 2025 Africa Cup of Nations and the 2030 World Cup. 140 billion dirhams of investments are expected by 2025. A project of the future representing 6% of GDP and 10% of employment.\";}}s:6:\"blocks\";a:8:{i:0;a:2:{s:4:\"type\";s:4:\"hero\";s:5:\"image\";s:86:\"http://localhost:8000/storage/posts/featured/31c1051a-c52d-44db-b7d5-23178ad34ffe.webp\";}i:1;a:3:{s:4:\"type\";s:9:\"paragraph\";s:7:\"content\";s:303:\"<p>Le secteur du B&acirc;timent et des Travaux Publics (BTP) au Maroc vit une m&eacute;tamorphose historique. Port&eacute; par des ambitions royales et des rendez-vous plan&eacute;taires, le Royaume ne se contente plus de construire des infrastructures : il b&acirc;tit l\'avenir de toute une nation.</p>\";s:10:\"content_en\";s:272:\"<p>The construction and public works (BTP) sector in Morocco is undergoing a historic transformation. Driven by royal ambitions and global commitments, the Kingdom is no longer content with simply building infrastructure: it is building the future of an entire nation.</p>\";}i:2;a:6:{s:4:\"type\";s:5:\"quote\";s:6:\"author\";s:0:\"\";s:7:\"content\";s:153:\"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\";s:9:\"author_en\";s:0:\"\";s:10:\"content_en\";s:0:\"\";s:13:\"content_en_en\";s:153:\"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\";}i:3;a:4:{s:4:\"type\";s:10:\"subheading\";s:7:\"content\";s:62:\"1. L’Ambition Sportive : Un Accélérateur d\'Infrastructures\";s:10:\"content_en\";s:0:\"\";s:13:\"content_en_en\";s:54:\"1. Sporting Ambition: An Accelerator of Infrastructure\";}i:4;a:3:{s:4:\"type\";s:9:\"paragraph\";s:7:\"content\";s:804:\"<p data-path-to-node=\"6\">L&rsquo;accueil de la&nbsp;<strong data-path-to-node=\"6\" data-index-in-node=\"16\">CAN 2025</strong> et la co-organisation de la <strong data-path-to-node=\"6\" data-index-in-node=\"53\">Coupe du Monde 2030</strong> avec l&rsquo;Espagne et le Portugal ne sont pas de simples &eacute;v&eacute;nements sportifs. Ce sont des catalyseurs de d&eacute;veloppement.</p>\n<p data-path-to-node=\"7\">De Tanger &agrave; Agadir, la mise &agrave; niveau des stades (Ibn Battouta, Moulay Abdellah, Adrar) d&eacute;passe le cadre du football. Il s\'agit de cr&eacute;er des p&ocirc;les de vie, de culture et de loisirs connect&eacute;s. Ces projets exigent une rigueur technique et une rapidit&eacute; d\'ex&eacute;cution o&ugrave; l\'expertise certifi&eacute;e devient la cl&eacute; du succ&egrave;s.</p>\";s:10:\"content_en\";s:477:\"<p>Hosting the 2025 Africa Cup of Nations and co-hosting the 2030 World Cup with Spain and Portugal are not simply sporting events. They are catalysts for development.</p>\n<p>From Tangier to Agadir, the upgrading of stadiums (Ibn Battouta, Moulay Abdellah, Adrar) goes beyond football. It\'s about creating interconnected hubs of life, culture, and leisure. These projects demand technical precision and rapid execution, where certified expertise becomes the key to success.</p>\";}i:5;a:4:{s:4:\"type\";s:10:\"subheading\";s:7:\"content\";s:48:\"2. Modernisation Intégrée : Au-delà du Béton\";s:10:\"content_en\";s:0:\"\";s:13:\"content_en_en\";s:48:\"2. Modernisation Intégrée : Au-delà du Béton\";}i:6;a:3:{s:4:\"type\";s:9:\"paragraph\";s:7:\"content\";s:270:\"<p>Le d&eacute;veloppement du Maroc repose sur une vision holistique. Avec un investissement colossal de plus de <strong data-path-to-node=\"9\" data-index-in-node=\"103\">140 milliards de dirhams d\'ici 2025</strong>, le Royaume d&eacute;ploie des projets structurants :</p>\";s:10:\"content_en\";s:170:\"<p>Morocco\'s development is based on a holistic vision. With a colossal investment of over 140 billion dirhams by 2025, the Kingdom is deploying structuring projects:</p>\";}i:7;a:4:{s:4:\"type\";s:4:\"list\";s:5:\"items\";a:3:{i:0;s:62:\"Mobilité : Extension du réseau TGV et des lignes de Tramway.\";i:1;s:81:\"Souveraineté : Construction de stations de dessalement et de complexes solaires.\";i:2;s:79:\"Logistique : Expansion des ports et aéroports pour une connectivité mondiale.\";}s:8:\"items_en\";a:3:{i:0;s:54:\"Mobility: Extension of the TGV network and tram lines.\";i:1;s:69:\"Sovereignty: Construction of desalination plants and solar complexes.\";i:2;s:67:\"Logistics: Expansion of ports and airports for global connectivity.\";}s:8:\"listType\";s:9:\"unordered\";}}s:9:\"author_id\";i:1;s:10:\"created_at\";s:27:\"2026-03-25T15:12:51.000000Z\";s:10:\"updated_at\";s:27:\"2026-03-27T22:24:08.000000Z\";s:10:\"deleted_at\";N;s:6:\"author\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:13:\"Administrator\";}s:10:\"categories\";a:0:{}s:4:\"tags\";a:0:{}s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:10:\"\0*\0perPage\";i:6;s:14:\"\0*\0currentPage\";i:1;s:7:\"\0*\0path\";s:26:\"http://127.0.0.1:8000/blog\";s:8:\"\0*\0query\";a:0:{}s:11:\"\0*\0fragment\";N;s:11:\"\0*\0pageName\";s:4:\"page\";s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:10:\"onEachSide\";i:3;s:10:\"\0*\0options\";a:2:{s:4:\"path\";s:26:\"http://127.0.0.1:8000/blog\";s:8:\"pageName\";s:4:\"page\";}s:8:\"\0*\0total\";i:1;s:11:\"\0*\0lastPage\";i:1;}s:8:\"postMeta\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:2;O:15:\"App\\Models\\Post\":34:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"posts\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:34:{s:2:\"id\";i:2;s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:7:\"content\";s:0:\"\";s:14:\"featured_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:6:\"status\";s:9:\"published\";s:12:\"published_at\";s:19:\"2026-03-27 22:24:08\";s:12:\"reading_time\";i:0;s:5:\"views\";i:0;s:8:\"featured\";i:1;s:14:\"allow_comments\";i:0;s:10:\"meta_title\";s:60:\"Le BTP au Maroc : Horizon 2030 et Essor du Secteur | CITABIC\";s:16:\"meta_description\";s:154:\"Découvrez comment la CAN 2025 et le Mondial 2030 propulsent le BTP au Maroc. Focus sur 140 Mrd DH d\'investissements et l\'expertise certifiée de CITABIC.\";s:13:\"meta_keywords\";s:113:\"Secteur BTP Maroc, Infrastructure CAN 2025, Investissement BTP Maroc, Construction Casablanca Tanger, CITABIC BTP\";s:13:\"focus_keyword\";s:14:\"BTP Maroc 2030\";s:13:\"canonical_url\";s:81:\"http://127.0.0.1:8000/blog/le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:8:\"og_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:14:\"og_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:8:\"og_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:13:\"twitter_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:19:\"twitter_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:13:\"twitter_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:12:\"twitter_card\";s:19:\"summary_large_image\";s:12:\"robots_index\";i:1;s:13:\"robots_follow\";i:1;s:11:\"schema_type\";s:7:\"Article\";s:11:\"schema_json\";N;s:12:\"translations\";s:334:\"{\"en\": {\"title\": \"Morocco: An Open-Air Construction Site Towards the 2030 Deadline\", \"excerpt\": \"The construction industry in Morocco is booming with the 2025 Africa Cup of Nations and the 2030 World Cup. 140 billion dirhams of investments are expected by 2025. A project of the future representing 6% of GDP and 10% of employment.\"}}\";s:6:\"blocks\";s:3881:\"[{\"type\": \"hero\", \"image\": \"http://localhost:8000/storage/posts/featured/31c1051a-c52d-44db-b7d5-23178ad34ffe.webp\"}, {\"type\": \"paragraph\", \"content\": \"<p>Le secteur du B&acirc;timent et des Travaux Publics (BTP) au Maroc vit une m&eacute;tamorphose historique. Port&eacute; par des ambitions royales et des rendez-vous plan&eacute;taires, le Royaume ne se contente plus de construire des infrastructures : il b&acirc;tit l\'avenir de toute une nation.</p>\", \"content_en\": \"<p>The construction and public works (BTP) sector in Morocco is undergoing a historic transformation. Driven by royal ambitions and global commitments, the Kingdom is no longer content with simply building infrastructure: it is building the future of an entire nation.</p>\"}, {\"type\": \"quote\", \"author\": \"\", \"content\": \"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\", \"author_en\": \"\", \"content_en\": \"\", \"content_en_en\": \"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\"}, {\"type\": \"subheading\", \"content\": \"1. L’Ambition Sportive : Un Accélérateur d\'Infrastructures\", \"content_en\": \"\", \"content_en_en\": \"1. Sporting Ambition: An Accelerator of Infrastructure\"}, {\"type\": \"paragraph\", \"content\": \"<p data-path-to-node=\\\"6\\\">L&rsquo;accueil de la&nbsp;<strong data-path-to-node=\\\"6\\\" data-index-in-node=\\\"16\\\">CAN 2025</strong> et la co-organisation de la <strong data-path-to-node=\\\"6\\\" data-index-in-node=\\\"53\\\">Coupe du Monde 2030</strong> avec l&rsquo;Espagne et le Portugal ne sont pas de simples &eacute;v&eacute;nements sportifs. Ce sont des catalyseurs de d&eacute;veloppement.</p>\\n<p data-path-to-node=\\\"7\\\">De Tanger &agrave; Agadir, la mise &agrave; niveau des stades (Ibn Battouta, Moulay Abdellah, Adrar) d&eacute;passe le cadre du football. Il s\'agit de cr&eacute;er des p&ocirc;les de vie, de culture et de loisirs connect&eacute;s. Ces projets exigent une rigueur technique et une rapidit&eacute; d\'ex&eacute;cution o&ugrave; l\'expertise certifi&eacute;e devient la cl&eacute; du succ&egrave;s.</p>\", \"content_en\": \"<p>Hosting the 2025 Africa Cup of Nations and co-hosting the 2030 World Cup with Spain and Portugal are not simply sporting events. They are catalysts for development.</p>\\n<p>From Tangier to Agadir, the upgrading of stadiums (Ibn Battouta, Moulay Abdellah, Adrar) goes beyond football. It\'s about creating interconnected hubs of life, culture, and leisure. These projects demand technical precision and rapid execution, where certified expertise becomes the key to success.</p>\"}, {\"type\": \"subheading\", \"content\": \"2. Modernisation Intégrée : Au-delà du Béton\", \"content_en\": \"\", \"content_en_en\": \"2. Modernisation Intégrée : Au-delà du Béton\"}, {\"type\": \"paragraph\", \"content\": \"<p>Le d&eacute;veloppement du Maroc repose sur une vision holistique. Avec un investissement colossal de plus de <strong data-path-to-node=\\\"9\\\" data-index-in-node=\\\"103\\\">140 milliards de dirhams d\'ici 2025</strong>, le Royaume d&eacute;ploie des projets structurants :</p>\", \"content_en\": \"<p>Morocco\'s development is based on a holistic vision. With a colossal investment of over 140 billion dirhams by 2025, the Kingdom is deploying structuring projects:</p>\"}, {\"type\": \"list\", \"items\": [\"Mobilité : Extension du réseau TGV et des lignes de Tramway.\", \"Souveraineté : Construction de stations de dessalement et de complexes solaires.\", \"Logistique : Expansion des ports et aéroports pour une connectivité mondiale.\"], \"items_en\": [\"Mobility: Extension of the TGV network and tram lines.\", \"Sovereignty: Construction of desalination plants and solar complexes.\", \"Logistics: Expansion of ports and airports for global connectivity.\"], \"listType\": \"unordered\"}]\";s:9:\"author_id\";i:1;s:10:\"created_at\";s:19:\"2026-03-25 15:12:51\";s:10:\"updated_at\";s:19:\"2026-03-27 22:24:08\";s:10:\"deleted_at\";N;}s:11:\"\0*\0original\";a:34:{s:2:\"id\";i:2;s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:7:\"content\";s:0:\"\";s:14:\"featured_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:6:\"status\";s:9:\"published\";s:12:\"published_at\";s:19:\"2026-03-27 22:24:08\";s:12:\"reading_time\";i:0;s:5:\"views\";i:0;s:8:\"featured\";i:1;s:14:\"allow_comments\";i:0;s:10:\"meta_title\";s:60:\"Le BTP au Maroc : Horizon 2030 et Essor du Secteur | CITABIC\";s:16:\"meta_description\";s:154:\"Découvrez comment la CAN 2025 et le Mondial 2030 propulsent le BTP au Maroc. Focus sur 140 Mrd DH d\'investissements et l\'expertise certifiée de CITABIC.\";s:13:\"meta_keywords\";s:113:\"Secteur BTP Maroc, Infrastructure CAN 2025, Investissement BTP Maroc, Construction Casablanca Tanger, CITABIC BTP\";s:13:\"focus_keyword\";s:14:\"BTP Maroc 2030\";s:13:\"canonical_url\";s:81:\"http://127.0.0.1:8000/blog/le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:8:\"og_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:14:\"og_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:8:\"og_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:13:\"twitter_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:19:\"twitter_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:13:\"twitter_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:12:\"twitter_card\";s:19:\"summary_large_image\";s:12:\"robots_index\";i:1;s:13:\"robots_follow\";i:1;s:11:\"schema_type\";s:7:\"Article\";s:11:\"schema_json\";N;s:12:\"translations\";s:334:\"{\"en\": {\"title\": \"Morocco: An Open-Air Construction Site Towards the 2030 Deadline\", \"excerpt\": \"The construction industry in Morocco is booming with the 2025 Africa Cup of Nations and the 2030 World Cup. 140 billion dirhams of investments are expected by 2025. A project of the future representing 6% of GDP and 10% of employment.\"}}\";s:6:\"blocks\";s:3881:\"[{\"type\": \"hero\", \"image\": \"http://localhost:8000/storage/posts/featured/31c1051a-c52d-44db-b7d5-23178ad34ffe.webp\"}, {\"type\": \"paragraph\", \"content\": \"<p>Le secteur du B&acirc;timent et des Travaux Publics (BTP) au Maroc vit une m&eacute;tamorphose historique. Port&eacute; par des ambitions royales et des rendez-vous plan&eacute;taires, le Royaume ne se contente plus de construire des infrastructures : il b&acirc;tit l\'avenir de toute une nation.</p>\", \"content_en\": \"<p>The construction and public works (BTP) sector in Morocco is undergoing a historic transformation. Driven by royal ambitions and global commitments, the Kingdom is no longer content with simply building infrastructure: it is building the future of an entire nation.</p>\"}, {\"type\": \"quote\", \"author\": \"\", \"content\": \"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\", \"author_en\": \"\", \"content_en\": \"\", \"content_en_en\": \"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\"}, {\"type\": \"subheading\", \"content\": \"1. L’Ambition Sportive : Un Accélérateur d\'Infrastructures\", \"content_en\": \"\", \"content_en_en\": \"1. Sporting Ambition: An Accelerator of Infrastructure\"}, {\"type\": \"paragraph\", \"content\": \"<p data-path-to-node=\\\"6\\\">L&rsquo;accueil de la&nbsp;<strong data-path-to-node=\\\"6\\\" data-index-in-node=\\\"16\\\">CAN 2025</strong> et la co-organisation de la <strong data-path-to-node=\\\"6\\\" data-index-in-node=\\\"53\\\">Coupe du Monde 2030</strong> avec l&rsquo;Espagne et le Portugal ne sont pas de simples &eacute;v&eacute;nements sportifs. Ce sont des catalyseurs de d&eacute;veloppement.</p>\\n<p data-path-to-node=\\\"7\\\">De Tanger &agrave; Agadir, la mise &agrave; niveau des stades (Ibn Battouta, Moulay Abdellah, Adrar) d&eacute;passe le cadre du football. Il s\'agit de cr&eacute;er des p&ocirc;les de vie, de culture et de loisirs connect&eacute;s. Ces projets exigent une rigueur technique et une rapidit&eacute; d\'ex&eacute;cution o&ugrave; l\'expertise certifi&eacute;e devient la cl&eacute; du succ&egrave;s.</p>\", \"content_en\": \"<p>Hosting the 2025 Africa Cup of Nations and co-hosting the 2030 World Cup with Spain and Portugal are not simply sporting events. They are catalysts for development.</p>\\n<p>From Tangier to Agadir, the upgrading of stadiums (Ibn Battouta, Moulay Abdellah, Adrar) goes beyond football. It\'s about creating interconnected hubs of life, culture, and leisure. These projects demand technical precision and rapid execution, where certified expertise becomes the key to success.</p>\"}, {\"type\": \"subheading\", \"content\": \"2. Modernisation Intégrée : Au-delà du Béton\", \"content_en\": \"\", \"content_en_en\": \"2. Modernisation Intégrée : Au-delà du Béton\"}, {\"type\": \"paragraph\", \"content\": \"<p>Le d&eacute;veloppement du Maroc repose sur une vision holistique. Avec un investissement colossal de plus de <strong data-path-to-node=\\\"9\\\" data-index-in-node=\\\"103\\\">140 milliards de dirhams d\'ici 2025</strong>, le Royaume d&eacute;ploie des projets structurants :</p>\", \"content_en\": \"<p>Morocco\'s development is based on a holistic vision. With a colossal investment of over 140 billion dirhams by 2025, the Kingdom is deploying structuring projects:</p>\"}, {\"type\": \"list\", \"items\": [\"Mobilité : Extension du réseau TGV et des lignes de Tramway.\", \"Souveraineté : Construction de stations de dessalement et de complexes solaires.\", \"Logistique : Expansion des ports et aéroports pour une connectivité mondiale.\"], \"items_en\": [\"Mobility: Extension of the TGV network and tram lines.\", \"Sovereignty: Construction of desalination plants and solar complexes.\", \"Logistics: Expansion of ports and airports for global connectivity.\"], \"listType\": \"unordered\"}]\";s:9:\"author_id\";i:1;s:10:\"created_at\";s:19:\"2026-03-25 15:12:51\";s:10:\"updated_at\";s:19:\"2026-03-27 22:24:08\";s:10:\"deleted_at\";N;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:9:{s:10:\"deleted_at\";s:8:\"datetime\";s:6:\"status\";s:20:\"App\\Enums\\PostStatus\";s:12:\"published_at\";s:8:\"datetime\";s:8:\"featured\";s:7:\"boolean\";s:14:\"allow_comments\";s:7:\"boolean\";s:12:\"robots_index\";s:7:\"boolean\";s:13:\"robots_follow\";s:7:\"boolean\";s:12:\"translations\";s:5:\"array\";s:6:\"blocks\";s:5:\"array\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:3:{s:6:\"author\";O:15:\"App\\Models\\User\":35:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:5:\"users\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:13:\"Administrator\";}s:11:\"\0*\0original\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:13:\"Administrator\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:17:\"email_verified_at\";s:8:\"datetime\";s:8:\"password\";s:6:\"hashed\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:2:{i:0;s:8:\"password\";i:1;s:14:\"remember_token\";}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:3:{i:0;s:4:\"name\";i:1;s:5:\"email\";i:2;s:8:\"password\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:19:\"\0*\0authPasswordName\";s:8:\"password\";s:20:\"\0*\0rememberTokenName\";s:14:\"remember_token\";}s:10:\"categories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:4:\"tags\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:30:{i:0;s:5:\"title\";i:1;s:4:\"slug\";i:2;s:7:\"excerpt\";i:3;s:7:\"content\";i:4;s:14:\"featured_image\";i:5;s:6:\"status\";i:6;s:12:\"published_at\";i:7;s:12:\"reading_time\";i:8;s:5:\"views\";i:9;s:8:\"featured\";i:10;s:14:\"allow_comments\";i:11;s:10:\"meta_title\";i:12;s:16:\"meta_description\";i:13;s:13:\"canonical_url\";i:14;s:13:\"meta_keywords\";i:15;s:13:\"focus_keyword\";i:16;s:8:\"og_title\";i:17;s:14:\"og_description\";i:18;s:8:\"og_image\";i:19;s:13:\"twitter_title\";i:20;s:19:\"twitter_description\";i:21;s:13:\"twitter_image\";i:22;s:12:\"twitter_card\";i:23;s:12:\"robots_index\";i:24;s:13:\"robots_follow\";i:25;s:11:\"schema_type\";i:26;s:11:\"schema_json\";i:27;s:9:\"author_id\";i:28;s:12:\"translations\";i:29;s:6:\"blocks\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}s:16:\"\0*\0forceDeleting\";b:0;}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"recentPosts\";O:29:\"Illuminate\\Support\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;a:36:{s:2:\"id\";i:2;s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:7:\"content\";s:0:\"\";s:14:\"featured_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:6:\"status\";s:9:\"published\";s:12:\"published_at\";s:27:\"2026-03-27T22:24:08.000000Z\";s:12:\"reading_time\";i:0;s:5:\"views\";i:0;s:8:\"featured\";b:1;s:14:\"allow_comments\";b:0;s:10:\"meta_title\";s:60:\"Le BTP au Maroc : Horizon 2030 et Essor du Secteur | CITABIC\";s:16:\"meta_description\";s:154:\"Découvrez comment la CAN 2025 et le Mondial 2030 propulsent le BTP au Maroc. Focus sur 140 Mrd DH d\'investissements et l\'expertise certifiée de CITABIC.\";s:13:\"meta_keywords\";s:113:\"Secteur BTP Maroc, Infrastructure CAN 2025, Investissement BTP Maroc, Construction Casablanca Tanger, CITABIC BTP\";s:13:\"focus_keyword\";s:14:\"BTP Maroc 2030\";s:13:\"canonical_url\";s:81:\"http://127.0.0.1:8000/blog/le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:8:\"og_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:14:\"og_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:8:\"og_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:13:\"twitter_title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:19:\"twitter_description\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:13:\"twitter_image\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:12:\"twitter_card\";s:19:\"summary_large_image\";s:12:\"robots_index\";b:1;s:13:\"robots_follow\";b:1;s:11:\"schema_type\";s:7:\"Article\";s:11:\"schema_json\";N;s:12:\"translations\";a:1:{s:2:\"en\";a:2:{s:5:\"title\";s:64:\"Morocco: An Open-Air Construction Site Towards the 2030 Deadline\";s:7:\"excerpt\";s:234:\"The construction industry in Morocco is booming with the 2025 Africa Cup of Nations and the 2030 World Cup. 140 billion dirhams of investments are expected by 2025. A project of the future representing 6% of GDP and 10% of employment.\";}}s:6:\"blocks\";a:8:{i:0;a:2:{s:4:\"type\";s:4:\"hero\";s:5:\"image\";s:86:\"http://localhost:8000/storage/posts/featured/31c1051a-c52d-44db-b7d5-23178ad34ffe.webp\";}i:1;a:3:{s:4:\"type\";s:9:\"paragraph\";s:7:\"content\";s:303:\"<p>Le secteur du B&acirc;timent et des Travaux Publics (BTP) au Maroc vit une m&eacute;tamorphose historique. Port&eacute; par des ambitions royales et des rendez-vous plan&eacute;taires, le Royaume ne se contente plus de construire des infrastructures : il b&acirc;tit l\'avenir de toute une nation.</p>\";s:10:\"content_en\";s:272:\"<p>The construction and public works (BTP) sector in Morocco is undergoing a historic transformation. Driven by royal ambitions and global commitments, the Kingdom is no longer content with simply building infrastructure: it is building the future of an entire nation.</p>\";}i:2;a:6:{s:4:\"type\";s:5:\"quote\";s:6:\"author\";s:0:\"\";s:7:\"content\";s:153:\"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\";s:9:\"author_en\";s:0:\"\";s:10:\"content_en\";s:0:\"\";s:13:\"content_en_en\";s:153:\"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\";}i:3;a:4:{s:4:\"type\";s:10:\"subheading\";s:7:\"content\";s:62:\"1. L’Ambition Sportive : Un Accélérateur d\'Infrastructures\";s:10:\"content_en\";s:0:\"\";s:13:\"content_en_en\";s:54:\"1. Sporting Ambition: An Accelerator of Infrastructure\";}i:4;a:3:{s:4:\"type\";s:9:\"paragraph\";s:7:\"content\";s:804:\"<p data-path-to-node=\"6\">L&rsquo;accueil de la&nbsp;<strong data-path-to-node=\"6\" data-index-in-node=\"16\">CAN 2025</strong> et la co-organisation de la <strong data-path-to-node=\"6\" data-index-in-node=\"53\">Coupe du Monde 2030</strong> avec l&rsquo;Espagne et le Portugal ne sont pas de simples &eacute;v&eacute;nements sportifs. Ce sont des catalyseurs de d&eacute;veloppement.</p>\n<p data-path-to-node=\"7\">De Tanger &agrave; Agadir, la mise &agrave; niveau des stades (Ibn Battouta, Moulay Abdellah, Adrar) d&eacute;passe le cadre du football. Il s\'agit de cr&eacute;er des p&ocirc;les de vie, de culture et de loisirs connect&eacute;s. Ces projets exigent une rigueur technique et une rapidit&eacute; d\'ex&eacute;cution o&ugrave; l\'expertise certifi&eacute;e devient la cl&eacute; du succ&egrave;s.</p>\";s:10:\"content_en\";s:477:\"<p>Hosting the 2025 Africa Cup of Nations and co-hosting the 2030 World Cup with Spain and Portugal are not simply sporting events. They are catalysts for development.</p>\n<p>From Tangier to Agadir, the upgrading of stadiums (Ibn Battouta, Moulay Abdellah, Adrar) goes beyond football. It\'s about creating interconnected hubs of life, culture, and leisure. These projects demand technical precision and rapid execution, where certified expertise becomes the key to success.</p>\";}i:5;a:4:{s:4:\"type\";s:10:\"subheading\";s:7:\"content\";s:48:\"2. Modernisation Intégrée : Au-delà du Béton\";s:10:\"content_en\";s:0:\"\";s:13:\"content_en_en\";s:48:\"2. Modernisation Intégrée : Au-delà du Béton\";}i:6;a:3:{s:4:\"type\";s:9:\"paragraph\";s:7:\"content\";s:270:\"<p>Le d&eacute;veloppement du Maroc repose sur une vision holistique. Avec un investissement colossal de plus de <strong data-path-to-node=\"9\" data-index-in-node=\"103\">140 milliards de dirhams d\'ici 2025</strong>, le Royaume d&eacute;ploie des projets structurants :</p>\";s:10:\"content_en\";s:170:\"<p>Morocco\'s development is based on a holistic vision. With a colossal investment of over 140 billion dirhams by 2025, the Kingdom is deploying structuring projects:</p>\";}i:7;a:4:{s:4:\"type\";s:4:\"list\";s:5:\"items\";a:3:{i:0;s:62:\"Mobilité : Extension du réseau TGV et des lignes de Tramway.\";i:1;s:81:\"Souveraineté : Construction de stations de dessalement et de complexes solaires.\";i:2;s:79:\"Logistique : Expansion des ports et aéroports pour une connectivité mondiale.\";}s:8:\"items_en\";a:3:{i:0;s:54:\"Mobility: Extension of the TGV network and tram lines.\";i:1;s:69:\"Sovereignty: Construction of desalination plants and solar complexes.\";i:2;s:67:\"Logistics: Expansion of ports and airports for global connectivity.\";}s:8:\"listType\";s:9:\"unordered\";}}s:9:\"author_id\";i:1;s:10:\"created_at\";s:27:\"2026-03-25T15:12:51.000000Z\";s:10:\"updated_at\";s:27:\"2026-03-27T22:24:08.000000Z\";s:10:\"deleted_at\";N;s:6:\"author\";a:2:{s:2:\"id\";i:1;s:4:\"name\";s:13:\"Administrator\";}s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:17:\"popularCategories\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:1:{i:0;O:19:\"App\\Models\\Category\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:10:\"categories\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:2;s:4:\"name\";s:4:\"News\";s:4:\"slug\";s:4:\"news\";s:10:\"created_at\";s:19:\"2026-03-26 14:34:39\";s:10:\"updated_at\";s:19:\"2026-03-26 14:34:39\";s:11:\"posts_count\";i:0;}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:2;s:4:\"name\";s:4:\"News\";s:4:\"slug\";s:4:\"news\";s:10:\"created_at\";s:19:\"2026-03-26 14:34:39\";s:10:\"updated_at\";s:19:\"2026-03-26 14:34:39\";s:11:\"posts_count\";i:0;}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"name\";i:1;s:4:\"slug\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:11:\"popularTags\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:0:{}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}',1774666027),('laravel-cache-boost:mcp:database-schema:mysql::1:0:0:0','a:2:{s:6:\"engine\";s:5:\"mysql\";s:6:\"tables\";a:37:{s:12:\"app_settings\";a:5:{s:2:\"id\";s:15:\"bigint unsigned\";s:3:\"key\";s:12:\"varchar(255)\";s:5:\"value\";s:4:\"text\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:26:\"approach_item_translations\";a:8:{s:2:\"id\";s:15:\"bigint unsigned\";s:5:\"label\";s:12:\"varchar(255)\";s:5:\"title\";s:12:\"varchar(255)\";s:11:\"description\";s:4:\"text\";s:6:\"locale\";s:12:\"varchar(255)\";s:16:\"approach_item_id\";s:15:\"bigint unsigned\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:14:\"approach_items\";a:6:{s:2:\"id\";s:15:\"bigint unsigned\";s:5:\"color\";s:12:\"varchar(255)\";s:4:\"icon\";s:12:\"varchar(255)\";s:5:\"order\";s:3:\"int\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:5:\"cache\";a:3:{s:3:\"key\";s:12:\"varchar(255)\";s:5:\"value\";s:10:\"mediumtext\";s:10:\"expiration\";s:3:\"int\";}s:11:\"cache_locks\";a:3:{s:3:\"key\";s:12:\"varchar(255)\";s:5:\"owner\";s:12:\"varchar(255)\";s:10:\"expiration\";s:3:\"int\";}s:10:\"categories\";a:5:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:4:\"slug\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:13:\"category_post\";a:2:{s:7:\"post_id\";s:15:\"bigint unsigned\";s:11:\"category_id\";s:15:\"bigint unsigned\";}s:14:\"certifications\";a:8:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"slug\";s:12:\"varchar(255)\";s:4:\"name\";s:12:\"varchar(255)\";s:8:\"language\";s:12:\"varchar(255)\";s:11:\"description\";s:12:\"varchar(255)\";s:5:\"image\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:15:\"citabic_domains\";a:9:{s:2:\"id\";s:15:\"bigint unsigned\";s:18:\"citabic_profile_id\";s:15:\"bigint unsigned\";s:5:\"title\";s:12:\"varchar(255)\";s:4:\"icon\";s:12:\"varchar(255)\";s:5:\"items\";s:4:\"json\";s:10:\"sort_order\";s:3:\"int\";s:12:\"translations\";s:4:\"json\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:15:\"citabic_figures\";a:8:{s:2:\"id\";s:15:\"bigint unsigned\";s:18:\"citabic_profile_id\";s:15:\"bigint unsigned\";s:5:\"label\";s:12:\"varchar(255)\";s:5:\"value\";s:12:\"varchar(255)\";s:10:\"sort_order\";s:3:\"int\";s:12:\"translations\";s:4:\"json\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:13:\"citabic_infos\";a:8:{s:2:\"id\";s:15:\"bigint unsigned\";s:18:\"citabic_profile_id\";s:15:\"bigint unsigned\";s:4:\"type\";s:12:\"varchar(255)\";s:7:\"content\";s:4:\"text\";s:10:\"sort_order\";s:3:\"int\";s:12:\"translations\";s:4:\"json\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:17:\"citabic_processes\";a:8:{s:2:\"id\";s:15:\"bigint unsigned\";s:18:\"citabic_profile_id\";s:15:\"bigint unsigned\";s:5:\"title\";s:12:\"varchar(255)\";s:11:\"description\";s:4:\"text\";s:10:\"sort_order\";s:3:\"int\";s:12:\"translations\";s:4:\"json\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:16:\"citabic_profiles\";a:19:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:7:\"tagline\";s:12:\"varchar(255)\";s:9:\"full_name\";s:12:\"varchar(255)\";s:10:\"legal_name\";s:12:\"varchar(255)\";s:10:\"legal_form\";s:12:\"varchar(255)\";s:7:\"capital\";s:12:\"varchar(255)\";s:11:\"head_office\";s:4:\"text\";s:3:\"ice\";s:12:\"varchar(255)\";s:18:\"company_created_at\";s:12:\"varchar(255)\";s:2:\"rc\";s:12:\"varchar(255)\";s:6:\"status\";s:12:\"varchar(255)\";s:5:\"phone\";s:12:\"varchar(255)\";s:5:\"email\";s:12:\"varchar(255)\";s:15:\"hero_video_path\";s:12:\"varchar(255)\";s:18:\"information_system\";s:8:\"longtext\";s:12:\"translations\";s:4:\"json\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:18:\"citabic_references\";a:15:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"slug\";s:12:\"varchar(255)\";s:5:\"title\";s:12:\"varchar(255)\";s:6:\"client\";s:12:\"varchar(255)\";s:5:\"image\";s:12:\"varchar(255)\";s:7:\"summary\";s:4:\"text\";s:11:\"description\";s:8:\"longtext\";s:7:\"surface\";s:12:\"varchar(255)\";s:6:\"budget\";s:12:\"varchar(255)\";s:5:\"items\";s:4:\"json\";s:6:\"blocks\";s:4:\"json\";s:12:\"translations\";s:4:\"json\";s:10:\"sort_order\";s:12:\"int unsigned\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:14:\"citabic_values\";a:10:{s:2:\"id\";s:15:\"bigint unsigned\";s:18:\"citabic_profile_id\";s:15:\"bigint unsigned\";s:4:\"type\";s:12:\"varchar(255)\";s:5:\"title\";s:12:\"varchar(255)\";s:4:\"text\";s:4:\"text\";s:5:\"image\";s:12:\"varchar(255)\";s:10:\"sort_order\";s:3:\"int\";s:12:\"translations\";s:4:\"json\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:13:\"company_infos\";a:6:{s:2:\"id\";s:15:\"bigint unsigned\";s:3:\"key\";s:12:\"varchar(255)\";s:5:\"value\";s:4:\"text\";s:4:\"lang\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:19:\"contact_submissions\";a:10:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:5:\"email\";s:12:\"varchar(255)\";s:7:\"subject\";s:12:\"varchar(255)\";s:6:\"number\";s:12:\"varchar(255)\";s:7:\"message\";s:4:\"text\";s:10:\"ip_address\";s:11:\"varchar(45)\";s:10:\"user_agent\";s:4:\"text\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:11:\"failed_jobs\";a:7:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"uuid\";s:12:\"varchar(255)\";s:10:\"connection\";s:4:\"text\";s:5:\"queue\";s:4:\"text\";s:7:\"payload\";s:8:\"longtext\";s:9:\"exception\";s:8:\"longtext\";s:9:\"failed_at\";s:9:\"timestamp\";}s:11:\"job_batches\";a:10:{s:2:\"id\";s:12:\"varchar(255)\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"total_jobs\";s:3:\"int\";s:12:\"pending_jobs\";s:3:\"int\";s:11:\"failed_jobs\";s:3:\"int\";s:14:\"failed_job_ids\";s:8:\"longtext\";s:7:\"options\";s:10:\"mediumtext\";s:12:\"cancelled_at\";s:3:\"int\";s:10:\"created_at\";s:3:\"int\";s:11:\"finished_at\";s:3:\"int\";}s:4:\"jobs\";a:7:{s:2:\"id\";s:15:\"bigint unsigned\";s:5:\"queue\";s:12:\"varchar(255)\";s:7:\"payload\";s:8:\"longtext\";s:8:\"attempts\";s:16:\"tinyint unsigned\";s:11:\"reserved_at\";s:12:\"int unsigned\";s:12:\"available_at\";s:12:\"int unsigned\";s:10:\"created_at\";s:12:\"int unsigned\";}s:10:\"migrations\";a:3:{s:2:\"id\";s:12:\"int unsigned\";s:9:\"migration\";s:12:\"varchar(255)\";s:5:\"batch\";s:3:\"int\";}s:20:\"mission_translations\";a:7:{s:2:\"id\";s:15:\"bigint unsigned\";s:5:\"title\";s:12:\"varchar(255)\";s:11:\"description\";s:4:\"text\";s:6:\"locale\";s:12:\"varchar(255)\";s:10:\"mission_id\";s:15:\"bigint unsigned\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:8:\"missions\";a:6:{s:2:\"id\";s:15:\"bigint unsigned\";s:16:\"background_image\";s:12:\"varchar(255)\";s:4:\"icon\";s:12:\"varchar(255)\";s:5:\"order\";s:3:\"int\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:21:\"model_has_permissions\";a:3:{s:13:\"permission_id\";s:15:\"bigint unsigned\";s:10:\"model_type\";s:12:\"varchar(255)\";s:8:\"model_id\";s:15:\"bigint unsigned\";}s:15:\"model_has_roles\";a:3:{s:7:\"role_id\";s:15:\"bigint unsigned\";s:10:\"model_type\";s:12:\"varchar(255)\";s:8:\"model_id\";s:15:\"bigint unsigned\";}s:13:\"notifications\";a:8:{s:2:\"id\";s:8:\"char(36)\";s:4:\"type\";s:12:\"varchar(255)\";s:15:\"notifiable_type\";s:12:\"varchar(255)\";s:13:\"notifiable_id\";s:15:\"bigint unsigned\";s:4:\"data\";s:4:\"text\";s:7:\"read_at\";s:9:\"timestamp\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:21:\"password_reset_tokens\";a:3:{s:5:\"email\";s:12:\"varchar(255)\";s:5:\"token\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";}s:11:\"permissions\";a:5:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"guard_name\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:13:\"post_comments\";a:8:{s:2:\"id\";s:15:\"bigint unsigned\";s:7:\"post_id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:5:\"email\";s:12:\"varchar(255)\";s:7:\"content\";s:4:\"text\";s:11:\"is_approved\";s:10:\"tinyint(1)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:8:\"post_tag\";a:2:{s:7:\"post_id\";s:15:\"bigint unsigned\";s:6:\"tag_id\";s:15:\"bigint unsigned\";}s:5:\"posts\";a:34:{s:2:\"id\";s:15:\"bigint unsigned\";s:5:\"title\";s:12:\"varchar(255)\";s:4:\"slug\";s:12:\"varchar(255)\";s:7:\"excerpt\";s:4:\"text\";s:7:\"content\";s:8:\"longtext\";s:14:\"featured_image\";s:12:\"varchar(255)\";s:6:\"status\";s:36:\"enum(\'draft\',\'published\',\'archived\')\";s:12:\"published_at\";s:9:\"timestamp\";s:12:\"reading_time\";s:3:\"int\";s:5:\"views\";s:3:\"int\";s:8:\"featured\";s:10:\"tinyint(1)\";s:14:\"allow_comments\";s:10:\"tinyint(1)\";s:10:\"meta_title\";s:12:\"varchar(255)\";s:16:\"meta_description\";s:4:\"text\";s:13:\"meta_keywords\";s:12:\"varchar(255)\";s:13:\"focus_keyword\";s:12:\"varchar(255)\";s:13:\"canonical_url\";s:12:\"varchar(255)\";s:8:\"og_title\";s:12:\"varchar(255)\";s:14:\"og_description\";s:4:\"text\";s:8:\"og_image\";s:12:\"varchar(255)\";s:13:\"twitter_title\";s:12:\"varchar(255)\";s:19:\"twitter_description\";s:4:\"text\";s:13:\"twitter_image\";s:12:\"varchar(255)\";s:12:\"twitter_card\";s:12:\"varchar(255)\";s:12:\"robots_index\";s:10:\"tinyint(1)\";s:13:\"robots_follow\";s:10:\"tinyint(1)\";s:11:\"schema_type\";s:12:\"varchar(255)\";s:11:\"schema_json\";s:8:\"longtext\";s:12:\"translations\";s:4:\"json\";s:6:\"blocks\";s:4:\"json\";s:9:\"author_id\";s:15:\"bigint unsigned\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";s:10:\"deleted_at\";s:9:\"timestamp\";}s:20:\"role_has_permissions\";a:2:{s:13:\"permission_id\";s:15:\"bigint unsigned\";s:7:\"role_id\";s:15:\"bigint unsigned\";}s:5:\"roles\";a:5:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:10:\"guard_name\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:16:\"section_contents\";a:7:{s:2:\"id\";s:15:\"bigint unsigned\";s:7:\"section\";s:12:\"varchar(255)\";s:3:\"key\";s:12:\"varchar(255)\";s:5:\"value\";s:4:\"text\";s:8:\"language\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:8:\"sessions\";a:6:{s:2:\"id\";s:12:\"varchar(255)\";s:7:\"user_id\";s:15:\"bigint unsigned\";s:10:\"ip_address\";s:11:\"varchar(45)\";s:10:\"user_agent\";s:4:\"text\";s:7:\"payload\";s:8:\"longtext\";s:13:\"last_activity\";s:3:\"int\";}s:4:\"tags\";a:5:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:4:\"slug\";s:12:\"varchar(255)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}s:5:\"users\";a:9:{s:2:\"id\";s:15:\"bigint unsigned\";s:4:\"name\";s:12:\"varchar(255)\";s:5:\"email\";s:12:\"varchar(255)\";s:17:\"email_verified_at\";s:9:\"timestamp\";s:8:\"password\";s:12:\"varchar(255)\";s:8:\"is_admin\";s:10:\"tinyint(1)\";s:14:\"remember_token\";s:12:\"varchar(100)\";s:10:\"created_at\";s:9:\"timestamp\";s:10:\"updated_at\";s:9:\"timestamp\";}}}',1774719875),('laravel-cache-company_info:fr','a:14:{s:5:\"phone\";s:17:\"+212 600 95 33 53\";s:5:\"email\";s:20:\"zaidsmd111@gmail.com\";s:7:\"address\";s:44:\"Office Building Anatolia Etage 6 N 17 Tanger\";s:10:\"legal_name\";s:7:\"CITABIC\";s:7:\"capital\";s:6:\"100000\";s:10:\"legal_form\";s:21:\"SARL a associe unique\";s:2:\"rc\";s:6:\"115445\";s:3:\"ice\";s:15:\"002789168000063\";s:6:\"status\";s:6:\"active\";s:13:\"creation_date\";s:10:\"04/16/2021\";s:9:\"full_name\";s:76:\"Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil\";s:8:\"linkedin\";s:30:\"https://www.linkedin.com/feed/\";s:9:\"instagram\";N;s:8:\"facebook\";N;}',1774684865),('laravel-cache-company_info:fr:v1','a:14:{s:5:\"phone\";s:17:\"+212 600 95 33 53\";s:5:\"email\";s:20:\"zaidsmd111@gmail.com\";s:7:\"address\";s:44:\"Office Building Anatolia Etage 6 N 17 Tanger\";s:10:\"legal_name\";s:7:\"CITABIC\";s:7:\"capital\";s:6:\"100000\";s:10:\"legal_form\";s:21:\"SARL a associe unique\";s:2:\"rc\";s:6:\"115445\";s:3:\"ice\";s:15:\"002789168000063\";s:6:\"status\";s:6:\"active\";s:13:\"creation_date\";s:10:\"04/16/2021\";s:9:\"full_name\";s:76:\"Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil\";s:8:\"linkedin\";s:30:\"https://www.linkedin.com/feed/\";s:9:\"instagram\";N;s:8:\"facebook\";N;}',1774685597),('laravel-cache-company_info:fr:v2','a:14:{s:5:\"phone\";s:17:\"+212 600 95 33 53\";s:5:\"email\";s:20:\"zaidsmd111@gmail.com\";s:7:\"address\";s:44:\"Office Building Anatolia Etage 6 N 17 Tanger\";s:10:\"legal_name\";s:7:\"CITABIC\";s:7:\"capital\";s:6:\"100000\";s:10:\"legal_form\";s:21:\"SARL a associe unique\";s:2:\"rc\";s:6:\"115445\";s:3:\"ice\";s:15:\"002789168000063\";s:6:\"status\";s:6:\"active\";s:13:\"creation_date\";s:10:\"04/16/2021\";s:9:\"full_name\";s:76:\"Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil\";s:8:\"linkedin\";s:30:\"https://www.linkedin.com/feed/\";s:9:\"instagram\";N;s:8:\"facebook\";N;}',1774685602),('laravel-cache-company_info:fr:v3','a:14:{s:5:\"phone\";s:17:\"+212 600 95 33 53\";s:5:\"email\";s:20:\"zaidsmd111@gmail.com\";s:7:\"address\";s:44:\"Office Building Anatolia Etage 6 N 17 Tanger\";s:10:\"legal_name\";s:7:\"CITABIC\";s:7:\"capital\";s:6:\"100000\";s:10:\"legal_form\";s:21:\"SARL a associe unique\";s:2:\"rc\";s:6:\"115445\";s:3:\"ice\";s:15:\"002789168000063\";s:6:\"status\";s:6:\"active\";s:13:\"creation_date\";s:10:\"04/16/2021\";s:9:\"full_name\";s:76:\"Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil\";s:8:\"linkedin\";s:30:\"https://www.linkedin.com/feed/\";s:9:\"instagram\";N;s:8:\"facebook\";N;}',1774685608),('laravel-cache-company_info:fr:v4','a:14:{s:5:\"phone\";s:17:\"+212 600 95 33 53\";s:5:\"email\";s:20:\"zaidsmd111@gmail.com\";s:7:\"address\";s:44:\"Office Building Anatolia Etage 6 N 17 Tanger\";s:10:\"legal_name\";s:7:\"CITABIC\";s:7:\"capital\";s:6:\"100000\";s:10:\"legal_form\";s:21:\"SARL a associe unique\";s:2:\"rc\";s:6:\"115445\";s:3:\"ice\";s:15:\"002789168000063\";s:6:\"status\";s:6:\"active\";s:13:\"creation_date\";s:10:\"04/16/2021\";s:9:\"full_name\";s:76:\"Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil\";s:8:\"linkedin\";s:30:\"https://www.linkedin.com/feed/\";s:9:\"instagram\";N;s:8:\"facebook\";N;}',1774685625),('laravel-cache-company_info:fr:v5','a:14:{s:5:\"phone\";s:17:\"+212 600 95 33 53\";s:5:\"email\";s:20:\"zaidsmd111@gmail.com\";s:7:\"address\";s:44:\"Office Building Anatolia Etage 6 N 17 Tanger\";s:10:\"legal_name\";s:7:\"CITABIC\";s:7:\"capital\";s:6:\"100000\";s:10:\"legal_form\";s:21:\"SARL a associe unique\";s:2:\"rc\";s:6:\"115445\";s:3:\"ice\";s:15:\"002789168000063\";s:6:\"status\";s:6:\"active\";s:13:\"creation_date\";s:10:\"04/16/2021\";s:9:\"full_name\";s:76:\"Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil\";s:8:\"linkedin\";s:30:\"https://www.linkedin.com/feed/\";s:9:\"instagram\";N;s:8:\"facebook\";N;}',1774685636),('laravel-cache-company_page_fr:v5','a:20:{s:15:\"about_header_bg\";s:50:\"about/3eHZyN8RwDo2GQOSbgzYKSKAzRJQ64ke2nlEcrJw.jpg\";s:11:\"about_title\";s:16:\"A propos de nous\";s:10:\"about_text\";s:906:\"<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>\";s:12:\"rounded_text\";s:37:\"Ensemble, construisons votre avenir !\";s:13:\"section_image\";s:50:\"about/TZH0dsVqNUapiHsg4az4Z66TYev8Pp9WJqENVK7V.jpg\";s:13:\"mission_title\";s:13:\"Notre mission\";s:12:\"mission_text\";s:158:\"<p><strong>CITABIC</strong> articule sa mission autour de la satisfaction client, de la qualite de gestion et d\'une execution structuree de ses processus.</p>\";s:12:\"why_us_title\";s:26:\"Pourquoi choisir CITABIC ?\";s:11:\"why_us_text\";s:344:\"<p>Expertise BTP certifi&eacute;e <strong data-path-to-node=\"1\" data-index-in-node=\"29\">ISO 9001 &amp; 45001</strong>. Nos &eacute;quipes d&eacute;ploient des solutions innovantes et sur-mesure, garantissant s&eacute;curit&eacute;, transparence (ERP) et durabilit&eacute; pour chacun de vos projets, dans le strict respect de vos exigences.</p>\";s:12:\"why_us_cards\";a:5:{i:0;s:31:\"Expertise complète dans le BTP\";i:1;s:46:\"Engagement envers la qualité et la sécurité\";i:2;s:39:\"Solutions personnalisées et innovantes\";i:3;s:44:\"Une équipe de professionnels expérimentés\";i:4;s:39:\"Infrastructure et technologie de pointe\";}s:17:\"organigrame_title\";s:18:\"Notre Organisation\";s:11:\"organigrame\";s:50:\"about/9tnBQ840WzezAqyp3v4KjDVVKwh8YTB1rjkUE7Pz.png\";s:18:\"cartographie_title\";s:36:\"Cartographie de processus de CITABIC\";s:12:\"cartographie\";s:50:\"about/y1DgrAlkrDAQPVFcPlPKWKzKQSsAQkECfuC0CVAP.png\";s:17:\"contact_form_text\";s:28:\"Prendre contact avec CITABIC\";s:13:\"contact_image\";s:52:\"contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:7:\"domains\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:3:{i:0;O:24:\"App\\Models\\CitabicDomain\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"citabic_domains\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:1;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";s:12:\"Génie civil\";s:4:\"icon\";s:52:\"domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";s:5:\"items\";s:113:\"[\"Travaux d\'infrastructure\", \"VRD\", \"Autoportant\", \"Ouvrage d´art\", \"Assainissement\", \"Renforcement Structures\"]\";s:10:\"sort_order\";i:0;s:12:\"translations\";s:153:\"{\"en\": {\"items\": [\"Infrastructure works\", \"VRD\", \"Freestanding\", \"Work of art\", \"Sanitation\", \"Reinforcement Structures\"], \"title\": \"CIVIL ENGINEERING\"}}\";s:10:\"created_at\";s:19:\"2026-03-18 02:03:27\";s:10:\"updated_at\";s:19:\"2026-03-19 02:23:08\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:1;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";s:12:\"Génie civil\";s:4:\"icon\";s:52:\"domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";s:5:\"items\";s:113:\"[\"Travaux d\'infrastructure\", \"VRD\", \"Autoportant\", \"Ouvrage d´art\", \"Assainissement\", \"Renforcement Structures\"]\";s:10:\"sort_order\";i:0;s:12:\"translations\";s:153:\"{\"en\": {\"items\": [\"Infrastructure works\", \"VRD\", \"Freestanding\", \"Work of art\", \"Sanitation\", \"Reinforcement Structures\"], \"title\": \"CIVIL ENGINEERING\"}}\";s:10:\"created_at\";s:19:\"2026-03-18 02:03:27\";s:10:\"updated_at\";s:19:\"2026-03-19 02:23:08\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:5:\"items\";s:5:\"array\";s:12:\"translations\";s:5:\"array\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";i:2;s:4:\"icon\";i:3;s:5:\"items\";i:4;s:10:\"sort_order\";i:5;s:12:\"translations\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:24:\"App\\Models\\CitabicDomain\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"citabic_domains\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:2;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";s:9:\"Bâtiment\";s:4:\"icon\";s:52:\"domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";s:5:\"items\";s:187:\"[\"Réalisations clé en main\", \"Entreprise générale\", \"Gros œuvre\", \"Rénovations et transformations\", \"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\", \"Façades\"]\";s:10:\"sort_order\";i:1;s:12:\"translations\";s:213:\"{\"en\": {\"items\": [\"Turnkey solutions\", \"General contractor\", \"Structural work\", \"Renovations and transformations\", \"Exterior landscaping (Industrial paving, Stamped concrete…)\", \"Facades\"], \"title\": \"Building\"}}\";s:10:\"created_at\";s:19:\"2026-03-19 02:35:21\";s:10:\"updated_at\";s:19:\"2026-03-19 02:35:21\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:2;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";s:9:\"Bâtiment\";s:4:\"icon\";s:52:\"domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";s:5:\"items\";s:187:\"[\"Réalisations clé en main\", \"Entreprise générale\", \"Gros œuvre\", \"Rénovations et transformations\", \"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\", \"Façades\"]\";s:10:\"sort_order\";i:1;s:12:\"translations\";s:213:\"{\"en\": {\"items\": [\"Turnkey solutions\", \"General contractor\", \"Structural work\", \"Renovations and transformations\", \"Exterior landscaping (Industrial paving, Stamped concrete…)\", \"Facades\"], \"title\": \"Building\"}}\";s:10:\"created_at\";s:19:\"2026-03-19 02:35:21\";s:10:\"updated_at\";s:19:\"2026-03-19 02:35:21\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:5:\"items\";s:5:\"array\";s:12:\"translations\";s:5:\"array\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";i:2;s:4:\"icon\";i:3;s:5:\"items\";i:4;s:10:\"sort_order\";i:5;s:12:\"translations\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:24:\"App\\Models\\CitabicDomain\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:15:\"citabic_domains\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:9:{s:2:\"id\";i:3;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";s:10:\"Immobilier\";s:4:\"icon\";s:52:\"domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";s:5:\"items\";s:128:\"[\"Ordonnancement, Pilotage et Coordination\", \"Simulations financières\", \"Acquisition et développement de projets immobiliers\"]\";s:10:\"sort_order\";i:2;s:12:\"translations\";s:166:\"{\"en\": {\"items\": [\"Scheduling, Management and Coordination\", \"Financial simulations\", \"Acquisition and development of real estate projects\"], \"title\": \"Real estate\"}}\";s:10:\"created_at\";s:19:\"2026-03-19 02:38:51\";s:10:\"updated_at\";s:19:\"2026-03-19 02:38:51\";}s:11:\"\0*\0original\";a:9:{s:2:\"id\";i:3;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";s:10:\"Immobilier\";s:4:\"icon\";s:52:\"domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";s:5:\"items\";s:128:\"[\"Ordonnancement, Pilotage et Coordination\", \"Simulations financières\", \"Acquisition et développement de projets immobiliers\"]\";s:10:\"sort_order\";i:2;s:12:\"translations\";s:166:\"{\"en\": {\"items\": [\"Scheduling, Management and Coordination\", \"Financial simulations\", \"Acquisition and development of real estate projects\"], \"title\": \"Real estate\"}}\";s:10:\"created_at\";s:19:\"2026-03-19 02:38:51\";s:10:\"updated_at\";s:19:\"2026-03-19 02:38:51\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:2:{s:5:\"items\";s:5:\"array\";s:12:\"translations\";s:5:\"array\";}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:6:{i:0;s:18:\"citabic_profile_id\";i:1;s:5:\"title\";i:2;s:4:\"icon\";i:3;s:5:\"items\";i:4;s:10:\"sort_order\";i:5;s:12:\"translations\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:8:\"missions\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:4:{i:0;O:18:\"App\\Models\\Mission\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"missions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:1;s:16:\"background_image\";N;s:4:\"icon\";s:53:\"missions/1y05FL3uOpPisxGpWkaPNzRbyeao3yALKeECWwFT.png\";s:5:\"order\";i:1;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:10:09\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:1;s:16:\"background_image\";N;s:4:\"icon\";s:53:\"missions/1y05FL3uOpPisxGpWkaPNzRbyeao3yALKeECWwFT.png\";s:5:\"order\";i:1;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:10:09\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"translations\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:1;s:5:\"title\";s:26:\"Excellence Opérationnelle\";s:11:\"description\";s:120:\"Garantir la satisfaction de nos clients par des prestations BTP de haute qualité et des services intégrés sur mesure.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:1;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:1;s:5:\"title\";s:26:\"Excellence Opérationnelle\";s:11:\"description\";s:120:\"Garantir la satisfaction de nos clients par des prestations BTP de haute qualité et des services intégrés sur mesure.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:1;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:2;s:5:\"title\";s:22:\"Operational Excellence\";s:11:\"description\";s:96:\"Ensuring client satisfaction through high-quality construction and tailored integrated services.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:1;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:2;s:5:\"title\";s:22:\"Operational Excellence\";s:11:\"description\";s:96:\"Ensuring client satisfaction through high-quality construction and tailored integrated services.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:1;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"icon\";i:1;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:18:\"App\\Models\\Mission\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"missions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:2;s:16:\"background_image\";N;s:4:\"icon\";s:53:\"missions/ZJtuAJ1wS1TdAYVtDgYWdIXK4lFUeuiprWe9noBq.png\";s:5:\"order\";i:2;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:12:58\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:2;s:16:\"background_image\";N;s:4:\"icon\";s:53:\"missions/ZJtuAJ1wS1TdAYVtDgYWdIXK4lFUeuiprWe9noBq.png\";s:5:\"order\";i:2;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:12:58\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"translations\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:3;s:5:\"title\";s:24:\"Standards Internationaux\";s:11:\"description\";s:104:\"Une expertise certifiée et un management rigoureux appliqué à tous les niveaux de notre organisation.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:2;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:3;s:5:\"title\";s:24:\"Standards Internationaux\";s:11:\"description\";s:104:\"Une expertise certifiée et un management rigoureux appliqué à tous les niveaux de notre organisation.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:2;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:4;s:5:\"title\";s:23:\"International Standards\";s:11:\"description\";s:98:\"Certified expertise and rigorous management systems applied across all levels of our organization.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:2;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:4;s:5:\"title\";s:23:\"International Standards\";s:11:\"description\";s:98:\"Certified expertise and rigorous management systems applied across all levels of our organization.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:2;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"icon\";i:1;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:2;O:18:\"App\\Models\\Mission\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"missions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:3;s:16:\"background_image\";s:53:\"missions/e2E5cNqiLZdH3vXvRgkfw62ihPsoArfp1jCMHFEm.jpg\";s:4:\"icon\";s:53:\"missions/iH19hGAvP2QmSwxduTFxxtOmvs67ujTlmz58i82B.png\";s:5:\"order\";i:3;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:14:43\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:3;s:16:\"background_image\";s:53:\"missions/e2E5cNqiLZdH3vXvRgkfw62ihPsoArfp1jCMHFEm.jpg\";s:4:\"icon\";s:53:\"missions/iH19hGAvP2QmSwxduTFxxtOmvs67ujTlmz58i82B.png\";s:5:\"order\";i:3;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:14:43\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"translations\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:5;s:5:\"title\";s:18:\"Offre Clé-en-Main\";s:11:\"description\";s:121:\"Une gamme complète d\'activités (génie civil, façades, travaux divers) offrant une synergie optimale pour vos projets.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:3;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:5;s:5:\"title\";s:18:\"Offre Clé-en-Main\";s:11:\"description\";s:121:\"Une gamme complète d\'activités (génie civil, façades, travaux divers) offrant une synergie optimale pour vos projets.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:3;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:6;s:5:\"title\";s:17:\"Turnkey Solutions\";s:11:\"description\";s:124:\"A comprehensive range of activities (civil engineering, facades, various works) providing optimal synergy for your projects.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:3;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:6;s:5:\"title\";s:17:\"Turnkey Solutions\";s:11:\"description\";s:124:\"A comprehensive range of activities (civil engineering, facades, various works) providing optimal synergy for your projects.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:3;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"icon\";i:1;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:3;O:18:\"App\\Models\\Mission\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:8:\"missions\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:6:{s:2:\"id\";i:4;s:16:\"background_image\";N;s:4:\"icon\";s:53:\"missions/bLZkZkONJnLL6JlJw7AviPzO5yj1XETeShZG5emc.png\";s:5:\"order\";i:4;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:17:40\";}s:11:\"\0*\0original\";a:6:{s:2:\"id\";i:4;s:16:\"background_image\";N;s:4:\"icon\";s:53:\"missions/bLZkZkONJnLL6JlJw7AviPzO5yj1XETeShZG5emc.png\";s:5:\"order\";i:4;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 20:17:40\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:1:{s:12:\"translations\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:7;s:5:\"title\";s:21:\"Gestion & Durabilité\";s:11:\"description\";s:99:\"Une gestion de projet optimale assurant la pérennité et la solidité de toutes nos réalisations.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:4;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:7;s:5:\"title\";s:21:\"Gestion & Durabilité\";s:11:\"description\";s:99:\"Une gestion de projet optimale assurant la pérennité et la solidité de toutes nos réalisations.\";s:6:\"locale\";s:2:\"fr\";s:10:\"mission_id\";i:4;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:29:\"App\\Models\\MissionTranslation\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:20:\"mission_translations\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:7:{s:2:\"id\";i:8;s:5:\"title\";s:23:\"Management & Durability\";s:11:\"description\";s:96:\"Optimal project management ensuring the longevity and structural integrity of every realization.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:4;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:11:\"\0*\0original\";a:7:{s:2:\"id\";i:8;s:5:\"title\";s:23:\"Management & Durability\";s:11:\"description\";s:96:\"Optimal project management ensuring the longevity and structural integrity of every realization.\";s:6:\"locale\";s:2:\"en\";s:10:\"mission_id\";i:4;s:10:\"created_at\";s:19:\"2026-03-19 03:35:31\";s:10:\"updated_at\";s:19:\"2026-03-19 03:35:31\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:4:{i:0;s:5:\"title\";i:1;s:11:\"description\";i:2;s:6:\"locale\";i:3;s:10:\"mission_id\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:2:{i:0;s:4:\"icon\";i:1;s:5:\"order\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}s:14:\"certifications\";O:39:\"Illuminate\\Database\\Eloquent\\Collection\":2:{s:8:\"\0*\0items\";a:2:{i:0;O:24:\"App\\Models\\Certification\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"certifications\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:1;s:4:\"slug\";s:24:\"certifie-iso-9001-v-2015\";s:4:\"name\";s:25:\"Certifié ISO 9001 V 2015\";s:8:\"language\";s:2:\"fr\";s:11:\"description\";s:37:\"Système de Management de la Qualité\";s:5:\"image\";s:59:\"certifications/VzP1FVLsZWLT5WZZFkP1CS2lnSWiSmsbygwjyrjj.jpg\";s:10:\"created_at\";s:19:\"2026-03-14 21:38:12\";s:10:\"updated_at\";s:19:\"2026-03-14 21:46:01\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:1;s:4:\"slug\";s:24:\"certifie-iso-9001-v-2015\";s:4:\"name\";s:25:\"Certifié ISO 9001 V 2015\";s:8:\"language\";s:2:\"fr\";s:11:\"description\";s:37:\"Système de Management de la Qualité\";s:5:\"image\";s:59:\"certifications/VzP1FVLsZWLT5WZZFkP1CS2lnSWiSmsbygwjyrjj.jpg\";s:10:\"created_at\";s:19:\"2026-03-14 21:38:12\";s:10:\"updated_at\";s:19:\"2026-03-14 21:46:01\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:11:\"description\";i:3;s:8:\"language\";i:4;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}i:1;O:24:\"App\\Models\\Certification\":33:{s:13:\"\0*\0connection\";s:5:\"mysql\";s:8:\"\0*\0table\";s:14:\"certifications\";s:13:\"\0*\0primaryKey\";s:2:\"id\";s:10:\"\0*\0keyType\";s:3:\"int\";s:12:\"incrementing\";b:1;s:7:\"\0*\0with\";a:0:{}s:12:\"\0*\0withCount\";a:0:{}s:19:\"preventsLazyLoading\";b:0;s:10:\"\0*\0perPage\";i:15;s:6:\"exists\";b:1;s:18:\"wasRecentlyCreated\";b:0;s:28:\"\0*\0escapeWhenCastingToString\";b:0;s:13:\"\0*\0attributes\";a:8:{s:2:\"id\";i:3;s:4:\"slug\";s:25:\"certifie-iso-45001-v-2018\";s:4:\"name\";s:26:\"Certifié ISO 45001 V 2018\";s:8:\"language\";s:2:\"fr\";s:11:\"description\";s:26:\"Système de Management SST\";s:5:\"image\";s:59:\"certifications/qe8SZS8GMZ5SZH2ARCu9FPiX1pg9EJGdb7rNvrej.jpg\";s:10:\"created_at\";s:19:\"2026-03-14 21:44:29\";s:10:\"updated_at\";s:19:\"2026-03-14 21:44:29\";}s:11:\"\0*\0original\";a:8:{s:2:\"id\";i:3;s:4:\"slug\";s:25:\"certifie-iso-45001-v-2018\";s:4:\"name\";s:26:\"Certifié ISO 45001 V 2018\";s:8:\"language\";s:2:\"fr\";s:11:\"description\";s:26:\"Système de Management SST\";s:5:\"image\";s:59:\"certifications/qe8SZS8GMZ5SZH2ARCu9FPiX1pg9EJGdb7rNvrej.jpg\";s:10:\"created_at\";s:19:\"2026-03-14 21:44:29\";s:10:\"updated_at\";s:19:\"2026-03-14 21:44:29\";}s:10:\"\0*\0changes\";a:0:{}s:11:\"\0*\0previous\";a:0:{}s:8:\"\0*\0casts\";a:0:{}s:17:\"\0*\0classCastCache\";a:0:{}s:21:\"\0*\0attributeCastCache\";a:0:{}s:13:\"\0*\0dateFormat\";N;s:10:\"\0*\0appends\";a:0:{}s:19:\"\0*\0dispatchesEvents\";a:0:{}s:14:\"\0*\0observables\";a:0:{}s:12:\"\0*\0relations\";a:0:{}s:10:\"\0*\0touches\";a:0:{}s:27:\"\0*\0relationAutoloadCallback\";N;s:26:\"\0*\0relationAutoloadContext\";N;s:10:\"timestamps\";b:1;s:13:\"usesUniqueIds\";b:0;s:9:\"\0*\0hidden\";a:0:{}s:10:\"\0*\0visible\";a:0:{}s:11:\"\0*\0fillable\";a:5:{i:0;s:4:\"name\";i:1;s:4:\"slug\";i:2;s:11:\"description\";i:3;s:8:\"language\";i:4;s:5:\"image\";}s:10:\"\0*\0guarded\";a:1:{i:0;s:1:\"*\";}}}s:28:\"\0*\0escapeWhenCastingToString\";b:0;}}',1774685828),('laravel-cache-contact_page:fr:v5','a:5:{s:10:\"form_title\";s:28:\"Prendre contact avec CITABIC\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:18:\"contact_image_path\";s:52:\"contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:17:\"contact_image_url\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:3:\"seo\";a:7:{s:5:\"title\";s:17:\"CITABIC | Contact\";s:11:\"description\";s:28:\"Prendre contact avec CITABIC\";s:8:\"keywords\";s:46:\"citabic, contact, btp, genie civil, immobilier\";s:8:\"og_title\";s:17:\"CITABIC | Contact\";s:14:\"og_description\";s:28:\"Prendre contact avec CITABIC\";s:8:\"og_image\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:12:\"twitter_card\";s:19:\"summary_large_image\";}}',1774666020),('laravel-cache-guest_pages_cache_version','i:5;',2090024035),('laravel-cache-home_page:fr','a:9:{s:3:\"seo\";a:7:{s:5:\"title\";s:17:\"CITABIC | Accueil\";s:11:\"description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"keywords\";s:44:\"citabic, btp, genie civil, immobilier, maroc\";s:8:\"og_title\";s:17:\"CITABIC | Accueil\";s:14:\"og_description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"og_image\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:12:\"twitter_card\";s:19:\"summary_large_image\";}s:4:\"hero\";a:4:{s:8:\"subtitle\";s:29:\"VOTRE VISION, NOTRE EXPERTISE\";s:5:\"title\";s:38:\"Ensemble, nous bâtissons votre avenir\";s:8:\"cta_text\";s:9:\"Decouvrir\";s:11:\"circle_text\";s:37:\"Ensemble, construisons votre avenir !\";}s:5:\"about\";a:7:{s:11:\"image_1_url\";s:77:\"http://localhost:8000/storage/about/8b2b1014-9f28-4a93-bf50-1726d70ac32f.webp\";s:11:\"image_2_url\";s:77:\"http://localhost:8000/storage/about/52a4913b-db46-40dd-8c97-7e14f42aee2f.webp\";s:11:\"image_3_url\";s:77:\"http://localhost:8000/storage/about/9fc67cae-4e9a-4ccc-80fb-f735adcae07b.webp\";s:12:\"rounded_text\";s:37:\"Ensemble, construisons votre avenir !\";s:8:\"subtitle\";s:16:\"A propos de nous\";s:5:\"title\";s:24:\"Présentation de CITABIC\";s:4:\"text\";s:906:\"<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>\";}s:7:\"domains\";a:4:{s:8:\"subtitle\";s:19:\"Domaines d\'activite\";s:5:\"title\";s:37:\"Une couverture complete du cycle BTP.\";s:4:\"text\";s:125:\"<p>Les activites de CITABIC couvrent le genie civil, le batiment, l\'immobilier et les missions de coordination de projet.</p>\";s:5:\"items\";a:3:{i:0;a:3:{s:5:\"title\";s:12:\"Génie civil\";s:5:\"items\";a:6:{i:0;s:24:\"Travaux d\'infrastructure\";i:1;s:3:\"VRD\";i:2;s:11:\"Autoportant\";i:3;s:14:\"Ouvrage d´art\";i:4;s:14:\"Assainissement\";i:5;s:23:\"Renforcement Structures\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";}i:1;a:3:{s:5:\"title\";s:9:\"Bâtiment\";s:5:\"items\";a:6:{i:0;s:26:\"Réalisations clé en main\";i:1;s:21:\"Entreprise générale\";i:2;s:11:\"Gros œuvre\";i:3;s:31:\"Rénovations et transformations\";i:4;s:66:\"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\";i:5;s:8:\"Façades\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";}i:2;a:3:{s:5:\"title\";s:10:\"Immobilier\";s:5:\"items\";a:3:{i:0;s:40:\"Ordonnancement, Pilotage et Coordination\";i:1;s:24:\"Simulations financières\";i:2;s:52:\"Acquisition et développement de projets immobiliers\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";}}}s:3:\"why\";a:4:{s:9:\"image_url\";s:77:\"http://localhost:8000/storage/about/d7e62eac-a664-46de-9833-4028892d3634.webp\";s:8:\"subtitle\";s:21:\"Pourquoi nous choisir\";s:5:\"title\";s:40:\"Où la vision rencontre la construction.\";s:4:\"text\";s:234:\"Expertise BTP certifiée ISO 9001 & 45001. Nos équipes déploient des solutions innovantes et sur-mesure, garantissant sécurité, transparence (ERP) et durabilité pour chacun de vos projets, dans le strict respect de vos exigences.\";}s:6:\"values\";a:4:{s:8:\"subtitle\";s:11:\"Nos valeurs\";s:5:\"title\";s:18:\"Ce que nous defons\";s:4:\"text\";s:0:\"\";s:10:\"empty_text\";s:25:\"Aucune valeur configuree.\";}s:8:\"projects\";a:4:{s:8:\"subtitle\";s:11:\"Nos projets\";s:5:\"title\";s:31:\"Découvrez nos derniers projets\";s:4:\"text\";s:148:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement et la construction de structures destin&eacute;es aux entreprises.</p>\";s:5:\"items\";a:1:{i:0;a:4:{s:4:\"slug\";s:18:\"unite-industrielle\";s:5:\"title\";s:92:\"Construction d’une unité industrielle de production de carrelage décoratif traditionnel.\";s:6:\"client\";s:12:\"PJLP SARL AU\";s:15:\"cover_image_url\";s:77:\"http://localhost:8000/storage/about/d84f913a-f25c-498f-bf89-2ff2cb4f28af.webp\";}}}s:7:\"contact\";a:6:{s:8:\"subtitle\";s:14:\"Contactez-nous\";s:10:\"form_title\";s:28:\"Prendre contact avec CITABIC\";s:17:\"contact_image_url\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:11:\"submit_text\";s:18:\"Envoyer le message\";s:19:\"message_placeholder\";s:13:\"Votre message\";}s:4:\"blog\";a:8:{s:8:\"subtitle\";s:19:\"Actualités et blog\";s:5:\"title\";s:27:\"Découvrez nos perspectives\";s:4:\"text\";s:245:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement&nbsp; et l\'&eacute;dification de structures strat&eacute;giques d&eacute;di&eacute;es &agrave; la performance des entreprises.<br>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\";s:11:\"browse_text\";s:17:\"Voir tout le blog\";s:14:\"read_more_text\";s:13:\"Lire la suite\";s:13:\"min_read_text\";s:14:\"min de lecture\";s:10:\"empty_text\";s:36:\"Aucun article publie pour le moment.\";s:5:\"posts\";a:1:{i:0;a:6:{s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:18:\"published_at_label\";s:14:\"March 27, 2026\";s:12:\"reading_time\";i:0;}}}}',1777255265),('laravel-cache-home_page:fr:v1','a:9:{s:3:\"seo\";a:7:{s:5:\"title\";s:17:\"CITABIC | Accueil\";s:11:\"description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"keywords\";s:44:\"citabic, btp, genie civil, immobilier, maroc\";s:8:\"og_title\";s:17:\"CITABIC | Accueil\";s:14:\"og_description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"og_image\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:12:\"twitter_card\";s:19:\"summary_large_image\";}s:4:\"hero\";a:4:{s:8:\"subtitle\";s:29:\"VOTRE VISION, NOTRE EXPERTISE\";s:5:\"title\";s:38:\"Ensemble, nous bâtissons votre avenir\";s:8:\"cta_text\";s:9:\"Decouvrir\";s:11:\"circle_text\";s:37:\"Ensemble, construisons votre avenir !\";}s:5:\"about\";a:7:{s:11:\"image_1_url\";s:77:\"http://localhost:8000/storage/about/8b2b1014-9f28-4a93-bf50-1726d70ac32f.webp\";s:11:\"image_2_url\";s:77:\"http://localhost:8000/storage/about/52a4913b-db46-40dd-8c97-7e14f42aee2f.webp\";s:11:\"image_3_url\";s:77:\"http://localhost:8000/storage/about/9fc67cae-4e9a-4ccc-80fb-f735adcae07b.webp\";s:12:\"rounded_text\";s:37:\"Ensemble, construisons votre avenir !\";s:8:\"subtitle\";s:16:\"A propos de nous\";s:5:\"title\";s:24:\"Présentation de CITABIC\";s:4:\"text\";s:906:\"<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>\";}s:7:\"domains\";a:4:{s:8:\"subtitle\";s:19:\"Domaines d\'activite\";s:5:\"title\";s:37:\"Une couverture complete du cycle BTP.\";s:4:\"text\";s:125:\"<p>Les activites de CITABIC couvrent le genie civil, le batiment, l\'immobilier et les missions de coordination de projet.</p>\";s:5:\"items\";a:3:{i:0;a:3:{s:5:\"title\";s:12:\"Génie civil\";s:5:\"items\";a:6:{i:0;s:24:\"Travaux d\'infrastructure\";i:1;s:3:\"VRD\";i:2;s:11:\"Autoportant\";i:3;s:14:\"Ouvrage d´art\";i:4;s:14:\"Assainissement\";i:5;s:23:\"Renforcement Structures\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";}i:1;a:3:{s:5:\"title\";s:9:\"Bâtiment\";s:5:\"items\";a:6:{i:0;s:26:\"Réalisations clé en main\";i:1;s:21:\"Entreprise générale\";i:2;s:11:\"Gros œuvre\";i:3;s:31:\"Rénovations et transformations\";i:4;s:66:\"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\";i:5;s:8:\"Façades\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";}i:2;a:3:{s:5:\"title\";s:10:\"Immobilier\";s:5:\"items\";a:3:{i:0;s:40:\"Ordonnancement, Pilotage et Coordination\";i:1;s:24:\"Simulations financières\";i:2;s:52:\"Acquisition et développement de projets immobiliers\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";}}}s:3:\"why\";a:4:{s:9:\"image_url\";s:77:\"http://localhost:8000/storage/about/d7e62eac-a664-46de-9833-4028892d3634.webp\";s:8:\"subtitle\";s:21:\"Pourquoi nous choisir\";s:5:\"title\";s:40:\"Où la vision rencontre la construction.\";s:4:\"text\";s:234:\"Expertise BTP certifiée ISO 9001 & 45001. Nos équipes déploient des solutions innovantes et sur-mesure, garantissant sécurité, transparence (ERP) et durabilité pour chacun de vos projets, dans le strict respect de vos exigences.\";}s:6:\"values\";a:4:{s:8:\"subtitle\";s:11:\"Nos valeurs\";s:5:\"title\";s:18:\"Ce que nous defons\";s:4:\"text\";s:0:\"\";s:10:\"empty_text\";s:25:\"Aucune valeur configuree.\";}s:8:\"projects\";a:4:{s:8:\"subtitle\";s:11:\"Nos projets\";s:5:\"title\";s:31:\"Découvrez nos derniers projets\";s:4:\"text\";s:148:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement et la construction de structures destin&eacute;es aux entreprises.</p>\";s:5:\"items\";a:1:{i:0;a:4:{s:4:\"slug\";s:18:\"unite-industrielle\";s:5:\"title\";s:92:\"Construction d’une unité industrielle de production de carrelage décoratif traditionnel.\";s:6:\"client\";s:12:\"PJLP SARL AU\";s:15:\"cover_image_url\";s:77:\"http://localhost:8000/storage/about/d84f913a-f25c-498f-bf89-2ff2cb4f28af.webp\";}}}s:7:\"contact\";a:6:{s:8:\"subtitle\";s:14:\"Contactez-nous\";s:10:\"form_title\";s:28:\"Prendre contact avec CITABIC\";s:17:\"contact_image_url\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:11:\"submit_text\";s:18:\"Envoyer le message\";s:19:\"message_placeholder\";s:13:\"Votre message\";}s:4:\"blog\";a:8:{s:8:\"subtitle\";s:19:\"Actualités et blog\";s:5:\"title\";s:27:\"Découvrez nos perspectives\";s:4:\"text\";s:245:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement&nbsp; et l\'&eacute;dification de structures strat&eacute;giques d&eacute;di&eacute;es &agrave; la performance des entreprises.<br>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\";s:11:\"browse_text\";s:17:\"Voir tout le blog\";s:14:\"read_more_text\";s:13:\"Lire la suite\";s:13:\"min_read_text\";s:14:\"min de lecture\";s:10:\"empty_text\";s:36:\"Aucun article publie pour le moment.\";s:5:\"posts\";a:1:{i:0;a:6:{s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:18:\"published_at_label\";s:14:\"March 27, 2026\";s:12:\"reading_time\";i:0;}}}}',1777255997),('laravel-cache-home_page:fr:v2','a:9:{s:3:\"seo\";a:7:{s:5:\"title\";s:17:\"CITABIC | Accueil\";s:11:\"description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"keywords\";s:44:\"citabic, btp, genie civil, immobilier, maroc\";s:8:\"og_title\";s:17:\"CITABIC | Accueil\";s:14:\"og_description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"og_image\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:12:\"twitter_card\";s:19:\"summary_large_image\";}s:4:\"hero\";a:4:{s:8:\"subtitle\";s:29:\"VOTRE VISION, NOTRE EXPERTISE\";s:5:\"title\";s:5:\"addsa\";s:8:\"cta_text\";s:9:\"Decouvrir\";s:11:\"circle_text\";s:37:\"Ensemble, construisons votre avenir !\";}s:5:\"about\";a:7:{s:11:\"image_1_url\";s:77:\"http://localhost:8000/storage/about/8b2b1014-9f28-4a93-bf50-1726d70ac32f.webp\";s:11:\"image_2_url\";s:77:\"http://localhost:8000/storage/about/52a4913b-db46-40dd-8c97-7e14f42aee2f.webp\";s:11:\"image_3_url\";s:77:\"http://localhost:8000/storage/about/9fc67cae-4e9a-4ccc-80fb-f735adcae07b.webp\";s:12:\"rounded_text\";s:37:\"Ensemble, construisons votre avenir !\";s:8:\"subtitle\";s:16:\"A propos de nous\";s:5:\"title\";s:24:\"Présentation de CITABIC\";s:4:\"text\";s:906:\"<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>\";}s:7:\"domains\";a:4:{s:8:\"subtitle\";s:19:\"Domaines d\'activite\";s:5:\"title\";s:37:\"Une couverture complete du cycle BTP.\";s:4:\"text\";s:125:\"<p>Les activites de CITABIC couvrent le genie civil, le batiment, l\'immobilier et les missions de coordination de projet.</p>\";s:5:\"items\";a:3:{i:0;a:3:{s:5:\"title\";s:12:\"Génie civil\";s:5:\"items\";a:6:{i:0;s:24:\"Travaux d\'infrastructure\";i:1;s:3:\"VRD\";i:2;s:11:\"Autoportant\";i:3;s:14:\"Ouvrage d´art\";i:4;s:14:\"Assainissement\";i:5;s:23:\"Renforcement Structures\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";}i:1;a:3:{s:5:\"title\";s:9:\"Bâtiment\";s:5:\"items\";a:6:{i:0;s:26:\"Réalisations clé en main\";i:1;s:21:\"Entreprise générale\";i:2;s:11:\"Gros œuvre\";i:3;s:31:\"Rénovations et transformations\";i:4;s:66:\"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\";i:5;s:8:\"Façades\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";}i:2;a:3:{s:5:\"title\";s:10:\"Immobilier\";s:5:\"items\";a:3:{i:0;s:40:\"Ordonnancement, Pilotage et Coordination\";i:1;s:24:\"Simulations financières\";i:2;s:52:\"Acquisition et développement de projets immobiliers\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";}}}s:3:\"why\";a:4:{s:9:\"image_url\";s:77:\"http://localhost:8000/storage/about/d7e62eac-a664-46de-9833-4028892d3634.webp\";s:8:\"subtitle\";s:21:\"Pourquoi nous choisir\";s:5:\"title\";s:40:\"Où la vision rencontre la construction.\";s:4:\"text\";s:234:\"Expertise BTP certifiée ISO 9001 & 45001. Nos équipes déploient des solutions innovantes et sur-mesure, garantissant sécurité, transparence (ERP) et durabilité pour chacun de vos projets, dans le strict respect de vos exigences.\";}s:6:\"values\";a:4:{s:8:\"subtitle\";s:11:\"Nos valeurs\";s:5:\"title\";s:18:\"Ce que nous defons\";s:4:\"text\";s:0:\"\";s:10:\"empty_text\";s:25:\"Aucune valeur configuree.\";}s:8:\"projects\";a:4:{s:8:\"subtitle\";s:11:\"Nos projets\";s:5:\"title\";s:31:\"Découvrez nos derniers projets\";s:4:\"text\";s:148:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement et la construction de structures destin&eacute;es aux entreprises.</p>\";s:5:\"items\";a:1:{i:0;a:4:{s:4:\"slug\";s:18:\"unite-industrielle\";s:5:\"title\";s:92:\"Construction d’une unité industrielle de production de carrelage décoratif traditionnel.\";s:6:\"client\";s:12:\"PJLP SARL AU\";s:15:\"cover_image_url\";s:77:\"http://localhost:8000/storage/about/d84f913a-f25c-498f-bf89-2ff2cb4f28af.webp\";}}}s:7:\"contact\";a:6:{s:8:\"subtitle\";s:14:\"Contactez-nous\";s:10:\"form_title\";s:28:\"Prendre contact avec CITABIC\";s:17:\"contact_image_url\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:11:\"submit_text\";s:18:\"Envoyer le message\";s:19:\"message_placeholder\";s:13:\"Votre message\";}s:4:\"blog\";a:8:{s:8:\"subtitle\";s:19:\"Actualités et blog\";s:5:\"title\";s:27:\"Découvrez nos perspectives\";s:4:\"text\";s:245:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement&nbsp; et l\'&eacute;dification de structures strat&eacute;giques d&eacute;di&eacute;es &agrave; la performance des entreprises.<br>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\";s:11:\"browse_text\";s:17:\"Voir tout le blog\";s:14:\"read_more_text\";s:13:\"Lire la suite\";s:13:\"min_read_text\";s:14:\"min de lecture\";s:10:\"empty_text\";s:36:\"Aucun article publie pour le moment.\";s:5:\"posts\";a:1:{i:0;a:6:{s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:18:\"published_at_label\";s:14:\"March 27, 2026\";s:12:\"reading_time\";i:0;}}}}',1777256002),('laravel-cache-home_page:fr:v3','a:9:{s:3:\"seo\";a:7:{s:5:\"title\";s:17:\"CITABIC | Accueil\";s:11:\"description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"keywords\";s:44:\"citabic, btp, genie civil, immobilier, maroc\";s:8:\"og_title\";s:17:\"CITABIC | Accueil\";s:14:\"og_description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"og_image\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:12:\"twitter_card\";s:19:\"summary_large_image\";}s:4:\"hero\";a:4:{s:8:\"subtitle\";s:29:\"VOTRE VISION, NOTRE EXPERTISE\";s:5:\"title\";s:38:\"Ensemble, nous bâtissons votre avenir\";s:8:\"cta_text\";s:9:\"Decouvrir\";s:11:\"circle_text\";s:37:\"Ensemble, construisons votre avenir !\";}s:5:\"about\";a:7:{s:11:\"image_1_url\";s:77:\"http://localhost:8000/storage/about/8b2b1014-9f28-4a93-bf50-1726d70ac32f.webp\";s:11:\"image_2_url\";s:77:\"http://localhost:8000/storage/about/52a4913b-db46-40dd-8c97-7e14f42aee2f.webp\";s:11:\"image_3_url\";s:77:\"http://localhost:8000/storage/about/9fc67cae-4e9a-4ccc-80fb-f735adcae07b.webp\";s:12:\"rounded_text\";s:37:\"Ensemble, construisons votre avenir !\";s:8:\"subtitle\";s:16:\"A propos de nous\";s:5:\"title\";s:24:\"Présentation de CITABIC\";s:4:\"text\";s:906:\"<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>\";}s:7:\"domains\";a:4:{s:8:\"subtitle\";s:19:\"Domaines d\'activite\";s:5:\"title\";s:37:\"Une couverture complete du cycle BTP.\";s:4:\"text\";s:125:\"<p>Les activites de CITABIC couvrent le genie civil, le batiment, l\'immobilier et les missions de coordination de projet.</p>\";s:5:\"items\";a:3:{i:0;a:3:{s:5:\"title\";s:12:\"Génie civil\";s:5:\"items\";a:6:{i:0;s:24:\"Travaux d\'infrastructure\";i:1;s:3:\"VRD\";i:2;s:11:\"Autoportant\";i:3;s:14:\"Ouvrage d´art\";i:4;s:14:\"Assainissement\";i:5;s:23:\"Renforcement Structures\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";}i:1;a:3:{s:5:\"title\";s:9:\"Bâtiment\";s:5:\"items\";a:6:{i:0;s:26:\"Réalisations clé en main\";i:1;s:21:\"Entreprise générale\";i:2;s:11:\"Gros œuvre\";i:3;s:31:\"Rénovations et transformations\";i:4;s:66:\"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\";i:5;s:8:\"Façades\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";}i:2;a:3:{s:5:\"title\";s:10:\"Immobilier\";s:5:\"items\";a:3:{i:0;s:40:\"Ordonnancement, Pilotage et Coordination\";i:1;s:24:\"Simulations financières\";i:2;s:52:\"Acquisition et développement de projets immobiliers\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";}}}s:3:\"why\";a:4:{s:9:\"image_url\";s:77:\"http://localhost:8000/storage/about/d7e62eac-a664-46de-9833-4028892d3634.webp\";s:8:\"subtitle\";s:21:\"Pourquoi nous choisir\";s:5:\"title\";s:40:\"Où la vision rencontre la construction.\";s:4:\"text\";s:234:\"Expertise BTP certifiée ISO 9001 & 45001. Nos équipes déploient des solutions innovantes et sur-mesure, garantissant sécurité, transparence (ERP) et durabilité pour chacun de vos projets, dans le strict respect de vos exigences.\";}s:6:\"values\";a:4:{s:8:\"subtitle\";s:11:\"Nos valeurs\";s:5:\"title\";s:18:\"Ce que nous defons\";s:4:\"text\";s:0:\"\";s:10:\"empty_text\";s:25:\"Aucune valeur configuree.\";}s:8:\"projects\";a:4:{s:8:\"subtitle\";s:11:\"Nos projets\";s:5:\"title\";s:31:\"Découvrez nos derniers projets\";s:4:\"text\";s:148:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement et la construction de structures destin&eacute;es aux entreprises.</p>\";s:5:\"items\";a:1:{i:0;a:4:{s:4:\"slug\";s:18:\"unite-industrielle\";s:5:\"title\";s:92:\"Construction d’une unité industrielle de production de carrelage décoratif traditionnel.\";s:6:\"client\";s:12:\"PJLP SARL AU\";s:15:\"cover_image_url\";s:77:\"http://localhost:8000/storage/about/d84f913a-f25c-498f-bf89-2ff2cb4f28af.webp\";}}}s:7:\"contact\";a:6:{s:8:\"subtitle\";s:14:\"Contactez-nous\";s:10:\"form_title\";s:28:\"Prendre contact avec CITABIC\";s:17:\"contact_image_url\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:11:\"submit_text\";s:18:\"Envoyer le message\";s:19:\"message_placeholder\";s:13:\"Votre message\";}s:4:\"blog\";a:8:{s:8:\"subtitle\";s:19:\"Actualités et blog\";s:5:\"title\";s:27:\"Découvrez nos perspectives\";s:4:\"text\";s:245:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement&nbsp; et l\'&eacute;dification de structures strat&eacute;giques d&eacute;di&eacute;es &agrave; la performance des entreprises.<br>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\";s:11:\"browse_text\";s:17:\"Voir tout le blog\";s:14:\"read_more_text\";s:13:\"Lire la suite\";s:13:\"min_read_text\";s:14:\"min de lecture\";s:10:\"empty_text\";s:36:\"Aucun article publie pour le moment.\";s:5:\"posts\";a:1:{i:0;a:6:{s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:18:\"published_at_label\";s:14:\"March 27, 2026\";s:12:\"reading_time\";i:0;}}}}',1777256008),('laravel-cache-home_page:fr:v4','a:9:{s:3:\"seo\";a:7:{s:5:\"title\";s:17:\"CITABIC | Accueil\";s:11:\"description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"keywords\";s:44:\"citabic, btp, genie civil, immobilier, maroc\";s:8:\"og_title\";s:17:\"CITABIC | Accueil\";s:14:\"og_description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"og_image\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:12:\"twitter_card\";s:19:\"summary_large_image\";}s:4:\"hero\";a:4:{s:8:\"subtitle\";s:29:\"VOTRE VISION, NOTRE EXPERTISE\";s:5:\"title\";s:38:\"Ensemble, nous bâtissons votre avenir\";s:8:\"cta_text\";s:9:\"Decouvrir\";s:11:\"circle_text\";s:37:\"Ensemble, construisons votre avenir !\";}s:5:\"about\";a:7:{s:11:\"image_1_url\";s:77:\"http://localhost:8000/storage/about/8b2b1014-9f28-4a93-bf50-1726d70ac32f.webp\";s:11:\"image_2_url\";s:77:\"http://localhost:8000/storage/about/52a4913b-db46-40dd-8c97-7e14f42aee2f.webp\";s:11:\"image_3_url\";s:77:\"http://localhost:8000/storage/about/9fc67cae-4e9a-4ccc-80fb-f735adcae07b.webp\";s:12:\"rounded_text\";s:37:\"Ensemble, construisons votre avenir !\";s:8:\"subtitle\";s:16:\"A propos de nous\";s:5:\"title\";s:24:\"Présentation de CITABIC\";s:4:\"text\";s:906:\"<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>\";}s:7:\"domains\";a:4:{s:8:\"subtitle\";s:19:\"Domaines d\'activite\";s:5:\"title\";s:37:\"Une couverture complete du cycle BTP.\";s:4:\"text\";s:125:\"<p>Les activites de CITABIC couvrent le genie civil, le batiment, l\'immobilier et les missions de coordination de projet.</p>\";s:5:\"items\";a:3:{i:0;a:3:{s:5:\"title\";s:12:\"Génie civil\";s:5:\"items\";a:6:{i:0;s:24:\"Travaux d\'infrastructure\";i:1;s:3:\"VRD\";i:2;s:11:\"Autoportant\";i:3;s:14:\"Ouvrage d´art\";i:4;s:14:\"Assainissement\";i:5;s:23:\"Renforcement Structures\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";}i:1;a:3:{s:5:\"title\";s:9:\"Bâtiment\";s:5:\"items\";a:6:{i:0;s:26:\"Réalisations clé en main\";i:1;s:21:\"Entreprise générale\";i:2;s:11:\"Gros œuvre\";i:3;s:31:\"Rénovations et transformations\";i:4;s:66:\"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\";i:5;s:8:\"Façades\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";}i:2;a:3:{s:5:\"title\";s:10:\"Immobilier\";s:5:\"items\";a:3:{i:0;s:40:\"Ordonnancement, Pilotage et Coordination\";i:1;s:24:\"Simulations financières\";i:2;s:52:\"Acquisition et développement de projets immobiliers\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";}}}s:3:\"why\";a:4:{s:9:\"image_url\";s:77:\"http://localhost:8000/storage/about/d7e62eac-a664-46de-9833-4028892d3634.webp\";s:8:\"subtitle\";s:21:\"Pourquoi nous choisir\";s:5:\"title\";s:40:\"Où la vision rencontre la construction.\";s:4:\"text\";s:234:\"Expertise BTP certifiée ISO 9001 & 45001. Nos équipes déploient des solutions innovantes et sur-mesure, garantissant sécurité, transparence (ERP) et durabilité pour chacun de vos projets, dans le strict respect de vos exigences.\";}s:6:\"values\";a:4:{s:8:\"subtitle\";s:11:\"Nos valeurs\";s:5:\"title\";s:18:\"Ce que nous defons\";s:4:\"text\";s:0:\"\";s:10:\"empty_text\";s:25:\"Aucune valeur configuree.\";}s:8:\"projects\";a:4:{s:8:\"subtitle\";s:11:\"Nos projets\";s:5:\"title\";s:31:\"Découvrez nos derniers projets\";s:4:\"text\";s:148:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement et la construction de structures destin&eacute;es aux entreprises.</p>\";s:5:\"items\";a:1:{i:0;a:4:{s:4:\"slug\";s:18:\"unite-industrielle\";s:5:\"title\";s:92:\"Construction d’une unité industrielle de production de carrelage décoratif traditionnel.\";s:6:\"client\";s:12:\"PJLP SARL AU\";s:15:\"cover_image_url\";s:77:\"http://localhost:8000/storage/about/d84f913a-f25c-498f-bf89-2ff2cb4f28af.webp\";}}}s:7:\"contact\";a:6:{s:8:\"subtitle\";s:14:\"Contactez-nous\";s:10:\"form_title\";s:28:\"Prendre contact avec CITABIC\";s:17:\"contact_image_url\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:11:\"submit_text\";s:18:\"Envoyer le message\";s:19:\"message_placeholder\";s:13:\"Votre message\";}s:4:\"blog\";a:8:{s:8:\"subtitle\";s:19:\"Actualités et blog\";s:5:\"title\";s:27:\"Découvrez nos perspectives\";s:4:\"text\";s:245:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement&nbsp; et l\'&eacute;dification de structures strat&eacute;giques d&eacute;di&eacute;es &agrave; la performance des entreprises.<br>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\";s:11:\"browse_text\";s:17:\"Voir tout le blog\";s:14:\"read_more_text\";s:13:\"Lire la suite\";s:13:\"min_read_text\";s:14:\"min de lecture\";s:10:\"empty_text\";s:36:\"Aucun article publie pour le moment.\";s:5:\"posts\";a:1:{i:0;a:6:{s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:18:\"published_at_label\";s:14:\"March 27, 2026\";s:12:\"reading_time\";i:0;}}}}',1777256025),('laravel-cache-home_page:fr:v5','a:9:{s:3:\"seo\";a:7:{s:5:\"title\";s:17:\"CITABIC | Accueil\";s:11:\"description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"keywords\";s:44:\"citabic, btp, genie civil, immobilier, maroc\";s:8:\"og_title\";s:17:\"CITABIC | Accueil\";s:14:\"og_description\";s:84:\"CITABIC realise vos projets BTP, genie civil et immobilier avec qualite et securite.\";s:8:\"og_image\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:12:\"twitter_card\";s:19:\"summary_large_image\";}s:4:\"hero\";a:4:{s:8:\"subtitle\";s:29:\"VOTRE VISION, NOTRE EXPERTISE\";s:5:\"title\";s:38:\"Ensemble, nous bâtissons votre avenir\";s:8:\"cta_text\";s:9:\"Decouvrir\";s:11:\"circle_text\";s:37:\"Ensemble, construisons votre avenir !\";}s:5:\"about\";a:7:{s:11:\"image_1_url\";s:77:\"http://localhost:8000/storage/about/8b2b1014-9f28-4a93-bf50-1726d70ac32f.webp\";s:11:\"image_2_url\";s:77:\"http://localhost:8000/storage/about/52a4913b-db46-40dd-8c97-7e14f42aee2f.webp\";s:11:\"image_3_url\";s:77:\"http://localhost:8000/storage/about/9fc67cae-4e9a-4ccc-80fb-f735adcae07b.webp\";s:12:\"rounded_text\";s:37:\"Ensemble, construisons votre avenir !\";s:8:\"subtitle\";s:16:\"A propos de nous\";s:5:\"title\";s:24:\"Présentation de CITABIC\";s:4:\"text\";s:906:\"<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>\";}s:7:\"domains\";a:4:{s:8:\"subtitle\";s:19:\"Domaines d\'activite\";s:5:\"title\";s:37:\"Une couverture complete du cycle BTP.\";s:4:\"text\";s:125:\"<p>Les activites de CITABIC couvrent le genie civil, le batiment, l\'immobilier et les missions de coordination de projet.</p>\";s:5:\"items\";a:3:{i:0;a:3:{s:5:\"title\";s:12:\"Génie civil\";s:5:\"items\";a:6:{i:0;s:24:\"Travaux d\'infrastructure\";i:1;s:3:\"VRD\";i:2;s:11:\"Autoportant\";i:3;s:14:\"Ouvrage d´art\";i:4;s:14:\"Assainissement\";i:5;s:23:\"Renforcement Structures\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png\";}i:1;a:3:{s:5:\"title\";s:9:\"Bâtiment\";s:5:\"items\";a:6:{i:0;s:26:\"Réalisations clé en main\";i:1;s:21:\"Entreprise générale\";i:2;s:11:\"Gros œuvre\";i:3;s:31:\"Rénovations et transformations\";i:4;s:66:\"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\";i:5;s:8:\"Façades\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png\";}i:2;a:3:{s:5:\"title\";s:10:\"Immobilier\";s:5:\"items\";a:3:{i:0;s:40:\"Ordonnancement, Pilotage et Coordination\";i:1;s:24:\"Simulations financières\";i:2;s:52:\"Acquisition et développement de projets immobiliers\";}s:8:\"icon_url\";s:82:\"http://localhost:8000/storage/domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png\";}}}s:3:\"why\";a:4:{s:9:\"image_url\";s:77:\"http://localhost:8000/storage/about/d7e62eac-a664-46de-9833-4028892d3634.webp\";s:8:\"subtitle\";s:21:\"Pourquoi nous choisir\";s:5:\"title\";s:40:\"Où la vision rencontre la construction.\";s:4:\"text\";s:234:\"Expertise BTP certifiée ISO 9001 & 45001. Nos équipes déploient des solutions innovantes et sur-mesure, garantissant sécurité, transparence (ERP) et durabilité pour chacun de vos projets, dans le strict respect de vos exigences.\";}s:6:\"values\";a:4:{s:8:\"subtitle\";s:11:\"Nos valeurs\";s:5:\"title\";s:18:\"Ce que nous defons\";s:4:\"text\";s:0:\"\";s:10:\"empty_text\";s:25:\"Aucune valeur configuree.\";}s:8:\"projects\";a:4:{s:8:\"subtitle\";s:11:\"Nos projets\";s:5:\"title\";s:31:\"Découvrez nos derniers projets\";s:4:\"text\";s:148:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement et la construction de structures destin&eacute;es aux entreprises.</p>\";s:5:\"items\";a:1:{i:0;a:4:{s:4:\"slug\";s:18:\"unite-industrielle\";s:5:\"title\";s:92:\"Construction d’une unité industrielle de production de carrelage décoratif traditionnel.\";s:6:\"client\";s:12:\"PJLP SARL AU\";s:15:\"cover_image_url\";s:77:\"http://localhost:8000/storage/about/d84f913a-f25c-498f-bf89-2ff2cb4f28af.webp\";}}}s:7:\"contact\";a:6:{s:8:\"subtitle\";s:14:\"Contactez-nous\";s:10:\"form_title\";s:28:\"Prendre contact avec CITABIC\";s:17:\"contact_image_url\";s:82:\"http://localhost:8000/storage/contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png\";s:9:\"map_embed\";s:380:\"<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>\";s:11:\"submit_text\";s:18:\"Envoyer le message\";s:19:\"message_placeholder\";s:13:\"Votre message\";}s:4:\"blog\";a:8:{s:8:\"subtitle\";s:19:\"Actualités et blog\";s:5:\"title\";s:27:\"Découvrez nos perspectives\";s:4:\"text\";s:245:\"<p>La construction commerciale englobe la conception, le d&eacute;veloppement&nbsp; et l\'&eacute;dification de structures strat&eacute;giques d&eacute;di&eacute;es &agrave; la performance des entreprises.<br>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>\";s:11:\"browse_text\";s:17:\"Voir tout le blog\";s:14:\"read_more_text\";s:13:\"Lire la suite\";s:13:\"min_read_text\";s:14:\"min de lecture\";s:10:\"empty_text\";s:36:\"Aucun article publie pour le moment.\";s:5:\"posts\";a:1:{i:0;a:6:{s:4:\"slug\";s:54:\"le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030\";s:5:\"title\";s:62:\"Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030\";s:7:\"excerpt\";s:159:\"Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.\";s:9:\"image_url\";s:86:\"http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp\";s:18:\"published_at_label\";s:14:\"March 27, 2026\";s:12:\"reading_time\";i:0;}}}}',1777256036),('laravel-cache-spatie.permission.cache','a:3:{s:5:\"alias\";a:4:{s:1:\"a\";s:2:\"id\";s:1:\"b\";s:4:\"name\";s:1:\"c\";s:10:\"guard_name\";s:1:\"r\";s:5:\"roles\";}s:11:\"permissions\";a:6:{i:0;a:4:{s:1:\"a\";i:1;s:1:\"b\";s:18:\"access admin panel\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:1;a:4:{s:1:\"a\";i:2;s:1:\"b\";s:12:\"manage users\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:2;a:4:{s:1:\"a\";i:3;s:1:\"b\";s:17:\"manage blog posts\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:3;a:4:{s:1:\"a\";i:4;s:1:\"b\";s:20:\"manage blog comments\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:2:{i:0;i:1;i:1;i:2;}}i:4;a:4:{s:1:\"a\";i:5;s:1:\"b\";s:26:\"manage contact submissions\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}i:5;a:4:{s:1:\"a\";i:6;s:1:\"b\";s:18:\"manage cms content\";s:1:\"c\";s:3:\"web\";s:1:\"r\";a:1:{i:0;i:1;}}}s:5:\"roles\";a:2:{i:0;a:3:{s:1:\"a\";i:1;s:1:\"b\";s:5:\"admin\";s:1:\"c\";s:3:\"web\";}i:1;a:3:{s:1:\"a\";i:2;s:1:\"b\";s:11:\"blog editor\";s:1:\"c\";s:3:\"web\";}}}',1774750391);
/*!40000 ALTER TABLE `cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `cache_locks`
--

DROP TABLE IF EXISTS `cache_locks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `cache_locks`
--

LOCK TABLES `cache_locks` WRITE;
/*!40000 ALTER TABLE `cache_locks` DISABLE KEYS */;
/*!40000 ALTER TABLE `cache_locks` ENABLE KEYS */;
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
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `categories_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categories`
--

LOCK TABLES `categories` WRITE;
/*!40000 ALTER TABLE `categories` DISABLE KEYS */;
INSERT INTO `categories` VALUES (2,'News','news','2026-03-26 14:34:39','2026-03-26 14:34:39');
/*!40000 ALTER TABLE `categories` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `category_post`
--

DROP TABLE IF EXISTS `category_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `category_post` (
  `post_id` bigint unsigned NOT NULL,
  `category_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`category_id`),
  KEY `category_post_category_id_foreign` (`category_id`),
  CONSTRAINT `category_post_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  CONSTRAINT `category_post_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `category_post`
--

LOCK TABLES `category_post` WRITE;
/*!40000 ALTER TABLE `category_post` DISABLE KEYS */;
/*!40000 ALTER TABLE `category_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `certifications`
--

DROP TABLE IF EXISTS `certifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `certifications` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'en',
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `certifications_slug_index` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `certifications`
--

LOCK TABLES `certifications` WRITE;
/*!40000 ALTER TABLE `certifications` DISABLE KEYS */;
INSERT INTO `certifications` VALUES (1,'certifie-iso-9001-v-2015','Certifié ISO 9001 V 2015','fr','Système de Management de la Qualité','certifications/VzP1FVLsZWLT5WZZFkP1CS2lnSWiSmsbygwjyrjj.jpg','2026-03-14 21:38:12','2026-03-14 21:46:01'),(2,'certifie-iso-9001-v-2015','ISO 9001 V 2015 certified','en','Quality Management System','certifications/VzP1FVLsZWLT5WZZFkP1CS2lnSWiSmsbygwjyrjj.jpg','2026-03-14 21:38:12','2026-03-14 21:46:01'),(3,'certifie-iso-45001-v-2018','Certifié ISO 45001 V 2018','fr','Système de Management SST','certifications/qe8SZS8GMZ5SZH2ARCu9FPiX1pg9EJGdb7rNvrej.jpg','2026-03-14 21:44:29','2026-03-14 21:44:29'),(4,'certifie-iso-45001-v-2018','Certified ISO 45001 V 2018','en','OHS Management System','certifications/qe8SZS8GMZ5SZH2ARCu9FPiX1pg9EJGdb7rNvrej.jpg','2026-03-14 21:44:29','2026-03-14 21:44:29');
/*!40000 ALTER TABLE `certifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citabic_domains`
--

DROP TABLE IF EXISTS `citabic_domains`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citabic_domains` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `citabic_profile_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` json DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `translations` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citabic_domains_citabic_profile_id_foreign` (`citabic_profile_id`),
  CONSTRAINT `citabic_domains_citabic_profile_id_foreign` FOREIGN KEY (`citabic_profile_id`) REFERENCES `citabic_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citabic_domains`
--

LOCK TABLES `citabic_domains` WRITE;
/*!40000 ALTER TABLE `citabic_domains` DISABLE KEYS */;
INSERT INTO `citabic_domains` VALUES (1,1,'Génie civil','domains/aoAcFNqna3mF4zV5wdUsgU6hS0jAlhHCBEfCGRir.png','[\"Travaux d\'infrastructure\", \"VRD\", \"Autoportant\", \"Ouvrage d´art\", \"Assainissement\", \"Renforcement Structures\"]',0,'{\"en\": {\"items\": [\"Infrastructure works\", \"VRD\", \"Freestanding\", \"Work of art\", \"Sanitation\", \"Reinforcement Structures\"], \"title\": \"CIVIL ENGINEERING\"}}','2026-03-18 02:03:27','2026-03-19 02:23:08'),(2,1,'Bâtiment','domains/j1H1u5dsyiblNqROJodZDKnaiBHga5LuYn4gq4I5.png','[\"Réalisations clé en main\", \"Entreprise générale\", \"Gros œuvre\", \"Rénovations et transformations\", \"Aménagements extérieurs(Dallage Industriel, Béton imprimé …)\", \"Façades\"]',1,'{\"en\": {\"items\": [\"Turnkey solutions\", \"General contractor\", \"Structural work\", \"Renovations and transformations\", \"Exterior landscaping (Industrial paving, Stamped concrete…)\", \"Facades\"], \"title\": \"Building\"}}','2026-03-19 02:35:21','2026-03-19 02:35:21'),(3,1,'Immobilier','domains/rC2CNdB4C50jDCsCPhAvWqGv3qcS6EiRFotfR8eA.png','[\"Ordonnancement, Pilotage et Coordination\", \"Simulations financières\", \"Acquisition et développement de projets immobiliers\"]',2,'{\"en\": {\"items\": [\"Scheduling, Management and Coordination\", \"Financial simulations\", \"Acquisition and development of real estate projects\"], \"title\": \"Real estate\"}}','2026-03-19 02:38:51','2026-03-19 02:38:51');
/*!40000 ALTER TABLE `citabic_domains` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citabic_figures`
--

DROP TABLE IF EXISTS `citabic_figures`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citabic_figures` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `citabic_profile_id` bigint unsigned NOT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `translations` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citabic_figures_citabic_profile_id_foreign` (`citabic_profile_id`),
  CONSTRAINT `citabic_figures_citabic_profile_id_foreign` FOREIGN KEY (`citabic_profile_id`) REFERENCES `citabic_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citabic_figures`
--

LOCK TABLES `citabic_figures` WRITE;
/*!40000 ALTER TABLE `citabic_figures` DISABLE KEYS */;
INSERT INTO `citabic_figures` VALUES (1,1,'CA cumulé','65M+',0,'{\"en\": {\"label\": \"CA cumulé\"}}','2026-03-17 16:40:16','2026-03-28 02:13:55'),(2,1,'Total de personnel embauché','1000+',2,'{\"en\": {\"label\": \"Total de personnel embauché\"}}','2026-03-17 16:40:44','2026-03-17 18:36:04'),(3,1,'Superficie totale construite','250km²+',1,'{\"en\": {\"label\": \"Superficie totale construite\"}}','2026-03-17 16:41:26','2026-03-17 18:35:41'),(4,1,'Respect des délais','92 % des projets',3,'{\"en\": {\"label\": \"Respect des délais\"}}','2026-03-17 16:41:44','2026-03-17 18:36:30'),(5,1,'Conformité aux normes','100 %',4,'{\"en\": {\"label\": \"Conformité aux normes\"}}','2026-03-17 16:42:04','2026-03-17 20:05:07'),(6,1,'Fournisseurs de confiance','50+',5,'{\"en\": {\"label\": \"Fournisseurs de confiance\"}}','2026-03-17 16:42:23','2026-03-19 02:45:38'),(7,1,'Équipe dédiée','70+',6,'{\"en\": {\"label\": \"Dedicated team\"}}','2026-03-19 02:45:08','2026-03-19 02:45:42');
/*!40000 ALTER TABLE `citabic_figures` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citabic_infos`
--

DROP TABLE IF EXISTS `citabic_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citabic_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `citabic_profile_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `translations` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citabic_infos_citabic_profile_id_foreign` (`citabic_profile_id`),
  CONSTRAINT `citabic_infos_citabic_profile_id_foreign` FOREIGN KEY (`citabic_profile_id`) REFERENCES `citabic_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citabic_infos`
--

LOCK TABLES `citabic_infos` WRITE;
/*!40000 ALTER TABLE `citabic_infos` DISABLE KEYS */;
INSERT INTO `citabic_infos` VALUES (162,1,'intro','CITABIC is a company whose core business is construction and public works. Responsiveness, experience and dynamism define the way it supports clients across their projects.',0,'{\"en\": \"CITABIC is a company whose core business is construction and public works. Responsiveness, experience and dynamism define the way it supports clients across their projects.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(163,1,'intro','Founded in 2021, CITABIC brings a new construction concept to the Moroccan market through a turnkey offer covering construction, renovation, civil engineering and consulting.',1,'{\"en\": \"Founded in 2021, CITABIC brings a new construction concept to the Moroccan market through a turnkey offer covering construction, renovation, civil engineering and consulting.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(164,1,'intro','The company relies on experienced building professionals to deliver quality services with peace of mind, strong execution discipline, and high standards for deadlines, safety and long-term durability.',2,'{\"en\": \"The company relies on experienced building professionals to deliver quality services with peace of mind, strong execution discipline, and high standards for deadlines, safety and long-term durability.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(165,1,'market_context','',0,'{\"en\": \"Economic growth and urbanization continue to drive demand for modern infrastructure and quality housing in Morocco.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(166,1,'market_context','',1,'{\"en\": \"Environmental standards and social expectations require sustainable construction solutions.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(167,1,'market_context','',2,'{\"en\": \"Projects must comply with international quality and safety standards to ensure long-term asset value.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(168,1,'market_context','',3,'{\"en\": \"Cost and schedule control remains essential in a highly competitive market.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(169,1,'market_context','',4,'{\"en\": \"Advanced tools such as BIM and ERP systems are becoming critical for accuracy, transparency and delivery efficiency.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(170,1,'mission','Fournir des services de construction de haute qualité et un accompagnement intégré garantissant la pleine satisfaction des clients.',0,'{\"en\": \"Deliver high-quality construction services and integrated support that fully satisfy clients.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(171,1,'mission','Offrir une expertise et des systèmes de gestion conformes aux normes internationales à tous les niveaux de l\'organisation.',1,'{\"en\": \"Provide expertise and management systems aligned with international standards across every level of the organization.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(172,1,'mission','Proposer une gamme d\'activités standardisées et systématiques pour un modèle de réalisation clé en main.',2,'{\"en\": \"Offer a standardized and systematic range of activities for a turnkey delivery model.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(173,1,'mission','Garantir une gestion de projet rigoureuse et une pérennité optimale des projets.',3,'{\"en\": \"Guarantee strong project management quality and long-lasting project durability.\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(174,1,'certifications','',0,'{\"en\": \"ISO 9001:2015 - Quality management system\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(175,1,'certifications','',1,'{\"en\": \"ISO 45001:2018 - Occupational health and safety management system\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(176,1,'partnerships','',0,'{\"en\": \"5 renowned partner architects\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(177,1,'partnerships','',1,'{\"en\": \"5 specialized technical design offices\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(178,1,'partnerships','',2,'{\"en\": \"4 certified laboratories for analysis and quality testing\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(179,1,'compliance','',0,'{\"en\": \"Regulatory inspections for equipment including tower cranes and telescopic handlers\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(180,1,'compliance','',1,'{\"en\": \"Forklift operator training certification\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(181,1,'compliance','',2,'{\"en\": \"Calibration of equipment such as leveling devices and measuring tools\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(182,1,'compliance','',3,'{\"en\": \"All-risk construction insurance, CNSS declarations, workplace accident coverage and civil liability insurance\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(183,1,'compliance','',4,'{\"en\": \"Tax and CNSS regularity certificates, including 1007 and 1220 attestations\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(184,1,'organization','',0,'{\"en\": \"General management and strategic development\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(185,1,'organization','',1,'{\"en\": \"QHS, logistics, purchasing, transport and maintenance\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(186,1,'organization','',2,'{\"en\": \"Operations, studies/quantity surveying, site execution and control\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(187,1,'organization','',3,'{\"en\": \"Administrative and financial management, HR and finance\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(188,1,'organization','',4,'{\"en\": \"Business development and partner coordination\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(189,1,'why_choose_us','',0,'{\"en\": \"Comprehensive construction expertise\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(190,1,'why_choose_us','',1,'{\"en\": \"Commitment to quality and safety\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(191,1,'why_choose_us','',2,'{\"en\": \"Tailored and innovative solutions\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(192,1,'why_choose_us','',3,'{\"en\": \"Experienced professional team\"}','2026-03-15 12:24:38','2026-03-15 12:24:38'),(193,1,'why_choose_us','',4,'{\"en\": \"Advanced infrastructure and technology\"}','2026-03-15 12:24:38','2026-03-15 12:24:38');
/*!40000 ALTER TABLE `citabic_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citabic_processes`
--

DROP TABLE IF EXISTS `citabic_processes`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citabic_processes` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `citabic_profile_id` bigint unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `sort_order` int NOT NULL DEFAULT '0',
  `translations` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citabic_processes_citabic_profile_id_foreign` (`citabic_profile_id`),
  CONSTRAINT `citabic_processes_citabic_profile_id_foreign` FOREIGN KEY (`citabic_profile_id`) REFERENCES `citabic_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citabic_processes`
--

LOCK TABLES `citabic_processes` WRITE;
/*!40000 ALTER TABLE `citabic_processes` DISABLE KEYS */;
INSERT INTO `citabic_processes` VALUES (1,1,'Management des risques','Satisfaire les clients par des prestations BTP et des services integres de haute qualite.',0,NULL,'2026-03-14 14:12:44','2026-03-14 14:12:44'),(2,1,'Direction','Mettre a disposition une expertise et des systemes de management aligns sur les standards internationaux.',1,NULL,'2026-03-14 14:12:44','2026-03-14 14:12:44'),(3,1,'Gestion de chantiers','Offrir une gamme d’activites standardisee et systematique pour une logique cle en main.',2,NULL,'2026-03-14 14:12:44','2026-03-14 14:12:44'),(4,1,'Gestion des ressources humaines','Garantir une qualite de gestion optimale et la durabilite des realisations.',3,NULL,'2026-03-14 14:12:44','2026-03-14 14:12:44'),(5,1,'Gestion des ressources materielles',NULL,4,NULL,'2026-03-14 14:12:44','2026-03-14 14:12:44'),(6,1,'Gestion de performance et amelioration',NULL,5,NULL,'2026-03-14 14:12:44','2026-03-14 14:12:44');
/*!40000 ALTER TABLE `citabic_processes` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citabic_profiles`
--

DROP TABLE IF EXISTS `citabic_profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citabic_profiles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tagline` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legal_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `legal_form` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `capital` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `head_office` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `ice` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `company_created_at` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `rc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hero_video_path` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `information_system` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `translations` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citabic_profiles`
--

LOCK TABLES `citabic_profiles` WRITE;
/*!40000 ALTER TABLE `citabic_profiles` DISABLE KEYS */;
INSERT INTO `citabic_profiles` VALUES (1,'CITABIC','Ensemble, construisons votre avenir !','Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil','CITABIC','SARL a associe unique','100 000 MAD','26 Rue Andaloussie, Office Building Anatolia Etage 6 N17, Tanger','002789168000063','18/04/2021','115445','En activite','+212 611-808226','b.benkaddour@citabic.com','guest/assets/video/citabic-hero.mp4','CITABIC a implemente une infrastructure informatique de pointe avec l’ERP Odoo pour optimiser la disponibilite, la confidentialite et l’integrite des donnees. Cette architecture traduit sa maturite organisationnelle et sa rigueur professionnelle.','{\"en\": {\"intro\": \"CITABIC is a company whose core business is construction and public works. Responsiveness, experience and dynamism define the way it supports clients across their projects.\\r\\nFounded in 2021, CITABIC brings a new construction concept to the Moroccan market through a turnkey offer covering construction, renovation, civil engineering and consulting.\\r\\nThe company relies on experienced building professionals to deliver quality services with peace of mind, strong execution discipline, and high standards for deadlines, safety and long-term durability.\", \"mission\": \"Deliver high-quality construction services and integrated support that fully satisfy clients.\\r\\nProvide expertise and management systems aligned with international standards across every level of the organization.\\r\\nOffer a standardized and systematic range of activities for a turnkey delivery model.\\r\\nGuarantee strong project management quality and long-lasting project durability.\", \"tagline\": \"Together we build your future!\", \"compliance\": \"Regulatory inspections for equipment including tower cranes and telescopic handlers\\r\\nForklift operator training certification\\r\\nCalibration of equipment such as leveling devices and measuring tools\\r\\nAll-risk construction insurance, CNSS declarations, workplace accident coverage and civil liability insurance\\r\\nTax and CNSS regularity certificates, including 1007 and 1220 attestations\", \"organization\": \"General management and strategic development\\r\\nQHS, logistics, purchasing, transport and maintenance\\r\\nOperations, studies/quantity surveying, site execution and control\\r\\nAdministrative and financial management, HR and finance\\r\\nBusiness development and partner coordination\", \"partnerships\": \"5 renowned partner architects\\r\\n5 specialized technical design offices\\r\\n4 certified laboratories for analysis and quality testing\", \"why_choose_us\": \"Comprehensive construction expertise\\r\\nCommitment to quality and safety\\r\\nTailored and innovative solutions\\r\\nExperienced professional team\\r\\nAdvanced infrastructure and technology\", \"certifications\": \"ISO 9001:2015 - Quality management system\\r\\nISO 45001:2018 - Occupational health and safety management system\", \"market_context\": \"Economic growth and urbanization continue to drive demand for modern infrastructure and quality housing in Morocco.\\r\\nEnvironmental standards and social expectations require sustainable construction solutions.\\r\\nProjects must comply with international quality and safety standards to ensure long-term asset value.\\r\\nCost and schedule control remains essential in a highly competitive market.\\r\\nAdvanced tools such as BIM and ERP systems are becoming critical for accuracy, transparency and delivery efficiency.\", \"information_system\": \"CITABIC has implemented a robust IT infrastructure powered by Odoo ERP to improve data availability, confidentiality and integrity. This architecture reflects organizational maturity and strong operational discipline.\"}}','2026-03-14 02:38:02','2026-03-15 12:24:38');
/*!40000 ALTER TABLE `citabic_profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citabic_references`
--

DROP TABLE IF EXISTS `citabic_references`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citabic_references` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `client` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `summary` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `surface` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `budget` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `items` json NOT NULL,
  `blocks` json DEFAULT NULL,
  `videos` json DEFAULT NULL,
  `translations` json DEFAULT NULL,
  `sort_order` int unsigned NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `citabic_references_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citabic_references`
--

LOCK TABLES `citabic_references` WRITE;
/*!40000 ALTER TABLE `citabic_references` DISABLE KEYS */;
INSERT INTO `citabic_references` VALUES (6,'unite-industrielle','Construction d’une unité industrielle de production de carrelage décoratif traditionnel.','PJLP SARL AU','/storage/about/46c5c3eb-428e-4798-a5fe-dfe062e237e9.webp','<p>PJLP SARL AU est une entreprise sp&eacute;cialis&eacute;e dans la production, la fabrication et la commercialisation de<br>carrelages d&eacute;coratifs sous diverses formes et mat&eacute;riaux. Fond&eacute;e par le cr&eacute;ateur de MOSAIC Factory, elle<br>fait partie d\'un groupe industriel &eacute;tabli en 2002 &agrave; Tanger, qui se consacre &agrave; la fabrication de carreaux, de<br>dalles et d\'&eacute;l&eacute;ments d\'ameublement en mati&egrave;res min&eacute;rales.</p>','<p>PJLP SARL AU est une entreprise sp&eacute;cialis&eacute;e dans la production, la fabrication et la commercialisation de<br>carrelages d&eacute;coratifs sous diverses formes et mat&eacute;riaux. Fond&eacute;e par le cr&eacute;ateur de MOSAIC Factory, elle<br>fait partie d\'un groupe industriel &eacute;tabli en 2002 &agrave; Tanger, qui se consacre &agrave; la fabrication de carreaux, de<br>dalles et d\'&eacute;l&eacute;ments d\'ameublement en mati&egrave;res min&eacute;rales.</p>','6.750 m²','25 000 000,00 DH','[]','[{\"type\": \"coverImage\", \"content\": \"/storage/about/d84f913a-f25c-498f-bf89-2ff2cb4f28af.webp\"}, {\"type\": \"heroImage\", \"content\": \"/storage/about/46c5c3eb-428e-4798-a5fe-dfe062e237e9.webp\"}, {\"type\": \"heading\", \"content\": \"Construction d’une unité industrielle de production de carrelage décoratif traditionnel.\", \"content_en\": \"Construction of an industrial unit for the production of traditional decorative tiles.\"}, {\"type\": \"text\", \"content\": \"<p>PJLP SARL AU est une entreprise sp&eacute;cialis&eacute;e dans la production, la fabrication et la commercialisation de<br>carrelages d&eacute;coratifs sous diverses formes et mat&eacute;riaux. Fond&eacute;e par le cr&eacute;ateur de MOSAIC Factory, elle<br>fait partie d\'un groupe industriel &eacute;tabli en 2002 &agrave; Tanger, qui se consacre &agrave; la fabrication de carreaux, de<br>dalles et d\'&eacute;l&eacute;ments d\'ameublement en mati&egrave;res min&eacute;rales.</p>\", \"content_en\": \"<p>PJLP SARL AU is a company specializing in the production, manufacturing, and marketing of decorative tiles in various shapes and materials. Founded by the creator of MOSAIC Factory, it is part of an industrial group established in 2002 in Tangier, dedicated to the manufacture of tiles, slabs, and furniture elements made from mineral materials.</p>\"}, {\"type\": \"subheading\", \"content\": \"Réalisations\", \"content_en\": \"Achievements\"}, {\"type\": \"list\", \"content\": \"Réalisation G.O une couverture autoportante avec une portée de 36 M\\nRéalisation G.O des planchers en béton précontraint DalleAlvéolées D.A.S ( 12*1,2)\\nRéalisation d’une structure en charpente métallique classique\\nRéalisation G.O des planchers en Hourdis-Poutrelle Jumelée\\nRéalisation des travaux Second d’œuvre (T.C.E)\\nRéalisation des travaux Dallage industrielle, aménagement extérieur, Travaux\\nd’étanchéité, Réseau sous dallage d’assainissement, prestations diverses\", \"content_en\": \"Construction of a self-supporting roof with a span of 36 meters.\\nConstruction of prestressed concrete floors using hollow-core slabs (12 x 1.2 m).\\nConstruction of a conventional steel frame structure.\\nConstruction of hollow-core slab floors using twin beams.\\nExecution of finishing work (all trades).\\nExecution of industrial flooring, landscaping, waterproofing, under-slab drainage network, and other services.\"}, {\"type\": \"gallery\", \"images\": [\"/storage/about/e03e1796-1037-4261-9027-54e7d589a99e.webp\", \"/storage/about/64343865-5e7c-4162-89e6-c528c23751f8.webp\"]}]',NULL,'{\"en\": []}',6,'2026-03-22 19:58:12','2026-03-23 02:02:52');
/*!40000 ALTER TABLE `citabic_references` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `citabic_values`
--

DROP TABLE IF EXISTS `citabic_values`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `citabic_values` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `citabic_profile_id` bigint unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci,
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `sort_order` int NOT NULL DEFAULT '0',
  `translations` json DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `citabic_values_citabic_profile_id_foreign` (`citabic_profile_id`),
  CONSTRAINT `citabic_values_citabic_profile_id_foreign` FOREIGN KEY (`citabic_profile_id`) REFERENCES `citabic_profiles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `citabic_values`
--

LOCK TABLES `citabic_values` WRITE;
/*!40000 ALTER TABLE `citabic_values` DISABLE KEYS */;
INSERT INTO `citabic_values` VALUES (1,1,'values','Engagement','<p>Nous favorisons une culture o&ugrave; nous faisons ce que nous&nbsp;disons et nous respectons nos engagements envers nos&nbsp;clients, nos communaut&eacute;s et entre nous</p>','values/433ded46-dfd4-446c-b24a-48a3354545c6.webp',0,'{\"en\": {\"text\": \"<p>We foster a culture where we do what we say and respect our commitments to our customers, our communities, and each other.</p>\", \"title\": \"Commitment\"}}','2026-03-14 17:55:37','2026-03-26 01:44:40'),(2,1,'values','Qualité','<p>&Agrave; chaque &eacute;tape de votre chantier, CITABIC s\'assure de la qualit&eacute; du travail qui a &eacute;t&eacute; r&eacute;alis&eacute; par nos corps de m&eacute;tiers exp&eacute;riment&eacute;s</p>','values/4a25dd56-c738-4a79-b0fc-1c95af88607f.webp',0,'{\"en\": {\"text\": \"<p>At each stage of your project, CITABIC ensures the quality of the work carried out by our experienced tradespeople.</p>\", \"title\": \"Quality\"}}','2026-03-26 00:03:21','2026-03-26 01:44:48'),(3,1,'values','Innovation','<p>Nous estimons que chaque situation est diff&eacute;rente et&nbsp;appelle, en cons&eacute;quence, des solutions adapt&eacute;es. Nous&nbsp;mettons donc tout en &oelig;uvre afin d&rsquo;offrir &agrave; nos clients les&nbsp;solutions op&eacute;rationnelles les plus innovantes</p>','values/ffbc7bad-77a6-4361-baf5-1b0f4759de90.webp',0,'{\"en\": {\"text\": \"<p>We believe that every situation is different and&nbsp;therefore requires tailored solutions. We&nbsp;make every effort to offer our clients the most innovative operational solutions.</p>\", \"title\": \"Innovation\"}}','2026-03-26 00:04:33','2026-03-26 01:45:09'),(4,1,'values','Éthique','<p>Le respect de l&rsquo;&eacute;thique est la fondation de nos activit&eacute;s. Tout ce que nous faisons est guid&eacute; par une vis&eacute;e morale qui garantit l&rsquo;&eacute;quit&eacute;, le respect et une totale transparence &agrave; toutes les parties prenantes</p>','values/ca7b6ccd-c891-4f78-ad8a-acac9a24615a.webp',0,'{\"en\": {\"text\": \"<p>Respect for ethics is the foundation of our activities. Everything we do is guided by a moral compass that guarantees fairness, respect, and complete transparency for all stakeholders.</p>\", \"title\": \"Ethics\"}}','2026-03-26 00:06:18','2026-03-26 01:47:03'),(5,1,'values','Sécurité','<p>Conscients des enjeux humains et &eacute;conomiques li&eacute;s &agrave; la s&eacute;curit&eacute;, nous respectons les principes fondamentaux de la pr&eacute;vention sur nos chantiers.</p>','values/8617b72c-517d-4c7a-87fc-ddc24d9ed10e.webp',0,'{\"en\": {\"text\": \"<p>Aware of the human and economic stakes linked to safety, we respect the fundamental principles of prevention on our construction sites.</p>\", \"title\": \"Security\"}}','2026-03-26 00:07:38','2026-03-26 01:45:39'),(6,1,'values','Intégrité','<p>Nos activit&eacute;s et nos relations professionnelles reposent sur la confiance, l&rsquo;honn&ecirc;tet&eacute; et l&rsquo;ouverture. Nous tenons nos promesses et mettons toujours tout en &oelig;uvre pour agir correctement.&nbsp;</p>','values/0ceb5373-f339-4817-b8c8-937bf5ab2de3.webp',0,'{\"en\": {\"text\": \"<p>Our business activities and professional relationships are based on trust, honesty, and openness. We keep our promises and always do our utmost to act correctly.</p>\", \"title\": \"Integrity\"}}','2026-03-26 00:08:45','2026-03-26 01:45:48');
/*!40000 ALTER TABLE `citabic_values` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `company_infos`
--

DROP TABLE IF EXISTS `company_infos`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `company_infos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci,
  `lang` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `company_infos`
--

LOCK TABLES `company_infos` WRITE;
/*!40000 ALTER TABLE `company_infos` DISABLE KEYS */;
INSERT INTO `company_infos` VALUES (1,'creation_date','04/16/2021','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(2,'full_name','Compagnie Internationale Amenagement Travaux - Batiment Immobilier - Conseil','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(3,'legal_name','CITABIC','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(4,'status','active','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(5,'legal_form','SARL a associe unique','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(6,'capital','100000','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(7,'address','Office Building Anatolia Etage 6 N 17 Tanger','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(8,'phone','+212 600 95 33 53','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(9,'email','zaidsmd111@gmail.com','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(10,'rc','115445','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(11,'ice','002789168000063','fr','2026-03-17 16:36:20','2026-03-17 16:36:20'),(12,'linkedin','https://www.linkedin.com/feed/','fr','2026-03-27 01:41:31','2026-03-27 01:41:31'),(13,'instagram',NULL,'fr','2026-03-27 01:41:55','2026-03-27 01:43:54'),(14,'facebook',NULL,'fr','2026-03-27 01:41:55','2026-03-27 01:43:51');
/*!40000 ALTER TABLE `company_infos` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contact_submissions`
--

DROP TABLE IF EXISTS `contact_submissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contact_submissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `subject` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `number` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `message` text COLLATE utf8mb4_unicode_ci,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contact_submissions`
--

LOCK TABLES `contact_submissions` WRITE;
/*!40000 ALTER TABLE `contact_submissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `contact_submissions` ENABLE KEYS */;
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
-- Table structure for table `job_batches`
--

DROP TABLE IF EXISTS `job_batches`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `job_batches`
--

LOCK TABLES `job_batches` WRITE;
/*!40000 ALTER TABLE `job_batches` DISABLE KEYS */;
/*!40000 ALTER TABLE `job_batches` ENABLE KEYS */;
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
  KEY `jobs_queue_reserved_at_available_at_index` (`queue`,`reserved_at`,`available_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'0001_01_01_000000_create_users_table',1),(2,'0001_01_01_000001_create_cache_table',1),(3,'0001_01_01_000002_create_jobs_table',1),(4,'2026_03_13_150000_create_citabic_profiles_table',1),(5,'2026_03_13_150100_create_citabic_references_table',1),(6,'2026_03_13_160000_add_translations_to_citabic_tables',1),(7,'2026_03_13_170000_add_hero_video_path_to_citabic_profiles_table',1),(8,'2026_03_14_090000_add_is_admin_to_users_table',1),(9,'2026_03_14_141209_create_citabic_processes_table',2),(10,'2026_03_14_141238_migrate_citabic_processes_data',3),(11,'2026_03_14_141442_remove_processes_from_citabic_profiles_table',4),(12,'2026_03_14_143754_create_citabic_domains_table',5),(13,'2026_03_14_143754_create_citabic_figures_table',5),(14,'2026_03_14_143754_create_citabic_infos_table',5),(15,'2026_03_14_143754_create_citabic_values_table',5),(16,'2026_03_14_143823_migrate_citabic_profile_json_data',5),(17,'2026_03_14_143832_remove_json_columns_from_citabic_profiles_table',5),(18,'2026_03_14_155229_create_citabic_blog_posts_table',6),(19,'2026_03_14_155902_create_categories_table',7),(20,'2026_03_14_155902_create_tags_table',7),(21,'2026_03_14_155903_create_posts_table',8),(22,'2026_03_14_155904_create_category_post_table',9),(23,'2026_03_14_155904_create_post_tag_table',9),(24,'2026_03_14_160407_update_posts_table_and_cleanup_blog',10),(25,'2026_03_14_180209_create_certifications_table',11),(27,'2026_03_15_123732_create_company_infos_table',12),(28,'2026_03_16_181931_create_section_contents_table',13),(29,'2026_03_16_200000_create_approach_items_table',14),(30,'2026_03_16_200100_create_approach_item_translations_table',14),(31,'2026_03_18_233115_add_icon_to_citabic_domains_table',15),(32,'2026_03_19_033152_create_missions_table',16),(33,'2026_03_19_033153_create_mission_translations_table',17),(34,'2026_03_22_184700_add_blocks_to_citabic_references_table',18),(35,'2026_03_24_222850_add_blocks_to_posts_table',19),(36,'2026_03_25_160750_create_app_settings_table',20),(37,'2026_03_25_164623_add_advanced_seo_fields_to_posts_table',21),(38,'2026_03_25_221344_create_post_comments_table',22),(39,'2026_03_26_001002_add_image_to_citabic_values_table',23),(40,'2026_03_27_014334_change_value_column_in_company_infos_table',24),(41,'2026_03_27_162126_create_contact_submissions_table',25),(42,'2026_03_28_003222_create_notifications_table',26),(43,'2026_03_28_010822_create_permission_tables',27),(44,'2026_03_28_011035_seed_default_roles_and_permissions',27),(45,'2026_10_31_160000_ensure_multilingual_and_media_columns',28);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `mission_translations`
--

DROP TABLE IF EXISTS `mission_translations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `mission_translations` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `mission_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mission_translations_mission_id_locale_unique` (`mission_id`,`locale`),
  CONSTRAINT `mission_translations_mission_id_foreign` FOREIGN KEY (`mission_id`) REFERENCES `missions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `mission_translations`
--

LOCK TABLES `mission_translations` WRITE;
/*!40000 ALTER TABLE `mission_translations` DISABLE KEYS */;
INSERT INTO `mission_translations` VALUES (1,'Excellence Opérationnelle','Garantir la satisfaction de nos clients par des prestations BTP de haute qualité et des services intégrés sur mesure.','fr',1,'2026-03-19 03:35:31','2026-03-19 03:35:31'),(2,'Operational Excellence','Ensuring client satisfaction through high-quality construction and tailored integrated services.','en',1,'2026-03-19 03:35:31','2026-03-19 03:35:31'),(3,'Standards Internationaux','Une expertise certifiée et un management rigoureux appliqué à tous les niveaux de notre organisation.','fr',2,'2026-03-19 03:35:31','2026-03-19 03:35:31'),(4,'International Standards','Certified expertise and rigorous management systems applied across all levels of our organization.','en',2,'2026-03-19 03:35:31','2026-03-19 03:35:31'),(5,'Offre Clé-en-Main','Une gamme complète d\'activités (génie civil, façades, travaux divers) offrant une synergie optimale pour vos projets.','fr',3,'2026-03-19 03:35:31','2026-03-19 03:35:31'),(6,'Turnkey Solutions','A comprehensive range of activities (civil engineering, facades, various works) providing optimal synergy for your projects.','en',3,'2026-03-19 03:35:31','2026-03-19 03:35:31'),(7,'Gestion & Durabilité','Une gestion de projet optimale assurant la pérennité et la solidité de toutes nos réalisations.','fr',4,'2026-03-19 03:35:31','2026-03-19 03:35:31'),(8,'Management & Durability','Optimal project management ensuring the longevity and structural integrity of every realization.','en',4,'2026-03-19 03:35:31','2026-03-19 03:35:31');
/*!40000 ALTER TABLE `mission_translations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `missions`
--

DROP TABLE IF EXISTS `missions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `missions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `background_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `icon` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `order` int NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `missions`
--

LOCK TABLES `missions` WRITE;
/*!40000 ALTER TABLE `missions` DISABLE KEYS */;
INSERT INTO `missions` VALUES (1,NULL,'missions/1y05FL3uOpPisxGpWkaPNzRbyeao3yALKeECWwFT.png',1,'2026-03-19 03:35:31','2026-03-19 20:10:09'),(2,NULL,'missions/ZJtuAJ1wS1TdAYVtDgYWdIXK4lFUeuiprWe9noBq.png',2,'2026-03-19 03:35:31','2026-03-19 20:12:58'),(3,'missions/e2E5cNqiLZdH3vXvRgkfw62ihPsoArfp1jCMHFEm.jpg','missions/iH19hGAvP2QmSwxduTFxxtOmvs67ujTlmz58i82B.png',3,'2026-03-19 03:35:31','2026-03-19 20:14:43'),(4,NULL,'missions/bLZkZkONJnLL6JlJw7AviPzO5yj1XETeShZG5emc.png',4,'2026-03-19 03:35:31','2026-03-19 20:17:40');
/*!40000 ALTER TABLE `missions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_permissions`
--

DROP TABLE IF EXISTS `model_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_permissions`
--

LOCK TABLES `model_has_permissions` WRITE;
/*!40000 ALTER TABLE `model_has_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `model_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `model_has_roles`
--

DROP TABLE IF EXISTS `model_has_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `model_has_roles` (
  `role_id` bigint unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `model_has_roles`
--

LOCK TABLES `model_has_roles` WRITE;
/*!40000 ALTER TABLE `model_has_roles` DISABLE KEYS */;
INSERT INTO `model_has_roles` VALUES (1,'App\\Models\\User',1);
/*!40000 ALTER TABLE `model_has_roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `notifications`
--

DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `notifications`
--

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `password_reset_tokens`
--

DROP TABLE IF EXISTS `password_reset_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
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
-- Table structure for table `permissions`
--

DROP TABLE IF EXISTS `permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `permissions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `permissions`
--

LOCK TABLES `permissions` WRITE;
/*!40000 ALTER TABLE `permissions` DISABLE KEYS */;
INSERT INTO `permissions` VALUES (1,'access admin panel','web','2026-03-28 01:11:51','2026-03-28 01:11:51'),(2,'manage users','web','2026-03-28 01:11:51','2026-03-28 01:11:51'),(3,'manage blog posts','web','2026-03-28 01:11:51','2026-03-28 01:11:51'),(4,'manage blog comments','web','2026-03-28 01:11:51','2026-03-28 01:11:51'),(5,'manage contact submissions','web','2026-03-28 01:11:51','2026-03-28 01:11:51'),(6,'manage cms content','web','2026-03-28 01:11:51','2026-03-28 01:11:51');
/*!40000 ALTER TABLE `permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_comments`
--

DROP TABLE IF EXISTS `post_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_comments` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_approved` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `post_comments_post_id_foreign` (`post_id`),
  CONSTRAINT `post_comments_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_comments`
--

LOCK TABLES `post_comments` WRITE;
/*!40000 ALTER TABLE `post_comments` DISABLE KEYS */;
INSERT INTO `post_comments` VALUES (1,2,'Zaid samadi','zaidsmd111@gmail.com','testsdfsdf',1,'2026-03-25 22:59:27','2026-03-25 22:59:27');
/*!40000 ALTER TABLE `post_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `post_tag`
--

DROP TABLE IF EXISTS `post_tag`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `post_tag` (
  `post_id` bigint unsigned NOT NULL,
  `tag_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`post_id`,`tag_id`),
  KEY `post_tag_tag_id_foreign` (`tag_id`),
  CONSTRAINT `post_tag_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `post_tag_tag_id_foreign` FOREIGN KEY (`tag_id`) REFERENCES `tags` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `post_tag`
--

LOCK TABLES `post_tag` WRITE;
/*!40000 ALTER TABLE `post_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `post_tag` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `posts` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `excerpt` text COLLATE utf8mb4_unicode_ci,
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `featured_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `status` enum('draft','published','archived') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'draft',
  `published_at` timestamp NULL DEFAULT NULL,
  `reading_time` int DEFAULT NULL,
  `views` int NOT NULL DEFAULT '0',
  `featured` tinyint(1) NOT NULL DEFAULT '0',
  `allow_comments` tinyint(1) NOT NULL DEFAULT '1',
  `meta_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_description` text COLLATE utf8mb4_unicode_ci,
  `meta_keywords` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `focus_keyword` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `canonical_url` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `og_description` text COLLATE utf8mb4_unicode_ci,
  `og_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_description` text COLLATE utf8mb4_unicode_ci,
  `twitter_image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `twitter_card` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'summary_large_image',
  `robots_index` tinyint(1) NOT NULL DEFAULT '1',
  `robots_follow` tinyint(1) NOT NULL DEFAULT '1',
  `schema_type` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `schema_json` longtext COLLATE utf8mb4_unicode_ci,
  `translations` json DEFAULT NULL,
  `blocks` json DEFAULT NULL,
  `author_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `posts_slug_unique` (`slug`),
  KEY `posts_author_id_foreign` (`author_id`),
  CONSTRAINT `posts_author_id_foreign` FOREIGN KEY (`author_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
INSERT INTO `posts` VALUES (1,'7 new movies and TV shows to watch on Netflix, Prime Video, HBO Max, and more this weekend (March 13)','test-post',NULL,'<p>This is a test content with some words to check reading time.</p>',NULL,'published','2026-03-14 16:01:00',1,1,0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'summary_large_image',1,1,NULL,NULL,'{\"en\": {\"title\": \"7 new movies and TV shows to watch on Netflix, Prime Video, HBO Max, and more this weekend (March 13)\", \"content\": \"<div id=\\\"hero\\\" class=\\\"clear-both widget widget-hero widget-hero widget-hero-hero widget-hero widget-hero-fter-news\\\" data-widget-type=\\\"hero\\\">\\r\\n<div class=\\\"news-article\\\"><header data-component-name=\\\"Article:Hero\\\">\\r\\n<aside id=\\\"affiliate-disclaimer\\\" class=\\\"mx-auto mb-4 flex items-center justify-start mx-0 my-5 p-0\\\" data-component-name=\\\"AffiliateDisclaimer\\\">\\r\\n<p class=\\\"text-700 mb-2 text-[12px] leading-[18px] md:text-[13px] [&amp;&gt;a]:text-gray-700 [&amp;&gt;a]:underline\\\">When you purchase through links on our site, we may earn an affiliate commission.&nbsp;<a href=\\\"https://www.techradar.com/news/about-us#section-affiliate-advertising-disclosure\\\" data-before-rewrite-localise=\\\"https://www.techradar.com/uk/news/about-us#section-affiliate-advertising-disclosure\\\">Here&rsquo;s how it works</a>.</p>\\r\\n<p class=\\\"text-700 mb-2 text-[12px] leading-[18px] md:text-[13px] [&amp;&gt;a]:text-gray-700 [&amp;&gt;a]:underline\\\">&nbsp;</p>\\r\\n<p class=\\\"text-700 mb-2 text-[12px] leading-[18px] md:text-[13px] [&amp;&gt;a]:text-gray-700 [&amp;&gt;a]:underline\\\"><img src=\\\"https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS.jpg\\\" alt=\\\"Nick runs after Judy on a pier in Zootopia 2\\\"><picture class=\\\"block w-full pt-[--aspect-padding] relative\\\" data-new-v2-image=\\\"true\\\"><source srcset=\\\"https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS-1920-80.jpg.webp 1920w, https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS-1200-80.jpg.webp 1200w, https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS-1024-80.jpg.webp 1024w, https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS-970-80.jpg.webp 970w, https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS-650-80.jpg.webp 650w, https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS-480-80.jpg.webp 480w, https://cdn.mos.cms.futurecdn.net/y2L8dEHzhPgjuKuin9bkgS-320-80.jpg.webp 320w\\\" type=\\\"image/webp\\\" sizes=\\\"(min-width: 1000px) 600px, calc(100vw - 40px)\\\"></picture></p>\\r\\n</aside>\\r\\n</header></div>\\r\\n</div>\", \"excerpt\": null}}',NULL,1,'2026-03-14 16:01:49','2026-03-25 16:44:44','2026-03-25 16:44:44'),(2,'Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030','le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030','Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.','','https://citabic.devbyzaid.site/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp','published','2026-03-27 22:24:08',0,0,1,0,'Le BTP au Maroc : Horizon 2030 et Essor du Secteur | CITABIC','Découvrez comment la CAN 2025 et le Mondial 2030 propulsent le BTP au Maroc. Focus sur 140 Mrd DH d\'investissements et l\'expertise certifiée de CITABIC.','Secteur BTP Maroc, Infrastructure CAN 2025, Investissement BTP Maroc, Construction Casablanca Tanger, CITABIC BTP','BTP Maroc 2030','https://citabic.devbyzaid.site/blog/le-maroc-un-chantier-a-ciel-ouvert-vers-lecheance-2030','Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030','Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.','http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp','Le Maroc : Un Chantier à Ciel Ouvert vers l’Échéance 2030','Le BTP au Maroc explose avec la CAN 2025 et le Mondial 2030. 140 mrd DH d\'investissements d\'ici 2025. Un chantier d\'avenir pesant 6% du PIB et 10% de l\'emploi.','http://localhost:8000/storage/posts/featured/5964f0bf-1b6c-4b70-a4f4-f33b67e739e7.webp','summary_large_image',1,1,'Article',NULL,'{\"en\": {\"title\": \"Morocco: An Open-Air Construction Site Towards the 2030 Deadline\", \"excerpt\": \"The construction industry in Morocco is booming with the 2025 Africa Cup of Nations and the 2030 World Cup. 140 billion dirhams of investments are expected by 2025. A project of the future representing 6% of GDP and 10% of employment.\"}}','[{\"type\": \"hero\", \"image\": \"https://citabic.devbyzaid.site/storage/posts/featured/31c1051a-c52d-44db-b7d5-23178ad34ffe.webp\"}, {\"type\": \"paragraph\", \"content\": \"<p>Le secteur du B&acirc;timent et des Travaux Publics (BTP) au Maroc vit une m&eacute;tamorphose historique. Port&eacute; par des ambitions royales et des rendez-vous plan&eacute;taires, le Royaume ne se contente plus de construire des infrastructures : il b&acirc;tit l\'avenir de toute une nation.</p>\", \"content_en\": \"<p>The construction and public works (BTP) sector in Morocco is undergoing a historic transformation. Driven by royal ambitions and global commitments, the Kingdom is no longer content with simply building infrastructure: it is building the future of an entire nation.</p>\"}, {\"type\": \"quote\", \"author\": \"\", \"content\": \"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\", \"author_en\": \"\", \"content_en\": \"\", \"content_en_en\": \"Le Maroc ne se prépare pas seulement à accueillir le monde ; il se transforme pour offrir à ses citoyens un cadre de vie aux standards internationaux.\"}, {\"type\": \"subheading\", \"content\": \"1. L’Ambition Sportive : Un Accélérateur d\'Infrastructures\", \"content_en\": \"\", \"content_en_en\": \"1. Sporting Ambition: An Accelerator of Infrastructure\"}, {\"type\": \"paragraph\", \"content\": \"<p data-path-to-node=\\\"6\\\">L&rsquo;accueil de la&nbsp;<strong data-path-to-node=\\\"6\\\" data-index-in-node=\\\"16\\\">CAN 2025</strong> et la co-organisation de la <strong data-path-to-node=\\\"6\\\" data-index-in-node=\\\"53\\\">Coupe du Monde 2030</strong> avec l&rsquo;Espagne et le Portugal ne sont pas de simples &eacute;v&eacute;nements sportifs. Ce sont des catalyseurs de d&eacute;veloppement.</p>\\n<p data-path-to-node=\\\"7\\\">De Tanger &agrave; Agadir, la mise &agrave; niveau des stades (Ibn Battouta, Moulay Abdellah, Adrar) d&eacute;passe le cadre du football. Il s\'agit de cr&eacute;er des p&ocirc;les de vie, de culture et de loisirs connect&eacute;s. Ces projets exigent une rigueur technique et une rapidit&eacute; d\'ex&eacute;cution o&ugrave; l\'expertise certifi&eacute;e devient la cl&eacute; du succ&egrave;s.</p>\", \"content_en\": \"<p>Hosting the 2025 Africa Cup of Nations and co-hosting the 2030 World Cup with Spain and Portugal are not simply sporting events. They are catalysts for development.</p>\\n<p>From Tangier to Agadir, the upgrading of stadiums (Ibn Battouta, Moulay Abdellah, Adrar) goes beyond football. It\'s about creating interconnected hubs of life, culture, and leisure. These projects demand technical precision and rapid execution, where certified expertise becomes the key to success.</p>\"}, {\"type\": \"subheading\", \"content\": \"2. Modernisation Intégrée : Au-delà du Béton\", \"content_en\": \"\", \"content_en_en\": \"2. Modernisation Intégrée : Au-delà du Béton\"}, {\"type\": \"paragraph\", \"content\": \"<p>Le d&eacute;veloppement du Maroc repose sur une vision holistique. Avec un investissement colossal de plus de <strong data-path-to-node=\\\"9\\\" data-index-in-node=\\\"103\\\">140 milliards de dirhams d\'ici 2025</strong>, le Royaume d&eacute;ploie des projets structurants :</p>\", \"content_en\": \"<p>Morocco\'s development is based on a holistic vision. With a colossal investment of over 140 billion dirhams by 2025, the Kingdom is deploying structuring projects:</p>\"}, {\"type\": \"list\", \"items\": [\"Mobilité : Extension du réseau TGV et des lignes de Tramway.\", \"Souveraineté : Construction de stations de dessalement et de complexes solaires.\", \"Logistique : Expansion des ports et aéroports pour une connectivité mondiale.\"], \"items_en\": [\"Mobility: Extension of the TGV network and tram lines.\", \"Sovereignty: Construction of desalination plants and solar complexes.\", \"Logistics: Expansion of ports and airports for global connectivity.\"], \"listType\": \"unordered\"}]',1,'2026-03-25 15:12:51','2026-03-28 18:38:04',NULL);
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `role_has_permissions`
--

DROP TABLE IF EXISTS `role_has_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint unsigned NOT NULL,
  `role_id` bigint unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `role_has_permissions`
--

LOCK TABLES `role_has_permissions` WRITE;
/*!40000 ALTER TABLE `role_has_permissions` DISABLE KEYS */;
INSERT INTO `role_has_permissions` VALUES (1,1),(2,1),(3,1),(4,1),(5,1),(6,1),(1,2),(3,2),(4,2);
/*!40000 ALTER TABLE `role_has_permissions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `roles`
--

DROP TABLE IF EXISTS `roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `roles` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `roles`
--

LOCK TABLES `roles` WRITE;
/*!40000 ALTER TABLE `roles` DISABLE KEYS */;
INSERT INTO `roles` VALUES (1,'admin','web','2026-03-28 01:11:51','2026-03-28 01:11:51'),(2,'blog editor','web','2026-03-28 01:11:51','2026-03-28 01:11:51');
/*!40000 ALTER TABLE `roles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `section_contents`
--

DROP TABLE IF EXISTS `section_contents`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `section_contents` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `section` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `language` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=65 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `section_contents`
--

LOCK TABLES `section_contents` WRITE;
/*!40000 ALTER TABLE `section_contents` DISABLE KEYS */;
INSERT INTO `section_contents` VALUES (1,'our_approach','our_approach_title','A sector undergoing rapid growth and transformation','en','2026-03-17 15:34:57','2026-03-17 15:34:57'),(2,'our_approach','our_approach_title','Un secteur en pleine croissance et transformation','fr','2026-03-17 15:34:57','2026-03-17 15:34:57'),(3,'hero','hero_title','Together we build your future','en','2026-03-17 21:39:46','2026-03-17 21:39:46'),(4,'hero','hero_title','Ensemble, nous bâtissons votre avenir','fr','2026-03-17 21:39:46','2026-03-28 02:13:26'),(5,'hero','hero_subtitle','YOUR VISION , OUR EXPERTISE','en','2026-03-17 21:39:46','2026-03-17 21:39:46'),(6,'hero','hero_subtitle','VOTRE VISION, NOTRE EXPERTISE','fr','2026-03-17 21:39:46','2026-03-17 21:39:46'),(7,'about','about_title','About Us','en','2026-03-17 21:39:46','2026-03-26 20:22:24'),(8,'about','about_title','Présentation de CITABIC','fr','2026-03-17 21:39:46','2026-03-26 23:23:05'),(9,'about','about_text','<p>Founded in 2021, <strong>CITABIC</strong> is a dynamic construction company that is reinventing the standards of building, renovation, and civil engineering through an innovative concept. Leveraging the experience and responsiveness of qualified professionals, the company is committed to supporting its clients in all their projects by offering superior quality turnkey solutions. Our credo is based on excellent service and seamless management, thus guaranteeing projects that precisely meet your needs and most demanding expectations.</p>','en','2026-03-17 21:42:55','2026-03-26 20:22:25'),(10,'about','about_text','<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>','fr','2026-03-17 21:42:55','2026-03-26 20:22:25'),(11,'about_page','about_title','A propos de nous','fr','2026-03-18 21:59:15','2026-03-18 21:59:15'),(12,'about_page','about_title','About Us','en','2026-03-18 21:59:15','2026-03-18 21:59:15'),(13,'about_page','rounded_text','Ensemble, construisons votre avenir !','fr','2026-03-18 21:59:15','2026-03-19 23:42:39'),(14,'about_page','rounded_text','Let\'s build your future together!','en','2026-03-18 21:59:15','2026-03-19 23:42:56'),(15,'about_page','about_text','<p data-path-to-node=\"0\">Fond&eacute;e en 2021, <strong data-path-to-node=\"0\" data-index-in-node=\"16\">CITABIC</strong> est une entreprise de BTP dynamique qui r&eacute;invente les standards de la construction, de la r&eacute;novation et du g&eacute;nie civil &agrave; travers un concept novateur. S&rsquo;appuyant sur l&rsquo;exp&eacute;rience et la r&eacute;activit&eacute; de professionnels qualifi&eacute;s, la soci&eacute;t&eacute; s\'engage &agrave; accompagner ses clients dans tous leurs projets en proposant des solutions <strong data-path-to-node=\"0\" data-index-in-node=\"345\">&laquo; cl&eacute; en main &raquo;</strong> d\'une qualit&eacute; sup&eacute;rieure. Notre cr&eacute;do repose sur un service d\'excellence et une gestion sereine, garantissant ainsi des r&eacute;alisations qui r&eacute;pondent pr&eacute;cis&eacute;ment &agrave; vos besoins et &agrave; vos attentes les plus exigeantes.</p>','fr','2026-03-18 21:59:15','2026-03-18 23:21:09'),(16,'about_page','about_text','<p>Founded in 2021, <strong>CITABIC</strong> is a dynamic construction company that is reinventing the standards of building, renovation, and civil engineering through an innovative concept. Leveraging the experience and responsiveness of qualified professionals, the company is committed to supporting its clients in all their projects by offering superior quality turnkey solutions. Our credo is based on excellent service and seamless management, thus guaranteeing projects that precisely meet your needs and most demanding expectations.</p>','en','2026-03-18 21:59:15','2026-03-18 23:36:11'),(17,'about_page','organigrame','about/9tnBQ840WzezAqyp3v4KjDVVKwh8YTB1rjkUE7Pz.png','fr','2026-03-18 21:59:42','2026-03-18 23:17:47'),(18,'about_page','cartographie','about/y1DgrAlkrDAQPVFcPlPKWKzKQSsAQkECfuC0CVAP.png','fr','2026-03-18 21:59:42','2026-03-18 23:18:11'),(19,'about_page','about_header_bg_img','about/3eHZyN8RwDo2GQOSbgzYKSKAzRJQ64ke2nlEcrJw.jpg','fr','2026-03-18 22:12:47','2026-03-18 23:18:11'),(20,'about_page','section_image','about/TZH0dsVqNUapiHsg4az4Z66TYev8Pp9WJqENVK7V.jpg','fr','2026-03-18 22:40:29','2026-03-19 23:33:30'),(21,'about_page','mission_text','<p><strong>CITABIC</strong> articule sa mission autour de la satisfaction client, de la qualite de gestion et d\'une execution structuree de ses processus.</p>','fr','2026-03-19 20:35:30','2026-03-19 20:36:46'),(22,'about_page','mission_text','<p><strong>CITABIC</strong> structures its mission around customer satisfaction, quality of management and a structured execution of its processes.</p>','en','2026-03-19 20:35:30','2026-03-19 20:35:30'),(23,'about_page','mission_title','Notre mission','fr','2026-03-19 20:35:56','2026-03-19 20:35:56'),(24,'about_page','mission_title','Our mission','en','2026-03-19 20:35:56','2026-03-19 20:35:56'),(25,'about_page','why_us_title','Pourquoi choisir CITABIC ?','fr','2026-03-20 00:23:03','2026-03-20 00:23:03'),(26,'about_page','why_us_text','<p>Expertise BTP certifi&eacute;e <strong data-path-to-node=\"1\" data-index-in-node=\"29\">ISO 9001 &amp; 45001</strong>. Nos &eacute;quipes d&eacute;ploient des solutions innovantes et sur-mesure, garantissant s&eacute;curit&eacute;, transparence (ERP) et durabilit&eacute; pour chacun de vos projets, dans le strict respect de vos exigences.</p>','fr','2026-03-20 00:23:03','2026-03-20 00:23:03'),(27,'about_page','why_us_cards','Expertise complète dans le BTP;Engagement envers la qualité et la sécurité;Solutions personnalisées et innovantes;Une équipe de professionnels expérimentés;Infrastructure et technologie de pointe','fr','2026-03-20 00:23:03','2026-03-20 00:23:12'),(28,'about_page','why_us_title','Why choose CITABIC?','en','2026-03-20 22:52:33','2026-03-20 22:52:33'),(29,'about_page','why_us_text','<p>Construction expertise certified <strong>ISO 9001 &amp; 45001</strong>. Our teams deploy innovative and tailor-made solutions, guaranteeing safety, transparency (ERP) and sustainability for each of your projects, in strict compliance with your requirements.</p>','en','2026-03-20 22:52:33','2026-03-20 22:53:05'),(30,'about_page','why_us_cards','Comprehensive expertise in the construction industry; Commitment to quality and safety; Customized and innovative solutions; A team of experienced professionals; State-of-the-art infrastructure and technology','en','2026-03-20 22:52:33','2026-03-20 22:52:33'),(31,'about_page','organigrame_title','Notre Organisation','fr','2026-03-21 00:40:50','2026-03-21 00:40:50'),(32,'about_page','cartographie_title','Cartographie de processus de CITABIC','fr','2026-03-21 12:09:33','2026-03-21 12:09:33'),(33,'contact','contact_title','Contact','fr','2026-03-21 15:53:02','2026-03-21 15:53:02'),(34,'contact','contact_form_text','Prendre contact avec CITABIC','fr','2026-03-21 15:53:02','2026-03-21 15:53:02'),(35,'contact','map_embed','<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d994.9369162131916!2d-5.811507772407547!3d35.771870542982874!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd0b810011ba8017%3A0xd6bdf01ad993f38f!2sCITABIC!5e0!3m2!1sen!2sma!4v1774108305722!5m2!1sen!2sma\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>','fr','2026-03-21 15:53:02','2026-03-21 15:53:02'),(36,'contact','contact_image','contact/HKU8tDo9cxFPQaF6hlaThnVT2Jk8QQ7ZPSPzdxpD.png','fr','2026-03-21 15:53:02','2026-03-21 15:53:02'),(37,'about','about_image_1','about/8b2b1014-9f28-4a93-bf50-1726d70ac32f.webp','fr','2026-03-21 21:50:24','2026-03-26 20:22:25'),(38,'about','about_image_2','about/52a4913b-db46-40dd-8c97-7e14f42aee2f.webp','fr','2026-03-21 21:50:24','2026-03-21 21:50:24'),(39,'about','about_image_3','about/9fc67cae-4e9a-4ccc-80fb-f735adcae07b.webp','fr','2026-03-21 21:50:24','2026-03-28 01:59:44'),(40,'hero','hero_video','hero/98d976d1-ce11-4737-a8e3-8da0ec1e4688.mp4','fr','2026-03-22 12:54:29','2026-10-31 15:09:12'),(41,'domain','domain_title','Complete coverage of the construction cycle.','en','2026-03-22 15:00:52','2026-03-22 15:00:52'),(42,'domain','domain_title','Une couverture complete du cycle BTP.','fr','2026-03-22 15:00:52','2026-03-22 15:00:52'),(43,'domain','domain_text','<p>CITABIC\'s activities cover civil engineering, construction, real estate and project coordination missions.</p>','en','2026-03-22 15:00:52','2026-03-22 15:00:52'),(44,'domain','domain_text','<p>Les activites de CITABIC couvrent le genie civil, le batiment, l\'immobilier et les missions de coordination de projet.</p>','fr','2026-03-22 15:00:52','2026-03-22 15:00:52'),(45,'why_choose_us','why_title','Où la vision rencontre la construction.','fr','2026-03-22 16:12:27','2026-03-22 16:12:27'),(46,'why_choose_us','why_subtitle','Pourquoi nous choisir','fr','2026-03-22 16:12:27','2026-03-22 16:12:27'),(47,'why_choose_us','why_text','Expertise BTP certifiée ISO 9001 & 45001. Nos équipes déploient des solutions innovantes et sur-mesure, garantissant sécurité, transparence (ERP) et durabilité pour chacun de vos projets, dans le strict respect de vos exigences.','fr','2026-03-22 16:12:27','2026-03-22 16:12:27'),(48,'why_choose_us','why_features','[]','en','2026-03-22 16:12:27','2026-03-22 16:12:27'),(49,'why_choose_us','why_features','[{\"title\":\"Expertise complète dans le BTP\",\"text\":\"Une maîtrise totale de tous les aspects du BTP, du génie civil à la construction\\r\\nclé en main, en passant par la rénovation et les aménagements extérieurs.\"},{\"title\":\"Engagement envers la qualité et la sécurité\",\"text\":\"Des standards élevés garantis par nos certifications ISO 9001 et ISO 45001,\\r\\nassurant une qualité et une sécurité optimales sur tous nos chantiers.\"},{\"title\":\"Solutions personnalisées et innovantes\",\"text\":\"Une approche sur-mesure qui s’adapte aux spécificités de chaque projet et\\r\\nintègre des solutions innovantes pour des résultats performants et durables.\"},{\"title\":\"Une équipe de professionnels expérimentés\",\"text\":\"Des experts qualifiés et engagés, à votre service pour assurer le bon\\r\\ndéroulement de vos projets dans le respect des délais et budgets.\"},{\"title\":\"Infrastructure et technologie de pointe\",\"text\":\"Gestion optimisée grâce à notre système ERP avancé, assurant une\\r\\ntransparence et une efficacité accrues dans chaque étape de nos prestations.\"}]','fr','2026-03-22 16:12:27','2026-03-22 16:14:30'),(50,'why_choose_us','why_image','about/d7e62eac-a664-46de-9833-4028892d3634.webp','fr','2026-03-22 17:12:25','2026-03-22 17:12:25'),(51,'projects','projects_subtitle','Our Projects','en','2026-03-24 19:07:18','2026-03-24 19:07:18'),(52,'projects','projects_subtitle','Nos projets','fr','2026-03-24 19:07:18','2026-03-24 19:07:18'),(53,'projects','projects_title','Check Our Latest Projects','en','2026-03-24 19:07:18','2026-03-24 19:07:18'),(54,'projects','projects_title','Découvrez nos derniers projets','fr','2026-03-24 19:07:18','2026-03-24 19:07:18'),(55,'projects','projects_text','<p>Commercial construction involves the design, development, and construction of structures intended for business.</p>','en','2026-03-24 19:07:18','2026-03-24 19:07:18'),(56,'projects','projects_text','<p>La construction commerciale englobe la conception, le d&eacute;veloppement et la construction de structures destin&eacute;es aux entreprises.</p>','fr','2026-03-24 19:07:18','2026-03-24 19:07:18'),(57,'home','blog_subtitle','Actualités et blog','fr','2026-03-25 23:11:03','2026-03-25 23:11:03'),(58,'home','blog_title','Découvrez nos perspectives','fr','2026-03-25 23:11:03','2026-03-25 23:11:03'),(59,'home','blog_text','<p>La construction commerciale englobe la conception, le d&eacute;veloppement&nbsp; et l\'&eacute;dification de structures strat&eacute;giques d&eacute;di&eacute;es &agrave; la performance des entreprises.<br>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;</p>','fr','2026-03-25 23:11:03','2026-03-25 23:11:03'),(60,'home','values_subtitle','Nos valeurs','fr','2026-03-26 01:22:57','2026-03-26 01:22:57'),(61,'home','values_title','Ce que nous defons','fr','2026-03-26 01:22:57','2026-03-26 01:22:57'),(62,'footer','section_image','about/11d8a930-c134-4ce2-89f6-5ba2e723a2fd.webp','fr','2026-03-26 01:52:42','2026-03-26 23:23:05'),(63,'about','about_subtitle','A propos de nous','fr','2026-03-26 23:23:05','2026-03-26 23:23:05'),(64,'domain','domain_subtitle','Domaines d\'activite','fr','2026-03-26 23:23:05','2026-03-26 23:23:05');
/*!40000 ALTER TABLE `section_contents` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `sessions`
--

DROP TABLE IF EXISTS `sessions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `sessions`
--

LOCK TABLES `sessions` WRITE;
/*!40000 ALTER TABLE `sessions` DISABLE KEYS */;
INSERT INTO `sessions` VALUES ('WT8v0ysbzCuFQbUFbcvNHcyCuiynNhcVhMjyNtI2',2,'127.0.0.1','Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/144.0.0.0 Safari/537.36','YTo1OntzOjY6Il90b2tlbiI7czo0MDoiOVY4RVQ2Zk4zZE5Hdk5OM0N5eWpxZjV4VHZ6MG5OV2F0c2dmamhXNyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjE6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMCI7czo1OiJyb3V0ZSI7czo0OiJob21lIjt9czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MjtzOjY6ImxvY2FsZSI7czoyOiJmciI7fQ==',1774664376);
/*!40000 ALTER TABLE `sessions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tags`
--

DROP TABLE IF EXISTS `tags`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `tags` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `tags_slug_unique` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
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
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `is_admin` tinyint(1) NOT NULL DEFAULT '0',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Administrator','admin@citabic.com',NULL,'$2y$12$eUDPy96t2CdM1AbGRfOmAeWwW5tXMagCOUJDVKyv/M1tlxBK8pEiq',1,NULL,'2026-03-14 02:38:03','2026-03-14 02:38:03');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2026-10-31 23:28:09
