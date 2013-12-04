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

INTERNALENVIRONMENTS=( t3o-deploy t3o-latest t3o-testing2)
for internalEnvironment in ${INTERNALENVIRONMENTS[@]}
do
	if [ "${ENVIRONMENT}" = "${internalEnvironment}" ] ; then
		echo "Remove system_installed.txt to avoid race conditions"
		rm -f ${TARGETPATH}/system_installed.txt

		echo "Killing scheduler for ${CONCRETE_ENVIRONMENT}"
		/usr/local/bin/deployment_t3org_${ENVIRONMENT}_kill_scheduler
		echo "done"
	fi
done