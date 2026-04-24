-- Gift card system schema update

CREATE TABLE `gift_cards` (
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

CREATE TABLE `gift_card_transactions` (
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
  MODIFY COLUMN `method` ENUM('cash', 'card', 'cheque', 'bank_transfer', 'advance', 'custom_pay_1', 'custom_pay_2', 'custom_pay_3', 'custom_pay_4', 'custom_pay_5', 'custom_pay_6', 'custom_pay_7', 'gift_card', 'other'),
  ADD COLUMN `gift_card_id` bigint unsigned NULL AFTER `transaction_id`,
  ADD INDEX `transaction_payments_gift_card_id_index` (`gift_card_id`),
  ADD CONSTRAINT `transaction_payments_gift_card_id_foreign` FOREIGN KEY (`gift_card_id`) REFERENCES `gift_cards` (`id`) ON DELETE SET NULL;
