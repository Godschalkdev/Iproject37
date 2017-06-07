<?php

//include '../db-util.php';

$username = "admin";
$passw = "Str00pW4f31";

//connectToDatabase();

function searchBar(){
	
	global $pdo;

	print("<select name='database' class='ui search dropdown' method='POST'>
			  <option onchange='this.form.submit()'> Zoeken in </option>
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
        default :
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
	
	
	print("<table border='1px'> 
	        <tr>
		        <td>Gebruikers ID</td> 
		        <td>Gebruikersnaam</td>
		        <td>Voornaam</td>
		        <td>Achternaam</td>
		        <td>Emailaddress</td>
	        </tr>"); 


 if(isset($_GET['param']) && $_GET['param']=="verwijder"){
          $verwijder_id = (int) $_GET['id'];
         $sql="DELETE FROM dbo.Users WHERE user_id='$verwijder_id'";
         $resultaat=$pdo->query($sql);

    if ($resultaat){
        echo "Verwijderen gelukt";

    } else {
        echo "Verwijderen error";

    }

    }


		foreach($stmt as $row)
	    { 
	        print("
				<tbody id='userTable'>
	        	<tr>
	        		<td contentEditable='true'>$row[user_id]</td> 
	                <td contentEditable='true'>$row[username]</td> 
	                <td contentEditable='true'>$row[firstname]</td>
	                <td contentEditable='true'>$row[lastname]</td>
	                <td contentEditable='true'>$row[emailaddress]</td>

	                <td><a href='?param=verwijder&amp;id={$row['user_id']}'>Verwijderen</a></td>
	                <td><a href='?param=opslaan&amp;id={$row['user_id']}'>Opslaan</a></td>
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
	if(isset($_GET['param']) && $_GET['param']=="verwijder"){
          $verwijder_id = (int) $_GET['id'];
         $sql="DELETE FROM dbo.Heading WHERE Heading_nr='$verwijder_id'";
         $resultaat=$pdo->query($sql);

    if ($resultaat){
        echo "Verwijderen gelukt";

    } else {
        echo "Verwijderen error";

    }

    }

     if(isset($_GET['param']) && $_GET['param']=="update"){
         $update_id = $_GET['id'];
         $update_heading_nr = $_GET['heading_nr'];
         $update_heading_name = $_GET['heading_name'];
         $update_heading_nr_parent = $_GET['heading_nr_parent'];
         $sql="UPDATE dbo.Heading SET heading_nr = '$update_heading_nr', heading_name = '$update_heading_name', heading_nr_parent = '$update_heading_nr_parent' WHERE Heading_nr='$update_id'";
         $resultaat=$pdo->query($sql);

    if ($resultaat){
        echo "Updaten gelukt";

    } else {
        echo "Updaten error";

    }

    }


	print("<table border='1px'> 
	        <tr>
		      	<td>Rubriek Nr</td> 
		        <td>Rubriek naam</td>
		        <td>Rubriek nr parent</td>
	        </tr>"); 

		foreach($stmt as $row)
	    { 
	        print("
				<tbody id='userTable' >
	        	<tr>
	        		<td contentEditable='true' name='heading_nr'>$row[heading_nr]</td> 
	                <td contentEditable='true' name='heading_name'>$row[heading_name]</td> 
	                <td contentEditable='true' name='heading_nr'>$row[heading_nr_parent]</td>
	                <td><a href='?param=verwijder&amp;id={$row['heading_nr']}'>Verwijderen</a></td>

	                <td><a href='?param=update&amp;
	                			  id={$row['heading_nr']}&amp;
	                			  heading_nr={$row['heading_nr']}&amp;
	                			  heading_name={$row['heading_name']}&amp;
	                			  heading_nr_parent={$row['heading_nr_parent']}'>
	                			  Update</a></td>

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
		$sql = "SELECT object_nr, title, seller, buyer FROM dbo.Object
	             WHERE object_nr LIKE '%".$zoekinput."%'
	           	    OR title LIKE '%".$zoekinput."%'
	                OR seller LIKE '%".$zoekinput."%'
	                OR buyer LIKE '%".$zoekinput."%'";


	$stmt = $pdo->prepare($sql);

	$stmt->fetchAll();

	$stmt->execute();
	
	// tabel
	if(isset($_GET['param']) && $_GET['param']=="verwijder"){
          $verwijder_id = (int) $_GET['id'];
         $sql="DELETE FROM dbo.Object WHERE object_nr='$verwijder_id'";
         $resultaat=$pdo->query($sql);

    if ($resultaat){
        echo "Verwijderen gelukt";

    } else {
        echo "Verwijderen error";

    }

    }

     if(isset($_GET['param']) && $_GET['param']=="update"){
         $update_id = $_GET['id'];
         $update_object_nr = $_GET['object_nr'];
         $update_title = $_GET['title'];
         $update_seller = $_GET['seller'];
         $sql="UPDATE dbo.Object SET object_nr = '$update_object_nr', title = '$update_title', seller = '$update_seller' WHERE object_nr='$update_id'";
         $resultaat=$pdo->query($sql);

    if ($resultaat){
        echo "Updaten gelukt";

    } else {
        echo "Updaten error";

    }

    }

	print("<table border='1px'> 
	        <tr>
		        <td>Object Nr</td> 
		        <td>Titel</td>
		        <td>Verkoper</td>
		        <td>Koper</td>
	        </tr>"); 


			foreach($stmt as $row)
	 	 {
	        print("
				<tbody id='userTable' >
	        	<tr>
	        		<td  contentEditable='true'>$row[object_nr]</td> 
	                <td  contentEditable='true'>$row[title]</td> 
	                <td  contentEditable='true'>$row[seller]</td>
	                <td  contentEditable='true'>$row[buyer]</td>
	                <td><a href='?param=verwijder&amp;id={$row['object_nr']}'>Verwijderen</a></td>

	                <td><a href='?param=update&amp;
	                			  id={$row['object_nr']}&amp;
	                			  object_nr={$row['object_nr']}&amp;
	                			  title={$row['title']}&amp;
	                			  seller={$row['seller']}'>
	                			  Update</a></td>
	               </tr>
	                   </tbody>"); 
	  }
	    

	    print("</table>");
	}
}

?>