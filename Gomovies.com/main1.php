<?php
function main1($m,$uno,$s,$name)
{

$n_users = $s[0];
$n_movies = $s[1];
$avg_rating = average_rating($m,$n_users);          								// avg_rating contains the average rating of all users
/*echo "<br>".'average rating for users is : '."<br>";
print_r($avg_rating);*/
$similarity = similarity_computation($m,$n_users,$n_movies,$uno,$avg_rating,$name); //this function will give us the similarity matrix

$rate = rating_computation($m,$similarity,$avg_rating,$uno,$n_users,$n_movies);
return $rate;

//done with this function
}

function average_rating($m,$n)
{
$avg = array();
$i = 0;
while ($i < $n)
{
	 $rated_movies =count(array_filter($m[$i],function($x) { return $x>0; } ));  
	//echo array_sum($m[$i]).' '.$rated_movies."<br>";
	if($rated_movies>0)
	$avg[$i] = array_sum($m[$i])/$rated_movies;
	else $avg[$i]=0;
	$i = $i + 1;
}
return $avg;
}

function similarity_computation($m,$n_users,$n_movies,$i,$avg_u,$name)
{
//this function is being used in similarity computation
$similarity = array(); //similarity matrix
	$j = 0;
	while ($j < $n_users)
	{
		//echo "calculating for $i, $j =";
		$similarity[$j] = compute($m[$i],$m[$j],$n_movies,$avg_u[$i],$avg_u[$j]) ;  
		$j = $j  + 1;	
	}

/*echo "<br>".'similarity matrix for criteria '.$name.' is : '."<br>";
print_r($similarity);*/
return $similarity;
}

function compute( $a,$b,$n,$avg_a,$avg_b)
{
//basically a person co-relation vectorized implementation;
$i = 0;
$x = array();
$y = array();
while ($i < $n) 
{
	if( $a[$i] == 0 || $b[$i] == 0 )
	{
		$i = $i + 1;
		continue;
	}
	$x[] = $a[$i];
	$y[] = $b[$i]; 
	$i = $i  + 1; 
}

$X=array();$Y=array();$C=array();
$X1=array();$Y1=array();

$len=count($x);
for($i=0;$i<$len;$i++)
{
$X[$i] = $x[$i] - $avg_a;
$Y[$i] = $y[$i] - $avg_b;
$C[$i] = $X[$i]*$Y[$i];
$X1[$i] = $X[$i]*$X[$i];
$Y1[$i] = $Y[$i]*$Y[$i];

}
$nominator = array_sum($C);
$s1 = array_sum($X1);
$s2 = array_sum($Y1);
$s3 = $s1*$s2;
$s = sqrt($s3);
$result = 0;
//echo "$nominator/$s"."<br>";
if($s !=0)
{
		$result = $nominator/$s;
}
return $result;
}

function rating_computation($m,$similarity,$avg,$i,$n_users,$n_movies)
{
//this function is being used in similarity computation
$rating = $m; 

	$j = 0;
	while ($j < $n_movies)
		{
			if($m[$i][$j]==0)
		$rating[$i][$j] = rate_predict($m,$similarity,$avg,$i,$j,$n_users) ; 
		$j = $j  + 1;	
		}
		
	return $rating;
}	

function rate_predict($m,$sim,$avg,$user,$movie,$n)
{
//threshold similarity = ( sim(u1,u2) > 0.4 );  
// return the normalised rating which is when added to avg rating becomes final rating

$result = 0;
$k = 0;
$x = array_column($m,$movie);
$i = 0;

while ($i < $n)
	{
	if ($x[$i] == 0) 
	{
		$i = $i + 1;
		continue;
	}
     if ($sim[$i] > 0.4)	//threshold value 
		{
			$result = $result + ( ($x[$i]-$avg[$i]) * $sim[$i] );
		$k = $k +  abs($sim[$i]);
		} //finish threshold
	$i = $i + 1;
	}

if( $k != 0 )
	$result = $result/$k + $avg[$user];
else
	$result = $avg[$user];

return $result;
}
?>