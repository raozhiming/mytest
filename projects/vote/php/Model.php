<?php
require_once("./config-local.php");

class Model {
    private $db;
    public function __construct() {
        $se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
        $start_time = $se[0] + $se[1];

        printf("start connect %s:%s\r\n", HOSTNAME, DATABASE);
        $this->db = mysqli_connect(HOSTNAME, USERNAME, DBPASSWORD);
        if(! $this->db )
        {
            die('连接失败: ' . mysqli_error($this->db));
        }

        mysqli_query($this->db , "set names utf8");
        mysqli_select_db($this->db, DATABASE);

        $se1 = explode(' ',microtime());//代码结束计算当前秒数
        $end_time = $se1[0] + $se1[1];
        $spend_time = $end_time - $start_time; //代码执行结束时间 - 代码开始时间 = 执行时间
        $hstime = round($spend_time,3);//获取小数点后三位
        echo 'connect OK, Elapsed time:' . $hstime . "\r\n";
    }

    public function __destruct() {
        mysqli_close($this->db);
    }

    public function get_dbConnect() {
        return $this->db;
    }

    public function query($sql) {
        if ($this->db->query($sql) === false) {
            echo "Error: " . $sql . "\r\n" . $conn->error."\r\n";
        }
    }

    public function get_result($table="", $key="", $value="") {
        if (!$key || !$value) {
            $sql = "select * from {$table}";
        }
        else {
            $sql = "select * from {$table} where {$key} = '{$value}'";
        }
        $resultArray= array();
        $result = mysql_query($this->db, $sql);
        while($row = mysqli_fetch_array($result))
        {
            $resultArray[$row['user_id']] = $row['ident_code'];
        }
        mysqli_free_result($result);
        return $resultArray;
    }

    public function delete($table="", $key="", $value="", $match=false) {
        if (!$key || !$value) {
            $sql = "delete from {$table}";
        }
        else {
            if ($match == true) {
                $sql = "delete from {$table} where {$key} like '%{$value}%'";
            }
            else {
                $sql = "delete from {$table} where {$key} = '{$value}'";
            }
        }
        query($sql);
    }

    public function free_result($result) {
        mysqli_free_result($result);
    }
}

?>