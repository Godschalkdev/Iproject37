<?php
session_start();

if (!$_SESSION['loggedin']) {
	header($_SERVER['DOCUMENT_ROOT'].'pages/login.php')
}

?>