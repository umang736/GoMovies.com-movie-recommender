<?php
require_once('db_conn.php');
require_once('misc/php-utility.php');
require('index_m.php');
require('main1.php');
require('gradientDescentMulti.php');
require('calculate.php');
$con=make_connection();

session_start();
if(!isset($_SESSION['uid']))
{ 
	$recommended=top_movies($con);
	$json_arr=array('mae'=>0,'logged_in'=>false,'recommended'=>$recommended);
	echo json_encode($json_arr);
	die();
}

require('load.php');

$uid=$_SESSION['uid']-1;
$criteria=5;
$s = array($users, $movies);
//var_dump($s);

$new_final_matrix=$overall;
$returned=index_m($overall[$uid],$movies);
$new_final_matrix[$uid]=$returned[0];
$indexes=$returned[1];
$ratings=$returned[2];

/*echo "The changed are"."<br>";
print_r($indexes);print_r($ratings);*/
$si = count($indexes);
$i = 0;
while ($i< $si)
	{
	$col = $indexes[$i];	
			
	$acting[$uid][$col] = 0;
	$music[$uid][$col] = 0;
	$sdb[$uid][$col] = 0;
	$story[$uid][$col] = 0;	
	$i = $i + 1;
	}
/*echo "new overall is"."<br>";	
	disp($new_final_matrix);*/
/*disp($acting);
disp($music);
disp($sdb);
disp($story);*/										
												// our collaborative filtering approach
$rate1 = main1($acting,$uid,$s,'acting');
$rate2 = main1($music,$uid,$s,'music');
$rate3 = main1($sdb,$uid,$s,'sdb');
$rate4 = main1($story,$uid,$s,'story');

/*disp($rate1);
disp($rate2);
disp($rate3);
disp($rate4);*/

 $Nparticles=20;// population size
 $T_MAX=200;// number of iterations

	$x = array();
	$y = array();
	$j = 0;
	while ($j<$s[1])
	{
		if($new_final_matrix[$uid][$j] != 0)
		{
		$p = array(1, $rate1[$uid][$j], $rate2[$uid][$j], $rate3[$uid][$j], $rate4[$uid][$j]);		
		$x[] = $p;
		$y[] = $new_final_matrix[$uid][$j];
		}
		$j = $j + 1;
	}
	// here we are going to compute the weights(theta) for every user
    $m = count($y);
	if($m==0)
	{
	$json_arr=array('new_user'=>'y');
	echo json_encode($json_arr);die();
	}
	else if($m==$s[1])
	{
	$json_arr=array('all_rated'=>'y');
	echo json_encode($json_arr);die();
	}
	$theta_final = calculate($x,$y,$Nparticles,$T_MAX);
	
/*echo "finally learned weights for ".($uid+1)." are "."<br>";
print_r($theta_final);*/

// prediction stage
	$predicted_ratings=array();
	$i=0;//stores count of ratings predicted
	$j = 0;
	while ($j<$s[1])
	{
		if($overall[$uid][$j] == 0)
		{
		$p = array(1, $rate1[$uid][$j], $rate2[$uid][$j], $rate3[$uid][$j], $rate4[$uid][$j]);			
		$predicted_ratings[$i] =array($j, 0);
		for($k=0;$k<$criteria;$k++)
		$predicted_ratings[$i][1] = $predicted_ratings[$i][1] + $theta_final[$k]*$p[$k];
		//echo 'user '.($uid+1).' movie '.($j+1).' rating '.$predicted_ratings[$i][1]."<br>";
		$i++;
		}
		$j = $j + 1;
	}
	usort($predicted_ratings, 'mySort');
	//disp($predicted_ratings);
	
	$recommended=array();
	$recommended_len=min(round(.3 * $i),6); //recommend top 30% movies and at max 6 movies
	for($j=0;$j<$recommended_len;$j++)
	{
		$k=$predicted_ratings[$j][0];
	$recommended[$j]=array("mid"=>($k+1), "name"=>get_moviename($con,$k+1), "acting"=>round($rate1[$uid][$k],2), "music"=>round($rate2[$uid][$k],2), "sdb"=>round($rate3[$uid][$k],2), "story"=>round($rate4[$uid][$k],2), "overall"=>round($predicted_ratings[$j][1],2));
	}
										// now we are going to compute the error
$mae=0;
if($si>0)
{
$predicted = array_fill(0,$si,0);
$i = 0;
while ($i< $si)
{
	$col = $indexes[$i];
	$p = array(1, $rate1[$uid][$col], $rate2[$uid][$col], $rate3[$uid][$col], $rate4[$uid][$col]);			
		$value=0;
	for($k=0;$k<$criteria;$k++)
		$value = $value + $theta_final[$k]*$p[$k];		
	$predicted[$i] = $value;
	$i = $i + 1;
}
for($i=0;$i<$si;$i++)
$mae = $mae + abs($ratings[$i] - $predicted[$i]);
$mae=$mae/$si;
}
//echo 'MAE is   = '.$mae."<br>";

$json_arr=array();//output json array
$json_arr['mae']=round($mae,2);$json_arr['recommended']=$recommended;
	echo json_encode($json_arr);
?>