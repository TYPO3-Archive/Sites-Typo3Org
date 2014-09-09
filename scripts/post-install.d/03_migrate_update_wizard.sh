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
#
# execute the Update Wizard tasks from the Install Tool

echo 'activate extension "cli_update_wizard"...'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase extension:install cli_update_wizard
echo "done"

echo 'execute migration "extensionManagerTables"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase migration:perform extensionManagerTables

echo 'execute migration "addFlexformsToAcl"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase migration:perform addFlexformsToAcl

echo 'execute migration "sysext_file_images"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase migration:perform sysext_file_images

echo 'execute migration "sysext_file_splitMetaData"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase migration:perform sysext_file_splitMetaData

echo 'execute migration "sysext_file_truncateProcessedFileTable"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase migration:perform sysext_file_truncateProcessedFileTable

echo 'execute migration "sysext_file_filemounts"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase migration:perform sysext_file_filemounts

echo 'updating refindex (needed for migration "sysext_file_rtemagicimages")'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" lowlevel_refindex -e -s

echo 'execute migration "sysext_file_rtemagicimages"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase migration:perform sysext_file_rtemagicimages

echo 'deactivate extension "cli_update_wizard"...'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase extension:uninstall cli_update_wizard
echo "done"