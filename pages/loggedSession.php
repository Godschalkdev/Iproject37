<?php
session_start();

if (!$_SESSION['loggedin']){
	header('location: ../pages/login.php');
}  

?>