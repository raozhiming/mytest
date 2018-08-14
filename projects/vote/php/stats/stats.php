<?php

require_once("./Model.php");
require_once("./BlockChainModel.php");
require_once("./MembersModel.php");
require_once("./VoteModel.php");
require_once("./Utils.php");

$HEAD="<<<------------------------------------------------------------------>>>\n";
$TAIL="<<<------------------------------------------------------------------>>>\n\n";

$se = explode(' ',microtime());
$ntime = $se[0] + $se[1];

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn ) {
    die('连接失败: ' . mysqli_error($conn));
}

$memberModel = new MemberModel($conn);
$userArray = $memberModel->getUserTrendByVoteCount();
$column = array("TopicCount", "users");
Utils::writeArray2csv("User_VoteCount_Stats.csv", $column, 1000000, $userArray);

$userArray = $memberModel->getCountByCreateTime(24);
$column = array("hour", "register user", "total");
Utils::writeArray2csv("User_Create_Trend.csv", $column, 1000000, $userArray);

$userArray = $memberModel->getUserByCountry();
$column = array("country", "register user", "fate_num", "CountryName");
Utils::writeArray2csv("User_Trend_ByCountry.csv", $column, 10000000, $userArray);

$calCol = array("country", "count", "fate_num");
$newuserArray = Utils::calTop($userArray, 30, $calCol);
Utils::writeArray2csv("User_Trend_ByTopCountry.csv", $column, 10000000, $newuserArray);

$userArray = $memberModel->getUsersByFate_num(11);
$column = array("user_id", "username", "fate_num", "wallet", "zone", "country");
Utils::writeArray2csv("User_TopFate.csv", $column, 1000000, $userArray);
printf("index | %20s | %8s | %32s | %8s | %8s |\r\n", "userName", "fate_num", "wallet", "Zone", "Country");
$index=0;
foreach ($userArray as $key => $value) {
    $index++;
    printf("%5d | %20s | %8d | %32s | %8d| %8s |\r\n", $index, $value['username'], $value['fate_num'], $value['wallet_addr'], $value['zone'], $value['CountryName']);
}

$userCount = $memberModel->getUserCount();
printf($HEAD);
printf("Total User:%d\r\n", $userCount);

$walletCount = $memberModel->getUserCountHasWallet();
printf($HEAD);
printf("user has wallet:%d\r\n", $walletCount);
$noWallet = $userCount - $walletCount;
$userArray = array();
$userArray["hasWallet"] = $walletCount;
$userArray["noWallet"] = $noWallet;
print_r($userArray);
$column = array("type", "users");
Utils::writeArray2csv("User_Wallet.csv", $column, 1000000, $userArray);


$voteModel = new VoteModel($conn);
$voteArray = $voteModel->getVoteCountByCreateTime(24);
$column = array("Time", "vote", "total");
Utils::writeArray2csv("Vote_Trend.csv", $column, 1000000, $voteArray);

$voteArray = $voteModel->getOfficialTopic();
$column = array("ID", "Title", "total");
Utils::writeArray2csv("Topic_Vote.csv", $column, 1000000, $voteArray);

$voteArray = $voteModel->getTopTopic(64);
printf($HEAD);
printf("Top Topic:\n%30s | %8s\r\n", "title", "count");
foreach ($voteArray as $key => $value) {
    printf("%30s | %8d\r\n", $value['title'], $value['total_vote_num']);
}
printf($TAIL);

$voteArray = $voteModel->getTopOption(20);
printf($HEAD);
printf("Top Option:\n%30s | %15s | %8s\r\n", "title", "option", "count");
foreach ($voteArray as $key => $value) {
    printf("%30s | %15s | %8d\r\n", $value['title'], $value['content'], $value['vote_num']);
}
printf($TAIL);

$blockModel = new BlockChainModel($conn);
$blockArray = $blockModel->getTotalCount();
printf($HEAD);
$userArray = array();
printf("BlockChain Total Count:\n%20s | %8s\r\n", "type", "count");
foreach ($blockArray as $key => $value) {
    printf("%20s | %8d\r\n", $value['type'], $value['count']);
    $userArray[$value['type']] = $value['count'];
}
$column = array("type", "count");
Utils::writeArray2csv("BlockChainData.csv", $column, 1000000, $userArray);
printf($TAIL);

$unSyncArray = $blockModel->getUnSyncCount();
printf($HEAD);
printf("BlockChain UnSync Count:\n%20s | %8s\r\n", "type", "count");
foreach ($unSyncArray as $key => $value) {
    printf("%20s | %8d\r\n", $value['type'], $value['count']);
}
printf($TAIL);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime;
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . "\r\n";

?>
