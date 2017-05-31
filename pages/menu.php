<?php 
require ($_SERVER['DOCUMENT_ROOT'] .'/controllers/menuController.php');
?>

<div class="ui large inverted niagara fixed pointing secondary menu">
	<div class="ui container">
      <h4 class="ui bottom aligned inverted header">
        <span class="Eenmaal">Eenmaal</span>Andermaal
      </h4>

		<a href="http://iproject37.icasites.nl" class="item">
			<i class="large white home icon"></i>
		</a>
		<a id="toggle" class="item">
			<i class="large white sidebar icon"></i>
		</a>
		<div class="center item">
			<div class="ui icon input">
				<input placeholder="Search..." type="text">
				<i class="circular search link icon"></i>
			</div>
		</div>
		<div class="right item">
			<div class="ui right icon pointing dropdown button">
			  	<i class="large niagara user icon"></i>
			  	<div class="menu">

			  	<?php if (isset($_SESSION['loggedin'])){
			  		printUserOptionLoggedIn();
			  		}else{
			  			printUserOptionLoggedOut();
			  			} ?>


				</div>
			</div>
		</div>
	</div>
</div>