<?php
error_reporting(0);
include '../db-util.php';
connectToDatabase();


function processForm()
{


  if (!empty( $_POST["username"]) && !empty( $_POST["password"])) {
    $Chk_LoginDetailsReturn = Chk_LoginDetails($_POST["username"],$_POST["password"]);
    if($Chk_LoginDetailsReturn == true){
      session_start();
      $_SESSION['loggedin'] = 'true';
      $_SESSION['naamuser'] = $Chk_LoginDetailsReturn[0];
      $_SESSION['emailuser'] = $Chk_LoginDetailsReturn[1];

      if($Chk_LoginDetailsReturn[0] == "admin"){
      $_SESSION['administrator'] = 'true';
          header("Location: /pages/admin.php");
            }
            elseif($Chk_LoginDetailsReturn[0] != "admin"){
      header("Location: /index.php");
    }
    } else {
       return "<p style=\"color:red;\">De combinatie van gebruikersnaam en wachtwoord is niet geldig.</p>";
     }
   } else{
    return "<p style=\"color:red;\">Vul uw gegevens in</p>";

  }
}


function logout(){

  if(!empty($_POST["logout"])) {
  unset($_SESSION);
  session_destroy();
  }
}
?>