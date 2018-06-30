<?php
//add elastos_member
require("./Model.php");


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

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}


$deleteUsersql = "DELETE FROM elastos_members where username like '%test%'";
$deleteTopicsql = "DELETE FROM elastos_topic";
$deleteTopicOptionssql = "DELETE FROM elastos_topic_option";
$deleteVotesql = "DELETE FROM elastos_vote";
$deleteUserWins = "DELETE FROM elastos_user_wins";

addRecord($conn, $deleteUsersql);
addRecord($conn, $deleteTopicsql);
addRecord($conn, $deleteTopicOptionssql);
addRecord($conn, $deleteVotesql);
addRecord($conn, $deleteUserWins);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

// mysqli_close($conn);

?>
