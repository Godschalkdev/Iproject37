<?php

//include '../db-util.php';

$username = "admin";
$passw = "Str00pW4f31";

//connectToDatabase();

function searchBar(){
	
	global $pdo;

	print("<select name='database' class='ui search dropdown' method='POST'>
              <option value='gebruiker' method='POST' onchange='this.form.submit()'> Account gegevens </option>
              <option value='categorie' method='POST' onchange='this.form.submit()'> Categorieën </option>
              <option value='veiling' method='POST' onchange='this.form.submit()'> Veilingen </option>
            </select>
            <div class='ui input'>
				<input placeholder='Zoeken' type='text' name='zoeken' value='' method='POST'>
				<input  type='submit' name='knop' method='REQUEST'>
			</div>"); 

if(isset($_POST['database'])){
    $select1 = $_POST['database'];
    switch ($select1) {
        case 'gebruiker':
            adminZoekenGebruiker();
            break;
        case 'categorie':
            adminZoekenCategorie();
            break;
        case 'veiling':
            adminZoekenVeiling();
            break;
    }
}

}


function adminZoekenGebruiker(){
	global $pdo;
	if(isset($_REQUEST['knop']) ) {

		$zoekinput = $_POST['zoeken'];
		$sql = "SELECT user_id, username, firstname, lastname, emailaddress FROM dbo.Users
	             WHERE user_id LIKE '%".$zoekinput."%'
	           	    OR username LIKE '%".$zoekinput."%'
	                OR firstname LIKE '%".$zoekinput."%'
	                OR lastname LIKE '%".$zoekinput."%'
	                OR emailaddress LIKE '%".$zoekinput."%'";


	$stmt = $pdo->prepare($sql);

	$stmt->fetchAll();

	$stmt->execute();
	
	// tabel
	print("<br>
		<table border='1px'> <br>
	        <tr>
		        <td>user ID</td> 
		        <td>username</td>
		        <td>firstname</td>
		        <td>lastname</td>
		        <td>emailaddress</td>
	        </tr>"); 

	while($row = $stmt->fetch(PDO::FETCH_NUM) ) 
	//foreach($sql as $row)
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
}

function adminZoekenCategorie(){
	global $pdo;
	if(isset($_REQUEST['knop']) ) {

		$zoekinput = $_POST['zoeken'];
		$sql = "SELECT heading_nr, heading_name, heading_nr_parent FROM dbo.Heading
	             WHERE heading_nr LIKE '%".$zoekinput."%'
	           	    OR heading_name LIKE '%".$zoekinput."%'
	                OR heading_nr_parent LIKE '%".$zoekinput."%'";


	$stmt = $pdo->prepare($sql);

	$stmt->fetchAll();

	$stmt->execute();
	
	// tabel
	print("<br>
		<table border='1px'> <br>
	        <tr>
		        <td>heading Nr</td> 
		        <td>heading name</td>
		        <td>heading nr parent</td>
	        </tr>"); 

	while($row = $stmt->fetch(PDO::FETCH_NUM) ) 
	//foreach($sql as $row)
	    { 
	        print("
				<tbody id='userTable' contentEditable='true'>
	        	<tr>
	        		<td>$row[0]</td> 
	                <td>$row[1]</td> 
	                <td>$row[2]</td>
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
}

function adminZoekenVeiling(){
	global $pdo;
	if(isset($_REQUEST['knop']) ) {

		$zoekinput = $_POST['zoeken'];
		$sql = "SELECT object_nr, title, seller FROM dbo.Object
	             WHERE object_nr LIKE '%".$zoekinput."%'
	           	    OR title LIKE '%".$zoekinput."%'
	                OR seller LIKE '%".$zoekinput."%'";


	$stmt = $pdo->prepare($sql);

	$stmt->fetchAll();

	$stmt->execute();
	
	// tabel
	print("<br>
		<table border='1px'> <br>
	        <tr>
		        <td>object Nr</td> 
		        <td>title</td>
		        <td>seller</td>
	        </tr>"); 

	while($row = $stmt->fetch(PDO::FETCH_NUM) ) 
	//foreach($sql as $row)
	    { 
	        print("
				<tbody id='userTable' contentEditable='true'>
	        	<tr>
	        		<td>$row[0]</td> 
	                <td>$row[1]</td> 
	                <td>$row[2]</td>
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
}

?>