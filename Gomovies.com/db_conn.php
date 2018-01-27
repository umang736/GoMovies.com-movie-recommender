
<?php
function make_connection(){
$con=mysqli_connect('localhost','root','umang736','rating') or die('connection error1') ;	
return $con;
}
?>