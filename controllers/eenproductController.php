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
        <img src="$file[filenaam]" alt="Panel $counter">
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
          <div class="ui object segment">
            <img src="$filename[filenaam]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
              <a class="ui sand button" href="Eenproduct.php?id=$veiling[voorwerpnummer]">Bekijk Veiling</a> 
            <h3 class="niagara">$veiling[titel]</h3>
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
  $time = substr("$bod[tijdstip]", 0, -8);
$html = <<<CONTENT
    <div class="item">
      <i class="ui user icon"></i>
      <div class="content">
        <div class="header">€ $bod[bodbedrag]</div>
        <div class="description">$bod[gebruikersnaam] ($bod[dag]  $time)</div>
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
    $bedrag = floor($hoogsteBod['hoogsteBod']);
    $bedrag += 10 + 10*$i;
    echo "<button value=\"$bedrag\" class=\"ui sand button snel\" name=\"snelBod\" onclick=\"this.form.submit()\">€$bedrag</button>";
  }
}

function doeBod($object_nr, $username, $offer) {
  bodQuery($object_nr, $offer, $username);
}

function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

function hoogsteBodUser($param) {
  return getHoogsteBod($param);
}

function getStartBedrag($param){
  return startBedragQuery($param);
}

function CHK_bod($bod, $object_nr) {
  $hoogsteBod = getHoogsteBod($object_nr);
  $verhoging = $bod - $hoogsteBod['hoogsteBod'];
  if ($hoogsteBod < 49.99) {
    return minimaalBod($verhoging, 0.50);
  } elseif (49.99 < $hoogsteBod && $hoogsteBod > 499.99) {
    return minimaalBod($verhoging, 1.00);
  } elseif (500.00 < $hoogsteBod && $hoogsteBod > 999.99) {
    return minimaalBod($verhoging, 5.00);
  } elseif (1000.00 < $hoogsteBod && $hoogsteBod > 4999.99) {
    return minimaalBod($verhoging, 10.00);
  } elseif (5000.00 < $hoogsteBod) {
    return minimaalBod($verhoging, 50.00);
  }
}

function minimaalBod($gebruikerverhoging, $minimaalVerhoging) {
  if($gebruikerverhoging < $minimaalVerhoging){
    alert("Uw verhoging is te laag");
    return false;
  } else {
    return true;
  }
}

function getEndDateTimeDiff($param) {
  $object = getObject($param);

  $date = strtotime($object['looptijd_einde_dag']." ".$object['looptijd_einde_tijdstip']);
  return $date - time();
}

function chk_id($param) {
  $object = getObject($param);
  if (empty($object['voorwerpnummer'])) {
    return true;
  }
  return false;
}
?>