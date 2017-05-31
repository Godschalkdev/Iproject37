<?php
require('controllers/indexController.php');
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
	<?php 
    	include 'pages/html/mainhead.html'
  	?>
    <link rel="stylesheet" type="text/css" href="stylecss/home.css">
</head>

<body>

  <?php 
    include 'pages/html/sidebar.html';
    include 'pages/html/menu.html';
  ?>  

  <div class="pusher">
    <?php
      include 'pages/html/banner.html';
    ?>
    <div class="maincontent">
      <div class="ui container">
        
          <div class='ui center aligned text container'>
            <h2 class='ui niagara dividing header'>Populaire producten</h2>
          </div>
          <div class="ui three column doubling stackable grid container">
            <?php printIndexVeilingen('populair'); ?>
          </div>

          <div class='ui center aligned text container'>
            <h2 class='ui niagara dividing header'>Nieuwe producten</h2>
          </div>
          	<div class="ui three column doubling stackable cards grid container">
           <?php printIndexVeilingen('nieuw'); ?>
           </div>
    
          <div class='ui center aligned text container'>
            <h2 class='ui niagara dividing header'>Bijzondere Producten</h2>
          </div>
          	<div class="ui three column doubling stackable cards grid container">
          <?php printIndexVeilingen('bijzonder'); ?>
          </div>

        	<div class='ui center aligned text container'>
              <h2 class='ui niagara dividing header'>Koopjes</h2>
            </div>
            	<div class="ui three column doubling stackable cards grid container">
            <?php printIndexVeilingen('koopje'); ?>
            </div>
            </div>
      	</div>
    <?php 
    include 'pages/html/footer.html';
    ?>
    </div>
  <?php
    include 'scripts/menuscript.html';
  ?>

</body>
</html>