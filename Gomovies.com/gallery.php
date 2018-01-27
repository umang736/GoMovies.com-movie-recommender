<?php
   session_start();
   require_once('db_conn.php');
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">

    <title>View Movies</title>

    <!-- Bootstrap core CSS -->
    <link href="gallery-css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="gallery-css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="gallery-css/dashboard.css" rel="stylesheet">
    <link href="gallery-css/star-rating.css" media="all" rel="stylesheet" type="text/css" />
	<link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <link rel="shortcut icon" href="images/ico/G-icon.ico">
      
<style>
.width-100{
width:100%;
}
input.btn[type="submit"]{
color:#FFF;background-color:#694489; border-color:#72587F;
}
input.btn[type="submit"]:hover{
background-color:#551A8B; border-color:#2E0854;
}
</style>
  </head>

<body style="background-color:#fff;">

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
                    <li class="active"><a href="gallery.php">Gallery</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Trending Week- Top Movies<i class="icon-angle-down"></i></a>
                        <ul class="dropdown-menu">
                           <li class="nav-header"> Bollywood</li>
                              <!--<li><a href="#">3 idiots</a></li>
                              <li><a href="#">Sholay</a></li>
                              <li><a href="#">Drishyam</a></li>-->
                              <li class="divider"></li>
                              <li class="nav-header">Hollywood</li>
                             <!-- <li><a href="#">Batman-The Dark Knight</a></li>
                              <li><a href="#">Inception</a></li>-->
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
			  <form class="navbar-form pull-right" name="form1" action="gallery.php" method="post" >
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
                    <li><a href="contact-us.php">Contact</a></li>
                </ul>
            </div>
        </div>
    </header><!--/header-->

    <div class="container-fluid">
      <div class="row" ng-app="myApp" ng-controller="moviesCtrl" ng-init="movies=[];">
        
        <div class="col-sm-3 col-md-2 sidebar"  style="margin-bottom:0px;">
          <form role="form">
            <div class="form-group">
              <label class="control-label" for="moviename">Search</label>
              <div class="input-group">
                <span class="input-group-addon"><i class="glyphicon glyphicon-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Enter a movie name" id="moviename" ng-model="moviename"/>
              </div>
            </div>
          </form>
          <select id="sel1" class="form-control" size="15" ng-model="sel1" ng-options="template.mid as template.name for template in movies|filter:{name:moviename}" ng-change="update()">
      	  <option style="display:none;" value="">Select a movie</option>
          </select>
        </div>
        
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <h1 class="page-header">Movie Details</h1>
          <div class="row" style="font-size:20px;">
          <div class="col-sm-3 col-md-3 text-right">Name:</div><div ng-bind="mname" class="col-sm-9 col-md-9" style="font-weight:bold;"></div> 
          </div>

          <h2 class="sub-header">Ratings</h2>
         <form method="post" name="rate_form" role="form" class="form-horizontal" ng-submit="submit()">
            <div class="form-group">
             <label class="control-label col-sm-3  col-md-3" style="margin-top:10px;">Acting:</label>
             <input id="acting" value="0" type="number" class="criteria">
            </div>
            <div class="form-group">
             <label class="control-label col-sm-3  col-md-3" style="margin-top:10px;">Music:</label> 
             <input id="music" value="0" type="number" class="criteria">
            </div>
            <div class="form-group">
             <label class="control-label col-sm-3  col-md-3" style="margin-top:10px;">Sets Design/Backgrounds:</label>  
             <input id="sdb" value="0" type="number" class="criteria">
            </div>
            <div class="form-group">
             <label class="control-label col-sm-3  col-md-3" style="margin-top:10px;">Story:</label>
             <input id="story" value="0" type="number" class="criteria">
            </div>
            <div class="form-group">
             <label class="control-label col-sm-3  col-md-3" style="margin-top:10px;">Overall:</label>
             <input id="overall" value="0" type="number" class="criteria">
            </div>
            <div class="clearfix"></div>

            <div class="form-group" >
            <div class="col-sm-offset-4 col-sm-8 col-md-offset-4 col-md-8">
             <input type="submit" class="btn" name="rate_submit" <?php if(!isset($_SESSION['username'])) echo "disabled";?> 
             value="{{rated_text}}">
             <button type="button" class="btn btn-default" onClick="javascript:undo();">Reset</button>
             </div>
            </div>
          </form>
        </div>
      
      </div>
    </div>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script src="js/jquery-1.11.2.min.js"></script>
   <script src="misc/js-utility.js"></script>
    <script src="gallery-js/angular_1.4.0-rc.2.min.js"></script>
    <script src="gallery-js/bootstrap.min.js"></script>
    <script src="gallery-js/star-rating.js" type="text/javascript"></script>
   
 <script>
 
 var app = angular.module('myApp', []);
app.controller('moviesCtrl', function($scope, $http, $filter, $window) {
	$scope.mname="Movie name comes here";
	$scope.rated_text="Submit";
	
    $http.post("./get_data.php",{query : 'movie_list'})
    .success(function(response) {
		$scope.movies = response; //$scope.sel1=$scope.movies[0].mid;
		});
	$scope.update=function(){
	var obj=$filter('filter')($scope.movies,$scope.sel1,function(d,mov){return d.mid==mov})[0];
	 $scope.mname=obj.name;
	 
	 $http.post("./get_data.php",{query : 'user-movie_details', mid : $scope.sel1})
    .success(function(response) {
		if(response.exists)
		{
			$window.acting=response.acting;$window.music=response.music;$window.sdb=response.sdb;
			$window.story=response.story;$window.overall=response.overall;
		angular.element("#acting").rating('update', response.acting);
		angular.element("#music").rating('update', response.music);
		angular.element("#sdb").rating('update', response.sdb);
		angular.element("#story").rating('update', response.story);
		angular.element("#overall").rating('update', response.overall);
		$window.rated=1;$scope.rated_text="Update";
		}
		else
		{
			$window.acting=$window.music=$window.sdb=$window.story=$window.overall=0;
			$window.rated=0;$scope.rated_text="Submit";
		undo();
		}
		console.log($window.acting+""+$window.music+""+$window.sdb+""+$window.story+""+$window.overall);
		});	
	}
	
});
 </script>  

<script>
var acting,music,sdb,story,overall;
acting=music=sdb=story=overall=0;
var rated=0;
    jQuery(document).ready(function () {
		
         $(".criteria").rating({
            starCaptions:     {
        1: 'One Star',
        2: 'Two Stars',
        3: 'Three Stars',
        4: 'Four Stars',
        5: 'Five Stars',
		6: 'Six Stars',
        7: 'Seven Stars',
        8: 'Eight Stars',
        9: 'Nine Stars',
        10: 'Ten Stars'
    },
            starCaptionClasses:     {
        1: 'label label-danger',
        2: 'label label-danger',
        3: 'label label-warning',
        4: 'label label-warning',
        5: 'label label-info',
        6: 'label label-info',
        7: 'label label-primary',
        8: 'label label-primary',
        9: 'label label-success',
        10: 'label label-success'
    },min:0, max:10, step:1, size:'sm', stars:10, hoverOnClear: false
        });			
			
			$('div.rating-container').addClass("col-sm-9 col-md-9");
			plugin_initialize();
					
$("form[name='rate_form']").submit(function(){
	var mid=$("#sel1").val();//console.log(mid);
	if(mid==""){alert("Please select a movie");}	
	else if(acting>0&&music>0&&sdb>0&&story>0&&overall>0)
	{
	var ratings={};
	mid=mid.match(/\d+/)[0];
	ratings['exists']=rated;
	ratings['mid']=mid;
	ratings['acting']=acting;
	ratings['music']=music;

	ratings['sdb']=sdb;
	ratings['story']=story;
	ratings['overall']=overall;
	console.log(ratings);
	$.post("submit.php",ratings,function(data, status){
		data=data.substring(2);//remove escape character coming automatically from response
		console.log("hello"+data+"world");
		if(data=="done")alert("ratings stored");
		else alert("failed to store ratings");
		},"text");
	}
	else
	alert('Please rate all the criterias');
return false;
});

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