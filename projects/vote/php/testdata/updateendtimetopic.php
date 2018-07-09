<?php
//add elastos_topic

require("./Model.php");

// $options = getopt("p:");

// if($options['p']=='')
// {
//     print_usage();
//     exit(1);
// }

// function print_usage() {
//     echo "-p [mysql password]\n";
// }

function addRecord($conn, $sql)
{
    if ($conn->query($sql) === TRUE) {
        echo "新记录插入成功\r\n";
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
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

$end = time() - 480*60;
$updateTopicSql = "UPDATE elastos_topic set end_time =".$end.", end_gmt_time =".$end."  where is_official=1 and answer_status=1";
addRecord($conn, $updateTopicSql);


$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

// mysqli_close($conn);

?>
