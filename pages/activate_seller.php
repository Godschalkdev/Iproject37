<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Verkoper</title>
	<?php 
    include 'html/mainhead.html';
    include '../Controllers/activate_sellerController.php';
  	?>
  	<link rel="stylesheet" type="text/css" href="/stylecss/register.css">
</head>

<body>

 	<?php 
    	include 'html/sidebar.html';
    	include 'html/menu.html';

    	// v test for $_SESSION, verwijderen voor eind v
    	$_SESSION['username'] = "[Username]";
    	$_SESSION['emailaddress'] = "[email@mail.com]";
  	?>
	<div class="pusher">
  	<div class="maincontent">
 	 	<div class="ui container">
 	 		<div class="ui raised segment">
 	 		<h1 class="ui niagara header">Registreren als verkoper</h1>
 	 		<?php 

 	 			// v print test tijdelijk v
 	 		    echo "<pre>";
 	 		    print_r($_SESSION);
    			print_r($_POST);
    			echo "</pre>"; 

    			printSellers();
    			
    		?>
 	 		<form method="post" action="../pages/activate_seller.php" class="ui big form">

  			<h4 class="ui dividing header">Verkopersinformatie</h4>
		  
  				<div class="two fields">
			   		<div class="field">
			      	<label>Gebruikersnaam</label>
			      		<h3 class="ui grey header"><?php echo $_SESSION['username'] ?></h3>
			    	</div>
			   		<div class="field">
			      	<label>Email</label>
			      		<h3 class="ui grey header"><?php echo $_SESSION['emailaddress'] ?></h3>
			    	</div>
			    </div>

			<h4 class="ui dividing header">Betalingsinformatie</h4>
		    	<div class="two fields">
					<div class="field">
					    <label>Bank</label>
					    <select class="ui search dropdown" name="bank">
				            <option value="Rabobank">Rabobank</option>
				            <option value="ING Bank">ING Bank</option>
				            <option value="ABN Ambro">ABN Ambro</option>
				            <option value="SNS Bank">SNS Bank</option>
				        </select>
				  	</div>

			    	<div class="field">
				    	<label>Rekeningnummer</label>
				    	<input type="text" name="rekeningnummer" placeholder="Rekeningnummer">
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
					        <input type="radio" name="controleoptie" value="post">
					        <label>Post</label>
				      	</div>
				    </div>
			  	</div>

			  	<div class="field">
			      	<label>Creditcardnummer</label>
			      	<input type="text" name="creditcardnummer" placeholder="Creditcardnummer">
			    </div>
		    	<h4 class="ui dividing header">Valideren</h4>
		    	<div class="two wide field">
			      	<label>Activatiecode</label>
			      	<input type="text" name="activatiecode">
			    </div>
			    <input type="submit" value="Activeren" class="ui huge sand button">
			    <?php  register_seller(); ?>
			</form>
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

	<script>
		$('.ui.radio.checkbox').checkbox();
	</script>
</body>
</html>