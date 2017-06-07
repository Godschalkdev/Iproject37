<?php

function sendUserVerification($emailaddress, $activationcode, $password, $username){
$to = $emailaddress;
$subject = 'SIGNUP| VERIFICATION';
$message='
Bedankt voor uw aanmelding op EenmaalAndermaal.

Username: '.$username.'
Password: '.$password.'

Klik op de link hieronder om uw account te activeren.
http://www.eenmaalandermaal.dev/pages/userActivation.php?emailaddress='.$emailaddress.'&activation_code='.$activationcode.'
';
$headers = 'From:noreply@yourwebsite.com' . "\r\n";
mail($to, $subject, $message, $headers);
}

function aflopendeVeilingKoperMail($emailaddress, $producttitel, $username){
	$to = $emailaddress;
	$subject = 'U heeft een veiling gewonnen';
	$message='
	Beste '.$username.',
	Gefelicteerd! U heeft een veiling gewonnen!

	U heeft het volgende product gewonnen: '.$producttitel.'

	Klik op de link hieronder om feedback te geven:
	';
	$headers = 'From:noreply@yourwebsite.com' . "\r\n";
	mail($to, $subject, $message, $headers);
}

function aflopendeVeilingVerkoperMail($emailaddress, $producttitel, $username){
	$to = $emailaddress;
	$subject = 'U heeft een Product verkocht';
	$message='
	Beste '.$username.',
	Gefelicteerd! U heeft een product verkocht!

	U heeft het volgende product verkocht: '.$producttitel.'

	Klik op de link hieronder om feedback te geven:
	';
	$headers = 'From:noreply@yourwebsite.com' . "\r\n";
	mail($to, $subject, $message, $headers);
}

?>