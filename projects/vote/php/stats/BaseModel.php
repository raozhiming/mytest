<?php

class BaseModel {
    protected $m_db;

    public function __construct($db) {
        $this->m_db = $db;
    }

    public function ExecSelectQuery($sql) {
        $se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
        $start_time = $se[0] + $se[1];

        // printf("ExecSelectQuery:%s\r\n", $sql);

        $resultArray = array();
        if ($result = mysqli_query($this->m_db, $sql)) {
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $resultArray[] = $row;
            }
            mysqli_free_result($result);
        }
        else {
            echo "Error: " . $this->m_db->error."\r\n";
        }
        // print_r($resultArray);
        $se1 = explode(' ',microtime());
        $end_time = $se1[0] + $se1[1];
        $spend_time = $end_time - $start_time;
        $hstime = round($spend_time,3);//获取小数点后三位
        echo 'ExecSelectQuery OK, Elapsed time:' . $hstime . "\r\n";
        return $resultArray;
    }
}

?>