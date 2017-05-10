<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Home</title>

	<link rel="stylesheet" type="text/css" href="../semantic/semantic.css">
	<link rel="stylesheet" type="text/css" href="../stylecss/home.css">
  <link rel="stylesheet" type="text/css" href="../stylecss/menu.css">
  <link rel="stylesheet" type="text/css" href="../stylecss/footer.css">
	
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="semantic/semantic.min.js"></script>
</head>



<body>

  <?php 
    include 'html/menu.html';
    include 'html/banner.html';
    include 'html/sidebar.html';
  ?>





  <div class="mainContent">
  	<div class='ui vertical stripe segment' id='member'>
      <div class='ui text container'>
        <h2 class='ui center aligned header'>Login</h2>
        <div class="ui padded segment">
          <form class ='ui form'>
            <div class="eight wide field">
              <label>Gebruikersnaam</label>
              </label>
              <input name="username" placeholder="voorbeeld@mail.com" type="text">
            </div>
            <div class="eight wide field">
              <label>Wachtwoord</label>
              </label>
              <input name="password" placeholder="Wachtwoord" type="password">
            </div>
          </form> 
          <p> Nog geen account?
          <a href="">Registeer hier!</a>
          </p>
        </div>
      </div>
    </div>
  </div>

  <?php include 'html/footer.html' ?>



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