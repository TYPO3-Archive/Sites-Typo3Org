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
if [ "${ENVIRONMENT}" = "production" ] ; then
	# production system - do nothing
	echo -n "Nothing to do"

else

	SOURCE_DB_NAME=`getLocalConfValue "typo_db" "${SOURCE_DIR}"`
	SOURCE_DB_USER=`getLocalConfValue "typo_db_username" "${SOURCE_DIR}"`
	SOURCE_DB_PASS=`getLocalConfValue "typo_db_password" "${SOURCE_DIR}"`
	SOURCE_DB_HOST=`getLocalConfValue "typo_db_host" "${SOURCE_DIR}"`

	echo -n "Fix  some user settings for non-production systems (Christian Z, Nikola S, Mario M, Daniel L., Kay Strobach, Tomas Norre)"
	echo "UPDATE be_users SET disable=0 WHERE uid IN (9,34, 50, 58, 151, 153);" | mysql -u${SOURCE_DB_USER} -h${SOURCE_DB_HOST} -p${SOURCE_DB_PASS} ${SOURCE_DB_NAME}
	echo -n "Make editor an admin on non-production systems (Thomas L.)"
	echo "UPDATE be_users SET admin=1 WHERE uid IN (132);" | mysql -u${SOURCE_DB_USER} -h${SOURCE_DB_HOST} -p${SOURCE_DB_PASS} ${SOURCE_DB_NAME}
	echo "done"
fi
