<?php 
  require ('../db-util.php');

  connectToDatabase();

function printAllFiles($param) {
  $files = getAllFiles($param);
  $counter = 1;

  echo "<ul class=\"slider\">";

  foreach ($files as $file) {
    $item = <<<CONTENT
    <li>
        <input type="radio" id="slide$counter" name="slide" checked>
        <label for="slide$counter"></label>
        <img src="$file" alt="Panel $counter">
    </li>
CONTENT;
  echo $item;
  $counter++;
  }
  echo "</ul>";
}

function getTimeObject($param) {
  $object = getObject($param);
}

function printVergelijkbareVeilingen($param){
	$veilingen = getVergelijkbareVeilingen($param);

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
              <a class="ui sand button" href="/pages/Eenproduct.php?id=$veilingen[object_nr]" method="get">Bekijk Veiling</a>
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
  
function printBiedingen($param) {
$boden = getBiedingen($param);

  echo "<div class=\"ui list\">";
foreach ($boden as $bod) {
$html = <<<CONTENT
    <div class="item">
      <i class="ui user icon"></i>
      <div class="content">
        <div class="header">€ $bod[offer_amount]</div>
        <div class="description">$bod[username] ($bod[date]  $bod[time])</div>
      </div>
    </div>
CONTENT;
  echo "$html";
  }
  echo "</div>";
}

function printHoogsteBod($param) {
  $bod = getHoogsteBod($param);
  if (empty($bod['hoogsteBod'])) {
    echo "0,00";
  } else {
    echo "$bod[hoogsteBod]";
  }
}

function printBiedKnoppen($param) {
  $hoogsteBod = getHoogsteBod($param);
  for ($i=0; $i < 3; $i++) { 
    $bedrag = $hoogsteBod['hoogsteBod'];
    $bedrag += 10 + 10*$i;
    echo "<button value=\"$bedrag\" class=\"ui sand button snel\" name=\"snelBod\" onclick=\"this.form.submit()\">€$bedrag</button>";
  }
}

function doeBod($object_nr, $username, $offer) {
  bodQuery($object_nr, $username, $offer);
}
?>