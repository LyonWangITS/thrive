# Change Log for the THRIVE repo

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [1.1.4] - 2018-02-05
### Changed
- Fixing undefined variable error
- Fixing "25+" values save
- Increasing font size of descriptions on drinks guide
- Making gray bullets darker
- Fixing text overflow on graph bar
- Moving services from data_minimal.sql to data_testing.sql
- Updating prod.sql in order to include a list of services and disable feedback questions
- Bump code and DB version numbers to 1.1.4 in .env


## [1.1.3] - 2018-01-11
### Changed
- bump version number to 1.1.3 in .env


## [1.1.2] - 2018-01-11
### Changed
- Hard code '/thrive/' top level directory in displayed URL of dashboard (Philip Chase)


## [1.1.1] - 2018-01-11
### Changed
- Bump version number in .env to 1.1.1 (Philip Chase)
- Remove old data from prod.sql and reset passwords (Philip Chase)
- Redump the database with relocated services table and old test data removed (Philip Chase)
- Move the services table from the testing data export to the minimal data export (Philip Chase)


## [1.1.0] - 2018-01-11
### Changed
- Address customer requests from 2018-01-03 email from Rob (Tiago Bember Simeao)
- Address customer requests from 2017-12-04 email from Rob (Tiago Bember Simeao)
- Unhardcoding Tips & Facts on PDF download page. (Tiago Bember Simeao)
- Move test VM from thrive.dev to thrive.test to circumvent Chrome HSTS errors (Philip Chase)
- Fixing app url on Vagrant config. (Tiago Bember Simeao)
- Re-enabling use of services and making tips & facts configurable. (Tiago Bember Simeao)
- Changing vagrant web protocol to https. (Tiago Bember Simeao)
- Adding ID number field to initial step. (Tiago Bember Simeao)
- Vagrant startup fixes: setting correct URL and unhardcoding browser. (Tiago Bember Simeao)


## [1.0.0] - 2017-10-20
### added
- First release to customer for test
