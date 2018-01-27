<?php
require_once('db_conn.php');
function index_m($m,$n_movies)
{

$new_matrix=$m;
$index=array();
$rate=array();

$flag=array_fill(0,$n_movies,0);
       
    $rated_movies =count(array_filter($m, function($x) { return $x>0; }));
    $sample_size = min(floor($rated_movies*(1/10)),($n_movies-$rated_movies)); 
    $j=1; 
	  while ($j<= $sample_size)
		{
			$h2 = mt_rand(0,($n_movies-1));
			
			//printf("%d %d %d\n",$h1,$h2,$m[$h1][$h2]);
			if( $m[$h2] == 0 || $flag[$h2] == 1 )
				continue;
			
			$flag[$h2] = 1;
			$index[] =$h2;
			$rate[] =$m[$h2];
			$new_matrix[$h2] = 0;
			$j=$j+1;
		}
 	
$returned =array($new_matrix,$index,$rate);
return $returned;
}
?>