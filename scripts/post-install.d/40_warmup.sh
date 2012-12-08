#!/bin/bash -e

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

if [ `id -u -n` = 'typo3org' ]; then
	for url in $list ; do
		wget --quiet --spider  $url;
	done
fi
