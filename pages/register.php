<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<?php 
		include 'html/registerhead.html';
	?>
</head>

<body>
	<?php 
    	include 'html/menu.html';
    	include 'html/sidebar.html';
  	?>
	
	<div class="ui top container">
		<h1 class="ui top inverted header">
			Register
		</h1>
		<?php
    error_reporting(E_ALL);
    ini_set('display_errors','On');
    echo '<pre>';
    print_r(PDO::getAvailableDrivers());
    echo '</pre>';
    ?>
		<form action="#" method="POST" class="ui form">
				<div class="ui input">
					<div class="ui vertical grid segment">
					<div class="six wide column">
						<label for="voornaam">voornaam</label>
						<input type="text" id="voornaam" placeholder="Hans">
						<label for="achternaam">achternaam</label>
						<input type="text" id="achternaam">
						<label for="geboortedatum">geboortedatum</label>
						<input type="date" id="geboortedatum" placeholder="01/01/1999">	
					</div>
					<div class="six wide column">
						<label for="e-mail">email</label>
						<input type="email" name="e-mail" placeholder="123@voorbeel.com">
						<label for="password">wachtwoord</label>
						<input type="password" name="password">
					</div>
					</div>
					<div class="ui vertical grid segment">
					<div class="six wide column">
						<label for="land">land</label>
						<select name="land">
							<option value="nederland">Nederland</option>
							<option value="duitsland">Duitsland</option>
							<option value="belgië">België</option>
						</select>
						<label for="stad">stad</label>
						<input type="text" name="stad">
						<label for="straat">straat</label>
						<input type="text" name="straat">
						<label for="huisnr">huisnr</label>
						<input type="text" name="huisnr">
						<label for="post">post code</label>
						<input type="text" name="post">
					</div>
					</div>
					<div class="ui vertical segment">
						<label for="vraag">Vraag</label>
						<select name="vraag">
							<option value="huisdier">Wat was de naam van uw eerste huisdier?</option>
							<option value="bijnaam">Wat was vroeger uw bijnaam?</option>
						</select>
						<label for="awnser">awnser</label>
						<input type="text" name="awnser">
						<label for="seller">seller?</label>
						<input type="radio">
					</div>
				</div>
			</div>
		</form>
	</div>
	<?php
		include 'html/footer.html';
		include '../scripts/menuscript.html';
	?>
</body>
</html>