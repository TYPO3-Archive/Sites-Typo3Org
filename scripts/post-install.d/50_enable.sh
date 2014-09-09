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
	SOURCE_DB_NAME=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php DB database ${LOCALCONF_FILENAME}"`
	SOURCE_DB_USER=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php DB username ${LOCALCONF_FILENAME}"`
	SOURCE_DB_PASS=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php DB password ${LOCALCONF_FILENAME}"`
	SOURCE_DB_HOST=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php DB host ${LOCALCONF_FILENAME}"`
	SOURCE_DB_PORT=`php "${SOURCE_DIR}/scripts/utility/getLocalConfiguration.php DB port ${LOCALCONF_FILENAME}"`

	echo "Give users an admin login who do not have one on production."
	echo "Christian Zenker, Thomas Löffler, Kay Strobach, Tomas Norre, Sascha Schmidt, Björn Jacob)"
	echo "UPDATE be_users SET disable=0, admin=1 WHERE uid IN (9, 132, 151, 153, 166, 168);" | mysql -u${SOURCE_DB_USER} -h${SOURCE_DB_HOST} -P${SOURCE_DB_PORT} -p${SOURCE_DB_PASS} ${SOURCE_DB_NAME}
	echo "done"
fi
