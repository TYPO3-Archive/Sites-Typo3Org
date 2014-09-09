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

echo 'activate extension "dam_falmigration"...'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase extension:install dam_falmigration
echo "done"

echo 'migrate dam to fal "dammigration:connectdamrecordswithsysfile"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase dammigration:connectdamrecordswithsysfile

echo 'migrate dam to fal "dammigration:migratedammetadata"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase dammigration:migratedammetadata

echo 'migrate dam to fal "dammigration:migratemediatagsinrte"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase dammigration:migratemediatagsinrte
echo 'migrate dam links in flexforms'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase dammigration:migratemediatagsinrte tt_content tx_templavoila_flex

echo 'migrate dam to fal "dammigration:migratedamcategoriestofalcollections"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase dammigration:migratedamcategoriestofalcollections

echo 'migrate dam to fal "dammigration:migratedamfrontendplugins"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase dammigration:migratedamfrontendplugins

echo 'migrate dam to fal "dammigration:migraterelations"'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase dammigration:migraterelations

echo 'deactivate extension "dam_falmigration"...'
/usr/bin/php -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" extbase extension:uninstall dam_falmigration
echo "done"