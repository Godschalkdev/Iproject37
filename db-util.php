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
  $data = $pdo->query("SELECT TOP 10 title, description, max(offer_amount) as hoogsteBod,count(offer_amount) as totaleOffers FROM Object b inner join Offer f ON b.object_nr = f.object_nr GROUP BY title, description ORDER BY TotaleOffers desc");
  return $data->fetchAll();;
}


function getBijzondereVeilingen(){
	global $pdo;
	$data = $pdo->query("SELECT TOP 10 title, description, starting_price, MAX(offer_amount) as hoogsteBod, CAST(((100 / b.starting_price) * (max(f.offer_amount) - b.starting_price)) as NUMERIC(7,2)) as percentageVerschil FROM Object b Inner JOIN Offer f On b.object_nr = f.object_nr Group by title, description, starting_price ORDER BY percentageVerschil desc");
	return $data -> fetchAll();;

}


function getKoopjes(){
global $pdo; 
$data = $pdo ->query("SELECT TOP 10 title, description, starting_price ,MAX(offer_amount) as hoogsteBod, count(offer_amount) as totaleOffers
FROM Object b INNER JOIN Offer f on b.object_nr = f.object_nr GROUP BY starting_price, title, description HAVING starting_price <= 50 AND ((100 / b.starting_price) * (max(f.offer_amount) - b.starting_price)) < 20 ORDER BY totaleOffers desc");
return $data -> fetchAll();;

}

function getNieuweVeilingen(){
global $pdo; 
$data = $pdo ->query("SELECT TOP 10 title, description, MAX(offer_amount) as hoogsteBod FROM Object b left JOIN Offer f on b.object_nr = f.object_nr
GROUP BY title, description ORDER BY min(duration_start_date)"); 
return $data -> fetchAll();;
}




?>
