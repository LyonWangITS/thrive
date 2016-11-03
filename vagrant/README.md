# CakePHP Development VM

## Intro

This Vagrant VM builds a Debian Linux box for CakePHP development.  It
installs a local Apache, MySQL, CakePHP and dependencies.  It is designed for
rapid construction, live code changes, and rapid database refresh.

The configuration of this VM is parameterized via the Vagrant ENV plugin.  All
project-specific details should be saved into .env in this folder. This applies
to details needed in VagrantFile, the shell scripts it calls, the Makefile
at the root of this repo, `./Makefile` and the Makefile at `./schema/Makefile`.

This project requires some vagrant plugins.  Install them with these commands:

    vagrant plugin install vagrant-env
    vagrant plugin install vagrant-hostsupdater

With the plugins installed, run `vagrant up` to build this VM.


## iDMD-Specific features

The VM included some features specific to the Imaging DMD projects.  These are
contained principally in the script idmd_functions.sh. This script is included in
bootstrap.sh which references its functions.
