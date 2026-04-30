-- phpMyAdmin SQL Dump
-- version 4.9.5deb2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 30, 2026 at 06:17 AM
-- Server version: 8.0.42-0ubuntu0.20.04.1
-- PHP Version: 7.4.3-4ubuntu2.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `soundstream_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(150) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(2, 'admin', 'admin@gmail.com', '$2y$10$SX0QkJjlYIzdXyIOep/ehOLa1imtnZBhkbLZ5FtrCqCzp8OyySn8O', '2025-12-17 11:46:17');

-- --------------------------------------------------------

--
-- Table structure for table `albums`
--

CREATE TABLE `albums` (
  `id` int UNSIGNED NOT NULL,
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
  `updated_at` datetime NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `albums`
--

INSERT INTO `albums` (`id`, `user_id`, `album_title`, `artist`, `featuring`, `album_type`, `num_tracks`, `genre`, `subgenre`, `release_date`, `language`, `upc_code`, `label`, `description`, `explicit`, `cover_art`, `template`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 2, 'Test Album', 'Dhanpreet', '', 'album', 2, 'rock', 'alternative', '2025-12-20', 'english', '', '', '', '', 'uploads/artwork/mocaa.jpg', '', 1, '2025-12-18 11:20:39', '2025-12-18 11:20:39'),
(4, 5, 'Nazar 2', 'Nisha', '', 'album', 3, 'classical', 'indie', '2026-11-11', 'hindi', '', '', '', '', 'uploads/artwork/1777451168_ux-design.png', 'clean', 0, '2026-04-29 08:26:11', '2026-04-29 08:26:11');

-- --------------------------------------------------------

--
-- Table structure for table `album_social`
--

CREATE TABLE `album_social` (
  `id` int UNSIGNED NOT NULL,
  `album_id` int NOT NULL,
  `platform` varchar(100) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `album_stores`
--

CREATE TABLE `album_stores` (
  `id` int UNSIGNED NOT NULL,
  `album_id` int NOT NULL,
  `store_name` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `album_stores`
--

INSERT INTO `album_stores` (`id`, `album_id`, `store_name`, `enabled`) VALUES
(1, 1, 'spotify', 1),
(2, 1, 'apple', 1),
(3, 1, 'youtube', 1),
(4, 1, 'amazon', 1),
(5, 1, 'tidal', 1),
(33, 4, 'apple_music', 1),
(32, 4, 'spotify', 1),
(31, 4, 'i-tunes', 1),
(34, 4, 'pandora', 1);

-- --------------------------------------------------------

--
-- Table structure for table `album_tracks`
--

CREATE TABLE `album_tracks` (
  `id` int UNSIGNED NOT NULL,
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
  `is_active` tinyint NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `album_tracks`
--

INSERT INTO `album_tracks` (`id`, `album_id`, `track_number`, `track_title`, `songwriters`, `artists`, `producers`, `audio_file`, `is_explicit`, `isrc`, `total_streams`, `total_downloads`, `total_revenue`, `is_active`) VALUES
(1, 1, 1, 'Title 1', '', '', '', 'uploads/audio/BOYFRIEND(MUSIC_VIDEO)_KARAN_AUJLA_SUNANDA_IKKY_Latest_Punjabi_Songs_20251.mp3', 0, 'INABC2500001', 0, 0, 0.00, 0),
(2, 1, 2, 'Title 2', '', '', '', 'uploads/audio/BOYFRIEND(MUSIC_VIDEO)_KARAN_AUJLA_SUNANDA_IKKY_Latest_Punjabi_Songs_20252.mp3', 0, 'INABC2500002', 300, 30, 30.00, 0),
(21, 4, 1, 'Album Song 1', '', '', '', 'uploads/audio/1777451104_patw64-20-seconds-game-countdown-142456.mp3', 0, NULL, 0, 0, 0.00, 0),
(22, 4, 2, 'Album Song 2', '', '', '', 'uploads/audio/1777451105_freesound_community-2sec-40421.mp3', 0, NULL, 0, 0, 0.00, 0),
(23, 4, 3, 'Album Song 3', '', '', '', 'uploads/audio/1777451106_hindi-new-song.mp3', 0, NULL, 0, 0, 0.00, 0);

-- --------------------------------------------------------

--
-- Table structure for table `album_track_streaming_history`
--

CREATE TABLE `album_track_streaming_history` (
  `id` int NOT NULL,
  `track_id` int NOT NULL,
  `isrc` varchar(20) NOT NULL,
  `platform` enum('spotify','apple','youtube','amazon','gaana','jiosaavn') NOT NULL,
  `streams` bigint DEFAULT '0',
  `revenue` decimal(10,2) DEFAULT '0.00',
  `downloads` bigint NOT NULL DEFAULT '0',
  `report_month` date NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `assets` (
  `id` int NOT NULL,
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
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `assets`
--

INSERT INTO `assets` (`id`, `user_id`, `project_id`, `asset_name`, `asset_type`, `version`, `tags`, `credits`, `notes`, `file_path`, `file_size`, `created_at`) VALUES
(1, 5, 6, 'test work', 'Master Track', '', '', '', '', 'uploads/users-assets/1777468857_hindi-new-song.mp3', 6720000, '2026-04-29 13:21:02');

-- --------------------------------------------------------

--
-- Table structure for table `asset_projects`
--

CREATE TABLE `asset_projects` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `name` varchar(150) NOT NULL,
  `project_type` enum('song','album') DEFAULT 'song',
  `genre` varchar(100) DEFAULT NULL,
  `bpm` int DEFAULT NULL,
  `musical_key` varchar(50) DEFAULT NULL,
  `description` text,
  `status` enum('idea','draft','final') DEFAULT 'idea',
  `tags` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `asset_projects`
--

INSERT INTO `asset_projects` (`id`, `user_id`, `name`, `project_type`, `genre`, `bpm`, `musical_key`, `description`, `status`, `tags`, `created_at`) VALUES
(1, 1, 'Project 1', 'album', 'sd', 33, 'ss', '', 'idea', '', '2026-01-02 17:30:27'),
(2, 1, 'Test project 2', 'song', '', 0, '', '', 'idea', '', '2026-01-03 07:08:41'),
(3, 1, 'tt', 'song', '', 0, '', '', 'idea', '', '2026-01-03 07:31:03'),
(6, 5, 'Test Project', 'song', '', 0, '', '', 'idea', '', '2026-04-29 13:20:36');

-- --------------------------------------------------------

--
-- Table structure for table `genres`
--

CREATE TABLE `genres` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `languages` (
  `id` int NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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

CREATE TABLE `migrations` (
  `version` bigint NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `plans`
--

CREATE TABLE `plans` (
  `id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `duration` enum('daily','monthly','yearly') NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` enum('active','inactive') DEFAULT 'active'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plans`
--

INSERT INTO `plans` (`id`, `name`, `price`, `duration`, `created_at`, `status`) VALUES
(1, 'Rising Artists', '1399.00', 'yearly', '2026-04-06 23:13:44', 'active'),
(4, 'Bearkout Artists', '1599.00', 'yearly', '2026-04-06 23:21:07', 'active'),
(5, 'Professtional Artists', '2499.00', 'yearly', '2026-04-07 11:53:11', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `plan_features`
--

CREATE TABLE `plan_features` (
  `id` int NOT NULL,
  `plan_id` int NOT NULL,
  `feature_name` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `plan_features`
--

INSERT INTO `plan_features` (`id`, `plan_id`, `feature_name`, `created_at`) VALUES
(1, 2, 'feature 1', '2026-04-06 17:45:27'),
(2, 2, 'feature 2', '2026-04-06 17:45:27'),
(3, 2, 'feature 3', '2026-04-06 17:45:27'),
(4, 3, 'saxas', '2026-04-06 17:47:23'),
(5, 3, 'asxasx', '2026-04-06 17:47:23'),
(21, 4, 'test feature 2', '2026-04-07 11:52:42'),
(20, 4, 'test feature 1', '2026-04-07 11:52:42'),
(17, 1, 'feature 1', '2026-04-07 11:51:59'),
(18, 1, 'feature 2', '2026-04-07 11:51:59'),
(19, 1, 'feature 3', '2026-04-07 11:51:59'),
(22, 4, 'test feature 3', '2026-04-07 11:52:42'),
(23, 5, 'test feature 1', '2026-04-07 06:23:11'),
(24, 5, 'test feature 2', '2026-04-07 06:23:11'),
(25, 5, 'test feature 3', '2026-04-07 06:23:11');

-- --------------------------------------------------------

--
-- Table structure for table `releases`
--

CREATE TABLE `releases` (
  `id` int NOT NULL,
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
  `is_active` tinyint NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `releases`
--

INSERT INTO `releases` (`id`, `user_id`, `title`, `primary_artist`, `featuring`, `genre`, `subgenre`, `release_date`, `language`, `isrc`, `description`, `explicit_content`, `created_at`, `is_deleted`, `deleted_at`, `stream_count`, `revenue`, `download_count`, `is_active`) VALUES
(1, 2, 'Test Song', 'Dhanpreet', '', 'rock', 'alternative', '2025-12-18', 'hindi', 'INABC2500002', '', 'no', '2025-12-18 11:18:23', 0, NULL, 55500, '5550.00', 25100, 1),
(12, 5, 'Test Gagan', 'Gagan Arora', 'Simranjeet Singh, Diljit Singh', 'bollywood', '', '2026-04-29', 'hindi', '', 'Gagan Test Album Single', 'yes', '2026-04-29 10:16:19', 0, NULL, 0, '0.00', 0, 0),
(11, 5, 'test', 'Nisha', '', 'calm', 'indie', '2026-11-11', 'ukrainian', '', '', 'no', '2026-04-28 11:35:44', 1, '2026-04-28 11:44:42', 0, '0.00', 0, 0),
(10, 5, 'My Song ', 'Nisha', '', 'love', 'indie', '2025-11-11', 'russian', '', '', 'no', '2026-04-28 11:32:32', 0, NULL, 0, '0.00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `release_artwork`
--

CREATE TABLE `release_artwork` (
  `id` int NOT NULL,
  `release_id` int NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `template_id` int DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `release_artwork`
--

INSERT INTO `release_artwork` (`id`, `release_id`, `file_path`, `template_id`) VALUES
(1, 1, 'uploads/artwork/virk_logo.png', 1),
(15, 12, 'uploads/artwork/1777457778_Yrf_Romantic_Melodies_-_Instrumental.jpg', 1),
(13, 10, 'uploads/artwork/1777375944_santa-animation.gif', 2);

-- --------------------------------------------------------

--
-- Table structure for table `release_social`
--

CREATE TABLE `release_social` (
  `id` int NOT NULL,
  `release_id` int NOT NULL,
  `platform_key` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `release_social`
--

INSERT INTO `release_social` (`id`, `release_id`, `platform_key`) VALUES
(63, 12, 'twitter'),
(61, 12, 'instagram'),
(62, 12, 'facebook'),
(60, 12, 'youtube'),
(54, 10, 'youtube');

-- --------------------------------------------------------

--
-- Table structure for table `release_stores`
--

CREATE TABLE `release_stores` (
  `id` int NOT NULL,
  `release_id` int NOT NULL,
  `store_key` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
(495, 12, 'jiosaavn'),
(496, 12, 'snapchat'),
(497, 12, 'net-ease'),
(498, 12, 'joox'),
(499, 12, 'peloton'),
(500, 12, 'wnky'),
(494, 12, 'gaana'),
(493, 12, 'tiktok_music'),
(492, 12, 'youtube_music'),
(491, 12, 'boomplay'),
(490, 12, 'tidal'),
(489, 12, 'deezer'),
(488, 12, 'pandora'),
(487, 12, 'amazon_music'),
(486, 12, 'apple_music'),
(485, 12, 'spotify'),
(484, 12, 'i-tunes'),
(449, 10, 'wnky'),
(448, 10, 'peloton'),
(447, 10, 'joox'),
(446, 10, 'net-ease'),
(445, 10, 'snapchat'),
(444, 10, 'jiosaavn'),
(443, 10, 'gaana'),
(442, 10, 'tiktok_music'),
(441, 10, 'youtube_music'),
(440, 10, 'boomplay'),
(439, 10, 'tidal'),
(438, 10, 'deezer'),
(437, 10, 'pandora'),
(436, 10, 'amazon_music'),
(435, 10, 'apple_music'),
(434, 10, 'spotify'),
(433, 10, 'i-tunes');

-- --------------------------------------------------------

--
-- Table structure for table `sampling`
--

CREATE TABLE `sampling` (
  `id` bigint NOT NULL,
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
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sampling`
--

INSERT INTO `sampling` (`id`, `user_id`, `song_name`, `artist_name`, `artwork_path`, `audio_path`, `unique_slug`, `duration`, `total_plays`, `total_clicks`, `status`, `created_at`) VALUES
(1, 5, 'Love Song', 'Nisha', 'uploads/artwork/1777376029_santa-animation.gif', 'uploads/audio/1777376029_hindi-new-song.mp3', 'd0c48bbfb573', 0, 0, 1, 'active', '2026-04-28 11:33:52');

-- --------------------------------------------------------

--
-- Table structure for table `sampling_clicks`
--

CREATE TABLE `sampling_clicks` (
  `id` int NOT NULL,
  `sampling_id` int DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `clicked_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `sampling_clicks`
--

INSERT INTO `sampling_clicks` (`id`, `sampling_id`, `ip_address`, `user_agent`, `clicked_at`) VALUES
(1, 1, '106.219.66.244', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/147.0.0.0 Safari/537.36', '2026-04-28 11:34:01');

-- --------------------------------------------------------

--
-- Table structure for table `sampling_plays`
--

CREATE TABLE `sampling_plays` (
  `id` int NOT NULL,
  `sampling_id` int DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `played_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `streaming_clicks`
--

CREATE TABLE `streaming_clicks` (
  `id` int NOT NULL,
  `streaming_link_id` int NOT NULL,
  `track_id` int DEFAULT NULL,
  `clicked_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `streaming_links`
--

CREATE TABLE `streaming_links` (
  `id` int NOT NULL,
  `content_type` enum('single','album') NOT NULL,
  `content_id` int NOT NULL,
  `platform` varchar(50) NOT NULL,
  `url` varchar(500) NOT NULL,
  `is_active` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `streaming_upload_logs`
--

CREATE TABLE `streaming_upload_logs` (
  `id` int NOT NULL,
  `filename` varchar(255) DEFAULT NULL,
  `total_rows` int DEFAULT NULL,
  `success_rows` int DEFAULT NULL,
  `failed_rows` int DEFAULT NULL,
  `uploaded_by` int DEFAULT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_uploaded_files`
--

CREATE TABLE `tbl_uploaded_files` (
  `id` bigint NOT NULL,
  `file_url` text NOT NULL,
  `created_at` datetime NOT NULL,
  `audio_url` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tracks`
--

CREATE TABLE `tracks` (
  `id` int NOT NULL,
  `release_id` int NOT NULL,
  `title` varchar(255) NOT NULL,
  `audio_file` varchar(255) DEFAULT NULL,
  `lyrics` text,
  `lyrics_language` varchar(50) DEFAULT NULL,
  `explicit_lyrics` enum('yes','no') DEFAULT 'no',
  `tiktok_minutes` int DEFAULT '0',
  `tiktok_seconds` int DEFAULT '0',
  `crbt_clip_min` int DEFAULT '0',
  `crbt_clip_sec` int DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `tracks`
--

INSERT INTO `tracks` (`id`, `release_id`, `title`, `audio_file`, `lyrics`, `lyrics_language`, `explicit_lyrics`, `tiktok_minutes`, `tiktok_seconds`, `crbt_clip_min`, `crbt_clip_sec`) VALUES
(1, 1, 'Boyfriend', 'uploads/audio/BOYFRIEND(MUSIC_VIDEO)_KARAN_AUJLA_SUNANDA_IKKY_Latest_Punjabi_Songs_2025.mp3', '', NULL, NULL, 0, 0, 0, 0),
(10, 10, 'Nazar', 'uploads/audio/1777375844_hindi_song_1.mp3', '', NULL, NULL, 0, 0, 0, 0),
(12, 12, 'Saiyaara Kishore Kumar Version', 'uploads/audio/1777457684_Saiyaara_Tu_Toh_Badla_Nahin_Hai.mp3', '', NULL, NULL, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `track_artists`
--

CREATE TABLE `track_artists` (
  `id` int NOT NULL,
  `track_id` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `role` varchar(50) NOT NULL,
  `type` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'main'
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_artists`
--

INSERT INTO `track_artists` (`id`, `track_id`, `name`, `role`, `type`) VALUES
(1, 1, 'Dhanpreet', 'performer', 'performing'),
(18, 12, 'Tanishk Bagchi', 'composer', 'main'),
(13, 10, 'Nisha', 'lead', 'main'),
(14, 10, 'pa 1', 'performer', 'performing'),
(16, 12, 'Kishore Kumar', 'lead', 'main'),
(17, 12, 'Faheem Abdullah', 'composer', 'main'),
(19, 12, 'Faheem Abdullah', 'performer', 'performing'),
(20, 12, 'Arslan', 'performer', 'performing');

-- --------------------------------------------------------

--
-- Table structure for table `track_producers`
--

CREATE TABLE `track_producers` (
  `id` int NOT NULL,
  `track_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_producers`
--

INSERT INTO `track_producers` (`id`, `track_id`, `name`, `role`) VALUES
(1, 1, 'Dhanpreet', 'producer'),
(30, 12, 'Yash Raj Films', 'producer'),
(28, 10, 'producer 2', 'producer');

-- --------------------------------------------------------

--
-- Table structure for table `track_songwriters`
--

CREATE TABLE `track_songwriters` (
  `id` int NOT NULL,
  `track_id` int NOT NULL,
  `name` varchar(255) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_songwriters`
--

INSERT INTO `track_songwriters` (`id`, `track_id`, `name`) VALUES
(1, 1, 'Karan'),
(31, 12, 'Tanishk Bagchi'),
(30, 12, 'Faheem Abdullah'),
(28, 10, 'Nisha'),
(32, 12, 'Arslan');

-- --------------------------------------------------------

--
-- Table structure for table `track_streaming_history`
--

CREATE TABLE `track_streaming_history` (
  `id` int NOT NULL,
  `track_id` int NOT NULL,
  `isrc` varchar(20) NOT NULL,
  `platform` enum('spotify','apple','youtube','amazon','gaana','jiosaavn') NOT NULL,
  `streams` bigint DEFAULT '0',
  `revenue` decimal(10,2) DEFAULT '0.00',
  `downloads` bigint NOT NULL DEFAULT '0',
  `report_month` date NOT NULL,
  `uploaded_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `track_streaming_history`
--

INSERT INTO `track_streaming_history` (`id`, `track_id`, `isrc`, `platform`, `streams`, `revenue`, `downloads`, `report_month`, `uploaded_at`) VALUES
(13, 1, 'INABC2500002', 'spotify', 12000, '1000.00', 5000, '2025-01-01', '2026-01-03 07:19:02'),
(14, 1, 'INABC2500002', 'apple', 15000, '1500.00', 7000, '2025-01-01', '2026-01-03 07:19:02'),
(15, 1, 'INABC2500002', 'spotify', 12500, '1500.00', 5600, '2025-02-01', '2026-01-03 07:26:41'),
(16, 1, 'INABC2500002', 'apple', 16000, '1550.00', 7500, '2025-02-01', '2026-01-03 07:26:41');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(191) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime NOT NULL,
  `updated_at` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Nisha Vaish', 'vaish.nisha55@gmail.com', '$2y$10$hkc5MuPH91jwLfFvUvZ2MenfZJ5eJnajIxnVhw2HcvJhLmIfH4poG', 1, '2025-12-13 17:25:06', '2026-02-06 08:59:08'),
(2, 'Dhanpreet', 'dhanpreet02@gmail.com', '$2y$10$vXzg5amRzG0FGSjqD7.LSeWfIb7ICTP/ez7LY8N/BfDjlEaCG2o9O', 1, '2025-12-18 11:16:22', '2026-04-11 11:50:23'),
(3, 'Test', 'Test@gmail.com', '$2y$10$P8c7/qPX63I6icE1GxJzre1TDsySrQRfk6YNO9QA18wVvGklvlk/i', 1, '2025-12-21 18:35:01', '2026-01-07 06:25:18'),
(4, 'Kartik', 'guptakartik606@gmail.com', '$2y$10$P8c7/qPX63I6icE1GxJzre1TDsySrQRfk6YNO9QA18wVvGklvlk/i', 1, '2026-01-03 07:54:18', '2026-02-06 14:36:35'),
(5, 'Nisha Vaish', 'vaish.nisha73@gmail.com', '$2y$10$41yy9vtcyYjo2C9yDqILKurhLnrQbyA.Qi.ZmE2F9lgktmgpMz9LO', 1, '2026-02-06 14:15:58', '2026-04-30 05:13:05'),
(6, 'vskofwmjtr', 'gdqhmemp@immenseignite.info', '$2y$10$Mcobp/cjYLmbJJPd420nZ.UrL9DeekJFRH.j.qfMSuVK9HMC2u3We', 1, '2026-04-23 01:43:54', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_bank_details`
--

CREATE TABLE `user_bank_details` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `account_name` varchar(255) DEFAULT NULL,
  `account_number` varchar(50) DEFAULT NULL,
  `ifsc` varchar(20) DEFAULT NULL,
  `bank_name` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_invoices`
--

CREATE TABLE `user_invoices` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `title` varchar(255) DEFAULT NULL,
  `invoice_month` varchar(7) NOT NULL,
  `status` enum('pending','approved','paid') NOT NULL DEFAULT 'pending',
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `user_invoices`
--

INSERT INTO `user_invoices` (`id`, `user_id`, `title`, `invoice_month`, `status`, `file_path`, `created_at`) VALUES
(3, 5, 'xscasc', '2025-10', 'pending', 'uploads/invoices/1777377807_city-run--lang.png', '2026-04-28 12:03:34');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `albums`
--
ALTER TABLE `albums`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `album_social`
--
ALTER TABLE `album_social`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `album_stores`
--
ALTER TABLE `album_stores`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `album_tracks`
--
ALTER TABLE `album_tracks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `album_track_streaming_history`
--
ALTER TABLE `album_track_streaming_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `isrc` (`isrc`),
  ADD KEY `report_month` (`report_month`);

--
-- Indexes for table `assets`
--
ALTER TABLE `assets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `asset_projects`
--
ALTER TABLE `asset_projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plans`
--
ALTER TABLE `plans`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `plan_features`
--
ALTER TABLE `plan_features`
  ADD PRIMARY KEY (`id`),
  ADD KEY `plan_id` (`plan_id`);

--
-- Indexes for table `releases`
--
ALTER TABLE `releases`
  ADD PRIMARY KEY (`id`),
  ADD KEY `is_deleted` (`is_deleted`);

--
-- Indexes for table `release_artwork`
--
ALTER TABLE `release_artwork`
  ADD PRIMARY KEY (`id`),
  ADD KEY `release_id` (`release_id`);

--
-- Indexes for table `release_social`
--
ALTER TABLE `release_social`
  ADD PRIMARY KEY (`id`),
  ADD KEY `release_id` (`release_id`);

--
-- Indexes for table `release_stores`
--
ALTER TABLE `release_stores`
  ADD PRIMARY KEY (`id`),
  ADD KEY `release_id` (`release_id`);

--
-- Indexes for table `sampling`
--
ALTER TABLE `sampling`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_slug` (`unique_slug`);

--
-- Indexes for table `sampling_clicks`
--
ALTER TABLE `sampling_clicks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sampling_plays`
--
ALTER TABLE `sampling_plays`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `streaming_clicks`
--
ALTER TABLE `streaming_clicks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `streaming_links`
--
ALTER TABLE `streaming_links`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `streaming_upload_logs`
--
ALTER TABLE `streaming_upload_logs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_uploaded_files`
--
ALTER TABLE `tbl_uploaded_files`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tracks`
--
ALTER TABLE `tracks`
  ADD PRIMARY KEY (`id`),
  ADD KEY `release_id` (`release_id`);

--
-- Indexes for table `track_artists`
--
ALTER TABLE `track_artists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `track_id` (`track_id`);

--
-- Indexes for table `track_producers`
--
ALTER TABLE `track_producers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `track_id` (`track_id`);

--
-- Indexes for table `track_songwriters`
--
ALTER TABLE `track_songwriters`
  ADD PRIMARY KEY (`id`),
  ADD KEY `track_id` (`track_id`);

--
-- Indexes for table `track_streaming_history`
--
ALTER TABLE `track_streaming_history`
  ADD PRIMARY KEY (`id`),
  ADD KEY `isrc` (`isrc`),
  ADD KEY `report_month` (`report_month`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email_unique` (`email`);

--
-- Indexes for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `user_id` (`user_id`);

--
-- Indexes for table `user_invoices`
--
ALTER TABLE `user_invoices`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `albums`
--
ALTER TABLE `albums`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `album_social`
--
ALTER TABLE `album_social`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `album_stores`
--
ALTER TABLE `album_stores`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `album_tracks`
--
ALTER TABLE `album_tracks`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `album_track_streaming_history`
--
ALTER TABLE `album_track_streaming_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `assets`
--
ALTER TABLE `assets`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `asset_projects`
--
ALTER TABLE `asset_projects`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `genres`
--
ALTER TABLE `genres`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `plans`
--
ALTER TABLE `plans`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `plan_features`
--
ALTER TABLE `plan_features`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `releases`
--
ALTER TABLE `releases`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `release_artwork`
--
ALTER TABLE `release_artwork`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `release_social`
--
ALTER TABLE `release_social`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;

--
-- AUTO_INCREMENT for table `release_stores`
--
ALTER TABLE `release_stores`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=501;

--
-- AUTO_INCREMENT for table `sampling`
--
ALTER TABLE `sampling`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sampling_clicks`
--
ALTER TABLE `sampling_clicks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `sampling_plays`
--
ALTER TABLE `sampling_plays`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `streaming_clicks`
--
ALTER TABLE `streaming_clicks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `streaming_links`
--
ALTER TABLE `streaming_links`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `streaming_upload_logs`
--
ALTER TABLE `streaming_upload_logs`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_uploaded_files`
--
ALTER TABLE `tbl_uploaded_files`
  MODIFY `id` bigint NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tracks`
--
ALTER TABLE `tracks`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `track_artists`
--
ALTER TABLE `track_artists`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `track_producers`
--
ALTER TABLE `track_producers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `track_songwriters`
--
ALTER TABLE `track_songwriters`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `track_streaming_history`
--
ALTER TABLE `track_streaming_history`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_bank_details`
--
ALTER TABLE `user_bank_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_invoices`
--
ALTER TABLE `user_invoices`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
