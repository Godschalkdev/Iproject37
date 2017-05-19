<?php

include '../db-util.php';

$username = "admin";
$passw = "Str00pW4f31";


connectToDatabase();


function getUsers()
{
	global $pdo;
	$data = $pdo->query("SELECT * from dbo.Users");
  	return $data->fetchAll();
}		
	
function showUsers()
{
	$data = getUsers();
	foreach($data as $key)
	{
		$html = <<<MYCONTENT
			<tr>
				<td>$key[username]</td> 
				<td>$key[firstname]</td>
				<td>$key[lastname]</td>
				<td>$key[emailaddress]</td>
				<td>
					<div class="ui buttons">
						<button class ="ui button" onClick=".editbtn">Aanpassen</button>
						<button class ="ui button">Email versturen</button>
						<button class ="ui button">Verwijderen</button>
					</div>
				</td>
			</tr>
			
MYCONTENT;
	echo $html;
	}
}




