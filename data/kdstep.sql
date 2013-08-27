/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : kdstep

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2013-04-09 15:41:22
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `address`
-- ----------------------------
DROP TABLE IF EXISTS `address`;
CREATE TABLE `address` (
  `address_id` int(11) NOT NULL AUTO_INCREMENT,
  `address_details` varchar(256) NOT NULL,
  PRIMARY KEY (`address_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of address
-- ----------------------------

-- ----------------------------
-- Table structure for `attribute`
-- ----------------------------
DROP TABLE IF EXISTS `attribute`;
CREATE TABLE `attribute` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `unique_key_attribute` varchar(250) NOT NULL,
  `attribute_title` varchar(250) DEFAULT NULL,
  `attribute_type` int(11) NOT NULL,
  `attribute_belongs_to` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of attribute
-- ----------------------------
INSERT INTO `attribute` VALUES ('1', 'blood_group', 'Blood Group', '4', '1');
INSERT INTO `attribute` VALUES ('2', 'phone_number', 'Phone Number', '1', '1');

-- ----------------------------
-- Table structure for `contact`
-- ----------------------------
DROP TABLE IF EXISTS `contact`;
CREATE TABLE `contact` (
  `contact_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_name` varchar(50) NOT NULL,
  `address_line_1` varchar(50) DEFAULT NULL,
  `contact_type_id` int(11) NOT NULL,
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contact
-- ----------------------------
INSERT INTO `contact` VALUES ('1', 'jignesh', 'valsad', '2');
INSERT INTO `contact` VALUES ('5', 'purvesh', 'purvesh', '2');
INSERT INTO `contact` VALUES ('6', 'Abhijit', 'valsad', '2');

-- ----------------------------
-- Table structure for `contact_type`
-- ----------------------------
DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE `contact_type` (
  `contact_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_type_name` varchar(100) NOT NULL,
  PRIMARY KEY (`contact_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contact_type
-- ----------------------------
INSERT INTO `contact_type` VALUES ('2', 'employee- dont -delete this record');
INSERT INTO `contact_type` VALUES ('6', 'cleint');
INSERT INTO `contact_type` VALUES ('8', 'supplier');

-- ----------------------------
-- Table structure for `core_system_settings`
-- ----------------------------
DROP TABLE IF EXISTS `core_system_settings`;
CREATE TABLE `core_system_settings` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `application_name` varchar(1000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of core_system_settings
-- ----------------------------
INSERT INTO `core_system_settings` VALUES ('1', 'ERP');

-- ----------------------------
-- Table structure for `department`
-- ----------------------------
DROP TABLE IF EXISTS `department`;
CREATE TABLE `department` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(500) NOT NULL,
  `department_description` text,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of department
-- ----------------------------
INSERT INTO `department` VALUES ('3', 'Customer Service', 'This department responsibility is to response customer query and find the proper solution for the customer query.');

-- ----------------------------
-- Table structure for `employee`
-- ----------------------------
DROP TABLE IF EXISTS `employee`;
CREATE TABLE `employee` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `department_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `employee_address` varchar(1000) DEFAULT NULL,
  `employee_phone` varchar(500) DEFAULT NULL,
  `monthly_pay` int(11) NOT NULL,
  `annual_leave` double DEFAULT NULL,
  `sick_leave` double DEFAULT NULL,
  `last_name` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of employee
-- ----------------------------
INSERT INTO `employee` VALUES ('1', '3', 'Jignesh', 'Valsad', '0091-990909', '5000', '10.4', '5', 'Patel');
INSERT INTO `employee` VALUES ('2', '0', 'Jigisha', null, null, '0', null, null, 'Patel');
INSERT INTO `employee` VALUES ('3', '0', 'Purvesh', null, null, '0', null, null, 'Patel');
INSERT INTO `employee` VALUES ('5', '0', 'Hiral', null, null, '0', null, null, 'Patel');

-- ----------------------------
-- Table structure for `employee_attribute_value`
-- ----------------------------
DROP TABLE IF EXISTS `employee_attribute_value`;
CREATE TABLE `employee_attribute_value` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `attribute_id` int(11) DEFAULT NULL,
  `attribute_value_text` text,
  `unique_key_attribute` varchar(10000) DEFAULT NULL,
  `employee_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of employee_attribute_value
-- ----------------------------
INSERT INTO `employee_attribute_value` VALUES ('15', '2', '022 134 2343', 'phone_number', '2');
INSERT INTO `employee_attribute_value` VALUES ('14', '1', '0', 'blood_group', '2');
INSERT INTO `employee_attribute_value` VALUES ('13', '2', '022 134 2345', 'phone_number', '1');
INSERT INTO `employee_attribute_value` VALUES ('12', '1', '1', 'blood_group', '1');

-- ----------------------------
-- Table structure for `leave`
-- ----------------------------
DROP TABLE IF EXISTS `leave`;
CREATE TABLE `leave` (
  `leave_id` int(11) NOT NULL AUTO_INCREMENT,
  `employee_id` int(11) NOT NULL,
  `leave_type` int(11) NOT NULL,
  `reason_for_leave` text NOT NULL,
  `status` varchar(100) NOT NULL,
  `leave_start_date` date NOT NULL,
  `leave_end_date` date NOT NULL,
  PRIMARY KEY (`leave_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of leave
-- ----------------------------

-- ----------------------------
-- Table structure for `login`
-- ----------------------------
DROP TABLE IF EXISTS `login`;
CREATE TABLE `login` (
  `login_id` int(11) NOT NULL AUTO_INCREMENT,
  `login_user_name` varchar(50) NOT NULL,
  `login_password` varchar(1000) NOT NULL,
  `mysalt` varchar(50) NOT NULL,
  `role_type_id` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`login_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of login
-- ----------------------------
INSERT INTO `login` VALUES ('2', 'admin', 'password5f4dcc3b5aa765d61d8327deb882cf99', '5f4dcc3b5aa765d61d8327deb882cf99', '1', '2011-10-02 12:42:03', '5');

-- ----------------------------
-- Table structure for `product`
-- ----------------------------
DROP TABLE IF EXISTS `product`;
CREATE TABLE `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `product_name` varchar(256) NOT NULL,
  `product_description` varchar(1000) NOT NULL,
  `quantity` float NOT NULL,
  `cost_price` float NOT NULL,
  `unit_price` float NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of product
-- ----------------------------
INSERT INTO `product` VALUES ('1', 'Product 1', 'prodcut desc 1', '10', '90', '100');
INSERT INTO `product` VALUES ('2', 'product test2', 'product test 2 desc', '10', '90', '100');

-- ----------------------------
-- Table structure for `project`
-- ----------------------------
DROP TABLE IF EXISTS `project`;
CREATE TABLE `project` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_type_id` int(11) NOT NULL,
  `project_name` varchar(100) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `priority` varchar(50) DEFAULT NULL,
  `created_by_person_id` int(11) NOT NULL,
  `due_date` timestamp NULL DEFAULT NULL,
  `start_date` timestamp NULL DEFAULT NULL,
  `project_description` varchar(1000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project
-- ----------------------------
INSERT INTO `project` VALUES ('10', '2', 'Kd Step design', '2013-04-09 14:00:53', 'low', '0', null, null, '');
INSERT INTO `project` VALUES ('11', '2', 'Kd step SEO new', '2013-04-09 14:01:08', 'low', '0', null, null, '');
INSERT INTO `project` VALUES ('13', '2', 'Kd Step installed php block module', '2013-04-09 14:01:14', 'low', '0', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '');
INSERT INTO `project` VALUES ('38', '2', 'KD workflow ', '2011-10-05 21:50:31', 'high', '0', '2011-11-15 20:00:00', '2011-10-05 19:00:00', 'KD workflow is a Project management system.');

-- ----------------------------
-- Table structure for `project_contact`
-- ----------------------------
DROP TABLE IF EXISTS `project_contact`;
CREATE TABLE `project_contact` (
  `project_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project_contact
-- ----------------------------
INSERT INTO `project_contact` VALUES ('38', '5');
INSERT INTO `project_contact` VALUES ('38', '1');
INSERT INTO `project_contact` VALUES ('38', '6');
INSERT INTO `project_contact` VALUES ('13', '5');

-- ----------------------------
-- Table structure for `project_type`
-- ----------------------------
DROP TABLE IF EXISTS `project_type`;
CREATE TABLE `project_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_type_name` varchar(100) NOT NULL,
  `project_type_description` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project_type
-- ----------------------------
INSERT INTO `project_type` VALUES ('1', 'Sales', 'new description');
INSERT INTO `project_type` VALUES ('2', 'Devlopement', 'description');
INSERT INTO `project_type` VALUES ('17', 'new name 2', 'new desc3');
INSERT INTO `project_type` VALUES ('18', 'Wp Site', 'Wordpress sites and plugins');

-- ----------------------------
-- Table structure for `role_type`
-- ----------------------------
DROP TABLE IF EXISTS `role_type`;
CREATE TABLE `role_type` (
  `role_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `role_type_name` varchar(500) NOT NULL,
  `role_type_allowed_action` varchar(10000) NOT NULL,
  PRIMARY KEY (`role_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role_type
-- ----------------------------
INSERT INTO `role_type` VALUES ('1', 'Administrator', 'all (manuall entry)');

-- ----------------------------
-- Table structure for `sale_purcase_product`
-- ----------------------------
DROP TABLE IF EXISTS `sale_purcase_product`;
CREATE TABLE `sale_purcase_product` (
  `sale_purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sale_purcase_product
-- ----------------------------

-- ----------------------------
-- Table structure for `sale_purchase`
-- ----------------------------
DROP TABLE IF EXISTS `sale_purchase`;
CREATE TABLE `sale_purchase` (
  `sale_purchase_id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'primary key',
  `sale_or_purchase` tinyint(1) DEFAULT NULL COMMENT '0 = sale and 1 = purchase',
  `sale_purchase_number` int(11) NOT NULL,
  `project_id` int(11) NOT NULL,
  `sale_purchase_name` varchar(100) NOT NULL,
  `sale_purchase_description` varchar(10000) DEFAULT '',
  `sale_purchase_created_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `sale_purchase_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `ship_to_address_id` int(11) NOT NULL,
  `bill_to_address_id` int(11) NOT NULL,
  PRIMARY KEY (`sale_purchase_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sale_purchase
-- ----------------------------

-- ----------------------------
-- Table structure for `sale_purchase_type`
-- ----------------------------
DROP TABLE IF EXISTS `sale_purchase_type`;
CREATE TABLE `sale_purchase_type` (
  `sale_purchase_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `sale_purchase_type_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`sale_purchase_type_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of sale_purchase_type
-- ----------------------------

-- ----------------------------
-- Table structure for `status`
-- ----------------------------
DROP TABLE IF EXISTS `status`;
CREATE TABLE `status` (
  `status_id` int(11) NOT NULL AUTO_INCREMENT,
  `status_name` varchar(256) NOT NULL,
  PRIMARY KEY (`status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of status
-- ----------------------------
INSERT INTO `status` VALUES ('1', 'pending');
INSERT INTO `status` VALUES ('2', 'start');
INSERT INTO `status` VALUES ('3', 'completed');

-- ----------------------------
-- Table structure for `step`
-- ----------------------------
DROP TABLE IF EXISTS `step`;
CREATE TABLE `step` (
  `step_id` int(11) NOT NULL AUTO_INCREMENT,
  `parent_step_id` int(11) DEFAULT NULL,
  `project_type_id` int(11) NOT NULL,
  `step_name` varchar(50) NOT NULL,
  PRIMARY KEY (`step_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of step
-- ----------------------------
INSERT INTO `step` VALUES ('6', null, '1', 'Start');
INSERT INTO `step` VALUES ('7', '6', '1', 'step2');
INSERT INTO `step` VALUES ('8', '6', '1', 'step2-1');
INSERT INTO `step` VALUES ('9', '7', '1', 'step3-0');

-- ----------------------------
-- Table structure for `task`
-- ----------------------------
DROP TABLE IF EXISTS `task`;
CREATE TABLE `task` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_name` varchar(50) NOT NULL,
  `created_date_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `task_start_date_time` datetime DEFAULT NULL,
  `task_end_date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of task
-- ----------------------------
INSERT INTO `task` VALUES ('45', 'Working on initial timepicker setup', '2013-03-09 13:45:23', '2013-03-09 13:00:00', '2013-03-09 13:20:00');
INSERT INTO `task` VALUES ('46', 'setting up url for project', '2013-03-09 13:45:23', '2013-03-09 13:20:00', '2013-03-09 13:30:00');

-- ----------------------------
-- Table structure for `task_contact`
-- ----------------------------
DROP TABLE IF EXISTS `task_contact`;
CREATE TABLE `task_contact` (
  `task_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of task_contact
-- ----------------------------
INSERT INTO `task_contact` VALUES ('40', '5');
INSERT INTO `task_contact` VALUES ('40', '2');
INSERT INTO `task_contact` VALUES ('40', '1');
INSERT INTO `task_contact` VALUES ('41', '1');
INSERT INTO `task_contact` VALUES ('41', '5');

-- ----------------------------
-- Table structure for `timesheet`
-- ----------------------------
DROP TABLE IF EXISTS `timesheet`;
CREATE TABLE `timesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `action_id` int(11) DEFAULT NULL,
  `task_id` int(11) DEFAULT NULL,
  `employee_id` int(11) DEFAULT NULL,
  `task_date` date NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of timesheet
-- ----------------------------
INSERT INTO `timesheet` VALUES ('9', null, '45', null, '2013-03-09');
INSERT INTO `timesheet` VALUES ('10', null, '46', null, '2013-03-09');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', '0192023a7bbd73250516f069df18b500');
