<?php
session_start();

if (!$_SESSION['loggedin']){
	header('location: http://www.eenmaalandermaal.dev/pages/login.php');
}


?>