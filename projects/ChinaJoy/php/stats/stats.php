<?php

require_once("./Model.php");
require_once("./MembersModel.php");
require_once("./Utils.php");

$HEAD="<<<------------------------------------------------------------------>>>\n";
$TAIL="<<<------------------------------------------------------------------>>>\n\n";

$se = explode(' ',microtime());
$ntime = $se[0] + $se[1];

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn ) {
    die('连接失败: ' . mysqli_error($conn));
}

$memberModel = new MemberModel($conn);
$userArray = $memberModel->getEcoReward();
$column = array("NickName", "Medal", "TeamName", "Address", "eco_currency");
Utils::writeArray2csv("Eco_rewards.csv", $column, 1000000, $userArray);


$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime;
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . "\r\n";

?>
