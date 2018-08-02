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

$deleteTable = array("elastos_api_logs", "elastos_daily_top", "elastos_height_blocks","elastos_joy_item", "elastos_lottery_details", "elastos_member_charge", "elastos_members", "elastos_members_joy", "elastos_member_team", "elastos_msg", "elastos_node", "elastos_operator_logs", "elastos_register_details", "elastos_team_switch_log", "elastos_transfer", "elastos_txblock", "tx_info");
// $deleteTable = array("elastos_api_logs",  "tx_info");
foreach ($deleteTable as $key => $value) {
    $sql = "DELETE FROM " . $value;
    if ($conn->query($sql) === TRUE) {
        echo $sql."  执行成功\r\n";
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
}



$se1 = explode(' ',microtime());
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime;
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

?>
