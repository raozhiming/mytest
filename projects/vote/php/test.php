<?php

function calWins($life, $allResult)
{
	$name = (int)$life;
	$hasName=true;
	$succKey  =array();
	$errKey   =array();
	// $errorShow=false;

	echo '命 ',$name;


	foreach ($allResult as $key => $value) {
		if($value==1){
			if(!in_array($key, $succKey)){
				$succKey[]=$key;
			}
		}else{
			if(!in_array($key,$errKey)){
				$errKey[]=$key;
			}
		}

	}

	//找到可以续命的errKey
	$nameErrKey=[];//存储可以续命的errkey
	$maxKey=count($allResult)-1;
	foreach ($errKey as $key => $value) {
		if($value==0||$value==$maxKey){//第一个或最后一个就猜错，直接丢掉，不考虑续命
			//do nothing
		}else{
			if($allResult[$value-1]==1&&$allResult[$value+1]){//上下都猜对的情况下才可以续命哦！！！！
				$nameErrKey[]=$value;
			}
		}


	}

	$nameErrKeyCount=count($nameErrKey);

	if($nameErrKeyCount==0){//表示不存在可以用“命”来替换的key
		// print_r('<pre>');
		// print_r($nameErrKey);
		echo '走这里逻辑';
		// print_r($allResult);
		$ContinuousWinningCategory=[];//连中的种类集合
		$firstKey=[];
		$firstSuccCursor=false;//指向第一个猜中的光标
		$counter=0;//连中计数器


		foreach ($allResult as $key => $value) {
			if($value==1&&!$firstSuccCursor){//第1次猜中且还没有指向第一个猜中光标的的情况下
				$firstKey[]=$key;
				$firstSuccCursor=true;
			}
			if($value==1&&$firstSuccCursor){//大于第一次猜中且已经有指向第一个猜中光标的情况下
				//do nothing
				$counter+=1;
			}

			if($value==0){
				$firstSuccCursor=false;
				if($counter>0&&$counter!=1){//判断$counter!=1的目的是避免1连中情况存在
					$ContinuousWinningCategory[]=$counter;
				}
				$counter=0;
			}

			if(count($allResult)-1==$key&&$counter>0&&$counter!=1){//判断是不是最后一个投票，判断$counter!=1的目的是避免1连中情况存在
				$ContinuousWinningCategory[]=$counter;
			}
			echo $key.':'.$counter;
			echo '<br>';

		}

		// print_r('<pre>');
		// print_r($ContinuousWinningCategory);

	}else{
		// print_r('<pre>');
		// print_r($nameErrKey);
		// print_r($allResult);
		$ContinuousWinningCategory=[];//连中的种类集合
		$firstKey=[];
		$firstSuccCursor=false;//指向第一个猜中的光标
		$counter=0;//连中计数器


		foreach ($allResult as $key => $value) {
			if($value==1&&!$firstSuccCursor){//第1次猜中且还没有指向第一个猜中光标的的情况下
				$firstKey[]=$key;
				$firstSuccCursor=true;
			}
			if($value==1&&$firstSuccCursor){//大于第一次猜中且已经有指向第一个猜中光标的情况下
				//do nothing
				$counter+=1;
			}

			if($value==0&&!in_array($key, $nameErrKey)) {
				$firstSuccCursor=false;
				if($counter>0&&$counter!=1){
					$ContinuousWinningCategory[]=$counter;
				}
				$counter=0;
			}

			if($value==0&&in_array($key, $nameErrKey)) {//啥也不做，跳过去
				// $counter
				echo '当前级别:'.$counter.'级升下一级需要：';
				echo pow(2,$counter-1);
				echo '命,';
				if((true == $hasName) && pow(2,$counter-1) <= $name) {//有命且命足够的情况下
					$firstSuccCursor=true;
					$name = $name-pow(2,$counter-1);
					if($name==0){
						$hasName=false;
					}
					echo '命足够||',$name;

				}else{//命不够用的，白搭，不能进行连续
					echo '不够||',$name;
					$firstSuccCursor=false;
					if($counter>0&&$counter!=1){
						$ContinuousWinningCategory[]=$counter;
					}
					$counter=0;
				}


			}

			if(count($allResult)-1==$key&&$counter>0&&$counter!=1){//判断是不是最后一个投票
				$ContinuousWinningCategory[]=$counter;
			}

			// echo $key.':'.$counter;
			// echo '<br>';
		}

		print_r('<pre>');
		print_r($ContinuousWinningCategory);

	}
    return $ContinuousWinningCategory;
}

	#-----------------------------------------------------
	//模拟各种猜中场景
	// $allResult=['1','1','0','0','0','1','1','1','1','1','0','0','0','1','1'];
	// $allResult=['0','1','1','0','1','1','0','1','1','1','0','0','0','1','1'];
	// $allResult=['1','1','0','1','1','0','1','0','1','1','0','0','0','1','1'];
	// $allResult=['1','0','0','1','1','1','0','0','1','1','0','0','0','1','1'];
	// $allResult=['1','0','0','0','1','0','1','0','1','1','0','0','0','1','1'];
	// $allResult=['0','0','0','0','0','0','0','0','1','1','0','0','0','1','1'];
	// $allResult=['1','1','1','1','1','1','1','1','1','1','0','0','0','1','1'];
	// $allResult=['0','0','1','1','0','0','1','1','1','1','0','0','0','1','1'];
	// $allResult=['1','1','0','1','1','0','1','0','1','1','0','0','0','1','1'];

	// $allResult=['1','0','1','0','0','1','1','1','1','0','1'];

	// $allResult=['1','0','1','1','0','1','1','1','0','1'];
	// $allResult=['1','0','1', '0','1','1','1','1','0','1', '0', '1'];
	// $allResult=['1','1','1','0','1','1','0','1', '1', '0'];
	// $allResult=['1','0','1','1','1','1','1','1','0'];
	// $allResult=['1','1','1','1','1','1','1','1','0','1', '0','1'];

	// $allResult=['0','1', '1', '0','0','1','1','1','1', '1','0','0','1','1'];

	$lifes = [1,1,1,1,1,
				0,0,8,2,2,8,
				8,8,3,8,128,
				8,7,16];

	$results = array
	(
		array('1'),
		array('0'),
	    array('1','1'),
	    array('1','0', '0','1'),
	    array('1','0', '1','1'),//5
	    array('1','0', '1','1'),
	    array('1','0', '1','0'),
	    array('1','0', '1','0','1'),
	    array('1','0', '1','0','1'),
	    array('1','1', '1','1','1'),//10
	    array('1','0', '0','0','1'),
	    array('1','0', '0','1','0'),
	    array('1','0', '1','0','1', '0', '1'),
	    array('1','0', '1','0','0', '1', '0', '1', '0', '0', '1', '0','1'),
	    array('0','1', '1', '0','0','1','1','1','1', '1','0','0','1','1'),
	    array('1','0', '0', '1','1','1','1','1','1', '1','0','0','1','1'),//15
	    array('1','0', '0', '1','1','1','1','1','1', '1','0','1','1','1'),
	    array('1','1', '1', '1','0','1','0','1','1', '1','0','1','1','1'),
	    array('1','1', '1', '1','1','1','0','1','1', '1','1','1','0','1'),
	);
	$continuousWinning = array
	(
	    array(),
	    array(),
	    array(2),
	    array(),
	    array(3),//5
	    array(2),
	    array(),
	    array(3),
	    array(2),
	    array(5),//10
	    array(),
	    array(),
	    array(4),
	    array(2,2,2),
	    array(2,5,2),
	    array(7,2),//15
	    array(7,3),
	    array(4,4,3),
	    array(6,6),
	);

	$errorCase=[];
	for($i = 0;$i < count($results);$i++){
		echo "\r\n----------------", $i, "------------------\r\n";
		echo "lifes ",($lifes[$i]);
		$calResult = calWins($lifes[$i], $results[$i]);
		if($calResult == $continuousWinning[$i]){
		    print_r('数组相同');
		}
		else {
			$errorCase[]=$i;
			echo "---------  ", $i,"  ------";
			echo "calResult\r\n";
			print_r($calResult);
			echo "expect\r\n";
			print_r($continuousWinning[$i]);
		}
	}

	echo "\r\n-----------------------------------\r\n";
	echo 'Total Cases:',count($results), ' Fail:',count($errorCase);
	echo "\r\n-----------------------------------\r\n";

	if (count($errorCase) > 0) {
		print_r($errorCase);
	}


?>