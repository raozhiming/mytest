<?php

require_once("./Utils.php");

class VoteModel {
    private $m_db;
    private $m_voteArray = array();

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
        $sql = "select count(*) as c from elastos_vote";
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c - 1;//-1:official
        mysqli_free_result($result);
        return $rowCount;
    }

    public function getAllVotes() {
        $sql = "select user_id, topic_id, option_id, vote_gmt_time from elastos_vote;";
        return $this->ExecSelectQuery($sql);
    }

    public function getCountByCreateTime($hours=1) {
        if ($hours <= 1) {
            $sql = "select date_format(from_unixtime(vote_gmt_time), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_vote group by hour";
        }
        else {
            $interval = 3600 * $hours;
            $sql = "select date_format(from_unixtime(floor(vote_gmt_time/".$interval.")* ".$interval."), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_vote group by hour";
        }
        $userGroup = $this->ExecSelectQuery($sql);
        return Utils::calTotalValue($userGroup, 'count', 'total');
    }


    public function getTopTopic($limit) {
        $sql = "select topic_id, title, total_vote_num from elastos_topic order by total_vote_num desc limit ".$limit;
        return $this->ExecSelectQuery($sql);
    }

    public function getOfficialTopic() {
        $sql = "select topic_id, title, total_vote_num from elastos_topic where is_official=1 and is_valid=1 order by start_time";
        return $this->ExecSelectQuery($sql);
    }

    public function getTopOption($limit) {
        $sql = "select o.option_id, t.title, o.content, o.vote_num from elastos_topic_option o, elastos_topic t where o.topic_id = t.topic_id order by o.vote_num desc limit ".$limit;
        return $this->ExecSelectQuery($sql);
    }
}

?>
