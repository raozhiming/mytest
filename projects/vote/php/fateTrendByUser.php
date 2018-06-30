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

// $dateStr = date("Y/m/d H:00", time());
// printf("dateStr = %s\r\n", $dateStr);

$memberModel = new MemberModel($conn);

// $voteCountArray = $memberModel->getVoteCountByReferee(41018);
// print_r($voteCountArray);
// exit;

$userArray = $memberModel->getUserByFate_num(20);
// $column = array("user_id", "username", "zone", "fate_num");
// Utils::writeArray2csv("Fate_Num_Top.csv", $column, 1000000, $userArray);
printf("index | %20s | %8s | %8s |\r\n", "userName", "Zone", "fate_num");
$index=0;
$column = array("Time");
$voteCountColumn = array("VoteCount");
$fateTrend = array();
$voteCountTrend = array();
$maxVoteCount=70;
foreach ($userArray as $key => $value)
{
    $index++;
    printf("%5d | %20s | %8d | %8d |\r\n", $index, $value['username'], $value['zone'], $value['fate_num']);
    $column[] = $value['username'];
    $voteCountColumn[] = $value['username'];

    $fateArray = $memberModel->getFateTrendByUser($value['username'], 6);
    // print_r($fateArray);
    foreach ($fateArray as $key => $count)
    {
        if (!array_key_exists('Date', $fateTrend[$key])) {
            $fateTrend[$key]['Date'] = $key;
        }
        $fateTrend[$key][$value['username']]=$count;
    }

    $voteCountArray = $memberModel->getVoteCountByReferee($value['user_id']);
    for ($i = 1; $i < $maxVoteCount; $i++) {
        printf("  %s [%d]: %d\r\n", $value['username'], $i, $voteCountArray[$i]);
        if (!array_key_exists('voteCount', $voteCountTrend[$i])) {
            $voteCountTrend[$i]['voteCount'] = $i;
        }
        if (array_key_exists($i, $voteCountArray)) {
            $voteCountTrend[$i][$value['username']]=$voteCountArray[$i];
            echo "---------\r\n";
            print_r($voteCountTrend[$i]);
        }
        else {
            $voteCountTrend[$i][$value['username']]=0;
            echo "+++++++++\r\n";
            print_r($voteCountTrend[$i]);
        }
    }

    $voteCountTrend['参与投票人数']['voteCount'] = 'Total';
    $voteCountTrend['参与投票人数'][$value['username']] = $voteCountArray['total'];

    $voteCountTrend['邀请数']['voteCount'] = 'Fate_Num';
    $voteCountTrend['邀请数'][$value['username']] = $value['fate_num'];
}

// print_r($voteCountTrend);

Utils::writeArray2csv("FateTrendTop.csv", $column, 1000000, $fateTrend);
Utils::writeArray2csv("voteCountTrendByReferee.csv", $voteCountColumn, 1000000, $voteCountTrend);


$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . "\r\n";

?>
