<?php
	require ('../controllers/eenproductController.php');
	if (empty($_GET['id'])) {
		header('../index.php');
	} else {
		$object = getObject($_GET['id']);
	}

	$_SESSION['user'] = 'traum_bad';

	if (isset($_POST['snelBod'])) {
		$user = hoogsteBodUser($_GET['id']);

		if ($_SESSION['user'] == $user['username']) {
			alert('U kan niet over uwzelf bieden');
		} else {
			doeBod($_GET['id'], $_SESSION['user'],$_POST['snelBod']);
		}
		unset($_POST['snelBod']);
	} 
?>


<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>MijnVeiling</title>
	<?php 
	include 'html/mainhead.html';
	?>
	<link rel="stylesheet" type="text/css" href="/stylecss/eenproduct.css">
</head>

<body>
	<?php 
	include  $_SERVER['DOCUMENT_ROOT']. "/pages/menu.php";
	include 'html/sidebar.html';
	?>
	
	<div class="pusher">
		<div class="maincontent">
			<div class="ui container">
				<div class="ui raised main segment">
					<ui class="ui top right attached label massive" id="timer">
					
					</ui>
					<div class="ui grid">
						<div class="ui eight wide column">
							<h2 class="ui dividing sand header">
								<?php echo "$object[title]"; ?>
							</h2>
							<?php printAllFiles($_GET['id']) ?>
							<div class="ui segment">
								<?php echo "$object[description]"; ?>
							</div>
						</div>
						<div class="ui eight wide column">
							<h1 class="ui center aligned dividing sand header">
								Bieding
							</h1>
							<div class="ui offer segment">
								<h3 class="ui header">Huidig bod: € <?php printHoogsteBod($_GET['id']);	?>
								</h3>
								<h4 class="ui header">Snel bieden</h4>
								<form method="post" action="">
								<?php printBiedKnoppen($_GET['id']); ?>
								</form>
								<form action="" class="ui form">
									<div class="field">
										<label>Bedrag</label>
										<input type="text" name="amount">
										<input type="submit" name="submit" value="Bied" class="ui sand button">
									</div>
								</form>
							</div>
							<?php printBiedingen($_GET['id']); ?>
							</div>
						</div>
					</div>
				<h3 class="ui dividing niagara header">
					Vergelijkbare producten
				</h3>
	        	<div class="ui three column doubling stackable grid container">
					<?php
						printVergelijkbareVeilingen($_GET['id']);
					?>
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