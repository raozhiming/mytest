<?php
//add elastos_member

require("./Model.php");

$options = getopt("u:r:b:h");

if($options['u']=='' || $options['r']=='' || $options['b']=='')
{
    print_usage();
    exit(1);
}

$totalCount = (int)$options['u'];
$parentInfo = array();
$parentCount = (int)$options['b'];
$parentCountRecord = 0;
$refereeCount = (int)$options['r'];
$refereeCountRecord = 0;

function print_usage() {
    echo "-u [total user number]\n";
    echo "-b [parent number]\n";
    echo "-r [referee number]\n";
}

function getUserInfo($name, $referee,$indent_code,$parent_ident_code)
{
    $info = "('" . $name . "','e10adc3949ba59abbe56e057f20f883e'," . time() . "," . $referee . ",'".$indent_code. "','".$parent_ident_code."') ";
    // echo "getUserInfo:".$info."\r\n";
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
        // echo "新记录插入成功\r\n";
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

function updateParent($conn, $parentInfo)
{
    foreach ($parentInfo as $userid => $info)
    {
        $updateTopicSql = "UPDATE elastos_members set fate_num =".$info['fate_num']." where user_id =".$userid;
        addRecord($conn, $updateTopicSql);
    }
}

function getIdentCodeByUsername($conn, $userName)
{
    $memberInfo = array();
    $result = mysqli_query($conn, "SELECT user_id, fate_num, ident_code FROM elastos_members where username='".$userName."'");
    while($row = mysqli_fetch_array($result))
    {
        $memberInfo[$row['user_id']] = array('ident_code' => $row['ident_code'], 'fate_num' => $row['fate_num']);
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
// $conn = mysqli_connect($dbhost, $dbuser, $dbpass)；
$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}
// 设置编码，防止中文乱码
// mysqli_query($conn , "set names utf8");

// mysqli_select_db( $conn, 'vote' );

$allMemberInfo = getAllIdentCode($conn);

$sql = "INSERT INTO elastos_members (username,password,create_time,referee,ident_code,parent_ident_code) VALUES ";

$addCount = 0;
$needAdd=0;

for ($i=1; $i<=$totalCount; $i++)
{
    $refee = 0;
    $parent_ident_code = "NULL";
    $userName = "test".$i;
    $hasUser = false;
    // $hasUser = isUserExist($conn, $userName);
    if (false == $hasUser){
        if (($i > $parentCount) && ($refereeCountRecord < $refereeCount)) {
            $temp=array_rand($parentInfo,1);
            $refee = $temp;
            // echo "refee id:".$temp."\r\n";
            $parent_ident_code = $parentInfo[$temp]['ident_code'];
            $refereeCountRecord++;
        }

        $indent_code = getIdentCode($allMemberInfo);

        $addCount++;
        $needAdd++;

        if ($parentCountRecord >= $parentCount) {
            $sql .= getUserInfo($userName, $refee, $indent_code, $parent_ident_code).',';
            if ($refee > 0) {
                $parentInfo[$temp]['fate_num']++;
            }

            if (($addCount % 5000) == 0) {
                $sql = substr($sql, 0, strlen($sql) - 1);
                addRecord($conn, $sql);

                $needAdd=0;
                $sql = "INSERT INTO elastos_members (username,password,create_time,referee,ident_code,parent_ident_code) VALUES ";
            }
        }
        else {
            $addsql = "INSERT INTO elastos_members (username,password,create_time,referee,ident_code,parent_ident_code) VALUES " . getUserInfo($userName, $refee, $indent_code, $parent_ident_code);
            addRecord($conn, $addsql);

            $id = mysqli_insert_id($conn);
            // echo "parent id:".$id."\r\n";
            $parentInfo[$id] = array('ident_code' => $indent_code, 'fate_num' => 0);
            $parentCountRecord++;
        }
    }
    else {
        $info = getIdentCodeByUsername($conn, $userName);
        if ($parentCountRecord <= $parentCount) {
            $key = key($info);

            $parentInfo[$key] = $info[$key];

            $parentCountRecord++;
        }
    }
};

if ($needAdd) {
    $sql = substr($sql, 0, strlen($sql) - 1);
    addRecord($conn, $sql);
}

if ($addCount > 0) {
    updateParent($conn, $parentInfo);
}

echo "addCount:".$addCount."\r\n";

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

?>
