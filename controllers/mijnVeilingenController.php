<?php
require '../db-util.php';

connectToDatabase();



function printFeedback($param) {
	$feedbacks = getFeedback($param);
	if (empty($feedback)) {
		echo "$param heeft nog geen feedback ontvangen";
	} else {
		foreach ($feedbacks as $feedback) {
		$html = <<<MYCONTENT
			<div class="ui segment">
				<i class="ui user icon"></i>$feedback[soort_gebruiker]  |  $feedback[dag]  |  $feedback[commentaar] | $feedback[feedbacksoort]
				<div class="ui divider"></div>
				$feedback[comment]
			</div>
MYCONTENT;
		echo $html;
		}
	}
}

function printFeedbackForm($user, $logger) {
	$object = getFeedbackBeschikbaar($user, $logger);
	//if (!empty(getFeedbackBeschikbaar($user, $logger))) {
		$html = <<<MYCONTENT
		<div class="ui segment">
			<h4 class="ui header">Geef uw feedback over het kopen bij $user</h4>
			<form class="ui form" method="POST" action="">
				<div class="fields">
					<div class="field">
						<select class="ui dropdown" name="titel">
							<option value="">Positief</option>
						</select>
					</div>
					<div class="field">
						<select class="ui dropdown" name="beoordeling">
							<option value="Positief">Positief</option>
							<option value="Neutraal">Neutraal</option>
							<option value="Negatief">Negatief</option>
						</select>
					</div>
				</div>
			</form>
		</div>
MYCONTENT;
	echo $html;
	//}
}


function printVeilingenUser($param) {
	$veilingen = getUserVeilingen($param);
	if (empty($veilingen)) {
		echo "U heeft geen producten aangeboden bij EenmaalAndermaal";
	} else {
		printVeilingen($veilingen);
	}
}

function getStartBedrag($param){
  return startBedragQuery($param);
}

function printGebodenproducten($param) {
	$veilingen = getUserVeilingenBieden($param);
	printVeilingen($veilingen);
}

function printVeilingen($param) {
	foreach ($param as $veiling) {
	   $filenaam = getfile($veiling['voorwerpnummer']);
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
      <div class="ui product segment">
        <img src="$filenaam[filenaam]" class="ui rounded medium image">
        <div class="ui top left attached label huge">
          €$hoogsteBod[hoogsteBod]
        </div>
          <a class="ui sand button" href="Eenproduct.php?id=$veiling[voorwerpnummer]">Bekijk Veiling</a> 
        <h3 class="ui niagara header">$veiling[titel]</h3>
MYCONTENT;
	echo $html;
	if (isset($veilingen['bod'])) {
		echo "<h3 class=\"ui niagara header\">$veiling[titel]</h3>";
		}
	echo "</div>";
	}
}
?>