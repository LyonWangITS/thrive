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
    cat << END > /tmp/pbc.pub
ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAgEAlrkWcQHSuOMbwIxEqdSwTmeK0WQq4EKVyrSJNomr6gTsERN+i0Bptkz3W7jwU77Eo1duUq87aTvgzXudsN5bTMVERbW6nf3fp1mjHtQkLTfAqBw0h9UbXD2/esvM5gbK/hj/mNvcDN10NEytrRZk9IjRV14ktYJwI6Z4aRPIi124ps3JQUg/uETa+qx9Xt8TxSU9MQlmQXygS661wHugPlPtaH4qhDGGg4h6I3002eLRi703o17LVQdiWBOJUDdwVMTIbkYiJGQ4U0E93XJMFH4paUDiDXNcWkjMUCDmhcnpkIstvWGz+nureo7c1wcHht/hsbVNiD+uKoMAm6ZgDFTD7qyXG7CblNLLBf/zKIelvftMcWRnAYl5pklN97ZDVuln5UPd/sJ5Ds0lvZLtaRR8vM25691bzWzdmv/+KhJK7ohq4mGaYQlmXslzaU3RpD+K5wKfyyfAAgioMhSSgQq6AWOd6hEWklNHB1mrl6KDaOuc7ZyL4SG0Qbq2nW73kxzNBvOIcoWIV0afX+QPXwoFJbPwBZnhppo1XjWFS57BPfv6zq566JpvJ2dXCDDA/PwFOH5v7HsueoIHEwY0SKXU8QwL+e4IlKBFWSqwTJlFLZKE5nzVlqYki6KqFsOT7mRFp+5hj9DNyXuxpDrlb5+iegK63/4Wc3ldBNGoj0s= pbc@ufl.edu
END
    sudo cp /home/vagrant/.ssh/authorized_keys /home/deploy/.ssh/keys/vagrant.pub
    sudo mv /tmp/pbc.pub /home/deploy/.ssh/keys/
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
