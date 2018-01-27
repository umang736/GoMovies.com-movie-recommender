<?php
function  gradientDescentMulti($X, $y, $theta, $alpha, $num_iters)
{
$m = count($y); //number of training examples
$cri = count($X[0]); //number of criterias
 
 $Xt=$X;
 array_unshift($Xt, null);
$Xt = call_user_func_array('array_map', $Xt);

for ($iter = 1;$iter<=$num_iters;$iter++)
{
	
	 $xty=array_fill(0,$m,0);
	 for($i=0;$i<$m;$i++)
	 {
		 for($j=0;$j<$cri;$j++)
		$xty[$i] = $xty[$i]+ $X[$i][$j]*$theta[$j];
		 $xty[$i] = $xty[$i]-$y[$i];
	 }

	 $J = computeCostMulti($xty);
    /*if(($iter%100) == 0)
	{
		echo 'cost value at iter '.$iter.' is '.$J.'<br>';		
	}*/

 for($j=0;$j<$cri;$j++)
 {
	 $prod=0;
	 for($i=0;$i<$m;$i++)
	  $prod=$prod+$Xt[$j][$i]*$xty[$i];

 	$theta[$j] = $theta[$j] - ($alpha / $m) * $prod;
 }
}
//echo'final value of J is '.$J."<br>";

return $theta;
}

function computeCostMulti($xty)
{
	
$m = count($xty); // number of training examples

$J = 0;
 
 for($i=0;$i<$m;$i++)
 $J = $J+ $xty[$i]*$xty[$i];
	 
$J=$J/(2*$m);
// =========================================================================
return $J;
}

?>