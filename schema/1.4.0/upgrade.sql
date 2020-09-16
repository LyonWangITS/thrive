-- Add additional Effects of Drinking at Stage 5
ALTER TABLE entries ADD COLUMN 05_tried_to_limit_amount_drank enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 05_tried_to_resist_opportunity_to_start_drinking enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 05_tried_to_slow_my_drinking enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 05_tried_to_drink_less enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL;
ALTER TABLE entries ADD COLUMN 05_tried_to_stop_drinking enum('never', 'rarely', 'sometimes', 'often', 'always', 'skip') DEFAULT NULL;
