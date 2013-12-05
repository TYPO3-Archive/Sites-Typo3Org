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

# apply a patch to use Curl instead of file_get_contents to query the solr server
#
# Here is the whole story:
# 1. A regression has been introduced in a bugfix version of PHP5.3.
#    @see https://bugs.php.net/bug.php?id=64016
#    It breaks file_get_contents when issuing HEAD requests.
#    This regression is on the integration server but not on production (because Debian uses a different PHP version)
#    It also not considered a bug by the PHP Team, because this functionality is deprecated and is removed in PHP5.5
# 2. EXT:solr uses a library called SolrPhpClient that relies on file_get_contents to query solr
#    Interestingly it also has a class to handle those requests with curl but no way of activating it... WTF
#
# So to fix it on the integration systems, we change that library to use Curl instead of file_get_contents
# by just changing the source code...

INTERNALENVIRONMENTS=( t3o-deploy t3o-latest t3o-testing2)
for internalEnvironment in ${INTERNALENVIRONMENTS[@]}
do
	if [ "${ENVIRONMENT}" = "${internalEnvironment}" ] ; then
		echo "Applying bugfix for SOLR..."

		patch -d ${TARGETPATH}/htdocs/typo3conf/ext/ -p0 < assets/fix-solr-on-integration.patch

		echo "done"
	fi
done
