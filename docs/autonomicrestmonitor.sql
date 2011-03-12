-- phpMyAdmin SQL Dump
-- version 3.3.9
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 12, 2011 at 07:38 PM
-- Server version: 5.1.44
-- PHP Version: 5.3.2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `autonomicrestmonitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `Request`
--

CREATE TABLE `Request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `responseTime` float NOT NULL DEFAULT '0',
  `id_RequestType` int(11) NOT NULL,
  `id_Site` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_RequestType` (`id_RequestType`),
  KEY `id_Site` (`id_Site`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=17 ;

-- --------------------------------------------------------

--
-- Table structure for table `RequestType`
--

CREATE TABLE `RequestType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE `Role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(16) DEFAULT NULL,
  `canAddUser` int(11) DEFAULT NULL,
  `canDeleteUser` int(11) DEFAULT NULL,
  `canEditUser` int(11) DEFAULT NULL,
  `canAddRole` int(11) DEFAULT NULL,
  `canDeleteRole` int(11) DEFAULT NULL,
  `canEditRole` int(11) DEFAULT NULL,
  `canAddServer` int(11) DEFAULT NULL,
  `canDeleteServer` int(11) DEFAULT NULL,
  `canEditServer` int(11) DEFAULT NULL,
  `userLimit` int(11) DEFAULT NULL,
  `roleLimit` int(11) DEFAULT NULL,
  `serverLimit` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

-- --------------------------------------------------------

--
-- Table structure for table `Site`
--

CREATE TABLE `Site` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(64) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `id_User` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_User` (`id_User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=5 ;

-- --------------------------------------------------------

--
-- Table structure for table `User`
--

CREATE TABLE `User` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(16) DEFAULT NULL,
  `password` varchar(40) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `id_Role` int(11) DEFAULT NULL,
  `id_User` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `id_Role` (`id_Role`),
  KEY `id_User` (`id_User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=14 ;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Request`
--
ALTER TABLE `Request`
  ADD CONSTRAINT `Request_ibfk_5` FOREIGN KEY (`id_RequestType`) REFERENCES `RequestType` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `Request_ibfk_6` FOREIGN KEY (`id_Site`) REFERENCES `Site` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `Site`
--
ALTER TABLE `Site`
  ADD CONSTRAINT `Site_ibfk_1` FOREIGN KEY (`id_User`) REFERENCES `User` (`id`) ON UPDATE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`id_Role`) REFERENCES `Role` (`id`);
