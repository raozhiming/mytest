<?php
//add elastos_topic

require("./Model.php");

$options = getopt("o:");

if($options['o']=='')
{
    print_usage();
    exit(1);
}

function print_usage() {
    echo "-o [1:is_official]\n";
}

function addRecord($conn, $sql)
{
    if ($conn->query($sql) === TRUE) {
        // echo "新记录插入成功\r\n";
        return true;
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
        return false;
    }
}

function getAllOptionByTopicID($conn, $topic_id)
{
    $optionIDs = array();
    $result = mysqli_query($conn, "SELECT option_id, vote_num FROM elastos_topic_option where topic_id=".$topic_id);
    while($row = mysqli_fetch_array($result))
    {
        $optionIDs[$row['option_id']] = $row['vote_num'];
    }
    // print_r($optionIDs);
    return $optionIDs;
}

function getAllTopic($conn, $is_official)
{
    $topicIDs = array();
    $result = mysqli_query($conn, "SELECT topic_id, total_vote_num FROM elastos_topic where is_official=".$is_official);
    while($row = mysqli_fetch_array($result))
    {
        $optionIDs = getAllOptionByTopicID($conn, $row['topic_id']);

        $topicInfo = array('total_vote_num' => $row['total_vote_num'], 'options' => $optionIDs);
        $topicIDs[$row['topic_id']] = $topicInfo;
    }

    return $topicIDs;
}

function getAllTestMemberId($conn)
{
    $memberIDs = array();
    $result = mysqli_query($conn, "SELECT user_id FROM elastos_members where username like '%test%'");
    while($row = mysqli_fetch_array($result))
    {
        $memberIDs[] = $row['user_id'];
    }

    return $memberIDs;
}

function getAllVote($conn)
{
    $voteIDs = array();
    $result = mysqli_query($conn, "SELECT vote_id, user_id, topic_id FROM elastos_vote");
    while($row = mysqli_fetch_array($result))
    {
        $voteIDs[] = $row;
    }

    return $voteIDs;
}

function updateTopicAndOption($conn, $topicArray)
{
    foreach ($topicArray as $topicid => $topicinfo)
    {

        foreach ($topicinfo['options'] as $optionid => $vote_num)
        {
            $updateOptionSql = "UPDATE elastos_topic_option set vote_num =".$vote_num." where option_id =".$optionid;
            addRecord($conn, $updateOptionSql);
        }

        $updateTopicSql = "UPDATE elastos_topic set total_vote_num =".$topicinfo['total_vote_num']." where topic_id =".$topicid;
        addRecord($conn, $updateTopicSql);
    }
}

function isVote($voteIDs, $user_id, $topic_id)
{
    foreach ($voteIDs as $key => $voteArray)
    {
        if (($voteArray['user_id'] == $user_id) and ($voteArray['topic_id'] == $topic_id)) {
            // print_r($voteArray);
            // echo "\r\n";
            return true;
        }
    }

    return false;
}

//开始时间计算
$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];


$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = $options['p'];         // mysql用户名密码
// $conn = mysqli_connect($dbhost, $dbuser, $dbpass);
$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}

$addCount = 0;
$needAdd = 0;
$voteMembers=0;

$alltopic = getAllTopic($conn, $options['o']);
// print_r($alltopic);
// exit();

$allMembers=getAllTestMemberId($conn);
// print_r($allMembers);

// $allVote = getAllVote($conn);
// print_r($allVote);

// $conn->query('BEGIN');

$sql = "INSERT INTO elastos_vote (user_id, topic_id, option_id, vote_time, vote_gmt_time) VALUES ";

foreach ($allMembers as $key => $userid)
{
    echo "userid:".$userid."\r\n";
    $voteTime = time();
    $voteMembers++;
    $voteTopics=0;
    foreach ($alltopic as $topicid => $topicinfo)
    {
        // if($voteMembers <= 15000) continue;

        $voteTime += 10;
        $voteOptionID=array_rand($topicinfo['options'],1);

        // if (true == isVote($allVote, $userid, $topicid)) {
        //     echo "user:".$userid." has vote"." ".$topicid."\r\n";
        //     continue;
        // }


        $alltopic[$topicid]['total_vote_num']++;
        $alltopic[$topicid]['options'][$voteOptionID]++;

        // print_r($topicinfo['options']);
        // echo "voteOptionID:".$voteOptionID."\r\n";
        // echo "optionid:".$topicinfo['options'][$voteOptionID]."\r\n";
        // echo "topicid:".$topicid." optionid:".$voteOptionID." \r\n";
        $sql .= "(".$userid.",".$topicid.",".$voteOptionID.",".$voteTime.",".$voteTime."),";

        $addCount++;
        $needAdd++;

        if (($addCount % 1000) == 0) {
            $sql = substr($sql, 0, strlen($sql) - 1);
            if (false == addRecord($conn, $sql)) break;

            $needAdd = 0;
            $sql = "INSERT INTO elastos_vote (user_id, topic_id, option_id, vote_time, vote_gmt_time) VALUES ";
        }

        $voteTopics++;
        if ($voteMembers < 64) {
            if ($voteTopics >= $voteMembers) break;
        }
    }
};

if ($needAdd > 0) {
    $sql = substr($sql, 0, strlen($sql) - 1);
    addRecord($conn, $sql);
}

if ($addCount > 0) {
    updateTopicAndOption($conn, $alltopic);
}
// $conn->query('COMMIT');


echo "addCount:".$addCount."\r\n";
// print_r($alltopic);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

// mysqli_close($conn);

?>
