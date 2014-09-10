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
if [ "${ENVIRONMENT}" = "production" ] ; then
	# production system - do nothing
	echo "No need to modify robots.txt on production"

else
	echo -n "Dissalow crawlers from indexing this system..."
	echo -e "User-agent: *\nDisallow: /\n" > ${SOURCE_DIR}/htdocs/robots.txt
	echo " done"
fi