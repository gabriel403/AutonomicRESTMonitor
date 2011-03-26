-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2011 at 07:00 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.5

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `autonomicrestmonitor`
--

-- --------------------------------------------------------

--
-- Table structure for table `Request`
--

DROP TABLE IF EXISTS `Request`;
DROP TABLE IF EXISTS `SiteRequestType`;
DROP TABLE IF EXISTS `RequestType`;
DROP TABLE IF EXISTS `Site`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Role`;

CREATE TABLE `Request` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `startTime` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `responseTime` float NOT NULL DEFAULT '0',
  `id_RequestType` int(11) NOT NULL,
  `id_Site` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_RequestType` (`id_RequestType`),
  KEY `id_Site` (`id_Site`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Request`
--


-- --------------------------------------------------------

--
-- Table structure for table `RequestType`
--

CREATE TABLE `RequestType` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(64) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Dumping data for table `RequestType`
--

INSERT INTO `RequestType` (`id`, `type`) VALUES
(1, 'Ping'),
(2, 'Head');

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`id`, `name`, `canAddUser`, `canDeleteUser`, `canEditUser`, `canAddRole`, `canDeleteRole`, `canEditRole`, `canAddServer`, `canDeleteServer`, `canEditServer`, `userLimit`, `roleLimit`, `serverLimit`) VALUES
(1, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, -1, -1);

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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Site`
--


-- --------------------------------------------------------

--
-- Table structure for table `SiteRequestType`
--

CREATE TABLE `SiteRequestType` (
  `id_Site` int(11) NOT NULL,
  `id_Requesttype` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_Site`,`id_Requesttype`),
  KEY `id_Requesttype` (`id_Requesttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SiteRequestType`
--


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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `User`
--

INSERT INTO `User` (`id`, `username`, `password`, `active`, `id_Role`, `id_User`) VALUES
(1, 'admin', '8e3f2c4bac633c59504716c22ecf680195ebe76f', 1, 1, 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `Request`
--
ALTER TABLE `Request`
  ADD CONSTRAINT `Request_ibfk_8` FOREIGN KEY (`id_Site`) REFERENCES `Site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `Request_ibfk_7` FOREIGN KEY (`id_RequestType`) REFERENCES `RequestType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `Site`
--
ALTER TABLE `Site`
  ADD CONSTRAINT `Site_ibfk_1` FOREIGN KEY (`id_User`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `SiteRequestType`
--
ALTER TABLE `SiteRequestType`
  ADD CONSTRAINT `SiteRequestType_ibfk_5` FOREIGN KEY (`id_Site`) REFERENCES `Site` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `SiteRequestType_ibfk_4` FOREIGN KEY (`id_Requesttype`) REFERENCES `RequestType` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `User`
--
ALTER TABLE `User`
  ADD CONSTRAINT `User_ibfk_2` FOREIGN KEY (`id_User`) REFERENCES `User` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `User_ibfk_1` FOREIGN KEY (`id_Role`) REFERENCES `Role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
