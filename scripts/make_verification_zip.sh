#!/usr/bin/env bash
# Author: Roy Keyes <keyes@ufl.edu>
# Description: Collects documents from a directory specified below
# in DOCS_DIR and makes a custom zip file named by below in FILE_NAME
# which is one of 2 variables passed in on the command line


# Command line argument #1, which version would you like zipped
WHICH_VERSION=${1}

# Command line argument #2, what is the name for the zip file
# This will have the version number appended to it
FILE_NAME=${2}

# Where are the docs, based on the current directory
DOCS_DIR=${3}

# Name the zip file based on concatenation of FILE_NAME & WHICH_VERSION
ZIP_FILE_NAME=${FILE_NAME}_${WHICH_VERSION}
# Attach the extension here, since this filename is used in multiple locations
ZIP_FILE_NAME_WITH_EXTENSION=${ZIP_FILE_NAME}.zip

# What directory is this script operating from
MY_DIR=`pwd`

if [ -z ${WHICH_VERSION} ] || [ -z ${FILE_NAME} ] || [ -z ${DOCS_DIR} ];
then
    echo "ERROR: MISSING VERSION, FILE NAME, OR VERIFICATION DOCS DIRECTORY"
    echo "Usage: make_verification_zip.sh VERSION FILENAME DOCSDIR"
    exit
else
    echo "Zipping: ${WHICH_VERSION}"
    FULL_PATH=${MY_DIR}${DOCS_DIR}${WHICH_VERSION}

    if [ -d "${FULL_PATH}" ];
    then
        echo "Changing to directory: ${FULL_PATH}"
        cd ${FULL_PATH}
        if [ -f "${ZIP_FILE_NAME_WITH_EXTENSION}" ];
        then
            rm ${ZIP_FILE_NAME_WITH_EXTENSION}
        fi

        echo "Making tmp directory: ${FULL_TMP_PATH}"
        TMP_DIR=`mktemp -d`
        FULL_TMP_PATH="${TMP_DIR}/${ZIP_FILE_NAME}"
        mkdir ${FULL_TMP_PATH}

        if [ -d "${FULL_TMP_PATH}" ];
        then
            echo "Copying all ${VERSION} files to temp: {$FULL_TMP_PATH}"
            cp ./* $FULL_TMP_PATH

            echo "Zipping files to ${ZIP_FILE_NAME_WITH_EXTENSION}"
            pushd ${TMP_DIR}
            zip -r ${ZIP_FILE_NAME_WITH_EXTENSION} ./${ZIP_FILE_NAME}/* -x *.zip -x *.md
            popd

            PATH_TO_ZIP=${TMP_DIR}/${ZIP_FILE_NAME_WITH_EXTENSION}
            if [ -f ${PATH_TO_ZIP} ];
            then
                echo "Copying the zip file from temp to PWD: ${MY_DIR}/${ZIP_FILE_NAME_WITH_EXTENSION}"
                cp ${PATH_TO_ZIP} ${MY_DIR}/
            else
                echo "Unable to access/copy the zip file from temp: ${PATH_TO_ZIP}"
                exit
            fi
        else
            echo "Unable to create temporary directory ${TMP_DIR}"
            exit
        fi
    else
        echo "Directory not found: ${FULL_PATH}"
        exit
    fi
fi
