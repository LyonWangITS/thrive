# Helper script for common tasks
# @author Andrei Sura, Philip Chase

include /vagrant/.env

SHARED_DIR := /vagrant

# Check that given variables are set and all have non-empty values,
# die with an error otherwise.
#
# Params:
#   1. Variable name(s) to test.
#   2. (optional) Error message to print.
check_defined = \
    $(foreach 1,$1,$(__check_defined))
__check_defined = \
    $(if $(value $1),, \
      $(error Undefined $1$(if $(value 2), ($(strip $2)))))

help:
	@echo
	@echo "Important Commands"
	@echo
	@echo "  all                 : Initialize the build area with the code from COMMIT, run tests on the workdir and package the code from COMMIT"
	@echo "  clean               : Clean the build area"
	@echo "  test                : run all tests"
	@echo "  package             : Package the code from COMMIT"
	@echo "  install             : Package the code from COMMIT and install it locally to appear at /PROJECT_ID"
	@echo
	@echo "Not-so-important Commands"
	@echo
	@echo "  acl_admins_and_users: enumerates ACls for the Admins and Users groups"
	@echo "  acl_commands        : Enumerates Cake ACL commands"
	@echo "  acl_visit_create    : (TODO: Remove or explain this recipe)"
	@echo "  acl_visit_list      : (TODO: Remove or explain this recipe)"
	@echo "  check_app           : test if the webapp is properly working"
	@echo "  create_schema       : runs cakephp create table statements on the test database"
	@echo "  db_groups           : enumerate the authorization groups and their IDs"
	@echo "  dump_schema         : writes file Config/Schema/schema.ph"
	@echo


acl_admins_and_users:
	sudo $(CAKE) acl view -v aro 'Group.1'
	sudo $(CAKE) acl view -v aro 'Group.3'

acl_commands:
	@echo " \
	create     Create a new ACL node \
	delete     Deletes the ACL object with the given <node> reference \
	setparent  Moves the ACL node under a new parent. \
	getpath    Print out the path to an ACL node. \
	check      Check the permissions between an ACO and ARO. \
	grant      Grant an ARO permissions to an ACO. \
	deny       Deny an ARO permissions to an ACO. \
	inherit    Inherit an ARO's parent permissions. \
	view       View a tree or a single node's subtree. \
	initdb     Initialize the DbAcl tables. Uses this command : cake schema create DbAcl"

acl_visit_create:
	sudo $(CAKE) create aco 'controllers' 'VisitSummaryDownloads'

acl_visit_list:
	sudo $(CAKE) acl view aco 'VisitSummaryDownloads'
	sudo $(CAKE) acl check Group.3 VisitSummaryDownloads

check_app:
	curl -sk $(URL_OF_DEPLOYED_APP)/users/login | grep $(TEST_STRING_ON_FRONT_PAGE)

create_schema:
	# runs create table statements on the test database
	cd $(PATH_TO_APP_IN_GUEST_FILESYSTEM)/app && sudo Console/cake schema update --connection test

dump_schema:
	# writes file Config/Schema/schema.ph
	cd $(PATH_TO_APP_IN_GUEST_FILESYSTEM)/app && sudo Console/cake schema dump  --connection default > /tmp/schema.sql && echo 'wrote /temp/schema.sql'

db_groups:
	mysql -u$(DB_USER) -p$(DB_PASS) $(DB) -e 'select id, name from groups'


# Classic Makefile targets to init, test, package, and deploy
BUILD_DIR=/tmp/$(PROJECT_ID)
REPO_DIR=$(BUILD_DIR)/$(PROJECT_ID)
COMPOSER_INSTALLED=app/Vendor/composer/installed.json
COMPOSER=$(REPO_DIR)/$(COMPOSER_INSTALLED)
PACKAGE_FILE=/tmp/$(PACKAGE).zip
$(eval SCRATCH = $(shell mktemp -d))
BUILD_CODE_VERSION=$(CODE_VERSION)
PACKAGE=$(PROJECT_ID)-$(BUILD_CODE_VERSION)

check_commit:
ifndef COMMIT
	$(eval COMMIT := master)
endif
ifeq ($(COMMIT),)
	$(eval COMMIT := master)
endif


all: init test package

clean:
	rm -rf $(BUILD_DIR)
	rm -rf /tmp/$(PROJECT_ID)*

$(BUILD_DIR):
	mkdir -p $(BUILD_DIR)

clone: $(REPO_DIR)

$(REPO_DIR): | $(BUILD_DIR)
	cd $(BUILD_DIR) && \
	git clone file://$(PATH_TO_APP_IN_GUEST_FILESYSTEM) $(PROJECT_ID)

checkout: $(REPO_DIR) check_commit | $(BUILD_DIR)
	cd $(REPO_DIR) && \
	git checkout ${COMMIT}

pull: checkout
	cd $(REPO_DIR) ; \
	git pull

init: pull
    # - Install your dependencies via gem, maven, etc.
    # - Download sql dumps or copy configuration templates
    #   that a dev needs to get up and running.
    # - Install git hooks (more below)

composer: $(COMPOSER)

$(COMPOSER): pull
	sudo php5dismod xdebug
	cd $(REPO_DIR)/app && composer install --no-dev 2>&1
	sudo php5enmod xdebug

# TODO this planned prereq code for the coverage target needs work to integrate it with the coverage target
GIT_STATUS=$(SHARED_DIR)/git-status
GIT_STATUS_COMMAND=$(SHARED_DIR)/git-status.sh
WORKDIR=$(PATH_TO_APP_IN_GUEST_FILESYSTEM)
$(GIT_STATUS):
	$(GIT_STATUS_COMMAND) $(GIT_STATUS) $(WORKDIR)

test: coverage

test_without_coverage:
	cd $(PATH_TO_APP_IN_GUEST_FILESYSTEM)/app && sudo Console/cake test app AllTests --debug

RELATIVE_PATH_TO_COVERAGE_REPORT=app/webroot/coverage/index.html
PATH_TO_COVERAGE_REPORT=$(PATH_TO_APP_IN_GUEST_FILESYSTEM)/$(RELATIVE_PATH_TO_COVERAGE_REPORT)

.PHONY: coverage $(PATH_TO_COVERAGE_REPORT)

coverage: $(PATH_TO_COVERAGE_REPORT)

$(PATH_TO_COVERAGE_REPORT):
	cd $(PATH_TO_APP_IN_GUEST_FILESYSTEM)/app && sudo Console/cake test app AllTests --coverage-html webroot/coverage
	@echo "open $(URL_OF_DEPLOYED_APP)/coverage/ to view the coverage report"

package: $(PACKAGE_FILE)

$(PACKAGE_FILE):
	mkdir -p $(BUILD_DIR)
	cd $(BUILD_DIR) && zip -rq $(PACKAGE_FILE) \
	$(PROJECT_ID)/app/ \
	$(PROJECT_ID)/lib/ \
	$(PROJECT_ID)/index.php \
	$(PROJECT_ID)/.htaccess \
	$(PROJECT_ID)/deploy.sh \
	$(PROJECT_ID)/CHANGELOG.md
	ls -ltrh $(PACKAGE_FILE)
	cp $(PACKAGE_FILE) /vagrant/

# Here's a local deployment we probably don't need, but it works
install: package
	sudo rm -rf $(DEV_DEPLOY_DIR)
	sudo mkdir -p $(DEV_DEPLOY_DIR)
	sudo unzip -q $(PACKAGE_FILE) -d $(SCRATCH)
	sudo rsync -ar $(SCRATCH)/$(PROJECT_ID)/ $(DEV_DEPLOY_DIR)
	sudo rm -rf $(SCRATCH)
	sudo chown -R www-data.vagrant $(DEV_DEPLOY_DIR)
	sudo chmod -R u+rwX,go+rX,go-w $(DEV_DEPLOY_DIR)
	sudo chmod -R 777 $(DEV_DEPLOY_DIR)/app/tmp
	@echo "open $(DEV_DEPLOY_URL) to test the deployment"
