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
	<script src="../semantic/semantic.min.js"></script>
</head>



<body>

  <?php 
    include 'html/menu.html';
    include 'html/banner.html';
    include 'html/sidebar.html';
  ?>





  <div class="mainContent">
  	<div class='ui vertical stripe segment' id='member'>
      <div class='ui center aligned text container'>
        <h2 class='ui header'>Populaire producten</h2>
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