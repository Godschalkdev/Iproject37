<?php

require ('../db-util.php');

connectToDatabase();
$Errors                         = array();
$requiredFields                 = array('title', 'beschrijving', 'startprijs', 'betaalwijze', 'betaalinstructies', 'stad', 'land', 'dagen', 'bezorgkosten', 'bezorginstructies');

function nieuwProduct_validatie()
{
  global $Errors;

  if (isValidForm()) { 
    $title        				=	$_POST['titel'];
    $description        		=	$_POST['beschrijving'];
    $starting_price         	=	$_POST['startprijs'];
    $payment_method  			=	$_POST['betaalwijze'];
    $payment_instructions   	=	$_POST['betaalinstructies'];
    $city        				=	$_POST['stad'];
    $country             		=	$_POST['land'];
    $duration         			=	$_POST['dagen'];
    $duration_start_date        =  	date('Y-m-d');
    $duration_start_time        =  	date("H:i:s");
    $shipping_costs             =	$_POST['bezorgkosten'];
    $shipping_instructions   	=	$_POST['bezorginstructies'];
    $seller     				=	$_SESSION['naamuser'];
    $date 						= 	strtotime('+$duration, day');
    $duration_end_date      	=	date('Y-m-d', $date);
    $duration_end_time        	=	$duration_start_time;
    $auction_closed 			=   0; 
    $filename					=	$_POST['afbeelding[]'];
    $lowest_heading_nr			=	'4352';
    if(addNewObject($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed)){
      return "<h1 style=\"color:green;\">Nieuw product toegevoegd</h1>";
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


function printrubriek($param) {
	$veilingen = getRubriek($param);
	echo "<option value=\"\">- selecteer een rubriek -</option>";
	foreach ($veilingen as $veiling) {
		echo "<option value=\"$veiling[heading_nr]\">$veiling[heading_name]</option>";
	}
}

function printZoekSysteem(){
	
	echo "<div class=\"six wide field\"> <select name=\"hoofd\" class=\"ui search dropdown\" id=\"hoofd\" onchange=\"this.form.submit()\">";
	echo "<option value=\"$_POST[hoofd]\"></option>";
	printrubriek('-1');
	echo "</select></div>";
	
	if (!empty($_POST['hoofd']) && !empty(getRubriek($_POST['hoofd']))) {
	echo "<div class=\"six wide field\"> <select name=\"sub\" class=\"ui search dropdown\" id=\"sub\" onchange=\"this.form.submit()\">";
	echo "<option value=\"$_POST[sub]\"></option>";
	printrubriek($_POST['hoofd']);
	echo "</select></div>";

	} 

	if (!empty($_POST['sub']) && !empty(getRubriek($_POST['sub']))) {
	echo "<div class=\"six wide field\"> <select name=\"rest\" class=\"ui search dropdown\" id=\"rest\" onchange=\"this.form.submit()\">";
	echo "<option value=\"$_POST[rest]\"></option>";
	printrubriek($_POST['sub']);
	echo "</select></div>";

	} 
}

function getheader(){
	

	if(empty($_POST['rest']) && empty(getRubriek($_POST['rest']))){
		$headingnr = $_POST['hoofd'];
}	else if(!empty($_POST['hoofd']) && !empty(getRubriek($_POST['hoofd'])) && !empty($_POST['rest']) && !empty(getRubriek($_POST['rest']))){
	$headingnr = $_POST['rest'];
}
return $headingnr;
}


function addNewObject($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed){

	if(insertNieuwObject($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed)){
		echo 'product toegevoegd'; 
		// $object_nr = getObjectnummer($title, $duration_start_date, $duration_start_time, $seller);

		// if(insertNieuwFiles($object_nr,$filename) && insertNieuwObject_in_Heading($object_nr, $lowest_heading_nr)){

		// 	return true;
		// } else {
		// 	echo 'object niet gevonden'; 
		// }
	} else{ 
		echo 'product niet toegevoegd'; 
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
      case $requiredFields[0]:
      echo "<p style=\"color:red\">verkeerde titel</p>";
      break;
      case $requiredFields[1]:
      echo "<p style=\"color:red\">verkeerde beschrijving</p>";
      break;
      case $requiredFields[2]:
      echo "<p style=\"color:red\">verkeerde startprijs</p>";
      break;
      case $requiredFields[3]:
      echo "<p style=\"color:red\">verkeerde betaalwijze</p>";
      break;
      case $requiredFields[4]:
      echo "<p style=\"color:red\">betaalinstructies klopt niet</p>";
      break;
      case $requiredFields[5]:
      echo "<p style=\"color:red\">verkeerde stad</p>";
      break;
      case $requiredFields[6]:
      echo "<p style=\"color:red\">verkeerde land</p>";
      break;
      case $requiredFields[7]:
      echo "<p style=\"color:red\">verkeerde dagen</p>";
      break;
      case $requiredFields[8]:
      echo "<p style=\"color:red\">geen bezorgkosten</p>";
      break;
      case $requiredFields[9]:
      echo "<p style=\"color:red\">bezorginstructies invullen</p>";
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