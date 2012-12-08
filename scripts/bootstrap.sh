#!/bin/bash -e

# Get absolute path to main directory
ABSPATH=$(cd "${0%/*}" 2>/dev/null; echo "${PWD}/${0##*/}")
SOURCE_DIR=`dirname "${ABSPATH}"`

#######################################################################

echo "Running post-install scripts... "
for SCRIPT in "${SOURCE_DIR}/post-install.d"/*.sh; do
    if [ -x "${SCRIPT}" ]; then
        echo -n " - `basename ${SCRIPT}`... "
        "${SCRIPT}"
        echo "done"
    fi
done
