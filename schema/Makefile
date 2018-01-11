include /vagrant/.env

DUMP_SCHEMA_DEV := schema.sql

FLAGS_SCHEMA_ONLY := --no-data		  --skip-lock-tables --triggers --routines --events --skip-add-locks --skip-comments
FLAGS_DATA_ONLY   := --no-create-info --skip-lock-tables --skip-add-locks --skip-comments --skip-extended-insert --no-create-db

help:
	@echo "Run one of these targets"
	@echo "  dump_schema            Dump only the database schema"
	@echo "  dump_minimal_data      Dump only the data need by every instance of the app"
	@echo "  dump_testing_data      Dump data need to instantiate the dev instance"
	@echo "  dump_dev               All of the above"

dump_schema:
	mysqldump $(FLAGS_SCHEMA_ONLY) $(DB) | sed -e 's/AUTO_INCREMENT=[[:digit:]]* //' | sed "/50013 DEFINER=/d" > $(DUMP_SCHEMA_DEV)
	grep 'CREATE TABLE' $(DUMP_SCHEMA_DEV) | wc -l

dump_minimal_data:
	mysqldump $(FLAGS_DATA_ONLY) \
	$(DB) \
	lu_partner_states roles services | \
	sed "s/'0000-00-00 00:00:00'/now()/g;"  > data_minimal.sql
	du -h data_minimal.sql

dump_testing_data:
	mysqldump $(FLAGS_DATA_ONLY) \
	$(DB) \
	accounts entries partners pending_changes | \
	sed "s/'0000-00-00 00:00:00'/now()/g;" > data_testing.sql

dump_dev: dump_schema dump_minimal_data dump_testing_data

