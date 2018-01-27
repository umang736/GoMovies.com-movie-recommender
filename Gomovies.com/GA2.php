<?php
function GA($x,$y,$pop_size){
      $m = count($y);
	 $criteria=count($x[0]); 
	 
	  $X0 =array();
	for($j=0;$j<$pop_size;$j++)
	{
		 $X0[$j] =array(get_rand(0,1), get_rand(0,1), get_rand(0,1), get_rand(0,1), get_rand(0,1));
	}
	 	for ($k=1;$k<=($criteria*100);$k++) //100*5 iterations
     {
	 	$X0=selection($X0,$x,$y);
     	//echo '<br>'.'old: '."<b>";disp($X0);
		$j=0.2*$pop_size;//20% elitism
		 while ($j < ($pop_size-1))
		  {
			 $t=$j+1;
			 while (($t<($pop_size-1)) && ($X0[$j]==$X0[$t]))         
			 {
			 $t=$t+1;
			 }
			 $tmp=$X0[$j+1];$X0[$j+1]=$X0[$t];$X0[$t]=$tmp;
			 $returned=crossOver($X0[$j],$X0[$j+1]);
			 $X0[$j]=$returned[0];
			 $X0[$j+1]=$returned[1];
			$j=$j+2;
		  }
      	$X0=mutation($X0);
		//echo '<br>'.'new: '."<b>";disp($X0);
	 }
	 
     //finding best fit individual 
     $temp = -10000;
$res = array(get_rand(0,1), get_rand(0,1), get_rand(0,1), get_rand(0,1), get_rand(0,1));
$j = 0;
while ($j< $pop_size)
{
	 $xty=array_fill(0,$m,0);
			 for($k=0;$k<$m;$k++)
			 {
				 for($i=0;$i<$criteria;$i++)
				$xty[$k] = $xty[$k]+ $x[$k][$i]*$X0[$j][$i];
				 $xty[$k] = $xty[$k]-$y[$k];
			 }
	$fit = 1/computeCostMulti($xty);
	if($fit >= $temp)
	{
			$res = $X0[$j];
			$temp = $fit;
	}
	$j = $j + 1;
}
/*echo 'final J='.$temp.' for theta= '."<br>";
print_r($res);	*/
return $res;	
}

function selection($parents,$X,$y)
{
      $m = count($y);
	  $criteria=count($X[0]); 	
$s = count($parents);
$i = 0;
while ($i< $s)
{
	 $xty=array_fill(0,$m,0);
			 for($k=0;$k<$m;$k++)
			 {
				 for($j=0;$j<$criteria;$j++)
				$xty[$k] = $xty[$k]+ $X[$k][$j]*$parents[$i][$j];
				 $xty[$k] = $xty[$k]-$y[$k];
			 }
	$parents[$i]['fit'] = 1/computeCostMulti($xty);
	$i = $i + 1;
}
	usort($parents, 'fitSort');
	//disp($parents);

$elitend=round(0.2*$s);$mean_fit=0;
for($i=$elitend;$i<$s;$i++)
$mean_fit = $mean_fit + $parents[$i]['fit'];
$mean_fit = $mean_fit/($s-$elitend);

$selected = array();
for($i=0;$i<$elitend;$i++)
$selected[$i] = array_slice($parents[$i], 0, $criteria);

$wheel = array();
$i = $elitend;
while ($i< $s)
{
	$count = round($parents[$i]['fit']/$mean_fit);
	if($count>0)
	{
	$slice=array_slice($parents[$i], 0, $criteria);
	$j = 1;
	while($j <= $count)
	{
		$wheel[] = $slice;
		$j = $j + 1;
	}
	}
	$i = $i + 1;
}

//echo "<br>".'wheel: '."<br>";disp($wheel);
$len = count($wheel);
$i = $elitend;
while ($i< $s)
{
	$index = mt_rand(0,$len-1);	
	$selected[$i] = $wheel[$index];
	$i = $i + 1;
}

return $selected;
}

function crossOver($theta1,$theta2)
{
$r1 = $theta1;
$r2 = $theta2;
$alpha = 0.4;
// choosing a random index now
$l = count($theta1);//no. of criterias =5
$index = mt_rand(0,$l-1);

$i = $index;
while ($i < $l)
{
	$r1[$i] = $alpha*$theta1[$i] + (1-$alpha)*$theta2[$i];
	$r2[$i] = $alpha*$theta2[$i] + (1-$alpha)*$theta1[$i];
	$i = $i + 1;
}
$arr=array($r1,$r2);
return $arr;
}

function mutation($parents)
{
$mutated = $parents;
$s = count($parents);
$l = count($parents[0]);//total criterias
$i = 0.2*$s;//20% elitism;
while ($i< $s)
{
	for ($index=0;$index<$l;$index++)
	{
    $check = mt_rand(1, 10);
	if($check == 2)
	{
		$mutated[$i][$index] = get_rand(0,1);
	}
	}
	$i = $i + 1;
}
return $mutated;
}

?>