<?php

function connectToDatabase()
{
	global $pdo; 
	$server = "localhost";
	$databaseName = "EENMAALANDERMAAL";
	$username = "sa";
	$password = "";


	try{ 
		$pdo = new PDO("sqlsrv:server=" .$server.";Database =". $databaseName.";ConnectionPooling=0", $username, $password);
}
catch(PDOexeption $e){
	echo $e->getMessage();
}
}

function getPopulaireVeilingen(){
global $pdo;
  $data = $pdo->query("SELECT TOP 3 title, description, max(offer_amount) as hoogsteBod,count(offer_amount) as totaleOffers FROM Object b inner join Offer f ON b.object_nr = f.object_nr GROUP BY title, description ORDER BY TotaleOffers desc");
  return $data->fetchAll();;
}
?>
