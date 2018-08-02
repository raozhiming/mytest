<?php

require("./Model.php");

$options = getopt("c:h");

if($options['c']=='')
{
    print_usage();
    exit(1);
}

$totalCount = (int)$options['c'];

function print_usage() {
    echo "-c [total count]\n";
}

function getJoyItemInfo($user_id, $team_id, $job_id, $usertime, $score, $blockhash, $now)
{
    $plaintext = "" . $user_id . $usertime . $score . "adcdef";
    $info = "(" . $user_id . ", " . $team_id . "," . $job_id . "," . $usertime . "," .
            $score . "," . $now . "," . $now . ",".$now. ",'" .
            $plaintext . "', '" . $blockhash . "', 0, 'test26339745f1db0780572a38958ae01f1aa3aa2bab44bf7a758df1fc79d329'," . $now . ") ";
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
    if ($conn->query($sql) === FALSE) {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
}

function getLasttxblock($conn)
{
    $blockInfo = array();
    $result = mysqli_query($conn, "SELECT height, blockhash FROM elastos_txblock order by timestamp desc limit 1");
    if (!$result) {
        die('连接失败: ' . mysqli_error($conn));
    }
    while($row = mysqli_fetch_array($result))
    {
        $blockInfo[$row['height']] = $row['blockhash'];
        return $row['blockhash'];
    }

    return "";
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

$lasttxblockInfo = getLasttxblock($conn);
print_r($lasttxblockInfo);

$sql = "INSERT INTO elastos_joy_item (user_id,team_id,joy_id,use_time,score,start_time,end_time,create_time,plaintext,blockhash,status,txId,update_time) VALUES ";

$addCount = 0;
$needAdd=0;

$now = time();
$score = 0;
for ($i=1; $i<=$totalCount; $i++)
{
    $addCount++;
    $needAdd++;

    $score++;

    $timestamp = $now + 10 * $i;
    $sql .= getJoyItemInfo(5, 3, 3, 10, $score, $lasttxblockInfo, $timestamp).',';
    // echo $sql . "\n\n";
    if (($addCount % 5000) == 0) {
        $sql = substr($sql, 0, strlen($sql) - 1);
        addRecord($conn, $sql);

        $needAdd=0;
        $sql = "INSERT INTO elastos_joy_item (user_id,team_id,joy_id,use_time,score,start_time,end_time,create_time,plaintext,blockhash,status,txId,update_time) VALUES ";
    }
};

if ($needAdd) {
    $sql = substr($sql, 0, strlen($sql) - 1);
    addRecord($conn, $sql);
}

echo "addCount:".$addCount."\r\n";

$se1 = explode(' ',microtime());
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime;
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

?>
