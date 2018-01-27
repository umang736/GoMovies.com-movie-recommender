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
    <title>Gomovies.com</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/prettyPhoto.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->       
    <link rel="shortcut icon" href="images/ico/G-icon.ico">
    <head>
    <style type="text/css">
	.img-responsive{
	height:295px;
		}
    </style>
    </head>
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
                    <li class="active"><a href="index.php">Home</a></li>
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
			  <form class="navbar-form pull-right" name="form1" action="index.php" method="post" >
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
     
     <form class="navbar-form pull-right" action="logout.php">
      <?php echo" Hello, Mr. $name ";?> <button type="submit" class="btn">Logout</button>
      </form>

 <?php
 }
 ?>
                    <li><a href="contact-us.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </header><!--/header-->
    <section id="main-slider" class="no-margin">
        <div class="carousel slide wet-asphalt">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active" style="background-image:url(images/slider/bg1.jpg)">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="carousel-content centered">
                                    <h2 class="animation animated-item-1">Welcome</h2>
                                    <h3 class="animation animated-item-2"><String>Welcome to GoMovies. Let us suggest you a movie that suits you.</strong></h3>
                                      <a class="btn btn-md animation animated-item-3" href="indexsign.php">Sign up Today</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image:url(images/slider/1@2x.jpg)">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="carousel-content center centered">
                                    <h2 class="boxed animation animated-item-1">All Collection of Movies</h2>
                                    <h3 class="boxed animation animated-item-2">Get latest and old collection of movies.</h3>
                                    <br>
                                    <a class="btn btn-md animation animated-item-3" href="#">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image:url(images/slider/genres-1.png);">
                <!--Wallpapersxl%20Don%20Bollywood%20Movies%20178373%201920x1080.jpg-->
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="carousel-content centered">
                                    <h2 class="animation animated-item-1">Planet Movies</h2>
                                    <h3 class="animation animated-item-2">Largest place of movies comprising of hundreds of genre like Fiction ,Horror,Action ,Drama and much more</h3>
                                    <a class="btn btn-md animation animated-item-3" href="gallery.php">Show Gallery</a>
                                </div>
                            </div>
                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="centered">
                                    <div class="embed-container">
                                  
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="icon-angle-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="icon-angle-right"></i>
        </a>
    </section><!--/#main-slider-->

    <section id="services" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-twitter icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Twitter Marketing</h3>
                            <p>Grab your popcorn while watching movies and follw us on twitter @gomovies.com.</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-facebook icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Facebook Marketing</h3>
                            <p>Like our page and get update with the oncomming trends and news.Follw us on Faacebook.</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-google-plus icon-md"></i>
                        </div>
                        <div class="media-body">
                            <h3 class="media-heading">Google Plus Marketing</h3>
                            <p>Just catch your seat and let us suggest you a movie . Get latest updates and newsletters, subscribe to our Google-mail</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
            </div>
        </div>
    </section><!--/#services-->

    <section id="recent-works">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h3>Recommended Movies</h3>
                    <p>Have a glimpse to the latest blockbuster and hit movies.</p>
                    <div class="btn-group">
                        <a class="btn btn-danger" href="#scroller" data-slide="prev"><i class="icon-angle-left"></i></a>
                        <a class="btn btn-danger" href="#scroller" data-slide="next"><i class="icon-angle-right"></i></a>
                    </div>
                    <p class="gap" id="error_dispaly"></p>
                </div>
                <div class="col-md-9">
                    <div id="scroller" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">
                                   
                                </div><!--/.row-->
                            </div><!--/.item-->
                            <div class="item">
                                <div class="row">

                                </div><!--/.row-->
                            </div><!--/.item-->
                        </div>
                    </div><!--/#scroller-->
                </div><!--/.col-md-9-->
            </div><!--/.row-->
        </div>     
    </section><!--/#recent-works-->

    <section id="testimonial" class="alizarin">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="center">
                        <h2>Who we are</h2>
                        <p>GoMovies</p>
                    </div>
                    <div class="gap"></div>
                    <div class="row">
                        <div class="col-md-6">
                            <blockquote>
                                <p>Recommendations</p>
                                
                            </blockquote>
                            
                                <p>GoMovies helps you find movies you will like. Rate movies to build a custom taste profile, then Gomovies recommends other movies for you to watch</p>
                               
                            
                        </div>
                        <div class="col-md-6">
                            <blockquote>
                                <p>Oh yeah, it's that good.</p>
                               
                            </blockquote>
                       
                                <p>Learn more about movies with rich data and  images .Browse movies in our gallery . Explore the database to find a best pick up for you.</p>
                             
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!--/#testimonial-->

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
                        <li><a href="#">Home</a></li>
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Faq</a></li>
                        <li><a href="contact-us.php">Contact Us</a></li>
                        <li><a id="gototop" class="gototop" href="#"><i class="icon-chevron-up"></i></a></li><!--#gototop-->
                    </ul>
                </div>
            </div>
        </div>
    </footer><!--/#footer-->

    <script src="js/jquery-1.11.2.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
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
//contentType: "application/x-www-form-urlencoded; charset=UTF-8"
});
						
$.ajax({
	 type: 'POST',
url: "./hello_gd.php",
success: function( data ) {
	console.log( JSON.stringify(data));
	if (typeof data.new_user !== 'undefined') {
    //new user
	return;
	}
	else if (typeof data.all_rated !== 'undefined') {
    //all rated
	return;
	}
	if(data.mae!=0)
	$('p#error_dispaly').text('Recommending with MAE: '+Math.round(1000*data.mae)/100+'%');
	else if((typeof data.logged_in !== 'undefined')&&(data.logged_in===false))
	$('section#recent-works > div.container > div.row > div.col-md-3 > h3').text('Top Rated Movies');
	var i,first=Math.min(data.recommended.length,3);
	for(i=0;i<first;i++)
	{
		var $img=$('<img>',{class:'img-responsive',src:'images/movies/'+data.recommended[i].mid+'.jpg',alt:''});
		var ele= $('<div>').attr('class', 'col-xs-4').append(
        $('<div>').attr('class', 'portfolio-item').append(
             $('<div>').attr('class', 'item-inner').append(
			 $img
)));
$("<h5></h5>").text(data.recommended[i].name).insertAfter($img);
	
$("div#scroller div.row:eq(0)").append(ele);
	}
	var second=(data.recommended.length<=3?0:3);
		for(i=second;i<data.recommended.length;i++)
	{
		var $img=$('<img>',{class:'img-responsive',src:'images/movies/'+data.recommended[i].mid+'.jpg',alt:''});
		var ele= $('<div>').attr('class', 'col-xs-4').append(
        $('<div>').attr('class', 'portfolio-item').append(
             $('<div>').attr('class', 'item-inner').append(
			 $img
)));
$("<h5></h5>").text(data.recommended[i].name).insertAfter($img);
	
$("div#scroller div.row:eq(1)").append(ele);
	}
},
dataType: "json",
//contentType: "application/x-www-form-urlencoded; charset=UTF-8"
});

/*<div class="col-xs-4">
     <div class="portfolio-item">
        <div class="item-inner">
           <img class="img-responsive" src="images/portfolio/recent/item2.png" alt="">
           <h5>
           Movie name
           </h5>
        </div>
     </div>
  </div>*/

    });
	</script>
</body>
</html>