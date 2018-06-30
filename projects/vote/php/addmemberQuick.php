<?php
//add elastos_member

$options = getopt("u:r:p:b:h");

if($options['u']=='' || $options['p']=='')
{
    print_usage();
    exit(1);
}

$totalCount = (int)$options['u'];

function print_usage() {
    echo "-p [password]";
    echo "-u [total user number]\n";
}

function getUserInfo($name, $indent_code)
{
    $info = "('" . $name . "','e10adc3949ba59abbe56e057f20f883e'," . time() . ",'" .$indent_code. "') ";
    echo "getUserInfo:".$info."\r\n";
    return $info;
}

function addRecord($conn, $sql)
{
    if ($conn->query($sql) === TRUE) {
        echo "新记录插入成功\r\n";
    } else {
        echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
    }
}

function getIdentCodeByUsername($conn, $userName)
{
    $memberInfo = array();
    $result = mysqli_query($conn, "SELECT user_id, ident_code FROM elastos_members where username='".$userName."'");
    while($row = mysqli_fetch_array($result))
    {
        $memberInfo[$row['user_id']] = $row['ident_code'];
    }

    return $memberInfo;
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

// 随机生成6位唯一识别码
function randCodeCN($len = 6){
    $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
    mt_srand((double)microtime()*1000000*getmypid());
    $code = '';
    while(strlen($code) < $len)
        $code .= substr($chars, (mt_rand()%strlen($chars)), 1);
    return $code;
}

function getIdentCode($memberInfo){
    $ident_code = '';
    do{
        $ident_code = randCodeCN();
    }while(array_search($ident_code, $memberInfo));
    return $ident_code;
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

$allMemberInfo = getAllIdentCode($conn);

$sql = "INSERT INTO elastos_members (username,password,create_time,ident_code) VALUES ";

$addCount = 0;
$needAdd=0;

for ($i=1; $i<=$totalCount; $i++)
{
    $userName = "testq".$i;

    $indent_code = getIdentCode($allMemberInfo);
    $sql .= getUserInfo($userName, $indent_code).',';

    $addCount++;
    $needAdd++;
    if (($addCount % 10000) == 0) {
        $sql = substr($sql, 0, strlen($sql) - 1);
        addRecord($conn, $sql);

        $needAdd=0;
        $sql = "INSERT INTO elastos_members (username,password,create_time,ident_code) VALUES ";
    }

    $allMemberInfo[$id] = $indent_code;
};

if ($needAdd) {
    $sql = substr($sql, 0, strlen($sql) - 1);
    addRecord($conn, $sql);
}
echo "addCount:".$addCount."\r\n";

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

mysqli_close($conn);

?>
