<?php

require('controllers/indexController.php');

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
	<?php 
    include '../pages/html/homehead.html'
  ?>
</head>

<body>

  <?php 
    include '../pages/html/menu.html';
    include '../pages/html/banner.html';
    include '../pages/html/sidebar.html';
  ?>

  <div class="mainContent">
  	
    <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Populaire producten</h2>
      </div>
      <?php printPopulaireVeilingen(); ?>
      </div>


    <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Bijzondere Producten</h2>
      </div>
      <?php printBijzondereVeilingen(); ?>
      </div>

  <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Koopjes</h2>
      </div>
      <?php printKoopjes(); ?>
      </div>

      <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Nieuwste producten</h2>
      </div>
      <?php printNieuweVeilingen(); ?>
      </div>
      </div>
      

  <?php include '../pages/html/footer.html' ?>



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