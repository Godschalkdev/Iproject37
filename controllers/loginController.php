<?php

session_start();
include '../db-util.php';
connectToDatabase();



function processForm()
{


  if (!empty( $_POST["username"]) && !empty( $_POST["password"])) {
    $Chk_LoginDetailsReturn = Chk_LoginDetails($_POST["username"],$_POST["password"]);
    if($Chk_LoginDetailsReturn == true){

      $_SESSION['loggedin'] = 'true';
      $_SESSION['naamuser'] = $Chk_LoginDetailsReturn[0];
      $_SESSION['emailuser'] = $Chk_LoginDetailsReturn[1];
      header("Location: /index.php");
    } else {
       return "<p style=\"color:red;\">De combinatie van gebruikersnaam en wachtwoord is niet geldig.</p>";
     }
   } else{
    return "<p style=\"color:red;\">Vul uw gegevens in</p>";

  }
}


 
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
 		$query ->bindParam('1', $username, PDO::PARAM_STR);
 		$query ->bindParam('2', $password, PDO::PARAM_STR);

 		if($query ->execute() == true)
 		{
 			$query ->bind_result($query, $username, $password);
 			$query ->fetch();

 			session_regenerate_id();
 	            $_SESSION['SESSION_USERNAME'] = $query['username'];
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