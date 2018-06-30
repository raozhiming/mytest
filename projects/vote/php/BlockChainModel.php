<?php

require_once("./Utils.php");

class BlockChainModel {
    private $m_db;

    public function __construct($db) {
        $this->m_db = $db;
    }

    private function ExecSelectQuery($sql) {
        $se = explode(' ',microtime()); //返回数组，当前时间微秒数和时间戳秒数
        $start_time = $se[0] + $se[1];

        printf("ExecSelectQuery:%s\r\n", $sql);

        $userArray = array();
        if ($result = mysqli_query($this->m_db, $sql)) {
            while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                $userArray[] = $row;
            }
            mysqli_free_result($result);
        }
        else {
            echo "Error: " . $this->m_db->error."\r\n";
        }
        $se1 = explode(' ',microtime());
        $end_time = $se1[0] + $se1[1];
        $spend_time = $end_time - $start_time;
        $hstime = round($spend_time,3);
        echo 'ExecSelectQuery OK, Elapsed time:' . $hstime . "\r\n";
        return $userArray;
    }

    public function getCount() {
        $sql = "select type, count(*) as count from elastos_chainblock group by type";
        $recordArray = $this->ExecSelectQuery($sql);
        $recordArray['total'] = array_sum($recordArray);
        return $recordArray;
    }

    public function getAllVotes() {
        $sql = "select user_id, topic_id, option_id, vote_gmt_time from elastos_chainblock;";
        return $this->ExecSelectQuery($sql);
    }

    // public function getCountByCreateTime() {
    //     $sql = "select date_format(from_unixtime(vote_gmt_time), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_chainblock group by hour";
    //     $userGroup = $this->ExecSelectQuery($sql);
    //     return Utils::calTotalValue($userGroup, 'count', 'total');
    // }

    public function getUnsyncCountByType($type="") {
        if (!$type) {
            $sql = "select count(*) as 'c' from elastos_chainblock where sync = 0;";
        }
        else {
            $sql = "select count(*) as 'c' from elastos_chainblock where sync = 0 and type = '{$type}';";
        }
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c;
        mysqli_free_result($result);
        return $rowCount;
    }

    public function getUnsyncCountNotVote() {
        $sql = "select count(*) as 'c' from elastos_chainblock where sync = 0 and type != 'vote';";
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c;
        mysqli_free_result($result);
        return $rowCount;
    }
}

?>