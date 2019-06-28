# Developers notes for US THRIVE

## Accessing the management app

Access logins at [https://thrive.test/admin/login](https://thrive.test/admin/login)

The default admin account is `admin@example.com`, password of `password`.
The default site account at Demo University is `demo@example.com`, password of `password`.

Survey results can be accessed by logging in at [https://thrive.test/admin/login](https://thrive.test/admin/login) as `albert@example.com` with password of `password`.


## Survey access

The survey can be accessed via the site login or directly at http://thrive.dev/demo


## Database dumps and VM database creation

The database in the VM is built with functions in bootstrap_functions.sh.  populate_db looks in ./schema/$DB_EPOCH_VERSION for the files schema.sql, data_minimal.sql, and data_testing.sql  It builds a database from those files. It then looks for ./schema/N.M.O/upgrade.sql where N.M.O is higher than $DB_EPOCH_VERISON and applies those files in version sort order.

You can generate new schema.sql, data_minimal.sql, and data_testing.sql files form the VM as user root by CDing to /var/www/web_app/schema and runnign `make`.  Specifically, `make dump_dev` will generate all three files and place them at ./schema

To use the new schema.sql, data_minimal.sql, and data_testing.sql files as a new database epoch, create a folder ./schema/N.M.O and copy the three files into it. Then revise ./.env to reference N.M.O for the DB_EPOCH_VERSION. Then rebuild the VM to test the new DB EPOCH.


### Database deployment

When building the test VM, the database will automatically deploy the latest database. This is only achievable through a strict management of database updates.

The database schema is stored in subfolders of `./schema`.  Each subfolder is named for the version of the software it supports. For each version which requires a database change a versioned folder must be created and populated with an upgrade.sql.  In most every case, a corresponding downgrade.sql should also be created. The `upgrade.sql` applies the changes needed by that version of the software.  The downgrade.sql reverts those changes.

At certain points in the lifecycle of the project it might be beneficial to create a complete database dump to allow the state of the database to be described in a single file or loaded more rapidly. The _epoch_ files are also stored in the `./schema/x.y.z/` folders. There are three such files: `schema.sql`, `data_minimal.sql`, and `data_testing.sql`.  If the epoch files occur on a version number that has an upgrade.sql, they are stored alongside the upgrade.sql.

    schema.sql: defines the structure of the database.  It is almost entirely CREATE TABLE statements. It has no data in it.

    data_minimal.sql: has the absolutely smallest data set required to allow the application to run in a development environment. It is entirely made of INSERT statements. Commonly it populates look up tables and creates default user accounts.

    data_testing.sql: has a useful data set for testing the application.  These lines of sql could be very few records or a great many records. The contents of this file should be a testing dataset to save the developer from the burden of creating test data each time a VM is built. It is composed entirely of insert statements.

The three epoch files are created by a series of mysql dump commands run from ./schema/Makefile. The dump commands are carefully tailored to separate DDL from the data and the minimal data set from the testing data. The makefile can only be run as root from the VM.

When the VM is built, the Vagrant provisioning scripts reference a variable `DB_EPOCH_VERSION` in `./vagrant/.env` to determine which of the epoch files to use for the initial database construction. The provisioning script loads these three files in the order `schema.sql`, `data_minimal.sql`, and `data_testing.sql`. After loading the epoch files, the script then loads each upgrade.sql whose version number is higher than `DB_EPOCH_VERSION`. It loads these upgrade.sql files in version sort order from lowest to highest to preserve the sequence in which they were created.


### Database deployment in staging or prod

When deploying the database in a staging or prod instance, the epoch files are only used once. What's more the testing data is not used.  A small `prod.sql.example` with production passwords for the default accounts might be used, but this is optional. Any such `prod.sql.example` would be crafted by hand. Generally this is done by cribbing content from the `data_minimal.sql` and `data_testing.sql` files. This project includes a `prod.sql.example` which serves as a template for the SQL changes that need to be applied to a new staging or production instance of this application.

To set up a new database, apply first the latest `schema.sql` file to the db, and then proceed with the `data_minimal.sql` and `prod.sql.example` files. Note that the `prod.sql.example` file should be edited; at least the password 'change this password' should be updated.

For upgrades to staging or production hosts, `upgrade.sql` scripts are applied by hand. Each upgrade.sql for versions between that which is deployed and that which you are upgrading to must be deployed by hand, in ascending version sort order. They can be batched together, but they must all be applied and in the correct order.

For example if you were running 4.7.0 and were deploying 4.12.0 you would check
for the upgrade.sql files and run each one you found in order.  As some releases
do not include database updates you might find a shorter list as shown here:

    ./schema/4.7.0/upgrade.sql
    ./schema/4.8.0/upgrade.sql
    ./schema/4.11.0/upgrade.sql
    ./schema/4.12.0/upgrade.sql


<a name="Rollback"></a>
## Rollback or Downgrade

If a software release needs to be reversed, each step of the deployment has to be reversed.

### Code Rollback

The code deployment scripts deploy each version of the code to /var/www.backup/(appName).YYYYMMDD-HHMM.  before symlinking it into the production location.  To revert, the code, delete the current symlink and replace it with one pointing at the previous code.


### Database Rollback

To the rollback the database, follow procedures like those for upgrade, but use
the downgrade.sql scripts.


