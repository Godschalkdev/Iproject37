<?php

include '../db-util.php';
include '../Controllers/mailController.php';

$username = "admin";
$passw = "Iproject37!";

connectToDatabase();

function meerderePaginasAantalRijen($nrijen){
	$nRijen = $nrijen;

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
  }
function meerderePaginasAdminLaag(){
	$rijenPerPagina = 1000;
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
	//$params = array(&$laagRijNummer, &$hoogRijNummer);
	//$database->execute(array($laagRijNummer, $hoogRijNummer));
	return $laagRijNummer;
}

function meerderePaginasAdminHoog(){
	$rijenPerPagina = 1000;
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
	//$params = array(&$laagRijNummer, &$hoogRijNummer);
	//$database->execute(array($laagRijNummer, $hoogRijNummer));
	return $hoogRijNummer;
}

function deleteAdmin($param){

		 if(isset($_GET['param']) && $_GET['param']=="verwijder"){
		          $verwijder_id = (int) $_GET['id'];
		    $sql= $param;
		    //print($sql);
		    if ($sql){
		        echo "Verwijderen gelukt";
		    } else {
		        echo "Verwijderen error";

	    }

    }
}

function updateAdmin($param){
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
}
	
// tabblad 1 van Admin Page - Zoeken

function zoekBalkAdmin(){

	print("<select name='database' class='ui search dropdown' method='POST'>
			  <option onchange='this.form.submit()'> Zoeken in </option>
              <option value='gebruiker' method='POST' onchange='this.form.submit()'> Account gegevens </option>
              <option value='categorie' method='POST' onchange='this.form.submit()'> Categorieën </option>
              <option value='veiling' method='POST' onchange='this.form.submit()'> Veilingen </option>
            </select>
            <div class='ui input'>
				<input placeholder='Zoeken' type='text' name='zoeken' value='' method='POST'>
				<input  type='submit' name='knop' method='REQUEST'>
			</div><br/><br/>"); 

if(isset($_POST['database'])){
    $select1 = $_POST['database'];
    switch ($select1) {
        case 'gebruiker':
        	if(isset($_REQUEST['knop']) ) {
        		$zoekinput = $_POST['zoeken'];
        		 $zoekresultaten = adminZoekenGebruiker($zoekinput);
           		 tabelGebruikers($zoekresultaten,getAantalGebruikers());
       		 }
            break;
        case 'categorie':
	        if(isset($_REQUEST['knop']) ) {
	        	$zoekinput = $_POST['zoeken'];
	        	 $zoekresultaten = adminZoekenCategorie($zoekinput);
	            tabelCategorieen($zoekresultaten, getAantalCategorieen());
	        }
            break;
        case 'veiling':
	        if(isset($_REQUEST['knop']) ) {
	        	$zoekinput = $_POST['zoeken'];
	        	$zoekresultaten = adminZoekenVeiling($zoekinput, getAantalVeilingen());
	           tabelVeilingen($zoekresultaten);
	       }
            break;
        default :
        	break;
    }
}

}

// tabblad 2 van Admin Page - Account gegevens beheren

function tabelKoppenGebruikers(){
	print("<table border='1px'> 
	        <tr>
		        <td>Gebruikers ID</td> 
		        <td>Gebruikersnaam</td>
		        <td>Voornaam</td>
		        <td>Achternaam</td>
		        <td>Emailaddress</td>
	        </tr>"); 
}

function tabelGebruikers($database, $aantalRijen){
	meerderePaginasAantalRijen($aantalRijen);
  $rows =  $database;
  	if (!empty($rows)) {
  		tabelKoppenGebruikers();
	  	foreach($rows as $row)
	      { 
	      	$id = $row['user_id'];
	      	
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
	     // deleteAdmin(deleteGebruikerAdmin($id));
	      print("</table>");
	  	} else {
  			echo "</br></br>Er zijn geen gebruikers.";
  	}
}

// tabblad 3 van Admin Page - Categorieen beheren

function tabelKoppenCategorieen(){
	print("<table border='1px'> 
	        <tr>
		      	<td>Rubriek Nr</td> 
		        <td>Rubriek naam</td>
		        <td>Rubriek nr parent</td>
	        </tr>");
}

function tabelCategorieen($database, $aantalRijen){
	meerderePaginasAantalRijen($aantalRijen);
  $rows =  $database;
  	if (!empty($rows)) {
  		tabelKoppenCategorieen();
	  	foreach($rows as $row)
	      { 
	      	//deleteAdmin(deleteCategorieAdmin($row['heading_nr']));
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
	  	} else {
  			echo "</br></br>Er zijn geen categorieën.";
  	}
}

// tabblad 4 van Admin Page - Veilingen beheren

function tabelKoppenVeilingen(){
	print("<table border='1px'> 
	        <tr>
		        <td>Object Nr</td> 
		        <td>Titel</td>
		        <td>Verkoper</td>
		        <td>Koper</td>
	        </tr>"); 
}

function tabelVeilingen($database, $aantalRijen){
  meerderePaginasAantalRijen($aantalRijen);
  $rows =  $database;
  	if (!empty($rows)) {
  		tabelKoppenVeilingen();
	  	foreach($rows as $row)
	      { 
	      	//deleteAdmin(deleteVeilingAdmin($row['object_nr']));
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
	  	} else {
  			echo "</br></br>Er zijn geen veilingen.";
  	}
}

// tabblad 5 van Admin Page - afgelopen veilingen en mailen
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
        
        $hoogsteBieder = $hoogsteBod['username'];
        $emailKoper = getEmail($hoogsteBieder);

        $verkoper = $row['seller'];
        $emailVerkoper = getEmail($verkoper);

	   if(isset($_POST['knop'])){
	        koperInObject($objectnr, $hoogsteBod['username']);
	        aflopendeVeilingKoperMail($emailKoper['emailaddress'], $row['title'], $hoogsteBod['username']);
	        aflopendeVeilingVerkoperMail($emailVerkoper[0], $row['title'], $hoogsteBod['username']);
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