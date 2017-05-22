<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
  <title>Admin</title>
	<?php 
    include 'html/mainhead.html';
    include '../Controllers/adminController.php';
  ?>
  	<link rel="stylesheet" type="text/css" href="/stylecss/login.css">
</head>

<body>

 	<?php 
    	include 'html/menu.html';
    	//include 'html/sidebar.html';
  	?>

  	<div class="maincontent">
 	 	  <div class="ui container">
 	 		 <div class="ui raised segment">
 	 			  <h1 class="ui niagara header">Admin</h1>
          <h3 class="ui dividing header"></h3>
 	 			  <div class="ui top attached tabular menu">
            <a class="active item" data-tab="first">Account gegevens</a>
            <a class="item" data-tab="second">Categorieën beheren</a>
            <a class="item" data-tab="third">Veilingen beheren</a>
            <a class="item" data-tab="fourth">KPI's</a>
          </div>
          <div class="ui bottom attached tab segment active" data-tab="first">
              <table style="width:100%">
                <tr>
                  <th>Gebruikersnaam</th>
                  <th>Voornaam</th>
                  <th>Achternaam</th>
                  <th>Email</th>
                  <?php
                    showUsers();
                  ?>
                </tr>
                
              </table> 
          </div>
          <div class="ui bottom attached tab segment" data-tab="second">
             Second
          </div>
          <div class="ui bottom attached tab segment" data-tab="third">
             Third
          </div>
          <div class="ui bottom attached tab segment" data-tab="fourth">
             <iframe width="800" height="600" src="https://app.powerbi.com/view?r=eyJrIjoiNGFhMmExNGYtODI5Yi00OWNkLThkNjgtNWMxYjZhZDM0M2Q4IiwidCI6ImI2N2RjOTdiLTNlZTAtNDAyZi1iNjJkLWFmY2QwMTBlMzA1YiIsImMiOjh9" frameborder="0" allowFullScreen="true"></iframe>
          </div>
  		  </div>
  		</div>
  	</div>

  	<?php include 'html/footer.html'; 
  		  include '../scripts/menuscript.html'; 
        include '../scripts/adminScript.html';
  		?>
</body>
</html>