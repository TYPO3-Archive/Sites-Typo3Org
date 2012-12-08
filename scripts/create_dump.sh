#!/bin/bash -e

#####################################
# extract value of php variables used in localconf.php
getLocalConfValue() {
    FIRST=$1
    SECOND=$2

    if [ ! -f "${SECOND}/htdocs/typo3conf/localconf.php" ] ; then
        echo "File \"${SECOND}/htdocs/typo3conf/localconf.php\" not found" >&2
        exit 1
    fi

    echo `grep "^\\\$${FIRST} =" ${SECOND}/htdocs/typo3conf/localconf.php | tail -1 | sed -e 's/.*= .//g' | sed -e 's/.;.*//g'`
}

function usage {
    echo "Usage:"
    echo "  $0 [-v] -u <db user> [-p <db pass>] [-h <db host>] -d <database> -r <system root> -t <backup target> -s <system> [-c] [-x] [-a]"
    echo "Option -a Create complete dump including all cache information"
    echo "Option -c Use compression"
    echo "Option -x Skip file backup"
    echo ""
    exit $1
}

## Set defaults - can be overridden later
BACKUP_EXCLUDE_FOLDERS="htdocs/typo3temp"
BACKUP_IGNORE_TABLES="cache_extensions cache_hash cache_imagesizes cache_md5params cache_pages cache_pagesection cache_typo3temp_log tx_ncstaticfilecache_file tx_realurl_errorlog tx_realurl_pathcache tx_realurl_uniqalias tx_realurl_urldecodecache tx_realurl_urlencodecache be_sessions fe_sessions fe_session_data cachingframework_cache_hash cachingframework_cache_hash_tags cachingframework_cache_pagesection cachingframework_cache_pagesection_tags cachingframework_cache_pages cachingframework_cache_pages_tags"
USE_COMPRESSION=0
CREATE_COMPLETE_DUMP=0
SKIP_FILES=0
SOURCE_DB_HOST="localhost"
SOURCE_DB_PASS=""
mysqlDumpCommand="mysqldump"
mysqlCommand="mysql"


########## get argument-values
while getopts 'u:p:h:d:r:t:s:c:xa' OPTION ; do
    case "${OPTION}" in
        a)  CREATE_COMPLETE_DUMP=1;;
        u)  SOURCE_DB_USER="${OPTARG}";;
        p)  SOURCE_DB_PASS="${OPTARG}";;
        h)  SOURCE_DB_HOST="${OPTARG}";;
        d)  SOURCE_DB_NAME="${OPTARG}";;
        r)  SYSTEM_ROOT_DIR=`echo "${OPTARG}" | sed -e "s/\/*$//" `;; # delete last slash
        t)  BACKUP_TARGET_DIR=`echo "${OPTARG}" | sed -e "s/\/*$//" `;; # delete last slash
        s)  SYSTEM="${OPTARG}";;
        c)  USE_COMPRESSION=1;;
        x)  SKIP_FILES=1;;
        \?) echo; usage 1;;
    esac
done


########## check if all duty arguments are set
if [ -z "${SYSTEM_ROOT_DIR}" ]; then
    echo "$0: missing required option -- r"
    echo
    usage 1
fi
if [ -z "${BACKUP_TARGET_DIR}" ]; then
    echo "$0: missing required option -- t"
    echo
    usage 1
fi
if [ -z "${SYSTEM}" ]; then
    echo "$0: missing required option -- s"
    echo
    usage 1
fi

#####################################
# grep install parameter from package
if [ -z "${SOURCE_DB_USER}" ] || [ -z "${SOURCE_DB_PASS}" ] || [ -z "${SOURCE_DB_HOST}" ] || [ -z "${SOURCE_DB_NAME}" ] ; then
	SOURCE_DB_NAME=`getLocalConfValue "typo_db" "${SYSTEM_ROOT_DIR}"`
	SOURCE_DB_USER=`getLocalConfValue "typo_db_username" "${SYSTEM_ROOT_DIR}"`
	SOURCE_DB_PASS=`getLocalConfValue "typo_db_password" "${SYSTEM_ROOT_DIR}"`
	SOURCE_DB_HOST=`getLocalConfValue "typo_db_host" "${SYSTEM_ROOT_DIR}"`
fi

### OVERRIDE with property file:
if [ -f "${SYSTEM_ROOT_DIR}/Configuration/package.properties" ]; then
	echo "Reading project shell properties..";
	. ${SYSTEM_ROOT_DIR}/Configuration/package.properties
fi



########## define Folder
BACKUP_TARGET_DIR_SYSTEM="${BACKUP_TARGET_DIR}/${SYSTEM}/"
BACKUP_TARGET_DIR_SYSTEM_FILES="${BACKUP_TARGET_DIR_SYSTEM}files/"
BACKUP_TARGET_DIR_SYSTEM_DATABASE="${BACKUP_TARGET_DIR_SYSTEM}database/"

########## Do some basic checks:
if [ ! -d "${SYSTEM_ROOT_DIR}/htdocs" ]; then
   echo "Error: $SYSTEM_ROOT_DIR/htdocs does not exist!"
    exit 1
fi
if [ ! -d "${SYSTEM_ROOT_DIR}/htdocs/fileadmin" ]; then
    echo "Error: $SYSTEM_ROOT_DIR/htdocs seems not to be the home of TYPO3!"
    exit 1
fi



########## Show info, before we start the backup
echo "About to create a filesystem and database dump of system ${SYSTEM} with this configuration:"
echo " - DB: ${SOURCE_DB_NAME}@${SOURCE_DB_HOST} (DB-account:${SOURCE_DB_USER}/${SOURCE_DB_PASS})"
echo " - system root: ${SYSTEM_ROOT_DIR}/"
echo " - backup target: ${BACKUP_TARGET_DIR_SYSTEM}"


########## Create directorys
if [ ! -d "${BACKUP_TARGET_DIR_SYSTEM}" ]; then
    mkdir "$BACKUP_TARGET_DIR_SYSTEM"
fi
if [ ! -d "${BACKUP_TARGET_DIR_SYSTEM_FILES}" ] && [ "$SKIP_FILES" -eq 0 ]; then
    mkdir "$BACKUP_TARGET_DIR_SYSTEM_FILES"
fi
if [ -d "${BACKUP_TARGET_DIR_SYSTEM_DATABASE}" ]; then
    rm -rf "$BACKUP_TARGET_DIR_SYSTEM_DATABASE"
fi
mkdir "$BACKUP_TARGET_DIR_SYSTEM_DATABASE"


########## Remove backup_success.txt to mark the backup as not finished
if [ -f "${BACKUP_TARGET_DIR_SYSTEM}backup_successful.txt" ]; then
	rm "${BACKUP_TARGET_DIR_SYSTEM}backup_successful.txt"
fi

########## Create SQL-file with data-structure for all tables
echo -n "Dumping database-structure..."
"${mysqlDumpCommand}" --skip-lock-tables --single-transaction -u"${SOURCE_DB_USER}" -p"${SOURCE_DB_PASS}" -h"${SOURCE_DB_HOST}" --opt --no-data "${SOURCE_DB_NAME}" > "${BACKUP_TARGET_DIR_SYSTEM_DATABASE}structure.sql"
echo "done"


########## create SQL-files for each-table with SQL-insert-statements
echo -n "Dumping database-data..."
MYSQL_TABLES=`"${mysqlCommand}" -u"${SOURCE_DB_USER}" -p"${SOURCE_DB_PASS}" -h"${SOURCE_DB_HOST}" ${SOURCE_DB_NAME} --batch --silent -e "SHOW TABLES"`
for TABLE in ${MYSQL_TABLES}; do
    if [ ! -z "`echo ${BACKUP_IGNORE_TABLES} | grep -ve "\(^\|\W\)$TABLE\(\W\|\$\)"`" -o "${CREATE_COMPLETE_DUMP}" -ne 0 ] ; then
        "${mysqlDumpCommand}" --skip-lock-tables --single-transaction -u"${SOURCE_DB_USER}" -p"${SOURCE_DB_PASS}" -h"${SOURCE_DB_HOST}" --opt --complete-insert --no-create-info "${SOURCE_DB_NAME}" "${TABLE}" > "${BACKUP_TARGET_DIR_SYSTEM_DATABASE}data_${TABLE}.sql"
    fi
done
echo "done"


########## copy files
if [ "$SKIP_FILES" -ne 0 ]; then
    echo -n "Skip copying filesystem..."
else
    ########## define rsync-options
    RSYNC_OPTIONS=(
        --force
        --ignore-errors
        --omit-dir-times
        --archive
        --partial
        --delete-after
        --delete-excluded
        "--exclude='create_backup.sh'"
        "--exclude='backup/'"
        "--exclude='backup_storage/'"
        "--exclude='systemstorage/'"
        "--exclude='.svn/'"
        "--exclude='*/.svn/'"
    )

    if [ "${CREATE_COMPLETE_DUMP}" -ne 1 ] ; then
        for FOLDER in `echo ${BACKUP_EXCLUDE_FOLDERS}`; do
            RSYNC_OPTIONS+=("--exclude='${FOLDER}'")
        done
    fi

    echo -n "Copying relevant filesystem..."
    rsync "${RSYNC_OPTIONS[@]}" "${SYSTEM_ROOT_DIR}/" "${BACKUP_TARGET_DIR_SYSTEM_FILES}/"
    echo "done"
fi

########## Create backup_success.txt to mark the backup as success
touch "${BACKUP_TARGET_DIR_SYSTEM}backup_successful.txt"

########## compress files
if [ "$USE_COMPRESSION" -ne 0 ]; then
    echo -n "Compressing files..."
    tar cfCz "$BACKUP_TARGET_DIR_SYSTEM$SYSTEM.tar.gz" $BACKUP_TARGET_DIR_SYSTEM*
    rm -rf "$BACKUP_TARGET_DIR_SYSTEM_HTDOCS"
    rm -rf "$BACKUP_TARGET_DIR_SYSTEM_DATABASE"

    echo "done"
fi
