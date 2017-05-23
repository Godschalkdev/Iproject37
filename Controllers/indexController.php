<?php 

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
  }
  
  foreach($veilingen as $veilingen){
   $filename = getfile($veilingen['object_nr']);
   $hoogsteBod = getHoogsteBod($veilingen['object_nr']);
$html = <<<MYCONTENT
        <div class="column">
          <div class="ui segment">
            <img src="$filename[filename]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
            <div class="ui buttons">
              <button class="ui sand button">Bekijk Veiling</button>
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