<?php
session_start();
require_once('db_conn.php');
if((isset($_POST['button1'])))
			{
				$userlogin=$_POST['email'];
				$passlogin=$_POST['password'];
					 //   echo "$passlogin" + "$userlogin";
					 
						if(empty($userlogin)||empty($passlogin))
						{
							$message="Provide both Email and Password";
							echo "<script type='text/javascript'>alert('$message');</script>";
						}
						else
						{
						   	$con=make_connection();
										    
							 $query="SELECT `name` FROM table1 WHERE `email`='$userlogin' and password='$passlogin'";					 
													 if($query_res=mysqli_query($con,$query))
													 {
														 $query_row=mysqli_fetch_assoc($query_res);
														 if($query_row)
														   {
															$name=$query_row['name'];
															$_SESSION['username']=$name;
															$query2="SELECT uid FROM users WHERE `emailid`='$userlogin'";
															$query_res2=mysqli_query($con,$query2);
															$query_row2=mysqli_fetch_assoc($query_res2);
														     if($query_row2)
															 {
																 $_SESSION['uid']=$query_row2['uid'];
															 }
															 else
															 {
															  $query3="SELECT count(*) as total FROM users";
															  $query_res3=mysqli_query($con,$query3);
															  $query_row3=mysqli_fetch_assoc($query_res3);
															  $_SESSION['uid']=$uid=$query_row3['total']+1;
															  $query3="insert into users(emailid,uid) VALUES('" . $userlogin . "', " . $uid . ")";
																$query_res3=mysqli_query($con,$query3);
															 }
															}
														 else
														   {
															  $message2="Email or Password invalid. Please try again";
															  echo "<script type='text/javascript'>alert('$message2');</script>";														
														   }
														 
													 }
													 else
													 {
														 die("Error: ".mysqli_error($con));
													 }
													 
                        }
						header("Location:".$_SERVER['HTTP_REFERER']);
	       }
?>