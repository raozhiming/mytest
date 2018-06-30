<?php

// // 从文件中读取数据到PHP变量
// $json_string = file_get_contents('vote.json');

// // 把JSON字符串转成PHP数组
// $data = json_decode($json_string, true);

// // 显示出来看看
// var_dump($data);


echo strtotime("2018-6-14 23:00:00");

echo "\r\n".date_default_timezone_get()."\r\n";
$start_time = 1529085600;
echo "\r\n date:".date("Y-m-d",$start_time);

$start_date = strtotime(date("Y-m-d",$start_time )) ;//?
echo "\r\n".$start_date ."\r\n";
?>
