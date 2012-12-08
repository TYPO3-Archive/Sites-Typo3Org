#!/bin/bash

# Synchronize translation packages from pootle server to local TER
# Steffen Gebert, July 2012

BASE_PATH=/var/www/vhosts/typo3.org

rsync -rc --exclude ".htaccess" -e "ssh -i $BASE_PATH/home/.ssh/id_rsa-translation.typo3.org"  translat3o@translation.typo3.org:/var/www/vhosts/pootle.typo3.org/l10n_ter/ $BASE_PATH/www/fileadmin/ter/
find $BASE_PATH/www/fileadmin/ter/ -type d -print0|/usr/bin/xargs -0 /bin/chmod 775
find $BASE_PATH/www/fileadmin/ter/ -type f -print0|/usr/bin/xargs -0 /bin/chmod 664
