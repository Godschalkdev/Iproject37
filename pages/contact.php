<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>Contact</title>
		<link rel="stylesheet" type="text/css" href="/stylecss/extrapaginas.css">

		<?php 
			include 'html/mainhead.html';
		?>
		
	</head>
	
	<body>
	
		<?php 
			include  $_SERVER['DOCUMENT_ROOT']. "/pages/menu.php";
			include 'html/sidebar.html';
		?>
		<div class="pusher">
			<div class="maincontent">
				<div class="ui container">
					<div class = "ui raised segment">
						<h1 class="ui niagara header">Contact</h1>

						<h3 class="ui dividing header"></h3>
						
	        				<h3 class="ui dividing header">Heb je een vraag?</h3>

							<a href="/pages/FAQ.php">Bekijk de veelgestelde vragen.</a>

							<h3 class="ui dividing header">Geen oplossing gevonden? Neem contact op.</h3>

								<p> Eenmaalandermaal B.V. </p>
								<p> Heyendaalseweg 96  </p>
								<p> 2041 ER Nijmegen </p>
								<p> Telefoon: 0303-6694 </p>
								<p> E-mail: eenmaalandermaal@info.nl </p>
									 											
					</div>
				</div>
				</div>
				<?php
					include 'html/footer.html';
				?>
			
		</div>
	
		
		<?php
		include '../scripts/menuscript.html';
		?>
		
	</body>
</html>