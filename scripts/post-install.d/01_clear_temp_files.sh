#!/bin/bash -e


#####################################
# apply command line arguments to local variable

while getopts 'c:e:t:' OPTION ; do
    case "${OPTION}" in
		c)
            CONCRETE_ENVIRONMENT="${OPTARG}"
            ;;
        e)
            ENVIRONMENT="${OPTARG}"
            ;;
        t)
            TARGETPATH="${OPTARG}"
            ;;
    esac
done


# Get absolute path to main directory
ABSPATH=$(cd "${0%/*}" 2>/dev/null; cd ../..; echo "${PWD}/${0##*/}")
SOURCE_DIR=`dirname "${ABSPATH}"`

#######################################################################

getLocalConfValue() {
	FIRST=$1
	SECOND=$2

	if [ ! -f "${SECOND}/htdocs/typo3conf/localconf.php" ] ; then
		echo "File \"${SECOND}/htdocs/typo3conf/localconf.php\" not found" >&2
		exit 1
	fi

	echo `grep "^\\\$${FIRST} =" ${SECOND}/htdocs/typo3conf/localconf.php | tail -1 | sed -e 's/.*= .//g' | sed -e 's/.;.*//g'`
}
#######################################################################

# do this as soon as possible! 10_prepare-permissions can run a few minutes and this caused trouble
# on production when an extension was removed.
# @see http://forge.typo3.org/issues/55080

rm -f "${SOURCE_DIR}/htdocs/typo3conf/temp_CACHED_"*

SOURCE_DB_NAME=`getLocalConfValue "typo_db" "${SOURCE_DIR}"`
SOURCE_DB_USER=`getLocalConfValue "typo_db_username" "${SOURCE_DIR}"`
SOURCE_DB_PASS=`getLocalConfValue "typo_db_password" "${SOURCE_DIR}"`
SOURCE_DB_HOST=`getLocalConfValue "typo_db_host" "${SOURCE_DIR}"`

# clear extbase caches because method signatures might have been updated
mysql -u${SOURCE_DB_USER} -p${SOURCE_DB_PASS} -h${SOURCE_DB_HOST} -D${SOURCE_DB_NAME} -e "TRUNCATE tx_extbase_cache_object; TRUNCATE tx_extbase_cache_object_tags;"
mysql -u${SOURCE_DB_USER} -p${SOURCE_DB_PASS} -h${SOURCE_DB_HOST} -D${SOURCE_DB_NAME} -e "TRUNCATE tx_extbase_cache_reflection; TRUNCATE tx_extbase_cache_reflection_tags;"
