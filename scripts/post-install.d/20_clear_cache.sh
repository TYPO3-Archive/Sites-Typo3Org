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



