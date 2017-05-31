<?php
require_once "../controllers/userActivationController.php"; 

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Activatie pagina</title>
  <?php
  include 'html/mainhead.html'; 
  ?>
  <link rel="stylesheet" type="text/css" href="/stylecss/login.css">

</head>

<body>

  <?php 
    include  $_SERVER['DOCUMENT_ROOT']. "/pages/menu.php";
    include 'html/sidebar.html';
  ?>
  <div class="pusher">
    <div class="maincontent">
      <div class='ui text container'>  
        <div class="ui raised segment">
        <h1 class='ui massive niagara header'>Activatie pagina</h1>
        <h3 class='niagara'><?php checkActivation(); ?></h3>
          <p>Nog geen account aangemaakt?!
          <a href="register.php">Registreer Hier!</a></div>
          </p>
    
      </div>
    </div>

    <?php 
        include 'html/footer.html';
    ?>
     </div>

    <?php
      include '../scripts/menuscript.html';
    ?>

</body>
</html>