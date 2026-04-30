-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Apr 07, 2026 at 05:50 AM
-- Server version: 8.0.31
-- PHP Version: 8.1.13

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soundflow_live_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(2, 'admin', 'admin@gmail.com', '$2y$10$SX0QkJjlYIzdXyIOep/ehOLa1imtnZBhkbLZ5FtrCqCzp8OyySn8O', '2025-12-17 11:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

DROP TABLE IF EXISTS `albums`;
CREATE TABLE IF NOT EXISTS `albums` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `album_title` varchar(255) NOT NULL,
  `artist` varchar(255) NOT NULL,
  `featuring` text,
  `album_type` varchar(50) NOT NULL,
  `num_tracks` int NOT NULL,
  `genre` varchar(100) NOT NULL,
  `subgenre` varchar(100) DEFAULT NULL,
  `release_date` date NOT NULL,
  `language` varchar(100) NOT NULL,
  `upc_code` varchar(50) DEFAULT NULL,
  `label` varchar(255) DEFAULT NULL,
  `description` text,
  `explicit` varchar(20) NOT NULL,
  `cover_art` varchar(255) DEFAULT NULL,
  `template` varchar(50) DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `user_id`, `album_title`, `artist`, `featuring`, `album_type`, `num_tracks`, `genre`, `subgenre`, `release_date`, `language`, `upc_code`, `label`, `description`, `explicit`, `cover_art`, `template`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Test Album', 'Dhanpreet', '', 'album', 2, 'rock', 'alternative', '2025-12-20', 'english', '', '', '', '', 'uploads/covers/virk_logo.png', '', 1, '2025-12-18 11:20:39', '2025-12-18 11:20:39'),
(2, 1, 'test album', 'Nisha', '', 'album', 2, 'rock', 'alternative', '2025-11-11', 'english', '', '', '', 'yes', 'uploads/covers/wheel-banner1.jpg', 'vintage', 1, '2026-01-03 07:06:49', '2026-01-03 07:06:49');

-- --------------------------------------------------------

--
-- Table structure for table `album_social`
--

DROP TABLE IF EXISTS `album_social`;
CREATE TABLE IF NOT EXISTS `album_social` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `album_id` int NOT NULL,
  `platform` varchar(100) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `album_social`
--

INSERT INTO `album_social` (`id`, `album_id`, `platform`, `enabled`) VALUES
(1, 2, 'youtube', 1),
(2, 2, 'instagram', 1);

-- --------------------------------------------------------

--
-- Table structure for table `album_stores`
--

DROP TABLE IF EXISTS `album_stores`;
CREATE TABLE IF NOT EXISTS `album_stores` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `album_id` int NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `album_stores`
--

INSERT INTO `album_stores` (`id`, `album_id`, `store_name`, `enabled`) VALUES
(1, 1, 'spotify', 1),
(2, 1, 'apple', 1),
(3, 1, 'youtube', 1),
(4, 1, 'amazon', 1),
(5, 1, 'tidal', 1),
(6, 2, 'i-tunes', 1),
(7, 2, 'spotify', 1),
(8, 2, 'apple_music', 1),
(9, 2, 'amazon_music', 1);

-- --------------------------------------------------------

--
-- Table structure for table `album_tracks`
--

DROP TABLE IF EXISTS `album_tracks`;
CREATE TABLE IF NOT EXISTS `album_tracks` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `album_id` int NOT NULL,
  `track_number` int NOT NULL,
  `track_title` varchar(255) NOT NULL,
  `songwriters` text,
  `artists` text,
  `producers` text,
  `audio_file` varchar(255) NOT NULL,
  `is_explicit` tinyint(1) NOT NULL DEFAULT '0',
  `isrc` varchar(255) DEFAULT NULL,
  `total_streams` bigint NOT NULL DEFAULT '0',
  `total_downloads` bigint NOT NULL DEFAULT '0',
  `total_revenue` float(10,2) NOT NULL DEFAULT '0.00',
  `is_active` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `album_tracks`
--

INSERT INTO `album_tracks` (`id`, `album_id`, `track_number`, `track_title`, `songwriters`, `artists`, `producers`, `audio_file`, `is_explicit`, `isrc`, `total_streams`, `total_downloads`, `total_revenue`, `is_active`) VALUES
(1, 1, 1, 'Title 1', '', '', '', 'uploads/audio/BOYFRIEND(MUSIC_VIDEO)_KARAN_AUJLA_SUNANDA_IKKY_Latest_Punjabi_Songs_20251.mp3', 0, 'INABC2500001', 0, 0, 0.00, 0),
(2, 1, 2, 'Title 2', '', '', '', 'uploads/audio/BOYFRIEND(MUSIC_VIDEO)_KARAN_AUJLA_SUNANDA_IKKY_Latest_Punjabi_Songs_20252.mp3', 0, 'INABC2500002', 300, 30, 30.00, 0),
(3, 2, 1, 'Album Song 1', '', '', '', 'uploads/audio/page-shuffle-transition-4298698.mp3', 0, NULL, 0, 0, 0.00, 0),
(4, 2, 2, 'Album Song 2', '', '', '', 'uploads/audio/page-shuffle-transition-4298699.mp3', 0, 'INABC2500004', 8000, 80, 800.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `album_track_streaming_history`
--

DROP TABLE IF EXISTS `album_track_streaming_history`;
CREATE TABLE IF NOT EXISTS `album_track_streaming_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `track_id` int NOT NULL,
  `isrc` varchar(20) NOT NULL,
  `platform` enum('spotify','apple','youtube','amazon','gaana','jiosaavn') NOT NULL,
  `streams` bigint DEFAULT '0',
  `revenue` decimal(10,2) DEFAULT '0.00',
  `downloads` bigint NOT NULL DEFAULT '0',
  `report_month` date NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `isrc` (`isrc`),
  KEY `report_month` (`report_month`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `album_track_streaming_history`
--

INSERT INTO `album_track_streaming_history` (`id`, `track_id`, `isrc`, `platform`, `streams`, `revenue`, `downloads`, `report_month`, `uploaded_at`) VALUES
(1, 2, 'INABC2500002', 'spotify', 50, '5.00', 5, '2025-01-01', '2025-12-24 15:24:14'),
(2, 2, 'INABC2500002', 'spotify', 100, '10.00', 10, '2025-01-02', '2025-12-24 15:24:14'),
(3, 2, 'INABC2500002', 'spotify', 150, '15.00', 15, '2025-02-01', '2025-12-24 15:24:14'),
(4, 4, 'INABC2500004', 'spotify', 5000, '500.00', 50, '2026-01-01', '2026-01-06 09:34:24'),
(5, 4, 'INABC2500004', 'youtube', 3000, '300.00', 30, '2026-01-02', '2026-01-06 09:34:24');

-- --------------------------------------------------------

--
-- Table structure for table `assets`
--

DROP TABLE IF EXISTS `assets`;
CREATE TABLE IF NOT EXISTS `assets` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `project_id` int NOT NULL,
  `asset_name` varchar(255) DEFAULT NULL,
  `asset_type` varchar(50) DEFAULT NULL,
  `version` varchar(50) DEFAULT NULL,
  `tags` varchar(255) DEFAULT NULL,
  `credits` varchar(255) DEFAULT NULL,
  `notes` text,
  `file_path` text,
  `file_size` bigint DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `asset_projects`
--

DROP TABLE IF EXISTS `asset_projects`;
CREATE TABLE IF NOT EXISTS `asset_projects` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `project_type` enum('song','album') DEFAULT 'song',
  `genre` varchar(100) DEFAULT NULL,
  `bpm` int DEFAULT NULL,
  `musical_key` varchar(50) DEFAULT NULL,
  `description` text,
  `status` enum('idea','draft','final') DEFAULT 'idea',
  `tags` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `asset_projects`
--

INSERT INTO `asset_projects` (`id`, `user_id`, `name`, `project_type`, `genre`, `bpm`, `musical_key`, `description`, `status`, `tags`, `created_at`) VALUES
(1, 1, 'Project 1', 'album', 'sd', 33, 'ss', '', 'idea', '', '2026-01-02 17:30:27'),
(2, 1, 'Test project 2', 'song', '', 0, '', '', 'idea', '', '2026-01-03 07:08:41'),
(3, 1, 'tt', 'song', '', 0, '', '', 'idea', '', '2026-01-03 07:31:03');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

DROP TABLE IF EXISTS `genres`;
CREATE TABLE IF NOT EXISTS `genres` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=88 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `genres`
--

INSERT INTO `genres` (`id`, `name`) VALUES
(1, 'Love'),
(2, 'Romantic'),
(3, 'Sad'),
(4, 'Emotional'),
(5, 'Heartbreak'),
(6, 'Happy'),
(7, 'Joyful'),
(8, 'Chill'),
(9, 'Relaxing'),
(10, 'Calm'),
(11, 'Peaceful'),
(12, 'Angry'),
(13, 'Dark'),
(14, 'Dramatic'),
(15, 'Hopeful'),
(16, 'Inspirational'),
(17, 'Motivational'),
(18, 'Uplifting'),
(19, 'Energetic'),
(20, 'Party'),
(21, 'Celebration'),
(22, 'Pop'),
(23, 'Rock'),
(24, 'Hip-Hop'),
(25, 'Rap'),
(26, 'EDM'),
(27, 'Electronic'),
(28, 'House'),
(29, 'Techno'),
(30, 'Trance'),
(31, 'Dubstep'),
(32, 'Drum & Bass'),
(33, 'Jazz'),
(34, 'Blues'),
(35, 'Classical'),
(36, 'Country'),
(37, 'Folk'),
(38, 'Indie'),
(39, 'Alternative'),
(40, 'Metal'),
(41, 'Punk'),
(42, 'Reggae'),
(43, 'Latin'),
(44, 'Afrobeats'),
(45, 'K-Pop'),
(46, 'J-Pop'),
(47, 'Bollywood'),
(48, 'Soul'),
(49, 'Funk'),
(50, 'Disco'),
(51, 'Instrumental'),
(52, 'Acoustic'),
(53, 'Beat'),
(54, 'Lo-Fi'),
(55, 'Remix'),
(56, 'Cover'),
(57, 'Orchestra'),
(58, 'Piano'),
(59, 'Guitar'),
(60, 'Vocal'),
(61, 'A Cappella'),
(62, 'Ambient'),
(63, 'Experimental'),
(64, 'Soundtrack'),
(65, 'Background Music'),
(66, 'Film Score'),
(67, 'Trailer Music'),
(68, 'Cinematic'),
(69, 'Game Music'),
(70, 'Podcast Intro'),
(71, 'Advertisement'),
(72, 'Corporate'),
(73, 'Meditation'),
(74, 'Yoga'),
(75, 'Sleep'),
(76, 'Documentary'),
(77, 'Prayer'),
(78, 'Devotional'),
(79, 'Bhajan'),
(80, 'Kirtan'),
(81, 'Chant'),
(82, 'Spiritual'),
(83, 'Worship'),
(84, 'Kids'),
(85, 'Nursery Rhymes'),
(86, 'Educational'),
(87, 'Storytelling');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

DROP TABLE IF EXISTS `languages`;
CREATE TABLE IF NOT EXISTS `languages` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=94 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `name`) VALUES
(1, 'English'),
(2, 'Spanish'),
(3, 'French'),
(4, 'German'),
(5, 'Italian'),
(6, 'Portuguese'),
(7, 'Dutch'),
(8, 'Russian'),
(9, 'Ukrainian'),
(10, 'Polish'),
(11, 'Czech'),
(12, 'Slovak'),
(13, 'Hungarian'),
(14, 'Romanian'),
(15, 'Bulgarian'),
(16, 'Greek'),
(17, 'Turkish'),
(18, 'Arabic'),
(19, 'Hebrew'),
(20, 'Persian'),
(21, 'Urdu'),
(22, 'Hindi'),
(23, 'Bengali'),
(24, 'Punjabi'),
(25, 'Gujarati'),
(26, 'Marathi'),
(27, 'Tamil'),
(28, 'Telugu'),
(29, 'Kannada'),
(30, 'Malayalam'),
(31, 'Sinhala'),
(32, 'Nepali'),
(33, 'Odia'),
(34, 'Assamese'),
(35, 'Kashmiri'),
(36, 'Sanskrit'),
(37, 'Thai'),
(38, 'Vietnamese'),
(39, 'Indonesian'),
(40, 'Malay'),
(41, 'Filipino'),
(42, 'Chinese'),
(43, 'Mandarin'),
(44, 'Cantonese'),
(45, 'Japanese'),
(46, 'Korean'),
(47, 'Mongolian'),
(48, 'Khmer'),
(49, 'Lao'),
(50, 'Burmese'),
(51, 'Swahili'),
(52, 'Zulu'),
(53, 'Xhosa'),
(54, 'Afrikaans'),
(55, 'Amharic'),
(56, 'Somali'),
(57, 'Yoruba'),
(58, 'Igbo'),
(59, 'Hausa'),
(60, 'Shona'),
(61, 'Sesotho'),
(62, 'Tswana'),
(63, 'Latin'),
(64, 'Esperanto'),
(65, 'Icelandic'),
(66, 'Norwegian'),
(67, 'Swedish'),
(68, 'Danish'),
(69, 'Finnish'),
(70, 'Estonian'),
(71, 'Latvian'),
(72, 'Lithuanian'),
(73, 'Irish'),
(74, 'Scottish Gaelic'),
(75, 'Welsh'),
(76, 'Basque'),
(77, 'Catalan'),
(78, 'Galician'),
(79, 'Albanian'),
(80, 'Serbian'),
(81, 'Croatian'),
(82, 'Bosnian'),
(83, 'Slovenian'),
(84, 'Macedonian'),
(85, 'Tibetan'),
(86, 'Uyghur'),
(87, 'Kazakh'),
(88, 'Uzbek'),
(89, 'Turkmen'),
(90, 'Kyrgyz'),
(91, 'Tajik'),
(92, 'Pashto'),
(93, 'Dari');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `version` bigint NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

DROP TABLE IF EXISTS `plans`;
CREATE TABLE IF NOT EXISTS `plans` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` enum('daily','monthly','yearly') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive') DEFAULT 'active',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `duration`, `created_at`, `updated_at`, `status`) VALUES
(1, 'Project 1', '1000.00', 'daily', '2026-04-06 23:13:44', '2026-04-06 23:30:14', 'inactive'),
(4, 'test plan 123', '1000.00', 'yearly', '2026-04-06 23:21:07', '2026-04-06 23:30:23', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `plan_features`
--

DROP TABLE IF EXISTS `plan_features`;
CREATE TABLE IF NOT EXISTS `plan_features` (
  `id` int NOT NULL AUTO_INCREMENT,
  `plan_id` int NOT NULL,
  `feature_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `plan_id` (`plan_id`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plan_features`
--

INSERT INTO `plan_features` (`id`, `plan_id`, `feature_name`, `created_at`) VALUES
(1, 2, 'feature 1', '2026-04-06 17:45:27'),
(2, 2, 'feature 2', '2026-04-06 17:45:27'),
(3, 2, 'feature 3', '2026-04-06 17:45:27'),
(4, 3, 'saxas', '2026-04-06 17:47:23'),
(5, 3, 'asxasx', '2026-04-06 17:47:23'),
(16, 4, 's4', '2026-04-06 23:25:22'),
(15, 4, 's1', '2026-04-06 23:25:22'),
(14, 4, 's2', '2026-04-06 23:25:22'),
(13, 4, 's3', '2026-04-06 23:25:22');

-- --------------------------------------------------------

--
-- Table structure for table `releases`
--

DROP TABLE IF EXISTS `releases`;
CREATE TABLE IF NOT EXISTS `releases` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `primary_artist` varchar(255) NOT NULL,
  `featuring` varchar(255) DEFAULT NULL,
  `genre` varchar(100) DEFAULT NULL,
  `subgenre` varchar(100) DEFAULT NULL,
  `release_date` date DEFAULT NULL,
  `language` varchar(50) DEFAULT NULL,
  `isrc` varchar(50) DEFAULT NULL,
  `description` text,
  `explicit_content` enum('yes','no') DEFAULT 'no',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `is_deleted` tinyint(1) NOT NULL DEFAULT '0',
  `deleted_at` datetime DEFAULT NULL,
  `stream_count` bigint NOT NULL DEFAULT '0',
  `revenue` decimal(10,2) NOT NULL DEFAULT '0.00',
  `download_count` bigint NOT NULL DEFAULT '0',
  `is_active` tinyint NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `is_deleted` (`is_deleted`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `releases`
--

INSERT INTO `releases` (`id`, `user_id`, `title`, `primary_artist`, `featuring`, `genre`, `subgenre`, `release_date`, `language`, `isrc`, `description`, `explicit_content`, `created_at`, `updated_at`, `is_deleted`, `deleted_at`, `stream_count`, `revenue`, `download_count`, `is_active`) VALUES
(1, 2, 'Test Song', 'Dhanpreet', '', 'rock', 'alternative', '2025-12-18', 'hindi', 'INABC2500002', '', 'no', '2025-12-18 11:18:23', '2026-04-02 07:03:43', 0, NULL, 55500, '5550.00', 25100, 1),
(2, 1, 'Test Song', 'Nisha', '', 'pop', 'indie', '2025-12-12', 'german', '12345', '', 'yes', '2025-12-20 12:30:25', '2026-04-02 07:03:43', 0, NULL, 4000, '720.00', 400, 1),
(3, 4, 'Testing One1', 'Kartik', '', 'pop', 'indie', '2026-01-05', 'english', 'INABC2500003', '', 'yes', '2026-01-03 08:08:59', '2026-04-02 07:03:43', 0, NULL, 0, '0.00', 0, 1),
(4, 5, 'test song', 'Nisha', '', 'pop', 'trap', '2026-11-11', 'hindi', '', '', 'no', '2026-02-06 14:22:29', '2026-04-02 07:03:43', 0, NULL, 0, '0.00', 0, 0),
(5, 5, 'test', 'Nisha', 'Nisha, Rishi', 'happy', 'house', '2026-03-19', 'english', '', '', 'yes', '2026-03-12 10:46:05', '2026-04-02 07:03:43', 0, NULL, 0, '0.00', 0, 0),
(6, 5, 'test 2', 'Nisha 1', '', 'love', 'indie', '2026-11-11', 'english', '', '', 'yes', '2026-03-12 11:50:44', '2026-04-02 07:03:43', 0, NULL, 0, '0.00', 0, 0),
(7, 5, '1', '1', '', 'sad', 'trap', '2026-11-11', 'hindi', 'INABC256676856', 'descv test', 'yes', '2026-03-12 11:53:55', '2026-04-02 07:03:43', 0, NULL, 0, '0.00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `release_artwork`
--

DROP TABLE IF EXISTS `release_artwork`;
CREATE TABLE IF NOT EXISTS `release_artwork` (
  `id` int NOT NULL AUTO_INCREMENT,
  `release_id` int NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `template_id` int DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `release_id` (`release_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `release_artwork`
--

INSERT INTO `release_artwork` (`id`, `release_id`, `file_path`, `template_id`) VALUES
(1, 1, 'uploads/artwork/virk_logo.png', 1),
(2, 2, 'uploads/artwork/spin-banner.gif', 0),
(3, 3, 'uploads/artwork/image1.jpeg', 0),
(4, 4, 'uploads/artwork/mocaa.jpg', 0),
(5, 5, 'uploads/artwork/Toh-Toh-flowchart.png', 1),
(6, 6, 'uploads/artwork/City_Run_Masthead_1_-_Logo_updated.png', 0),
(8, 7, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `release_social`
--

DROP TABLE IF EXISTS `release_social`;
CREATE TABLE IF NOT EXISTS `release_social` (
  `id` int NOT NULL AUTO_INCREMENT,
  `release_id` int NOT NULL,
  `platform_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `release_id` (`release_id`)
) ENGINE=MyISAM AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `release_social`
--

INSERT INTO `release_social` (`id`, `release_id`, `platform_key`) VALUES
(2, 2, 'youtube'),
(6, 3, 'instagram'),
(5, 3, 'youtube'),
(7, 4, 'youtube'),
(8, 4, 'instagram'),
(23, 5, 'facebook'),
(22, 5, 'instagram'),
(21, 5, 'youtube'),
(27, 6, 'facebook'),
(26, 6, 'youtube'),
(30, 7, 'youtube');

-- --------------------------------------------------------

--
-- Table structure for table `release_stores`
--

DROP TABLE IF EXISTS `release_stores`;
CREATE TABLE IF NOT EXISTS `release_stores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `release_id` int NOT NULL,
  `store_key` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `release_id` (`release_id`)
) ENGINE=MyISAM AUTO_INCREMENT=195 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `release_stores`
--

INSERT INTO `release_stores` (`id`, `release_id`, `store_key`) VALUES
(1, 1, 'itunes'),
(2, 1, 'apple-music'),
(3, 1, 'spotify'),
(4, 1, 'amazon'),
(5, 1, 'pandora'),
(6, 1, 'deezer'),
(7, 1, 'tidal'),
(8, 1, 'boomplay'),
(9, 1, 'youtube-music'),
(10, 1, 'tiktok'),
(11, 1, 'gaana'),
(12, 1, 'jiosaavn'),
(16, 2, 'spotify'),
(15, 2, 'i-tunes'),
(22, 3, 'amazon_music'),
(21, 3, 'apple-music'),
(20, 3, 'spotify'),
(23, 4, 'i-tunes'),
(24, 4, 'spotify'),
(108, 5, 'peloton'),
(107, 5, 'joox'),
(106, 5, 'net-ease'),
(105, 5, 'snapchat'),
(104, 5, 'jiosaavn'),
(103, 5, 'gaana'),
(102, 5, 'tiktok_music'),
(101, 5, 'youtube_music'),
(100, 5, 'boomplay'),
(99, 5, 'tidal'),
(98, 5, 'deezer'),
(97, 5, 'pandora'),
(96, 5, 'amazon_music'),
(95, 5, 'apple_music'),
(94, 5, 'spotify'),
(93, 5, 'i-tunes'),
(109, 5, 'wnky'),
(138, 6, 'jiosaavn'),
(137, 6, 'gaana'),
(136, 6, 'tiktok_music'),
(135, 6, 'youtube_music'),
(134, 6, 'boomplay'),
(133, 6, 'tidal'),
(132, 6, 'deezer'),
(131, 6, 'pandora'),
(130, 6, 'amazon_music'),
(129, 6, 'apple_music'),
(128, 6, 'spotify'),
(127, 6, 'i-tunes'),
(139, 6, 'snapchat'),
(140, 6, 'net-ease'),
(141, 6, 'joox'),
(142, 6, 'peloton'),
(143, 6, 'wnky'),
(190, 7, 'snapchat'),
(189, 7, 'jiosaavn'),
(188, 7, 'gaana'),
(187, 7, 'tiktok_music'),
(186, 7, 'youtube_music'),
(185, 7, 'boomplay'),
(184, 7, 'tidal'),
(183, 7, 'deezer'),
(182, 7, 'pandora'),
(181, 7, 'amazon_music'),
(180, 7, 'apple_music'),
(179, 7, 'spotify'),
(178, 7, 'i-tunes'),
(191, 7, 'net-ease'),
(192, 7, 'joox'),
(193, 7, 'peloton'),
(194, 7, 'wnky');

-- --------------------------------------------------------

--
-- Table structure for table `sampling`
--

DROP TABLE IF EXISTS `sampling`;
CREATE TABLE IF NOT EXISTS `sampling` (
  `id` bigint NOT NULL AUTO_INCREMENT,
  `user_id` bigint NOT NULL,
  `song_name` varchar(255) NOT NULL,
  `artist_name` varchar(255) DEFAULT NULL,
  `artwork_path` text,
  `audio_path` text NOT NULL,
  `unique_slug` varchar(100) DEFAULT NULL,
  `duration` int DEFAULT '0',
  `total_plays` int DEFAULT '0',
  `total_clicks` int DEFAULT '0',
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_slug` (`unique_slug`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sampling`
--

INSERT INTO `sampling` (`id`, `user_id`, `song_name`, `artist_name`, `artwork_path`, `audio_path`, `unique_slug`, `duration`, `total_plays`, `total_clicks`, `status`, `created_at`) VALUES
(3, 5, 'songv3D  56', 'Nisha 3D 66', 'uploads/artwork/milestone_issue.png', 'uploads/audio/page-shuffle-transition-42986913.mp3', '8a35cd5aec13', 0, 13, 5, 'active', '2026-04-03 11:10:20');

-- --------------------------------------------------------

--
-- Table structure for table `sampling_clicks`
--

DROP TABLE IF EXISTS `sampling_clicks`;
CREATE TABLE IF NOT EXISTS `sampling_clicks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sampling_id` int DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `clicked_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sampling_clicks`
--

INSERT INTO `sampling_clicks` (`id`, `sampling_id`, `ip_address`, `user_agent`, `clicked_at`) VALUES
(1, 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 08:36:45'),
(2, 5, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 08:36:47'),
(3, 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-06 08:37:09'),
(4, 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 05:10:34'),
(5, 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 05:11:31'),
(6, 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 05:11:42'),
(7, 3, '::1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/146.0.0.0 Safari/537.36', '2026-04-07 05:12:00');

-- --------------------------------------------------------

--
-- Table structure for table `sampling_plays`
--

DROP TABLE IF EXISTS `sampling_plays`;
CREATE TABLE IF NOT EXISTS `sampling_plays` (
  `id` int NOT NULL AUTO_INCREMENT,
  `sampling_id` int DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `played_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sampling_plays`
--

INSERT INTO `sampling_plays` (`id`, `sampling_id`, `ip_address`, `played_at`) VALUES
(1, 3, '::1', '2026-04-03 11:23:05'),
(2, 3, '::1', '2026-04-03 11:23:13'),
(3, 3, '::1', '2026-04-03 11:23:36'),
(4, 3, '::1', '2026-04-03 11:23:40'),
(5, 3, '::1', '2026-04-03 11:23:41'),
(6, 3, '::1', '2026-04-03 11:23:45'),
(7, 6, '::1', '2026-04-06 08:31:55'),
(8, 6, '::1', '2026-04-06 08:31:57'),
(9, 5, '::1', '2026-04-06 08:36:45'),
(10, 5, '::1', '2026-04-06 08:36:48'),
(11, 3, '::1', '2026-04-06 08:37:10'),
(12, 3, '::1', '2026-04-07 05:10:34'),
(13, 3, '::1', '2026-04-07 05:11:02'),
(14, 3, '::1', '2026-04-07 05:11:31'),
(15, 3, '::1', '2026-04-07 05:11:42'),
(16, 3, '::1', '2026-04-07 05:12:00'),
(17, 3, '::1', '2026-04-07 05:12:07');

-- --------------------------------------------------------

--
-- Table structure for table `streaming_clicks`
--

DROP TABLE IF EXISTS `streaming_clicks`;
CREATE TABLE IF NOT EXISTS `streaming_clicks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `streaming_link_id` int NOT NULL,
  `track_id` int DEFAULT NULL,
  `clicked_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `streaming_links`
--

DROP TABLE IF EXISTS `streaming_links`;
CREATE TABLE IF NOT EXISTS `streaming_links` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content_type` enum('single','album') NOT NULL,
  `content_id` int NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` varchar(500) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `streaming_links`
--

INSERT INTO `streaming_links` (`id`, `content_type`, `content_id`, `platform`, `url`, `is_active`, `created_at`) VALUES
(1, 'single', 2, 'spotify', 'https://sportify.igpl.pro', 1, '2025-12-20 12:39:17'),
(2, 'single', 1, 'spotify', 'https://sportify.igpl.pro', 1, '2026-01-03 07:16:13'),
(3, 'single', 1, 'apple-music', 'https://apple.igpl.pro', 1, '2026-01-03 07:16:19'),
(4, 'album', 4, 'spotify', 'https://spotify.com', 1, '2026-01-06 09:29:18');

-- --------------------------------------------------------

--
-- Table structure for table `streaming_upload_logs`
--

DROP TABLE IF EXISTS `streaming_upload_logs`;
CREATE TABLE IF NOT EXISTS `streaming_upload_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) DEFAULT NULL,
  `total_rows` int DEFAULT NULL,
  `success_rows` int DEFAULT NULL,
  `failed_rows` int DEFAULT NULL,
  `uploaded_by` int DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

DROP TABLE IF EXISTS `tracks`;
CREATE TABLE IF NOT EXISTS `tracks` (
  `id` int NOT NULL AUTO_INCREMENT,
  `release_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `audio_file` varchar(255) DEFAULT NULL,
  `lyrics` text,
  `lyrics_language` varchar(50) DEFAULT NULL,
  `explicit_lyrics` enum('yes','no') DEFAULT 'no',
  `tiktok_minutes` int DEFAULT '0',
  `tiktok_seconds` int DEFAULT '0',
  `crbt_clip_min` int DEFAULT '0',
  `crbt_clip_sec` int DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `release_id` (`release_id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `release_id`, `title`, `audio_file`, `lyrics`, `lyrics_language`, `explicit_lyrics`, `tiktok_minutes`, `tiktok_seconds`, `crbt_clip_min`, `crbt_clip_sec`) VALUES
(1, 1, 'Boyfriend', 'uploads/audio/BOYFRIEND(MUSIC_VIDEO)_KARAN_AUJLA_SUNANDA_IKKY_Latest_Punjabi_Songs_2025.mp3', '', NULL, NULL, 0, 0, 0, 0),
(2, 2, 'Nazar', 'uploads/audio/page-shuffle-transition-4298697.mp3', '', NULL, 'no', 0, 0, 0, 0),
(3, 3, 'Tera Yaar Hoo mai', NULL, '', NULL, NULL, 0, 0, 0, 0),
(4, 4, 'Nazar', 'uploads/audio/page-shuffle-transition-42986910.mp3', '', NULL, NULL, 0, 0, 0, 0),
(5, 5, 'Song Title', 'uploads/audio/file_example_WAV_10MG.wav', '', NULL, 'no', 1, 15, 1, 5),
(6, 6, 'Song Title  2', 'uploads/audio/file_example_WAV_10MG1.wav', '', NULL, NULL, 0, 0, 0, 0),
(7, 7, 'Nazar 1', 'uploads/audio/file_example_WAV_10MG2.wav', 'test lyrics', NULL, 'no', 1, 5, 3, 15);

-- --------------------------------------------------------

--
-- Table structure for table `track_artists`
--

DROP TABLE IF EXISTS `track_artists`;
CREATE TABLE IF NOT EXISTS `track_artists` (
  `id` int NOT NULL AUTO_INCREMENT,
  `track_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'main',
  PRIMARY KEY (`id`),
  KEY `track_id` (`track_id`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_artists`
--

INSERT INTO `track_artists` (`id`, `track_id`, `name`, `role`, `type`) VALUES
(1, 1, 'Dhanpreet', 'performer', 'performing'),
(3, 3, 'Kartik', 'lyricist', 'main'),
(4, 3, 'Kartik', 'performer', 'performing'),
(5, 4, 'user 1', 'performer', 'performing'),
(6, 4, 'user 2', 'featured', 'performing'),
(9, 6, 'user 2', 'performer', 'performing');

-- --------------------------------------------------------

--
-- Table structure for table `track_producers`
--

DROP TABLE IF EXISTS `track_producers`;
CREATE TABLE IF NOT EXISTS `track_producers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `track_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `track_id` (`track_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_producers`
--

INSERT INTO `track_producers` (`id`, `track_id`, `name`, `role`) VALUES
(1, 1, 'Dhanpreet', 'producer'),
(3, 2, 'ppw2', 'producer'),
(4, 3, 'Kartik', 'producer'),
(5, 4, 'producer 1', 'producer'),
(8, 5, 'producer 2', 'producer'),
(9, 6, 'producer 1', 'producer'),
(12, 7, 'user 3', 'producer');

-- --------------------------------------------------------

--
-- Table structure for table `track_songwriters`
--

DROP TABLE IF EXISTS `track_songwriters`;
CREATE TABLE IF NOT EXISTS `track_songwriters` (
  `id` int NOT NULL AUTO_INCREMENT,
  `track_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `track_id` (`track_id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_songwriters`
--

INSERT INTO `track_songwriters` (`id`, `track_id`, `name`) VALUES
(1, 1, 'Karan'),
(3, 2, 'sw1'),
(4, 3, 'Kartik'),
(5, 4, 'Nisha'),
(8, 5, 'Nisha'),
(9, 6, 'Nisha'),
(12, 7, 'Nisha');

-- --------------------------------------------------------

--
-- Table structure for table `track_streaming_history`
--

DROP TABLE IF EXISTS `track_streaming_history`;
CREATE TABLE IF NOT EXISTS `track_streaming_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `track_id` int NOT NULL,
  `isrc` varchar(20) NOT NULL,
  `platform` enum('spotify','apple','youtube','amazon','gaana','jiosaavn') NOT NULL,
  `streams` bigint DEFAULT '0',
  `revenue` decimal(10,2) DEFAULT '0.00',
  `downloads` bigint NOT NULL DEFAULT '0',
  `report_month` date NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `isrc` (`isrc`),
  KEY `report_month` (`report_month`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_streaming_history`
--

INSERT INTO `track_streaming_history` (`id`, `track_id`, `isrc`, `platform`, `streams`, `revenue`, `downloads`, `report_month`, `uploaded_at`) VALUES
(1, 2, '12345', 'spotify', 500, '100.00', 50, '2025-12-30', '2025-12-20 14:17:31'),
(2, 2, '12345', 'youtube', 300, '50.00', 30, '2025-12-31', '2025-12-20 14:17:31'),
(3, 2, '12345', 'apple', 200, '30.00', 20, '2026-01-01', '2025-12-20 14:17:31'),
(4, 2, '12345', 'spotify', 500, '100.00', 50, '2025-01-03', '2025-12-20 14:17:31'),
(5, 2, '12345', 'youtube', 300, '50.00', 30, '2025-01-03', '2025-12-20 14:17:31'),
(6, 2, '12345', '', 200, '30.00', 20, '2025-01-03', '2025-12-20 14:17:31'),
(7, 2, '12345', 'spotify', 500, '100.00', 50, '2025-02-02', '2025-12-20 14:17:31'),
(8, 2, '12345', 'youtube', 300, '50.00', 30, '2025-02-02', '2025-12-20 14:17:31'),
(9, 2, '12345', '', 200, '30.00', 20, '2025-02-02', '2025-12-20 14:17:31'),
(10, 2, '12345', 'spotify', 500, '100.00', 50, '2025-02-03', '2025-12-20 14:17:31'),
(11, 2, '12345', 'youtube', 300, '50.00', 30, '2025-02-03', '2025-12-20 14:17:31'),
(12, 2, '12345', '', 200, '30.00', 20, '2025-02-03', '2025-12-20 14:17:31'),
(13, 1, 'INABC2500002', 'spotify', 12000, '1000.00', 5000, '2025-01-01', '2026-01-03 07:19:02'),
(14, 1, 'INABC2500002', 'apple', 15000, '1500.00', 7000, '2025-01-01', '2026-01-03 07:19:02'),
(15, 1, 'INABC2500002', 'spotify', 12500, '1500.00', 5600, '2025-02-01', '2026-01-03 07:26:41'),
(16, 1, 'INABC2500002', 'apple', 16000, '1550.00', 7500, '2025-02-01', '2026-01-03 07:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nisha Vaish', 'vaish.nisha55@gmail.com', '$2y$10$hkc5MuPH91jwLfFvUvZ2MenfZJ5eJnajIxnVhw2HcvJhLmIfH4poG', 1, '2025-12-13 17:25:06', '2026-02-06 08:59:08'),
(2, 'Dhanpreet', 'dhanpreet02@gmail.com', '$2y$10$vXzg5amRzG0FGSjqD7.LSeWfIb7ICTP/ez7LY8N/BfDjlEaCG2o9O', 1, '2025-12-18 11:16:22', '2026-04-01 06:40:24'),
(3, 'Test', 'Test@gmail.com', '$2y$10$P8c7/qPX63I6icE1GxJzre1TDsySrQRfk6YNO9QA18wVvGklvlk/i', 1, '2025-12-21 18:35:01', '2026-01-07 06:25:18'),
(4, 'Kartik', 'guptakartik606@gmail.com', '$2y$10$P8c7/qPX63I6icE1GxJzre1TDsySrQRfk6YNO9QA18wVvGklvlk/i', 1, '2026-01-03 07:54:18', '2026-02-06 14:36:35'),
(5, 'Nisha Vaish', 'vaish.nisha73@gmail.com', '$2y$10$41yy9vtcyYjo2C9yDqILKurhLnrQbyA.Qi.ZmE2F9lgktmgpMz9LO', 1, '2026-02-06 14:15:58', '2026-04-07 05:02:55');

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

DROP TABLE IF EXISTS `user_bank_details`;
CREATE TABLE IF NOT EXISTS `user_bank_details` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc` varchar(20) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_bank_details`
--

INSERT INTO `user_bank_details` (`id`, `user_id`, `account_name`, `account_number`, `ifsc`, `bank_name`, `created_at`) VALUES
(1, 1, 'Nisha', '12466778', 'IFSC11', 'kotal', '2026-01-03 10:24:31');

-- --------------------------------------------------------

--
-- Table structure for table `user_invoices`
--

DROP TABLE IF EXISTS `user_invoices`;
CREATE TABLE IF NOT EXISTS `user_invoices` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `invoice_month` varchar(7) NOT NULL,
  `status` enum('pending','approved','paid') NOT NULL DEFAULT 'pending',
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_invoices`
--

INSERT INTO `user_invoices` (`id`, `user_id`, `title`, `invoice_month`, `status`, `file_path`, `created_at`) VALUES
(1, 1, 'in-feb-2025', '2025-02', 'paid', 'uploads/invoices/d09f276354c2802762b16ef14def516b.jpg', '2026-01-03 10:25:09');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
