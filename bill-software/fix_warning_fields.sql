-- Fix fields that are showing warnings

-- Fix Expiry - change from DATE to VARCHAR to accept 'N' and text dates
ALTER TABLE `items` MODIFY `Expiry` VARCHAR(50) NULL;

-- Fix splrate - change from DECIMAL to VARCHAR to accept '$0.00' format
ALTER TABLE `items` MODIFY `splrate` VARCHAR(50) NULL;

-- Fix Mrp - change from DECIMAL to VARCHAR to accept '$55.20' format
ALTER TABLE `items` MODIFY `Mrp` VARCHAR(50) NULL;

-- Fix ScmFrom - change from DATE to VARCHAR to accept '10-Aug-02' format
ALTER TABLE `items` MODIFY `ScmFrom` VARCHAR(50) NULL;

-- Fix ScmTo - change from DATE to VARCHAR to accept '10-Aug-02' format
ALTER TABLE `items` MODIFY `ScmTo` VARCHAR(50) NULL;

-- Fix DisContinue - change from BOOLEAN/INTEGER to VARCHAR to accept 'N' and 'Y'
ALTER TABLE `items` MODIFY `DisContinue` VARCHAR(10) NULL;

-- Fix FDisWR - change from DECIMAL to VARCHAR to accept spaces and text
ALTER TABLE `items` MODIFY `FDisWR` VARCHAR(50) NULL;
