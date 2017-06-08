<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Aanmaken Verkopersaccount</title>
	<?php 
    include 'html/mainhead.html';
    include '../Controllers/activate_sellerController.php';
  	?>
  	<link rel="stylesheet" type="text/css" href="/stylecss/register.css">
</head>

<body>

 	<?php 
    	include 'html/sidebar.html';
    	include  $_SERVER['DOCUMENT_ROOT']. "/pages/menu.php";

    	// v test for $_SESSION, verwijderen voor eind v
    	$_SESSION['username'] = "Mahoda";
    	$_SESSION['emailaddress'] = "eenmaalandermaalofficial@gmail.com";
    	// ^
  	?>
<div class="pusher">
  	<div class="maincontent">
 	 	<div class="ui container">
 	 		<div class="ui raised segment">
 	 		<h1 class="ui niagara header">Registreren als verkoper</h1>
 	 		<?php 

 	 		verwerkInfo();
    			
    		?>
 	 		<form method="post" action="../pages/activate_seller.php" class="ui big form">

  			<h4 class="ui dividing header">Verkopersinformatie</h4>
		  
  			<div class="two fields">
			   	<div class="field">
			      	<label>Gebruikersnaam</label>
			      		<h3 class="ui grey header"><?php echo $_SESSION['naamuser'] ?></h3>
			    	</div>
			   		<div class="field">
			      		<label>Email</label>
			      		<h3 class="ui grey header"><?php echo $_SESSION['emailuser'] ?></h3>
			    	</div>
			</div>

			<h4 class="ui dividing header">Betalingsinformatie</h4>
		    	<div class="two fields">
					<div class="field">
					    <label>Bank</label>
					    <select class="ui search dropdown" name="bank">
					    	<option value="">Selectuur uw bank</option>
				            <option value="Rabobank">Rabobank</option>
				            <option value="ING Bank">ING Bank</option>
				            <option value="ABN Ambro">ABN Ambro</option>
				            <option value="SNS Bank">SNS Bank</option>
				        </select>
				  	</div>

			    	<div class="field">
				    	<label>Rekeningnummer</label>
				    	<input type="text" name="rekeningnummer" placeholder="Vul hier uw rekeningnummer in">
			    	</div>
				</div>

				<div class="inline fields">
				    <label for="controleoptie">Selecteer identificatiemethode:</label>
				    <div class="field">
				     	<div class="ui radio checkbox">
					        <input type="radio" name="controleoptie" value="creditcard" required>
					        <label>Creditcard</label>
				      	</div>
				    </div>
				    <div class="field">
				      	<div class="ui radio checkbox">
					        <input type="radio" name="controleoptie" value="email">
					        <label>Email</label>
				      	</div>
				    </div>
			  	</div>

			  	<div class="field">
			      	<label>Creditcardnummer</label>
			      	<input type="text" name="creditcardnummer" placeholder="Vul hier uw creditcardnummer in">
			    </div>
			    <input type="submit" name="submit" value="Activeren" class="ui huge sand button">
			</form>
		</div>
  	</div>
  	</div>
  	</form>

  	<?php 
  		include 'html/footer.html'; 
  	?>

  	</div>

  	<?php 
  		include '../scripts/menuscript.html';
  	?>

	<script>
		$('.ui.radio.checkbox').checkbox();
	</script>
</body>
</html>