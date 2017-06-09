<?php

require ('../db-util.php');

connectToDatabase();
$Errors                         = array();
$requiredFields                 = array('titel', 'beschrijving', 'startprijs', 'betaalwijze', 'betaalinstructies', 'stad', 'land', 'dagen', 'bezorgkosten', 'bezorginstructies');

function nieuwProduct_validatie($param)
{
  global $Errors;
  

  if (isValidForm()) { 
    $title        				  =	       $_POST['titel'];
    $description        		=	       $_POST['beschrijving'];
    $starting_price         =	       $_POST['startprijs'];
    $payment_method  			  =	       $_POST['betaalwijze'];
    $payment_instructions   =	       $_POST['betaalinstructies']; 
    $city        				    =	       $_POST['stad'];
    $country             		=	       $_POST['land'];
    $duration         			=	       $_POST['dagen'];
    $duration_start_date    =  	     date('Y-m-d');
    $duration_start_time    =  	     date("H:i:s");
    $shipping_costs         =	       $_POST['bezorgkosten'];
    $shipping_instructions  =	       $_POST['bezorginstructies'];
    $seller     				    =	       $_SESSION['naamuser'];
    $date 						      = 	     strtotime("+".$duration." days");
    $duration_end_date      =	       date('Y-m-d', $date);
    $duration_end_time      =	       $duration_start_time;
    $auction_closed 			  =        0; 
    $lowest_heading_nr      =        $param;
  if(addNewObject($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed)){
    
    $object_nr = getObjectnummer($title, $duration_start_date, $duration_start_time, $seller);
    $filename = uploadFile($object_nr['voorwerpnummer']);
    insertNieuwObject_in_Heading($object_nr['voorwerpnummer'], $lowest_heading_nr);
        if(!empty(getObject($object_nr['voorwerpnummer']))){


      return "<h1 style=\"color:green;\">Nieuw product toegevoegd".getRubriekNummer()."</h1>";

    }
    }
  }
  else{
    return $Errors;
}
}


function uploadFile($object){
$valid_file = true;
$max_file_size = 2024000;
$valid_formats = array("jpg","jpeg","JPG", "png", "gif", "bmp");

for($i=0; $i < 4; $i++){

if(isset($_FILES['files']['name'][$i]))
{
  

  if(!$_FILES['files']['error'][$i])
  {
    
    $new_file_name = strtolower($_FILES['files']['name'][$i]);
    $ext = pathinfo($_FILES['files']['name'][$i], PATHINFO_EXTENSION); 

    if($_FILES['files']['size'][$i] > $max_file_size )
    {
      $valid_file = false;
      $msg = 'Oops!  Je bestand is te groot';
    }

    elseif(!in_array($ext, $valid_formats)){
      $valid_file = false; 
      $msg = 'Oops! geen geldige bestand';
    }
    
    //if the file has passed the test
    elseif($valid_file)
    { 
      
      
      
      $uniq_file_name = getGeneratedFilename($_FILES['files']['name'][$i]);
      //move it to where we want it to be
      move_uploaded_file($_FILES['files']['tmp_name'][$i], "..\uploads\ ".$uniq_file_name);
      insertNieuwFile($object, $uniq_file_name);
      $msg = 'WAT MOOI!  HET IS GELUKT.';
      
      
    }
  
  //if there is an error...
  }
    else
  {
    //set that to be the returned msg
    $msg = 'Ooops!  DAT GING FOUT:  '.$_FILES['files']['error'][$i];
  }

}
}

}


function getGeneratedFilename($name){
$uniq = base_convert(uniqid(), 16, 10);
$newName = $uniq."_".$name;
return $newName;
}

function printrubriek($param) {
  $veilingen = getRubriek($param);
  echo "<option value=\"\">- selecteer een rubriek -</option>";
  foreach ($veilingen as $veiling) {
    echo "<option value=\"$veiling[rubrieknummer]\">$veiling[rubrieknaam]</option>";
  }
}

function printZoekSysteem(){
  
  echo "<div class=\"six wide field\"> <select name=\"hoofd\" class=\"ui search dropdown\" id=\"hoofd\" onchange=\"this.form.submit()\">";
  echo "<option value=\"$_GET[hoofd]\"></option>";
  printrubriek('-1');
  echo "</select></div>";
  
  if (!empty($_GET['hoofd']) && !empty(getRubriek($_GET['hoofd']))) {
  echo "<div class=\"six wide field\"> <select name=\"sub\" class=\"ui search dropdown\" id=\"sub\" onchange=\"this.form.submit()\">";
  echo "<option value=\"$_GET[sub]\"></option>";
  printrubriek($_GET['hoofd']);
  echo "</select></div>";
  } 

  if (!empty($_GET['sub']) && !empty(getRubriek($_GET['sub']))) {
  echo "<div class=\"six wide field\"> <select name=\"rest\" class=\"ui search dropdown\" id=\"rest\" onchange=\"this.form.submit()\">";
  echo "<option value=\"$_GET[rest]\"></option>";
  printrubriek($_GET['sub']);
  echo "</select></div>";
  } 
}

function getRubriekNummer() {
  if (!empty($_GET['rest'])) {
    return $_GET['rest'];
}
  elseif(!empty($_GET['sub'])) {
    return $_GET['sub'];
  }
}

function isValidForm()
{
  global $requiredFields;
  return chk_Fields($requiredFields);
}



function getheader(){
	

	if(empty($_GET['rest']) && empty(getRubriek($_GET['rest']))){
		$headingnr = $_GET['hoofd'];
}	else if(!empty($_GET['hoofd']) && !empty(getRubriek($_GET['hoofd'])) && !empty($_GET['rest']) && !empty(getRubriek($_GET['rest']))){
	$headingnr = $_GET['rest'];
}
return $headingnr;
}


function addNewObject($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed){

	if(insertNieuwObject($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed)){
		return true;
		// $object_nr = getObjectnummer($title, $duration_start_date, $duration_start_time, $seller);

		// if(insertNieuwFiles($object_nr,$filename) && insertNieuwObject_in_Heading($object_nr, $lowest_heading_nr)){

		// 	return true;
		// } else {
		// 	echo 'object niet gevonden'; 
		// }
	} else{ 
		return false;
	}
}



function chk_Fields($fields){
  $error = false;
  global $Errors;
  foreach($fields AS $fieldname) {
    if(!isset($_POST[$fieldname]) || empty($_POST[$fieldname])) {
      array_push($Errors,$fieldname);
      $error                    = true;
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
      case $requiredFields['titel']:
      echo "<p style=\"color:red\">verkeerde titel</p>";
      break;
      case $requiredFields['beschrijving']:
      echo "<p style=\"color:red\">verkeerde beschrijving</p>";
      break;
      case $requiredFields['startprijs']:
      echo "<p style=\"color:red\">verkeerde startprijs</p>";
      break;
      case $requiredFields['betaalwijze']:
      echo "<p style=\"color:red\">verkeerde betaalwijze</p>";
      break;
      case $requiredFields['betaalinstructies']:
      echo "<p style=\"color:red\">betaalinstructies klopt niet</p>";
      break;
      case $requiredFields['stad']:
      echo "<p style=\"color:red\">verkeerde stad</p>";
      break;
      case $requiredFields['land']:
      echo "<p style=\"color:red\">verkeerde land</p>";
      break;
      case $requiredFields['dagen']:
      echo "<p style=\"color:red\">verkeerde dagen</p>";
      break;
      case $requiredFields['bezorgkosten']:
      echo "<p style=\"color:red\">geen bezorgkosten</p>";
      break;
      case $requiredFields['bezorginstructies']:
      echo "<p style=\"color:red\">bezorginstructies invullen</p>";
      break;
      case $requiredFields['files']:
      echo "<p style=\"color:red\"> afbeelding is leeg invullen</p>";
      break;
    }
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







?>