<?php
require '../db-util.php';

connectToDatabase();


function printFeedback($param) {
	$feedbacks = getFeedback($param);
	if (empty($feedbacks)) {
		echo "<div class=\"ui segment\">$param heeft nog geen feedback ontvangen</div>";
	} else {
		foreach ($feedbacks as $feedback) {
			if ($feedback['buyer_seller'] == 'buyer') {
				$persoon = $feedback['buyer'];
			} else {
				$persoon = $feedback['seller'];
			}
			$html = <<<MYCONTENT
				<div class="ui segment">
					<i class="ui user icon"></i><a href=mijnVeilingen.php?user=$persoon>$persoon</a>  |  $feedback[date]  |  $feedback[title] | $feedback[feedback_type]
					<div class="ui divider"></div>
					$feedback[comment]
				</div>
MYCONTENT;
		if ($persoon == $param) {
			# code...
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
			$titles .= "<option value=\"$object[object_nr]\">$object[title]</option>";
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
      <div class="ui product segment">
        <img src="$filename[filename]" class="ui rounded medium image">
        <div class="ui top left attached label huge">
          €$hoogsteBod[hoogsteBod]
        </div>
          <a class="ui sand button" href="Eenproduct.php?id=$veiling[object_nr]">Bekijk Veiling</a> 
        <h3 class="ui niagara header">$veiling[title]</h3>
MYCONTENT;
	echo $html;
	if (isset($veilingen['bod'])) {
		echo "<h3 class=\"ui niagara header\">$veiling[title]</h3>";
		}
	echo "</div>";
	}
}
?>