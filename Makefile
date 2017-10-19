# Helper script for common tasks
# @author Andrei Sura

include vagrant/.env

SHARED_DIR := /vagrant/
VAGR := VAGRANT_CWD=vagrant
VAGR_SSH := $(VAGR) vagrant ssh
VM_MAKEFILE_PATH=/vagrant


APP_CONSTANTS_FILE := app/Config/constants.php

LAST_TAG              := $(shell git tag | sort  -t. -k 1,1n -k 2,2n -k 3,3n | tail -1)
# CODE_VERSION          := $(shell grep APP_VERSION ${APP_CONSTANTS_FILE} | cut -d "'" -f 4)
DEPLOYED_VERSION_DEV  := $(shell curl -sk ${APP_URL_DEV} | grep Version | grep -oE '[0-9.]{1,2}[0-9.]{1,2}[0-9a-z.]{1,4}')
DEPLOYED_VERSION_PROD := $(shell curl -sk ${APP_URL_PROD} | grep Version | grep -oE '[0-9.]{1,2}[0-9.]{1,2}[0-9a-z.]{1,4}')

COLOR_RED='\033[0;31m'
COLOR_GREEN='\033[0;32m'
COLOR_YELLOW='\033[0;33m'
COLOR_NONE='\033[0m'
STATUS_PASS=✔
STATUS_FAIL=✗

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
	@echo "  all                 : Initialize the build area with the code from COMMIT, "
	@echo "                        run tests on the workdir and package the code from COMMIT"
	@echo "  test                : run all tests"
	@echo "  clean_build_area    : Clean the build area"
	@echo "  package             : Package the code from COMMIT"
	@echo "  show_versions       : compare code/tag/deployed version numbers"
	@echo "  add_key_to_staging  : Add an ssh public key to deploy@ctsit-staging"
	@echo "  add_key_to_prod     : Add an ssh public key to deploy@ctsit-projects"
	@echo "  deploy_to_dev       : Deploy PACKAGE_FILE to the development VM with the parameters in ./dev.env"
	@echo "  deploy_to_stage     : Deploy PACKAGE_FILE to the staging with the parameters in ./stage.env"
	@echo "  deploy_to_prod      : Deploy PACKAGE_FILE to the staging with the parameters in ./prod.env"
	@echo
	@echo "Code Verification Commands"
	@echo
	@echo "  print_log           : Print a report of the git log for audit purposes"
	@echo "  review_setup        : Add a target to make a git alias 'lr' for generating commit history for code review logs"
	@echo "  zip_verification    : Create a zip file of the verification for a specific version (Requires: VERSION=0.0.0)"
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
	@echo "  mkdocs              : open mkdocs in the browser"
	@echo "  mkdocs_kill         : kill mkdocs process"
	@echo "  vas                 : ssh into the VM"
	@echo "  vas_list            : Enumerates a couple VM folders"
	@echo "  vdown               : vagrant destroy the VM"
	@echo "  vhalt               : vagrant halt the the VM"
	@echo "  vrebuild            : vagrant destroy and vagrant up the VM"
	@echo "  vup                 : vagrant up the VM"
	@echo

acl_admins_and_users:
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make $@"

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
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make $@"

acl_visit_list:
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make $@"

check_app:
	curl -sk $(URL_OF_DEPLOYED_APP)/users/login | grep $(TEST_STRING_ON_FRONT_PAGE)

create_schema:
	# runs create table statements on the test database
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make $@"

dump_schema:
	# writes file Config/Schema/schema.ph
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make $@"

db_groups:
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make $@"

mkdocs:
	#TODO Fix this Recipe. It returns "make: `docs' is up to date."
	which mkdocs || pip install mkdocs
	mkdocs build && mkdocs serve &
	open http://127.0.0.1:8000/
	ps -fe | grep 'bin/mkdocs serve' | head -2 | head -1 | cut -d ' ' -f 4

mkdocs_kill:
	kill `ps -fe | grep 'bin/mkdocs serve' | head -2 | head -1 | cut -d ' ' -f 4`

check_print_log_reqs:
	@echo "Checking 'aha' and 'wkhtmltopdf' requirements."
	@type aha         >/dev/null 2>&1 || { echo >&2 "Please install aha using 'brew install aha'"; exit 1; }
	@type wkhtmltopdf >/dev/null 2>&1 || { echo >&2 "Please install wkhtmltopdf using 'brew install wkhtmltopdf'"; exit 1; }

print_log: check_print_log_reqs
	rm -f revision-history.pdf temp.txt
	echo "Git commit log for the ${PROJECT_NAME}" > temp.txt
	echo "The authoritative git repo for this project is housed at ${PROJECT_REPO}" >> temp.txt
	echo "" >> temp.txt
	git log --pretty=format:"%C(yellow)%h\\ %C(green)%ad%Cred%d\\ %Creset%s%Cblue\\ [%an]" --decorate --date=short --graph >> temp.txt
	cat temp.txt | aha | wkhtmltopdf - revision-history.pdf
	rm -f temp.txt
	echo "See report at revision-history.pdf"

review_setup:
	git config --global alias.lr 'log --pretty=format:"%h\\ %ai\\ %an%d\\ %s" --decorate --date=short'
	@echo ""
	@echo "The git alias, 'git lr' has been added to your global git config."
	@echo "Use 'git lr' to output the code review log for your branch. e.g. "
	@echo ""
	@echo "   git lr develop..HEAD"
	@echo ""
	@echo "Insert this output into a copy of ./docs/verification/code_review_template.md"
	@echo "to start a new code review session."
	@echo ""

show_versions:
	@echo "Last tag: $(LAST_TAG) (git show $(LAST_TAG))"
	@echo "Code version: $(CODE_VERSION) ($(APP_CONSTANTS_FILE))"
	@echo "Deployed DEV version: $(DEPLOYED_VERSION_DEV)"
	@echo "Deployed PROD version: $(DEPLOYED_VERSION_PROD)"

ifneq ($(CODE_VERSION), $(DEPLOYED_VERSION_DEV))
	@echo ${COLOR_YELLOW}[${STATUS_FAIL}]${COLOR_NONE} Fix it: DEV does not match CODE $(APP_CONSTANTS_FILE)
else
	@echo ${COLOR_GREEN}[${STATUS_PASS}]${COLOR_NONE} Great job: DEV matches CODE $(APP_CONSTANTS_FILE)
endif

ifneq ($(DEPLOYED_VERSION_PROD), $(DEPLOYED_VERSION_DEV))
	@echo ${COLOR_RED}[${STATUS_FAIL}]${COLOR_NONE} Fix it: DEV does not match PROD $(APP_CONSTANTS_FILE)
else
	@echo ${COLOR_GREEN}[${STATUS_PASS}]${COLOR_NONE} Great job: DEV matches PROD $(APP_CONSTANTS_FILE)
endif

vas:
	$(VAGR_SSH)
vas_list:
	$(VAGR_SSH) -c 'ls -al /vagrant && ls -al $(PATH_TO_APP_IN_GUEST_FILESYSTEM)'
vdown:
	$(VAGR) vagrant destroy
vhalt:
	$(VAGR) vagrant halt
vup:
	$(VAGR) vagrant up
vrebuild:
	$(VAGR) vagrant destroy -f && time $(VAGR) vagrant up

zip_verification:
	@bash scripts/make_verification_zip.sh $$VERSION "$(VERIFICATION_DOCS_FILENAME)" "$(VERIFICATION_DOCS_DIRECTORY)"


# Makefile targets to package and deploy

check_commit:
ifndef COMMIT
	$(eval COMMIT := master)
endif
ifeq ($(COMMIT),)
	$(eval COMMIT := master)
endif

all: check_commit
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make all COMMIT=$(COMMIT)"

test:
	$(VAGR_SSH) -c "cd $(PATH_TO_APP_IN_GUEST_FILESYSTEM)/app && sudo Console/cake test app AllTests --coverage-html webroot/coverage"
	@echo "open $(URL_OF_DEPLOYED_APP)/coverage/ to view the coverage report"

clean_build_area:
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && sudo make clean"

package: check_commit
	$(VAGR_SSH) -c "cd $(VM_MAKEFILE_PATH) && make package COMMIT=$(COMMIT)"

add_key_to_staging:
	$(call check_defined, KEYFILE, a file with the public key to add)
	scp $(KEYFILE) deploy@$(STAGING_HOST):/home/deploy/.ssh/keys/
	ssh deploy@$(STAGING_HOST) 'tmpfile=`mktemp` && cat `ls -1 /home/deploy/.ssh/keys/*.pub` > $$tmpfile && cp $$tmpfile /home/deploy/.ssh/authorized_keys && rm $$tmpfile'

add_key_to_prod:
	$(call check_defined, KEYFILE, a file with the public key to add)
	scp $(KEYFILE) deploy@$(PROD_HOST):/home/deploy/.ssh/keys/
	ssh deploy@$(PROD_HOST) 'tmpfile=`mktemp` && cat `ls -1 /home/deploy/.ssh/keys/*.pub` > $$tmpfile && cp $$tmpfile /home/deploy/.ssh/authorized_keys && rm $$tmpfile'

# We never want to save the hostkey file for dev
SSH_OPTS = -o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null

deploy_to_host:
	$(call check_defined, PACKAGE_FILE, the package to be deployed)
	$(eval APP_HOSTNAME=$(shell grep APP_HOSTNAME ${ENV_FILE} | cut -d "=" -f 2))
	ssh $(SSH_OPTS) deploy@$(APP_HOSTNAME) 'rm -rf scratch && mkdir scratch'
	scp $(SSH_OPTS) $(PACKAGE_FILE) deploy@$(APP_HOSTNAME):scratch/
	ssh $(SSH_OPTS) deploy@$(APP_HOSTNAME) 'cd scratch && unzip -q *.zip'
	#scp $(SSH_OPTS) deploy.sh deploy@$(APP_HOSTNAME):scratch/$(PROJECT_ID)/
	scp $(SSH_OPTS) $(ENV_FILE) deploy@$(APP_HOSTNAME):scratch/this.env
	ssh $(SSH_OPTS) deploy@$(APP_HOSTNAME) 'source scratch/this.env; bash scratch/$(PROJECT_ID)/deploy.sh'
	ssh $(SSH_OPTS) deploy@$(APP_HOSTNAME) 'rm -rf scratch'

use_dev_params:
	$(eval ENV_FILE=dev.env)

use_staging_params:
	$(eval ENV_FILE=staging.env)

use_prod_params:
	$(eval ENV_FILE=prod.env)

deploy_to_dev: use_dev_params deploy_to_host
	open -a 'Google Chrome.app' $(DEV_WEBROOT_URL)/$(PROJECT_ID)

deploy_to_stage: use_staging_params deploy_to_host

deploy_to_prod: use_prod_params deploy_to_host
