<?php
include '../db-util.php';
connectToDatabase();

session_start();


function checkForm(){

	if (isset($_POST['submit'])) {
		registerSeller();
	};
}

function registerSeller(){
	global $pdo;

	$username = $_SESSION['username'];
	$email = $_SESSION['emailaddress'];
	$bank = $_SESSION['bank'];
	$rekeningnummer = $_SESSION['rekeningnummer'];
	$controleoptie = $_SESSION['controleoptie'];
	$creditcardnummer = $_SESSION['creditcardnummer'];
	$activatieCode = $_SESSION['code'];

	if ($_SESSION['code'] == $_POST['activatiecode'] ) {

		$query = $pdo -> query("UPDATE dbo.Gebruiker 
				SET verkoper_ja_of_nee = 'nee' 
				WHERE gebruiker ='".$_SESSION['username']."' " );

		$query = $pdo -> prepare("INSERT INTO dbo.Seller (gebruiker, bank, bankrekening, controle_optie, creditcardnummer)
								VALUES (?, ?, ?, ?, ?)");
		$query->execute(array( $username, $bank, $rekeningnummer, $controleoptie, $creditcardnummer));

		echo '<div class="ui green message">Gefeliciteerd U bent nu verkoper.</div>';


	} else {
		echo '<div class="ui red message">Uw activatiecode komt niet overeen.</div>';
	}
};

?>
