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

    // public function getUserCountHasWallet() {
    //     $sql = "select count(*) as c from elastos_members where wallet_addr is not null;";
    //     $result = mysqli_query($this->m_db, $sql);
    //     $rowCount = $result->fetch_object()->c;
    //     mysqli_free_result($result);
    //     return $rowCount;
    // }

    // public function getUserCountNoReferee() {
    //     $sql = "select count(*) as 'c' from elastos_members where referee=0;";
    //     $result = mysqli_query($this->m_db, $sql);
    //     $rowCount = $result->fetch_object()->c;
    //     mysqli_free_result($result);
    //     return $rowCount;
    // }

    public function getRegisterReward($limit) {
        $sql = "select m.nickname, d.hexChar, d.register_reward, d.create_time from elastos_members m, elastos_lottery_details d where m.openid = d.openid order by d.create_time desc;";
        $userGroup = $this->ExecSelectQuery($sql);
        return $userGroup;
    }

    public function getLotteryRecord($limit) {
        $sql = "select m.nickname, d.hexChar, d.reward, d.create_time from elastos_members m, elastos_lottery_details d where m.openid = d.openid order by d.create_time desc;";
        $userGroup = $this->ExecSelectQuery($sql);
        return $userGroup;
    }

    public function getMedalBoard($limit) {
        $sql = "select m.nickname, j.medal_num, t.name from elastos_members m, elastos_members_joy j, elastos_teams t where m.openid = j.openid and j.team_id = t.id order by j.medal_num desc;";
        $userGroup = $this->ExecSelectQuery($sql);
        return $userGroup;
    }

    public function getCountByCreateTime($hours=1) {
        if ($hours <= 1) {
            $sql = "select date_format(from_unixtime(create_time), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_members group by hour";
        }
        else {
            $interval = 3600 * $hours;
            if ($hours % 24 == 0) {
                $sql = "select date_format(from_unixtime(floor(create_time/".$interval.")* ".$interval."), '%Y/%m/%d') hour, count(*) as count from elastos_members group by hour";
            }
            else {
                $sql = "select date_format(from_unixtime(floor(create_time/".$interval.")* ".$interval."), '%Y/%m/%d %H:00') hour, count(*) as count from elastos_members group by hour";
            }
        }
        $userGroup = $this->ExecSelectQuery($sql);
        return Utils::calTotalValue($userGroup, 'count', 'total');
    }

    public function getFateTrendByUser($name, $hours=1) {
        $start_time = $this->getFirstUserCreateTime();

        $interval = 3600 * $hours;
        $first_timeAxis = ($start_time / $interval) * $interval;
        $end_time = (time() / $interval) * $interval;

        $sql = "select (floor(create_time/".$interval.")* ".$interval.") hour, count(*) as count from elastos_members group by hour";
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
}

?>