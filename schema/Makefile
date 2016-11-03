include /vagrant/.env

DUMP_SCHEMA_DEV := schema.sql
DUMP_DATA_DEV := data.sql

FLAGS_SCHEMA_ONLY := --no-data		  --skip-lock-tables --triggers --routines --events --skip-add-locks --skip-comments
FLAGS_DATA_ONLY   := --no-create-info --skip-lock-tables --skip-add-locks --skip-comments --skip-extended-insert --no-create-db

help:
	@echo "Run one of these targets"
	@echo "  dump_schema            Dump only the database schemaq"
	@echo "  dump_minimal_data      Dump only the data need by every instance of the app"
	@echo "  dump_testing_data      Dump data need to instantiate the dev instance"
	@echo "  dump_dev               All of the above"

dump_schema:
	mysqldump $(FLAGS_SCHEMA_ONLY) $(DB) | sed -e 's/AUTO_INCREMENT=[[:digit:]]* //' | sed "/50013 DEFINER=/d" > $(DUMP_SCHEMA_DEV)
	grep 'CREATE TABLE' $(DUMP_SCHEMA_DEV) | wc -l

dump_minimal_data:
	mysqldump $(FLAGS_DATA_ONLY) \
	--ignore-table=$(DB).cake_sessions \
	--ignore-table=$(DB).email_tracks \
	--ignore-table=$(DB).login_attempts \
	--ignore-table=$(DB).lu_activity_seasons_medical_history_updates \
	--ignore-table=$(DB).lu_activity_seasons_subject_histories \
	--ignore-table=$(DB).lu_age_first_symptoms_subject_histories \
	--ignore-table=$(DB).lu_alternative_treatments_subject_histories \
	--ignore-table=$(DB).lu_muscle_lower_updates_medical_history_updates \
	--ignore-table=$(DB).lu_muscle_lower_updates_subject_histories \
	--ignore-table=$(DB).lu_muscle_upper_updates_medical_history_updates \
	--ignore-table=$(DB).lu_muscle_upper_updates_subject_histories \
	--ignore-table=$(DB).lu_stretch_perf_updates_medical_history_updates \
	--ignore-table=$(DB).lu_stretch_perf_updates_subject_histories \
	--ignore-table=$(DB).access_logs \
	--ignore-table=$(DB).activities \
	--ignore-table=$(DB).additional_uploads \
	--ignore-table=$(DB).adverse_events \
	--ignore-table=$(DB).analyzed_images \
	--ignore-table=$(DB).biodex_tests \
	--ignore-table=$(DB).child_reports \
	--ignore-table=$(DB).control_consents \
	--ignore-table=$(DB).corticosteroid_medication_logs \
	--ignore-table=$(DB).corticosteroid_physician_checklists \
	--ignore-table=$(DB).deviations \
	--ignore-table=$(DB).fads \
	--ignore-table=$(DB).fas \
	--ignore-table=$(DB).file_downloads \
	--ignore-table=$(DB).followup_med_logs \
	--ignore-table=$(DB).foot_postures \
	--ignore-table=$(DB).genetic_informations \
	--ignore-table=$(DB).initial_med_logs \
	--ignore-table=$(DB).lu_ethnicities_people \
	--ignore-table=$(DB).lu_races_people \
	--ignore-table=$(DB).maintenance_tables \
	--ignore-table=$(DB).marketing_downloads \
	--ignore-table=$(DB).medical_history_updates \
	--ignore-table=$(DB).mops \
	--ignore-table=$(DB).mr_screen_inds \
	--ignore-table=$(DB).mr_screen_pars \
	--ignore-table=$(DB).optional_blood_consents \
	--ignore-table=$(DB).optional_sample_bloods \
	--ignore-table=$(DB).optional_sample_urines \
	--ignore-table=$(DB).optional_sample_salivas \
	--ignore-table=$(DB).parent_family_modules \
	--ignore-table=$(DB).parent_reports_children \
	--ignore-table=$(DB).parent_reports_teens \
	--ignore-table=$(DB).parent_reports_young_children \
	--ignore-table=$(DB).person_status_histories \
	--ignore-table=$(DB).person_study_histories \
	--ignore-table=$(DB).qol_consents \
	--ignore-table=$(DB).safety_report_aim4s \
	--ignore-table=$(DB).safety_report_demos \
	--ignore-table=$(DB).sample_track_bloods \
	--ignore-table=$(DB).sample_track_skins \
	--ignore-table=$(DB).scheduling_report_temp \
	--ignore-table=$(DB).schedulings \
	--ignore-table=$(DB).subject_data_reports \
	--ignore-table=$(DB).subject_histories \
	--ignore-table=$(DB).tanner_stages \
	--ignore-table=$(DB).teen_reports \
	--ignore-table=$(DB).tickets \
	--ignore-table=$(DB).upload_mri_datasheets \
	--ignore-table=$(DB).upload_users \
	--ignore-table=$(DB).weight_height_roms \
	--ignore-table=$(DB).young_child_reports \
	--ignore-table=$(DB).people \
	--ignore-table=$(DB).users \
	--ignore-table=$(DB).upper_extremity_functions \
	--ignore-table=$(DB).upper_extremity_strengths \
	--ignore-table=$(DB).north_star_ambulatory_assessments \
	--ignore-table=$(DB).upload_mr_upper_datasheets \
	--ignore-table=$(DB).general_visit_comments \
	--ignore-table=$(DB).patient_uploads \
	--ignore-table=$(DB).phone_screenings \
	$(DB) | \
	sed "s/'0000-00-00 00:00:00'/now()/g;"  > data_minimal.sql
	du -h data_minimal.sql

dump_testing_data:
	mysqldump $(FLAGS_DATA_ONLY) \
	$(DB) \
	people users upload_users | \
	sed "s/'0000-00-00 00:00:00'/now()/g;" > data_testing.sql

dump_dev: dump_schema dump_minimal_data dump_testing_data
