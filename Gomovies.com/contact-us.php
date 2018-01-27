<?php
   session_start();
   require_once('db_conn.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Contact Us | Gomovies.com</title>
    <link href="gallery-css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/G-icon.ico">
</head><!--/head-->
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
 if(!(isset($_SESSION['username'])))
 {

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
															 
															header("Location:".$_SERVER['PHP_SELF']);
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
			  <form class="navbar-form pull-right" name="form1" action="contact-us.php" method="post" >
              <input class="span2" type="text" placeholder="Email" name="email" >
              <input class="span2" type="password" placeholder="Password" name="password">
              <button type="submit" class="btn" name="button1">Sign in</button>
              </form>
		    
 <?php
 }
 else
 {
	 $name=$_SESSION['username'];
	 ?>
     
     <form class="navbar-form pull-right" action="logout.php" >
      <?php echo" Hello, Mr. $name ";?> <button type="submit" class="btn">Logout</button>
      </form>

 <?php
 }
 ?>
                    <li class="active"><a href="contact-us.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </header><!--/header-->

    <section id="title" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <h1>Contact Us</h1>
                    <p>Please fill up the below form to contact us.</p>
                </div>
                <div class="col-sm-6">
                    <ul class="breadcrumb pull-right">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Contact Us</li>
                    </ul>
                </div>
            </div>
        </div>
    </section><!--/#title-->    

    <section id="contact-page" class="container">
        <div class="row">
            <div class="col-sm-8">
                <h4>Contact Form</h4>
                <div class="status alert alert-success" style="display: none"></div>
                <form id="main-contact-form" class="contact-form" name="contact-form" method="post" action="sendemail.php" role="form">
                    <div class="row">
                        <div class="col-sm-5">
                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="Name">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="Email address">
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" required placeholder="Subject">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg">Send Message</button>
                            </div>
                        </div>
                        <div class="col-sm-7">
                            <textarea name="message" id="message" required class="form-control" rows="8" placeholder="Message"></textarea>
                        </div>
                    </div>
                </form>
            </div><!--/.col-sm-8-->
            
        </div>
    </section><!--/#contact-page-->

 <section id="bottom" class="wet-asphalt">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-6">
                    <h4>About Us</h4>
                    <p>More specific .</p>
                    <p>We are Gomovies.com . We are recommendation engine and we help you all to get the best movie to your door according to your taste and profile .Find movies that are similar to the ones you like. Tune the matching so that the results best fits you.</p>
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <h4>Company</h4>
                    <div>
                        <ul class="arrow">
                            <li><a href="#">Computer Science Department</a></li>
                            <li><a href="#">MNNIT Allahabad</a></li>
                        </ul>
                    </div>
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <h4>Other Sites</h4>
                    <div>
                        <div class="media">
                            <div class="pull-left">
                              <!---  <img src="images/blog/thumb1.jpg" alt=""> -->
                            </div>
                            <div class="media-body">
                                <span class="media-heading"><a href="http://www.imdb.com/">IMDB.com</a></span>
                                <small class="muted"></small>
                            </div>
                        </div>
                        <div class="media">
                            <div class="pull-left">
                               <!--- <img src="images/blog/thumb2.jpg" alt=""> -->
                            </div>
                            <div class="media-body">
                                <span class="media-heading"><a href="http://www.rottentomatoes.com/">Rotten Tomatoes</a></span>
                                <small class="muted"></small>
                            </div>
                        </div>
                        <div class="media">
                            <div class="pull-left">
                        <!---        <img src="images/blog/thumb3.jpg" alt=""> -->
                            </div>
                            <div class="media-body">
                                <span class="media-heading"><a href="http://grouplens.org/datasets/movielens/">MovieLens</a></span>
                                <small class="muted"></small>
                            </div>
                        </div>
                    </div>  
                </div><!--/.col-md-3-->

                <div class="col-md-3 col-sm-6">
                    <h4>Address</h4>
                    <address>
                        <strong>CSED </strong><br>
                        MNNIT Allahabad<br>
                        Allahabad-211004<br>
                        <abbr title="Phone"></abbr>+91-8795155830
                    </address>
                    <h4>Newsletter</h4>
                    <form role="form">
                        <div class="input-group">
                            <input type="text" class="form-control" autocomplete="off" placeholder="Enter your email">
                            <span class="input-group-btn">
                                <button class="btn btn-danger" type="button">Go!</button>
                            </span>
                        </div>
                    </form>
                </div> <!--/.col-md-3-->
            </div>
        </div>
    </section><!--/#bottom-->

    <footer id="footer" class="midnight-blue">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    &copy;2016 <a target="_blank" href="http://www.mnnit.ac.in/" title="Free Twitter Bootstrap WordPress Themes and HTML templates">MNNIT Allahabad</a>. All Rights Reserved.
                </div>
                <div class="col-sm-6">
                    <ul class="pull-right">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="#">Contact Us</a></li>
                        <li><a id="gototop" class="gototop" href="#"><i class="icon-chevron-up"></i></a></li><!--#gototop-->
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="gallery-js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
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
});

    });
	</script>
</body>
</html>