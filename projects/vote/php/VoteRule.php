<?php
class Rng{
	private $total_life;
	private $final = [];

	public function getRng($arr, $total_life){
		$this->final = [];
		print_r($arr);
		$this->total_life = $total_life;
		//数组转字符串，去掉两端的0，再以00分割成数组
		$arr = explode('00',trim(implode('', $arr), '0'));
		echo " arr new\r\n";
		print_r($arr);
		foreach($arr as $v){
			if(strlen($v) > 1){
				//把分割后的数组的值：数量小于1的去掉，去掉两端的0
				$this->checkLife(trim($v, '0'));
			}
		}
		echo " return final\r\n";
		print_r($this->final);
		return $this->final;
	}

	private function checkLife($str){
		//去掉两端的0
		$str = trim($str, '0');
		if(strlen($str) > 1){
			if(!strpos($str, '0')){
			//如果全为1，直接存入最终数组
			$this->final[] = strlen($str);
			}else{
				$arr = $this->strToArr($str);
				$i = 0;//记录使用命的次数
				foreach($arr as $k=>$v){
					if($v == '0'){
						//需要命数
						$life = pow(2, $k-$i-1);
						echo '当前级别：'.($k-$i).'级,升下一级需要：'.$life.'命，当前剩余：'.$this->total_life.'命'.'<br>';
						if($life <= $this->total_life){
							$this->total_life -= $life;
							$i++;
							//如果此次使用命之后接下来的字符串全为1
							if(!strpos(trim(substr($str, $k), '0'), '0')){
								//把此字符串所有0去掉(去掉的也是使用过的命)
								$str = str_replace('0', '', $str);
								$this->checkLife($str);
								break;
							}
						}else{
							//命不够了，直接把此命之前的连续猜对次数存入最终数组
							$this->final[] = $k - $i;
							//截取此命之后的字符串
							$str = substr($str, $k);
							$this->checkLife($str);
							break;
						}
					}
				}
			}
		}
	}

	//字符串转数组
	private function strToArr($str){
		$arr = [];
		for($i = 0; $i < strlen($str); $i++){
			$arr[] = substr($str, $i, 1);
		}
		return $arr;
	}

}
// $arr = [0,1,0,0,1,1,0,0,0,0,0,0,1,1,0,1,1,1,1,0,1,0,1,0,0];
// $arr = [1,0,0,0,1,0,0,0,0,1,1,0,1];
$arr = array('1','1', '1','1','1','0','0','1', '1', '0', '1');
$rng = new Rng();
// echo "<pre>";
$res = $rng->getRng($arr, 1);
print_r($res);

$lifes = [1,1,1,1,1,
			0,0,8,2,2,8,
			8,8,3,8,128,
			8,7,16,0,2,
			];

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
	array('1','0', '0','0','0','0','0','1', '1', '0', '1'),
	array('1','0', '0','0','0','0','0','1', '1', '0', '1'),
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
    array(2),
    array(3),
);

$errorCase=[];
for($i = 0;$i < count($results);$i++){
	echo "\r\n----------------", $i, "------------------\r\n";
	echo "lifes ",($lifes[$i]);
	$calResult = $rng->getRng($results[$i], $lifes[$i]);
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