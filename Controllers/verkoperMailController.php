<?php

require '../db-util.php';

connectToDatabase();

function checkForm()
{

	if (isset($_POST['submit2'])) 
	{
		registerSeller();
	}
}

function registerSeller()
{
	global $pdo;

	$username 			= $_SESSION['naamuser'];
	$email 				= $_SESSION['emailuser'];
	$bank 				= $_SESSION['bank'];
	$rekeningnummer		= $_SESSION['rekeningnummer'];
	$controleoptie 		= $_SESSION['controleoptie'];
	$creditcardnummer 	= $_SESSION['creditcardnummer'];
	$activatieCode 		= $_SESSION['code'];

	if ($_SESSION['code'] == $_POST['activatiecode'] ) 
	{

		$query = $pdo -> query("UPDATE dbo.Gebruiker 
				SET verkoper_ja_of_nee = 'ja' 
				WHERE gebruiker ='".$_SESSION['naamuser']."' " );

		$query = $pdo -> prepare("INSERT INTO dbo.Verkoper (gebruiker, bank, bankrekening, controle_optie, creditcardnummer)
								VALUES (?, ?, ?, ?, ?)");
		$query->execute(array( $username, $bank, $rekeningnummer, $controleoptie, $creditcardnummer));

		echo '<div class="ui green message">Gefeliciteerd U bent nu verkoper.</div>';


	} else 
	{
		echo '<div class="ui red message">Uw activatiecode komt niet overeen.</div>';
	}
}

?>
