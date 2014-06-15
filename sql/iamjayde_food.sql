/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 50534
 Source Host           : localhost
 Source Database       : iamjayde_food

 Target Server Type    : MySQL
 Target Server Version : 50534
 File Encoding         : utf-8

 Date: 06/14/2014 01:34:37 AM
*/

SET NAMES utf8;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
--  Table structure for `iaddress`
-- ----------------------------
DROP TABLE IF EXISTS `iaddress`;
CREATE TABLE `iaddress` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `street1` varchar(255) DEFAULT NULL,
  `street2` varchar(255) DEFAULT NULL,
  `city` varchar(255) DEFAULT NULL,
  `state` varchar(255) DEFAULT NULL,
  `zip` varchar(255) DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `icart`
-- ----------------------------
DROP TABLE IF EXISTS `icart`;
CREATE TABLE `icart` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `comments` varchar(255) DEFAULT NULL,
  `cartitems` int(11) unsigned DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `cartitems` (`cartitems`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `igenre`
-- ----------------------------
DROP TABLE IF EXISTS `igenre`;
CREATE TABLE `igenre` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `keywords` varchar(255) DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `imenu`
-- ----------------------------
DROP TABLE IF EXISTS `imenu`;
CREATE TABLE `imenu` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `restaurant` int(11) unsigned DEFAULT NULL,
  `name` varchar(255) DEFAULT NULL,
  `schedule` varchar(255) DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `restaurant` (`restaurant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `imenuitem`
-- ----------------------------
DROP TABLE IF EXISTS `imenuitem`;
CREATE TABLE `imenuitem` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `is_vegetarian` enum('Yes','No','Can Be Made') DEFAULT NULL,
  `is_vegan` enum('Yes','No','Can Be Made') DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `iorder`
-- ----------------------------
DROP TABLE IF EXISTS `iorder`;
CREATE TABLE `iorder` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `status` enum('Pending','Submitted','Delivered','Canceled') DEFAULT NULL,
  `estreadytime` datetime DEFAULT NULL,
  `orderitems` int(11) unsigned DEFAULT NULL,
  `orderitemstotal` decimal(10,2) DEFAULT NULL,
  `tip` decimal(10,2) DEFAULT NULL,
  `taxtotal` decimal(10,2) DEFAULT NULL,
  `deliverytype` enum('Deliver','Pickup') DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `orderitems` (`orderitems`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `irestaurant`
-- ----------------------------
DROP TABLE IF EXISTS `irestaurant`;
CREATE TABLE `irestaurant` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `description` varchar(255) DEFAULT NULL,
  `genre` varchar(255) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `phone` int(11) DEFAULT NULL,
  `estlatency` varchar(255) DEFAULT NULL,
  `hours` varchar(255) DEFAULT NULL,
  `latitude` decimal(10,2) DEFAULT NULL,
  `longitude` decimal(10,2) DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `genre` (`genre`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `ireview`
-- ----------------------------
DROP TABLE IF EXISTS `ireview`;
CREATE TABLE `ireview` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `restaurant` int(11) unsigned DEFAULT NULL,
  `comments` varchar(255) DEFAULT NULL,
  `owner` int(11) unsigned DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `restaurant` (`restaurant`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
--  Table structure for `iuser`
-- ----------------------------
DROP TABLE IF EXISTS `iuser`;
CREATE TABLE `iuser` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) DEFAULT NULL,
  `cellphone` int(11) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `tagline` varchar(255) DEFAULT NULL,
  `creation_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

SET FOREIGN_KEY_CHECKS = 1;
