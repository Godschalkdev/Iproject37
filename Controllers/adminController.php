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

function getHeading()
{
	global $pdo;
	$data = $pdo->query("SELECT * from dbo.Heading");
  	return $data->fetchAll();
}

function getVeilingen()
{
	global $pdo;
	$data = $pdo->query("SELECT * from dbo.Object");
  	return $data->fetchAll();
}

function removeUser()
{
 global $pdo;
 $userData = getUsers();
 $data = $pdo->query("DELETE from dbo.Users where uid='".$userData['uid']."' AND UTable='".$_REQUEST['uid']."' " );

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
						<input type="hidden" name="UTable" value="$key[user_id]"/>
						<input type="submit" name="edit" value="Opslaan" class ="ui button one>Aanpassen </button>
						<input type="submit" name="email" value="Mailen" class ="ui button two">Email versturen</button>
						<input type="submit" name="remove" value="Verwijderen" class ="ui button three">Verwijderen</button>
					</div>
				</td>
			</tr>
MYCONTENT;
	echo $html;
	}
}

function showHeading()
{
	$data = getHeading();
	foreach($data as $key)
	{
				$html = <<<MYCONTENT
			<tr>
				<td>$key[heading_nr]</td> 
				<td>$key[heading_name]</td>
				<td>$key[heading_nr_parent]</td>
				<td>
					<div class="ui buttons">
		
						<input type="submit" name="edit" value="Opslaan" class ="ui button one>Aanpassen </button>
						<input type="submit" name="email" value="Mailen" class ="ui button two">Email versturen</button>
						<input type="submit" name="remove" value="Verwijderen" class ="ui button three">Verwijderen</button>
					</div>
				</td>
			</tr>
MYCONTENT;
	echo $html;
	}
}

function showVeilingen()
{
	$data = getVeilingen();
	foreach($data as $key)
	{
				$html = <<<MYCONTENT
			<tr>
				<td>$key[title]</td>	
				<td>$key[seller]</td> 
				<td>
					<div class="ui buttons">
		
						<input type="submit" name="edit" value="Opslaan" class ="ui button one>Aanpassen </button>
						<input type="submit" name="email" value="Mailen" class ="ui button two">Email versturen</button>
						<input type="submit" name="remove" value="Verwijderen" class ="ui button three">Verwijderen</button>
					</div>
				</td>
			</tr>
MYCONTENT;
	echo $html;
	}
}


function saveInput(){
	$conn = connectToDatabase();
	$data = getUsers();
	foreach($data as $key)

	if (isset($_POST['edit'])) {
	$sql = "UPDATE Users 
			SET username = $key[username],  
				firstname = $key[firstname],
				lastname = $key[lastname],
				emailaddress = $key[emailaddress]
			WHERE user_id = $key[user_id]";

	$stmt = $conn->prepare($sql);
	$stmt->execute();

	echo $stmt->rowCount() . " records UPDATED successfully";
}
}

//if(isset($_POST('remove')))
// {

// }


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


