-- Migration: fix_people_service_type_constraint
-- Description: Updates the service_type check constraint to support Portuguese terms and migrates existing data.

-- 1. Remove old constraint
ALTER TABLE people DROP CONSTRAINT IF EXISTS people_service_type_check;

-- 2. Update existing 'daily' data to 'diaria'
UPDATE people SET service_type = 'diaria' WHERE service_type = 'daily';

-- 3. Add new constraint with supported terms (Portuguese and English)
ALTER TABLE people ADD CONSTRAINT people_service_type_check 
    CHECK (service_type = ANY (ARRAY['diaria'::text, 'empreitada'::text, 'mensal'::text, 'daily'::text, 'contract'::text, 'production'::text]));
