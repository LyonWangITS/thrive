-- Add time stamps for completion of each form stage
ALTER TABLE entries ADD COLUMN 01_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 02_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 03_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 04_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 05_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 06_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 07_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 08_completed datetime DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 09_completed datetime DEFAULT NULL;
