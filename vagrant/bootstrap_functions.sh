#!/bin/bash

# Contributors:
#    Christopher P. Barnes <senrabc@gmail.com>
#    Andrei Sura: github.com/indera
#    Mohan Das Katragadda <mohan.das142@gmail.com>
#    Philip Chase <philipbchase@gmail.com>
#    Ruchi Vivek Desai <ruchivdesai@gmail.com>
#    Taeber Rapczak <taeber@ufl.edu>
#    Josh Hanna <josh@hanna.io>
#    Marly Cormar <marlycormar@ufl.edu>
#
# Copyright (c) 2016, University of Florida
# All rights reserved.
#
# Distributed under the BSD 3-Clause License
# For full text of the BSD 3-Clause License see http://opensource.org/licenses/BSD-3-Clause

function log() {
    echo -n "MSG: "
    echo $*
}

function install_utils() {
    apt-get install -y git vim ack-grep unzip zip \
        tree colordiff libxml2-utils xmlstarlet nmap

    cp /vagrant/dot_files/bash_aliases  /home/vagrant/.bash_aliases
    cp /vagrant/dot_files/bashrc        /home/vagrant/.bashrc
    cp /vagrant/dot_files/vimrc         /home/vagrant/.vimrc

    cp /vagrant/dot_files/bash_aliases  /root/.bash_aliases
    cp /vagrant/dot_files/bashrc        /root/.bashrc
    cp /vagrant/dot_files/vimrc         /root/.vimrc
}

function install_prereqs() {
    log "Install prerequisite packages..."
    REQUIRED_PARAMETER_COUNT=3
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Installs and configures MySQL, Apache and php5.6"
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "MYSQL_REPO           The MySQL Repo to install from.  E.g., mysql-5.6"
        echo "DATABASE_ROOT_PASS   Password of the MySQL root user."
        echo "MYSQLCONF            Configuration file for MySQL Daemon Instance"
        return 1
    else
        MYSQL_REPO=$1
        DATABASE_ROOT_PASS=$2
        MYSQLCONF=$3
    fi

    apt-get install -y dirmngr --install-recommends

    # Note: pgp.mit.edu and sks-keyservers.net no longer contain this key
    gpg  --keyserver-options timeout=10000 --keyserver keyserver.ubuntu.com --recv-keys 5072E1F5
    gpg -a --export 5072E1F5 | sudo apt-key add -

cat << END > /etc/apt/sources.list.d/mysql.list
deb http://repo.mysql.com/apt/debian/ stretch $MYSQL_REPO
deb-src http://repo.mysql.com/apt/debian/ stretch $MYSQL_REPO
END

    apt-get update

    log "Preparing to install mysql-community-server with root password: '$DATABASE_ROOT_PASS'..."
    echo mysql-server mysql-server/root_password       password $DATABASE_ROOT_PASS | debconf-set-selections
    echo mysql-server mysql-server/root_password_again password $DATABASE_ROOT_PASS | debconf-set-selections
    echo mysql-community-server mysql-community-server/root_password       password $DATABASE_ROOT_PASS | debconf-set-selections
    echo mysql-community-server mysql-community-server/root_password_again password $DATABASE_ROOT_PASS | debconf-set-selections
    echo mysql-community-server mysql-community-server/root-pass           password $DATABASE_ROOT_PASS | debconf-set-selections
    echo mysql-community-server mysql-community-server/re-root-pass        password $DATABASE_ROOT_PASS | debconf-set-selections

    apt-get install -y apache2
    apt-get install -y mysql-community-server

    # Installing php5.6
    log "Installing php5.6..."
    apt-get install -y ca-certificates apt-transport-https
    wget -q https://packages.sury.org/php/apt.gpg -O- | sudo apt-key add -
    echo "deb https://packages.sury.org/php/ stretch main" | sudo tee /etc/apt/sources.list.d/php.list
    apt-get update
    apt-get install -y php5.6 php5.6-mysql php5.6-mcrypt php5.6-gd php5.6-dom php5.6-mbstring

    # Configure mysqld to be more permissive
    log "Configure mysqld to be more permissive..."
    log "Setting sql_mode in $MYSQLCONF"
    echo '[mysqld]' > $MYSQLCONF
    echo 'sql_mode=ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION' >> $MYSQLCONF
    service mysql restart

    # configure MySQL to start every time
    update-rc.d mysql defaults

    # Increase the default upload size limit to allow ginormous files
    sed -i 's/upload_max_filesize =.*/upload_max_filesize = 20M/' /etc/php/5.6/apache2/php.ini
    sed -i 's/;date.timezone =.*/date.timezone = America\/New_York/' /etc/php/5.6/apache2/php.ini
    sed -i 's/;date.timezone =.*/date.timezone = America\/New_York/' /etc/php/5.6/cli/php.ini

    log "Stop apache..."
    service apache2 stop
    # Keep the default site on port :80
    # a2dissite 000-default

    log "Link config files for apache port 443"
    ln -sfv /vagrant/apache-ssl.conf    /etc/apache2/sites-available/apache-ssl.conf
    ln -sfv /vagrant/apache-ssl.conf    /etc/apache2/sites-enabled/apache-ssl.conf

    log "Link config files for apache port 80"
    OLD_APACHE_DEFAULT=/etc/apache2/sites-enabled/000-default.conf
    if [ -e $OLD_APACHE_DEFAULT ]; then rm $OLD_APACHE_DEFAULT; fi

    OLD_APACHE_DEFAULT=/etc/apache2/sites-available/000-default.conf
    if [ -e $OLD_APACHE_DEFAULT ]; then rm $OLD_APACHE_DEFAULT; fi

    ln -sfv /vagrant/apache-default.conf    /etc/apache2/sites-available/000-default.conf
    ln -sfv /vagrant/apache-default.conf    /etc/apache2/sites-enabled/000-default.conf

    log "Enable apache modules"
    a2enmod ssl
    a2enmod rewrite

    log "Restaring apache with new config..."
    sleep 2
    service apache2 start
}

function create_database() {
    log "Executing: create_database()"

    REQUIRED_PARAMETER_COUNT=5
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Creates a MySQL database, a DB user with access to the DB, and sets user's password."
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "DATABASE_NAME        Name of the database to create"
        echo "DATABASE_USER        Database user who will have access to DATABASE_NAME"
        echo "DATABASE_PASSWORD    Password of DATABASE_USER"
        echo "DATABASE_HOST        The host from which DATABASE_USER is authorized to access DATABASE_NAME"
        echo "DATABASE_ROOT_PASS   Password of the mysql root user"
        return 1
    else
        DATABASE_NAME=$1
        DATABASE_USER=$2
        DATABASE_PASSWORD=$3
        DATABASE_HOST=$4
        DATABASE_ROOT_PASS=$5
    fi

    log "Creating database $DATABASE_NAME"
    # Create database used by the app
    mysql -u root -p$DATABASE_ROOT_PASS mysql <<SQL
DROP DATABASE IF EXISTS $DATABASE_NAME;
CREATE DATABASE $DATABASE_NAME;

GRANT
    SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, ALTER, EXECUTE, CREATE VIEW, SHOW VIEW
ON
    $DATABASE_NAME.*
TO
    '$DATABASE_USER'@'$DATABASE_HOST'
IDENTIFIED BY
    '$DATABASE_PASSWORD';
SQL

}

function update_cake_connection_settings() {
    log "Executing: update_cake_connection_settings()"

    REQUIRED_PARAMETER_COUNT=5
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Rewrites the CakePHP database.php for this app."
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "DEPLOY_DIR           The directory where the app is deployed"
        echo "DATABASE_USER        Database user who will have access to DATABASE_NAME"
        echo "DATABASE_PASSWORD    Password of DATABASE_USER"
        echo "DATABASE_HOST        The host from which DATABASE_USER is authorized to access DATABASE_NAME"
        echo "DATABASE_NAME        The name of the database the app uses"
        return 1
    else
        DEPLOY_DIR=$1
        DATABASE_USER=$2
        DATABASE_PASSWORD=$3
        DATABASE_HOST=$4
        DATABASE_NAME=$5
    fi

    # edit cake database config file
    CAKE_DB_CONFIG_FILE=$DEPLOY_DIR/app/Config/database.php
    echo "Setting the connection variables in: $CAKE_DB_CONFIG_FILE"
    sed -e "s/'host'.*=>.*/'host' => '$DATABASE_HOST',/;" -i $CAKE_DB_CONFIG_FILE
    sed -e "s/'login'.*=>.*/'login' => '$DATABASE_USER',/;" -i $CAKE_DB_CONFIG_FILE
    sed -e "s/'password'.*=>.*/'password' => '$DATABASE_PASSWORD',/;" -i $CAKE_DB_CONFIG_FILE
    sed -e "s/'database'.*=>.*/'database' => '$DATABASE_NAME',/;" -i $CAKE_DB_CONFIG_FILE
}

function write_dot_mysql_dot_cnf() {
    echo "Writing .my.cnf files to home dirs..."
    REQUIRED_PARAMETER_COUNT=4
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Creates .my.cnf files for vagrant user and root."
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "DATABASE_NAME        Name of the database to access."
        echo "DATABASE_USER        Database user to connect with."
        echo "DATABASE_PASSWORD    Password of DATABASE_USER"
        echo "DATABASE_ROOT_PASS   Password of root MySQL user"
        return 1
    else
        DATABASE_NAME=$1
        DATABASE_USER=$2
        DATABASE_PASSWORD=$3
        DATABASE_ROOT_PASS=$4
    fi

    # Write a .my.cnf file into the vagrant user's home dir
    cat << EOF > /home/vagrant/.my.cnf
[mysql]
password="$DATABASE_PASSWORD"
user=$DATABASE_USER
database=$DATABASE_NAME

[mysqldump]
password="$DATABASE_PASSWORD"
user=$DATABASE_USER
EOF
    chown vagrant.vagrant /home/vagrant/.my.cnf

    # Write a .my.cnf file into the root's home dir
    cat << EOF > /root/.my.cnf
[mysql]
password="$DATABASE_ROOT_PASS"
user=root
database=$DATABASE_NAME

[mysqldump]
password="$DATABASE_ROOT_PASS"
user=root
EOF
}

function populate_db () {
    log "Executing ${FUNCNAME[0]}"
    REQUIRED_PARAMETER_COUNT=5
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Creates a MySQL database, a DB user with access to the DB, and sets user's password."
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "DATABASE_NAME        Name of the database to create"
        echo "DATABASE_USER        Database user who will have access to DATABASE_NAME"
        echo "DATABASE_PASSWORD    Password of DATABASE_USER"
        echo "DEPLOY_DIR           The directory where the app is deployed"
        echo "DB_EPOCH_VERSION     The version of the schema files to be loaded before applying upgrades"
        return 1
    else
        DATABASE_NAME=$1
        DATABASE_USER=$2
        DATABASE_PASSWORD=$3
        DEPLOY_DIR=$4
        DB_EPOCH_VERSION=$5
    fi

    SCHEMA_FOLDER=$DEPLOY_DIR/schema

    # LOad the three epoch files--schema.sql, data_minimal.sql and data_testing.sql--in that order
    for file in schema.sql data_minimal.sql data_testing.sql ; do
        create_tables $DATABASE_NAME $DATABASE_USER $DATABASE_PASSWORD $SCHEMA_FOLDER/$DB_EPOCH_VERSION/$file
    done

    # load every upgrade.sql with a higher version number than the $DB_EPOCH_VERSION
    for dir in `find $SCHEMA_FOLDER -maxdepth 1 -type d | sort --version-sort | grep -A1000 $DB_EPOCH_VERSION | tail -n +2` ; do
        if [ -e $dir/upgrade.sql ]; then
            create_tables $DATABASE_NAME $DATABASE_USER $DATABASE_PASSWORD $dir/upgrade.sql
        fi
    done

}

function create_tables() {
    log "Executing: create_tables()"
    # load a single SQL file into the database to initialize the application

    REQUIRED_PARAMETER_COUNT=4
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Creates a MySQL database, a DB user with access to the DB, and sets user's password."
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "DATABASE_NAME        Name of the database to create"
        echo "DATABASE_USER        Database user who will have access to DATABASE_NAME"
        echo "DATABASE_PASSWORD    Password of DATABASE_USER"
        echo "SQL_FILE             The full path to the SQL file that will be loaded into the DATABASE_NAME"
        return 1
    else
        DATABASE_NAME=$1
        DATABASE_USER=$2
        DATABASE_PASSWORD=$3
        SQL_FILE=$4
    fi

    if [ -e $SQL_FILE ]; then
        echo "Loading database file $SQL_FILE into $DATABASE_NAME..."
        mysql -u$DATABASE_USER -p$DATABASE_PASSWORD $DATABASE_NAME < $SQL_FILE
    else
        echo "Database file $SQL_FILE does not exist"
    fi
}

function install_xdebug() {
    # Install XDebug for enabling code coverage
    log "Executing: install_xdebug()"
    apt-get install -y php5.6-xdebug

    echo 'Restarting apache server'
    service apache2 restart
}

function install_composer_deps() {
    log "Executing: install_composer_deps()"
    REQUIRED_PARAMETER_COUNT=1
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Installs PHP Composer and runs 'composer install' for this app"
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "DEPLOY_DIR           The directory where the app is deployed"
        return 1
    else
        DEPLOY_DIR=$1
    fi

    curl -sS https://getcomposer.org/installer | php
    mv composer.phar /usr/local/bin/composer

    pushd $DEPLOY_DIR/app
        # silence the deprecation notice
        # The Composer\Package\LinkConstraint\VersionConstraint class is deprecated,
        # use Composer\Semver\Constraint\Constraint instead. in phar:///usr/local/bin/composer/src/Composer/Package/LinkConstraint/VersionConstraint.php:17
        phpdismod xdebug
        composer install 2>&1 | tee ~/log_install_composer_deps
        phpenmod xdebug
    popd
    log "Done with install_composer_deps()"
}

function upgrade_acl () {
    echo "Executing: upgrade_acl()"

    REQUIRED_PARAMETER_COUNT=2
    if [ $# != $REQUIRED_PARAMETER_COUNT ]; then
        echo "${FUNCNAME[0]} Runs any ACL Upgrade scripts"
        echo "${FUNCNAME[0]} requires these $REQUIRED_PARAMETER_COUNT parameters in this order:"
        echo "DEPLOY_DIR           The directory where the app is deployed"
        echo "DB_EPOCH_VERSION     The version of the schema files to be loaded before applying upgrades"
        return 1
    else
        DEPLOY_DIR=$1
        DB_EPOCH_VERSION=$2
    fi

    SCHEMA_FOLDER=$DEPLOY_DIR/schema

    # run every acl-upgrade.sh with a higher version number than the $DB_EPOCH_VERSION
    for dir in `find $SCHEMA_FOLDER -maxdepth 1 -type d | sort --version-sort | grep -A1000 $DB_EPOCH_VERSION | tail -n +2` ; do
        if [ -e $dir/acl-upgrade.sh ]; then
            echo "Running $dir/acl-upgrade.sh..."
            bash $dir/acl-upgrade.sh $DEPLOY_DIR
        fi
    done

}

function reset_db {
    . /vagrant/.env
    create_database $DB $DB_APP_USER $DB_APP_PASSWORD $DB_HOST $DB_PASS
    create_database $DB_TEST $DB_APP_USER $DB_APP_PASSWORD $DB_HOST $DB_PASS
    update_cake_connection_settings $PATH_TO_APP_IN_GUEST_FILESYSTEM $DB_APP_USER $DB_APP_PASSWORD $DB_HOST $DB
    populate_db $DB $DB_USER $DB_PASS $PATH_TO_APP_IN_GUEST_FILESYSTEM $DB_EPOCH_VERSION
    upgrade_acl $PATH_TO_APP_IN_GUEST_FILESYSTEM $DB_EPOCH_VERSION
}
