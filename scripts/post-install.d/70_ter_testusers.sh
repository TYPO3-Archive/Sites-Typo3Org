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
if [ "${ENVIRONMENT}" = "production" ] ; then
	# production system - do nothing
	echo -n "Nothing to do"

else

	LOCALCONF_FILENAME="${SOURCE_DIR}/htdocs/typo3conf/LocalConfiguration.php"
	SOURCE_DB_NAME=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB database ${LOCALCONF_FILENAME}`
	SOURCE_DB_USER=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB username ${LOCALCONF_FILENAME}`
	SOURCE_DB_PASS=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB password ${LOCALCONF_FILENAME}`
	SOURCE_DB_HOST=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB host ${LOCALCONF_FILENAME}`
	SOURCE_DB_PORT=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php" DB port ${LOCALCONF_FILENAME}`

	echo -n "Import test users for TER SOAP API testing..."
	mysql -u${SOURCE_DB_USER} -h${SOURCE_DB_HOST} -p${SOURCE_DB_PASS} ${SOURCE_DB_NAME} < "${SOURCE_DIR}/scripts/post-install.d/assets/ter_testusers.sql"
	echo " done"
fi
