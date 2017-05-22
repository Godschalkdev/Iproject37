<?php 

require('db-util.php');

connectToDatabase();

function printPopulaireVeilingen(){

  $populaireVeilingen = getPopulaireVeilingen();
  foreach($populaireVeilingen as $populaireVeilingen){
$html = <<<MYCONTENT
        <div class="column">
          <div class="ui segment">
            <img src="$populaireVeilingen[filename]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $populaireVeilingen[hoogsteBod]
            </div>
            <div class="ui buttons">
              <button class="ui sand button">Bekijk Veiling</button>
              <div class="or" data-text=""></div>
              <button class="ui button">14:00:45</button>
            </div>
            <h3 class="niagara">$populaireVeilingen[title]</h3>
            <p>$populaireVeilingen[description]</p>
          </div>
        </div>
MYCONTENT;
echo $html; 
 }
}

?>