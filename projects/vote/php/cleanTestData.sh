#!/bin/sh

print_usage ()
{
	echo "cleanTestData -p [mysql password]";
	echo "\r\n";
}

mysqlPassword="";
hasPassword=false;

while getopts ':p' OPT
do
	case $OPT in
		p)
			hasPassword=true;
			echo "arg" $OPTARG;
			mysqlPassword=$OPTARG;;
		?)
			print_usage;
			exit;
		;;
	esac
done




if [ "$hasPassword" = false ]; then
    print_usage;
    exit 1;
fi


START_TIME=`date +%s`

echo $mysqlPassword "\r\n";

php cleanTestData.php -p $mysqlPassword

# add topic

ELAPSED_TIME=$(( `date +%s`-$START_TIME ))
HOURS=`echo $ELAPSED_TIME/3600 | bc`
MINUTES=`echo $ELAPSED_TIME/60%60 | bc`
SECONDS=`echo $ELAPSED_TIME%60 | bc`
date
echo "GetUserVoteResult finished, elapsed time: $HOURS Hours, $MINUTES Minutes, $SECONDS Seconds."