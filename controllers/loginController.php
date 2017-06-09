<?php
error_reporting(0);
include '../db-util.php';
connectToDatabase();

$adminUsername = "admin";
$adminPassword = "Iproject37!";

function processForm()
{


  if (!empty( $_POST["username"]) && !empty( $_POST["password"])) {
    $Chk_LoginDetailsReturn = Chk_LoginDetails($_POST["username"],$_POST["password"]);
    if($Chk_LoginDetailsReturn == true){
      session_start();
      $_SESSION['loggedin'] = 'true';
      $_SESSION['naamuser'] = $Chk_LoginDetailsReturn[0];
      $_SESSION['emailuser'] = $Chk_LoginDetailsReturn[1];
      // if(checkUserisVerkoper($_SESSION['naamuser'])){
      //   $_SESSION['verkoper'] = 'true';
      // }
      header("Location: /index.php");
    } else {
       return "<p style=\"color:red;\">De combinatie van gebruikersnaam en wachtwoord is niet geldig.</p>";
     }
   } else{
    return "<p style=\"color:red;\">Vul uw gegevens in</p>";

  }
}

function logout(){

  if(!empty($_POST["logout"])) {
  $_SESSION["user_id"] = "";
  session_destroy();
}
}


 
 function login(){
 {
 global $pdo;
 if(!isset($_POST['username']) || !isset($_POST['password']))
 	{
 		echo "Gebruikers of wachtwoord is niet ingevuld!";
 	}
  // else if( $_POST['username'] == $adminUsername && $_POST['password'] == $adminPassword){
  //   header("./admin.php");
  // }
 	else
 	{
 		$username = $_POST['username'];
 		$password = $_POST['password'];

 		$query = $pdo -> prepare("SELECT gebruikersnaam, wachtwoord FROM gebruiker where gebruikersnaam=? AND wachtwoord=?");
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