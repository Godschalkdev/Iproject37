<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	
  <?php
	include 'html/mainhead.html'; 
  ?>
  <link rel="stylesheet" type="text/css" href="../../stylecss/login.css">

</head>

<body>

  <?php 
    include 'html/menu.html';
    include 'html/sidebar.html';
    include ('../Controllers/loginController.php');
  ?>



  <div class="maincontent">
    <div class='ui text container'>  
      <div class="ui raised segment">
      <h1 class='ui huge niagara header'>Login</h1>
        <form class ='ui big form' method="post">
          <div class="field">
            <label>Gebruikersnaam</label>
            <input name="username" placeholder="voorbeeld@mail.com" type="text">
            </div>
          <div class="field">
              <label>Wachtwoord</label>
              <input name="password" placeholder="Wachtwoord" type="password">
          </div>
          <button class="ui huge sand button" name="submit" type="submit" value="submit">Inloggen</button>
        </form> 
        <p> Nog geen account?
        <a href="register.php">Registeer hier!</a>
        </p>
      </div>
    </div>
  </div>

  <?php 
    include 'html/footer.html';
    include '../scripts/menuscript.html';
   ?>

</body>
</html>