-- Migration: Add Expense Types
-- Created: 2026-02-09
-- Description: Creates expense_types table and updates materials table to support expense categorization

-- Create expense_types table
CREATE TABLE IF NOT EXISTS `expense_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `created_at` timestamp DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default expense type "Diversas"
INSERT INTO `expense_types` (`name`) VALUES ('Diversas');

-- Add expense_type_id column to materials table
ALTER TABLE `materials` ADD COLUMN `expense_type_id` int(11) DEFAULT 1 AFTER `name`;

-- Update existing materials to use "Diversas" type
UPDATE `materials` SET `expense_type_id` = 1 WHERE `expense_type_id` IS NULL OR `expense_type_id` = 0;

-- Add foreign key constraint
ALTER TABLE `materials` 
  ADD CONSTRAINT `fk_materials_expense_type` 
  FOREIGN KEY (`expense_type_id`) REFERENCES `expense_types` (`id`) 
  ON DELETE RESTRICT;

-- Insert some common expense types
INSERT INTO `expense_types` (`name`) VALUES 
  ('Mão de Obra'),
  ('Materiais de Construção'),
  ('Ferramentas'),
  ('Transporte'),
  ('Alimentação'),
  ('Equipamentos');

COMMIT;
