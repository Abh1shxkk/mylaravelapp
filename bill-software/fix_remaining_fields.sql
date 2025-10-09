-- First, clean up invalid date values in ScmFrom and ScmTo
UPDATE `items` SET `ScmFrom` = NULL WHERE `ScmFrom` = '0000-00-00' OR `ScmFrom` = '' OR `ScmFrom` IS NULL;
UPDATE `items` SET `ScmTo` = NULL WHERE `ScmTo` = '0000-00-00' OR `ScmTo` = '' OR `ScmTo` IS NULL;

-- Now modify the columns to VARCHAR
ALTER TABLE `items` MODIFY `ScmFrom` VARCHAR(50) NULL;
ALTER TABLE `items` MODIFY `ScmTo` VARCHAR(50) NULL;
ALTER TABLE `items` MODIFY `DisContinue` VARCHAR(10) NULL;
ALTER TABLE `items` MODIFY `FDisWR` VARCHAR(50) NULL;
