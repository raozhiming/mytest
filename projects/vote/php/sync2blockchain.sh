#!/bin/sh


START_TIME=`date +%s`

loopCount=0

output=1
while [ true ]; do
	php /data/www/vote/public/index.php /api/topic/genTopic
	php /data/www/vote/public/index.php /api/topic/addTopicOpt
	php /data/www/vote/public/index.php /api/topic/submitTopicResult

	output=$(php getUnSyncRecords.php)
	echo $output"\r\n"

	loopCount=$(($loopCount+1))
	echo "loopCount:"$loopCount"   wait for 20s\r\n"
    date
	sleep 20
done
# add topic

ELAPSED_TIME=$(( `date +%s`-$START_TIME ))
HOURS=`echo $ELAPSED_TIME/3600 | bc`
MINUTES=`echo $ELAPSED_TIME/60%60 | bc`
SECONDS=`echo $ELAPSED_TIME%60 | bc`
date
echo "GetUserVoteResult finished, elapsed time: $HOURS Hours, $MINUTES Minutes, $SECONDS Seconds."