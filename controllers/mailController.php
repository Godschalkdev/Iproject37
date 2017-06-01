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



?>