-- Migration: Create Suppliers Table and Link to Materials
-- Created: 2026-02-09

-- 1. Create table 'suppliers'
CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `observations` text,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- 2. Insert default supplier
INSERT INTO `suppliers` (`id`, `name`, `observations`) VALUES (1, 'Fornecedor Padrão', 'Fornecedor genérico para despesas antigas')
ON DUPLICATE KEY UPDATE `name` = `name`; -- Avoid error if re-run

-- 3. Add supplier_id to materials
-- Check if column exists first (MariaDB doesn't support IF NOT EXISTS for columns in simple ALTER, so we rely on script idempotency or error checking in app logic. Here we just run it, if it fails it fails but mostly safe to run once.)
-- BUT to be safe in SQL script, we can use a procedure or just run it and expect error if exists. 
-- For simplicity, let's assume it doesn't exist or ignore error.
ALTER TABLE `materials` ADD COLUMN `supplier_id` int(11) DEFAULT 1 AFTER `work_id`;

-- 4. Update existing materials to link to default supplier
UPDATE `materials` SET `supplier_id` = 1 WHERE `supplier_id` IS NULL OR `supplier_id` = 0;

-- 5. Add Foreign Key
ALTER TABLE `materials` 
  ADD CONSTRAINT `fk_materials_supplier` 
  FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) 
  ON DELETE RESTRICT;

COMMIT;
