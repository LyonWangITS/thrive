# Developers notes for US THRIVE

## Accessing the management app

Access logins at [https://thrive.test/admin/login](https://thrive.test/admin/login)

The default admin account is `admin@example.com`, password of `password`.
The default site account at Demo University is `demo@example.com`, password of `password`.

Survey results can be accessed by logging in at [https://thrive.test/admin/login](https://thrive.test/admin/login) as `albert@example.com` with password of `password`.


## Survey access

The survey can be accessed via the site login or directly at http://thrive.dev/demo

While testing new code, you may wish to autofill all values to get to the page you are modifying; a helper script and instructions are provided at `scripts/autofill_page.js`.


## Database dumps and VM database creation

The database in the VM is built with functions in `bootstrap_functions.sh`. `populate_db` looks in `./schema/$DB_EPOCH_VERSION` for the files `schema.sql`, `data_minimal.sql`, and `data_testing.sql`. It builds a database from those files. It then looks for `./schema/N.M.O/upgrade.sql` where `N.M.O` is higher than `$DB_EPOCH_VERSION` and applies those files in version sort order.

You can generate new `schema.sql`, `data_minimal.sql`, and `data_testing.sql` files form the VM as user root by `cd`'ing to `/var/www/web_app/schema` and running `make`. Specifically, `make dump_dev` will generate all three files and place them at `./schema`.

To use the new `schema.sql`, `data_minimal.sql`, and `data_testing.sql` files as a new database epoch, create a folder `./schema/N.M.O` and copy the three files into it. Then revise `./.env` to reference `N.M.O` for the `DB_EPOCH_VERSION`. Then rebuild the VM to test the new DB EPOCH.

