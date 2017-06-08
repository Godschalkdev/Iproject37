<?php

include '../db-util.php';
include '../Controllers/mailController.php';
//include '../scripts/adminScript.html';

$gebruikersnaam = "admin";
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
         $update_voorwerpnummer = $_GET['voorwerpnummer'];
         $update_titel = $_GET['titel'];
         $update_verkoper = $_GET['verkoper'];
         $update_koper = $_GET['koper'];
         $sql="UPDATE dbo.Voorwerp SET voorwerpnummer = '$update_voorwerpnummer', titel = '$update_titel', verkoper = '$update_verkoper', koper = '$update_koper' WHERE voorwerpnummer='$update_id'";
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
				<input  type='submit' name='knopZoeken' method='REQUEST'>
			</div><br/><br/>"); 

if(isset($_POST['database'])){
    $select = $_POST['database'];
    switch ($select) {
        case 'gebruiker':
        	if(isset($_REQUEST['knopZoeken']) ) {
        		$zoekinput = $_POST['zoeken'];
        		 $zoekresultaten = adminZoekenGebruiker($zoekinput, getAantalGebruikers());
           		 tabelGebruikers($zoekresultaten, getAantalGebruikers());
       		 }
            break;
        case 'categorie':
	        if(isset($_REQUEST['knopZoeken']) ) {
	        	$zoekinput = $_POST['zoeken'];
	        	 $zoekresultaten = adminZoekenCategorie($zoekinput, getAantalCategorieen());
	            tabelCategorieen($zoekresultaten, getAantalCategorieen());
	        }
            break;
        case 'veiling':
	        if(isset($_REQUEST['knopZoeken']) ) {
	        	$zoekinput = $_POST['zoeken'];
	        	$zoekresultaten = adminZoekenVeiling($zoekinput, getAantalVeilingen());
	           tabelVeilingen($zoekresultaten, getAantalVeilingen());
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
		        <td>emailadres</td>
	        </tr>"); 
}

function tabelGebruikers($database, $aantalRijen){
	global $pdo;

	meerderePaginasAantalRijen($aantalRijen);

	// verwijderen krijg ik niet aan de gang in een aparte functie
	 if(isset($_GET['param']) && $_GET['param']=="verwijderGebruiker"){
	          $verwijder_id = (int) $_GET['id'];
	         $sql="DELETE FROM dbo.Gebruiker WHERE gebruiker_id='$verwijder_id'";
	         $resultaat=$pdo->query($sql);

	    if ($resultaat){
	        echo "Verwijderen gelukt";

	    } else {
	        echo "Verwijderen error";

	    }

	    }

  $rows =  $database;
  	if (!empty($rows)) {
  		tabelKoppenGebruikers();
	  	foreach($rows as $row)
	      { 
	     //$id = $row['gebruiker_id'];
	      	
	        print("
				<tbody id='userTable'>
	        	<tr>
	        		<td contentEditable='true'>$row[gebruiker_id]</td> 
	                <td contentEditable='true'>$row[gebruikersnaam]</td> 
	                <td contentEditable='true'>$row[voornaam]</td>
	                <td contentEditable='true'>$row[achternaam]</td>
	                <td contentEditable='true'>$row[emailadres]</td>

	                <td><a href='?param=verwijderGebruiker&amp;id={$row['gebruiker_id']}'>Verwijderen</a></td>
	                <td><a href='?param=update&amp;id={$row['gebruiker_id']}&amp;gebruiker_id={$row['gebruiker_id']}&amp;gebruikersnaam={$row['gebruikersnaam']}&amp;voornaam={$row['voornaam']}&amp;achternaam={$row['achternaam']}&amp;emailadres={$row['emailadres']}'>Update</a></td>
	               </tr>
	                </tbody>"); 
	      } 
	    //  deleteAdmin(deleteGebruikerAdmin($id));
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
	global $pdo;

	meerderePaginasAantalRijen($aantalRijen);
// verwijderen krijg ik niet aan de gang in een aparte functie
	 if(isset($_GET['param']) && $_GET['param']=="verwijderCategorie"){
	          $verwijder_id = (int) $_GET['id'];
	         $sql="DELETE FROM dbo.Rubriek WHERE rubrieknummer='$verwijder_id'";
	         $resultaat=$pdo->query($sql);

	    if ($resultaat){
	        echo "Verwijderen gelukt";

	    } else {
	        echo "Verwijderen error";

	    }

	    }

  	$rows =  $database;
  	if (!empty($rows)) {
  		tabelKoppenCategorieen();
	  	foreach($rows as $row)
	      { 
	    //  	$id = $row['rubrieknummer'];
	      	//deleteAdmin(deleteCategorieAdmin($row['rubrieknummer']));
	        print("
				<tbody id='userTable' >
	        	<tr>
	        		<td contentEditable='true' name='rubrieknummer'>$row[rubrieknummer]</td> 
	                <td contentEditable='true' name='rubrieknaam'>$row[rubrieknaam]</td> 
	                <td contentEditable='true' name='rubriek'>$row[rubriek]</td>
	                <td><a href='?param=verwijderCategorie&amp;id={$row['rubrieknummer']}'>Verwijderen</a></td>

	                <td><a href='?param=update&amp;id={$row['rubrieknummer']}&amp;rubrieknummer={$row['rubrieknummer']}&amp;rubrieknaam={$row['rubrieknaam']}&amp;rubriek={$row['rubriek']}'>
	                			  Update</a></td>

	               </tr>
	                </tbody>");
	      } 
	   //   deleteAdmin(deleteCategorieAdmin($id));
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
	global$pdo;

  meerderePaginasAantalRijen($aantalRijen);

// verwijderen krijg ik niet aan de gang in een aparte functie
	 if(isset($_GET['param']) && $_GET['param']=="verwijderVeiling"){
	          $verwijder_id = (int) $_GET['id'];
	         $sql="DELETE FROM dbo.Voorwerp WHERE voorwerpnummer='$verwijder_id'";
	         $resultaat=$pdo->query($sql);

	    if ($resultaat){
	        echo "Verwijderen gelukt";

	    } else {
	        echo "Verwijderen error";

	    }

	    }

  $rows =  $database;
  	if (!empty($rows)) {
  		tabelKoppenVeilingen();
	  	foreach($rows as $row)
	      { 
	      //	$id = $row['voorwerpnummer'];
	      	//deleteAdmin(deleteVeilingAdmin($row['voorwerpnummer']));
	          print("
				<tbody id='userTable' >
	        	<tr>
	        		<td contentEditable='true'>$row[voorwerpnummer]</td> 
	                <td contentEditable='true'>$row[titel]</td> 
	                <td contentEditable='true'>$row[verkoper]</td>
	                <td contentEditable='true'>$row[koper]</td>

	                <td><a href='?param=verwijderVeiling&amp;id={$row['voorwerpnummer']}'>Verwijderen</a></td>

	                <td><a href='?param=update&amp;id={$row['voorwerpnummer']}&amp;voorwerpnummer={$row['voorwerpnummer']}&amp;titel={$row['titel']}&amp;verkoper={$row['verkoper']}&amp;koper={$row['koper']}'>
	                			  Update</a></td>
	               </tr>
	                   </tbody>"); 
	      } 
	      //deleteAdmin(deleteVeilingAdmin($id));
	      print("</table>");

	  	} else {
  			echo "</br></br>Er zijn geen veilingen.";
  	}
}

// tabblad 5 van Admin Page - afgelopen veilingen en mailen
function buttonAfgelopenVeilingen()
{
  print("<div class='ui input'>
        <input  type='submit' name='knop' method='POST' value='Veilingen sluiten en Mail sturen'>
      </div>"); 

	$rows =  getAfgelopenVeilingen();
    foreach($rows as $row)
      { 
        $hoogsteBod = getHoogsteBod($row['voorwerpnummer']);
        $objectnr = $row['voorwerpnummer'];
        
        $hoogsteBieder = $hoogsteBod['gebruikersnaam'];
        $emailKoper = getEmail($hoogsteBieder);

        $verkoper = $row['verkoper'];
        $emailVerkoper = getEmail($verkoper);

	   if(isset($_POST['knop'])){
	        koperInObject($objectnr, $hoogsteBod['gebruikersnaam']);
	        aflopendeVeilingKoperMail($emailKoper['emailadres'], $row['titel'], $hoogsteBod['gebruikersnaam']);
	        aflopendeVeilingVerkoperMail($emailVerkoper[0], $row['titel'], $hoogsteBod['gebruikersnaam']);
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
	        $hoogsteBod = getHoogsteBod($row['voorwerpnummer']) ;
	          print("
	        <tbody id='userTable'>
	            <tr>
	                <td contentEditable='true'>$row[voorwerpnummer]</td> 
	                <td contentEditable='true'>$row[titel]</td> 
	                <td contentEditable='true'>$hoogsteBod[gebruikersnaam]</td>
	                <td contentEditable='true'>$row[verkoper]</td>
	            </tr>
	        </tbody>"); 
	      } 
	      print("</table>");
	  	} else {
  			echo "</br></br>Er zijn geen aflopende veilingen.";
  	}
}

?>