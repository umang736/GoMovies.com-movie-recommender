<!DOCTYPE html>


<?php
session_start();
if(isset($_SESSION['uid'])) {
  header("Location: index.php");
  
}

include_once 'db_conn.php';
include_once 'misc/php-utility.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
   $con=make_connection();
    $name = fix($con,$_POST['name']);
    $email = fix($con,$_POST['email']);
    $password = fix($con,$_POST['password']);
    $cpassword =fix($con,$_POST['cpassword']);
    
    //name can contain only alpha characters and space
    if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
        $error = true;
        $name_error = "Name must contain only alphabets and space";
    }
    if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {
        $error = true;
        $email_error = "Please Enter Valid Email ID";
    }
    if(strlen($password) < 6) {
        $error = true;
        $password_error = "Password must be a minimum of 6 characters";
    }
    if($password != $cpassword) {
        $error = true;
        $cpassword_error = "Password and Confirm Password don't match";
    }
    if (!$error) 
	{
		
		$sql="SELECT email FROM table1 WHERE email='$email'";
        $result=mysqli_query($con,$sql);
	    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
        if(mysqli_num_rows($result)>=1)
        {
            $message2="Email Already Taken. Please try again ";
			echo "<script type='text/javascript'>alert('$message2');     </script>";
        }									 
        else if(mysqli_query($con, "INSERT INTO table1(name,email,password) VALUES('" . $name . "', '" . $email . "', '" .$password. "')"))
		 {
			 
			$query="SELECT count(*) as total FROM users";
			$query_res=mysqli_query($con,$query);
			$query_row=mysqli_fetch_assoc($query_res);
			$uid=$query_row['total']+1;
			$query="insert into users(emailid,uid) VALUES('" . $email . "', " . $uid . ")";
			$query_res=mysqli_query($con,$query);
           $successmsg = "Successfully Registered! <a href='index.php'>Click here to Login</a>";
         } 
		else {
            $errormsg = "Error in registering...Please try again later!";
        }
    }
}
?>

<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GoMovies signup</title>
        
        <!-- CSS -->
        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500">
        <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/font-awesome.min.css">
		<link rel="stylesheet" href="assets/css/form-elements.css">
    	<link href="css/main.css" rel="stylesheet">
        <link rel="stylesheet" href="assets/css/style.css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="js/html5shiv.js"></script>
            <script src="js/respond.min.js"></script>
        <![endif]-->

        <!-- Favicon and touch icons -->
        <link rel="shortcut icon" href="images/ico/G-icon.ico">
    </head>

    <body>

		 <header class="navbar navbar-inverse navbar-fixed-top wet-asphalt" role="banner">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php" style="height:80px;"><img src="images/logo.png" alt="logo"></a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-left" style="font-size:15px;">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="gallery.php">Gallery</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Trending Week- Top Movies<i class="icon-angle-down"></i></a>
                        <ul class="dropdown-menu">
                           <li class="nav-header"> Bollywood</li>
                              <li class="divider"></li>
                           <li class="nav-header">Hollywood</li>
                        </ul>
                    </li>
                    
                     <?php
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
														    	 $_SESSION['uid']=$query_row2['uid'];
															
															header("Location: index.php");
														   }
														 else
														   {
															  $message2="Email or Password invalid. Please try again";
															  echo "<script type='text/javascript'>alert('$message2');</script>";														
														   }
														 
													 }
													 else
													 {
														 echo mysqli_error($con);
													 }
													 
                        }
	       }
			?>
			  <form class="navbar-form pull-right" name="form1" action="indexsign.php" method="post" >
              <input class="span2" type="text" placeholder="Email" name="email" >
              <input class="span2" type="password" placeholder="Password" name="password">
              <button type="submit" class="btn" name="button1">Sign in</button>
              </form>
		    

                    <li><a href="contact-us.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </header><!--/header-->

        <!-- Top content -->
        <div class="top-content" style="background-image: url(./images/backgrounds/register.JPG);">
        	
            <div class="inner-bg" >
                <div class="container">
                    <div class="row">
                        <div class="col-sm-8 col-sm-offset-2 text">
                            <h1><u><strong>Registration Form</strong></u></h1>
                            <div class="description">
                            	<p>
	                            	
                            	</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    	<!--<div class="col-sm-6 col-md-6">
                    		<img src="assets/img/ebook.png" alt="">
                    	</div>-->
                        <div class="col-sm-6 col-md-6 col-sm-offset-6 col-md-offset-6 col-sm-offset-6 form-box">
                        	<div class="form-top">
                        		<div class="form-top-left">
                        			<h3>Get our full advantage</h3>
                            		<p>Fill in the form below to get instant access:</p>
                        		</div>
                        		<div class="form-top-right">
                        			<i class="fa fa-pencil"></i>
                        		</div>
                            </div>
                            <div class="form-bottom">
			                   <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                <fieldset>
                    <legend>Sign Up</legend>

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="Enter Full Name" required value="<?php if($error) echo $name; ?>" class="form-control" />
                        <span class="text-danger"> <?php if (isset($name_error)) echo $name_error; ?> </span>
                    </div>
                    
                    <div class="form-group">
                        <label for="name">Email</label>
                        <input type="text" name="email" placeholder="Email" required value="<?php if($error) echo $email; ?>" class="form-control" />
                        
                        
                        <span class="text-danger"><?php if (isset($email_error)) echo $email_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Password</label>
                        <input type="password" name="password" placeholder="Password" required class="form-control" />
                       
                       
                        <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                    </div>

                    <div class="form-group">
                        <label for="name">Confirm Password</label>
                        <input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
                        <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                    </div>

                    <div class="form-group">
                        <input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
                    </div>
                </fieldset>
            </form>
             <span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
            <span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		                    </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>


        <!-- Javascript -->
        <script src="assets/js/jquery-1.11.1.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>
        <!--  <script src="assets/js/jquery.backstretch.min.js"></script>
        <script src="assets/js/retina-1.1.0.min.js"></script>-->
        <script src="assets/js/scripts.js"></script>
        <!--[if lt IE 10]>
            <script src="assets/js/placeholder.js"></script>
        <![endif]-->
 <script>
    jQuery(document).ready(function () {
							
$.ajax({
	 type: 'POST',
url: "./get_data.php",
data: '{ "query": "top-rated" }',
success: function( data ) {
	var i;
	for(i=data.bollywood.length-1;i>=0;i--)
	{
var ele= $('<li>').append(
		$('<a>').attr('href','#').append(data.bollywood[i].name)
);

console.log( data.bollywood[i] );
$("ul.dropdown-menu li.nav-header:eq(0)").after(ele);
	}
	
	for(i=data.hollywood.length-1;i>=0;i--)
	{
var ele= $('<li>').append(
		$('<a>').attr('href','#').append(data.hollywood[i].name)
);

console.log( data.hollywood[i] );
$("ul.dropdown-menu li.nav-header:eq(1)").after(ele);
	}
},
dataType: "json",
contentType: "application/json; charset=utf-8"
//contentType: "application/x-www-form-urlencoded; charset=UTF-8"
});

    });
	</script>
    </body>

</html>