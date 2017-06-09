<?php

if (!$_SESSION['loggedin']){
	header('location: ../pages/login.php');
}  
?>