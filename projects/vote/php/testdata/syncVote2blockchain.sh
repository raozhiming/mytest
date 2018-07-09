#!/bin/sh


START_TIME=`date +%s`

loopCount=0
date
output=1
while [ true ]; do
	php /data/www/vote/public/index.php /api/vote/vote

	output=$(php getUnSyncVotes.php)
	echo $output"\r\n"

	loopCount=$(($loopCount+1))
	echo "loopCount:"$loopCount"\r\n"
	date
done
# add topic

ELAPSED_TIME=$(( `date +%s`-$START_TIME ))
HOURS=`echo $ELAPSED_TIME/3600 | bc`
MINUTES=`echo $ELAPSED_TIME/60%60 | bc`
SECONDS=`echo $ELAPSED_TIME%60 | bc`
date
echo "GetUserVoteResult finished, elapsed time: $HOURS Hours, $MINUTES Minutes, $SECONDS Seconds."