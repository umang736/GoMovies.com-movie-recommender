<?php
session_start();
require_once('db_conn.php');
if(count($_POST)>0)
{
	$con=make_connection();
	$key_value=array("acting"=>"acting","music"=>"music","sdb"=>"sets_design_or_backgrounds","story"=>"story","overall"=>"overall");
	
	if(isset($_POST['mid'])&&isset($_POST['overall'])&&isset($_POST['exists']))
	{
	$uid=$_SESSION['uid'];$i=$_POST['mid'];
			if(!$_POST['exists'])
			{
			$sql3="insert into acting values ($uid,$i,$_POST[acting])";
			mysqli_query($con,$sql3)or die('insert acting error');			
			$sql3="insert into music values ($uid,$i,$_POST[music])";
			mysqli_query($con,$sql3)or die('insert music error');
			$sql3="insert into sets_design_or_backgrounds values ($uid,$i,$_POST[sdb])";
			mysqli_query($con,$sql3)or die('insert sets_design_or_backgrounds error');
			$sql3="insert into story values ($uid,$i,$_POST[story])";
			mysqli_query($con,$sql3)or die('insert story error');
			$sql3="insert into overall values ($uid,$i,$_POST[overall])";
			mysqli_query($con,$sql3)or die('insert overall error');
			}
			else //$_POST['exists']==1
			{
			$sql3="update acting set rating=$_POST[acting] where uid=$uid and mid=$i";
			mysqli_query($con,$sql3)or die('update acting error');			
			$sql3="update music set rating=$_POST[music] where uid=$uid and mid=$i";
			mysqli_query($con,$sql3)or die('update music error');
			$sql3="update sets_design_or_backgrounds set rating=$_POST[sdb] where uid=$uid and mid=$i";
			mysqli_query($con,$sql3)or die('update sets_design_or_backgrounds error');
			$sql3="update story set rating=$_POST[story] where uid=$uid and mid=$i";
			mysqli_query($con,$sql3)or die('update story error');
			$sql3="update overall set rating=$_POST[overall] where uid=$uid and mid=$i";
			mysqli_query($con,$sql3)or die('update overall error');
			}
			echo "done";
	}
}
?>