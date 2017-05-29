<?php

include '../db-util.php';

connectToDatabase();

session_start();

function register_seller(){
	global $pdo;

	$username = $_SESSION['username'];
	$email = $_SESSION['emailaddress'];
	$bank = $_POST['bank'];
	$rekeningnummer = $_POST['rekeningnummer'];
	$controleoptie = $_POST['controleoptie'];
	$creditcardnummer = $_POST['creditcardnummer'];

	$query = $pdo -> prepare("INSERT INTO dbo.Seller (username, bankname, account_number, control_option_name, creditcardnumber)
							VALUES (?, ?, ?, ?, ?)");
	$query->execute(array( $username, $bank, $rekeningnummer, $controleoptie, $creditcardnummer));
};




// v Testen V
function getSellers()
{
	global $pdo;
	$data = $pdo->query("SELECT * from dbo.Seller");
  	return $data->fetchAll();
}

function printSellers(){
	$data = getSellers();
	foreach($data as $key){
		print($key['username']);
	}
}	

?>