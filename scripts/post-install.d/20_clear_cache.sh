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

#find "${SOURCE_DIR}/htdocs/typo3temp" -type f -not -path "${SOURCE_DIR}/htdocs/typo3temp/ter_*"  -delete

if [ -d "${SOURCE_DIR}/htdocs/typo3temp/js_css_optimizer" ]; then
	find "${SOURCE_DIR}/htdocs/typo3temp/js_css_optimizer" -type f -delete
fi

/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" lowlevel_cleaner tx_cachecleaner_cache -r --AUTOFIX --YES -s --optimize --tables sys_log
/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" cleartypo3cache all > /dev/null
