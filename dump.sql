-- phpMyAdmin SQL Dump
-- version 4.0.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 21, 2014 at 10:30 PM
-- Server version: 5.5.16-log
-- PHP Version: 5.3.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `scrapedcourse`
--
CREATE DATABASE IF NOT EXISTS `scrapedcourse` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `scrapedcourse`;

-- --------------------------------------------------------

--
-- Table structure for table `coursedetails`
--

CREATE TABLE IF NOT EXISTS `coursedetails` (
  `id` int(4) NOT NULL,
  `profname` varchar(30) NOT NULL,
  `profimage` text NOT NULL,
  `course_id` int(5) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `course_data`
--

CREATE TABLE IF NOT EXISTS `course_data` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` text NOT NULL,
  `short_desc` text NOT NULL,
  `long_desc` text NOT NULL,
  `course_link` text NOT NULL,
  `video_link` text NOT NULL,
  `start_date` date NOT NULL,
  `course_length` int(11) NOT NULL,
  `course_image` text NOT NULL,
  `category` varchar(100) NOT NULL,
  `site` text NOT NULL,
  `course_fee` int(11) NOT NULL,
  `language` text NOT NULL,
  `certificate` enum('yes','no') NOT NULL,
  `university` text NOT NULL,
  `time_scraped` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `coursedetails`
--
ALTER TABLE `coursedetails`
  ADD CONSTRAINT `coursedetails_ibfk_1` FOREIGN KEY (`course_id`) REFERENCES `course_data` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

