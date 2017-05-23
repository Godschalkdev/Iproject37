<?php
	require '../controllers/indexController.php';
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
	include 'html/menu.html';
	include 'html/sidebar.html';
	?>
	
	<div class="pusher">
		<div class="maincontent">
			<div class="ui container">
				<div class="ui raised main segment">
					<ui class="ui top right attached label massive">
						12:00:00
					</ui>
					<div class="ui grid">
						<div class="ui eight wide column">
							<h1 class="ui dividing sand header">
								Nieuwe kast
							</h1>
							<ul class="slider">
							    <li>
							        <input type="radio" id="slide1" name="slide" checked>
							        <label for="slide1"></label>
							        <img src="/images/vazen.jpg" alt="Panel 1">
							    </li>
							    <li>
							        <input type="radio" id="slide2" name="slide">
							        <label for="slide2"></label>
							        <img src="/images/kast.jpg" alt="Panel 2">
							    </li>
							    <li>
							        <input type="radio" id="slide3" name="slide">
							        <label for="slide3"></label>
							        <img src="/images/tafel.jpg" alt="Panel 3">
							    </li>
							    <li>
							        <input type="radio" id="slide4" name="slide">
							        <label for="slide4"></label>
							        <img src="/images/xbox.jpg" alt="Panel 4">
							    </li>
							</ul>
							<div class="ui segment">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sint aliquam cum, quae assumenda, nisi illum facere, laudantium aliquid optio delectus molestiae? Dolorem explicabo corporis minus provident doloribus molestias asperiores dolorum.
							</div>
						</div>
						<div class="ui eight wide column">
							<h1 class="ui center aligned dividing sand header">
								Bieding
							</h1>
							<div class="ui offer segment">
								<h3 class="ui header">Huidig bod: €250,00</h3>
								<h4 class="ui header">Snel bieden</h4>
								<button class="ui sand button snel">€260,00</button>
								<button class="ui sand button snel">€270,00</button>
								<button class="ui sand button snel">€280,00</button>
								<form action="" class="ui form">
									<div class="field">
										<label>Bedrag</label>
										<input type="text" name="amount">
										<input type="submit" name="submit" value="Bied" class="ui sand button">
									</div>
								</form>
							</div>
							<div class="ui list">
								<div class="item">
									<i class="ui user icon"></i>
									<div class="content">
										<div class="header">€250,00</div>
										<div class="description">Billy bop (19-05-17  13:39)</div>
									</div>
								</div>
								<div class="item">
									<i class="ui user icon"></i>
									<div class="content">
										<div class="header">€240,00</div>
										<div class="description">Milly bop (19-05-17  13:39)</div>
									</div>
								</div>
								<div class="item">
									<i class="ui user icon"></i>
									<div class="content">
										<div class="header">€230,00</div>
										<div class="description">Billy bop (19-05-17  13:39)</div>
									</div>
								</div>
								<div class="item">
									<i class="ui user icon"></i>
									<div class="content">
										<div class="header">€220,00</div>
										<div class="description">Milly bop (19-05-17  13:39)</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<h3 class="ui dividing niagara header">
					Vergelijkbare producten
				</h3>
	        	<div class="ui three column doubling stackable grid container">
					<?php
						printPopulaireVeilingen();
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