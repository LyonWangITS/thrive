-- Remove additional Effects of Drinking at Stage 5
ALTER TABLE entries DROP COLUMN 05_tried_to_limit_amount_drank;
ALTER TABLE entries DROP COLUMN 05_tried_to_resist_opportunity_to_start_drinking;
ALTER TABLE entries DROP COLUMN 05_tried_to_slow_my_drinking;
ALTER TABLE entries DROP COLUMN 05_tried_to_drink_less;
ALTER TABLE entries DROP COLUMN 05_tried_to_stop_drinking;
