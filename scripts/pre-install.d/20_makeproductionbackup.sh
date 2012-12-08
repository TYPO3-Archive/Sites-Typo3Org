#!/bin/bash -e

echo "#######################################################################"
echo " disabled script make backup from production environment"
echo "#######################################################################"
exit 0;

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
permissionsFixed=0
INTERNALENVIRONMENTS=( deploy latest training sandbox )
for internalEnvironment in ${INTERNALENVIRONMENTS[@]}
do
	if [ "${ENVIRONMENT}" = "${internalEnvironment}" ] ; then
		echo "No create backup required for internal environments"
	fi
done

if [ "${ENVIRONMENT}" = "stage" ] ; then
	echo "Create Backup:"
	/usr/local/bin/deployment_###PROJECTNAME###_update_systemstorage
fi

if [ "${ENVIRONMENT}" = "production" ] ; then
	echo "Create Backup:"
	/usr/local/bin/deployment_###PROJECTNAME###_update_systemstorage
fi
