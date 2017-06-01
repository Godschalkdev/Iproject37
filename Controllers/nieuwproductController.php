<?php

require ('../db-util.php');

connectToDatabase();



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


?>