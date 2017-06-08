<?php

function connectToDatabase()
{
  global $pdo; 
  $server = "localhost";
  $databaseName = "EENMAALANDERMAAL";
  $username = "sa";
  $password = "";


  try{ 
    $pdo = new PDO("sqlsrv:server=" .$server.";Database =". $databaseName.";ConnectionPooling=0", $username, $password);
}
catch(PDOexeption $e){
  echo $e->getMessage();
}
}

//Functies voor het inloggen
 function Chk_LoginDetails($gebruikersnaam, $plaintextpassword)
    {
      global $pdo;
      $data = $pdo->prepare("SELECT gebruikersnaam, wachtwoord, emailadres FROM Gebruiker WHERE gebruikersnaam = ? AND geactiveerd_ja_of_nee = 'ja' ");
      $data->execute(array($gebruikersnaam));

      $datas = $data->fetch();
      $count = count($datas);
      if ($count > 0) {
        if (password_verify($plaintextpassword, $datas["wachtwoord"])) {
          return array($datas["gebruikersnaam"],$datas["emailadres"]);
        } else {
          return false;
        }}
        else{
          return false;
        }
      }

//Functies voor de index pagina
function getPopulaireVeilingen(){
global $pdo;
  $data = $pdo->query("SELECT TOP 3 titel, beschrijving, max(bodbedrag) as hoogsteBod,count(bodbedrag) as totaleOffers, b.voorwerpnummer FROM Voorwerp b inner join Bod f ON b.voorwerpnummer = f.voorwerpnummer GROUP BY titel, beschrijving, b.voorwerpnummer ORDER BY TotaleOffers desc");
  return $data->fetchAll();
  
}

function getfile($voorwerpnummer) {
  global $pdo;
    $data = $pdo->query("SELECT TOP 4 * FROM Bestand WHERE voorwerpnummer = $voorwerpnummer");
  return $data->fetch();
}

function getBijzondereVeilingen(){

  global $pdo;
  $data = $pdo->query("SELECT TOP 3 b.voorwerpnummer, titel, beschrijving, startprijs, MAX(bodbedrag) as hoogsteBod, CAST(((100 / (b.startprijs+1)) * (max(f.bodbedrag) - b.startprijs)) as NUMERIC(12,2)) as percentageVerschil FROM Voorwerp as b Inner JOIN Offer as f On b.voorwerpnummer = f.voorwerpnummer Group by titel, beschrijving, startprijs, b.voorwerpnummer ORDER BY percentageVerschil desc");
  return $data->fetchAll();
}


function getKoopjes(){
global $pdo; 
$data = $pdo ->query("SELECT TOP 3  b.voorwerpnummer, titel, beschrijving, startprijs ,MAX(bodbedrag) as hoogsteBod, count(bodbedrag) as totaleOffers 
FROM Voorwerp b INNER JOIN Bod f on b.voorwerpnummer = f.voorwerpnummer 
GROUP BY startprijs, titel, beschrijving , b.voorwerpnummer
having startprijs <= 100 AND ((100 / (b.startprijs+1)) * (max(f.bodbedrag) - b.startprijs)) < 100
ORDER BY totaleOffers desc");
return $data -> fetchAll();
}

function getNieuweVeilingen(){

  global $pdo; 
  $data = $pdo ->query("SELECT top 3 Voorwerp.voorwerpnummer, looptijd_einde_dag, looptijd_einde_tijdstip, titel
                        FROM Voorwerp
                        ORDER BY looptijd_einde_dag desc, looptijd_einde_tijdstip desc"); 
  return $data -> fetchAll();
}

function getHoogsteBod($param){
  global $pdo;
  $data = $pdo ->query("SELECT TOP 1 MAX(bodbedrag) as hoogsteBod, gebruikersnaam
                        FROM Bod
                        WHERE voorwerpnummer = $param
                        GROUP BY gebruikersnaam
                        ORDER BY hoogsteBod DESC");
  return $data->fetch();
  }



//Functies op nieuwe gebruikers te registreren

 function Chk_UserAlreadyExist_email($emailadres)
    {
      global $pdo;
      $data = $pdo->prepare("SELECT emailadres FROM Gebruiker WHERE emailadres = ?");
      $data->execute(array($emailadres));
      $count = count($data->fetchAll());
      if ($count > 0) {
        return true;
      } else {
        return false;
      }
    }


 function Chk_UserAlreadyExist_gebruikersnaam($gebruikersnaam)
      {
        global $pdo;
        $data = $pdo->prepare("SELECT gebruikersnaam FROM Gebruiker WHERE gebruikersnaam = ?");
        $data->execute(array($gebruikersnaam));
        $count = count($data->fetchAll());
        if ($count > 0) {
          return true;
        } else {
          return false;
        }
      }



function checkActivation(){ 
global $pdo;   
if(isset($_GET['emailaddress']) && !empty($_GET['emailaddress']) && isset($_GET['activation_code']) && !empty($_GET['activation_code'])){
    // Verify data
    $emailaddress = $_GET['emailaddress']; // Set email variable
    $activation_code = $_GET['activation_code']; // Set hash variable
                 
    $data = $pdo->prepare("SELECT emailaddress, activatiecode, geactiveerd_ja_of_nee FROM [user] WHERE emailaddress = ? AND activatiecode = ? AND geactiveerd_ja_of_nee = 'nee' ");
    $data->execute(array($emailaddress, $activation_code));
    $count = count($data->fetchAll());
                 
    if($count > 0){
        // We have a match, activate the account
      $updateActive = $pdo->prepare("UPDATE [User] SET geactiveerd_ja_of_nee ='ja' WHERE emailadres = ? AND activatiecode = ? AND geactiveerd_ja_of_nee = 'nee'");
        $updateActive->execute(array($emailaddress, $activation_code));
        echo 'Je account is geactiveerd, je kunt nu inloggen <a href="http://www.eenmaalandermaal.dev/pages/login.php">Hier!</a></div>';
    }else{
        // No match -> invalid url or account has already been activated.
        echo 'De link is ongeldig, of je bent al geactiveerd.';
    }
                 
}else{
    // Invalid approach
    echo 'Ongeldige link, gebruik de link die naar je mail is gestuurd!';
}
}



function addNewUser($gebruikersnaam, $voornaam,$achternaam,$adresregel_1,$adresregel_2, $postcode, $plaatsnaam, $land, $geboortedag, $emailadres, $wachtwoord, $vraagnummer, $antwoordtekst, $verkoper_ja_of_nee,$geactiveerd_ja_of_nee, $activatiecode) {
              
                try{ 
                  global $pdo;
    
                $stmt = $pdo->prepare("INSERT INTO Gebruiker (gebruikersnaam, voornaam, achternaam, adresregel_1, adresregel_2, postcode, plaatsnaam, land, geboortedag, emailadres, wachtwoord, vraagnummer, antwoordtekst, verkoper_ja_of_nee, geactiveerd_ja_of_nee, activatiecode) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") ;
                $stmt->execute(array($gebruikersnaam, $voornaam, $achternaam, $adresregel_1, $adresregel_2, $postcode, $plaatsnaam, $land, $geboortedag, $emailadres, $wachtwoord, $vraagnummer, $antwoordtekst, $verkoper_ja_of_nee, $geactiveerd_ja_of_nee, $activatiecode));
}
      catch(PDOexeption $e){
          echo $e->getMessage();
}

                return true;
 }

function hashpassword($cleartextpassword){
              $extra_key = ['iconcepts' => 37, ];
              return password_hash($cleartextpassword, PASSWORD_BCRYPT, $extra_key);
            }



//Functie om producten en biedingen weer te geven

function getRubriek($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * from Rubriek where rubriek = $param");
  return $data ->fetchAll(); 
}

function getProductsByHeader($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Voorwerp JOIN Voorwerp_in_Heading ON Voorwerp.voorwerpnummer = Voorwerp_in_Rubriek.voorwerpnummer WHERE rubriek_op_laagste_niveau = $param");

  return $data ->fetchAll();
}


function getVergelijkbareVeilingen($param) {
  global $pdo;
  $heading_nr = getObjectRubriek($param);
  $data = $pdo ->query("SELECT TOP 3 * FROM Voorwerp JOIN Voorwerp_in_Rubriek ON Voorwerp.voorwerpnummer = Voorwerp_in_Rubriek.voorwerpnummer WHERE rubriek_op_laagste_niveau = $heading_nr[rubriek_op_laagste_niveau] AND Voorwerp.voorwerpnummer != $param");

  return $data ->fetchAll();
}

function getObjectRubriek($param) {
  global $pdo;
  $data = $pdo ->query("SELECT rubriek_op_laagste_niveau FROM Voorwerp_in_Rubriek WHERE voorwerpnummer = $param");

  return $data ->fetch();
}

function getAllFiles($param) {
  global $pdo;
  $data = $pdo ->query("SELECT TOP 4 filenaam FROM Bestand WHERE voorwerpnummer = $param");

  return $data ->fetchAll();  
}

function getObject($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Voorwerp WHERE voorwerpnummer = $param");

  return $data ->fetch();
}

function getBiedingen($param) {
  global $pdo;
  $data = $pdo ->query("SELECT TOP 5 * FROM Bod WHERE voorwerpnummer = $param ORDER BY bodbedrag DESC");

  return $data ->fetchAll(); 
}

function bodQuery($objectnr, $amount, $username) {
  global $pdo;
  $data = $pdo->prepare("INSERT INTO Bod VALUES (?,?,?,GETDATE(),CONVERT (time, SYSDATETIME()))");
  $data->execute(array($objectnr, $amount, $username));
}

function startBedragQuery($param) {
  global $pdo;
  $data = $pdo ->query("SELECT startprijs
                       FROM Voorwerp
                       WHERE voorwerpnummer = $param");

  return $data ->fetchAll();
}

function insertNieuwObject(){
    global $pdo;

  $stmt = $pdo->prepare("INSERT INTO Gebruiker (titel, beschrijving, startprijs, betalingswijze, betalingsinstructie, city, country, duration, duration_start_date, duration_start_time, shipping_costs, shipping_instructions, seller, buyer, duration_end_date, duration_end_time, auction_closed, selling_price) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") ;
  $stmt->execute(array($titel, $beschrijving, $startprijs, $betalingswijze, $betalingsinstructie,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $buyer, $duration_end_date, $duration_end_time, $auction_closed, $selling_price));
}

function getUserVeilingen($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM [Object] WHERE seller = '$param'");
  return $data ->fetchAll();
}

function getUserVeilingenBieden($param) {
  global $pdo;
  $data = $pdo ->query("SELECT MAX(bodbedrag) AS bod, Bod.voorwerpnummer, titel FROM Bod JOIN [Object] ON [Object].voorwerpnummer = Bod.voorwerpnummer WHERE username = '$param' GROUP BY Bod.voorwerpnummer, titel");
  return $data ->fetchAll();
}



function insertNieuwFiles($voorwerpnummer, $filename){
  try {
global $pdo;
foreach ([$filename]['name'] as $file)
    {    
$data = $pdo->prepare("INSERT INTO [File] (filename, voorwerpnummer) VALUES (?,?)") ;
$data->execute(array($file, $voorwerpnummer));

}
}
      catch(PDOexeption $e){
          echo $e->getMessage();
}

                return true;
 
}



function insertNieuwObject_in_Heading($voorwerpnummer, $lowest_heading_nr){
try {
global $pdo;

$data = $pdo->prepare("INSERT INTO [Object_in_Heading] (voorwerpnummer, lowest_heading_nr) VALUES (?,?)") ;
$data->execute(array($voorwerpnummer, $lowest_heading_nr));

}
      catch(PDOexeption $e){
          echo $e->getMessage();
}

                return true;
 }

function getObjectnummer($titel, $duration_start_date, $duration_start_time, $seller){
global $pdo;
  
  $data = $pdo->prepare("SELECT voorwerpnummer FROM [Object] WHERE titel = ? AND duration_start_date = ? AND duration_start_time = ? AND seller = ?");
  $data->execute(array($titel, $duration_start_date, $duration_start_time, $seller));
  return $data;

}


// Querys voor admin pagina

// Geeft aantal gebruikers terug
function getAantalUsers()
{
  global $pdo;
  $stmt = $pdo->query("SELECT COUNT(user_id) FROM dbo.Users");
  
  return $stmt->fetch(PDO::FETCH_NUM);
} 


// Geeft alle afgelopen veilingen terug
function getAfgelopenVeilingen(){
  global $pdo;

  $data = $pdo ->query("SELECT voorwerpnummer, titel, buyer, seller FROM dbo.Object
      WHERE  auction_closed = 0 AND CAST(GETDATE() AS DATE) >= duration_end_date ");
      //AND CAST(GETDATE() AS TIME) >= duration_end_time";
       //AND CAST(GETDATE() AS TIME >= duration_end_time)"; 
    return $data ->fetchAll();
}

function koperInObject($voorwerpnummer, $username){
    global $pdo;
      
    $stmt = $pdo->prepare("UPDATE [Object] 
                          SET buyer = (?)
                          WHERE voorwerpnummer = '$voorwerpnummer'");
    $stmt ->execute(array($username));
}

function veilingSluiten($voorwerpnummer){
    global $pdo;
      
    $stmt = $pdo->prepare("UPDATE [Object] 
                          SET auction_closed = 1
                          WHERE voorwerpnummer = '$voorwerpnummer'");
    $stmt ->execute(array());
}

function getAfgeslotenVeilingen(){
    global $pdo;

  $data = $pdo ->query("SELECT voorwerpnummer, titel, buyer, seller FROM dbo.Object
      WHERE  auction_closed = 1");
      //AND CAST(GETDATE() AS TIME) >= duration_end_time";
       //AND CAST(GETDATE() AS TIME >= duration_end_time)"; 
    return $data ->fetchAll();
}

function getEmail($username){
  global $pdo;
  $data = $pdo -> query("SELECT emailaddress FROM dbo.Users WHERE username = '$username'");
  return $data -> fetchAll();
}


function getFeedback($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Feedback JOIN Object ON Object.voorwerpnummer = Feedback.voorwerpnummer WHERE seller = '$param' or buyer = '$param'");
  return $data ->fetchAll();
}


function getFeedbackBeschikbaar($seller, $buyer) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM [Object] WHERE (seller = '$seller' AND buyer = '$buyer') OR (seller = '$buyer' AND buyer = '$seller')");
  return $data ->fetchAll();
}

function insertFeedback($voorwerpnummer, $type, $comment, $writer) {
  global $pdo;
  $stmt = $pdo->prepare("INSERT INTO Feedback VALUES (?,?,GETDATE(),?,GETDATE(),?)") ;
  $stmt ->execute(array($voorwerpnummer, $writer, $type, $comment));
}

function buyerOfseller($user, $voorwerpnummer) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM [Object] WHERE voorwerpnummer = $voorwerpnummer");
  $data = $data ->fetch();

  if ($data['buyer'] == $user) {
    return 'buyer';
  } else {
    return 'seller';
  }
}
?>