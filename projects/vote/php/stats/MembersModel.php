<?php

require_once("./BaseModel.php");
require_once("./Utils.php");

class MemberModel extends BaseModel {
    private $m_firstCreateTime = 0;

    public function getFirstUserCreateTime() {
        if ($m_firstCreateTime <= 0) {
            $sql = "select create_time from elastos_members limit 1";
            $result = mysqli_query($this->m_db, $sql);
            $m_firstCreateTime = $result->fetch_object()->create_time;
            mysqli_free_result($result);
        }
        return $m_firstCreateTime;
    }

    public function getUserCount() {
        $sql = "select count(*) as c from elastos_members";
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c;
        mysqli_free_result($result);
        return $rowCount;
    }

    public function getUserCountHasWallet() {
        $sql = "select count(*) as c from elastos_members where wallet_addr is not null;";
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c;
        mysqli_free_result($result);
        return $rowCount;
    }

    public function getUserCountNoReferee() {
        $sql = "select count(*) as 'c' from elastos_members where referee=0;";
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c;
        mysqli_free_result($result);
        return $rowCount;
    }

    public function getUsersByFate_num($limit) {
        $sql = "select user_id, username, zone, fate_num from elastos_members where fate_num>0 order by fate_num desc limit 0,{$limit};";
        $userGroup = $this->ExecSelectQuery($sql);
        return Utils::addCountryName($userGroup);
    }

    public function getCountByCreateTime($hours=1) {
        if ($hours <= 1) {
            $sql = "select date_format(from_unixtime(create_time), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_members group by hour";
        }
        else {
            $interval = 3600 * $hours;
            $sql = "select date_format(from_unixtime(floor(create_time/".$interval.")* ".$interval."), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_members group by hour";
        }
        $userGroup = $this->ExecSelectQuery($sql);
        return Utils::calTotalValue($userGroup, 'count', 'total');
    }

    public function getFateTrendByUser($name, $hours=1) {
        $start_time = $this->getFirstUserCreateTime();

        $interval = 3600 * $hours;
        $first_timeAxis = ($start_time / $interval) * $interval;
        $end_time = (time() / $interval) * $interval;

        $sql = "select (floor(create_time/".$interval.")* ".$interval.") hour, count(*) as count from elastos_members  where referee =(select user_id from elastos_members where username='{$name}') group by hour";
        $userGroup = $this->ExecSelectQuery($sql);

        $fateArray = Array();
        $date_index = $first_timeAxis;
        $total_value = 0;
        foreach ($userGroup as $key => $value) {
            for ($dateAxis = $date_index; $dateAxis < $value['hour']; $dateAxis += $interval) {
                $dateStr = date("Y/m/d H:00", $dateAxis);
                $fateArray[$dateStr] = $total_value;
            }

            $date_index = $dateAxis;
            $dateStr = date("Y/m/d H:00", $dateAxis);
            $total_value += $value['count'];
            $fateArray[$dateStr] = $total_value;
        }

        for ($dateAxis = $date_index + $interval; $dateAxis < $end_time; $dateAxis += $interval) {
            $dateStr = date("Y/m/d H:00", $dateAxis);
            $fateArray[$dateStr] = $total_value;
        }

        return $fateArray;
    }

    public function getUserByCountry() {
        $sql = "select zone, count(*) as count, sum(fate_num) as fate_num from elastos_members group by zone order by count desc;";
        $userGroup = $this->ExecSelectQuery($sql);
        return Utils::addCountryName($userGroup);
    }

    public function getUserTrendByVoteCount() {
        $sql = "select count(v.user_id) as total from elastos_vote v left join elastos_members m on m.user_id = v.user_id group by v.user_id";
        $userGroup = $this->ExecSelectQuery($sql);

        $voteArray = array();
        $userCountNoVote = $this->getUserCountNoVote();
        $voteArray[0] = $userCountNoVote;

        foreach ($userGroup as $key => $value) {
            $voteArray[$value['total']]++;
        }
        ksort($voteArray);
        $voteArray['total'] = array_sum($voteArray);
        return $voteArray;
    }

    public function getUserCountNoVote() {
        $sql = "select count(*) as 'c' from elastos_members m where (select count(1) from elastos_vote v where m.user_id = v.user_id) = 0";
        $result = mysqli_query($this->m_db, $sql);
        $rowCount = $result->fetch_object()->c;
        mysqli_free_result($result);
        return $rowCount;
    }

    public function getUserCountNoVoteByCountry() {
        $sql = "select zone, count(*) as count from elastos_members m where m.user_id not in (select user_id from elastos_vote) group by zone order by count";
        $userGroup = $this->ExecSelectQuery($sql);
        return Utils::addCountryName($userGroup);
    }

    public function getVoteCountByReferee($referee) {
        $sql = "select count(v.user_id) as total from elastos_vote v, elastos_members m where m.referee={$referee} and m.user_id = v.user_id group by v.user_id";
        $userGroup = $this->ExecSelectQuery($sql);

        $voteArray = array();
        foreach ($userGroup as $key => $value) {
            $voteArray[$value['total']]++;
        }
        ksort($voteArray);
        $voteArray['total'] = array_sum($voteArray);
        return $voteArray;
    }
}

?>