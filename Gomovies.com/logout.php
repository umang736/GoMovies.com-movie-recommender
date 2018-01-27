<?php
 session_start();
 $http_refer=$_SERVER['HTTP_REFERER'];
 echo $http_refer;
 session_destroy();
 header('Location:index.php');
?>