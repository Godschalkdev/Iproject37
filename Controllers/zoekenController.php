<?php

include '../db-util.php';

$username = "admin";
$passw = "Str00pW4f31";

connectToDatabase();

function searchBarAdminUser(){
	global $pdo;

	$query = $_GET['zoeken'];
	$sql = "SELECT * FROM dbo.Users
            WHERE ('user_id' LIKE '%".$query."%') 
               OR ('firstname' LIKE '%".$query."%')
               OR ('lastname' LIKE '%".$query."%')
               OR ('emailaddress' LIKE '%".$query."%')";

	$resultaat = $pdo->prepare($sql);
 	$stmt->execute($resultaat);

 	if(rowCount() > 0){

		while($stmt2 = mysql_fetch_array($stmt){
             
                echo "<p>".$stmt2['user_id']."
                		 ".$stmt2['firstname']."
                		 ".$stmt2['lastname']."
                		 ".$stmt2['emailaddress']."</p>";

 		}
	}
}



?>