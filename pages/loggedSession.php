<?php
session_start();

else if (!$_SESSION['loggedin']){
	header('location: http://www.eenmaalandermaal.dev/pages/login.php');
}  

?>