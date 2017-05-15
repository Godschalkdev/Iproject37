<?php
include '../db-util.php';


connectToDatabase();
session_start();

if(isset($_POST['submit']))
{
	checkCredentials();	
}else
{
	session_destroy();
}


function checkCredentials()
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

		$query = $pdo -> prepare("SELECT username, password, firstname, lastname, seller_yes_or_no FROM users where username=? AND password=?");
		$query ->bindParam('ss', $username, PDO::PARAM_STR);
		$query ->bindParam('ss', $password, PDO::PARAM_STR);

		if($query ->execute() == true)
		{
			$query ->bind_result($query, $username, $password, $firstname, $lastname, $seller_yes_or_no);
			$query ->fetch();

			session_regenerate_id();
	            $_SESSION['SESSION_USERNAME'] 			= $query['username'];
	            $_SESSION['SESSION_FIRST_NAME'] 		= $query['firstname'];
	            $_SESSION['SESSION_LAST_NAME']			= $query['lastname'];
	            $_SESSION['SESSION_SELLER_YES_OR_NO'] 	= $query['seller_yes_or_no'];
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
	


