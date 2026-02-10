-- Migration: Create Work Suppliers Link Table
-- Created: 2026-02-09

CREATE TABLE IF NOT EXISTS `work_suppliers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `work_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_work_supplier` (`work_id`, `supplier_id`),
  CONSTRAINT `fk_work_suppliers_work` FOREIGN KEY (`work_id`) REFERENCES `works` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_work_suppliers_supplier` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Optional: If we want to verify linking, we can check existing expenses and auto-link?
-- For now, let's keep it manual or implicit.
-- SELECT DISTINCT work_id, supplier_id FROM materials WHERE work_id IS NOT NULL AND supplier_id IS NOT NULL;
-- We could run an INSERT IGNORE based on existing data to pre-populate links:
INSERT IGNORE INTO `work_suppliers` (`work_id`, `supplier_id`)
SELECT DISTINCT `work_id`, `supplier_id` FROM `materials` WHERE `work_id` IS NOT NULL AND `supplier_id` IS NOT NULL;

COMMIT;
