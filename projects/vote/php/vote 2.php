
<?php
//add elastos_topic

$options = getopt("p:");

if($options['p']=='')
{
    print_usage();
    exit(1);
}

function print_usage() {
    echo "-p [mysql password]\n";
}


function getTopicInfo($title, $desc,$starttime, $user_id)
{
    $create_time = time();
    $start_time = strtotime($starttime) - 480*60;//json is +8 Zone
    $end_time = $start_time - 30*60;
    $start_date = strtotime(date("Y-m-d",$start_time)) + 480*60;//?
    $start_gmt_time = $start_time - 480*60;
    echo "start_date:".$start_date."\r\n";
    $info = "('" . $title . "',"
        // .$desc ."',"
        .$start_time . ","
        .$start_date . ","
        .$end_time . ","
        .$user_id . ","//user_id
        ."0,1,"
        .$create_time . ","
        ."1,0,0,1,"
        .$start_gmt_time
        .") ";
    // echo "getTopicInfo:".$info."\r\n";
    return $info;
}

function getOptionInfo($topicId, $content, $countryId)
{
    $create_time = time();

    $info = "(" . $topicId . ",'"
        .$content ."',0,0,"
        .$create_time . ","
        .$create_time . ",0,"
        .$countryId
        . ") ";
    echo "getOptionInfo:".$info."\r\n";
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
    if ($conn->query($sql) === TRUE) {
        echo "新记录插入成功\r\n";
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
}

function addParentFateNum($conn, $user_id)
{
    $sql = "update elastos_members set fate_num = fate_num+1 where user_id='".$user_id."'";
    if ($conn->query($sql) == false) {
        echo "addParentFateNum Error: " . $sql . "<br>" . $conn->error."\r\n";
    }
}

function getOfficialId($conn)
{
    $result = mysqli_query($conn, "SELECT user_id FROM elastos_members where is_official=1");
    while($row = mysqli_fetch_array($result))
    {
        return $row['user_id'];
    }

    return 0;
}

function getAllIdentCode($conn)
{
    $memberInfo = array();
    $result = mysqli_query($conn, "SELECT user_id, ident_code FROM elastos_members");
    while($row = mysqli_fetch_array($result))
    {
        $memberInfo[$row['user_id']] = $row['ident_code'];
    }

    return $memberInfo;
}

function getAllCountryId($conn)
{
    $countryIDs = array();
    $result = mysqli_query($conn, "SELECT ename,id FROM elastos_country");
    while($row = mysqli_fetch_array($result))
    {
        $countryIDs[$row['ename']] = $row['id'];
    }

    return $countryIDs;
}

//开始时间计算
$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];


$dbhost = 'localhost:3306';  // mysql服务器主机地址
$dbuser = 'root';            // mysql用户名
$dbpass = $options['p'];         // mysql用户名密码
$conn = mysqli_connect($dbhost, $dbuser, $dbpass);
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}
// 设置编码，防止中文乱码
mysqli_query($conn , "set names utf8");

mysqli_select_db( $conn, 'vote' );

$allCountryIDs = getAllCountryId($conn);

$topicSql = "INSERT INTO elastos_topic (title,start_time,start_date,end_time,user_id,choice,is_official,create_time,type,status,answer_status,is_valid,start_gmt_time) VALUES ";
$optionSql = "INSERT INTO elastos_topic_option (topic_id,content,vote_num,is_answer,create_time,update_time,status,country_id) VALUES ";
$addCount = 0;

// 从文件中读取数据到PHP变量
$json_string = file_get_contents('vote.json');

// 把JSON字符串转成PHP数组
$data = json_decode($json_string, true);

$officialId = getOfficialId($conn);
echo "officialId:".$officialId;

foreach ($data['topic'] as $key => $value)
{
    $addTopicsql = $topicSql . getTopicInfo($value['title'], $value['desc'], $value['Starttime'], $officialId);

    addRecord($conn, $addTopicsql);
    $topic_id = mysqli_insert_id($conn);

    $optionA = $optionSql . getOptionInfo($topic_id, $value['A'], $allCountryIDs[$value['A']]);
    addRecord($conn, $optionA);
    $optionB = $optionSql . getOptionInfo($topic_id, $value['B'], $allCountryIDs[$value['B']]);
    addRecord($conn, $optionB);
    $optionC = $optionSql . getOptionInfo($topic_id, $value['C'], 0);
    addRecord($conn, $optionC);

    $addCount++;
};

echo "addCount:".$addCount."\r\n";

print_r($allCountryIDs);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

mysqli_close($conn);

?>
