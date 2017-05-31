<?php
	$path = $_SERVER['DOCUMENT_ROOT'];
   	$path .= "/controllers/productpaginaController.php";
   	require ($path);
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Veilingen</title>
	<?php 
	include 'html/mainhead.html';
	?>
	<link rel="stylesheet" type="text/css" href="/stylecss/productpagina.css">
</head>

<body>
	<?php 
	include 'html/menu.html';
	include 'html/sidebar.html';
	?>
	
	<div class="pusher">
	<div class="maincontent">
		<div class="ui container">
			<div class="ui raised segment">
				<h1 class="ui dividing niagara header">Lopende Veilingen</h1>
				<form class="ui form" method="post" id="hoofdform">
					<div class="fields">
						<?php 	
						printZoekSysteem();
						?>
					</div>
				</form>
				<div class="ui three column doubling stackable cards grid container">
				<?php
				printProducten();
				?>
				</div>
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