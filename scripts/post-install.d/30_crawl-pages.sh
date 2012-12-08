#!/bin/bash -e

# Get absolute path to main directory
ABSPATH=$(cd "${0%/*}" 2>/dev/null; cd ../..; echo "${PWD}/${0##*/}")
SOURCE_DIR=`dirname "${ABSPATH}"`

#######################################################################

exit 0;

echo -n "Queuing page crawling... `date`"
/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" crawler_im 2 -d=3 -o=queue -conf=re-cache-all-pages  > /dev/null
/usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" crawler_im 17 -d=3 -o=queue -conf=re-cache-unconfigured-host > /dev/null
echo "done"

echo "Crawling pages..."

for i in {1..6}
do
   echo "#########################################################"
   echo "# Starting crawler \"${i}\" at `date`"
   echo "#########################################################"
   time /usr/bin/php5 -q "${SOURCE_DIR}/htdocs/typo3/cli_dispatch.phpsh" crawler_multiprocess 4000
   echo "############################"
done
echo "done"
