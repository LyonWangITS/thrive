#!/bin/bash

set -e

# Set global variables
MYDIR=$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )

# These variables are used by this deployment script to
# configure the software during deployment
#   DB_DATABASE   Name of apps' database
#   DB_HOST       Host on which DB_DATABASE resides
#   DB_USER       MySQL user with access to DB_DATABASE
#   DB_PASSWORD   Password for DB_USER
#   SALT          Salt string appended to passwords before hashing
#   SITENAME      A directory name under which this app should be deployed

echo "Working with sitename: $SITENAME"

# Set current date variable
date=`date +"%Y%m%d-%H%M"`

# Holds the name of the directory where the new code will be deployed
DEPLOY_DIR="/var/www/$SITENAME"

# Holds the name of the directory where we will backup the current contents of $DEPLOY_DIR
BACKUP_DIR=/var/www.backup/$SITENAME.$date

function set_cake_salt_value () {
    echo "Entering $FUNCNAME"

    if [ ! -z "$SALT" ]; then
        sed "s/Configure::write('Security.salt',.*/Configure::write('Security.salt', '"$SALT"');/g" -i $MYTEMP/app/Config/core.php
        echo >> $MYTEMP/index.php
        echo '$salt = "$SALT";' >> $MYTEMP/index.php
    fi
}

function turn_off_cake_debugging () {
    echo "Entering $FUNCNAME"
    sed -e "s/.*write('debug'.*/    Configure::write('debug', 0);/" -i $MYTEMP/app/Config/core.php
}

function set_cake_database_parameters () {
    echo "Entering $FUNCNAME"

    #Setting db parameters in database.php
    # .* required to grab the entire line where the regexp exists
    sed "s/'host' => .*/'host' => '"$DB_HOST"',/" -i $MYTEMP/app/Config/database.php
    sed "s/'login' => .*/'login' => '"$DB_USER"',/" -i $MYTEMP/app/Config/database.php
    sed "s/'password' => .*/'password' => '"$DB_PASSWORD"',/" -i $MYTEMP/app/Config/database.php
    sed "s/'database' => .*/'database' => '"$DB_DATABASE"',/" -i $MYTEMP/app/Config/database.php

    #Setting db parameters in DMD Upload config file
    UPLOAD_CONFIG=$MYTEMP/app/webroot/upload/include/constants.php
    if [ -e $UPLOAD_CONFIG ]; then
        sed -e 's/define ("DB_HOST",.*/define ("DB_HOST", "'$DB_HOST'");/' -i $UPLOAD_CONFIG
        sed -e 's/define ("DB_DATABASE",.*/define ("DB_DATABASE", "'$DB_DATABASE'");/' -i $UPLOAD_CONFIG
        sed -e 's/define ("DB_USER",.*/define ("DB_USER", "'$DB_USER'");/' -i $UPLOAD_CONFIG
        sed -e 's/define ("DB_PASSWORD",.*/define ("DB_PASSWORD", "'$DB_PASSWORD'");/' -i $UPLOAD_CONFIG
    else
        echo "This is not a DMD EDC app.  Skipping configuration of upload app database parameters."
    fi

}

function deploy_software_to_temp () {
    echo "Entering $FUNCNAME"

    # Copy files to a temp dir
    MYTEMP=`mktemp -d`
    rsync -ar $MYDIR/ $MYTEMP

    # configure cake parameters to work with this application
    set_cake_salt_value
    turn_off_cake_debugging
    set_cake_database_parameters

    # adjust ownership of deployed code
    chmod -R u+rwX,go+rX,go-w $MYTEMP

    #chmods for temp dir
    chmod -R 777 $MYTEMP/app/tmp

}

function deploy_new_software () {
    echo "Entering $FUNCNAME"

    # Synchronize the code with the DEPLOY_DIR
    echo "Copy the code in $MYTEMP to $BACKUP_DIR"
    rsync -arv -q $MYTEMP/ $BACKUP_DIR

    echo "Switching symbolic links to make the new app active"
    if [ -L $DEPLOY_DIR ]; then
        echo "Deleting symlink $DEPLOY_DIR"
        rm $DEPLOY_DIR
    fi
    ln -sf $BACKUP_DIR $DEPLOY_DIR
    echo "Symbolic links switched.  Active app is $BACKUP_DIR"
}

function clean_up_temp () {
    echo "Entering $FUNCNAME"

    # clean up the mess we made
    rm -rf $MYTEMP

}

deploy_software_to_temp
deploy_new_software
clean_up_temp
