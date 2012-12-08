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

reloaded=0
INTERNALENVIRONMENTS=( deploy latest training sandbox testing2)
for internalEnvironment in ${INTERNALENVIRONMENTS[@]}
do
	if [ "${ENVIRONMENT}" = "${internalEnvironment}" ] ; then
		echo "apache_reload in environment ${internalEnvironment} using script"
		reloaded=1
	   /usr/local/bin/apache2_reload
	fi
done

if [ `id -u -n` = 'vagrant' ]; then
	reloaded=1
	sudo service apache2 reload
fi


if [ "${ENVIRONMENT}" = "production" ] ; then
	#echo "apache_reload"
	#reloaded=1
    #/usr/local/bin/apache2_reload
fi


if [ "${reloaded}" = "0" ] ; then
	echo "#####################################"
	echo "#"
	echo " You still need to Restart Apache if you have APC cache enabled"
	echo "#"
	echo "#####################################"
fi
