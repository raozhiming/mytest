<?php

require_once("./Model.php");
require_once("./BlockChainModel.php");

$model = new Model();
$conn = $model->get_dbConnect();

$blockModel = new BlockChainModel($conn);
$unSyncCount = $blockModel->getUnsyncCountByType('vote');
printf("---------------------   unsyncCount(not vote) :%d ----------------------", $unSyncCount);

return $unSyncCount;
?>