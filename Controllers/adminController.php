<?php

include '../db-util.php';

$username = "admin";
$passw = "Str00pW4f31";


connectToDatabase();
session_start();

if(isset($_POST['submit']))
{
	checkAdmin();	
}else
{
	session_destroy();
}


function checkAdmin()
{
	if(!isset($_POST[username]) && !isset($_POST[password]))
	{
		echo "Gebruikersnaam of wachtwoord is niet ingevuld!";
		session_destroy();
	}

	else if($_POST[username] != $username || $_POST[password] !=$passw)
	{
		echo "Gebruikersnaam of wachtwoord is niet juist!";
	}

	else
	{
		if($_POST[username] == $username && $_POST[password] == $passw)
		{
			session_regenerate_id();
	            $_SESSION['SESSION_USERNAME'] 			= $username;
            session_write_close();
		}
	}
}	
	




