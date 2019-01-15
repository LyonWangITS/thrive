# Change Log for the THRIVE repo

All notable changes to this project will be documented in this file.
This project adheres to [Semantic Versioning](http://semver.org/).

## [standard_1.2.0] - 2019-01-15
### Changed
- Do a 3-step rename of 'sort-time' enum value on form 07 fields (Philip Chase)
- Change heading text to 'Arrive alive' in get_feedback_tips where version = 1 (Philip Chase)
- Change commit branch to standard_master. (Marly Cormar)
- Replace 'Stay off the road' by 'Arrive alive'. (Marly Cormar)
- Remove sentence starting with "Safe drinking guidelines are based ...". (Marly Cormar)
- Change "Slow down" by "Slowing down". (Marly Cormar)
- Change "Cashed up" by "A cap on your tab". (Marly Cormar)
- Replace the word "gender" by "sex". (Marly Cormar)
- Expand information on 'Standard Drinks'. (Marly Cormar)
- Expand slider bar with label "In the last four weeks what is the largest number of standard drinks you have consumed on a single occasion?" to 36+. (Marly Cormar)
- Update paragraph below label "Stay of the road". (Marly Cormar)
- Change the bullets under "Standard Drinks". (Marly Cormar)
- Update bullet points under 'Staying Under the Limit'. (Marly Cormar)
- Change the word "gender" by "sex". (Marly Cormar)
- Change from "audit" to "AUDIT". (Marly Cormar)
- Correct typo by changing "to" to "do". (Marly Cormar)
- Change from "boyfriend/girlfriend/spouse" to "romantic partner". (Marly Cormar)
- Change ip and ports to avoid conflicts with idmd dev host. (Marly Cormar)

### Add
- Add data download instructions to README and clean up formatting (Philip Chase)
- Include new option for the living arrangements. (Marly Cormar)


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
