-- phpMyAdmin SQL Dump
-- version 3.4.5
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jun 16, 2012 at 03:04 AM
-- Server version: 5.5.16
-- PHP Version: 5.3.8

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `popis`
--

-- --------------------------------------------------------

--
-- Table structure for table `domacin`
--

CREATE TABLE IF NOT EXISTS `domacin` (
  `id` int(11) NOT NULL,
  `ime` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `domacin`
--

INSERT INTO `domacin` (`id`, `ime`) VALUES
(1, 'StranaA'),
(2, 'StranaB');

-- --------------------------------------------------------

--
-- Table structure for table `gost`
--

CREATE TABLE IF NOT EXISTS `gost` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ime` varchar(30) DEFAULT NULL,
  `prezime` varchar(30) NOT NULL,
  `grupa_id` int(11) DEFAULT NULL,
  `domacin_id` int(11) DEFAULT NULL,
  `dosao` tinyint(1) NOT NULL DEFAULT '0',
  `dar_bam` decimal(8,2) NOT NULL DEFAULT '0.00',
  `dar_eur` decimal(8,2) NOT NULL DEFAULT '0.00',
  `dar_hrk` decimal(8,2) NOT NULL DEFAULT '0.00',
  `komentar` text,
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `tstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `grupa_id` (`grupa_id`),
  KEY `domacin_id` (`domacin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

-- --------------------------------------------------------

--
-- Table structure for table `grupa`
--

CREATE TABLE IF NOT EXISTS `grupa` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `naziv` varchar(30) NOT NULL,
  `stol_id` int(11) DEFAULT NULL,
  `defaultna` tinyint(1) NOT NULL DEFAULT '0',
  `deleted` tinyint(1) NOT NULL DEFAULT '0',
  `tstamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=28 ;

--
-- Dumping data for table `grupa`
--

INSERT INTO `grupa` (`id`, `naziv`, `stol_id`, `defaultna`, `deleted`, `tstamp`) VALUES
(1, 'Nesortirano', NULL, 1, 0, '0000-00-00 00:00:00');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `gost`
--
ALTER TABLE `gost`
  ADD CONSTRAINT `gost_ibfk_1` FOREIGN KEY (`grupa_id`) REFERENCES `grupa` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `gost_ibfk_2` FOREIGN KEY (`domacin_id`) REFERENCES `domacin` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
