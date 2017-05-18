<?php
include '../db-util.php';


connectToDatabase();
session_start();



function login(){
{
global $pdo;
if(!isset($_POST['username']) || !isset($_POST['password']))
	{
		echo "Gebruikers of wachtwoord is niet ingevuld!";
	}

	else
	{
		$username = $_POST['username'];
		$password = $_POST['password'];

		$query = $pdo -> prepare("SELECT username, password FROM users where username=? AND password=?");
		$query ->bindParam('ss', $username, PDO::PARAM_STR);
		$query ->bindParam('ss', $password, PDO::PARAM_STR);

		if($query ->execute() == true)
		{
			$query ->bind_result($query, $username, $password);
			$query ->fetch();

			session_regenerate_id();
	            $_SESSION['SESSION_USERNAME'] 			= $query['username'];
            session_write_close();

            if(session_status() == PHP_SESSION_NONE)
        	{
        		echo "failed";
        	}
        	else if(session_status() == PHP_SESSION_ACTIVE)
        	{
        		echo "succes";
        	}
        	header("./index.php");
		}

		else
		{
			echo "query failed";
			session_destroy();
		}
		
	}
}	
	
}

?>