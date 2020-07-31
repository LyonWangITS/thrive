-- Remove time stamps for completion of each form stage
ALTER TABLE entries DROP COLUMN 01_completed datetime;
ALTER TABLE entries DROP COLUMN 02_completed datetime;
ALTER TABLE entries DROP COLUMN 03_completed datetime;
ALTER TABLE entries DROP COLUMN 04_completed datetime;
ALTER TABLE entries DROP COLUMN 05_completed datetime;
ALTER TABLE entries DROP COLUMN 06_completed datetime;
ALTER TABLE entries DROP COLUMN 07_completed datetime;
ALTER TABLE entries DROP COLUMN 08_completed datetime;
ALTER TABLE entries DROP COLUMN 09_completed datetime;
