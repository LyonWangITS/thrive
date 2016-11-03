# Vagrant Environment

This repository, _vagrant\_environment_, is a collection of scripts and tools that should serve as a foundation for CakePHP-based web applications.  This repo has a configurable Vagrant-based VM with similarly configurable provisioning scripts written in BASH.  This repo also contains an implementation of a package-based software deployment environment.  Many of its features are also useful for non-Cake and non-php applications and should be reused and adapted to those environments where appropriate.

The repository supports these features:

* VM OS features
    * Vagrant VM parametered with vagrant-env.
    * Provisioning scripts parametered via environment variables.
    * Optimized Debian repos for faster and more reliable package installations.
    * Basic apache and SSL configuration.
    * Automatic setup of the package deployment environment.
    * Automatic opening of the web application after deployment.
    * Configurable development VM hostname
* MySQL Features
    * Auto-installed MySQL Server configured via environment variables
    * MySQL schema and data installed via scripts.
    * Scripted database dumps that separate schema from required tables from data.
    * ~/.mysql.cnf generated from configuration.
* PHP and CakePHP features
    * PHP dependencies managed with Composer.
    * Stream editing of CakePHP Configuration files.
* Software Packaging & Deployment
    * Makefile targets for building cakephp apps.
    * Makefile targets for running cakephp unit tests.
    * Makefile targets for package deployment to dev/stage/prod and related ssh key-management.
    * Example deploy.sh for deploying a cakephp app on a remote host.
    * Example deployment configuration for the development configuration.
    * Instructions for configuring the package deployment environment on your remote host.
* Configuration
    * A shared configuration file for all of the development tools.
    * Separate config files to control each of the deployment environments.

## How to use the _vagrant\_environment_ repo

To use the _vagrant\_environment_ repo, copy the entire repo to a new repository and commit it. In many cases it can be copied into an existing repo with some caution. Be careful not to overwrite the project CHANGELOG.md, and other files that have project-specific data.

You will probably want to CHANGELOG.md.  You will definitely need to adjust the configuration.  You will want to test the vagrant VM to make sure your configuration works.  You will likley want to edit bootstrap.sh to _not_ run functions your project does not need.  You will want to adjust the ./schema/Makefile to tailor the database dump targets to your project's needs. Eventually you will need to add package deployment configuration for your stage and prod hosts.

## Configuration

To configure the development environment, copy vagrant/.env_example to ./vagrant/.env and edit the new file to your applications needs.  While this is not the _only_ configuration file in this repo, it is the single most important one.  This file is used by the vagrant-env plugin to set project parameters used in VagrantFile.  It is also included by the provision scripts and all the Makefile to allow them to share a common set of parameters.

While to this file allows tremendous control, developers are advised to change only the minimum necessary to accommodate their app's _necessary differences.  All web apps are installed at `/var/ww/web_app`. You do not need to chnage this to make your app work.  On the other hand your VM needs to no collide with other VMs you migth have running, so specify a unique hostname, IP adress and port numbers is advised.

These parameters _must_ be changed:

    # Variables specific to VagrantFile
    # Tailor these to your VM's name
    HOSTNAME_IN_GUEST=fillingim-vm-debian82
    URL_OF_DEPLOYED_APP=https://fillingim.dev/web_app/
    HOSTNAME_IN_HOST=fillingim.dev

    # Change these parameters.  Make all end in the same 3 digits.
    # The acceptable range is 2-254. Add zero padding in the port
    # numbers as needed.
    VM_IP=192.168.33.110
    FORWARDED_PORT_443=56110
    FORWARDED_PORT_80=46110

    # The first of the database that is initially loaded during VM provisioning.
    # This loads causes DB_EPOCH_VERSION/schema.sql,
    # DB_EPOCH_VERSION/minimal_data.sql, and
    # DB_EPOCH_VERSION/test_data.sql to be loaded.
    # All upgrade.sql files of higher version numbers
    # will also be loaded.
    DB_EPOCH_VERSION=0.3.1

These parameters _should_ be changed:

    # Test deployment
    # A text string that can be found on the entry point to your app
    TEST_STRING_ON_FRONT_PAGE=Version
    # For a local deployment within the VM
    DEV_DEPLOY_DIR=/var/www/deployed
    DEV_DEPLOY_URL=https://fillingim.dev/deployed/
    # The root URL for the dev VM web site.
    DEV_WEBROOT_URL=https://fillingim.dev/

    # Document the deployed locations for this app instance
    APP_URL_DEV=https://ctsit-staging.ctsi.ufl.edu/fillingim/users/login
    APP_URL_PROD=https://ctsit-projects.ctsi.ufl.edu/fillingim/users/login

These parameters are project-specific, but less used:

    # Used for software verification in the iDMD Projects
    # Used to label an area in the log file generated by function: check_print_log_reqs
    PROJECT_NAME='Fillingim Web Application'
    # Used to name the file generated by function: check_print_log_reqs
    PROJECT_ID=fillingim
    # Referred to in the file generated by function: check_print_log_reqs
    PROJECT_REPO='ssh://git@ctsit-forge.ctsi.ufl.edu/fillingim.git'
    # describe where the verification docs are stored and hwow they should be packaged
    VERIFICATION_DOCS_FILENAME=fillingim_verification
    VERIFICATION_DOCS_DIRECTORY=/docs/verification/

    # Variables specific to configuring the upload target (for iDMD apps)
    SALT='wuenc8yu3h48fu39ruc9uiwjd0icjnwcde'

### Database

The schema and sample data are located under the `schema/` folder. ./schema/Makefile has commands to do standardized database dumps.  These are tailored for the iDMD projects and should be adjusted for your project.

The three files dumped are schema.sql, data_minimal.sql, data_testing.sql. Schema.sql is DDL and stored procedures, but _no data_. data_minimal.sql is the insert statements needed to make a minimally functional application. It contains _nothing_ specific to an _instance_ of an application. data_testing.sql contains enough data to bootstrap a functional instance of the application and do minimal testing.

The function _populate\_db_ in _bootstrap\_functions.sh_ expects read these three files from _./schema/$DB\_EPOCH\_VERSION/_.  _populate\_db_ will load each of these three files in the order listed above.  It will then search for all files that match the pattern ./schema/n.m.o/upgrade.sql where n.m.o is is greater than _$DB\_EPOCH\_VERSION_ It will load each of these files in version number order to deploy the very latest version of the database.

## Vagrant UP!

This project requires some vagrant plugins.  Install them with these commands:

    vagrant plugin install vagrant-env
    vagrant plugin install vagrant-hostsupdater
    vagrant plugin install vagrant-triggers

With the plugins installed, the application configured and some minimal dataqbase files in place, start the vagrant VM. with this command:

    cd vagrant/ && vagrant up

Watch the deployment process for errors.  Correct those that arise, destroy and recreate the vm until the depoyment runs to completion.  Your web browser should open to the apps web page when the deployment completes.

## Makefiles

There are three Makefile in the is repo each serve different roles. Each Makefile has a _help_ target that docuemtns the important methods. (TODO: make this true for _./schema/Makefile_)

_./Makefile_ has targets to test, package, and deploy the app.  It can only be run from the host OS.  Few if any of the targets will work correctly from the Guest VM. Note that some of the targets are just proxies for _./vagrant/Makefile_.

_./vagrant/Makefile_ has targets to test and package the app. It can only be run from the Guest VM. It will be accessible in the guest at _/vagrant_.

_./schema/Makefile_ has targets to dump the database. It can only be run from the guest VM. It appears in the guest at _/var/www/web_app/schema_.


### Packaging and Deployment

Packaging commands are available as targets in _./Makefile_ and _./vagrant/Makefile_. These are the important targets in _./Makefile_:

    all                 : Initialize the build area with the code from COMMIT,
                        run tests on the workdir and package the code from COMMIT
    test                : run all tests
    package             : Package the code from COMMIT
    show_versions       : compare code/tag/deployed version numbers
    add_key_to_staging  : Add an ssh public key to deploy@ctsit-staging
    add_key_to_prod     : Add an ssh public key to deploy@ctsit-projects
    deploy_to_dev       : Deploy PACKAGE_FILE to the development VM with the parameters in ./dev.env
    deploy_to_stage     : Deploy PACKAGE_FILE to the staging with the parameters in ./stage.env
    deploy_to_prod      : Deploy PACKAGE_FILE to the staging with the parameters in ./prod.env

These are the important targets in _./vagrant/Makefile_:

    all                 : Initialize the build area with the code from COMMIT,
                        run tests on the workdir and package the code from COMMIT
    clean               : Clean the buld area
    test                : run all tests
    package             : Package the code from COMMIT
    install             : Package the code from COMMIT and install it locally to appear at /PROJECT_ID

These commands are designed to be run from the host:


## Setting up for deployment

### Deploy user

The host where the package will be deployed requires a specific group and account exist.  This script will do the setup on an existing CTS-IT host.  Where needed, it uses the group ID of the git user to provide continuity with the older gitolite-based deployment tool.

Note: PBC wrote this, so he bootstrapped this with his own ssh key public key. If you are not PBC, you should add your key like PBC added his.

    # We're gonna need some scratch space!
    MYTEMP=`mktemp -d`

    # cat my ssh public key into a file named $MYTEMP/<$MY_GL_ID>.pub
    cat << END > $MYTEMP/pbc.pub
ssh-rsa AAAAB3NzaC1yc2EAAAABIwAAAgEAlrkWcQHSuOMbwIxEqdSwTmeK0WQq4EKVyrSJNomr6gTsERN+i0Bptkz3W7jwU77Eo1duUq87aTvgzXudsN5bTMVERbW6nf3fp1mjHtQkLTfAqBw0h9UbXD2/esvM5gbK/hj/mNvcDN10NEytrRZk9IjRV14ktYJwI6Z4aRPIi124ps3JQUg/uETa+qx9Xt8TxSU9MQlmQXygS661wHugPlPtaH4qhDGGg4h6I3002eLRi703o17LVQdiWBOJUDdwVMTIbkYiJGQ4U0E93XJMFH4paUDiDXNcWkjMUCDmhcnpkIstvWGz+nureo7c1wcHht/hsbVNiD+uKoMAm6ZgDFTD7qyXG7CblNLLBf/zKIelvftMcWRnAYl5pklN97ZDVuln5UPd/sJ5Ds0lvZLtaRR8vM25691bzWzdmv/+KhJK7ohq4mGaYQlmXslzaU3RpD+K5wKfyyfAAgioMhSSgQq6AWOd6hEWklNHB1mrl6KDaOuc7ZyL4SG0Qbq2nW73kxzNBvOIcoWIV0afX+QPXwoFJbPwBZnhppo1XjWFS57BPfv6zq566JpvJ2dXCDDA/PwFOH5v7HsueoIHEwY0SKXU8QwL+e4IlKBFWSqwTJlFLZKE5nzVlqYki6KqFsOT7mRFp+5hj9DNyXuxpDrlb5+iegK63/4Wc3ldBNGoj0s= pbc@ufl.edu
END

    cat << END > $MYTEMP/keyes.pub
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDBLC2LeTmH4q+Y3hLTggJrJ4GWrX812uBLSEi/yHk+OWHAp14LcZAudxTz13ugUh6wEEXEsr9owvfOKC+r2DpjAs3DQ2Lp9vS7hC2AyqM97nugd7zKfOjt7lHgF3CDVvfCOWUX/I7Ulsf/HaCZ/hBphX/4lMexgHCF5JfjG6Dmwc9JMW6ZOJoW0Yl9XfAOv3+ttS++tukdbUXs2n4YXasT7oe5vj8wTjtglrMcO2dcJ1qM5zYV7DyuAzshth9IU4SrU/GJKz35Vyw7MN17CCLuGxxgY8AjimI0/ZMnW/Shq/di3wsRY56Se26b15o+aG+/7gELP3xRSoU+vKd5j6H/ keyes@Psyclone241.local
END

    cat << END > $MYTEMP/cpb.pub
ssh-rsa AAAAB3NzaC1yc2EAAAADAQABAAABAQDjwQQtGrNXk16398qVV8StZkS2fmFx9BAr2PwYPBdW/Hw5if5dyPUV4SeCYwGaAnQP59klL2B4Kro1pkVq7dXxp5Bzr8kqHqZTiAKg91CE2X6YzaWjjdPDOGkHdkDGdMZPkwJzQpNmk4pwFcB5C3WUq2T2mUwAK4C7l5GD/8iePeRjhXiDWPfPD+XmWtLZN0FqlseRbr4tdMgf9oS9gj5t9WdCoGK+ZUAxMmlZ3/gZP9Ugyow9vXBJeABfZrjqAdKaHNt1eaZqj0OE/KNZp6nBhV944LaBVS8D3dQLVGUQ6I9LnOyG7BtUNcAkDdFAiZe9qaYp/gdlzVstnqIpZOr5 cpb@ufl.edu
END

    # If there is a git user, use its group for the deploy user
    if [ `getent passwd git | grep 998 -c` -eq 0 ]; then
        # make the git group if the group does not exist
        if [ `getent group git | grep 998 -c` -eq 0 ]; then
            sudo groupadd -g 998 git
        fi
        MYGROUP=git
    else
        # use the conventional www-data group if there is no git user
        MYGROUP=www-data
    fi

    # make the user with a random password
    sudo useradd -m -b /home -u 800 -g $MYGROUP -s /bin/bash -c "deployment user" deploy -p `cat /dev/urandom | tr -dc 'a-zA-Z0-9' | fold -w 32 | head -n 1`

    # set up key-based authentication
    sudo mkdir -p /home/deploy/.ssh/keys

    sudo mv $MYTEMP/*.pub /home/deploy/.ssh/keys/
    tmpfile=`mktemp`
    cat `ls -1 /home/deploy/.ssh/keys/*.pub` > $tmpfile
    sudo cp $tmpfile /home/deploy/.ssh/authorized_keys
    sudo rm $tmpfile

    # adjust the permissions for the deploy user
    sudo chmod 700 /home/deploy/.ssh
    sudo chmod 644 /home/deploy/.ssh/authorized_keys
    sudo chmod -R 700 /home/deploy/.ssh/keys
    sudo chown -R deploy.git /home/deploy


### SSH Keys for the deploy user

Additionally, each person who wants to deploy software must add their key to the deployment account.  To do that have an authorized person--someone whose key is already authorized run the make command _add\_key\_to\_staging_ or _add\_key\_to\_prod_ with the name of the keyfile as a parameter.  E.g.

    make add_key_to_staging KEYFILE=keyes.pub

### Deployment Configuration File

You will need a deployment configuration file for each environment where you want to deploy the application.  This file has database parameters and other variables that will be used to configure the application.  Here's a sample configuration used to deploy to this development VM.

    export SITENAME=fillingim
    export APP_HOSTNAME=fillingim.dev
    export DB_USER=admin
    export DB_DATABASE=app_database
    export DB_HOST=localhost
    export DB_PASSWORD=password

Copy _dev.env\_example_ to _dev.env_ and customize it for your application. If needed, make additional copies to _staging.env_ and _prod.env_ and customize those files to their respective environments.

Note: The values in deployment configuration file are being passed as bash environment variables.  As such these characters cannot be used without escaping or quoting:  |'"<>;\()&  Please be cautious when using special characters in these strings.  These characters should not cause any problems: !@#%^*-=+_~{},_.:[]


### Customizations for deploy.sh

The deploy.sh included here makes a few assumptions about the web space.  Specifically /var/www and /var/www.backup must be writeable.  Also, /var/www/PROJECT_ID must be a symbolic link.  To address the former, run these commands on the host:

    chmod g+w /var/www
    chmod g+w /var/www.backup

To address the latter, run these commands:

    PROJECT_ID=<Your Project ID>

    set -e
    SOURCE=/var/www/${PROJECT_ID}
    if [ -e ${SOURCE} ]; then
        date=`date +"%Y%m%d-%H%M"`
        TARGET=/var/www.backup/${PROJECT_ID}.${date}
        mkdir ${TARGET}
        rsync -arv $SOURCE/ $TARGET
        rm -rf $SOURCE.old
        mv $SOURCE $SOURCE.old
        ln -sf $TARGET $SOURCE
        rm -rf $SOURCE.old
    fi
