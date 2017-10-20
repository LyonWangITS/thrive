#!/bin/bash

# Contributors:
#    Philip Chase <philipbchase@gmail.com>
#
# Copyright (c) 2016, University of Florida
# All rights reserved.
#
# Distributed under the BSD 3-Clause License
# For full text of the BSD 3-Clause License see http://opensource.org/licenses/BSD-3-Clause

function create_deploy_user() {
    log "Executing: ${FUNCNAME[0]}"
    # make the user with a random password
    sudo useradd -m -b /home -u 800 -g vagrant -s /bin/bash -c "deployment user" deploy -p `cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1`
    sudo mkdir -p /home/deploy/.ssh/keys

    # add public key to bootstrap access
    sudo cp /home/vagrant/.ssh/authorized_keys /home/deploy/.ssh/keys/vagrant.pub
    sudo cp /vagrant/id_rsa.pub  /home/deploy/.ssh/keys/default.pub
    tmpfile=`mktemp`
    sudo cat `sudo find /home/deploy/.ssh/keys/ -type f` > $tmpfile
    sudo cp $tmpfile /home/deploy/.ssh/authorized_keys
    sudo rm $tmpfile

    # adjust the permissions for the deploy user
    sudo chmod 700 /home/deploy/.ssh
    sudo chmod 644 /home/deploy/.ssh/authorized_keys
    sudo chmod -R 700 /home/deploy/.ssh/keys
    sudo chown -R deploy.vagrant /home/deploy
}

function configure_webspace_folders() {
    log "Executing: ${FUNCNAME[0]}"
    sudo mkdir -p /var/www.backup
    sudo chown deploy.vagrant /var/www.backup
    sudo chmod 755 /var/www.backup
    sudo chown deploy.vagrant /var/www
    sudo chmod 755 /var/www
}
