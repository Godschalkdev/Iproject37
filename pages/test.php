
<?php
$ftp_server = "ftp.iproject.icasites.nl";
$ftp_username   = "iproject37";
$ftp_password   =  "6JYc6Lj4";

$remote_file_path = "/pics/";
$file_fake = "sometext.txt";
// setup of connection
$conn_id = ftp_connect($ftp_server) or die("could not connect to $ftp_server");

if(@ftp_login($conn_id, $ftp_username, $ftp_password)){

  echo "connected as $ftp_username@$ftp_server\n";

 if(ftp_put($conn_id, $remote_file_path, $file_fake, FTP_ASCII)){
    	echo "succes upload";
}
}
else
{
  echo "could not connect as $ftp_username\n";
}

?>