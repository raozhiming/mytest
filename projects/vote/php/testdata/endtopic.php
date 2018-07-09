<?php
//add elastos_topic

require("./Model.php");

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
        echo "新记录插入成功\r\n";
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
}

function getAllTopic($conn)
{
    $topicIDs = array();
    $result = mysqli_query($conn, "SELECT topic_id FROM elastos_topic where is_official=1");
    while($row = mysqli_fetch_array($result))
    {
        $topicIDs[] = $row['topic_id'];
    }

    return $topicIDs;
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


$alltopic = getAllTopic($conn);
print_r($alltopic);


foreach ($alltopic as $key => $topicid)
{
    $updateTopicSql = "UPDATE elastos_topic set status = 3 where topic_id=".$topicid;
    addRecord($conn, $updateTopicSql);
    $addCount++;
};

echo "addCount:".$addCount."\r\n";

print_r($allCountryIDs);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

// mysqli_close($conn);

?>
