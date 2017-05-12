<!DOCTYPE html>
<html>

	<head>
		<meta charset="utf-8">
		<?php 
			include '../../Iproject37/pages/html/mijnveilingenhead.html';
		?>
	</head>
	
	<body>
	
		<?php 
			include '../../Iproject37/pages/html/menu.html';
			include '../../Iproject37/pages/html/bannermijnveilingen.html';
			include '../../Iproject37/pages/html/sidebar.html';
		?>

	
		<div class="mainContent">
		<div class="ui container">
			<div class="ui middle aligned selection list">
				<h2>
					<div class="item">
					   <img class="ui avatar image" src="../images/Kast.jpg">
					    <div class="content">
					     	<a href="#" class="header">Kast</a>
					    	<div class="description">Laatste bieding: 20 minuten geleden</div>
					    </div>
					</div>
			 	</h2>
			  	<h2>
				  	<div class="item">
				   		<img class="ui avatar image" src="../images/Tafel.jpg">
				    	<div class="content">
				      		<a href="#" class="header">Tafel</a>
				      		<div class="description">Laatste bieding: 46 minuten geleden</div>
				    	</div>
				  	</div>
			  	</h2>
			  	<h2>
			  		<div class="item">
			    		<img class="ui avatar image" src="../images/Vazen.jpg">
			    		<div class="content">
			      			<a href="#" class="header">Vazen</a>
			      			<div class="description">Laatste bieding: --</div>
			    		</div>
			  		</div>
			  	</h2>
			 	<h2>
			  		<div class="item">
			    		<img class="ui avatar image" src="../images/Xbox.jpg">
			    		<div class="content">
			      			<a href="#" class="header">Xbox</a>
			      			<div class="description">Laatste bieding: 1 dag geleden</div>
			    		</div>
			  		</div>
			  	</h2>
			</div>
			</div>
		</div>
		
		<?php include '../../Iproject37/pages/html/footer.html' ?>

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