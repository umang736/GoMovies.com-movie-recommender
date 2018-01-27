<?php
function fix($con,$string){
return mysqli_real_escape_string($con,htmlentities(trim($string)));
}

function get_ip(){
if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
    $ip = $_SERVER['HTTP_CLIENT_IP'];
} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
} else {
    $ip = $_SERVER['REMOTE_ADDR'];
}
return $ip;	
}

function disp($arr){
	echo '<table>';
	foreach($arr as $rowarr)
	{
		echo '<tr>';
		foreach($rowarr as $ele)
	    echo '<td>'.$ele.'</td>';
		echo "</tr>";
	}
	echo "</table>";
}

function mySort($a, $b) {
    if($a[1] == $b[1]) {
        return 0;
    }
    return ($a[1] < $b[1]) ? 1 : -1;
}

function fitSort($a, $b) {
    if($a['fit'] == $b['fit']) {
        return 0;
    }
    return ($a['fit'] < $b['fit']) ? 1 : -1;
}

function top_movies($con){
		$arr=array();
		$sql="select m.mid,movie_name,avg(o.rating) as mean from movies m inner join overall o on m.mid=o.mid group by m.mid order by avg(rating) desc limit 6";
		$result=mysqli_query($con,$sql)or die('Load Top movies error');
		while($res=mysqli_fetch_array($result))
		array_push($arr,array("mid"=>intval($res['mid']),"name"=>$res['movie_name'],"overall"=>round(doubleval($res['mean']),2)));
		return $arr;
}

function get_moviename($con,$mid){
		$sql="select movie_name from movies where mid=$mid";
		$result=mysqli_query($con,$sql)or die('Load name error');
		$res=mysqli_fetch_array($result);
		$name=$res['movie_name'];
		return $name;
}

function get_rand($min,$max){
 $ans=$min + (mt_rand() / mt_getrandmax() * ($max - $min));	
 return $ans;
}
?>