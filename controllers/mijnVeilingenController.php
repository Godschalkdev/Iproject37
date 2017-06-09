<?php

require '../db-util.php';
connectToDatabase();

function printFeedback($param) {
	$feedbacks = getFeedback($param);
	if (empty($feedbacks)) {
		echo "<div class=\"ui segment\">$param heeft nog geen feedback ontvangen</div>";
	} else {
		foreach ($feedbacks as $feedback) {
			if ($feedback['soort_gebruiker'] == 'koper') {
				$persoon = $feedback['koper'];
			} else {
				$persoon = $feedback['verkoper'];
			}
		$html = <<<MYCONTENT
			<div class="ui segment">
				<i class="ui user icon"></i>$feedback[soort_gebruiker]  |  $feedback[dag]  |  $feedback[commentaar] | $feedback[feedbacksoort]
				<div class="ui divider"></div>
				$feedback[commentaar]
			</div>
MYCONTENT;
		if ($persoon == $param) {
		} else {
			echo $html;
		}
		}
	}
}
function printFeedbackForm($user, $logger) {
	$objecten = getFeedbackBeschikbaar($user, $logger);
	$titles = "";
	if (!empty($objecten)) {
		foreach ($objecten as $object) {
			$titles .= "<option value=\"$object[voorwerpnummer]\">$object[titel]</option>";
		}
		$html = <<<MYCONTENT
		<div class="ui segment">
			<h4 class="ui header">Geef uw feedback over het handelen met $user</h4>
			<form class="ui form" method="POST" action="">
				<div class="fields">
					<div class="field">
						<select class="ui dropdown" name="objectnr">
							<option value="">- Selecteer Voorwerp -</option>
							$titles
						</select>
					</div>
					<div class="field">
						<select class="ui dropdown" name="beoordeling">
							<option value="positive">Positief</option>
							<option value="neutral">Neutraal</option>
							<option value="negative">Negatief</option>
						</select>
					</div>
				</div>
				<div class="field">
					<input type="text" rows="2" name="comment">
					</input>
				</div>
				<input type="submit" class="ui sand button" value="Verstuur"></input>
			</form>
		</div>
MYCONTENT;
	echo $html;
	}
}

function filledFormSubmit() {
	if (isset($_POST['objectnr']) && isset($_POST['beoordeling'])) {
		$buyer_seller = buyerOfSeller($_SESSION['usernaam'], $_POST['objectnr']);
		insertFeedback($_POST['objectnr'], $_POST['beoordeling'], $_POST['comment'], $buyer_seller);
	}
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