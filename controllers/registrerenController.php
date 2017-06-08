<?php

require_once "../db-util.php";
require_once "mailcontroller.php";
connectToDatabase();
$Errors                         = array();
$requiredFields                 = array('gebruikersnaam', 'voornaam', 'achternaam', 'straat', 'postcode', 'stad', 'land', 'geboortejaar', 'geboortemaand', 'geboortedag', 'emailaddress' ,'wachtwoord','rewachtwoord'  ,'vraag', 'antwoord');


function register_validation()
{
  global $Errors;

  if (isValidForm()) {
    $username         =   $_POST['gebruikersnaam'];
    $firstname        =   $_POST['voornaam'];
    $lastname         =   $_POST['achternaam'];
    $address_field1   =   $_POST['straat'];
    $address_field2   =   $address_field1;
    $ZIP_code         =   $_POST['postcode'];
    $city             =   $_POST['stad'];
    $country          =   $_POST['land'];
    $year             =   $_POST['geboortejaar'];
    $month            =   $_POST['geboortemaand'];
    $day              =   $_POST['geboortedag'];
    $birthday         =   $year."-".$month."-".$day;
    $emailaddress     =   $_POST['emailaddress'];
    $password         =   hashpassword($_POST['wachtwoord']);
    $question_nr      =   $_POST['vraag'];
    $answer           =   $_POST['antwoord'];
    $seller_yes_or_no =   'no';
    $generatedCode    =   md5(rand(0,1000));
    $activation_code  =   $generatedCode;
    $registration_date =  '2016-06-06'; 
    $activated_yes_or_no = 'no';
    if(addNewUser($username, $firstname,$lastname,$address_field1,$address_field2, $ZIP_code, $city, $country, $birthday, $emailaddress, $password, $question_nr, $answer, $seller_yes_or_no,  $activated_yes_or_no, $activation_code)){
      sendUserVerification($emailaddress, $activation_code, $password, $username);
      return "<h1 style=\"color:green;\">Registratie doorgestuurd, verifieer uw account door uw mail te controleren. </h1>";
    }
  }
  else{
    return $Errors;
}
}



function isValidForm()
{
  global $requiredFields;
  return chk_Fields($requiredFields);
}

function chk_Fields($fields){
  $error = false;
  global $Errors;
  foreach($fields AS $fieldname) {
    if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
      array_push($Errors,$fieldname);
      $error                    = true;
    }
    elseif ($fieldname == "gebruikersnaam"){
      if(Chk_UserAlreadyExist_gebruikersnaam($_POST["gebruikersnaam"])){
        array_push($Errors,$fieldname);
        $error                = true;
      }
    }
    elseif ($fieldname == "voornaam"){
      if (!ctype_alpha($_POST["voornaam"])) {
        array_push($Errors,$fieldname);
        $error                = true;
      }
    }
    elseif ($fieldname == "achternaam"){
      if (!ctype_alpha($_POST["achternaam"])) {
        array_push($Errors,$fieldname);
        $error                = true;
      }
    }
    elseif ($fieldname == "emailaddress"){
      if(!filter_var($_POST['emailaddress'], FILTER_VALIDATE_EMAIL) || Chk_UserAlreadyExist_email($_POST['emailaddress'])){ 
        array_push($Errors,$fieldname);
        $error                = true;
      }
    }
    elseif ($fieldname == "wachtwoord"){
      $wachtwoordlengte = 8;
      $pattern = '/^(?=.*\d)(?=.*[A-Za-z])[0-9A-Za-z!@#$%]{8,15}$/';
      if (!preg_match($pattern, $_POST["wachtwoord"]) || strlen($_POST["wachtwoord"]) < $wachtwoordlengte) {
        array_push($Errors,$fieldname);
        $error                = true;
      }
    }
    elseif ($fieldname == "rewachtwoord"){
    if ($_POST["wachtwoord"] != $_POST["rewachtwoord"]){
      array_push($Errors,$fieldname);
        $error                = true;
    }
  }
}
  if($error){
    return false;
  }else{
    return true;
  }
}




function chk_InErrorArray($value){
  global $Errors;
  global $requiredFields;
  if (in_array($value, $Errors))
  {
    switch ($value) {
      case $requiredFields[0]:
      echo "<p style=\"color:red\">Gebruikersnaam is al in gebruik, of niet toegestaan.</p>";
      break;
      case $requiredFields[1]:
      echo "<p style=\"color:red\">Ongeldige voornaam.</p>";
      break;
      case $requiredFields[2]:
      echo "<p style=\"color:red\">Ongeldige achternaam</p>";
      break;
      case $requiredFields[3]:
      echo "<p style=\"color:red\">Ongeldige straat.</p>";
      break;
      case $requiredFields[4]:
      echo "<p style=\"color:red\">Ongeldige postcode.</p>";
      break;
      case $requiredFields[5]:
      echo "<p style=\"color:red\">Ongledige stad.</p>";
      break;
      case $requiredFields[6]:
      echo "<p style=\"color:red\">Ongeldige land.</p>";
      break;
      case $requiredFields[7]:
      echo "<p style=\"color:red\">Geen geldige geboortejaar.</p>";
      break;
      case $requiredFields[8]:
      echo "<p style=\"color:red\">Geen geldige geboortemaand.</p>";
      break;
      case $requiredFields[9]:
      echo "<p style=\"color:red\">Geen geldige geboortedag.</p>";
      break;
      case $requiredFields[10]:
      echo "<p style=\"color:red\">Geen geldig emailadress, of emailadress is al gebruikt</p>";
      break;
      case $requiredFields[11]:
      echo "<p style=\"color:red\">Wachtwoord moet minimaal 8 maximaal 15 tekens zijn,</p>";
      echo "<p style=\"color:red\">minimaal één hoofdletter, cijfer en speciale teken bevatten!</p>";
      break;
      case $requiredFields[12]:
      echo "<p style=\"color:red\">Herhaal wachtwoord komt niet overeen!</p>";
      break;
      case $requiredFields[13]:
      echo "<p style=\"color:red\">geen geldige vraag.</p>";
      break;
      case $requiredFields[14]:
      echo "<p style=\"color:red\">Geen geldige antwoord.</p>";
      break;
    }
  }
}
?>
