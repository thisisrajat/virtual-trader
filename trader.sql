-- phpMyAdmin SQL Dump
-- version 3.5.2.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Jun 25, 2014 at 07:34 PM
-- Server version: 5.5.27
-- PHP Version: 5.4.7

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `trader`
--

-- --------------------------------------------------------

--
-- Table structure for table `archive`
--

CREATE TABLE IF NOT EXISTS `archive` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `price` decimal(65,4) NOT NULL,
  `number_of_share` int(11) NOT NULL,
  `time` int(11) NOT NULL,
  `transaction` varchar(4) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE IF NOT EXISTS `cache` (
  `symbol` varchar(255) NOT NULL,
  `price` decimal(65,4) NOT NULL,
  PRIMARY KEY (`symbol`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`symbol`, `price`) VALUES
('AAPL', 90.1900),
('AIR', 27.3500),
('BA', 132.1000),
('FB', 64.6400),
('GOOG', 571.7500),
('GRPN', 6.1500),
('IBM', 181.5500),
('MJNA', 0.2180),
('MSFT', 110.0000),
('NFLX', 440.1800),
('OIL', 25.9100),
('X', 25.4200),
('XOM', 103.8300);

-- --------------------------------------------------------

--
-- Table structure for table `portfolio`
--

CREATE TABLE IF NOT EXISTS `portfolio` (
  `username` varchar(255) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `name_of_company` varchar(255) NOT NULL,
  `number_of_share` int(11) NOT NULL,
  `price` decimal(65,4) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY (`username`,`symbol`),
  KEY `symbol` (`symbol`),
  KEY `symbol_2` (`symbol`),
  KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `displayname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `cash` decimal(65,4) NOT NULL,
  `apparent_cash` decimal(65,4) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username` (`username`,`password`),
  KEY `username_2` (`username`,`password`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
