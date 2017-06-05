<?php
session_start();


include  $_SERVER['DOCUMENT_ROOT']. "/pages/loggedSession.php";
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
						<h1 class="ui niagara header">Mijn Veilingen</h1>
						<div class="ui three column doubling stackable grid container">
							<div class="column">
								<div class="ui segment">
									<img src="../images/kast.jpg" class="ui rounded medium image">
									<div class="ui top left attached label large">
										$ 400,-
									</div>
									<div class="ui buttons">
										<button class="ui sand button">Bekijk Veiling</button>
										<div class="or" data-text=""></div>
										<button class="ui button">14:00:45</button>
									</div>
									<h3 class="niagara">Xbox One</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae maiores, aliquam animi veritatis? Numquam facere sunt maiores harum quae dolores obcaecati neque cum, tempora laudantium, delectus a sapiente distinctio illum.</p>
								</div>
							</div>
							<div class="column">
								<div class="ui segment">
									<img src="../images/xbox.jpg" class="ui rounded medium image">
									<div class="ui top left attached label large">
										$ 400,-
									</div>
									<div class="ui buttons">
										<button class="ui sand button">Bekijk Veiling</button>
										<div class="or" data-text=""></div>
										<button class="ui button">14:00:45</button>
									</div>
									<h3 class="niagara">Xbox One</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae maiores, aliquam animi veritatis? Numquam facere sunt maiores harum quae dolores obcaecati neque cum, tempora laudantium, delectus a sapiente distinctio illum.</p>
								</div>
							</div>
							<div class="column">
								<div class="ui segment">
									<img src="../images/vazen.jpg" class="ui rounded medium image">
									<div class="ui top left attached label large">
										$ 400,-
									</div>
									<div class="ui buttons">
										<button class="ui sand button">Bekijk Veiling</button>
										<div class="or" data-text=""></div>
										<button class="ui button">14:00:45</button>
									</div>
									<h3 class="niagara">Xbox One</h3>
									<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Repudiandae maiores, aliquam animi veritatis? Numquam facere sunt maiores harum quae dolores obcaecati neque cum, tempora laudantium, delectus a sapiente distinctio illum.</p>
								</div>
							</div>
						</div>
						<div class="ui divider"></div>
						<a href="../pages/nieuwproduct.php" class="ui sand huge button">
	    				Nieuw product aanbieden
						</a>
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