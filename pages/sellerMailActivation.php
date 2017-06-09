<?php 
session_start();
?>

<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Activeren Verkopersaccount</title>
	<?php 
    include 'html/mainhead.html';
    include '../Controllers/verkoperMailController.php';
  	?>
  	<link rel="stylesheet" type="text/css" href="/stylecss/register.css">
</head>

<body>

 	<?php 
    	include 'html/sidebar.html';
    	include 'menu.php';
  	?>
<div class="pusher">
  	<div class="maincontent">
 	 	<div class="ui container">
 	 		<div class="ui raised segment">
 	 		<h1 class="ui niagara header">Activeer uw verkopersaccount</h1>
 	 		<?php 
    			checkForm();
    		?>
 	 		<form method="post" action="../pages/sellerMailActivation.php" class="ui big form">
		  
		    	<h4 class="ui dividing header">Vul hieronder uw activatiecode in.</h4>
		    	<div class="five wide field">
			      	<label>Activatiecode</label>
			      	<input type="text" name="activatiecode" placeholder="Vul hier uw activatiecode in" required>
			    </div>
			    <input type="submit" name="submit2" value="Activeren" class="ui huge sand button">
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