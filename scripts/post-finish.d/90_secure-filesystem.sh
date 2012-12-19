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
INTERNALENVIRONMENTS=( deploy latest training sandbox t3o-testing2)
for internalEnvironment in ${INTERNALENVIRONMENTS[@]}
do
	if [ "${ENVIRONMENT}" = "${internalEnvironment}" ] ; then
		echo "Fix permission for internal environment ${internalEnvironment} using script"
		permissionsFixed=1
		/usr/local/bin/deployment_t3org_${CONCRETE_ENVIRONMENT}_prepare_filesystem
	fi
done



if [ "${ENVIRONMENT}" = "production" ] ; then
	#echo -n "Fix group to www-data... `date` "
	#find ${SOURCE_DIR}/htdocs -exec chgrp typo3org {} \;
	#echo "done"
	#echo -n "Fix directory permissions... `date` "
	#find ${SOURCE_DIR}/htdocs -type d -exec chmod 02775  {} \;
	#echo "done"
	#echo -n "Fix file permissions... `date` "
	#find ${SOURCE_DIR}/htdocs -type f -exec chmod 0664 {} \;
	#echo "done"
fi

echo "Finish `date`"
