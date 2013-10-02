/*
Navicat MySQL Data Transfer

Source Server         : local
Source Server Version : 50524
Source Host           : localhost:3306
Source Database       : kdstep

Target Server Type    : MYSQL
Target Server Version : 50524
File Encoding         : 65001

Date: 2013-09-24 09:23:51
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
-- Table structure for `assign_role_action`
-- ----------------------------
DROP TABLE IF EXISTS `assign_role_action`;
CREATE TABLE `assign_role_action` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_id` int(10) NOT NULL,
  `role_allowed_action` varchar(10000) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of assign_role_action
-- ----------------------------
INSERT INTO `assign_role_action` VALUES ('1', '1', 'all (manuall entry)');
INSERT INTO `assign_role_action` VALUES ('5', '2', '{\"user\":{\"index\":\"on\",\"update\":\"on\",\"delete\":\"on\"}}');

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  `address` varchar(200) DEFAULT NULL,
  `contact_type_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contact
-- ----------------------------
INSERT INTO `contact` VALUES ('1', 'jignesh', 'Patel', 'valsad', '0');
INSERT INTO `contact` VALUES ('5', 'purvesh', 'Patel', 'purvesh', '2');
INSERT INTO `contact` VALUES ('6', 'Abhijit', 'Patel', 'valsad', '2');

-- ----------------------------
-- Table structure for `contact_type`
-- ----------------------------
DROP TABLE IF EXISTS `contact_type`;
CREATE TABLE `contact_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_type_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of contact_type
-- ----------------------------
INSERT INTO `contact_type` VALUES ('2', 'employee- dont -delete this record');
INSERT INTO `contact_type` VALUES ('6', 'cleint');
INSERT INTO `contact_type` VALUES ('8', 'supplier ');
INSERT INTO `contact_type` VALUES ('9', 'Employee');

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
INSERT INTO `core_system_settings` VALUES ('1', 'Project Management System');

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
-- Table structure for `nested_category`
-- ----------------------------
DROP TABLE IF EXISTS `nested_category`;
CREATE TABLE `nested_category` (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL,
  `lft` int(11) NOT NULL,
  `rgt` int(11) NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of nested_category
-- ----------------------------
INSERT INTO `nested_category` VALUES ('1', 'ELECTRONICS', '1', '20');
INSERT INTO `nested_category` VALUES ('2', 'TELEVISIONS', '2', '9');
INSERT INTO `nested_category` VALUES ('3', 'TUBE', '3', '4');
INSERT INTO `nested_category` VALUES ('4', 'LCD', '5', '6');
INSERT INTO `nested_category` VALUES ('5', 'PLASMA', '7', '8');
INSERT INTO `nested_category` VALUES ('6', 'PORTABLE ELECTRONICS', '10', '19');
INSERT INTO `nested_category` VALUES ('7', 'MP3 PLAYERS', '11', '14');
INSERT INTO `nested_category` VALUES ('8', 'FLASH', '12', '13');
INSERT INTO `nested_category` VALUES ('9', 'CD PLAYERS', '15', '16');
INSERT INTO `nested_category` VALUES ('10', '2 WAY RADIOS', '17', '18');

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
  `name` varchar(100) NOT NULL,
  `description` varchar(10000) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of project_type
-- ----------------------------
INSERT INTO `project_type` VALUES ('1', 'Sales', 'new description a');
INSERT INTO `project_type` VALUES ('2', 'Devlopement', 'description');
INSERT INTO `project_type` VALUES ('17', 'new name 2', 'new desc3');
INSERT INTO `project_type` VALUES ('18', 'Wp Site', 'Wordpress sites and plugins some extra longer with more and more more more more extra long');
INSERT INTO `project_type` VALUES ('19', 'Sales', 'Sales description');
INSERT INTO `project_type` VALUES ('20', 'Sales', 'Sales description  new New');
INSERT INTO `project_type` VALUES ('21', 'Step2', null);

-- ----------------------------
-- Table structure for `role`
-- ----------------------------
DROP TABLE IF EXISTS `role`;
CREATE TABLE `role` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `role_name` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of role
-- ----------------------------
INSERT INTO `role` VALUES ('1', 'Administrator');
INSERT INTO `role` VALUES ('2', 'CEO ');
INSERT INTO `role` VALUES ('3', 'Customer Service');
INSERT INTO `role` VALUES ('4', 'Accountant');
INSERT INTO `role` VALUES ('5', 'Employee');
INSERT INTO `role` VALUES ('6', 'Client');

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
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `project_type_id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `parent_step_id` int(11) DEFAULT NULL,
  `child_step_id` varchar(100) DEFAULT NULL,
  `step_left_id` int(11) DEFAULT NULL,
  `step_right_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of step
-- ----------------------------
INSERT INTO `step` VALUES ('11', '2', 'Start', null, '', '1', '6');
INSERT INTO `step` VALUES ('12', '2', 'Close', '13', null, '2', '3');
INSERT INTO `step` VALUES ('13', '2', 'step1', '11', null, '4', '5');

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
  `task_due_date_time` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of task
-- ----------------------------
INSERT INTO `task` VALUES ('45', 'Working on initial timepicker setup', '2013-03-09 13:45:23', '2013-04-11 16:04:00', '2013-04-27 16:04:00', '2013-04-17 16:04:00');
INSERT INTO `task` VALUES ('46', 'setting up url for project', '2013-03-09 13:45:23', '2013-04-11 16:04:00', '2013-04-25 16:04:00', '2013-04-22 16:04:00');

-- ----------------------------
-- Table structure for `task_contact`
-- ----------------------------
DROP TABLE IF EXISTS `task_contact`;
CREATE TABLE `task_contact` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `task_id` int(11) NOT NULL,
  `contact_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of task_contact
-- ----------------------------
INSERT INTO `task_contact` VALUES ('1', '40', '5');
INSERT INTO `task_contact` VALUES ('2', '40', '2');
INSERT INTO `task_contact` VALUES ('3', '40', '1');
INSERT INTO `task_contact` VALUES ('4', '41', '1');
INSERT INTO `task_contact` VALUES ('5', '41', '5');

-- ----------------------------
-- Table structure for `timesheet`
-- ----------------------------
DROP TABLE IF EXISTS `timesheet`;
CREATE TABLE `timesheet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `notes` text NOT NULL,
  `task_date` date NOT NULL,
  `start_time` datetime NOT NULL,
  `end_time` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of timesheet
-- ----------------------------
INSERT INTO `timesheet` VALUES ('11', '1', 'Test', '2013-09-12', '2013-09-12 09:58:37', '2013-09-12 10:58:42');
INSERT INTO `timesheet` VALUES ('12', '2', 'test1', '2013-09-18', '2013-09-18 00:00:00', '2013-09-18 00:30:00');
INSERT INTO `timesheet` VALUES ('13', '2', 'test 2', '2013-09-18', '2013-09-18 00:30:00', '2013-09-18 01:00:00');
INSERT INTO `timesheet` VALUES ('14', '2', 'working on kdstep timesheet', '2013-09-18', '2013-09-18 09:00:00', '2013-09-18 10:00:00');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_name` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role_id` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('2', 'admin', '0192023a7bbd73250516f069df18b500', 'Purvesh', 'Patel ', 'ind.purvesh@gmail.com', '1');
INSERT INTO `users` VALUES ('3', 'purvesh', '0192023a7bbd73250516f069df18b500', 'Purvesh', 'Patel', 'purvesh@righthandman.co.nz', '1');
INSERT INTO `users` VALUES ('4', 'jignesh', '0192023a7bbd73250516f069df18b500', 'Jignesh', 'Patel', 'jignesh@kdecom.com', '2');
INSERT INTO `users` VALUES ('5', 'abhijit', '0192023a7bbd73250516f069df18b500', 'Abhijit', 'Patel', 'abhijit@kdecom.com', '1');
INSERT INTO `users` VALUES ('6', 'hiral', '0192023a7bbd73250516f069df18b500', 'Hiral', 'Patel New', 'hiral@kdecom.com', '1');
INSERT INTO `users` VALUES ('7', 'krunal', '0192023a7bbd73250516f069df18b500', 'Krunal', 'Patel', 'krunal@kdecom.com', '1');
