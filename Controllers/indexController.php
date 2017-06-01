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
          <div class="ui product segment">
            <img src="$filename[filename]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
              <a class="ui sand button" href="pages/Eenproduct.php?id=$veilingen[object_nr]">Bekijk Veiling</a>
            <h3 class="niagara">$veilingen[title]</h3>
          </div>
        </div>
MYCONTENT;
echo $html; 
 }
}

?>