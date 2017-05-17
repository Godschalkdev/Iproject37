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
    include 'pages/html/menu.html';
    include 'pages/html/banner.html';
    include 'pages/html/sidebar.html';
  ?>

  <div class="mainContent">
    <div class="ui container">
      
        <div class='ui center aligned text container'>
          <h2 class='ui niagara dividing header'>Populaire producten</h2>
        </div>
        <div class="ui three doubling stackable cards grid container">
          <?php printPopulaireVeilingen(); ?>
        </div>
    </div>
  </div>

    

  <?php include 'pages/html/footer.html' ?>



	<script>
		$('.ui.dropdown').dropdown();
		$('#nextside').click(function(){
			$('.shape').shape('flip.right');
		});
		$('.shape').shape('set stage size', 200, 200);
		$('#toggle').click(function(){
			$('.ui.sidebar').sidebar('toggle');
		});
	</script>
</body>
</html>