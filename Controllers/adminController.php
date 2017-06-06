<?php

include '../db-util.php';
include '../Controllers/mailController.php';

$username = "admin";
$passw = "Str00pW4f31";

connectToDatabase();

// function getUsers(){
// 	global $pdo;
//     $stmt = $pdo->query("SELECT COUNT(user_id) FROM dbo.Users");
  
//     return $stmt->fetch(PDO::FETCH_NUM);
// }

function getHeadingPaginanummers()
{
	global $pdo;
	$data = $pdo->query("SELECT * from dbo.Heading");
  	return $data->fetchAll();
}

function getVeilingenPaginanummers()
{
	global $pdo;
	$data = $pdo->query("SELECT * from dbo.Object");
  	return $data->fetchAll();
}


function removeUser($row)
{

global $pdo;
//$id = $_POST[$row[0]];
 
$query = "DELETE FROM dbo.Users WHERE user_id = '$row'";
$query->execute();
}	

function showUsers()
{
	global $pdo;

	$nRijen = getAantalUsers(); 

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
            			AS user_id, username, firstname, lastname,  emailaddress FROM dbo.Users) 
        				AS Temp 
        				WHERE user_id BETWEEN ? AND ?";

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

	//$nRijen = $stmt->rowCount();
	



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
//aanpassesn
     if(isset($_GET['param']) && $_GET['param']=="update"){
         $update_id = $_GET['id'];
         $update_user_id = $_GET['user_id'];
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
		        <td>Gebruikers ID</td> 
		        <td>Gebruikersnaam</td>
		        <td>Voornaam</td>
		        <td>Achternaam</td>
		        <td>Emailaddress</td>
	        </tr>"); 

		foreach($stmt2 as $row)
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
	                <td><a href='?param=update&amp;id={$row['user_id']}&amp;user_id={$row['user_id']}&amp;username={$row['username']}&amp;firstname={$row['firstname']}&amp;lastname={$row['lastname']}&amp;emailaddress={$row['emailaddress']}'>Opslaan</a></td>
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

		foreach($stmt2 as $row)
	    { 
	        print("
				<tbody id='userTable' >
	        	<tr>
	        		<td contentEditable='true' name='heading_nr'>$row[heading_nr]</td> 
	                <td contentEditable='true' name='heading_name'>$row[heading_name]</td> 
	                <td contentEditable='true' name='heading_nr'>$row[heading_nr_parent]</td>
	                <td><a href='?param=verwijder&amp;id={$row['heading_nr']}'>Verwijderen</a></td>

	                <td><a href='?param=update&amp;id={$row['heading_nr']}&amp;heading_nr={$row['heading_nr']}&amp;heading_name={$row['heading_name']}&amp;heading_nr_parent={$row['heading_nr_parent']}'>
	                			  Update</a></td>

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
            			AS rownumber, object_nr, title, seller, buyer FROM dbo.Object) 
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
         $update_buyer = $_GET['buyer'];
         $sql="UPDATE dbo.Object SET object_nr = '$update_object_nr', title = '$update_title', seller = '$update_seller', buyer = '$update_buyer' WHERE object_nr='$update_id'";
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


			foreach($stmt2 as $row)
	 	 {
	        print("
				<tbody id='userTable' >
	        	<tr>
	        		<td  contentEditable='true'>$row[object_nr]</td> 
	                <td  contentEditable='true'>$row[title]</td> 
	                <td  contentEditable='true'>$row[seller]</td>
	                <td  contentEditable='true'>$row[buyer]</td>
	                <td><a href='?param=verwijder&amp;id={$row['object_nr']}'>Verwijderen</a></td>

	                <td><a href='?param=update&amp;id={$row['object_nr']}&amp;object_nr={$row['object_nr']}&amp;title={$row['title']}&amp;seller={$row['seller']}&amp;buyer={$row['buyer']}'>
	                			  Update</a></td>
	               </tr>
	                   </tbody>"); 
	  }
	    

	    print("</table>");
}

// tabblad 5 van Admin Page
function buttonAfgelopenVeilingen()
{
  print("<div class='ui input'>
        <input  type='submit' name='knop' method='POST' value='Mail versturen'>
      </div>"); 

	$rows =  getAfgelopenVeilingen();
    foreach($rows as $row)
      { 
        $hoogsteBod = getHoogsteBod($row['object_nr']);
        $objectnr = $row['object_nr'];
        $email = getEmail($hoogsteBod['username']);
        print($email['emailaddress']);
	   if(isset($_POST['knop'])){
	        koperInObject($objectnr, $hoogsteBod['username']);
	        aflopendeVeilingKoperMail($email['emailaddress'], $row['title'], $hoogsteBod['username']);
	        veilingSluiten($objectnr);
	   }
	}
}

function tabelKoppenAfgelopenVeilingen(){
	  print("<br/><br/>
      <table border='1px'> 
          <tr>
            <td>Object nummer</td> 
            <td>Titel</td>
            <td>Koper</td>
            <td>Verkoper</td>
            
          </tr>"); 
}

function tabelAfgelopenVeilingen(){
  $rows =  getAfgelopenVeilingen();
  	if (!empty($rows)) {
  		tabelKoppenAfgelopenVeilingen();
	  	foreach($rows as $row)
	      { 
	        $hoogsteBod = getHoogsteBod($row['object_nr']) ;
	          print("
	        <tbody id='userTable'>
	            <tr>
	              <td>$row[object_nr]</td> 
	                  <td>$row[title]</td> 
	                  <td>$hoogsteBod[username]</td>
	                  <td>$row[seller]</td>
	                 </tr>
	                  </tbody>"); 
	      } 
	      print("</table>");
	  	} else {
  			echo "</br></br>Er zijn geen aflopende veilingen.";
  	}
}
?>