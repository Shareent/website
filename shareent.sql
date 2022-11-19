-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 19, 2022 at 11:00 AM
-- Server version: 5.7.26
-- PHP Version: 7.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `shareent`
--

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

DROP TABLE IF EXISTS `profile`;
CREATE TABLE IF NOT EXISTS `profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `addr` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user_id`, `fname`, `lname`, `phone`, `addr`) VALUES
(1, '10d2610d466a37d22ee041feb0978c00', 'Simon', 'Ugorji', '08162273445', '66B immaculate Ave');

-- --------------------------------------------------------

--
-- Table structure for table `spaces`
--

DROP TABLE IF EXISTS `spaces`;
CREATE TABLE IF NOT EXISTS `spaces` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(100) NOT NULL,
  `space_name` varchar(50) NOT NULL,
  `space_img` varchar(100) DEFAULT NULL,
  `space_addr` varchar(100) NOT NULL,
  `space_type` varchar(50) NOT NULL,
  `space_price` varchar(50) NOT NULL,
  `space_desc` varchar(100) NOT NULL,
  `space_cac` varchar(500) DEFAULT NULL,
  `is_verified` varchar(5) NOT NULL DEFAULT 'no',
  `date_added` varchar(20) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `spaces`
--

INSERT INTO `spaces` (`id`, `user_id`, `space_name`, `space_img`, `space_addr`, `space_type`, `space_price`, `space_desc`, `space_cac`, `is_verified`, `date_added`) VALUES
(4, '10d2610d466a37d22ee041feb0978c00', 'Ssss', NULL, 'sssssssss', 'house', '111333333333', 'sssssssssss', NULL, 'no', '1668843158'),
(5, '10d2610d466a37d22ee041feb0978c00', 'Ighub Workspace', NULL, 'seseee', 'house', '5000', 'seseseseee', NULL, 'no', '1668855063'),
(6, '10d2610d466a37d22ee041feb0978c00', 'Ighub Workspacess', NULL, 'sssss', 'land', '5000', 'sssss', NULL, 'no', '1668855107');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `acc_type` varchar(20) NOT NULL DEFAULT 'buyer',
  `email` varchar(50) NOT NULL,
  `hash` varchar(500) NOT NULL,
  `date_joined` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `user_id`, `acc_type`, `email`, `hash`, `date_joined`) VALUES
(1, '10d2610d466a37d22ee041feb0978c00', 'agent', 'samanosuske@outlook.com', '$2y$10$BK31ImDEzWGjkvcB/2yI7OMB7GIKjOSI1cn3QLLM13M0Cehep0WXi', '');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
