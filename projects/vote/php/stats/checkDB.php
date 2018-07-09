<?php

require_once("./Model.php");
require_once("./Model-api.php");

//开始时间计算
$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}

$modelApi = new ModelApi();
$connApi = $modelApi->get_dbConnect();
if(! $connApi )
{
    die('连接失败: ' . mysqli_error($connApi));
}


$sqlModel = "select username from elastos_members";
$resultArray = array();
printf("query %s\n", $sqlModel);
if ($result = mysqli_query($conn, $sqlModel)) {
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $resultArray[] = $row['username'];
    }
    mysqli_free_result($result);
}
else {
    echo "Error: " . $conn->error."\r\n";
}

$name = array_values($resultArray);
// print_r($name);

$sqlModelApi = "select regName from api_vote_reginfo";
$resultApiArray = array();
printf("query %s\n", $sqlModelApi);
if ($result = mysqli_query($connApi, $sqlModelApi)) {
    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $resultApiArray[] = $row['regName'];
    }
    mysqli_free_result($result);
}
else {
    echo "Error: " . $connApi->error."\r\n";
}

$nameApi = array_values($resultApiArray);
// print_r($nameApi);
printf("len:%d\n", count($name));
printf("len 2:%d\n", count($nameApi));
$diff = array_diff($nameApi, $name);
print_r($diff);

$se1 = explode(' ',microtime());
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime;
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . "\r\n";

?>
