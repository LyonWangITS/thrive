-- Remove 'skip' as a valid option for the field 'see_things_through_to_the_end'
ALTER TABLE `entries` MODIFY COLUMN `02_see_things_through_to_the_end` ENUM('agree-strongly','agree-somewhat','disagree-somewhat','disagree-strongly') DEFAULT NULL;

-- Remove 'skip' as a valid option for the field '09_tobacco_use'
ALTER TABLE `entries` MODIFY COLUMN `09_tobacco_use` enum('never','used_to_smoke_regularly','occasionally','regularly') DEFAULT NULL;
