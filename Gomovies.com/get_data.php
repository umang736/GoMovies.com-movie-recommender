<?php
session_start();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
$foo = file_get_contents("php://input");
$foo=json_decode($foo, true);

require_once('db_conn.php');

if(isset($foo['query'])){
	$con=make_connection();
	if($foo['query']=='movie_list')
	{
		$sql="select * from movies";
		$result=mysqli_query($con,$sql)or die('Load movies error');
		$arr=array();
		while($res=mysqli_fetch_array($result))
		array_push($arr,array("mid"=>intval($res['mid']),"name"=>$res['movie_name']));
	
		echo json_encode($arr); 
	}
	else if($foo['query']=='user-movie_details')
	{
		if(isset($_SESSION['uid']))
		{
			$mid=$foo['mid'];	
			$sql="select rating from overall where uid=$_SESSION[uid] and mid=$mid";
			$result=mysqli_query($con,$sql)or die('Load overall error');
			if(mysqli_num_rows($result)>0)
			{
				$res=mysqli_fetch_array($result);
				$overall=$res['rating'];
				
				$sql="select rating from acting where uid=$_SESSION[uid] and mid=$mid";
				$result=mysqli_query($con,$sql)or die('Load Acting error');
				$res=mysqli_fetch_array($result);
				$acting=$res['rating'];
				$sql="select rating from music where uid=$_SESSION[uid] and mid=$mid";
				$result=mysqli_query($con,$sql)or die('Load music error');
				$res=mysqli_fetch_array($result);
				$music=$res['rating'];
				$sql="select rating from sets_design_or_backgrounds where uid=$_SESSION[uid] and mid=$mid";
				$result=mysqli_query($con,$sql)or die('Load sdb error');
				$res=mysqli_fetch_array($result);
				$sdb=$res['rating'];
				$sql="select rating from story where uid=$_SESSION[uid] and mid=$mid";
				$result=mysqli_query($con,$sql)or die('Load story error');
				$res=mysqli_fetch_array($result);
				$story=$res['rating'];
				$arr=array("acting"=>intval($acting),"music"=>intval($music),"sdb"=>intval($sdb),"story"=>intval($story),"overall"=>intval($overall),"exists"=>1);
			}
			else
				$arr=array("exists"=>0);
		}
		else
		$arr=array("exists"=>0);
		echo json_encode($arr); 
	}
	else if($foo['query']=='top-rated')
	{
		
		$arr=array();
		$bollywood=array(); $hollywood=array();
		$sql="select m.mid,movie_name,avg(o.rating) as mean from movies m inner join overall o on m.mid=o.mid where type='Bollywood' group by m.mid order by avg(rating) desc limit 3";
		$result=mysqli_query($con,$sql)or die('Load Bollywood error');
		while($res=mysqli_fetch_array($result))
		array_push($bollywood,array("mid"=>intval($res['mid']),"name"=>$res['movie_name'],"overall"=>round(doubleval($res['mean']),2)));
		$arr['bollywood']=$bollywood;
		$sql="select m.mid,movie_name,avg(o.rating) as mean from movies m inner join overall o on m.mid=o.mid where type='Hollywood' group by m.mid order by avg(rating) desc limit 2";
		$result=mysqli_query($con,$sql)or die('Load Hollywood error');
		while($res=mysqli_fetch_array($result))
		array_push($hollywood,array("mid"=>intval($res['mid']),"name"=>$res['movie_name'],"overall"=>round(doubleval($res['mean']),2)));
		$arr['hollywood']=$hollywood;

		echo json_encode($arr); 
	}
}
?>