<?php
//add elastos_member

require("./Model.php");
$allCountries = require("./countryZone.php");


function getUserInfo($db)
{
    $sql = "select user_id, username, zone, phone, fate_num from elastos_members where fate_num>0 order by fate_num;";
    if ($result = mysqli_query($db, $sql))
    {
        echo "\r\nmembers:\r\n";
        while($row = mysqli_fetch_array($result))
        {
            echo $row['user_id'].",".$row['username'].",".$row['zone'].",".$row['phone'].",".$row['fate_num']."\r\n";
        }
        mysqli_free_result($result);
    }
}

function getUserFateNum($db)
{
    $sql = "select count(*) as 'c' from elastos_members where referee>0;";
    $result = mysqli_query($db, $sql);
    $rowCount = $result->fetch_object()->c;
    mysqli_free_result($result);
    echo "userFateNum:".$rowCount."\r\n";
    return $rowCount;
}


// function getUserCreateTrend($db)
// {
//     $sql = "select create_time from elastos_members;";
//     $result = mysqli_query($db, $sql);
//     $rowCount = $result->fetch_object()->c;
//     mysqli_free_result($result);
//     echo "userFateNum:".$rowCount."\r\n";
//     return $rowCount;
// }

function getUserByCountry($db)
{
    $countryInfo = array();
    $sql = "select zone, count(*) as count, sum(fate_num) as fate_num from elastos_members group by zone order by count desc;";
    if ($result = mysqli_query($db, $sql))
    {
        global $allCountries;

        echo "\r\nSort by Country:\r\n";
        while($row = mysqli_fetch_array($result))
        {
            printf("%22s: users: %5d, fate_nums:%8d\r\n", $allCountries[$row['zone']], $row['count'], $row['fate_num']);
            $countryInfo[$allCountries[$row['zone']]] = array($row['count'], $row['fate_num']);
        }
        printf("Total Country:%d\r\n", mysqli_num_rows($result));
        mysqli_free_result($result);
    }
    return $countryInfo;
}

function getUserWithWalletAddress($db)
{
    $sql = "select count(*) as 'c' from elastos_members where wallet_addr is not null;";
    $result = mysqli_query($db, $sql);
    $rowCount = $result->fetch_object()->c;
    mysqli_free_result($result);
    return $rowCount;
}

function getTopicInfo($db)
{
    $sql = "select topic_id, title, total_vote_num from elastos_topic order by total_vote_num desc limit 20;";
    if ($result = mysqli_query($db, $sql))
    {
        echo "\r\ntopic top 20:\r\n";
        while($row = mysqli_fetch_array($result))
        {
            echo $row['topic_id'].",".$row['title'].",".$row['total_vote_num']."\r\n";
        }
        mysqli_free_result($result);
    }
}

function getOptionInfo($db)
{
    $sql = "select o.option_id, t.title, o.content, o.vote_num from elastos_topic_option o, elastos_topic t where o.topic_id = t.topic_id order by o.vote_num desc limit 20;";
    if ($result = mysqli_query($db, $sql))
    {
        echo "\r\noption top 20:\r\n";
        while($row = mysqli_fetch_array($result))
        {
            echo $row['option_id'].",".$row['title'].",".$row['content'].",".$row['vote_num']."\r\n";
        }
        mysqli_free_result($result);
    }
}

function getUpdaeNorefee($db)
{
    $sql = "select c.id, c.source, c.sync, m.username, m.referee from elastos_chainblock c, elastos_members m where c.source = m.user_id and c.type='userReg' and m.referee>0;";
    if ($result = mysqli_query($db, $sql))
    {
        echo "\r\ngetUpdaeNorefee:\r\n";
        while($row = mysqli_fetch_array($result))
        {
            echo $row['id'].",".$row['source'].",".$row['sync'].",".$row['username'].",".$row['refee']."\r\n";
        }
        printf("Total count:%d\r\n", mysqli_num_rows($result));
        mysqli_free_result($result);
    }
}


function getCountbyTable($db, $table)
{
    $sql = "select count(*) as 'c' from {$table};";
    $result = mysqli_query($db, $sql);
    $rowCount = $result->fetch_object()->c;
    mysqli_free_result($result);
    echo "{$table} count:".$rowCount."\r\n";
    return $rowCount;
}

function getUnsyncCount($db)
{
    $sql = "select type, count(*) as 'c' from elastos_chainblock where sync=0 group by type order by c;";
    if ($result = mysqli_query($db, $sql))
    {
        echo "\r\nunsync:\r\n";
        while($row = mysqli_fetch_array($result))
        {
            echo $row['type'].",".$row['c']."\r\n";
        }
        mysqli_free_result($result);
    }
    // $result = mysqli_query($db, $sql);
    // $rowCount = $result->fetch_object()->c;
    // mysqli_free_result($result);
    // echo "userFateNum:".$rowCount."\r\n";
    return $rowCount;
}

function getSyncErrorCount($db)
{
    $sql = "select type, count(*) as 'c' from elastos_chainblock where sync=1 and result not like '%result%' group by type order by c;";
    if ($result = mysqli_query($db, $sql))
    {
        echo "\r\nsync error:\r\n";
        while($row = mysqli_fetch_array($result))
        {
            echo $row['type'].",".$row['c']."\r\n";
        }
        mysqli_free_result($result);
    }
    // $result = mysqli_query($db, $sql);
    // $rowCount = $result->fetch_object()->c;
    // mysqli_free_result($result);
    // echo "userFateNum:".$rowCount."\r\n";
    return $rowCount;
}

function writeArray2csv($filename, $column_names, $limit_count, $data)
{
    if (empty($data)) {
        printf("data error\r\n");
        print_r($data);
        return;
    }

    $fp = fopen($filename, 'w+b');
    $column = implode(",", $column_names);
    fwrite($fp, $column."\r\n");
    $multiArray = false;
    if (count($column_names) > 2) $multiArray = true;

    $cal_count = 0;
    $otherValue = 0;
    $otherArray = array();
    $hasOther = false;
    foreach ($data as $key => $value)
    {
        if ($cal_count++ < $limit_count) {
            if ($multiArray) {
                $values = array_values($value);
                // echo "values:";
                // print_r($values);
                // echo "\r\n";

                $writeString = $key.",".implode(",", $values)."\r\n";
            }
            else {
                $writeString = $key.",".$value."\r\n";
            }
            // echo $writeString;
            fwrite($fp, $writeString);
        }
        else {
            $hasOther = true;
            if ($multiArray) {
                $values = array_values($value);

                for ($i = 0; $i < sizeof($values); $i++) {
                    $otherArray[$i] += $values[$i];
                }
            }
            else {
                $otherValue += $value;
            }
        }
    }
    if ($hasOther) {
        if ($multiArray) {
            $writeString = "Other,".implode(",", $otherArray)."\r\n";
        }
        else {
            $writeString = "Other,".$value."\r\n";
        }
        fwrite($fp, $writeString);
    }
    fclose($fp);
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

getUserInfo($conn);
// echo "---------------\r\n";
// getUserFateNum($conn);
getCountbyTable($conn, "elastos_members");
getCountbyTable($conn, "elastos_topic");
getCountbyTable($conn, "elastos_vote");
// echo "---------------\r\n";
// getTopicInfo($conn);
// echo "---------------\r\n";
// getOptionInfo($conn);
$countryInfo = getUserByCountry($conn);
// $column = array("country", "count", "fate_num");
// writeArray2csv("country.csv", $column, 19, $countryInfo);
// getUpdaeNorefee($conn);
// getUnsyncCount($conn);
// getSyncErrorCount($conn);

$noWalletCount = getUserWithWalletAddress($conn);
printf("has wallet:%d\r\n", $noWalletCount);

// $allMemberInfo = getAllIdentCode($conn);
// print_r($allMemberInfo);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

?>
