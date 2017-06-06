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
   $filename = getfile($veiling['object_nr']);
   $hoogsteBod = getHoogsteBod($veiling['object_nr']);
  if (empty($hoogsteBod['hoogsteBod'])) {
    $start = getStartBedrag($veiling['object_nr']);
    if(!empty($start['starting_price'])) {
      $hoogsteBod['hoogsteBod'] = $start['starting_price'];
    } else {
      $hoogsteBod['hoogsteBod'] = "0.00";
    }
  }
$html = <<<MYCONTENT
        <div class="column">
          <div class="ui product segment">
            <img src="$filename[filename]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
              <a class="ui sand button" href="pages/Eenproduct.php?id=$veiling[object_nr]">Bekijk Veiling</a>
            <h3 class="niagara">$veiling[title]</h3>
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