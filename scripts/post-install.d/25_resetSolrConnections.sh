#!/bin/bash -e

# Get absolute path to main directory
ABSPATH=$(cd "${0%/*}" 2>/dev/null; cd ../..; echo "${PWD}/${0##*/}")
SOURCE_DIR=`dirname "${ABSPATH}"`

#######################################################################

echo "update SOLR connections"
time /usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" solr updateConnections

exit 0;