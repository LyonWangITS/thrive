-- Add time stamps for viewing of sections of feedback page
ALTER TABLE entries ADD COLUMN final_page_section_timestamps JSON DEFAULT NULL;
