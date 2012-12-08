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
permissionsFixed=0
INTERNALENVIRONMENTS=( deploy latest training sandbox testing2)
for internalEnvironment in ${INTERNALENVIRONMENTS[@]}
do
	if [ "${ENVIRONMENT}" = "${internalEnvironment}" ] ; then
		echo "Prepare permission for internal environment ${internalEnvironment} using script"
		permissionsFixed=1
	 	/usr/local/bin/deployment_t3org_t3o-${CONCRETE_ENVIRONMENT}_prepare_filesystem
	fi
done


if [ "${ENVIRONMENT}" = "production" ] ; then
#######################################################################
	echo -n "Fix group to webmaster (preview system)... "
	time chgrp -R typo3org ${SOURCE_DIR}/htdocs >/dev/null || true;
	echo "done"

	echo -n "Fix permissions... "
	time chmod -R u+w,g=u,o=u-w ${SOURCE_DIR}/htdocs >/dev/null || true;
	echo -n "Add sticky bit... "
	time find ${SOURCE_DIR}/htdocs -type d -exec chmod g+s {} \; 2>/dev/null
fi
