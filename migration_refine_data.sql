-- Migration: Reset Expense Types and Add Supplier Contact Info
-- Created: 2026-02-09

-- 1. Reset Expense Types
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE `expense_types`;
SET FOREIGN_KEY_CHECKS = 1;

INSERT INTO `expense_types` (`id`, `name`) VALUES (1, 'Diversos');

-- 2. Add Contact Info to Suppliers
ALTER TABLE `suppliers`
ADD COLUMN `contact_name` VARCHAR(255) NULL AFTER `phone`,
ADD COLUMN `contact_phone` VARCHAR(20) NULL AFTER `contact_name`;

COMMIT;
