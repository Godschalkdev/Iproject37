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
    case 'koopje':
      $veilingen = getKoopjes();
      break;
  }
  
  foreach($veilingen as $veiling){
   $filename = getfile($veiling['voorwerpnummer']);
   $hoogsteBod = getHoogsteBod($veiling['voorwerpnummer']);
  if (empty($hoogsteBod['hoogsteBod'])) {
    $start = getStartBedrag($veiling['voorwerpnummer']);
    if(!empty($start['startprijs'])) {
      $hoogsteBod['hoogsteBod'] = $start['startprijs'];
    } else {
      $hoogsteBod['hoogsteBod'] = "0.00";
    }
  }
$html = <<<MYCONTENT
        <div class="column">
          <div class="ui product segment">
            <img src="$filename[filenaam]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
              <a class="ui sand button" href="pages/Eenproduct.php?id=$veiling[voorwerpnummer]">Bekijk Veiling</a>
            <h3 class="niagara">$veiling[titel]</h3>
          </div>
        </div>
MYCONTENT;
echo $html; 
 }
}

function getStartBedrag($param){
  return startBedragQuery($param);
}
?>