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

# do this as soon as possible! 10_prepare-permissions can run a few minutes and this caused trouble
# on production when an extension was removed.
# @see http://forge.typo3.org/issues/55080

echo -n "Clear file cache..."
rm -rf "${SOURCE_DIR}/htdocs/typo3temp/Cache/*"
echo " done"

LOCALCONF_FILENAME="${SOURCE_DIR}/htdocs/typo3conf/LocalConfiguration.php"
SOURCE_DB_NAME=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB database ${LOCALCONF_FILENAME}`
SOURCE_DB_USER=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB username ${LOCALCONF_FILENAME}`
SOURCE_DB_PASS=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB password ${LOCALCONF_FILENAME}`
SOURCE_DB_HOST=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB host ${LOCALCONF_FILENAME}`
SOURCE_DB_PORT=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB port ${LOCALCONF_FILENAME}`

echo -n "Clear extbase caches because method signatures might have been updated..."
mysql -u${SOURCE_DB_USER} -p${SOURCE_DB_PASS} -h${SOURCE_DB_HOST} -P${SOURCE_DB_PORT} -D${SOURCE_DB_NAME} -e "TRUNCATE cf_extbase_object; TRUNCATE cf_extbase_object_tags;"
mysql -u${SOURCE_DB_USER} -p${SOURCE_DB_PASS} -h${SOURCE_DB_HOST} -P${SOURCE_DB_PORT} -D${SOURCE_DB_NAME} -e "TRUNCATE cf_extbase_reflection; TRUNCATE cf_extbase_reflection_tags;"
echo " done"