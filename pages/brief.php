<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Brief</title>
	<?php 
    include 'html/mainhead.html';
    include '../Controllers/activate_sellerController.php';
  	?>
  	<link rel="stylesheet" type="text/css" href="/stylecss/register.css">
</head>

<body>

 	<?php 


    	// // v test for $_SESSION, verwijderen voor eind v
    	// $_SESSION['username'] = "I-Projectgroep 37";
    	// $_SESSION['emailaddress'] = "[email@mail.com]";
    	// // ^
  	?>
<div class="pusher">
  	<div class="maincontent">
 	 	<div class="ui container">
 	 		<div class="ui raised segment">
 	 			<h1 class="ui niagara header">Welkom bij EenmaalAndermaal</h1>
 	 			<p>Na het invoeren van onderstaande code op <a href="www.activeerverkopersaccount.nl">www.activeerverkopersaccount.nl</a> is uw verkopersaccount geactiveerd en kunt u artikelen via onze dienst aanbieden</p>

 	 			<p>
 	 				<h3 class="ui header">
		 	 			<?php 
		 	 				echo(genereerCode());
		 	 			?>
	 	 			</h3>
 	 			</p>

 	 			<p>Veel plezier!</p>
 	 		</div>
  		</div>
  	</div>


  	</div>

  	<?php 
  		include '../scripts/menuscript.html';
  	?>

	<script>
		$('.ui.radio.checkbox').checkbox();
	</script>
</body>
</html>