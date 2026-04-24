-- =============================================================================
-- Gift card feature — raw SQL equivalent of Laravel migrations:
--   2026_04_22_120000_create_gift_cards_table
--   2026_04_22_120100_create_gift_card_transactions_table
--   2026_04_22_120200_add_gift_card_fields_to_transaction_payments_table
--   2026_04_25_000000_add_linked_sale_id_to_gift_cards_table
--
-- Target: MySQL / MariaDB (InnoDB). Backup before run.
--
-- Usage:
--   • Fresh DB (no gift tables): run sections 1 → 2 → 3 → 4.
--   • Already ran Laravel migrations: sections 3–4 detect existing columns and skip safely.
--   • Section 3a (ENUM) is separate — only run if `method` does not yet allow `gift_card`.
-- =============================================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- -----------------------------------------------------------------------------
-- 1) gift_cards (original migration — no linked_sale_id yet)
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gift_cards` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `contact_id` int unsigned DEFAULT NULL,
  `card_number` varchar(64) NOT NULL,
  `issue_amount` decimal(22,4) NOT NULL DEFAULT 0.0000,
  `bonus_amount` decimal(22,4) NOT NULL DEFAULT 0.0000,
  `initial_balance` decimal(22,4) NOT NULL DEFAULT 0.0000,
  `current_balance` decimal(22,4) NOT NULL DEFAULT 0.0000,
  `status` enum('active','inactive','expired') NOT NULL DEFAULT 'active',
  `expires_at` timestamp NULL DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `gift_cards_business_id_card_number_unique` (`business_id`,`card_number`),
  KEY `gift_cards_business_id_index` (`business_id`),
  KEY `gift_cards_contact_id_index` (`contact_id`),
  KEY `gift_cards_card_number_index` (`card_number`),
  KEY `gift_cards_status_index` (`status`),
  KEY `gift_cards_expires_at_index` (`expires_at`),
  CONSTRAINT `gift_cards_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gift_cards_contact_id_foreign` FOREIGN KEY (`contact_id`) REFERENCES `contacts` (`id`) ON DELETE SET NULL,
  CONSTRAINT `gift_cards_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- -----------------------------------------------------------------------------
-- 2) gift_card_transactions
-- -----------------------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `gift_card_transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `business_id` int unsigned NOT NULL,
  `gift_card_id` bigint unsigned NOT NULL,
  `transaction_id` int unsigned DEFAULT NULL,
  `transaction_payment_id` int unsigned DEFAULT NULL,
  `type` enum('issue','bonus','redeem','reversal','adjustment') NOT NULL,
  `amount` decimal(22,4) NOT NULL DEFAULT 0.0000,
  `balance_before` decimal(22,4) NOT NULL DEFAULT 0.0000,
  `balance_after` decimal(22,4) NOT NULL DEFAULT 0.0000,
  `note` text DEFAULT NULL,
  `created_by` int unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gift_card_transactions_business_id_index` (`business_id`),
  KEY `gift_card_transactions_gift_card_id_index` (`gift_card_id`),
  KEY `gift_card_transactions_transaction_id_index` (`transaction_id`),
  KEY `gift_card_transactions_transaction_payment_id_index` (`transaction_payment_id`),
  KEY `gift_card_transactions_type_index` (`type`),
  CONSTRAINT `gift_card_transactions_business_id_foreign` FOREIGN KEY (`business_id`) REFERENCES `business` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gift_card_transactions_gift_card_id_foreign` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`) ON DELETE CASCADE,
  CONSTRAINT `gift_card_transactions_transaction_id_foreign` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL,
  CONSTRAINT `gift_card_transactions_transaction_payment_id_foreign` FOREIGN KEY (`transaction_payment_id`) REFERENCES `transaction_payments` (`id`) ON DELETE SET NULL,
  CONSTRAINT `gift_card_transactions_created_by_foreign` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;

-- -----------------------------------------------------------------------------
-- 3) transaction_payments
-- -----------------------------------------------------------------------------

-- 3a) ENUM — run ONLY if `gift_card` is not yet allowed on `method`.
--     WARNING: MODIFY replaces the whole ENUM; if your DB has extra values, merge them
--     into this list before running. If Laravel already migrated this, skip 3a.
-- -----------------------------------------------------------------------------
-- ALTER TABLE `transaction_payments`
--   MODIFY COLUMN `method` ENUM(
--     'cash','card','cheque','bank_transfer','advance',
--     'custom_pay_1','custom_pay_2','custom_pay_3','custom_pay_4','custom_pay_5','custom_pay_6','custom_pay_7',
--     'gift_card','other'
--   ) NOT NULL;

-- 3b) gift_card_id + FK — skipped automatically if column already exists (e.g. after `php artisan migrate`).
SET @db := DATABASE();
SET @gift_card_col_exists := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = @db
    AND TABLE_NAME = 'transaction_payments'
    AND COLUMN_NAME = 'gift_card_id'
);
SET @sql_add_gift_card_id := IF(
  @gift_card_col_exists > 0,
  'SELECT ''transaction_payments.gift_card_id already exists — skipped'' AS migration_notice',
  'ALTER TABLE `transaction_payments` ADD COLUMN `gift_card_id` bigint unsigned NULL DEFAULT NULL AFTER `transaction_id`, ADD KEY `transaction_payments_gift_card_id_index` (`gift_card_id`), ADD CONSTRAINT `transaction_payments_gift_card_id_foreign` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`) ON DELETE SET NULL'
);
PREPARE stmt_add_gift_card_id FROM @sql_add_gift_card_id;
EXECUTE stmt_add_gift_card_id;
DEALLOCATE PREPARE stmt_add_gift_card_id;

-- -----------------------------------------------------------------------------
-- 4) gift_cards.linked_sale_id — skipped if column already exists
-- -----------------------------------------------------------------------------
SET @linked_sale_col_exists := (
  SELECT COUNT(*) FROM information_schema.COLUMNS
  WHERE TABLE_SCHEMA = @db
    AND TABLE_NAME = 'gift_cards'
    AND COLUMN_NAME = 'linked_sale_id'
);
SET @sql_add_linked_sale := IF(
  @linked_sale_col_exists > 0,
  'SELECT ''gift_cards.linked_sale_id already exists — skipped'' AS migration_notice',
  'ALTER TABLE `gift_cards` ADD COLUMN `linked_sale_id` int unsigned NULL DEFAULT NULL AFTER `contact_id`, ADD CONSTRAINT `gift_cards_linked_sale_id_foreign` FOREIGN KEY (`linked_sale_id`) REFERENCES `transactions` (`id`) ON DELETE SET NULL'
);
PREPARE stmt_add_linked_sale FROM @sql_add_linked_sale;
EXECUTE stmt_add_linked_sale;
DEALLOCATE PREPARE stmt_add_linked_sale;

-- =============================================================================
-- ROLLBACK (optional — run only if you need to remove this feature manually)
-- =============================================================================
-- SET FOREIGN_KEY_CHECKS = 0;
-- ALTER TABLE `gift_cards` DROP FOREIGN KEY `gift_cards_linked_sale_id_foreign`;
-- ALTER TABLE `gift_cards` DROP COLUMN `linked_sale_id`;
-- ALTER TABLE `transaction_payments` DROP FOREIGN KEY `transaction_payments_gift_card_id_foreign`;
-- ALTER TABLE `transaction_payments` DROP COLUMN `gift_card_id`;
-- -- Restore old ENUM without gift_card (adjust list to your previous schema):
-- ALTER TABLE `transaction_payments` MODIFY COLUMN `method` ENUM(
--   'cash','card','cheque','bank_transfer','advance',
--   'custom_pay_1','custom_pay_2','custom_pay_3','custom_pay_4','custom_pay_5','custom_pay_6','custom_pay_7','other'
-- ) NOT NULL;
-- DROP TABLE IF EXISTS `gift_card_transactions`;
-- DROP TABLE IF EXISTS `gift_cards`;
-- SET FOREIGN_KEY_CHECKS = 1;
