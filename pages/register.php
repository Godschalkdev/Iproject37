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
		<form action="#" method="POST">
			<label for="firstname">firstname</label>
			<input type="text" id="firstname">
			<label for="lastname">lastname</label>
			<label for="geboortedatum">geboortedatum</label>
			<label for="email">email</label>
			<label for="re-email">herhaal email</label>
			<label for="password">wachtwoord</label>
			<label for="re-password">herhaal wachtwoord</label>
			<label for="land">land</label>
			<label for="stad">stad</label>
			<label for="straat">straat</label>
			<label for="huisnr">huisnr</label>
			<label for="post code">post code</label>
			<label for="question">security question</label>
			<label for="awnser">awnser</label>
			<label for="firstname">firstname</label>
			<label for="seller">seller?</label>
		</form>
	</div>

</body>
</html>