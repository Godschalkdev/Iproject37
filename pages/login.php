<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>

	<link rel="stylesheet" type="text/css" href="../semantic/semantic.css">
	<link rel="stylesheet" type="text/css" href="../stylecss/home.css">
  <link rel="stylesheet" type="text/css" href="../stylecss/menu.css">
  <link rel="stylesheet" type="text/css" href="../stylecss/footer.css">
  <link rel="stylesheet" type="text/css" href="../stylecss/login.css">
	
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="../semantic.min.js"></script>
</head>



<body>

  <?php 
    include 'html/menu.html';
    // include 'html/banner.html';
    include 'html/sidebar.html';
    require '../Controllers/loginController.php';
  ?>



  <div class="maincontent">
  	<div class='ui vertical stripe segment' id='member'>
      <div class='ui text container'>  
        <div class="ui raised segment">
        <h1 class='ui huge niagara header'>Login</h1>
          <form class ='ui big form' method="post">
            <div class="eight wide field">
              <label>Gebruikersnaam</label>
              <input name="username" placeholder="voorbeeld@mail.com" type="text">
              </div>
            <div class="eight wide field">
                <label>Wachtwoord</label>
                
                <input name="password" placeholder="Wachtwoord" type="password">
            </div>
            <button class="ui huge sand button" type="submit" value="submit">Inloggen</button>
          </form> 
          <p> Nog geen account?
          <a href="register.php">Registeer hier!</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <?php 
    include 'html/footer.html';
    include '../scripts/menuscript.html';
   ?>



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