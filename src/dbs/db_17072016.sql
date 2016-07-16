-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jul 17, 2016 at 02:51 AM
-- Server version: 5.5.49-0ubuntu0.14.04.1
-- PHP Version: 5.5.9-1ubuntu4.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `travel2`
--

-- --------------------------------------------------------

--
-- Table structure for table `amenities`
--

CREATE TABLE IF NOT EXISTS `amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(128) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `departure`
--

CREATE TABLE IF NOT EXISTS `departure` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `at` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `geography`
--

CREATE TABLE IF NOT EXISTS `geography` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `id_at_provider` int(11) NOT NULL,
  `parent_id` int(11) NOT NULL DEFAULT '0',
  `name` varchar(255) DEFAULT NULL,
  `int_name` varchar(255) DEFAULT NULL,
  `child_label` varchar(16) DEFAULT NULL,
  `description` varchar(128) DEFAULT NULL,
  `min_val` decimal(10,10) DEFAULT NULL,
  `max_val` decimal(10,10) DEFAULT NULL,
  `tree_level` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_id` (`provider_id`),
  KEY `parent_id` (`parent_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2721 ;

-- --------------------------------------------------------

--
-- Table structure for table `hotel`
--

CREATE TABLE IF NOT EXISTS `hotel` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `id_at_provider` int(11) NOT NULL,
  `source` varchar(16) DEFAULT NULL,
  `source_id` int(11) DEFAULT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(255) NOT NULL,
  `stars` int(11) NOT NULL,
  `description` text,
  `address` varchar(255) DEFAULT NULL,
  `zip` varchar(16) DEFAULT NULL,
  `phone` varchar(32) DEFAULT NULL,
  `fax` varchar(32) DEFAULT NULL,
  `location` int(11) NOT NULL,
  `url` varchar(255) DEFAULT NULL,
  `latitude` double DEFAULT NULL,
  `longitude` double DEFAULT NULL,
  `extra_class` int(11) DEFAULT NULL,
  `use_individually` tinyint(1) NOT NULL DEFAULT '0',
  `use_on_packages` tinyint(1) NOT NULL DEFAULT '0',
  `property_type` varchar(32) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `provider_id` (`provider_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1880 ;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_amenities`
--

CREATE TABLE IF NOT EXISTS `hotel_amenities` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hotel_id` int(11) NOT NULL,
  `amenity_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_detailed_description`
--

CREATE TABLE IF NOT EXISTS `hotel_detailed_description` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `label` varchar(128) NOT NULL,
  `text` text,
  `desc_index` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4782 ;

-- --------------------------------------------------------

--
-- Table structure for table `hotel_room_category`
--

CREATE TABLE IF NOT EXISTS `hotel_room_category` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_at_provider` int(11) NOT NULL,
  `hotel_id` int(11) NOT NULL,
  `name` varchar(128) NOT NULL,
  `description` varchar(512) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `hotel_id` (`hotel_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6709 ;

-- --------------------------------------------------------

--
-- Table structure for table `meal_type`
--

CREATE TABLE IF NOT EXISTS `meal_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `package`
--

CREATE TABLE IF NOT EXISTS `package` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `provider_id` int(11) NOT NULL,
  `id_at_provider` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `is_tour` tinyint(1) NOT NULL,
  `is_bus` tinyint(1) NOT NULL,
  `is_flight` tinyint(1) NOT NULL,
  `duration` int(11) DEFAULT NULL,
  `outbound_transport_duration` int(11) NOT NULL,
  `description` longtext COLLATE utf8_unicode_ci,
  `destination_id` int(11) NOT NULL,
  `included_services` longtext COLLATE utf8_unicode_ci,
  `not_included_services` longtext COLLATE utf8_unicode_ci,
  `hotel_id` int(11) NOT NULL,
  `hotel_source_id` int(11) DEFAULT NULL,
  `currency_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `price_set`
--

CREATE TABLE IF NOT EXISTS `price_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_at_provider` int(11) NOT NULL,
  `package_id` int(11) NOT NULL,
  `label` varchar(128) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `valid_from` datetime DEFAULT NULL,
  `valid_to` datetime DEFAULT NULL,
  `travel_from` datetime DEFAULT NULL,
  `travel_to` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `provider`
--

CREATE TABLE IF NOT EXISTS `provider` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) NOT NULL,
  `ident` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
