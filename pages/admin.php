<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
  <title>Admin</title>
	<?php 
    include 'html/mainhead.html';
    include '../Controllers/adminController.php';
    include '../Controllers/zoekenController.php';
  ?>
  	<link rel="stylesheet" type="text/css" href="/stylecss/login.css">
</head>

<body>

 	<?php 
    	include 'html/sidebar.html';
      include 'menu.php';
  	?>
    
  	<div class="maincontent">
 	 	  <div class="ui container">
 	 		 <div class="ui raised segment">
 	 			  <h1 class="ui niagara header">Admin</h1>
          <h3 class="ui dividing header"></h3>
 	 			  <div class="ui top attached tabular menu">
           <a class="active item" data-tab="first">Zoeken</a>
            <a class="item" data-tab="second">Account gegevens</a>
            <a class="item" data-tab="third">Categorieën beheren</a>
            <a class="item" data-tab="fourth">Veilingen beheren</a>
            <a class="item" data-tab="fifth">KPI's</a>
           

          </div>

          <div class="ui bottom attached tab segment active" data-tab="first">
            
            <form method="post"> 
            
            <?php 
              searchBar();
            ?>

<!--             <select name='database' >
              <option value='user'".(isset($_GET['user']) ? 'selected' : '')."> Account gegevens </option>
              <option> Categorieën </option>
              <option> Veilingen </option>
            </select>

              <input type='text' name='zoeken' value="<?php echo $zoeken ?>" placeholder='Zoeken' method="POST"> 
              <input type='submit' name='knop' value='verstuur' class='button ' method="REQUEST"> -->
        
            </form>   

          </div>

          <div class="ui bottom attached tab segment " data-tab="second">
            <form method="post">
                    <?php
                      showUsers();

                    //  saveInput();
                    ?>  
            </form>
          </div>

          <div class="ui bottom attached tab segment" data-tab="third">
              <form method="post">
                    <?php
                      showHeading();
                    //  saveInput();
                    ?>
            </form>
          </div>

          <div class="ui bottom attached tab segment" data-tab="fourth">
            <form method="post">
                    <?php
                      showVeilingen();
                    //  saveInput();
                    ?>
            </form>
          </div>

      

          <div class="ui bottom attached tab segment" data-tab="fifth">
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