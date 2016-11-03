#!/bin/bash

export DEBIAN_FRONTEND=noninteractive

# Exit on first error
set -e

echo "Import environment variables from /vagrant/.env"
. /vagrant/.env

# Print commands (uncomment to see more details)
# set -x

echo "Import helper functions from: bootstrap_functions.sh"
. /vagrant/bootstrap_functions.sh

# uncomment the next two lines when the iDMD project gets the updated upload app and starts usinfg this VM as its test target
#echo "Import iDMD helper functions from: idmd_functions.sh"
#. /vagrant/idmd_functions.sh

# Pick a fast mirror...or at least one that works
log "Picking a fast mirror in the US..."
apt-get install -y netselect-apt
cd /etc/apt/
netselect-apt -c US > ~/netselect-apt.log 2>&1

# Update our repos
log "Updating apt package indicies..."
apt-get update

# Install developer tools
log "Execute: install_utils..."
install_utils

log "Execute: install_prereqs..."
install_prereqs $MYSQL_REPO $DB_PASS $MYSQLCONF

# create the empty databases and update the cake configuration
create_database $DB $DB_APP_USER $DB_APP_PASSWORD $DB_HOST $DB_PASS
create_database $DB_TEST $DB_APP_USER $DB_APP_PASSWORD $DB_HOST $DB_PASS
update_cake_connection_settings $PATH_TO_APP_IN_GUEST_FILESYSTEM $DB_APP_USER $DB_APP_PASSWORD $DB_HOST

# make a config file for the mysql clients
write_dot_mysql_dot_cnf $DB $DB_APP_USER $DB_APP_PASSWORD $DB_PASS

# Create tables and load with data
populate_db $DB $DB_USER $DB_PASS $PATH_TO_APP_IN_GUEST_FILESYSTEM $DB_EPOCH_VERSION

log "Set permissions for tmp folder: app/tmp "
chmod -R 777 $PATH_TO_APP_IN_GUEST_FILESYSTEM/app/tmp

# Install xdebug for code coverage reports
install_xdebug

# Install composer and run it with app/composer.json
install_composer_deps $PATH_TO_APP_IN_GUEST_FILESYSTEM

# Execute ACL upgrade commands
upgrade_acl $PATH_TO_APP_IN_GUEST_FILESYSTEM $DB_EPOCH_VERSION

echo "Import helper functions from: deployment_functions.sh"
. /vagrant/deployment_functions.sh
create_deploy_user
configure_webspace_folders

log "Checking if the app is up..."
#curl -sk $URL_OF_DEPLOYED_APP | grep "CTSI"

log "All done."
