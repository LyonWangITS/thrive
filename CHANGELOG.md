# Change Log for the THRIVE repo

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [anchors_1.3.1] - 2020-08-28
### Added
- add timestamps for submission of each survey page (Kyle Chesney)
- Add VERSION matching existing CODE_VERSION value in .env (Philip Chase)
- add additional gpg keyserver (Kyle Chesney)
- add form filling js script and update README (Kyle Chesney)

### Changed
- Add "I choose not to answer" option to drinking questions and the "generally I see things.." question. (Marly Cormar)
- Add "I choose not to answer" option to smoking questions. (Marly Cormar)


## [1.2.4] - 2019-08-26
### Changed
- Increase font size in the personalized feedback. (Marly Cormar)


## [1.2.3] - 2019-06-28
### Changed
- Document the required installation of vbguest vagrant plugin. (Marly Cormar)
- Upgrade sync folder type to virtualbox. (Marly Cormar)
- Install php5.6 and needed packages. (Marly Cormar)
- Include debian stretch repos in the sources list. (Marly Cormar)
- Change php5enmod/dismod by phpenmod/dismod in the Makefile. (Marly Cormar)
- Set CONFIG_VM_BOX to debian/stretch64 in the .env file. (Marly Cormar)
- Update prod.sql.example with Bonnie Rowland as a new user. (Marly Cormar)
- Update code_version to 1.2.2. (Marly Cormar)
- Specify how to set up a new db in the documentation. (Marly Cormar)


## [1.2.2] - 2018-12-07
### Changed
- Fix female drinks per occasion/week. (Marly Cormar)
- Change commit branch from master to anchors_master. (Marly Cormar)


## [1.2.1] - 2018-11-09
### Changed
- Update password for admin and Leeman's user accounts. (Marly Cormar)
- Update DB_EPOCH_VERSION and CODE_VERSION. (Marly Cormar)
- Update schema files for v1.2.0 (Marly Cormar)
- Include database deployment instructions. (Marly Cormar)
- Relocate services from data_minimal to data_testing. (Marly Cormar)
- Associate db changes with the correct version number. (Marly Cormar)


## [1.2.0] - 2018-11-09
### Changed
- Update anchors branch with changes for the anchors MSM study provided by Rober Leeman on 09-12-2018.
- Update normative scores for average ethanol consumption. (Marly Cormar)
- Update schema and data testing. (Marly Cormar)
- Increase max. possible age to 30. (Marly Cormar)
- Remove past_4wk_std_drinks_* and past_4wk_drinks. (Marly Cormar)
- Add data download instructions to README and clean up formatting (Philip Chase)
- Expand slider bar with label "In the last four weeks what is the largest number of standard drinks you have consumed on a single occasion?" to 36+. (Marly Cormar)
- Make aesthetic changes to the wording of instructions and feedback.


## [1.1.8] - 2018-05-04
### Changed
- Do a 3-step rename of 'sort-time' enum value on form 07 fields (Philip Chase)


## [1.1.7] - 2018-05-04
### Changed
- Fixed selection of "Some of the time"


## [1.1.6] - 2018-03-21
### Changed
- Fixing width of paragraph elements on mobile
- Fixing feedback sections auto open on mobile


## [1.1.5] - 2018-03-20
### Changed
- Typos and small text fixes
- Small fixes on mobile version


## [1.1.4] - 2018-02-21
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
