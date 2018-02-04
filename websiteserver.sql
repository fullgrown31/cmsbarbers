-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2017 at 12:45 PM
-- Server version: 10.1.26-MariaDB
-- PHP Version: 7.1.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `websiteserver`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `user_id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `hash` varchar(500) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `avatar` varchar(100) DEFAULT NULL,
  `bio` varchar(300) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`user_id`, `username`, `password`, `hash`, `email`, `avatar`, `bio`) VALUES
(1, 'gabe', 'briones', '$1$1Lb0XmTz$TSRwH.1L9h/rqyp93rkwg/', 'lel@lel.com', 'Dapper-Haircuts-Low-Skin-Fade-with-Quiff.jpg', 'hellosss'),
(2, 'admin', 'password', '$1$.Q4t0Nil$pdexsQ0CbCNTLp94kzS5X.', 'admin@website.com', 'mens-crew-cut-hairstyle.jpg', 'heyy'),
(9, 'earl', 'earl', '$1$RCTMwQ7c$g9we0cYE2RREyUSPOeZ8B0', 'earlpascual@gmail.com', '10-mens-medium-blonde-hairstyle.jpg', 'early');

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `user_id` int(100) NOT NULL,
  `client_id` int(30) NOT NULL,
  `appointment_time` varchar(100) NOT NULL,
  `specifics` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `clients`
--

CREATE TABLE `clients` (
  `client_id` int(11) NOT NULL,
  `username` varchar(30) DEFAULT NULL,
  `password` varchar(30) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `hash` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `clients`
--

INSERT INTO `clients` (`client_id`, `username`, `password`, `email`, `hash`) VALUES
(19, 'early', 'earl', 'earl', '$1$R0vpD4VY$q5OoIjQPHFafEBwpVm2ta1'),
(20, 'dwight', 'mopas', 'dwight@gmails.com', '$1$x9wwXlMS$OEAx6r6LRZsBjLGisimxJ0'),
(21, 'earl', 'earle', 'earleee', '$1$UO55/h1E$N6gk0DwCPDRe.Kla1F59s.'),
(22, 'boi', 'boi', 'boi', '$1$CQRFo5S9$RBOGntKJbuJiG5crU2bkB0');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `client_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `comment_id` int(11) NOT NULL,
  `comment` varchar(300) DEFAULT NULL,
  `post_id` int(11) DEFAULT NULL,
  `name` varchar(30) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`client_id`, `user_id`, `comment_id`, `comment`, `post_id`, `name`, `postdate`) VALUES
(NULL, NULL, 53, 'not bad', 35, 'lol', '2017-11-20 06:33:53'),
(NULL, NULL, 54, 'heleloooo', 35, 'hello', '2017-11-20 06:34:36'),
(NULL, NULL, 55, 'grrr', 35, 'grrr', '2017-11-20 06:35:00'),
(NULL, NULL, 56, 'aa', 35, 'asdasd', '2017-11-20 06:35:55'),
(NULL, NULL, 57, 'sss', 35, 'sss', '2017-11-20 06:36:09'),
(NULL, NULL, 58, 'wut', 29, 'bald fade?', '2017-11-20 07:00:15'),
(NULL, NULL, 63, 'lol', 42, 'lol', '2017-11-20 08:45:13'),
(NULL, NULL, 64, 'yayyyyy', 29, 'Yayy', '2017-11-20 08:48:43'),
(NULL, NULL, 70, 'asdasdads', 29, 'asasdasd', '2017-11-20 09:04:48'),
(NULL, NULL, 74, 'wre', 42, 'ewrw', '2017-11-20 09:06:22'),
(NULL, NULL, 85, 'fdfd', 38, 'erer', '2017-11-20 09:48:11'),
(NULL, NULL, 86, '4trtrt', 38, '4rt4t', '2017-11-20 09:48:44'),
(NULL, NULL, 88, 'ccc', 38, 'scs', '2017-11-20 09:49:28'),
(NULL, NULL, 90, 'ffff', 38, 'ffff', '2017-11-20 09:51:03'),
(NULL, NULL, 91, 'ff', 42, 'ewf', '2017-11-20 09:52:32'),
(NULL, NULL, 92, 'rrrrrr', 42, 'rrrrrrr', '2017-11-20 09:52:38'),
(NULL, NULL, 93, 'sdsds', NULL, 'sdsd', '2017-11-20 09:54:37'),
(NULL, NULL, 94, 'sdsds', NULL, 'sdsd', '2017-11-20 09:54:37'),
(NULL, NULL, 95, 'sddd', NULL, 'sdsd', '2017-11-20 09:54:41'),
(NULL, NULL, 96, 'sddd', NULL, 'sdsd', '2017-11-20 09:54:41'),
(NULL, NULL, 97, 'ffff', 42, 'f', '2017-11-20 09:55:33'),
(NULL, NULL, 98, 'ffff', 42, 'f', '2017-11-20 09:55:33'),
(NULL, NULL, 99, 'eee', 42, 'eee', '2017-11-20 09:55:38'),
(NULL, NULL, 100, 'eee', 42, 'eee', '2017-11-20 09:55:38'),
(NULL, NULL, 107, '3333', 29, 'eeee3333', '2017-11-20 09:56:29'),
(NULL, NULL, 108, '3333', 29, 'eeee3333', '2017-11-20 09:56:29'),
(NULL, NULL, 109, 'rgrg', 38, 'rgrg', '2017-11-20 10:15:10'),
(NULL, NULL, 110, 'rgrg', 38, 'rgrg', '2017-11-20 10:15:10'),
(NULL, NULL, 111, 'world', 37, 'Hello', '2017-11-20 18:29:41'),
(NULL, NULL, 112, 'world', 37, 'Hello', '2017-11-20 18:29:41');

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(50) DEFAULT NULL,
  `content` varchar(1000) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `postdate` datetime DEFAULT NULL,
  `updatedate` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `content`, `image`, `user_id`, `postdate`, `updatedate`) VALUES
(29, 'Bald Fade', 'bald fading', 'swisshairbyzainal-long-curly-hairstyle-for-men.jpg', 1, '2017-11-20 04:27:40', '2017-11-20 06:22:26'),
(35, 'Side Swepts', 'side swept', 'short-smart-mens-side-parting.jpg', 1, '2017-11-20 06:12:05', '2017-11-20 06:22:04'),
(36, 'Crew Cut', 'le crew cut', 'mens-crew-cut-hairstyle.jpg', 1, '2017-11-20 08:21:21', NULL),
(37, 'Pompadour', 'le pompadour', 'pompadour-fade-black-hair.jpg', 1, '2017-11-20 08:24:21', NULL),
(38, 'French Crop', 'le french crop', 'mens-short-french-crop.jpg', 1, '2017-11-20 08:24:51', NULL),
(40, 'Dat Fade Doee', 'le fade', 'taper-fade-black-hair-men.jpg', 1, '2017-11-20 08:26:55', '2017-11-20 10:03:49'),
(42, 'Buzz Cut', 'The buzz', 'jake-gyllenhaal-buzz-cut.jpg', 2, '2017-11-20 08:44:38', NULL),
(46, 'bald', 'le classic', 'bald-fade-haircut-men.jpg', 1, '2017-11-27 06:07:45', NULL),
(48, 'fade', 'lol', 'Cool-Trendy-Haircuts-Bald-Fade-with-Shape-Up-and-Spiky-Hair.jpg', 1, '2017-11-27 08:04:39', NULL),
(49, 'fade again', 'lel', 'Dapper-Haircuts-Low-Skin-Fade-with-Quiff.jpg', 1, '2017-11-27 08:05:04', NULL),
(57, 'Eurocut', 'lol', 'cut.png', 1, '2017-12-03 09:38:48', NULL),
(59, 'undercut', 'undercutting the cut yenno', 'man-with-an-undercut-fade-hairstyle.jpg', 1, '2017-12-03 09:46:45', NULL),
(60, 'Lowcut', 'cut', 'taper-fade-black-hair-men.jpg', 1, '2017-12-03 10:00:39', NULL),
(63, 'fade', 'side swept', 'Cool-Trendy-Haircuts-Bald-Fade-with-Shape-Up-and-Spiky-Hair.jpg', 1, '2017-12-03 10:20:00', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `client_id_fk` (`client_id`) USING BTREE,
  ADD KEY `user_id_fk` (`user_id`) USING BTREE;

--
-- Indexes for table `clients`
--
ALTER TABLE `clients`
  ADD PRIMARY KEY (`client_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`comment_id`),
  ADD KEY `user_id_fk` (`user_id`),
  ADD KEY `client_id_fk` (`client_id`),
  ADD KEY `post_id_fk` (`post_id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `clients`
--
ALTER TABLE `clients`
  MODIFY `client_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `comment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;
--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=64;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `clientidfk` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`),
  ADD CONSTRAINT `useridfk` FOREIGN KEY (`user_id`) REFERENCES `admin` (`user_id`);

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `client_id_fk` FOREIGN KEY (`client_id`) REFERENCES `clients` (`client_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `post_id_fk` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`),
  ADD CONSTRAINT `user_id_fk` FOREIGN KEY (`user_id`) REFERENCES `admin` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `posts`
--
ALTER TABLE `posts`
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `admin` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
