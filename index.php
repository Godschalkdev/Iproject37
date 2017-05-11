<?php
require 'controllers/indexController.php';
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
	<?php 
    include 'pages/html/homehead.html'
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
      <div class='ui three doubling stackable cards grid container'>
        <div class='ui card'>
          <div class='image'>
            <img src='../images/Vazen.jpg'>
          </div>
          <div class='content'>
            <div class='header'>Chineze Vazen</div>
            <div class='meta'>
              <a>vraagprijs: €500.000</a>
            </div>
            <div class='description'>Vazen uit het oude china</div>
          </div>
          <div class='extra content'>
            <a href='#'>
              <i class='large legal icon'></i>
              Ga naar veiling
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Bijzondere Producten</h2>
      </div>
      <div class='ui three doubling stackable cards grid container'>
        <div class='ui card'>
          <div class='image'>
            <img src='../images/Vazen.jpg'>
          </div>
          <div class='content'>
            <div class='header'>Chineze Vazen</div>
            <div class='meta'>
              <a>vraagprijs: €500.000</a>
            </div>
            <div class='description'>Vazen uit het oude china</div>
          </div>
          <div class='extra content'>
            <a href='#'>
              <i class='large legal icon'></i>
              Ga naar veiling
            </a>
          </div>
        </div>
      </div>
    </div>    

  <div class='ui vertical segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui niagara header'>Koopjes</h2>
      </div>
      <div class='ui three doubling stackable cards grid container'>
        <div class='ui card'>
          <div class='image'>
            <img src='../images/Vazen.jpg'>
          </div>
          <div class='content'>
            <div class='header'>Chineze Vazen</div>
            <div class='meta'>
              <a>vraagprijs: €500.000</a>
            </div>
            <div class='description'>Vazen uit het oude china</div>
          </div>
          <div class='extra content'>
            <a href='#'>
              <i class='large legal icon'></i>
              Ga naar veiling
            </a>
          </div>
        </div>
      </div>
    </div>

  <?php 
     include 'pages/html/footer.html';
     include 'scripts/menuscript.html';
  ?>
  
</body>
</html>