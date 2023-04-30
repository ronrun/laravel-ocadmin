/*
Navicat MySQL Data Transfer

Source Server         : LocalMariaDbRoot
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : laravel10

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-05-01 13:01:55
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `autoload` tinyint(1) NOT NULL DEFAULT 0,
  `serialized` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `settings_group_key_unique` (`group`,`key`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'default', 'admin_email', 'arhatron@gmail.com', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
INSERT INTO `settings` VALUES ('2', 'default', 'admin_language', 'zh-Hant', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
INSERT INTO `settings` VALUES ('3', 'default', 'admin_pagination', '10', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
INSERT INTO `settings` VALUES ('4', 'default', 'language', 'zh-Hant', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
INSERT INTO `settings` VALUES ('5', 'default', 'timezone', 'Asia/Taipei', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
INSERT INTO `settings` VALUES ('6', 'default', 'currency', 'TWD', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
INSERT INTO `settings` VALUES ('7', 'default', 'login_attempts', '5', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
INSERT INTO `settings` VALUES ('8', 'default', 'login_suspending_minutes', '10', '1', '0', '2023-05-01 12:00:08', '2023-05-01 12:00:08');
