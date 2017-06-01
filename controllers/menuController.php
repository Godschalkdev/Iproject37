<?php 
session_start();


function printUserOptionLoggedIn(){	
$html = <<<MYCONTENT
        <div class="header">User</div>
			  		<a href="http://www.eenmaalandermaal.dev/pages/mijnveilingen.php" class="item">Mijn veilingen</a>
			  		<div class="ui divider"></div>
			  		<a href="http://www.eenmaalandermaal.dev/pages/logout.php" class="item">Log out</a>
MYCONTENT;
echo $html;
}				    

function printUserOptionLoggedOut(){

$html = <<<MYCONTENT
        <div class="header">User</div>
				    <a href="http://www.eenmaalandermaal.dev/pages/login.php"" class="item">Log In</a>
				    <a href="http://www.eenmaalandermaal.dev/pages/register.php" class="item">Register</a>
MYCONTENT;

echo $html;
}




?>


