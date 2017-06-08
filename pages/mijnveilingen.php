<?php
session_start();
include  $_SERVER['DOCUMENT_ROOT']. "/pages/loggedSession.php";
require $_SERVER['DOCUMENT_ROOT']."/controllers/mijnVeilingenController.php";
$_SESSION['usernaam'] = 'credenzadellacrema';
if (!isset($_GET['user'])) {
	$user = $_SESSION['usernaam'];
} else {
	$user = $_GET['user'];
}
	
	filledFormSubmit();
?>
<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<title>MijnVeiling</title>
		<?php 
			include 'html/mainhead.html';
		?>
		<link rel="stylesheet" type="text/css" href="/stylecss/mijnveilingen.css">
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
						<h1 class="ui niagara header">Mijn EenmaalAndermaal | <?php echo $user; ?></h1>
						<div class="ui top attached tabular menu">
						  <a class="item active" data-tab="first">Mijn Veilingen</a>
						  <a class="item" data-tab="second">Reviews</a>
						  <a class="item" data-tab="third">Biedingen</a>
						</div>
						<div class="ui bottom attached tab segment active" data-tab="first">
							<?php printVeilingenUser($user); ?>
						</div>
						<div class="ui bottom attached tab segment" data-tab="second">
							<?php 
								  printFeedback($user); 
								  printFeedbackForm($user, $_SESSION['usernaam'])
								  ?>
						</div>
						<div class="ui bottom attached tab segment" data-tab="third">
							<?php 
								if ($user == $_SESSION['usernaam']) {
									printGebodenproducten($user);
								} else {
									echo "U heeft geen toegang tot de biedingen van $user";
								}  
							?>
						</div>
					</div>
					<div class="ui divider"></div>
						<a href="../pages/nieuwproduct.php" class="ui sand huge button">
	    				Nieuw product aanbieden
						</a>
					</div>
				</div>
		<?php
		include 'html/footer.html';
		?>
	</div>
		<?php
		include '../scripts/menuscript.html';
		?>
		<script type="text/javascript">
			$('.menu .item')
			  .tab()
			;
		</script>
	</body>
</html>