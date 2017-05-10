<?php


function connectToDatabase()
{
	global $pdo; 
	$server = "127.0.0.1";
	$databaseName = "EENMAALANDERMAAL";
	$username = "sa";
	$password = "";


	try{ 
		$pdo = new PDO("sqlsrv:server=" .$server.";Database =". $databaseName.";ConnectionPooling=0", $username, $password);
	echo "Connected to database"; 
}
catch(PDOexeption $e){
	echo $e->getMessage();
}
}

?>


<VirtualHost *:80>
DocumentRoot "C:/xampp/htdocs"
ServerName localhost
</VirtualHost>

<VirtualHost *:80>
DocumentRoot "D:/Tg/Documents/Gitmap/Iproject37"
ServerName eenmaalandermaal.dev
ServerAlias www.eenmaalandermaal.dev
<Directory "D:/Tg/Documents/Gitmap/Iproject37">
AllowOverride All
Require all Granted
</Directory>
</VirtualHost>



extension=php_sqlsrv.dll
extension=php_pdo_sqlsrv.dll
extension=php_pdo_sqlsrv_7_ts_x86.dll
extension=php_pdo_sqlsrv_7_ts_x64.dll
extension=php_sqlsrv_7_ts_x86.dll
extension=php_sqlsrv_7_ts_x64.dll