/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50153
Source Host           : localhost:3306
Source Database       : game

Target Server Type    : MYSQL
Target Server Version : 50153
File Encoding         : 65001

Date: 2012-11-21 19:01:23
*/

SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `item`
-- ----------------------------
DROP TABLE IF EXISTS `item`;
CREATE TABLE `item` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `item_name` varchar(1000) DEFAULT NULL,
  `item_description` text,
  `item_type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of item
-- ----------------------------
INSERT INTO `item` VALUES ('1', 'Call of Duty: Black Ops 2', 'Pushing the boundaries of what fans have come to expect from the record-setting entertainment franchise, Call of Duty®: Black Ops 2 propels players into a near future, 21st Century Cold War, where technology and weapons have converged to create a new generation of warfare.', '1');
INSERT INTO `item` VALUES ('4', 'Halo - 4 ', 'AWesome Halo 3 remake', '1');
INSERT INTO `item` VALUES ('5', 'Halo - 3 ', 'Remake of Halo2', '1');
INSERT INTO `item` VALUES ('6', 'Halo - 2', 'Remake of Halo1', '1');
INSERT INTO `item` VALUES ('7', 'Halo - 1', 'action Games', '1');

-- ----------------------------
-- Table structure for `user`
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(1000) NOT NULL,
  `password` varchar(1000) NOT NULL,
  `first_name` varchar(1000) DEFAULT NULL,
  `last_name` varchar(1000) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `fuid` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('14', 'tagmyjob@gmail.com', '7178541af319bf72210656628b0c95bb', 'Tagmyjob', 'Smart Jobs', '1980-04-01', '100003267702042');
