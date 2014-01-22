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

#find "${SOURCE_DIR}/htdocs/typo3temp" -type f -not -path "${SOURCE_DIR}/htdocs/typo3temp/ter_*"  -delete

if [ -d "${SOURCE_DIR}/htdocs/typo3temp/js_css_optimizer" ]; then
	find "${SOURCE_DIR}/htdocs/typo3temp/js_css_optimizer" -type f -delete
fi

/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" lowlevel_cleaner tx_cachecleaner_cache -r --AUTOFIX --YES -s --optimize --tables sys_log
/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" cleartypo3cache all > /dev/null


SOURCE_DB_NAME=`getLocalConfValue "typo_db" "${SOURCE_DIR}"`
SOURCE_DB_USER=`getLocalConfValue "typo_db_username" "${SOURCE_DIR}"`
SOURCE_DB_PASS=`getLocalConfValue "typo_db_password" "${SOURCE_DIR}"`
SOURCE_DB_HOST=`getLocalConfValue "typo_db_host" "${SOURCE_DIR}"`

# tx_realurl_urlencodecache is quite huge (due to SOLR) and the major reason of
# performance issues after production deployment.
# @see http://forge.typo3.org/issues/51639
# Could be removed after http://forge.typo3.org/issues/54000 has been fixed
mysql -u${SOURCE_DB_USER} -p${SOURCE_DB_PASS} -h${SOURCE_DB_HOST} -D${SOURCE_DB_NAME} -e "TRUNCATE tx_realurl_urlencodecache;"
