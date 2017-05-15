<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<?php 
    include 'html/activate_seller_head.html'
    include 'activate_sellerController'
  	?>
</head>

<body>

 	<?php 
    	include 'html/menu.html';
    	include 'html/sidebar.html';
  	?>

  	<div class="maincontent">
 	 	<div class="ui container">
 	 		<div class="ui raised segment">
 	 		<h1 class="ui niagara header">Registreren als verkoper</h1>

  			<div method="POST" action="../index.php" class="ui big form">
  			<h4 class="ui dividing header">Verkopersinformatie</h4>
		  
  				<div class="two fields">
			   		<div class="field">
			      	<label>Gebruikersnaam</label>
			      			<h3 class="ui grey header">Mahoda</h3>
			    	</div>
			   		<div class="field">
			      	<label>Email</label>
			      		<h3 class="ui grey header">mahoda@email.com</h3>
			    	</div>
			    </div>
			<h4 class="ui dividing header">Betalingsinformatie</h4>
		    	<div class="two fields">
					<div class="field">
				    <label>Bank</label>
				    <select class="ui search dropdown" name="bank">
				            <option value="0">Rabobank</option>
				            <option value="1">ING Bank</option>
				            <option value="2">ABN Ambro</option>
				            <option value="3">SNS Bank</option>
				        </select>
				  	</div>

			    	<div class="field">
			    	<label>Rekeningnummer</label>
			    	<input type="text" placeholder="Rekeningnummer">
			    	</div>
				</div>

				<div class="inline fields">
			    <label for="controleoptie">Selecteer controleoptie:</label>
			    <div class="field">
			     	<div class="ui radio checkbox">
			        <input type="radio" name="controleoptie" checked="" tabindex="0">
			        <label>Creditcard</label>
			      	</div>
			    </div>
			    <div class="field">
			      	<div class="ui radio checkbox">
			        <input type="radio" name="controleoptie" tabindex="0">
			        <label>Post</label>
			      	</div>
			    </div>
		  	</div>

		  	<div class="field">
		      	<label>Creditcardnummer</label>
		      	<input type="text" placeholder="Creditcardnummer">
		    </div>
		    <h4 class="ui dividing header">Valideren</h4>
		    <div class="two wide field">
		      	<label>Activatiecode</label>
		      	<input type="text" placeholder="05XBSO0">
		    </div>
		    <input type="submit" value="Verkoopaccount Activeren" class="ui huge sand button">
		</div>

  	</div>
  	</div>
  	</div>

  	<?php include 'html/footer.html'; 
  		  include '../scripts/menuscript.html' ; 
  		?>

	<script>
		$('.ui.radio.checkbox').checkbox();
		$('#nextside').click(function(){
			$('.shape').shape('flip.right');
		});
		$('.shape').shape('set stage size', 200, 200);
	</script>
</body>
</html>