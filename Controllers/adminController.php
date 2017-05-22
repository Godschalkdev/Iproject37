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
						<button class ="ui button one">Aanpassen</button>
						<button class ="ui button two">Email versturen</button>
						<button class ="ui button three">Verwijderen</button>
					</div>
				</td>
			</tr>
			
MYCONTENT;
	echo $html;
	}
}

// function saveUsers()
// {
// 	$dom = new DomDocument();
// 	$dom->loadHTML('admin.php');
// 	$xpath = new DOMXPath($dom);

// 	$arr = array();
// 	$arr = array_filter(array_map('trim',$arr));
// 	foreach ($xpath->query('//tbody[@id="userTable"]/tr/td') as $node) 
// 	{
// 	    $arr[] = $node->nodeValue;
// 	}
// 	print_r($arr);

// }

// saveUsers();


