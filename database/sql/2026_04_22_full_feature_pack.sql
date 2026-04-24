-- Full feature pack schema sync
-- Includes: Gift Card + Phase-1 (Promotion/Loyalty/Display) + Phase-2 (ESL/Scale)

SET FOREIGN_KEY_CHECKS = 1;

-- ------------------------------------------------------------
-- Gift Card System
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `gift_cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `contact_id` int unsigned DEFAULT NULL,
  `card_number` varchar(64) NOT NULL,
  `issue_amount` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `bonus_amount` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `initial_balance` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `current_balance` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `status` enum('active','inactive','expired') NOT NULL DEFAULT 'active',
  `expires_at` timestamp NULL DEFAULT NULL,
  `note` text,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gift_cards_business_id_card_number_unique` (`business_id`,`card_number`),
  KEY `gift_cards_business_id_index` (`business_id`),
  KEY `gift_cards_contact_id_index` (`contact_id`),
  KEY `gift_cards_status_index` (`status`),
  KEY `gift_cards_expires_at_index` (`expires_at`),
  KEY `gift_cards_created_by_foreign` (`created_by`),
  CONSTRAINT `gift_cards_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gift_cards_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `gift_cards_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `gift_card_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `gift_card_id` bigint unsigned NOT NULL,
  `transaction_id` int unsigned DEFAULT NULL,
  `transaction_payment_id` int unsigned DEFAULT NULL,
  `type` enum('issue','bonus','redeem','reversal','adjustment') NOT NULL,
  `amount` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `balance_before` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `balance_after` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `note` text,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gift_card_transactions_business_id_index` (`business_id`),
  KEY `gift_card_transactions_gift_card_id_index` (`gift_card_id`),
  KEY `gift_card_transactions_transaction_id_index` (`transaction_id`),
  KEY `gift_card_transactions_transaction_payment_id_index` (`transaction_payment_id`),
  KEY `gift_card_transactions_type_index` (`type`),
  KEY `gift_card_transactions_created_by_foreign` (`created_by`),
  CONSTRAINT `gift_card_transactions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gift_card_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `gift_card_transactions_gift_card_id_foreign` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gift_card_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `gift_card_transactions_transaction_payment_id_foreign` FOREIGN KEY (`transaction_payment_id`) REFERENCES `transaction_payments` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `transaction_payments`
  MODIFY COLUMN `method` ENUM('cash', 'card', 'cheque', 'bank_transfer', 'advance', 'custom_pay_1', 'custom_pay_2', 'custom_pay_3', 'custom_pay_4', 'custom_pay_5', 'custom_pay_6', 'custom_pay_7', 'gift_card', 'other');

SET @q = IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
   WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'transaction_payments' AND COLUMN_NAME = 'gift_card_id') = 0,
  'ALTER TABLE `transaction_payments` ADD COLUMN `gift_card_id` bigint unsigned NULL AFTER `transaction_id`, ADD INDEX `transaction_payments_gift_card_id_index` (`gift_card_id`), ADD CONSTRAINT `transaction_payments_gift_card_id_foreign` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`) ON DELETE SET NULL',
  'SELECT 1'
);
PREPARE stmt FROM @q; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------
-- Phase-1: Promotion + Loyalty
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `promotions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `rule_type` varchar(50) NOT NULL,
  `discount_type` varchar(20) DEFAULT NULL,
  `discount_value` decimal(22,4) DEFAULT NULL,
  `coupon_code` varchar(80) DEFAULT NULL,
  `target_scope` varchar(40) NOT NULL DEFAULT 'all_products',
  `target_id` bigint unsigned DEFAULT NULL,
  `min_order_total` decimal(22,4) DEFAULT NULL,
  `min_qty` decimal(22,4) DEFAULT NULL,
  `max_discount_amount` decimal(22,4) DEFAULT NULL,
  `buy_qty` decimal(22,4) DEFAULT NULL,
  `get_qty` decimal(22,4) DEFAULT NULL,
  `bundle_qty` decimal(22,4) DEFAULT NULL,
  `bundle_price` decimal(22,4) DEFAULT NULL,
  `tier_min_qty` decimal(22,4) DEFAULT NULL,
  `usage_limit_per_coupon` int DEFAULT NULL,
  `usage_limit_per_customer` int DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `priority` int NOT NULL DEFAULT 1,
  `starts_at` timestamp NULL DEFAULT NULL,
  `ends_at` timestamp NULL DEFAULT NULL,
  `notes` text,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotions_business_id_index` (`business_id`),
  KEY `promotions_rule_type_index` (`rule_type`),
  KEY `promotions_coupon_code_index` (`coupon_code`),
  KEY `promotions_target_id_index` (`target_id`),
  KEY `promotions_is_active_index` (`is_active`),
  KEY `promotions_priority_index` (`priority`),
  KEY `promotions_starts_at_index` (`starts_at`),
  KEY `promotions_ends_at_index` (`ends_at`),
  KEY `promotions_created_by_foreign` (`created_by`),
  CONSTRAINT `promotions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `promotion_usages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `promotion_id` bigint unsigned NOT NULL,
  `transaction_id` int unsigned DEFAULT NULL,
  `contact_id` int unsigned DEFAULT NULL,
  `coupon_code` varchar(80) DEFAULT NULL,
  `discount_amount` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `meta` text,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promotion_usages_business_id_index` (`business_id`),
  KEY `promotion_usages_promotion_id_index` (`promotion_id`),
  KEY `promotion_usages_transaction_id_index` (`transaction_id`),
  KEY `promotion_usages_contact_id_index` (`contact_id`),
  KEY `promotion_usages_coupon_code_index` (`coupon_code`),
  KEY `promotion_usages_created_by_foreign` (`created_by`),
  CONSTRAINT `promotion_usages_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotion_usages_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `promotion_usages_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `promotion_usages_promotion_id_foreign` FOREIGN KEY (`promotion_id`) REFERENCES `promotions` (`id`) ON DELETE CASCADE,
  CONSTRAINT `promotion_usages_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @q = IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'transactions' AND COLUMN_NAME = 'promotion_code') = 0,
  'ALTER TABLE `transactions` ADD COLUMN `promotion_code` varchar(80) NULL AFTER `discount_amount`, ADD COLUMN `promotion_discount_amount` decimal(22,4) NOT NULL DEFAULT ''0.0000'' AFTER `promotion_code`, ADD COLUMN `promotion_meta` text NULL AFTER `promotion_discount_amount`, ADD INDEX `transactions_promotion_code_index` (`promotion_code`)',
  'SELECT 1'
);
PREPARE stmt FROM @q; EXECUTE stmt; DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS `loyalty_tiers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `level` int NOT NULL DEFAULT 1,
  `min_total_points` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `min_lifetime_sales` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `bonus_multiplier` decimal(12,4) NOT NULL DEFAULT '1.0000',
  `extra_discount_percent` decimal(12,4) NOT NULL DEFAULT '0.0000',
  `is_active` tinyint NOT NULL DEFAULT 1,
  `benefits` text,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loyalty_tiers_business_id_index` (`business_id`),
  KEY `loyalty_tiers_level_index` (`level`),
  KEY `loyalty_tiers_is_active_index` (`is_active`),
  KEY `loyalty_tiers_created_by_foreign` (`created_by`),
  CONSTRAINT `loyalty_tiers_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty_tiers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET @q = IF(
  (SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'contacts' AND COLUMN_NAME = 'loyalty_tier_id') = 0,
  'ALTER TABLE `contacts` ADD COLUMN `loyalty_tier_id` bigint unsigned NULL AFTER `customer_group_id`, ADD COLUMN `lifetime_sale_total` decimal(22,4) NOT NULL DEFAULT ''0.0000'' AFTER `total_rp_used`, ADD INDEX `contacts_loyalty_tier_id_index` (`loyalty_tier_id`), ADD CONSTRAINT `contacts_loyalty_tier_id_foreign` FOREIGN KEY (`loyalty_tier_id`) REFERENCES `loyalty_tiers` (`id`) ON DELETE SET NULL',
  'SELECT 1'
);
PREPARE stmt FROM @q; EXECUTE stmt; DEALLOCATE PREPARE stmt;

CREATE TABLE IF NOT EXISTS `loyalty_point_ledgers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `contact_id` int unsigned NOT NULL,
  `transaction_id` int unsigned DEFAULT NULL,
  `entry_type` varchar(30) NOT NULL,
  `points` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `balance_after` decimal(22,4) NOT NULL DEFAULT '0.0000',
  `note` text,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `loyalty_point_ledgers_business_id_index` (`business_id`),
  KEY `loyalty_point_ledgers_contact_id_index` (`contact_id`),
  KEY `loyalty_point_ledgers_transaction_id_index` (`transaction_id`),
  KEY `loyalty_point_ledgers_entry_type_index` (`entry_type`),
  KEY `loyalty_point_ledgers_created_by_foreign` (`created_by`),
  CONSTRAINT `loyalty_point_ledgers_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty_point_ledgers_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE CASCADE,
  CONSTRAINT `loyalty_point_ledgers_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `loyalty_point_ledgers_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- Phase-2: ESL + Weighing Scale
-- ------------------------------------------------------------

CREATE TABLE IF NOT EXISTS `esl_devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `vendor` varchar(60) NOT NULL DEFAULT 'generic',
  `device_name` varchar(120) NOT NULL,
  `device_identifier` varchar(120) DEFAULT NULL,
  `location_ref` varchar(120) DEFAULT NULL,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `esl_devices_business_id_index` (`business_id`),
  KEY `esl_devices_vendor_index` (`vendor`),
  KEY `esl_devices_device_identifier_index` (`device_identifier`),
  KEY `esl_devices_is_active_index` (`is_active`),
  KEY `esl_devices_created_by_foreign` (`created_by`),
  CONSTRAINT `esl_devices_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `esl_devices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `esl_sync_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `product_id` int unsigned DEFAULT NULL,
  `esl_device_id` bigint unsigned DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'pending',
  `payload` text,
  `response_body` text,
  `error_message` text,
  `synced_at` timestamp NULL DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `esl_sync_logs_business_id_index` (`business_id`),
  KEY `esl_sync_logs_product_id_index` (`product_id`),
  KEY `esl_sync_logs_esl_device_id_index` (`esl_device_id`),
  KEY `esl_sync_logs_status_index` (`status`),
  KEY `esl_sync_logs_synced_at_index` (`synced_at`),
  KEY `esl_sync_logs_created_by_foreign` (`created_by`),
  CONSTRAINT `esl_sync_logs_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `esl_sync_logs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `esl_sync_logs_esl_device_id_foreign` FOREIGN KEY (`esl_device_id`) REFERENCES `esl_devices` (`id`) ON DELETE SET NULL,
  CONSTRAINT `esl_sync_logs_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `scale_devices` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `vendor` varchar(60) NOT NULL DEFAULT 'generic',
  `name` varchar(120) NOT NULL,
  `connection_type` varchar(30) NOT NULL DEFAULT 'tcp',
  `host` varchar(150) DEFAULT NULL,
  `port` int DEFAULT NULL,
  `serial_port` varchar(80) DEFAULT NULL,
  `api_url` varchar(255) DEFAULT NULL,
  `api_key` varchar(191) DEFAULT NULL,
  `is_default` tinyint NOT NULL DEFAULT 0,
  `is_active` tinyint NOT NULL DEFAULT 1,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scale_devices_business_id_index` (`business_id`),
  KEY `scale_devices_vendor_index` (`vendor`),
  KEY `scale_devices_connection_type_index` (`connection_type`),
  KEY `scale_devices_is_active_index` (`is_active`),
  KEY `scale_devices_created_by_foreign` (`created_by`),
  CONSTRAINT `scale_devices_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `scale_devices_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `scale_read_logs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `scale_device_id` bigint unsigned DEFAULT NULL,
  `weight` decimal(22,6) DEFAULT NULL,
  `unit` varchar(20) DEFAULT NULL,
  `barcode` varchar(64) DEFAULT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'success',
  `response_body` text,
  `error_message` text,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `scale_read_logs_business_id_index` (`business_id`),
  KEY `scale_read_logs_scale_device_id_index` (`scale_device_id`),
  KEY `scale_read_logs_barcode_index` (`barcode`),
  KEY `scale_read_logs_status_index` (`status`),
  KEY `scale_read_logs_created_by_foreign` (`created_by`),
  CONSTRAINT `scale_read_logs_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `scale_read_logs_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL,
  CONSTRAINT `scale_read_logs_scale_device_id_foreign` FOREIGN KEY (`scale_device_id`) REFERENCES `scale_devices` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

