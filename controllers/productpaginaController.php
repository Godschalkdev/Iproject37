<?php

require('../db-util.php');

connectToDatabase();

function printrubriek($param) {
	$veilingen = getRubriek($param);
	echo "<option value=\"\">- selecteer een rubriek -</option>";
	foreach ($veilingen as $veiling) {
		echo "<option value=\"$veiling[heading_nr]\">$veiling[heading_name]</option>";
	}
}


function printZoekSysteem(){
	
	echo "<div class=\"six wide field\"> <select name=\"hoofd\" class=\"ui search dropdown\" id=\"hoofd\" onchange=\"this.form.submit()\">";
	echo "<option value=\"$_POST[hoofd]\"></option>";
	printrubriek('-1');
	echo "</select></div>";
	
	if (!empty($_POST['hoofd']) && !empty(getRubriek($_POST['hoofd']))) {
	echo "<div class=\"six wide field\"> <select name=\"sub\" class=\"ui search dropdown\" id=\"sub\" onchange=\"this.form.submit()\">";
	echo "<option value=\"$_POST[sub]\"></option>";
	printrubriek($_POST['hoofd']);
	echo "</select></div>";
	} 

	if (!empty($_POST['sub']) && !empty(getRubriek($_POST['sub']))) {
	echo "<div class=\"six wide field\"> <select name=\"rest\" class=\"ui search dropdown\" id=\"rest\" onchange=\"this.form.submit()\">";
	echo "<option value=\"$_POST[rest]\"></option>";
	printrubriek($_POST['sub']);
	echo "</select></div>";
	} 
	echo "<a href=\"html/resetfilter.php\" class=\"ui large sand button\"/>Reset</a>";
}

function printProducten() {
	if (!empty($_POST['hoofd']) && empty(getRubriek($_POST['hoofd']))) {
		$veilingen = getProductsByHeader($_POST['hoofd']);
}
 	if (!empty($_POST['sub']) && empty(getRubriek($_POST['sub']))) {
		$veilingen = getProductsByHeader($_POST['sub']);
}

	if (!empty($_POST['rest']) && empty(getRubriek($_POST['rest']))) {
		$veilingen = getProductsByHeader($_POST['rest']);
}

	if (!empty($veilingen)){
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
              <a class="ui sand button" href="/pages/Eenproduct.php?id=$veiling[object_nr]" method="get">Bekijk Veiling</a>
            <h3 class="niagara">$veiling[title]</h3>
          </div>
        </div>
MYCONTENT;
	echo $html; 
		}
	} 
}

function getStartBedrag($param){
  return startBedragQuery($param);
}
?>