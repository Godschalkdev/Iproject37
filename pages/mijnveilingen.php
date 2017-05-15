<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<?php 
			include 'html/mijnveilingenhead.html';
		?>
	</head>
	
	<body>
	
		<?php 
			include 'html/menu.html';
			include 'html/sidebar.html';
		?>

		<div class="maincontent">
			<div class="ui container">
				<div class = "ui raised segment">
					<h1 class="ui niagara header">Mijn Veilingen</h1>

					<h3 class="ui dividing header"></h3>

						<div class="ui container">
        					<a href="../pages/nieuwproduct.php" class="ui sand huge button">
            					Nieuw product aanbieden
        					</a>
        				</div>

        				<h3 class="ui dividing header"></h3>

        				<div class='ui vertical segment' id='member'>
     			
					      <div class='ui three doubling stackable cards grid container'>
					        <div class='ui card'>
					          <div class='ui large image' name="afbeelding">
					            <img src='../images/Kast.jpg'>
					          </div>
					          <div class='content'>
					            <div class='header' name="naamproduct">Kast</div>
					            <div class='meta' name="hoogstebod">
					              Hoogste bod: €10.00
					            </div>
					          </div>
					          <div class='extra content'>
					            <a href='#'>Toon product</a>
					          </div>
					        </div>
			
					        <div class='ui card'>
					          <div class='ui large image' name="afbeelding">
					            <img src='../images/Xbox.jpg'>
					          </div>
					          <div class='content'>
					            <div class='header' name="naamproduct">Xbox</div>
					            <div class='meta' name="hoogstebod">
					              Hoogste bod: €300.00
					            </div>
					          </div>
					          <div class='extra content'>
					            <a href='#'>Toon product</a>
					          </div>
							</div>

					      </div>
					    </div>

					    <div class='ui vertical segment' id='member'>
     			
					      <div class='ui three doubling stackable cards grid container'>
					        <div class='ui card'>
					          <div class='ui large image' name="afbeelding">
					            <img src='../images/Tafel.jpg'>
					          </div>
					          <div class='content'>
					            <div class='header' name="naamproduct">Tafel</div>
					            <div class='meta' name="hoogstebod">
					              Hoogste bod: €45.00
					            </div>
					          </div>
					          <div class='extra content'>
					            <a href='#'>Toon product</a>
					          </div>
					        </div>
			
					        <div class='ui card'>
					          <div class='ui large image' name="afbeelding">
					            <img src='../images/Vazen.jpg'>
					          </div>
					          <div class='content'>
					            <div class='header' name="naamproduct">Vazen</div>
					            <div class='meta' name="hoogstebod">
					              Hoogste bod: €300.00
					            </div>
					          </div>
					          <div class='extra content'>
					            <a href='#'>Toon product</a>
					          </div>
							</div>
							
					      </div>
					    </div>

				</div>
			</div>
		</div>
	
		
		<?php
		include 'html/footer.html';
		include '../scripts/menuscript.html';
		?>
		
	</body>
</html>