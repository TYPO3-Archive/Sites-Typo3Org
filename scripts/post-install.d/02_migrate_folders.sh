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

mkdir -p --mode=0775 "${SOURCE_DIR}/htdocs/fileadmin/user_upload/_temp_/importexport"
mkdir -p --mode=0775 "${SOURCE_DIR}/htdocs/uploads/{media,pics,tf}"
# a bug prevents TYPO3 from creating this folder when needed
# @see http://forge.typo3.org/issues/55833
mkdir -p --mode=0775 "${SOURCE_DIR}/htdocs/typo3temp/_processed_"

