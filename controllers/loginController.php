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
	if(!isset($_POST['username']) || !isset($_POST['password']))
	{
		echo "Gebruikers of wachtwoord is niet ingevuld!";
	}

	else
	{
		$username = clean($_POST['login']);
		$Password = clean($_POST['password']);

		$query = $pdo -> prepare("SELECT username, password, firstname, lastname, seller_yes_or_no FROM users where username=? AND password=?");
		$query ->bind_param('ss', $username, $password);

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
            exit();
		}

		else
		{
			echo "query failed";
			session_destroy();
		}
		
	}
}	
	


