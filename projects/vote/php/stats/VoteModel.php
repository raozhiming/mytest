<?php

require_once("./BaseModel.php");
require_once("./Utils.php");

class VoteModel extends BaseModel {
    public function getTopicCount() {
        $sql = "select count(*) as c from elastos_vote";
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c;
        mysqli_free_result($result);
        return $rowCount;
    }

    public function getVoteCountByCreateTime($hours=1) {
        if ($hours <= 1) {
            $sql = "select date_format(from_unixtime(vote_gmt_time), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_vote group by hour";
        }
        else {
            $interval = 3600 * $hours;
            if ($hours % 24 == 0) {
                $sql = "select date_format(from_unixtime(floor(vote_gmt_time/".$interval.")* ".$interval."), '%Y/%m/%d') hour, count(*) as count from elastos_vote group by hour";
            }
            else {
                $sql = "select date_format(from_unixtime(floor(vote_gmt_time/".$interval.")* ".$interval."), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_vote group by hour";
            }
        }
        $userGroup = $this->ExecSelectQuery($sql);
        return Utils::calTotalValue($userGroup, 'count', 'total');
    }

    public function getOfficialTopic() {
        $sql = "select topic_id, title, total_vote_num from elastos_topic where is_official=1 and is_valid=1 order by start_time";
        return $this->ExecSelectQuery($sql);
    }

    public function getTopTopic($limit) {
        $sql = "select topic_id, title, total_vote_num from elastos_topic order by total_vote_num desc limit ".$limit;
        return $this->ExecSelectQuery($sql);
    }


    public function getTopOption($limit) {
        $sql = "select o.option_id, t.title, o.content, o.vote_num from elastos_topic_option o, elastos_topic t where o.topic_id = t.topic_id order by o.vote_num desc limit ".$limit;
        return $this->ExecSelectQuery($sql);
    }
}

?>
