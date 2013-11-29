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

list=$(cat << "EOF"
http://typo3.org/
http://typo3.org/home/
http://typo3.org/about/
http://typo3.org/documentation/
http://typo3.org/extensions/repository/
http://typo3.org/community/
EOF
)

if [ "${ENVIRONMENT}" = "production" ] ; then
	for url in $list ; do
		wget --quiet --spider  $url;
	done
fi
