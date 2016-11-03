GIT_STATUS_FILE=$1
GIT_DIR=$2

if [ ! -e ${GIT_STATUS_FILE} ]; then
    cd $GIT_DIR && git status | md5sum > ${GIT_STATUS_FILE}
else
    cd $GIT_DIR && git status | md5sum > ${GIT_STATUS_FILE}.tmp
    diff -u ${GIT_STATUS_FILE}.tmp ${GIT_STATUS_FILE}
    if [ $? -eq 1 ]; then
        mv -f ${GIT_STATUS_FILE}.tmp ${GIT_STATUS_FILE}
    fi
fi
