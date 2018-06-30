<?php
//add elastos_topic

$options = getopt("p:");

if($options['p']=='')
{
    print_usage();
    exit(1);
}

function print_usage() {
    echo "-p [mysql password]\n";
}

function addRecord($conn, $sql)
{
    if ($conn->query($sql) === TRUE) {
        // echo "新记录插入成功\r\n";
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
}

function getAllOptionByTopicID($conn, $topic_id)
{
    $optionIDs = array();
    $result = mysqli_query($conn, "SELECT option_id FROM elastos_topic_option where topic_id=".$topic_id);
    while($row = mysqli_fetch_array($result))
    {
        $optionIDs[] = $row['option_id'];
    }

    return $optionIDs;
}

function getAllTopic($conn)
{
    $topicIDs = array();
    $result = mysqli_query($conn, "SELECT topic_id FROM elastos_topic where is_official=1");
    while($row = mysqli_fetch_array($result))
    {
        $optionIDs = getAllOptionByTopicID($conn, $row['topic_id']);
        $topicIDs[$row['topic_id']] = $optionIDs;
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

function isVote($conn, $user_id, $topic_id)
{
    $result = mysqli_query($conn, "SELECT vote_id FROM elastos_vote where user_id=".$user_id." and topic_id=".$topic_id);
    while($row = mysqli_fetch_array($result))
    {
        return true;
    }

    return false;
}

function voteTopicByOption($conn, $user_id, $topicid, $optionid, $votetime)
{
    if (true == isVote($conn, $user_id, $topicid)) {
        echo "user:".$user_id." has vote"."\r\n";
        return;
    }

    echo "user_id:".$user_id." topic_id:".$topicid." optionid:".$optionid."\r\n";

    // echo "UPDATE elastos_topic_option set vote_num =vote_num+1 where option_id =".$optionid."\r\n";
    $updateOptionSql = "UPDATE elastos_topic_option set vote_num =vote_num+1 where option_id =".$optionid;
    addRecord($conn, $updateOptionSql);

    // echo "UPDATE elastos_topic set total_vote_num =total_vote_num+1 where topic_id =".$topicid."\r\n";
    $updateTopicSql = "UPDATE elastos_topic set total_vote_num =total_vote_num+1 where topic_id =".$topicid;
    addRecord($conn, $updateTopicSql);


    // echo "INSERT INTO elastos_vote (user_id, topic_id, option_id, vote_time）VALUES (".$user_id.",".$topicid.",".$optionid.",".$votetime.")"."\r\n";
    $updateVoteSql = "INSERT INTO elastos_vote (user_id, topic_id, option_id, vote_time) VALUES (".$user_id.",".$topicid.",".$optionid.",".time().")";
    addRecord($conn, $updateVoteSql);

}

//开始时间计算
$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];


$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = $options['p'];         // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}
// 设置编码，防止中文乱码
mysqli_query($conn , "set names utf8");

mysqli_select_db( $conn, 'vote' );

$addCount = 0;


$alltopic = getAllTopic($conn);
print_r($alltopic);

$allMembers=getAllTestMemberId($conn);
print_r($allMembers);

// $conn->query('BEGIN');

foreach ($allMembers as $key => $userid)
{
    $voteTime = time();
    foreach ($alltopic as $topicid => $optionIDs)
    {
        $votetime += 10;
        $voteOptionID=array_rand($optionIDs,1);
        voteTopicByOption($conn, $userid, $topicid, $optionIDs[$voteOptionID], $voteTime);

        $addCount++;
    }
};

// $conn->query('COMMIT');

echo "addCount:".$addCount."\r\n";

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

mysqli_close($conn);

?>
