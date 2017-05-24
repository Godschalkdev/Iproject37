<?php

include '../db-util.php';

$username = "admin";
$passw = "Str00pW4f31";

connectToDatabase();



function getUsers()
{
	global $pdo;
	$data = $pdo->query("SELECT top 10 * from dbo.Users");
	
  	return $data->fetchAll(PDO::FETCH_ASSOC);
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
 $data = $pdo->query("DELETE from dbo.Users where user_id='".$_POST['UTable']."' " );

}	
	
function showUsers()
{
	global $pdo;

	$sql = "SELECT COUNT(user_id) FROM dbo.Users"; 

	$stmt = $pdo->query($sql);

	$nRijen = $stmt->fetch(PDO::FETCH_NUM);
 	$rijenPerPagina = 1000;

	if($nRijen[0] == 0) 
	{ 
	    echo "No rows returned."; 
	} 
	else 
	{     
	    $nPagina = ceil($nRijen[0]/$rijenPerPagina); 
	    for($i = 1; $i<=$nPagina; $i++) 
	    { 
	        $paginaNummer = "?paginaNummer=$i"; 
	        print("<a href=$paginaNummer>$i</a>&nbsp;&nbsp;"); 
	    } 
	    echo "<br/><br/>"; 
	}


	$sql = "SELECT * FROM  
            			(SELECT ROW_NUMBER() OVER(ORDER BY user_id) 
            			AS rownumber, username, firstname, lastname,  emailaddress FROM dbo.Users) 
        				AS Temp 
        				WHERE rownumber BETWEEN ? AND ?";

    $stmt2 = $pdo->prepare($sql);
   
  

	if(isset($_GET['paginaNummer'])) 
	{ 
	    $hoogRijNummer = $_GET['paginaNummer'] * $rijenPerPagina; 
	    $laagRijNummer = $hoogRijNummer - $rijenPerPagina + 1; 
	} 
	else 
	{ 
	    $laagRijNummer = 1; 
	    $hoogRijNummer = $rijenPerPagina; 
	}

	$params = array(&$laagRijNummer, &$hoogRijNummer);
	$stmt2->execute(array($laagRijNummer, $hoogRijNummer));

	 $nRijen = $stmt->rowCount();
	
	print("<table border='1px'> 
	        <tr>
		        <td>user ID</td> 
		        <td>username</td>
		        <td>firstname</td>
		        <td>lastname</td>
		        <td>emailaddress</td>
	        </tr>"); 

		while($row = $stmt2->fetch(PDO::FETCH_NUM) ) 
	    { 
	        print("
				<tbody id='userTable' contentEditable='true'>
	        	<tr>
	        		<td>$row[0]</td> 
	                <td>$row[1]</td> 
	                <td>$row[2]</td>
	                <td>$row[3]</td>
	                <td>$row[4]</td>
	                <td>
	                	<div class='ui buttons'>
	                	<input type='hidden' name='UTable' value='$row[0]'/>
	                		<input type='submit' name='edit' value='Opslaan' class='ui button one'>Opslaan</button>
	                		<input type='submit' name='email' value='Mailen' class='ui button two'>Mailen</button>
	                		<input type='submit' name'=remove' value='Verwijderen' class='ui button three'>Verwijderen</button>
	                	</div>
	                </td>
	               </tr>
	                </tbody>"); 
	    } 
	    print("</table>");
}


function showHeading()
{
	global $pdo;

	$sql = "SELECT COUNT(heading_nr) FROM dbo.Heading"; 

	$stmt = $pdo->query($sql);

	$nRijen = $stmt->fetch(PDO::FETCH_NUM);
 	$rijenPerPagina = 1000;
	if($nRijen[0] == 0) 
	{ 
	    echo "No rows returned."; 
	} 
	else 
	{     
	    $nPagina = ceil($nRijen[0]/$rijenPerPagina); 
	    for($i = 1; $i<=$nPagina; $i++) 
	    { 
	        $paginaNummer = "?paginaNummer=$i"; 
	        print("<a href=$paginaNummer>$i</a>&nbsp;&nbsp;"); 
	    } 
	    echo "<br/><br/>"; 
	}


	$sql = "SELECT * FROM  
            			(SELECT ROW_NUMBER() OVER(ORDER BY heading_nr) 
            			AS rownumber, heading_nr, heading_name, heading_nr_parent FROM dbo.Heading) 
        				AS Temp 
        				WHERE rownumber BETWEEN ? AND ?";

    $stmt2 = $pdo->prepare($sql);
   
  

	if(isset($_GET['paginaNummer'])) 
	{ 
	    $hoogRijNummer = $_GET['paginaNummer'] * $rijenPerPagina; 
	    $laagRijNummer = $hoogRijNummer - $rijenPerPagina + 1; 
	} 
	else 
	{ 
	    $laagRijNummer = 1; 
	    $hoogRijNummer = $rijenPerPagina; 
	}

	$params = array(&$laagRijNummer, &$hoogRijNummer);
	$stmt2->execute(array($laagRijNummer, $hoogRijNummer));

	 $nRijen = $stmt->rowCount();
	
	print("<table border='1px'> 
	        <tr>
		        <td>Heading Nr</td> 
		        <td>Heading name</td>
		        <td>Heading parent</td>
	        </tr>"); 

		while($row = $stmt2->fetch(PDO::FETCH_NUM) ) 
	    { 
	        print("
				<tbody id='userTable' contentEditable='true'>
	        	<tr>
	        		<td>$row[0]</td> 
	                <td>$row[1]</td> 
	                <td>$row[2]</td>
	                <td>
	                	<div class='ui buttons'>
	                		<input type='submit' name='edit' value='Opslaan' class='ui button one'>Opslaan</button>
	
	                		<input type='submit' name='remove' value='Verwijderen' class='ui button three'>Verwijderen</button>
	                	</div>
	                </td>
	               </tr>
	                </tbody>"); 
	    } 
	    print("</table>");
}

function showVeilingen()
{
	global $pdo;

	$sql = "SELECT COUNT(object_nr) FROM dbo.Object"; 

	$stmt = $pdo->query($sql);

	$nRijen = $stmt->fetch(PDO::FETCH_NUM);
 	$rijenPerPagina = 1000;
	if($nRijen[0] == 0) 
	{ 
	    echo "No rows returned."; 
	} 
	else 
	{     
	    $nPagina = ceil($nRijen[0]/$rijenPerPagina); 
	    for($i = 1; $i<=$nPagina; $i++) 
	    { 
	        $paginaNummer = "?paginaNummer=$i"; 
	        print("<a href=$paginaNummer>$i</a>&nbsp;&nbsp;"); 
	    } 
	    echo "<br/><br/>"; 
	}


	$sql = "SELECT * FROM  
            			(SELECT ROW_NUMBER() OVER(ORDER BY object_nr) 
            			AS rownumber, object_nr, title, seller FROM dbo.Object) 
        				AS Temp 
        				WHERE rownumber BETWEEN ? AND ?";

    $stmt2 = $pdo->prepare($sql);
   
  

	if(isset($_GET['paginaNummer'])) 
	{ 
	    $hoogRijNummer = $_GET['paginaNummer'] * $rijenPerPagina; 
	    $laagRijNummer = $hoogRijNummer - $rijenPerPagina + 1; 
	} 
	else 
	{ 
	    $laagRijNummer = 1; 
	    $hoogRijNummer = $rijenPerPagina; 
	}

	$params = array(&$laagRijNummer, &$hoogRijNummer);
	$stmt2->execute(array($laagRijNummer, $hoogRijNummer));

	 $nRijen = $stmt->rowCount();
	
	print("<table border='1px'> 
	        <tr>
		        <td>Object Nr</td> 
		        <td>Title</td>
		        <td>Seller</td>

	        </tr>"); 

		while($row = $stmt2->fetch(PDO::FETCH_NUM) ) 
	    { 
	        print("
				<tbody id='userTable' contentEditable='true'>
	        	<tr>
	        		<td>$row[0]</td> 
	                <td>$row[1]</td> 
	                <td>$row[2]</td>
	                <td>
	                	<div class='ui buttons'>
	                		<input type='submit' name='edit' value='Opslaan' class='ui button one'>Opslaan</button>

	                		<input type='submit' name='remove' value='Verwijderen' class='ui button three'>Verwijderen</button>
	                	</div>
	                </td>
	               </tr>
	                </tbody>"); 
	    } 
	    print("</table>");
}




/*
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
*/


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

<<<<<<< HEAD
// saveUsers();
=======
// saveUsers();


?>
>>>>>>> f19888fbfcd593dd32760b75bd123d1d764d2723
