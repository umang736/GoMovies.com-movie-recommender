<?php

$acting=array();
$music=array();
$sdb=array();
$story=array();
$overall=array();
$key_value=array("acting"=>"acting","music"=>"music","sdb"=>"sets_design_or_backgrounds","story"=>"story","overall"=>"overall");

$sql1="select count(*) as rows from users";
$result=mysqli_query($con,$sql1);
$res=mysqli_fetch_array($result);
$users=intval($res['rows']);
$sql1="select count(*) as columns from movies";
$result=mysqli_query($con,$sql1);
$res=mysqli_fetch_array($result);
$movies=intval($res['columns']);

for($i=0;$i<$users;$i++)
{
	$acting[$i]=array_fill(0, $movies, 0);
	$music[$i]=array_fill(0, $movies, 0);
	$sdb[$i]=array_fill(0, $movies, 0);
	$story[$i]=array_fill(0, $movies, 0);
	$overall[$i]=array_fill(0, $movies, 0);
}
//print_r($acting);

$sql2="select * from acting";
$result2=mysqli_query($con,$sql2);
while($res2=mysqli_fetch_array($result2))
$acting[$res2['uid']-1][$res2['mid']-1]=intval($res2['rating']);

$sql2="select * from music";
$result2=mysqli_query($con,$sql2);
while($res2=mysqli_fetch_array($result2))
$music[$res2['uid']-1][$res2['mid']-1]=intval($res2['rating']);

$sql2="select * from sets_design_or_backgrounds";
$result2=mysqli_query($con,$sql2);
while($res2=mysqli_fetch_array($result2))
$sdb[$res2['uid']-1][$res2['mid']-1]=intval($res2['rating']);

$sql2="select * from story";
$result2=mysqli_query($con,$sql2);
while($res2=mysqli_fetch_array($result2))
$story[$res2['uid']-1][$res2['mid']-1]=intval($res2['rating']);

$sql2="select * from overall";
$result2=mysqli_query($con,$sql2);
while($res2=mysqli_fetch_array($result2))
$overall[$res2['uid']-1][$res2['mid']-1]=intval($res2['rating']);

/*disp($acting);
disp($music);
disp($sdb);
disp($story);
disp($overall);*/


?>