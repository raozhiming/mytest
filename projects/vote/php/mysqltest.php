<?php
//add elastos_member

require("./Model.php");


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
    // print_r($parentInfo);
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


//开始时间计算
$se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
$ntime = $se[0] + $se[1];

$model = new Model();
$conn = $model->get_dbConnect();
if(! $conn )
{
    die('连接失败: ' . mysqli_error($conn));
}

$sql = "alter table elastos_vote add vote_gmt_time int(11) NOT NULL DEFAULT '0' COMMENT '格林威治投票时间（世界时间）'";
addRecord($conn, $sql);

// $allMemberInfo = getAllIdentCode($conn);
// print_r($allMemberInfo);

$se1 = explode(' ',microtime());//代码结束计算当前秒数
$etime = $se1[0] + $se1[1];
$htime = $etime - $ntime; //代码执行结束时间 - 代码开始时间 = 执行时间
$hstime = round($htime,3);//获取小数点后三位

echo 'Elapsed time:' . $hstime . '\r\n';

mysqli_close($conn);

?>
