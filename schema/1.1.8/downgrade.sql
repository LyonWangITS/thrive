-- Drop 04_past_4wk_drinks_* fields from stage 04
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_drinks_sun`     int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_drinks_mon`     int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_drinks_tue`     int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_drinks_wed`     int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_drinks_thu`     int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_drinks_fri`     int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_drinks_sat`     int(11) DEFAULT NULL;

-- Drop 04_past_4wk_std_drinks_* fields from stage 04
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_std_drinks_sun` int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_std_drinks_mon` int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_std_drinks_tue` int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_std_drinks_wed` int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_std_drinks_thu` int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_std_drinks_fri` int(11) DEFAULT NULL;
ALTER TABLE `entries` ADD COLUMN `04_past_4wk_std_drinks_sat` int(11) DEFAULT NULL;
