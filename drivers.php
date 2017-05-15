<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">

</head>

<body>
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


print_r(PDO::getAvailableDrivers());



    if (empty(PDO::getAvailableDrivers()))
    {
        throw new PDOException ("PDO does not support any driver.");
    }
?>

</body>
</html>