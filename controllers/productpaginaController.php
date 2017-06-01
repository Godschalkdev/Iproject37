<?php

require('../db-util.php');

connectToDatabase();

function printrubriek($param) {
	$rows = getRubriek($param);
	echo "<option value=\"\">- selecteer een rubriek -</option>";
	foreach ($rows as $row) {
		echo "<option value=\"$row[heading_nr]\">$row[heading_name]</option>";
	}
}

function printProducts($param) {
	$rows = getProductsByHeader($param);

	foreach($rows as $veiling){
   $filename = getfile($veiling['object_nr']);
   $hoogsteBod = getHoogsteBod($veiling['object_nr']);
$html = <<<MYCONTENT
        <div class="column">
          <div class="ui segment">
            <img src="$filename[filename]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
            <div class="ui buttons">
              <button class="ui sand button">Bekijk Veiling</button>
              <div class="or" data-text=""></div>
              <button class="ui button">14:00:45</button>
            </div>
            <h3 class="niagara">$veiling[title]</h3>
          </div>
        </div>
MYCONTENT;
echo $html; 
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
		$rows = getProductsByHeader($_POST['hoofd']);
}
 	if (!empty($_POST['sub']) && empty(getRubriek($_POST['sub']))) {
		$rows = getProductsByHeader($_POST['sub']);
}

	if (!empty($_POST['rest']) && empty(getRubriek($_POST['rest']))) {
		$rows = getProductsByHeader($_POST['rest']);
}

	if (!empty($rows)){
		foreach ($rows as $row) {
			$filename = getfile($row['object_nr']);
   			if (!is_null(getHoogsteBod($row['object_nr']))) {
   				$hoogsteBod = getHoogsteBod($row['object_nr']);
   			} else {
   				$hoogsteBod = $row['starting_price'];
   			}
	
$html = <<<MYCONTENT
        <div class="column">
          <div class="ui product segment">
            <img src="$filename[filename]" class="ui rounded medium image">
            <div class="ui top left attached label huge">
              € $hoogsteBod[hoogsteBod]
            </div>
            <div class="ui buttons">
              <button class="ui sand button">Bekijk Veiling</button>
              <div class="or" data-text=""></div>
              <button class="ui button">14:00:45</button>
            </div>
            <h3 class="niagara">$row[title]</h3>
          </div>
        </div>
MYCONTENT;
	echo $html;
		}
	} 
}

?>