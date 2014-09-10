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

list="
${SOURCE_DIR}/htdocs/fileadmin/user_upload/_temp_/importexport
${SOURCE_DIR}/htdocs/uploads/media
${SOURCE_DIR}/htdocs/uploads/pics
${SOURCE_DIR}/htdocs/uploads/tf
${SOURCE_DIR}/htdocs/typo3temp/_processed_
"

for FOLDER_PATH in $list ; do
	echo -n "Create $FOLDER_PATH... "
	mkdir -p --mode=0775 "$FOLDER_PATH"
	echo "done"
done

