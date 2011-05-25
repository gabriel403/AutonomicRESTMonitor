-- phpMyAdmin SQL Dump
-- version 3.3.9.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Mar 20, 2011 at 07:00 PM
-- Server version: 5.5.9
-- PHP Version: 5.3.5




SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";




CREATE USER 'autonomicrestmon'@'localhost' IDENTIFIED BY  'autonomicrestmonitor';
CREATE DATABASE  `autonomicrestmonitor` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
GRANT SELECT , INSERT , UPDATE , DELETE ON  `autonomicrestmonitor` . * TO  'autonomicrestmon'@'localhost';
USE `autonomicrestmonitor`;

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
DROP TABLE IF EXISTS `Server`;
DROP TABLE IF EXISTS `User`;
DROP TABLE IF EXISTS `Role`;

-- --------------------------------------------------------

--
-- Table structure for table `Role`
--

CREATE TABLE IF NOT EXISTS `Role` (
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
  `isAdmin` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `Role`
--

INSERT INTO `Role` (`id`, `name`, `canAddUser`, `canDeleteUser`, `canEditUser`, `canAddRole`, `canDeleteRole`, `canEditRole`, `canAddServer`, `canDeleteServer`, `canEditServer`, `userLimit`, `roleLimit`, `serverLimit`, `isAdmin`) VALUES
(1, 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 1, -1, -1, -1, 1);


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

-- --------------------------------------------------------

--
-- Table structure for table `Server`
--

CREATE TABLE `Server` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hostname` varchar(64) DEFAULT NULL,
  `ip` varchar(16) DEFAULT NULL,
  `active` int(11) DEFAULT NULL,
  `id_User` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_User` (`id_User`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Server`
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
-- Table structure for table `SiteRequestType`
--

CREATE TABLE `SiteRequestType` (
  `id_Server` int(11) NOT NULL,
  `id_Requesttype` int(11) NOT NULL,
  `Active` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_Server`,`id_Requesttype`),
  KEY `id_Requesttype` (`id_Requesttype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `SiteRequestType`
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
  `id_Server` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_RequestType` (`id_RequestType`),
  KEY `id_Server` (`id_Server`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Dumping data for table `Request`
--


--
-- Constraints for dumped tables
--
ALTER TABLE `Server`
  ADD CONSTRAINT `ServerUserId` FOREIGN KEY (`id_User`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `User`
  ADD CONSTRAINT `UserUserId` FOREIGN KEY (`id_User`) REFERENCES `User` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `UserRoleId` FOREIGN KEY (`id_Role`) REFERENCES `Role` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `Request`
  ADD CONSTRAINT `RequestServerId` FOREIGN KEY (`id_Server`) REFERENCES `Server` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `RequestRequestTypeId` FOREIGN KEY (`id_RequestType`) REFERENCES `RequestType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;
ALTER TABLE `SiteRequestType`
  ADD CONSTRAINT `SiteRequestTypeServerId` FOREIGN KEY (`id_Server`) REFERENCES `Server` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
  ADD CONSTRAINT `SiteRequestTypeRequesttypeId` FOREIGN KEY (`id_Requesttype`) REFERENCES `RequestType` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE;

-- ALTER TABLE  `Role` CHANGE  `canAddSite`  `canAddServer` INT( 11 ) NULL DEFAULT NULL
-- ALTER TABLE  `Role` CHANGE  `canEditSite`  `canEditServer` INT( 11 ) NULL DEFAULT NULL
-- ALTER TABLE  `Role` CHANGE  `canDeleteSite`  `canDeleteServer` INT( 11 ) NULL DEFAULT NULL

-- ALTER TABLE  `Request` DROP FOREIGN KEY  `Request_ibfk_7` ;
-- ALTER TABLE  `Request` DROP FOREIGN KEY  `Request_ibfk_8` ;
-- ALTER TABLE  `Request` CHANGE  `id_Site`  `id_Server` INT( 11 ) NOT NULL

-- ALTER TABLE  `SiteRequestType` DROP FOREIGN KEY  `SiteRequestType_ibfk_5` ;
-- ALTER TABLE  `SiteRequestType` DROP FOREIGN KEY  `SiteRequestType_ibfk_4` ;
-- ALTER TABLE  `SiteRequestType` CHANGE  `id_Site`  `id_Server` INT( 11 ) NOT NULL
-- RENAME TABLE  `autonomicrestmonitor`.`Site` TO  `autonomicrestmonitor`.`Server` ;


