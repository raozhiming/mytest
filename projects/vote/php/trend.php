<?php

require_once("./Model.php");
require_once("./BlockChainModel.php");
require_once("./MembersModel.php");
require_once("./VoteModel.php");
require_once("./Utils.php");

//开始时间计算
$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}

$memberModel = new MemberModel($conn);
$userArray = $memberModel->getVoteTrendByVoteCount();
$column = array("TopicCount", "users");
Utils::writeArray2csv("User_Vote_Trend.csv", $column, 1000000, $userArray);
print_r($userArray);
$count = $memberModel->getUserCountNoVote();
printf("Count:%d\r\n", $count);

$userArray = $memberModel->getCountByCreateTime(2);
// print_r($userArray);
$column = array("hour", "register user", "total");
Utils::writeArray2csv("Create_Trend.csv", $column, 1000000, $userArray);

$userArray = $memberModel->getUserByCountry();
$column = array("country", "register user", "fate_num", "CountryName");
Utils::writeArray2csv("Country_Trend.csv", $column, 10000000, $userArray);

$calCol = array("country", "count", "fate_num");
$newuserArray = Utils::calTop($userArray, 30, $calCol);
Utils::writeArray2csv("Country_Top30.csv", $column, 10000000, $newuserArray);

$userArray = $memberModel->getUserByFate_num(20);
$column = array("user_id", "username", "zone", "country", "fate_num");
Utils::writeArray2csv("Fate_Num_Top.csv", $column, 1000000, $userArray);
printf("index | %20s | %8s | %8s | %8s |\r\n", "userName", "Zone", "Country_Top30", "fate_num");
$index=0;
foreach ($userArray as $key => $value)
{
    $index++;
    printf("%5d | %20s | %8d | %8s| %8d |\r\n", $index, $value['username'], $value['zone'], $value['country'], $value['fate_num']);
}

$userCount = $memberModel->getCount();
printf("<<<------------------------------------------------------------------>>>\r\n");
printf("Total User:%d\r\n", $userCount);

$walletCount = $memberModel->getWalletCount();
printf("user has wallet:%d\r\n", $walletCount);
printf("<<<------------------------------------------------------------------>>>\r\n");


$voteModel = new VoteModel($conn);
$voteArray = $voteModel->getCountByCreateTime(2);
$column = array("Time", "vote", "total");
Utils::writeArray2csv("Vote_Trend.csv", $column, 1000000, $voteArray);

$voteArray = $voteModel->getOfficialTopic();
$column = array("ID", "Title", "total");
Utils::writeArray2csv("Topic_Vote.csv", $column, 1000000, $voteArray);

$voteArray = $voteModel->getTopTopic(20);
printf("<<<------------------------------------------------------------------>>>\r\n");
printf("%30s | %8s\r\n", "title", "count");
printf("<<<------------------------------------------------------------------>>>\r\n");
foreach ($voteArray as $key => $value)
{
    printf("%30s | %8d\r\n", $value['title'], $value['total_vote_num']);
}

$voteArray = $voteModel->getTopOption(20);
printf("<<<------------------------------------------------------------------>>>\r\n");
printf("%30s | %15s | %8s\r\n", "title", "option", "count");
printf("<<<------------------------------------------------------------------>>>\r\n");
foreach ($voteArray as $key => $value)
{
    printf("%30s | %15s | %8d\r\n", $value['title'], $value['content'], $value['vote_num']);
}

$blockModel = new BlockChainModel($conn);
$blockArray = $blockModel->getCount();
printf("<<<------------------------------------------------------------------>>>\r\n");
printf("%20s | %8s\r\n", "type", "count");
printf("<<<------------------------------------------------------------------>>>\r\n");
foreach ($blockArray as $key => $value)
{
    printf("%20s | %8d\r\n", $value['type'], $value['count']);
}
$unSyncCount = $blockModel->getUnsyncCountByType();
printf("unsyncCount :%d\r\n", $unSyncCount);

$unsyncNotVote = $blockModel->getUnsyncCountNotVote();
printf("unsyncCount(not vote) :%d\r\n", $unsyncNotVote);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . "\r\n";

?>
