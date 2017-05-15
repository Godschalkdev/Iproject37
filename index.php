<?php

require('controllers/indexController.php');

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
	<?php 
    include 'pages/html/homehead.html';
  ?>
</head>

<body>

  <?php 
    include 'pages/html/menu.html';
    include 'pages/html/banner.html';
    include 'pages/html/sidebar.html';
  ?>

  <div class="mainContent">
  	
    <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Populaire producten</h2>
      </div>
      <?php printPopulaireVeilingen(); ?>
      </div>
      <div class = 'ui divider'> </div>


    <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Bijzondere Producten</h2>
      </div>
      <?php printBijzondereVeilingen(); ?>
      </div>

      <div class = 'ui divider'> </div>


  <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Koopjes</h2>
      </div>
      <?php printKoopjesVeilingen(); ?>
      </div>

      <div class = 'ui divider'> </div>


      <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Nieuwste producten</h2>
      </div>
      <?php printNieuweVeilingen(); ?>
      </div>
      </div>
      

  <?php include 'pages/html/footer.html' ;
  include 'scripts/menuscript.html';
  ?>

</body>
</html>