#!/bin/bash -e

# Get absolute path to main directory
ABSPATH=$(cd "${0%/*}" 2>/dev/null; cd ../..; echo "${PWD}/${0##*/}")
SOURCE_DIR=`dirname "${ABSPATH}"`

#######################################################################

#find "${SOURCE_DIR}/htdocs/typo3temp" -type f -not -path "${SOURCE_DIR}/htdocs/typo3temp/ter_*"  -delete

if [ -d "${SOURCE_DIR}/htdocs/typo3temp/js_css_optimizer" ]; then
	find "${SOURCE_DIR}/htdocs/typo3temp/js_css_optimizer" -type f -delete
fi

rm -f "${SOURCE_DIR}/htdocs/typo3conf/temp_CACHED_"*

/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" lowlevel_cleaner tx_cachecleaner_cache -r --AUTOFIX --YES -s --optimize --tables sys_log
/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" cleartypo3cache all > /dev/null


CONFIG_TYPO_DB_USERNAME=$(grep \$typo_db_username ${SOURCE_DIR}/htdocs/typo3conf/localconf.php | cut -d\' -f2)
CONFIG_TYPO_DB_PASSWORD=$(grep \$typo_db_password ${SOURCE_DIR}/htdocs/typo3conf/localconf.php | cut -d\' -f2)
CONFIG_TYPO_DB_HOST=$(grep \$typo_db_host ${SOURCE_DIR}/htdocs/typo3conf/localconf.php | cut -d\' -f2)
CONFIG_TYPO_DB=$(grep -e \$typo_db[^_] ${SOURCE_DIR}/htdocs/typo3conf/localconf.php | cut -d\' -f2)

# tx_realurl_urlencodecache is quite huge (due to SOLR) and the major reason of
# performance issues after production deployment.
# @see http://forge.typo3.org/issues/51639
# Could be removed after http://forge.typo3.org/issues/54000 has been fixed
mysql -u${CONFIG_TYPO_DB_USERNAME} -p${CONFIG_TYPO_DB_PASSWORD} -h${CONFIG_TYPO_DB_HOST} -D${CONFIG_TYPO_DB} -e "TRUNCATE tx_realurl_urlencodecache;"
