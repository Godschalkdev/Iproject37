<?php
session_start();
require_once "../db-util.php";
connectToDatabase();
$Errors                         = array();
$requiredFields                 = array('gebruikersnaam', 'voornaam', 'achternaam', 'straat', 'postcode', 'stad', 'land', 'geboortejaar', 'geboortemaand', 'geboortedag', 'wachtwoord', 'vraag', 'antwoord');


function register_validation()
{
  global $Errors;
  if (isValidForm()) {
    $username         =   $_POST['gebruikersnaam'];
    $firstname        =   $_POST['voornaam'];
    $lastname         =   $_POST['achternaam'];
    $address_field1   =   $_POST['straat'];
    $address_field2   =   $_POST[''];
    $ZIP_code         =   $_POST['postcode'];
    $city             =   $_POST['stad'];
    $country          =   $_POST['land'];
    $year             =   $_POST['geboortejaar'];
    $month            =   $_POST['geboortemaand'];
    $day              =   $_POST['geboortedag'];
    $birthday         =   $year."-".$month."-".$day;
    $emailaddress     =   "test@hotmail.nl";
    $password         =   $_POST['wachtwoord'];
    $question_nr      =   $_POST['vraag'];
    $answer           =   $_POST['antwoord'];
    $seller_yes_or_no =   "no";
    if(addNewUser($username, $firstname,$lastname,$address_field1,$address_field2, $ZIP_code, $city, $country, $birthday, $emailaddress, $password, $question_nr, $answer, $seller_yes_or_no)){
      return "<p style=\"color:green;\">Uw account is aangemaakt, u kunt inloggen via de login pagina.</p>";
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
  $error                        = false;
  global $Errors;
  foreach($fields AS $fieldname) {
    if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
      array_push($Errors,$fieldname);
      $error                    = true;
    }
    elseif ($fieldname == "gebruikersnaam"){
      if(Chk_UserAlreadyExist($_POST['gebruikersnaam'])){
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


//Credits Rene Terstegen van Stackoverflow: http://stackoverflow.com/questions/20983339/validate-iban-php
function checkIBAN($iban)
{
  $iban                       = strtolower(str_replace(' ','',$iban));
  $Countries                  = array('al'=>28,'ad'=>24,'at'=>20,'az'=>28,'bh'=>22,'be'=>16,'ba'=>20,'br'=>29,'bg'=>22,'cr'=>21,'hr'=>21,'cy'=>28,'cz'=>24,'dk'=>18,'do'=>28,'ee'=>20,'fo'=>18,'fi'=>18,'fr'=>27,'ge'=>22,'de'=>22,'gi'=>23,'gr'=>27,'gl'=>18,'gt'=>28,'hu'=>28,'is'=>26,'ie'=>22,'il'=>23,'it'=>27,'jo'=>30,'kz'=>20,'kw'=>30,'lv'=>21,'lb'=>28,'li'=>21,'lt'=>20,'lu'=>20,'mk'=>19,'mt'=>31,'mr'=>27,'mu'=>30,'mc'=>27,'md'=>24,'me'=>22,'nl'=>18,'no'=>15,'pk'=>24,'ps'=>29,'pl'=>28,'pt'=>25,'qa'=>29,'ro'=>24,'sm'=>27,'sa'=>24,'rs'=>22,'sk'=>24,'si'=>19,'es'=>24,'se'=>24,'ch'=>21,'tn'=>24,'tr'=>26,'ae'=>23,'gb'=>22,'vg'=>24);
  $Chars                      = array('a'=>10,'b'=>11,'c'=>12,'d'=>13,'e'=>14,'f'=>15,'g'=>16,'h'=>17,'i'=>18,'j'=>19,'k'=>20,'l'=>21,'m'=>22,'n'=>23,'o'=>24,'p'=>25,'q'=>26,'r'=>27,'s'=>28,'t'=>29,'u'=>30,'v'=>31,'w'=>32,'x'=>33,'y'=>34,'z'=>35);

  if(strlen($iban) == $Countries[substr($iban,0,2)]){

    $MovedChar                = substr($iban, 4).substr($iban,0,4);
    $MovedCharArray           = str_split($MovedChar);
    $NewString                = "";

    foreach($MovedCharArray AS $key => $value){
      if(!is_numeric($MovedCharArray[$key])){
        $MovedCharArray[$key] = $Chars[$MovedCharArray[$key]];
      }
      $NewString .= $MovedCharArray[$key];
    }

    if(bcmod($NewString, '97') == 1)
    {
      return TRUE;
    }
    else{
      return FALSE;
    }
  }
  else{
    return FALSE;
  }
}

function chk_InErrorArray($value){
  global $Errors;
  global $requiredFields;
  if (in_array($value, $Errors))
  {
    switch ($value) {
      case $requiredFields[0]:
      echo "<p style=\"color:red\">Ongeldige Abbonoment.</p>";
      break;
      case $requiredFields[1]:
      echo "<p style=\"color:red\">Ongeldige Naam.</p>";
      break;
      case $requiredFields[2]:
      echo "<p style=\"color:red\">Ongeldige emailaddress/Al in gebruik.</p>";
      break;
      case $requiredFields[3]:
      echo "<p style=\"color:red\">Ongeldige geboortedatum.</p>";
      break;
      case $requiredFields[4]:
      echo "<p style=\"color:red\">Ongeldige IBAN Nummer.</p>";
      break;
      case $requiredFields[5]:
      echo "<p style=\"color:red\">Ongeldige BIC Nummer.</p>";
      break;
      case $requiredFields[6]:
      echo "<p style=\"color:red\">Ongeldige BIC Nummer.</p>";
      break;
    }
  }
}
?>