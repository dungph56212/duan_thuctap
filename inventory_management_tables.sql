-- Inventory Management Database Tables
-- Run this SQL to add inventory tracking and alert functionality

-- Inventory History Table
CREATE TABLE IF NOT EXISTS `inventory_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `san_pham_id` int(11) NOT NULL,
  `old_quantity` int(11) NOT NULL DEFAULT 0,
  `new_quantity` int(11) NOT NULL DEFAULT 0,
  `change_quantity` int(11) NOT NULL DEFAULT 0,
  `change_type` enum('manual','order','cancel','adjustment','restock') NOT NULL DEFAULT 'manual',
  `user_id` int(11) DEFAULT NULL,
  `order_id` int(11) DEFAULT NULL,
  `note` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  KEY `san_pham_id` (`san_pham_id`),
  KEY `user_id` (`user_id`),
  KEY `order_id` (`order_id`),
  KEY `change_type` (`change_type`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Inventory Alerts Table
CREATE TABLE IF NOT EXISTS `inventory_alerts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `san_pham_id` int(11) NOT NULL,
  `alert_type` enum('low_stock','out_of_stock','overstocked','reorder_needed') NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `read_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `san_pham_id` (`san_pham_id`),
  KEY `alert_type` (`alert_type`),
  KEY `is_read` (`is_read`),
  KEY `created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add foreign key constraints
ALTER TABLE `inventory_history`
  ADD CONSTRAINT `inventory_history_san_pham_fk` FOREIGN KEY (`san_pham_id`) REFERENCES `san_phams` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `inventory_history_user_fk` FOREIGN KEY (`user_id`) REFERENCES `tai_khoans` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `inventory_history_order_fk` FOREIGN KEY (`order_id`) REFERENCES `don_hangs` (`id`) ON DELETE SET NULL;

ALTER TABLE `inventory_alerts`
  ADD CONSTRAINT `inventory_alerts_san_pham_fk` FOREIGN KEY (`san_pham_id`) REFERENCES `san_phams` (`id`) ON DELETE CASCADE;

-- Add indexes for better performance
CREATE INDEX `idx_inventory_history_compound` ON `inventory_history` (`san_pham_id`, `created_at`, `change_type`);
CREATE INDEX `idx_inventory_alerts_compound` ON `inventory_alerts` (`is_read`, `alert_type`, `created_at`);

-- Add some sample inventory history data (optional)
INSERT INTO `inventory_history` (`san_pham_id`, `old_quantity`, `new_quantity`, `change_quantity`, `change_type`, `note`, `created_at`) VALUES
(1, 0, 50, 50, 'restock', 'Initial stock setup', NOW() - INTERVAL 30 DAY),
(2, 0, 30, 30, 'restock', 'Initial stock setup', NOW() - INTERVAL 30 DAY),
(3, 0, 25, 25, 'restock', 'Initial stock setup', NOW() - INTERVAL 30 DAY);
