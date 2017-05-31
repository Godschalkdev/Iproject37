<?php
session_start();
require ('../db-util.php');

connectToDatabase();
session_start();


if(isset($_POST['doorsturen']))
{
	insertNieuwProduct();
}else
{
	session_destroy();
}


	$sql = "SELECT heading_name FROM Heading";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
	$data = $stmt -> fetchAll();


function insertNieuwProduct(){
	global $pdo; 
	
	$insert = $pdo ->query (
		"INSERT INTO [object] (title, [description], starting_price, payment_method, payment_instructions, city, country, duration, shipping_cost, shipping_instructions) 
		VALUES (productnaam, productbeschrijving, startprijs, betaalwijze, Betaalinstructies, stad, land, duurveiling, bezorgkosten, bezorginstructies),
		INSERT INTO [file] ([filename]) 
		VALUES (afbeelding[])"
			);
}

?>