<?php
//add elastos_topic

require("./Model.php");

$options = getopt("p:c:");

if(($options['p']=='') || ($options['c'] ==''))
{
    print_usage();
    exit(1);
}

function print_usage() {
    echo "-p [mysql password]\n";
    echo "-c [topic count]\n";
}


function getTopicInfo($title, $desc,$starttime, $user_id)
{
    $create_time = time();
    $start_time = strtotime($starttime) - 480*60;//json is +8 Zone
    $end_time = $start_time - 30*60;
    $start_date = strtotime(date("Y-m-d",$start_time)) + 480*60;//?
    $start_gmt_time = $start_time - 480*60;
    echo "start_date:".$start_date."\r\n";
    $info = "('" . $title . "',"
        // .$desc ."',"
        .$start_time . ","
        .$start_date . ","
        .$end_time . ","
        .$user_id . ","//user_id
        ."0,1,"
        .$create_time . ","
        ."1,0,0,1,"
        .$start_gmt_time
        .") ";
    // echo "getTopicInfo:".$info."\r\n";
    return $info;
}

function getOptionInfo($topicId, $content, $countryId)
{
    $create_time = time();

    $info = "(" . $topicId . ",'"
        .$content ."',0,0,"
        .$create_time . ","
        .$create_time . ",0,"
        .$countryId
        . ") ";
    echo "getOptionInfo:".$info."\r\n";
    return $info;
}

function isUserExist($conn, $userName)
{
    $result = getIdentCodeByUsername($conn, $userName);
    if (count($result) > 0) return true;
    return false;
}

function addRecord($conn, $sql)
{
    if ($conn->query($sql) === TRUE) {
        echo "新记录插入成功\r\n";
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
}

function addParentFateNum($conn, $user_id)
{
    $sql = "update elastos_members set fate_num = fate_num+1 where user_id='".$user_id."'";
    if ($conn->query($sql) == false) {
        echo "addParentFateNum Error: " . $sql . "<br>" . $conn->error."\r\n";
    }
}

function getOfficialId($conn)
{
    $result = mysqli_query($conn, "SELECT user_id FROM elastos_members where is_official=1");
    while($row = mysqli_fetch_array($result))
    {
        return $row['user_id'];
    }

    return 0;
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

function getAllTopicId($conn)
{
    $topicIDs = array();
    $result = mysqli_query($conn, "SELECT topic_id FROM elastos_topic where is_official=1 and answer_status=0");
    while($row = mysqli_fetch_array($result))
    {
        $topicIDs[] = $row['topic_id'];
    }

    return $topicIDs;
}

function setOption($conn, $option_id, $is_selected)
{
    $isanswer = 2;
    if ($is_selected == true) {
        $isanswer = 1;
    }
    $update_time = time();
    echo "update elastos_topic_option set is_answer=".$isanswer." updatea_time=".$update_time.", where option_id=".$option_id."\r\n";
    mysqli_query($conn, "update elastos_topic_option set is_answer=".$isanswer.", update_time=".$update_time." where option_id=".$option_id);
}

function setTopicAnswer($conn, $topic_id, $optionId)
{
    echo "update elastos_topic set status=2, answer_status=1, answer='".$optionId."', where topic_id=".$topic_id."\r\n";
    mysqli_query($conn, "update elastos_topic set status=2, answer_status=1, answer='".$optionId."' where topic_id=".$topic_id);
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
// 设置编码，防止中文乱码
mysqli_query($conn , "set names utf8");

mysqli_select_db( $conn, 'vote' );

$addCount = 0;


$officialId = getOfficialId($conn);
echo "officialId:".$officialId;

$allOfficalTopic = getAllTopicId($conn);
print_r($allOfficalTopic);


foreach ($allOfficalTopic as $key => $topicid)
{
    $optionIDs = getAllOptionByTopicID($conn, $topicid);
    // print_r($optionIDs);

    $temp=array_rand($optionIDs,1);
    echo "option:".$temp."  ".$optionIDs[$temp]."\r\n";

    setTopicAnswer($conn, $topicid, $optionIDs[$temp]);

    foreach ($optionIDs as $key => $optionid) {
        $isanswer=false;
        if ($key == $temp) {
            $isanswer=true;
        }
        setOption($conn, $optionid, $isanswer);
    }

    $addCount++;
    if ($addCount >= $options['c']) break;
};

echo "addCount:".$addCount."\r\n";

// print_r($allCountryIDs);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

// mysqli_close($conn);

?>
