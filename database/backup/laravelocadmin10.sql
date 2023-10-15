/*
Navicat MySQL Data Transfer

Source Server         : LocalMariaDbRoot
Source Server Version : 50505
Source Host           : localhost:3306
Source Database       : laravelocadmin10

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2023-10-15 23:25:28
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `failed_jobs`
-- ----------------------------
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE `failed_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of failed_jobs
-- ----------------------------

-- ----------------------------
-- Table structure for `migrations`
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES ('13', '2014_10_12_000000_create_users_table', '1');
INSERT INTO `migrations` VALUES ('14', '2014_10_12_100000_create_password_reset_tokens_table', '1');
INSERT INTO `migrations` VALUES ('15', '2014_10_12_100000_create_password_resets_table', '1');
INSERT INTO `migrations` VALUES ('16', '2019_08_19_000000_create_failed_jobs_table', '1');
INSERT INTO `migrations` VALUES ('17', '2019_12_14_000001_create_personal_access_tokens_table', '1');
INSERT INTO `migrations` VALUES ('18', '2023_00_00_000001_create_settings_table', '1');
INSERT INTO `migrations` VALUES ('19', '2023_00_01_000001_create_taxonomies_table', '1');
INSERT INTO `migrations` VALUES ('20', '2023_00_01_000002_create_terms_table', '1');
INSERT INTO `migrations` VALUES ('21', '2023_00_02_000001_create_posts_table', '1');
INSERT INTO `migrations` VALUES ('22', '2023_00_03_000001_create_products_table', '1');
INSERT INTO `migrations` VALUES ('23', '2023_00_03_000002_create_product_terms_table', '1');
INSERT INTO `migrations` VALUES ('24', '2023_00_20_000003_create_permission_tables', '1');

-- ----------------------------
-- Table structure for `model_has_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `model_has_permissions`;
CREATE TABLE `model_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`model_id`,`model_type`),
  KEY `model_has_permissions_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for `model_has_roles`
-- ----------------------------
DROP TABLE IF EXISTS `model_has_roles`;
CREATE TABLE `model_has_roles` (
  `role_id` bigint(20) unsigned NOT NULL,
  `model_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `model_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`role_id`,`model_id`,`model_type`),
  KEY `model_has_roles_model_id_model_type_index` (`model_id`,`model_type`),
  CONSTRAINT `model_has_roles_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of model_has_roles
-- ----------------------------

-- ----------------------------
-- Table structure for `password_resets`
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_resets
-- ----------------------------

-- ----------------------------
-- Table structure for `password_reset_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of password_reset_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for `permissions`
-- ----------------------------
DROP TABLE IF EXISTS `permissions`;
CREATE TABLE `permissions` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `permissions_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of permissions
-- ----------------------------

-- ----------------------------
-- Table structure for `personal_access_tokens`
-- ----------------------------
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of personal_access_tokens
-- ----------------------------

-- ----------------------------
-- Table structure for `posts`
-- ----------------------------
DROP TABLE IF EXISTS `posts`;
CREATE TABLE `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_status` tinyint(4) NOT NULL DEFAULT 0,
  `comment_status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of posts
-- ----------------------------

-- ----------------------------
-- Table structure for `post_meta`
-- ----------------------------
DROP TABLE IF EXISTS `post_meta`;
CREATE TABLE `post_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `post_meta_post_id_meta_key_index` (`post_id`,`meta_key`),
  CONSTRAINT `post_meta_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of post_meta
-- ----------------------------

-- ----------------------------
-- Table structure for `post_translations`
-- ----------------------------
DROP TABLE IF EXISTS `post_translations`;
CREATE TABLE `post_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `post_translations_post_id_foreign` (`post_id`),
  KEY `post_translations_name_index` (`name`),
  KEY `post_translations_content_index` (`content`(768)),
  CONSTRAINT `post_translations_post_id_foreign` FOREIGN KEY (`post_id`) REFERENCES `posts` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of post_translations
-- ----------------------------

-- ----------------------------
-- Table structure for `products`
-- ----------------------------
DROP TABLE IF EXISTS `products`;
CREATE TABLE `products` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `is_active` tinyint(1) NOT NULL DEFAULT 0,
  `model` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of products
-- ----------------------------
INSERT INTO `products` VALUES ('1', '1', 'CokeBig', '2023-07-01 00:16:00', '2023-10-15 22:53:59');
INSERT INTO `products` VALUES ('2', '1', 'CokeSmall', '2023-07-01 00:16:00', '2023-07-01 00:16:00');
INSERT INTO `products` VALUES ('3', '1', 'CokeMedium', '2023-07-01 00:16:00', '2023-07-01 00:16:00');
INSERT INTO `products` VALUES ('4', '1', 'CoffeeBig', '2023-07-01 00:16:00', '2023-07-01 00:16:00');
INSERT INTO `products` VALUES ('5', '1', 'CoffeeSmall', '2023-07-01 00:16:00', '2023-07-01 00:16:00');
INSERT INTO `products` VALUES ('6', '1', 'CoffeeMedium', '2023-07-01 00:16:00', '2023-07-01 00:16:00');

-- ----------------------------
-- Table structure for `product_metas`
-- ----------------------------
DROP TABLE IF EXISTS `product_metas`;
CREATE TABLE `product_metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_metas_unique` (`product_id`,`locale`,`meta_key`) USING BTREE,
  CONSTRAINT `product_meta_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_metas
-- ----------------------------
INSERT INTO `product_metas` VALUES ('1', '1', 'en', 'name', '3 Coke Big');
INSERT INTO `product_metas` VALUES ('2', '2', 'en', 'name', '1 Coke Small');
INSERT INTO `product_metas` VALUES ('3', '3', 'en', 'name', '2  Coke Medium');
INSERT INTO `product_metas` VALUES ('4', '1', 'zh_TW', 'name', '3 可樂大');
INSERT INTO `product_metas` VALUES ('5', '2', 'zh_TW', 'name', '1 可樂小');
INSERT INTO `product_metas` VALUES ('6', '3', 'zh_TW', 'name', '2 可樂中');
INSERT INTO `product_metas` VALUES ('7', '4', 'en', 'name', '3 Coffee Big');
INSERT INTO `product_metas` VALUES ('8', '5', 'en', 'name', '1 Coffee Small');
INSERT INTO `product_metas` VALUES ('9', '6', 'en', 'name', '2 Coffee Medium');
INSERT INTO `product_metas` VALUES ('10', '4', 'zh_TW', 'name', '3 咖啡 大');
INSERT INTO `product_metas` VALUES ('11', '5', 'zh_TW', 'name', '1 咖啡 小');
INSERT INTO `product_metas` VALUES ('12', '6', 'zh_TW', 'name', '2 咖啡 中');
INSERT INTO `product_metas` VALUES ('13', '1', 'zh_TW', 'slug', '可樂大');
INSERT INTO `product_metas` VALUES ('14', '2', 'zh_TW', 'slug', '可樂小');
INSERT INTO `product_metas` VALUES ('15', '3', 'zh_TW', 'slug', '可樂中');
INSERT INTO `product_metas` VALUES ('16', '1', 'en', 'slug', 'coke-big');
INSERT INTO `product_metas` VALUES ('17', '2', 'en', 'slug', 'coke-small');
INSERT INTO `product_metas` VALUES ('18', '3', 'en', 'slug', 'coke-medium');
INSERT INTO `product_metas` VALUES ('19', '4', 'en', 'slug', 'coffee-big');
INSERT INTO `product_metas` VALUES ('20', '5', 'en', 'slug', 'coffee-small');
INSERT INTO `product_metas` VALUES ('21', '6', 'en', 'slug', 'coffee-medium');

-- ----------------------------
-- Table structure for `product_term_headers`
-- ----------------------------
DROP TABLE IF EXISTS `product_term_headers`;
CREATE TABLE `product_term_headers` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_term_headers
-- ----------------------------

-- ----------------------------
-- Table structure for `product_term_header_meta`
-- ----------------------------
DROP TABLE IF EXISTS `product_term_header_meta`;
CREATE TABLE `product_term_header_meta` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `term_id` int(10) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `product_term_header_meta_product_id_term_id_unique` (`product_id`,`term_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_term_header_meta
-- ----------------------------

-- ----------------------------
-- Table structure for `product_term_header_relations`
-- ----------------------------
DROP TABLE IF EXISTS `product_term_header_relations`;
CREATE TABLE `product_term_header_relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `header_term_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_term_header_relations
-- ----------------------------

-- ----------------------------
-- Table structure for `product_term_items`
-- ----------------------------
DROP TABLE IF EXISTS `product_term_items`;
CREATE TABLE `product_term_items` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_term_items
-- ----------------------------

-- ----------------------------
-- Table structure for `product_term_item_relations`
-- ----------------------------
DROP TABLE IF EXISTS `product_term_item_relations`;
CREATE TABLE `product_term_item_relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` int(10) unsigned NOT NULL,
  `item_term_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_term_item_relations
-- ----------------------------

-- ----------------------------
-- Table structure for `product_translations`
-- ----------------------------
DROP TABLE IF EXISTS `product_translations`;
CREATE TABLE `product_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `content` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `product_translations_product_id_foreign` (`product_id`),
  KEY `product_translations_name_index` (`name`),
  KEY `product_translations_content_index` (`content`(768)),
  CONSTRAINT `product_translations_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of product_translations
-- ----------------------------
INSERT INTO `product_translations` VALUES ('1', '1', 'en', '3 Coke Big', '', '');
INSERT INTO `product_translations` VALUES ('2', '2', 'en', '1 Coke Small', '', '');
INSERT INTO `product_translations` VALUES ('3', '3', 'en', '2  Coke Medium', '', '');
INSERT INTO `product_translations` VALUES ('4', '1', 'zh_TW', '3 可樂大', '', '');
INSERT INTO `product_translations` VALUES ('5', '2', 'zh_TW', '1 可樂小', '', '');
INSERT INTO `product_translations` VALUES ('6', '3', 'zh_TW', '2 可樂中', '', '');
INSERT INTO `product_translations` VALUES ('7', '4', 'en', '3 Coffee Big', '', '');
INSERT INTO `product_translations` VALUES ('8', '5', 'en', '1 Coffee Small', '', '');
INSERT INTO `product_translations` VALUES ('9', '6', 'en', '2 Coffee Medium', '', '');
INSERT INTO `product_translations` VALUES ('10', '4', 'zh_TW', '3 咖啡 大', '', '');
INSERT INTO `product_translations` VALUES ('11', '5', 'zh_TW', '1 咖啡 小', '', '');
INSERT INTO `product_translations` VALUES ('12', '6', 'zh_TW', '2 咖啡 中', '', '');

-- ----------------------------
-- Table structure for `roles`
-- ----------------------------
DROP TABLE IF EXISTS `roles`;
CREATE TABLE `roles` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `guard_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `roles_name_guard_name_unique` (`name`,`guard_name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of roles
-- ----------------------------

-- ----------------------------
-- Table structure for `role_has_permissions`
-- ----------------------------
DROP TABLE IF EXISTS `role_has_permissions`;
CREATE TABLE `role_has_permissions` (
  `permission_id` bigint(20) unsigned NOT NULL,
  `role_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`permission_id`,`role_id`),
  KEY `role_has_permissions_role_id_foreign` (`role_id`),
  CONSTRAINT `role_has_permissions_permission_id_foreign` FOREIGN KEY (`permission_id`) REFERENCES `permissions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `role_has_permissions_role_id_foreign` FOREIGN KEY (`role_id`) REFERENCES `roles` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of role_has_permissions
-- ----------------------------

-- ----------------------------
-- Table structure for `settings`
-- ----------------------------
DROP TABLE IF EXISTS `settings`;
CREATE TABLE `settings` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `group` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'default',
  `key` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `value` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_autoload` tinyint(1) NOT NULL DEFAULT 0,
  `is_json` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of settings
-- ----------------------------
INSERT INTO `settings` VALUES ('1', 'default', 'timezone', 'Asia/Taipei', '1', '0', '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `settings` VALUES ('2', 'default', 'default_login_attempts', '5', '1', '0', '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `settings` VALUES ('3', 'default', 'currency', 'TWD', '1', '0', '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `settings` VALUES ('4', 'default', 'language', 'zh-Hant', '1', '0', '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `settings` VALUES ('5', 'default', 'admin_pagination', '10', '1', '0', '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `settings` VALUES ('6', 'default', 'admin_language', 'zh-Hant', '1', '0', '2023-07-01 17:04:12', '2023-07-01 17:04:12');

-- ----------------------------
-- Table structure for `taxonomies`
-- ----------------------------
DROP TABLE IF EXISTS `taxonomies`;
CREATE TABLE `taxonomies` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `model` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `taxonomies_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of taxonomies
-- ----------------------------
INSERT INTO `taxonomies` VALUES ('1', 'post_category', 'AppModelsPostPost', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('2', 'post_tag', 'AppModelsPostPost', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('3', 'product_category', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('4', 'product_tag', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('5', 'product_attribute', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('6', 'product_filter', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('7', 'product_option', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('8', 'product_brand', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('9', 'navigation', '', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('10', 'admin_menu', '', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('11', 'project_category', 'AppModelsProjectProject', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('12', 'project_tag', 'AppModelsProjectProject', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('13', 'inventory_stock_category', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `taxonomies` VALUES ('14', 'inventory_accounting_category', 'AppModelsCatalogProduct', '1', '2023-06-09 00:00:00', '2023-06-09 00:00:00');

-- ----------------------------
-- Table structure for `taxonomy_translations`
-- ----------------------------
DROP TABLE IF EXISTS `taxonomy_translations`;
CREATE TABLE `taxonomy_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `taxonomy_id` int(10) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`),
  KEY `taxonomy_translations_locale_index` (`locale`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of taxonomy_translations
-- ----------------------------
INSERT INTO `taxonomy_translations` VALUES ('1', '1', 'en', 'Post Category');
INSERT INTO `taxonomy_translations` VALUES ('2', '2', 'en', 'Post Tag');
INSERT INTO `taxonomy_translations` VALUES ('3', '3', 'en', 'Product Category');
INSERT INTO `taxonomy_translations` VALUES ('4', '4', 'en', 'Product Tag');
INSERT INTO `taxonomy_translations` VALUES ('5', '5', 'en', 'Product Attribute');
INSERT INTO `taxonomy_translations` VALUES ('6', '6', 'en', 'Product Filter');
INSERT INTO `taxonomy_translations` VALUES ('7', '7', 'en', 'Product Option');
INSERT INTO `taxonomy_translations` VALUES ('8', '8', 'en', 'Product Brand');
INSERT INTO `taxonomy_translations` VALUES ('9', '9', 'en', 'Navication');
INSERT INTO `taxonomy_translations` VALUES ('10', '10', 'en', 'Admin Menu');
INSERT INTO `taxonomy_translations` VALUES ('11', '11', 'en', 'Project Category');
INSERT INTO `taxonomy_translations` VALUES ('12', '12', 'en', 'Project Tag');
INSERT INTO `taxonomy_translations` VALUES ('13', '13', 'en', 'Inventory Stock Category');
INSERT INTO `taxonomy_translations` VALUES ('14', '14', 'en', 'Inventory Accounting Category');
INSERT INTO `taxonomy_translations` VALUES ('15', '1', 'zh_TW', '文章分類');
INSERT INTO `taxonomy_translations` VALUES ('16', '2', 'zh_TW', '文章標籤');
INSERT INTO `taxonomy_translations` VALUES ('17', '3', 'zh_TW', '商品分類');
INSERT INTO `taxonomy_translations` VALUES ('18', '4', 'zh_TW', '商品標籤');
INSERT INTO `taxonomy_translations` VALUES ('19', '5', 'zh_TW', '商品規格');
INSERT INTO `taxonomy_translations` VALUES ('20', '6', 'zh_TW', '商品篩選器');
INSERT INTO `taxonomy_translations` VALUES ('21', '7', 'zh_TW', '商品選項');
INSERT INTO `taxonomy_translations` VALUES ('22', '8', 'zh_TW', '商品品牌');
INSERT INTO `taxonomy_translations` VALUES ('23', '9', 'zh_TW', '前台主選單');
INSERT INTO `taxonomy_translations` VALUES ('24', '10', 'zh_TW', '後台選單');
INSERT INTO `taxonomy_translations` VALUES ('25', '11', 'zh_TW', '專案分類');
INSERT INTO `taxonomy_translations` VALUES ('26', '12', 'zh_TW', '專案標籤');
INSERT INTO `taxonomy_translations` VALUES ('27', '13', 'zh_TW', '庫存分類');
INSERT INTO `taxonomy_translations` VALUES ('28', '14', 'zh_TW', '會計分類');

-- ----------------------------
-- Table structure for `terms`
-- ----------------------------
DROP TABLE IF EXISTS `terms`;
CREATE TABLE `terms` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT 0,
  `code` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `taxonomy_code` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `sort_order` smallint(6) NOT NULL DEFAULT 0,
  `count` int(10) unsigned NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `terms_code_taxonomy_code_unique` (`code`,`taxonomy_code`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of terms
-- ----------------------------
INSERT INTO `terms` VALUES ('1', '0', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('2', '1', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('3', '1', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('4', '1', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('5', '1', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('6', '0', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('7', '6', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('8', '6', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('9', '0', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('10', '9', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('11', '9', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('12', '0', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('13', '0', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('14', '0', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('15', '14', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('16', '14', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('17', '14', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('18', '14', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('19', '14', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('20', '14', null, 'product_category', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('21', '0', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('22', '0', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('23', '0', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('24', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('25', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('26', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('27', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('28', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('29', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('30', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('31', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('32', '23', null, 'product_tag', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('33', '0', null, 'product_option', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('34', '33', null, 'product_option_value', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('35', '33', null, 'product_option_value', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('36', '33', null, 'product_option_value', '1', '0', '0', '2023-06-09 00:00:00', '2023-06-09 00:00:00');
INSERT INTO `terms` VALUES ('37', '0', null, 'product_attribute', '1', '0', '0', '2023-07-02 10:20:40', '2023-07-02 10:20:40');

-- ----------------------------
-- Table structure for `term_metas`
-- ----------------------------
DROP TABLE IF EXISTS `term_metas`;
CREATE TABLE `term_metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` int(10) unsigned NOT NULL,
  `locale` varchar(10) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `term_metas_unique` (`term_id`,`locale`,`meta_key`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of term_metas
-- ----------------------------
INSERT INTO `term_metas` VALUES ('1', '33', null, 'option_values', 'a:3:{i:0;a:2:{s:7:\"term_id\";i:34;s:10:\"sort_order\";i:1;}i:1;a:2:{s:7:\"term_id\";i:35;s:10:\"sort_order\";i:2;}i:2;a:2:{s:7:\"term_id\";i:36;s:10:\"sort_order\";i:3;}}');

-- ----------------------------
-- Table structure for `term_relations`
-- ----------------------------
DROP TABLE IF EXISTS `term_relations`;
CREATE TABLE `term_relations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `object_id` int(10) unsigned NOT NULL,
  `term_id` bigint(20) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `term_relations_term_id_object_id_index` (`term_id`,`object_id`),
  CONSTRAINT `term_relations_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of term_relations
-- ----------------------------

-- ----------------------------
-- Table structure for `term_translations`
-- ----------------------------
DROP TABLE IF EXISTS `term_translations`;
CREATE TABLE `term_translations` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `term_id` bigint(20) unsigned NOT NULL,
  `locale` varchar(5) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` longtext COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `term_translations_term_id_locale_unique` (`term_id`,`locale`),
  CONSTRAINT `term_translations_term_id_foreign` FOREIGN KEY (`term_id`) REFERENCES `terms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of term_translations
-- ----------------------------
INSERT INTO `term_translations` VALUES ('1', '1', 'en', 'Components', 'components', null);
INSERT INTO `term_translations` VALUES ('2', '2', 'en', 'Monitors', '', null);
INSERT INTO `term_translations` VALUES ('3', '3', 'en', 'Printers', '', null);
INSERT INTO `term_translations` VALUES ('4', '4', 'en', 'Scanners', '', null);
INSERT INTO `term_translations` VALUES ('5', '5', 'en', 'Web Cameras', '', null);
INSERT INTO `term_translations` VALUES ('6', '6', 'en', 'Desktops', '', null);
INSERT INTO `term_translations` VALUES ('7', '7', 'en', 'MAC', '', null);
INSERT INTO `term_translations` VALUES ('8', '8', 'en', 'PC', '', null);
INSERT INTO `term_translations` VALUES ('9', '9', 'en', 'Laptops & Notebooks', '', null);
INSERT INTO `term_translations` VALUES ('10', '10', 'en', 'Macs', '', null);
INSERT INTO `term_translations` VALUES ('11', '11', 'en', 'Windows', '', null);
INSERT INTO `term_translations` VALUES ('12', '12', 'en', 'Tablets', '', null);
INSERT INTO `term_translations` VALUES ('13', '13', 'en', 'Software', '', null);
INSERT INTO `term_translations` VALUES ('14', '1', 'zh_TW', '零組件', 'components', null);
INSERT INTO `term_translations` VALUES ('15', '2', 'zh_TW', '螢幕', '', null);
INSERT INTO `term_translations` VALUES ('16', '3', 'zh_TW', '印表機', '', null);
INSERT INTO `term_translations` VALUES ('17', '4', 'zh_TW', '掃描器', '', null);
INSERT INTO `term_translations` VALUES ('18', '5', 'zh_TW', '網路攝影機', '', null);
INSERT INTO `term_translations` VALUES ('19', '6', 'zh_TW', '桌機', '', null);
INSERT INTO `term_translations` VALUES ('20', '7', 'zh_TW', '蘋果電腦', '', null);
INSERT INTO `term_translations` VALUES ('21', '8', 'zh_TW', 'PC', '', null);
INSERT INTO `term_translations` VALUES ('22', '9', 'zh_TW', '筆電', '', null);
INSERT INTO `term_translations` VALUES ('23', '10', 'zh_TW', '蘋果筆電', '', null);
INSERT INTO `term_translations` VALUES ('24', '11', 'zh_TW', 'Windows筆電', '', null);
INSERT INTO `term_translations` VALUES ('25', '12', 'zh_TW', '平板', '', null);
INSERT INTO `term_translations` VALUES ('26', '13', 'zh_TW', '軟體', '', null);
INSERT INTO `term_translations` VALUES ('27', '14', 'zh_TW', '服飾', '', null);
INSERT INTO `term_translations` VALUES ('28', '15', 'zh_TW', '短袖', '', null);
INSERT INTO `term_translations` VALUES ('29', '16', 'zh_TW', '短褲', '', null);
INSERT INTO `term_translations` VALUES ('30', '17', 'zh_TW', '長袖', '', null);
INSERT INTO `term_translations` VALUES ('31', '18', 'zh_TW', '長褲', '', null);
INSERT INTO `term_translations` VALUES ('32', '19', 'zh_TW', '內衣', '', null);
INSERT INTO `term_translations` VALUES ('33', '20', 'zh_TW', '100', '內褲', '');
INSERT INTO `term_translations` VALUES ('34', '21', 'zh_TW', '福利品', '', null);
INSERT INTO `term_translations` VALUES ('35', '22', 'zh_TW', '限時特價', '', null);
INSERT INTO `term_translations` VALUES ('36', '23', 'zh_TW', '服飾', '', null);
INSERT INTO `term_translations` VALUES ('37', '24', 'zh_TW', '男性', '', null);
INSERT INTO `term_translations` VALUES ('38', '25', 'zh_TW', '女性', '', null);
INSERT INTO `term_translations` VALUES ('39', '26', 'zh_TW', '夏季', '', null);
INSERT INTO `term_translations` VALUES ('40', '27', 'zh_TW', '冬季', '', null);
INSERT INTO `term_translations` VALUES ('41', '28', 'zh_TW', '運動', '', null);
INSERT INTO `term_translations` VALUES ('42', '29', 'zh_TW', '休閒', '', null);
INSERT INTO `term_translations` VALUES ('43', '30', 'zh_TW', '正式服裝', '', null);
INSERT INTO `term_translations` VALUES ('44', '31', 'zh_TW', '牛仔', '', null);
INSERT INTO `term_translations` VALUES ('45', '32', 'zh_TW', '時尚', '', '');
INSERT INTO `term_translations` VALUES ('56', '33', 'en', 'Size', '', null);
INSERT INTO `term_translations` VALUES ('57', '33', 'zh_TW', '尺寸', '', null);
INSERT INTO `term_translations` VALUES ('58', '34', 'en', 'Big', '', null);
INSERT INTO `term_translations` VALUES ('59', '35', 'en', 'Medium', '', null);
INSERT INTO `term_translations` VALUES ('60', '36', 'en', 'Small', '', null);
INSERT INTO `term_translations` VALUES ('61', '34', 'zh_TW', '大', '', null);
INSERT INTO `term_translations` VALUES ('62', '35', 'zh_TW', '中', '', null);
INSERT INTO `term_translations` VALUES ('63', '36', 'zh_TW', '小', '', null);
INSERT INTO `term_translations` VALUES ('87', '20', 'en', 'Underwear', '', '');
INSERT INTO `term_translations` VALUES ('95', '32', 'en', 'Fashion', '', '');
INSERT INTO `term_translations` VALUES ('103', '37', 'en', 'Processor', '', '');
INSERT INTO `term_translations` VALUES ('104', '37', 'zh_TW', '處理器', '', '');

-- ----------------------------
-- Table structure for `users`
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `display_name` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT 1,
  `is_admin` tinyint(1) NOT NULL DEFAULT 0,
  `last_login` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `users_username_index` (`username`),
  KEY `users_email_index` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=202 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'admin', 'Administrator', 'admin@example.org', null, '$2y$10$2j.Xz2b1UxZt950y5xexeOpxlUsg1oj2tgXEbGeG137nPIVHsVD8q', null, '1', '1', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('2', 'roscoe23', 'Dr. Claire Casper', 'helene.gleason@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Na02m9hyAz', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('3', 'collier.scarlett', 'Miguel Bauch', 'farrell.krystel@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CXAPc4hPZN', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('4', 'hoeger.isobel', 'Haven Stracke', 'sebastian12@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'kUJaO0bo2K', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('5', 'rosetta12', 'Mr. Cordell Casper', 'ydare@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'yCJe7naSUI', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('6', 'ena99', 'Delfina Goyette', 'lonnie21@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'qktuukxvJq', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('7', 'rkilback', 'Alessia Fahey', 'gorczany.napoleon@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'GL3HhEBh1O', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('8', 'mfritsch', 'Lionel Prosacco', 'lewis.schroeder@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MadoSdjsjs', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('9', 'bill.renner', 'Gabrielle Gerlach', 'marty81@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '8KCIG3SRDz', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('10', 'cole.valentine', 'William Beer', 'tatyana02@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'gpsnAHOWl6', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('11', 'sigurd21', 'Candace Wilderman', 'mjohnson@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'XLJvJ6GuMa', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('12', 'ulindgren', 'Roxane Jacobi', 'pbecker@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mAIIr3x6ra', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('13', 'macejkovic.selmer', 'Mrs. Frederique Trantow', 'alverta26@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'S9xQ6hzMoK', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('14', 'ftromp', 'Sydnie Nikolaus I', 'rory.schinner@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MkjpqWnULu', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('15', 'bogan.vivienne', 'Chester Trantow', 'dicki.antone@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '4IBCxgalZZ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('16', 'braun.dorcas', 'Prof. Stanley Bergnaum', 'elinore30@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pK3vOOdsqo', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('17', 'gfeil', 'Mr. Russ Zulauf', 'rohan.sim@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'U5JGWF1zRH', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('18', 'halvorson.denis', 'Vladimir Barrows DVM', 'eveline.oconnell@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1eG4yakJ5i', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('19', 'xquigley', 'Destinee Hermann', 'uschmitt@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nAWj2y74nS', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('20', 'fadel.tristin', 'Ona Mraz', 'prohan@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3U9IvbcGim', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('21', 'shanahan.ivory', 'Damion Baumbach', 'mollie08@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ALHEugN185', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('22', 'cecelia27', 'Drake Rogahn', 'keeling.bernardo@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1hgO6Rpa0G', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('23', 'lyric.streich', 'Kathryn Sanford', 'carley45@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0tf5aaWvbB', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('24', 'monahan.levi', 'Katarina Hamill', 'dario82@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'UcscQTezXU', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('25', 'xrohan', 'Prof. Victor West III', 'medhurst.eden@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '6KiJLiR0T6', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('26', 'shahn', 'Cordia Mayert PhD', 'bradford.dibbert@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Rn1KQMBtiI', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('27', 'alek55', 'Icie Swaniawski III', 'fern.homenick@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ayvxiaW9pf', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('28', 'london.nicolas', 'Karine Hoppe DVM', 'etha.walker@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Losr2IoDNN', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('29', 'jerald41', 'Vickie Little', 'rosendo.heaney@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'd83bpsp18f', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('30', 'nwindler', 'Antwan Emard', 'johns.wilma@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bkKtVhSisU', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('31', 'vframi', 'Kayleigh Bernhard', 'friedrich.oberbrunner@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'p2HIKruKmk', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('32', 'emcdermott', 'Mr. Kristofer Daugherty DDS', 'brock.powlowski@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'unPeiOeYZX', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('33', 'dupton', 'Emma Corwin I', 'tolson@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9DoAuPQTTu', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('34', 'stevie.hauck', 'Dahlia King', 'rowland.langworth@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'x8p4krQ85b', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('35', 'fannie.rosenbaum', 'Devante Balistreri III', 'jaqueline.bechtelar@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '47pz3b9Q0N', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('36', 'rosie43', 'Brando Runolfsson', 'xernser@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ajvm8t72ue', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('37', 'dora.moen', 'Roderick Larson', 'johann46@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'i3FwrVNwGZ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('38', 'kbauch', 'Destinee Bradtke DDS', 'nikko11@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'SWEFC2irxF', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('39', 'trantow.baby', 'Marley Cartwright Sr.', 'leuschke.therese@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Dbowa3cI84', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('40', 'dasia.conroy', 'Dr. Clementine D\'Amore I', 'oconnell.clinton@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '6mNYn3qq4F', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('41', 'vwalter', 'Caitlyn Green', 'brandi.lakin@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'vZwL9fTfwp', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('42', 'billie62', 'Miss Lesly Reichel IV', 'vshanahan@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'C1zVJoi8XG', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('43', 'green.turcotte', 'Prof. Terrell Erdman Jr.', 'jaeden.moen@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'G59YlkFr0k', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('44', 'victor.bernhard', 'Dr. Buster Kutch', 'vcremin@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'P7UCBmUrmA', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('45', 'oswaldo99', 'Kaia Davis', 'lura.kreiger@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'WPWJpCMA4P', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('46', 'streich.vito', 'Elmore Rohan', 'mcarter@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hM82zFuJvD', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('47', 'lelah58', 'Zola Crooks', 'pauline.wehner@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'QplvuyCQPF', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('48', 'daniel.arch', 'Cynthia Pacocha Sr.', 'denesik.alta@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aZYxmOemCY', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('49', 'linnie.toy', 'Coby Metz', 'zulauf.genesis@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '6VzQ05GpBB', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('50', 'ethelyn.runte', 'Ms. Krystal Mueller', 'harris.steve@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'JCgAmcmVbu', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('51', 'dbatz', 'Dr. Theresa Schuppe PhD', 'nader.anika@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jAoJSzRn62', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('52', 'mathias84', 'Jean Collier', 'hunter51@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'GeDpmlSC07', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('53', 'hbalistreri', 'Jailyn Rau', 'orn.deven@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'GrSh2QgZbB', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('54', 'chance.hackett', 'Elvie Schultz', 'kemmer.rigoberto@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MItVasAhpp', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('55', 'ycassin', 'Ryleigh Mohr', 'dena02@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ToJIK4tosP', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('56', 'ewintheiser', 'Mr. Micheal Zieme DVM', 'sandra.russel@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'NH1Wdme1Oe', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('57', 'rodriguez.emmanuel', 'Dr. Flo Gerhold II', 'dorian48@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cJLqgp6L2A', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('58', 'marks.fleta', 'Marty Spencer', 'oschowalter@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bqNGJaw2Xk', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('59', 'gauer', 'Mr. Eric Feest Sr.', 'vicente14@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '6T4AOBnBjv', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('60', 'renner.winona', 'Laurianne Kautzer', 'lazaro.hoppe@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'd7SOGVrgVo', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('61', 'lawson.gislason', 'Victoria Turcotte II', 'vankunding@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'En1pAfTfj9', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('62', 'jenkins.rodrigo', 'Lizeth Bernier', 'ted64@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9990OMMqCX', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('63', 'kelli.conn', 'Ivah Abshire', 'kulas.isabella@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ifvWCLknD1', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('64', 'charles.bahringer', 'Karine Ullrich', 'blanche99@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'n82SCYciCa', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('65', 'white.grady', 'Jesse Schmitt', 'qgreen@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jIXgZwfLcl', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('66', 'qrunte', 'Miss Myrna Windler', 'shanie.schowalter@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0LGkOmHh2i', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('67', 'sandrine.mante', 'Ms. Britney Heathcote', 'kody.rippin@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '7zF2jrCSxp', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('68', 'qlegros', 'Paul Simonis', 'leuschke.damon@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ILcTFqIdnY', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('69', 'jenkins.edwardo', 'Asha McLaughlin', 'madonna78@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'yc5xVQr44P', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('70', 'khettinger', 'Calista Kertzmann III', 'uvon@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bR8kFJwCPb', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('71', 'ehyatt', 'Gage Lowe', 'larkin.madelyn@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nuq8okyKWs', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('72', 'oberbrunner.alfonzo', 'Mrs. Adeline Considine', 'alene82@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Az8f3KqQYI', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('73', 'abruen', 'Micheal Frami', 'mitchell.marjory@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '17RS4eWn67', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('74', 'njakubowski', 'Mrs. Augustine Quigley DVM', 'wstark@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1FGJPvYtcx', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('75', 'leannon.hilario', 'Deshaun Wilkinson', 'dwilderman@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'g8F05x2j7l', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('76', 'francesca.towne', 'Prof. Walker Wiegand', 'stark.howard@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'HEwvW4XIjJ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('77', 'purdy.scarlett', 'Ms. Grace Hickle II', 'williamson.vivienne@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9efe78syyD', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('78', 'elyse07', 'Eva Hand II', 'cara86@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'q1ubFJawad', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('79', 'meta.hoppe', 'Micaela Schowalter', 'orrin27@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'qURxzFhRaL', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('80', 'uvonrueden', 'Philip Schoen DDS', 'hickle.nigel@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'avpcMg4S0a', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('81', 'ewalker', 'Jackson White', 'tromp.jazmyn@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'fAxtgyRtDG', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('82', 'johnston.marcel', 'Bill Wunsch', 'zackary.gleason@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'of4rg7mPRc', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('83', 'kutch.priscilla', 'Dawn Ortiz', 'xlangosh@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'evmm40waoW', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('84', 'bosco.sonia', 'Miss Filomena Wisozk I', 'polly.kuhlman@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hBFcwLPtxT', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('85', 'pink.schuppe', 'Miss Trycia Brekke', 'evalyn56@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1tsr12xrJZ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('86', 'murazik.alfreda', 'Miss Vivienne Stokes II', 'luis.smith@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'qOMNNAEMNk', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('87', 'buckridge.hans', 'Willie DuBuque', 'fwehner@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '6BmOn6v37N', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('88', 'greta.hermann', 'Anastasia Watsica', 'louvenia.willms@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'XizpzgQxFO', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('89', 'harber.jadon', 'Caterina Feeney', 'henriette.padberg@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MvI0KwubFT', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('90', 'abagail.hamill', 'Queenie Walter', 'dayton.zemlak@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OE0ODCLccJ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('91', 'bahringer.robbie', 'Kristina Kihn', 'ncasper@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'syVg9rDV1I', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('92', 'schaden.burdette', 'Flo Armstrong I', 'dorian.bernhard@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2sxiE2WXkR', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('93', 'evalyn71', 'Rosanna Thiel', 'candelario.moen@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '7pvQXYi7mJ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('94', 'antwon.aufderhar', 'Prof. Reggie Schulist II', 'wheidenreich@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'LB4ktnq0h5', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('95', 'sborer', 'Ms. Brigitte Kulas DVM', 'stokes.melyna@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'oFjkPqz2nV', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('96', 'kip.bosco', 'Leanna Herzog', 'kaycee.wuckert@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'C9DTlKBu86', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('97', 'bahringer.marianna', 'Raymond Bednar', 'wiegand.jairo@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'TRpry0UN4T', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('98', 'salma.jerde', 'Cletus Schimmel V', 'sabrina15@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'QvVwg5u1NW', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('99', 'jtreutel', 'Shemar Gerhold', 'sean41@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'I9ixlxSFOd', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('100', 'kenton16', 'Mr. Earl Jast', 'dora89@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9p2r6am1sF', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('101', 'ewill', 'Miss Elenor Daniel', 'kiehn.ruthe@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ojn2xCqO94', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('102', 'corbin.sauer', 'Lauren Howe DVM', 'adella00@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'AwQcxTCmjh', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('103', 'dietrich.opal', 'Rodger Douglas IV', 'stephany.schaden@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'd1bcEibTr0', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('104', 'nick.grady', 'Dr. Harley Parisian', 'dbeer@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mWn5PFuEJf', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('105', 'wolf.kenna', 'Fermin Kuhic II', 'izaiah.spinka@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'keOdT2eBlh', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('106', 'gusikowski.chaz', 'Abbie Hessel', 'kling.wendy@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9RDyVwwxcV', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('107', 'zachary.klein', 'Nedra Altenwerth', 'tdaugherty@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5GTr1TcmSk', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('108', 'senger.raul', 'Prof. Stefan Senger MD', 'beau00@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '8zUAai4tv9', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('109', 'tboyle', 'Prof. Ezequiel Gibson Jr.', 'lane.robel@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'B68Sg9Zsq5', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('110', 'felicia11', 'Mr. Leon O\'Connell I', 'kayli13@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'IMB5Vo1166', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('111', 'zrohan', 'Raleigh Yundt', 'christelle78@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'E83izX8xP3', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('112', 'cwaters', 'Dr. Favian Schumm III', 'pollich.patricia@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ljz3JNcMYZ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('113', 'pdietrich', 'Jayme Schulist', 'cgislason@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eQopk0p1Bd', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('114', 'nkohler', 'Hilda Heller', 'angelica.schowalter@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'KhLbIicnmz', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('115', 'macey.hegmann', 'Verlie Carroll Sr.', 'estella.shanahan@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'blG57lhKIT', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('116', 'pdicki', 'Miss Eveline Jones MD', 'fgoyette@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9JVhToQbUc', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('117', 'dschumm', 'Mrs. Lisette Kirlin', 'helene46@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3oXx325kds', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('118', 'marilou67', 'Aisha Okuneva', 'turner.melody@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '3oD0gs6IMn', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('119', 'wiza.mabelle', 'Bessie Murray', 'darren92@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ru2OJehvg6', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('120', 'vernon04', 'Dr. Jovany Grant', 'pfeffer.bethel@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'IEYkc8hvaq', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('121', 'ambrose67', 'Una Grant', 'rosalinda15@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'I5Q3ql0VWT', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('122', 'fsipes', 'Millie Nolan', 'lyla.torphy@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '81BvYQlDLF', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('123', 'ugottlieb', 'Roma Nader IV', 'dubuque.cullen@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 't99PZMAiLg', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('124', 'therese.kuphal', 'Mya Moen', 'nkunze@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'W19qq41rB9', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('125', 'yvette61', 'Myles Nader', 'thermiston@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'DylfuQOFRQ', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('126', 'reynold24', 'Mr. Van Schoen', 'umoen@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5U29o1qz9H', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('127', 'worn', 'Prof. Chanel Witting II', 'rohan.brandy@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wCMuL7ZxWP', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('128', 'hbruen', 'Dr. Adam Hand PhD', 'bobby.swaniawski@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'fjQdxYezTj', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('129', 'andrew22', 'Dr. Loren Abshire', 'emmalee.kunze@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ekWXAcfxHR', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('130', 'whitney95', 'Sallie Ziemann', 'alena55@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'OCM2Vpfy7m', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('131', 'kilback.marta', 'Mr. Cameron Stehr', 'xkessler@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'SN2xjlGGZv', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('132', 'mccullough.evan', 'Morton Abbott', 'alice.cremin@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nuVtJ20iI1', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('133', 'renner.garrett', 'Jonas Steuber', 'dina.kuphal@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '6VG6DEb9Fo', '1', '0', null, '2023-07-01 17:04:11', '2023-07-01 17:04:11');
INSERT INTO `users` VALUES ('134', 'nbreitenberg', 'Ms. Janessa Hahn', 'viva99@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ne2MCyCQVY', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('135', 'arianna.daugherty', 'Chelsie Renner PhD', 'uschmeler@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'v9jho9ren1', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('136', 'mconnelly', 'Breanne Nolan', 'wilkinson.ova@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'yLj8F10pBO', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('137', 'susana62', 'Destany Swaniawski PhD', 'mosciski.jan@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'UGynp3Bcky', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('138', 'claude.kilback', 'Javonte Auer II', 'kunde.rossie@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'pqsNsy1ifu', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('139', 'rutherford.elda', 'Henry Moore DDS', 'maurice.murray@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'VkcsU6PiLo', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('140', 'hbecker', 'Ms. Tianna Romaguera', 'tschinner@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'gDpNqvtJPq', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('141', 'marilyne.schmidt', 'Dr. Kurt Towne', 'horacio.orn@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9OQHzfmDU2', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('142', 'carmela.sanford', 'Gage Bosco', 'andreanne97@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'q0qpTOfvxA', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('143', 'tressa.keebler', 'Terrell Kutch', 'dkassulke@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'CU2fWOFdtg', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('144', 'julian64', 'Amalia Conn', 'dkihn@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '49BuzwrWiX', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('145', 'istoltenberg', 'Serenity Goodwin', 'benton32@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'AyBlwvXvbd', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('146', 'jan.smitham', 'Claude Buckridge MD', 'ngutkowski@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'GPb7D0Ew1c', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('147', 'predovic.irwin', 'Adele Boyer', 'bednar.damion@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'LGpN34C2PW', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('148', 'xwisozk', 'Prof. Toy Hauck', 'savanna.mann@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'mpsQtmL7Pc', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('149', 'keeling.lyla', 'Angeline Reichert', 'schaden.bartholome@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'JQCEDvyoC3', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('150', 'kessler.maida', 'Robyn Heller V', 'laron04@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'khTQdsTnmA', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('151', 'zack.lehner', 'Mr. Ansley West IV', 'ara90@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'l8QNDcVhNq', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('152', 'xherman', 'Myrtice Wilderman PhD', 'kuvalis.corine@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'W7uKfLmygE', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('153', 'gpfannerstill', 'Ezequiel Larson', 'xkunde@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'z7b7oQBfFP', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('154', 'karina68', 'Aliza Boehm', 'sydney.jacobs@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'yFoN0WQjkC', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('155', 'mackenzie.kovacek', 'Miss Leatha Adams', 'micheal14@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'K2eX9oWvpw', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('156', 'bernie29', 'Verner Thompson', 'paucek.thora@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'sDbAH0rmvn', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('157', 'larson.donna', 'Prof. Ara Klein I', 'rowena.wolff@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'v9e56RzSaD', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('158', 'marks.bridie', 'Prof. Amir Jast', 'edwin.conn@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Ytt65sQtGf', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('159', 'mack.weber', 'Charlie Bailey DVM', 'lina69@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bUFazvbhS5', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('160', 'oberbrunner.heaven', 'Mr. Wade Kovacek PhD', 'elueilwitz@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '9H6BmBWNke', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('161', 'rosemarie84', 'Jammie Raynor DDS', 'upton.ernestine@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0hx3JD01G3', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('162', 'kutch.connie', 'Ms. Lisa Willms I', 'daisha03@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '1AQPOeKlgs', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('163', 'zprosacco', 'Jasen Veum', 'devan.shanahan@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'fQtnZi2PvP', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('164', 'walsh.adella', 'Dr. Laurel Willms DVM', 'erdman.tracy@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'da0Vk0ng2Z', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('165', 'audra65', 'Iliana Volkman', 'jkiehn@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'XrstAXWkWm', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('166', 'alison.batz', 'Rosina Hyatt', 'ophelia.bayer@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'LI6YSX1yX8', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('167', 'pcassin', 'Cleve Heidenreich', 'bailey.antonina@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'wisYgMVYUZ', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('168', 'yundt.barney', 'Reyna Larkin Sr.', 'kemmer.ashton@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'psscAsWFFz', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('169', 'sandy.kautzer', 'Delphine Medhurst DVM', 'vallie07@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'uNl2lsP83F', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('170', 'margot.rempel', 'Alvera Runolfsdottir', 'luettgen.earline@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'AcNNrIpen9', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('171', 'xfisher', 'Kristian Koss V', 'kaylah44@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MV3DXqp58e', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('172', 'delfina54', 'Violet Nienow V', 'savannah04@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'eLGd2iEmBw', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('173', 'schuppe.neva', 'Prof. Ibrahim Hickle', 'kasandra60@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'ghuhGaIUvP', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('174', 'nikolaus.bryce', 'Eddie Williamson', 'kristina.ullrich@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '48MLHVDQB0', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('175', 'green.emory', 'Prof. Sherman Romaguera', 'pagac.fannie@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'VbUJq5TNfj', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('176', 'danial.tillman', 'Zula Dicki Sr.', 'vrempel@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'fEH96qD20h', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('177', 'qbednar', 'Royal Ward MD', 'yhegmann@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '41BDk465ur', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('178', 'wellington.crist', 'Brigitte Becker I', 'shirley80@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'aNfIV566IQ', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('179', 'paucek.lorena', 'Mrs. Kelly Heidenreich I', 'ben85@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'bsQEiEpoJY', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('180', 'iklein', 'Christiana Murray', 'heaven98@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'FEpgdy61bu', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('181', 'qullrich', 'Wilfred Mitchell', 'quigley.marcella@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'cVkY2fR3L6', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('182', 'zkovacek', 'Eldridge Cruickshank II', 'tillman.ashley@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '5VwX9nHOW0', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('183', 'cruickshank.rubye', 'Emerald Kohler', 'cecelia.grant@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'xi0ydgXCpp', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('184', 'brekke.helga', 'Adrain Durgan', 'ewilkinson@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2fKW8fnVZn', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('185', 'zachary37', 'Loma Ebert', 'hipolito47@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'VO6TVbsj9f', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('186', 'bgislason', 'Myrtie Shields I', 'qpfannerstill@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'PcaO0zAh8I', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('187', 'renner.alize', 'Anabel Mosciski', 'eosinski@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nojJWgKuhc', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('188', 'roob.lawrence', 'Lonny Brakus', 'zdibbert@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'jDrIioosCA', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('189', 'zdouglas', 'Heidi Stanton', 'rsipes@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EpgXRR0jsZ', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('190', 'kasey.emmerich', 'Mrs. Glenda Reichert', 'heather58@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'nnz3wmaEpT', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('191', 'waldo57', 'Claudie Kutch Jr.', 'juvenal46@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '2PFF7xAryw', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('192', 'haag.rico', 'Frieda Monahan', 'erobel@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'MxLWjyjoq5', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('193', 'qtrantow', 'Prof. Maeve Wilkinson IV', 'kschmidt@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'AEaVrbE0Yj', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('194', 'dayton01', 'Prof. Roscoe Carroll MD', 'kbartell@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'LubHkM3Crf', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('195', 'dcarter', 'Bella Bruen', 'leora.carter@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'lqJgYEiIim', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('196', 'kozey.oswald', 'Don Schinner', 'damore.gilbert@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Q6ov8QwETv', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('197', 'gerda72', 'Weldon Schmitt I', 'bdooley@example.com', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'EjNJk67Uwh', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('198', 'reagan.littel', 'Randal Cole', 'conrad.kling@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', '0K8fCp9aWS', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('199', 'allen12', 'Berenice Denesik', 'brown.jailyn@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'XWeSsYSMHn', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('200', 'kuhlman.gisselle', 'Mr. Arnaldo Beahan DVM', 'gbashirian@example.org', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'qwrc5Kt8ts', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');
INSERT INTO `users` VALUES ('201', 'mueller.sadye', 'Dr. Harrison Frami', 'werner67@example.net', '2023-07-01 17:04:11', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'hLpprfQpPW', '1', '0', null, '2023-07-01 17:04:12', '2023-07-01 17:04:12');

-- ----------------------------
-- Table structure for `user_logins`
-- ----------------------------
DROP TABLE IF EXISTS `user_logins`;
CREATE TABLE `user_logins` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint(20) unsigned NOT NULL,
  `ip` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_agent` varchar(40) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `user_logins_user_id_index` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_logins
-- ----------------------------

-- ----------------------------
-- Table structure for `user_metas`
-- ----------------------------
DROP TABLE IF EXISTS `user_metas`;
CREATE TABLE `user_metas` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `meta_key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `meta_value` longtext COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_metas_user_id_meta_key_unique` (`user_id`,`meta_key`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ----------------------------
-- Records of user_metas
-- ----------------------------
INSERT INTO `user_metas` VALUES ('1', '1', 'first_name', 'John');
INSERT INTO `user_metas` VALUES ('2', '1', 'last_name', 'Doe');
INSERT INTO `user_metas` VALUES ('3', '1', 'admin_last_active', '2023-07-01 17:04:12');
