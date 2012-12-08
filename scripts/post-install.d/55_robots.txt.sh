#!/bin/bash -e

# Get absolute path to main directory
ABSPATH=$(cd "${0%/*}" 2>/dev/null; cd ../..; echo "${PWD}/${0##*/}")
SOURCE_DIR=`dirname "${ABSPATH}"`

#######################################################################
if [ `id -u -n` = 'typo3org' ]; then
	# production system - do nothing
	echo -n "Nothing to do"

else
	echo -e "User-agent: *\nDisallow: /\n" > ${SOURCE_DIR}/htdocs/robots.txt
fi