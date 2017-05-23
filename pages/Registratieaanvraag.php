?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Registratie aanvraag</title>
  <?php
	include 'html/mainhead.html'; 
  ?>
  <link rel="stylesheet" type="text/css" href="/stylecss/login.css">

</head>

<body>

  <?php 
    include 'html/menu.html';
    include 'html/sidebar.html';
  ?>
  <div class="pusher">
    <div class="maincontent">
      <div class='ui text container'>  
        <div class="ui bottom attached segment">
        <h1 class='ui huge niagara header'>Registratie aanvraag</h1>
          <form action=""  class="ui massive form" method="POST">
            <div class="field">
              <label >Emailadres</label>
              <input name="emailaddress" placeholder="voorbeeld@mail.com" type="text">
            </div>
            <input type="submit" value="submit" class="ui massive sand button">
          </form> 
          <p> Al een account?
          <a href="register.php">Log hier in!</a></div>
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