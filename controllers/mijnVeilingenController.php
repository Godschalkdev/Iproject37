<?php
require '../db-util.php';

connectToDatabase();



function printFeedback($param) {
$feedbacks = getFeedback($param);

foreach ($feedbacks as $feedback) {
	$html = <<<MYCONTENT
		<div class="ui segment">
			<i class="ui user icon"></i>$feedback[buyer_seller]  |  $feedback[date]  |  $feedback[title] | $feedback[feedback_type]
			<div class="ui divider"></div>
			$feedback[comment]
		</div>
MYCONTENT;
	echo $html;
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