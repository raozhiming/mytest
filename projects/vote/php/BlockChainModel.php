<?php

require_once("./BaseModel.php");
require_once("./Utils.php");

class BlockChainModel extends BaseModel {
    public function getTotalCount() {
        $sql = "select type, count(*) as count from elastos_chainblock group by type";
        $recordArray = $this->ExecSelectQuery($sql);

        $sum = 0;
        foreach ($recordArray as $key => $value) {
            $sum += $value['count'];
        }
        $recordArray[] = array('type'=>'total', 'count'=>$sum);
        return $recordArray;
    }

    public function getUnSyncCount() {
        $sql = "select type, count(*) as count from elastos_chainblock where sync=0 group by type";
        $recordArray = $this->ExecSelectQuery($sql);

        $sum = 0;
        foreach ($recordArray as $key => $value) {
            $sum += $value['count'];
        }
        $recordArray[] = array('type'=>'total', 'count'=>$sum);
        return $recordArray;
    }
}

?>