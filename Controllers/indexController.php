<?php 
session_start();
require('db-util.php');

connectToDatabase();

function printIndexVeilingen($param){

  switch ($param) {
    case 'populair':
      $veilingen = getPopulaireVeilingen();
      break;
    case 'nieuw':
      $veilingen = getNieuweVeilingen();
      break;
    case 'bijzonder':
      $veilingen = getBijzondereVeilingen();
      break;
    case 'koopje':
      $veilingen = getKoopjes();
      break;
  }
  
  foreach($veilingen as $veilingen){
   $filename = getfile($veilingen['object_nr']);
   $hoogsteBod = getHoogsteBod($veilingen['object_nr']);
$html = <<<MYCONTENT
        <div class="column">
          <div class="ui object segment">
            <img src="$filename[filename]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
            <div class="ui buttons">
              <a class="ui sand button" href="/pages/Eenproduct.php">Bekijk Veiling</a>
              <div class="or" data-text=""></div>
              <button class="ui button">14:00:45</button>
            </div>
            <h3 class="niagara">$veilingen[title]</h3>
          </div>
        </div>
MYCONTENT;
echo $html; 
 }
}

?>