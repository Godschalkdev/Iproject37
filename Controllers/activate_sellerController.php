<?php

include '../db-util.php';

connectToDatabase();



function register_seller(){
	global $pdo;

	$username = $_SESSION['naamuser'];
	$email = $_SESSION['emailuser'];
	$bank = $_POST['bank'];
	$rekeningnummer = $_POST['rekeningnummer'];
	$controleoptie = $_POST['controleoptie'];
	$creditcardnummer = $_POST['creditcardnummer'];

	if (!empty($_POST['rekeningnummer'] && !empty($_POST['creditcardnummer'])) ) {

		$query = $pdo -> query("UPDATE dbo.User 
				SET seller_yes_or_no = 'yes' 
				WHERE username ='".$_SESSION['username']."' ");

		$query = $pdo -> prepare("INSERT INTO dbo.Seller (username, bankname, account_number, control_option_name, creditcardnumber)
								VALUES (?, ?, ?, ?, ?)");
		$query->execute(array( $username, $bank, $rekeningnummer, $controleoptie, $creditcardnummer));


	} else {
		echo '<div class="ui red message">Vul uw bankrekeningnummer en/of creditcardnummer in.</div>';
	}
};

function genereerCode() {
	echo(rand());
}



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
		print_r($key['username']);
	}
}	
// ^

?>