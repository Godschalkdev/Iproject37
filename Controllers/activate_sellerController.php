<?php

include '../db-util.php';

connectToDatabase();



function verwerkInfo(){

	
	if(isset($_POST['submit'])) { 

		$_SESSION['controleoptie'] = $_POST['controleoptie'];
		$_SESSION['bank'] = $_POST['bank'];
		$_SESSION['creditcardnummer'] = $_POST['creditcardnummer'];
		$_SESSION['rekeningnummer'] = $_POST['rekeningnummer'];

		if($_POST['controleoptie'] = 'email' && $_POST['rekeningnummer'] == !null){
			$activatieCode = mt_rand();
			$_SESSION['code'] = $activatieCode;
			sendSellerVerification($_SESSION['emailaddress'], $activatieCode, $_SESSION['username']);
			echo '<div class="ui green message">Bekijk uw inbox voor de activatiecode.</div>';
		} if ($_POST['controleoptie'] = 'creditcard' && $_POST['creditcardnummer'] == !null) {
			register_seller(); 
		} if ($_POST['controleoptie'] = 'creditcard' && $_POST['creditcardnummer'] == null)
			echo '<div class="ui red message">Vul een creditcardnummer in.</div>';
	}

}



function register_seller(){
	global $pdo;

	$username = $_SESSION['naamuser'];
	$email = $_SESSION['emailuser'];
	$bank = $_POST['bank'];
	$rekeningnummer = $_POST['rekeningnummer'];
	$controleoptie = $_POST['controleoptie'];
	$creditcardnummer = $_POST['creditcardnummer'];

	if (!empty($_POST['rekeningnummer'] && !empty($_POST['creditcardnummer'])) ) {

		$query = $pdo -> query("UPDATE dbo.Gebruiker 
				SET verkoper_ja_of_nee = 'ja' 
				WHERE gebruikersnaam ='".$_SESSION['username']."' " );

		$query = $pdo -> prepare("INSERT INTO dbo.Verkoper (gebruikersnaam, bank, bankrekening, controle_optie, creditcardnummer)
								VALUES (?, ?, ?, ?, ?)");
		$query->execute(array( $username, $bank, $rekeningnummer, $controleoptie, $creditcardnummer));


	} else {
		echo '<div class="ui red message">Vul uw bankrekeningnummer en/of creditcardnummer in.</div>';
	}
};


function sendSellerVerification($emailaddress, $activationcode, $username){
	$to = $emailaddress;
	$subject = 'VERKOPER | ACTIVATIE';
	$message='
	Bedankt voor uw aanmelding als verkoper op EenmaalAndermaal.

	Username: '.$username.'
	Activatiecode: '.$activationcode.'

	Volg de instructies op de site om uw verkopersaccount te activeren.
	';
	$headers = 'From:noreply@yourwebsite.com' . "\r\n"; // Set from headers
	mail($to, $subject, $message, $headers);
}

// v Testen V
function getSellers()
{
	global $pdo;
	$data = $pdo->query("SELECT * from dbo.Verkoper");
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