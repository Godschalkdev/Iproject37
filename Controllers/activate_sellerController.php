<?php

require '../db-util.php';

connectToDatabase();

function verwerkInfo()
{

	if(isset($_POST['submit'])) 
	{ 

		$_SESSION['controleoptie'] 		= $_POST['controleoptie'];
		$_SESSION['bank'] 				= $_POST['bank'];
		$_SESSION['creditcardnummer'] 	= $_POST['creditcardnummer'];
		$_SESSION['rekeningnummer'] 	= $_POST['rekeningnummer'];

		if($_POST['controleoptie'] = 'email') 
		{
			if($_POST['rekeningnummer'] == !null && $_POST['bank'] == !null) 
			{
				$activatieCode = mt_rand();
				$_SESSION['code'] = $activatieCode;
				sendSellerVerification($_SESSION['emailuser'], $activatieCode, $_SESSION['naamuser']);
				echo '<div class="ui green message">Bekijk uw inbox voor de activatiecode.</div>';
			} else 
			{
				echo '<div class="ui red message">Vul de vereiste gegevens in.</div>';
			}

		} 

		if ($_POST['controleoptie'] == 'creditcard') 
		{
			if ($_POST['creditcardnummer'] == !null) 
			{
				register_seller(); 
			} else if ($_POST['creditcardnummer'] == null) 
			{
				echo '<div class="ui red message">Vul de vereiste gegevens in.</div>';
			}
		}
	}
}

function register_seller(){
	global $pdo;

	$username 			= $_SESSION['naamuser'];
	$email 				= $_SESSION['emailuser'];
	$bank 				= $_POST['bank'];
	$rekeningnummer 	= $_POST['rekeningnummer'];
	$controleoptie 		= $_POST['controleoptie'];
	$creditcardnummer 	= $_POST['creditcardnummer'];

		$query = $pdo -> query("UPDATE dbo.Gebruiker 
				SET verkoper_ja_of_nee = 'ja' 
				WHERE gebruikersnaam ='".$_SESSION['naamuser']."' " );

		$query = $pdo -> prepare("INSERT INTO dbo.Verkoper (gebruikersnaam, bank, bankrekening, controle_optie, creditcardnummer)
								VALUES (?, ?, ?, ?, ?)");
		$query->execute(array( $username, $bank, $rekeningnummer, $controleoptie, $creditcardnummer));
}

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

?>