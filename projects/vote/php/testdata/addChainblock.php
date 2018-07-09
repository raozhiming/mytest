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

$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}

$addUserRegsql = "insert into elastos_chainblock (source, type, sync) select user_id, 'userReg', 0 from elastos_members m where m.username like '%test%'";
$addTopicsql = "insert into elastos_chainblock (source, type, sync) select topic_id, 'genTopic', 0 from elastos_topic where is_official=1";
$addTopicOptionssql = "insert into elastos_chainblock (source, type, sync) select topic_id, 'addTopicOpt', 0 from elastos_topic_option o where o.topic_id = (select topic_id from elastos_topic t where t.topic_id = o.topic_id)";
$addVotesql = "insert into elastos_chainblock (source, type, sync) select option_id, 'vote', 0 from elastos_vote v where v.topic_id = (select topic_id from elastos_topic t where t.topic_id = v.topic_id and t.is_official=1);";
$submitResult = "insert into elastos_chainblock (source, type, sync) select topic_id, 'submitTopicResult', 0 from elastos_topic where answer_status=1";

addRecord($conn, $addUserRegsql);
addRecord($conn, $addTopicsql);
addRecord($conn, $addTopicOptionssql);
addRecord($conn, $addVotesql);
addRecord($conn, $submitResult);

$se1 = explode(' ',microtime());
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime;
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

?>
