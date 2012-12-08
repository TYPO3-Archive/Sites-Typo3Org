#!/bin/bash -e

# Get absolute path to main directory
ABSPATH=$(cd "${0%/*}" 2>/dev/null; cd ../..; echo "${PWD}/${0##*/}")
SOURCE_DIR=`dirname "${ABSPATH}"`

#######################################################################
if [ `id -u -n` = 'typo3org' ]; then
	echo -n "Fix group to webmaster (preview system)... "
	time chgrp -R typo3org ${SOURCE_DIR}/htdocs >/dev/null || true;
	echo "done"	
else 
	echo -n "Fix group to webmaster ... "
	time chgrp -R www-data ${SOURCE_DIR}/htdocs >/dev/null || true;
	echo "done"
fi

echo -n "Fix permissions... "
time chmod -R u+w,g=u,o=u-w ${SOURCE_DIR}/htdocs >/dev/null || true;
echo -n "Add sticky bit... "
time find ${SOURCE_DIR}/htdocs -type d -exec chmod g+s {} \; 2>/dev/null