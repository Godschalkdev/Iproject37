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
				<td>$key[seller_yes_or_no]</td>
			</tr>
MYCONTENT;
	echo $html;
	}
}



