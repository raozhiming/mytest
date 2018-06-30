<?php

require("./Model.php");

//开始时间计算
$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}

$resetTopicSql = "UPDATE elastos_topic set total_vote_num=0, status=0, answer='', answer_status=0";
$resetOptionSql = "UPDATE elastos_topic_option set is_answer=0, vote_num =0";

$model->query($resetOptionSql);
$model->query($resetTopicSql);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

// mysqli_close($conn);

?>
