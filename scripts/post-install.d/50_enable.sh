#!/bin/bash -e

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
if [ `id -u -n` = 'typo3org' ]; then
	# production system - do nothing
	echo -n "Nothing to do"

else

	SOURCE_DB_NAME=`getLocalConfValue "typo_db" "${SOURCE_DIR}"`
	SOURCE_DB_USER=`getLocalConfValue "typo_db_username" "${SOURCE_DIR}"`
	SOURCE_DB_PASS=`getLocalConfValue "typo_db_password" "${SOURCE_DIR}"`
	SOURCE_DB_HOST=`getLocalConfValue "typo_db_host" "${SOURCE_DIR}"`

	echo -n "Fix  some user settings for non-production systems (Christian Z, Nikola S, Mario M, Daniel L., Kay Strobach)"
	echo "UPDATE be_users SET disable=0 WHERE uid IN (9,34, 50, 58, 151);" | mysql -u${SOURCE_DB_USER} -h${SOURCE_DB_HOST} -p${SOURCE_DB_PASS} ${SOURCE_DB_NAME}
	echo "done"
fi
