<?php 
 $success_message = "";
require('../controllers/loginController.php');
if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {
  $success_message = processForm();
}
      
        
            
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
  <?php
	include 'html/mainhead.html'; 
  ?>
  <link rel="stylesheet" type="text/css" href="/stylecss/login.css">

</head>

<body>

  <?php 
    include 'menu.php';
    include 'html/sidebar.html';
  ?>
  <div class="pusher">
    <div class="maincontent">
      <div class='ui text container'>  
        <div class="ui raised segment">
        <h1 class='ui huge niagara header'>Login</h1>
     <?php if (strlen($success_message) > 1){echo $success_message;$success_message = "";} ?>
          <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"  class="ui big form" method="POST">
            <div class="field">
              <label>Gebruikersnaam</label>
              <input name="username" placeholder="voorbeeld@mail.com" type="text">
            </div>
            <div class="field">
                <label>Wachtwoord</label>
                <input name="password" placeholder="Wachtwoord" type="password">
            </div>
            <input type="submit" value="submit" class="ui sand button">
          </form> 
          <p> Nog geen account?
          <a href="register.php">Registeer hier!</a>
          </p>
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

</body>
</html>