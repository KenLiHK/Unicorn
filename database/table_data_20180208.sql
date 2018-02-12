/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


DROP DATABASE IF EXISTS `unicorn`;
CREATE DATABASE IF NOT EXISTS `unicorn` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `unicorn`;



DROP TABLE IF EXISTS `food`;
CREATE TABLE IF NOT EXISTS `food` (
  `food_id` int(11) NOT NULL AUTO_INCREMENT,
  `food_category` varchar(10) NOT NULL,
  `food_name` varchar(100) NOT NULL,
  `available` varchar(1) NOT NULL,
  `price` decimal(6,1) NOT NULL,
  `discount` int(3) DEFAULT NULL,
  `discount_effect_date` datetime DEFAULT NULL,
  `discount_expiry_date` datetime DEFAULT NULL,
  `img_path` varchar(100) DEFAULT NULL,
  `remark` varchar(1000) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`food_id`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `food` DISABLE KEYS */;
INSERT INTO `food` (`food_id`, `food_category`, `food_name`, `available`, `price`, `discount`, `discount_effect_date`, `discount_expiry_date`, `img_path`, `remark`, `create_date`, `update_date`) VALUES
	(1, 'LU', 'Lu Food', 'Y', 98.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:13:33'),
	(2, 'SU', 'Su Food', 'Y', 87.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:15:51'),
	(3, 'HUI', 'Hui Food', 'Y', 87.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:16:04'),
	(4, 'ZHE', 'Zhe Food', 'Y', 107.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:20:03'),
	(5, 'MIN', 'Min Food', 'Y', 87.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:20:16'),
	(6, 'CHUAN', 'Chuan Food', 'Y', 98.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:15:19'),
	(7, 'XIANG', 'Xiang Food', 'Y', 107.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:20:26'),
	(8, 'YUE', 'Yue Food', 'Y', 87.0, 2, '2018-01-21 02:13:24', '2018-02-21 02:13:28', NULL, NULL, '2018-01-21 02:13:25', '2018-01-21 02:20:35');
/*!40000 ALTER TABLE `food` ENABLE KEYS */;



DROP TABLE IF EXISTS `food_tag`;
CREATE TABLE IF NOT EXISTS `food_tag` (
  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
  `food_id` int(11) NOT NULL,
  `tag_des` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `food_tag` DISABLE KEYS */;
/*!40000 ALTER TABLE `food_tag` ENABLE KEYS */;



DROP TABLE IF EXISTS `notification`;
CREATE TABLE IF NOT EXISTS `notification` (
  `notification_id` int(11) NOT NULL AUTO_INCREMENT,
  `type` varchar(4) NOT NULL,
  `subject` varchar(50) NOT NULL,
  `content` varchar(100) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL,
  PRIMARY KEY (`notification_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `notification` ENABLE KEYS */;


DROP TABLE IF EXISTS `order`;
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(50) NOT NULL,
  `status` varchar(4) NOT NULL,
  `order_effect_date` datetime DEFAULT NULL,
  `order_expiry_date` datetime DEFAULT NULL,
  `total_payment_amt` decimal(7,1) DEFAULT NULL,
  `total_discount_amt` decimal(7,1) DEFAULT NULL,
  `payment_date` datetime DEFAULT NULL,
  `payment_channel` varchar(2) DEFAULT NULL,
  `credit_card_type` varchar(2) DEFAULT NULL,
  `credit_card_no` varchar(16) DEFAULT NULL,
  `credit_card_security_code` varchar(3) DEFAULT NULL,
  `credit_card_holder_name` varchar(50) DEFAULT NULL,
  `credit_card_expiry_date` varchar(4) DEFAULT NULL,
  `cheque_no` int(12) DEFAULT NULL,
  `remark` varchar(1000) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` (`order_id`, `user_id`, `status`, `order_effect_date`, `order_expiry_date`, `total_payment_amt`, `total_discount_amt`, `payment_date`, `payment_channel`, `credit_card_type`, `credit_card_no`, `credit_card_security_code`, `credit_card_holder_name`, `credit_card_expiry_date`, `cheque_no`, `remark`, `create_date`, `update_date`) VALUES
	(2, 'kenli', 'OS31', '2018-01-21 02:38:54', '2018-01-22 02:38:57', 266.1, 5.5, '2018-01-21 02:39:20', 'CR', 'VS', '0123456789012345', '012', 'Ken Li', '0822', NULL, NULL, '2018-01-21 02:38:54', '2018-01-21 02:55:24');
/*!40000 ALTER TABLE `order` ENABLE KEYS */;



DROP TABLE IF EXISTS `order_detail`;
CREATE TABLE IF NOT EXISTS `order_detail` (
  `order_id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `qty` int(100) NOT NULL,
  `payment_amt` decimal(6,1) DEFAULT NULL,
  `discount_amt` decimal(6,1) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`order_id`,`food_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `order_detail` DISABLE KEYS */;
INSERT INTO `order_detail` (`order_id`, `food_id`, `qty`, `payment_amt`, `discount_amt`, `create_date`, `update_date`) VALUES
	(2, 1, 1, 96.0, 2.0, '2018-01-21 02:46:59', '2018-01-21 02:48:55'),
	(2, 2, 2, 170.1, 3.5, '2018-01-21 02:46:59', '2018-01-21 02:50:14');
/*!40000 ALTER TABLE `order_detail` ENABLE KEYS */;



DROP TABLE IF EXISTS `sys_config`;
CREATE TABLE IF NOT EXISTS `sys_config` (
  `config_id` int(11) NOT NULL AUTO_INCREMENT,
  `config_category` varchar(50) NOT NULL,
  `config_name` varchar(50) NOT NULL,
  `config_value` varchar(1000) NOT NULL,
  `config_effect_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `config_expiry_date` datetime DEFAULT NULL,
  PRIMARY KEY (`config_id`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `sys_config` DISABLE KEYS */;
INSERT INTO `sys_config` (`config_id`, `config_category`, `config_name`, `config_value`, `config_effect_date`, `config_expiry_date`) VALUES
	(1, 'FOOD_CATEGORY', 'LU', 'Shandong', '2018-01-21 01:50:44', NULL),
	(2, 'FOOD_CATEGORY', 'SU', 'Jiangsu', '2018-01-21 01:53:53', NULL),
	(3, 'FOOD_CATEGORY', 'HUI', 'Anhui', '2018-01-21 01:53:53', NULL),
	(4, 'FOOD_CATEGORY', 'ZHE', 'Zhejiang', '2018-01-21 01:53:53', NULL),
	(5, 'FOOD_CATEGORY', 'MIN', 'Fujian', '2018-01-21 01:53:53', NULL),
	(6, 'FOOD_CATEGORY', 'CHUAN', 'Sichuan', '2018-01-21 01:53:53', NULL),
	(7, 'FOOD_CATEGORY', 'XIANG', 'Hunan', '2018-01-21 01:53:53', NULL),
	(8, 'FOOD_CATEGORY', 'YUE', 'Canton', '2018-01-21 01:53:53', NULL),
	(9, 'FOOD_NAME', 'Lu Food', './resources/food1_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(10, 'FOOD_NAME', 'Su Food', './resources/food2_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(11, 'FOOD_NAME', 'Hui Food', './resources/food3_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(12, 'FOOD_NAME', 'Zhe Food', './resources/food4_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(13, 'FOOD_NAME', 'Min Food', './resources/food5_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(14, 'FOOD_NAME', 'Chuan Food', './resources/food6_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(15, 'FOOD_NAME', 'Xiang Food', './resources/food7_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(16, 'FOOD_NAME', 'Yue Food', './resources/food8_256x256.jpg', '2018-01-21 01:53:53', NULL),
	(27, 'UNICORN_CONTACT', 'UNICORN_EMAIL', 'cs5281unicorn@unicorn.com', '2018-01-21 02:04:33', NULL),
	(28, 'UNICORN_CONTACT', 'UNICORN_TEL', '+852 5281-2018', '2018-01-21 02:04:33', NULL),
	(29, 'UNICORN_CONTACT', 'UNICORN_FAX', '+852 5281-2019', '2018-01-21 02:04:33', NULL),
	(30, 'UNICORN_CONTACT', 'UNICORN_ADDRESS', 'Monday - Sunday 09:00-23:00', '2018-01-21 02:04:33', NULL),
	(31, 'UNICORN_CONTACT', 'UNICORN_SERVICE_HR', 'Li Dak Sum Yip Yio Chin A Bldg 5606, Hong Kong', '2018-01-21 02:04:33', NULL);
/*!40000 ALTER TABLE `sys_config` ENABLE KEYS */;



DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `user_id` varchar(50) NOT NULL,
  `sex` varchar(1) DEFAULT NULL,
  `privilege` varchar(1) NOT NULL,
  `eng_surname` varchar(50) NOT NULL,
  `eng_middle_name` varchar(50) NOT NULL,
  `eng_name` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `tel` varchar(50) NOT NULL,
  `address_1` varchar(100) NOT NULL,
  `address_2` varchar(100) NOT NULL,
  `address_3` varchar(100) NOT NULL,
  `address_4` varchar(100) NOT NULL,
  `last_login_date` datetime DEFAULT NULL,
  `reset` varchar(1) DEFAULT NULL,
  `locked` varchar(1) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `REG_TOKEN` varchar(100) DEFAULT NULL,
  `effect_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `expiry_date` datetime DEFAULT NULL,
  `remark` varchar(1000) DEFAULT NULL,
  `create_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`user_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`user_id`, `sex`, `privilege`, `eng_surname`, `eng_middle_name`, `eng_name`, `email`, `tel`, `address_1`, `address_2`, `address_3`, `address_4`, `last_login_date`, `reset`, `locked`, `password`, `REG_TOKEN`, `effect_date`, `expiry_date`, `remark`, `create_date`, `update_date`) VALUES
	('kenli', 'M', 'U', 'k', 'k', 'k', 'kenli15@gmail.com', '1212121216', '2', '2', '2', '2', NULL, 'N', 'N', 'a541ace3bec0604b356dd48b10486ed5', '2018020697d27e043b59e7c26532a83207a32e5c70b8860306c76ef5ca90a75f273b1b41', '2018-02-06 09:33:41', NULL, NULL, '2018-02-06 09:33:41', '2018-02-08 14:24:09');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;



DROP TABLE IF EXISTS `user_notification`;
CREATE TABLE IF NOT EXISTS `user_notification` (
  `notification_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` varchar(4) NOT NULL,
  `create_date` datetime NOT NULL,
  `update_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


/*!40000 ALTER TABLE `user_notification` DISABLE KEYS */;
/*!40000 ALTER TABLE `user_notification` ENABLE KEYS */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
