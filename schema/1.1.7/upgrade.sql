-- Add 'some-time' to the valid values on the form 07 fields
ALTER TABLE entries CHANGE `07_count_drinks` `07_count_drinks` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_set_number_drinks` `07_set_number_drinks` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_eat_before` `07_eat_before` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_space_drinks_out` `07_space_drinks_out` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_alternate_drinks` `07_alternate_drinks` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_drink_for_quality` `07_drink_for_quality` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_avoid_drinking_games` `07_avoid_drinking_games` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_have_a_reliable_driver` `07_have_a_reliable_driver` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_preplan_transportation` `07_preplan_transportation` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_dst_protection` `07_dst_protection` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_watch_out_for_each_other` `07_watch_out_for_each_other` ENUM('never','almost-never','sort-time','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;

-- Change 'sort-time' to 'some-time' on the form 07 fields
UPDATE entries SET `07_count_drinks` = 'some-time' WHERE `07_count_drinks` = 'sort-time';
UPDATE entries SET `07_set_number_drinks` = 'some-time' WHERE `07_set_number_drinks` = 'sort-time';
UPDATE entries SET `07_eat_before` = 'some-time' WHERE `07_eat_before` = 'sort-time';
UPDATE entries SET `07_space_drinks_out` = 'some-time' WHERE `07_space_drinks_out` = 'sort-time';
UPDATE entries SET `07_alternate_drinks` = 'some-time' WHERE `07_alternate_drinks` = 'sort-time';
UPDATE entries SET `07_drink_for_quality` = 'some-time' WHERE `07_drink_for_quality` = 'sort-time';
UPDATE entries SET `07_avoid_drinking_games` = 'some-time' WHERE `07_avoid_drinking_games` = 'sort-time';
UPDATE entries SET `07_have_a_reliable_driver` = 'some-time' WHERE `07_have_a_reliable_driver` = 'sort-time';
UPDATE entries SET `07_preplan_transportation` = 'some-time' WHERE `07_preplan_transportation` = 'sort-time';
UPDATE entries SET `07_dst_protection` = 'some-time' WHERE `07_dst_protection` = 'sort-time';
UPDATE entries SET `07_watch_out_for_each_other` = 'some-time' WHERE `07_watch_out_for_each_other` = 'sort-time';

-- Remove 'sort-time' from the valid values on the form 07 fields
ALTER TABLE entries CHANGE `07_count_drinks` `07_count_drinks` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_set_number_drinks` `07_set_number_drinks` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_eat_before` `07_eat_before` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_space_drinks_out` `07_space_drinks_out` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_alternate_drinks` `07_alternate_drinks` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_drink_for_quality` `07_drink_for_quality` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_avoid_drinking_games` `07_avoid_drinking_games` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_have_a_reliable_driver` `07_have_a_reliable_driver` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_preplan_transportation` `07_preplan_transportation` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_dst_protection` `07_dst_protection` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;
ALTER TABLE entries CHANGE `07_watch_out_for_each_other` `07_watch_out_for_each_other` ENUM('never','almost-never','some-time','half-time','most-time','almost-always','always','skip') DEFAULT NULL;

