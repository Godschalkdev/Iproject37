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
  $data = $pdo->query("SELECT TOP 3 b.voorwerpnummer, titel, beschrijving, startprijs, MAX(bodbedrag) as hoogsteBod, CAST(((100 / (b.startprijs+1)) * (max(f.bodbedrag) - b.startprijs)) as NUMERIC(12,2)) as percentageVerschil FROM Voorwerp as b Inner JOIN Bod as f On b.voorwerpnummer = f.voorwerpnummer Group by titel, beschrijving, startprijs, b.voorwerpnummer ORDER BY percentageVerschil desc");
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
  $data = $pdo ->query("SELECT * FROM Voorwerp JOIN Voorwerp_in_Rubriek ON Voorwerp.voorwerpnummer = Voorwerp_in_Rubriek.voorwerpnummer WHERE rubriek_op_laagste_niveau = $param");
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

function getUserVeilingen($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Voorwerp WHERE verkoper = '$param'");
  return $data ->fetchAll();
}

function getUserVeilingenBieden($param) {
  global $pdo;
  $data = $pdo ->query("SELECT MAX(bodbedrag) AS bod, Bod.voorwerpnummer, titel FROM Bod JOIN Voorwerp ON Voorwerp.voorwerpnummer = Bod.voorwerpnummer WHERE username = '$param' GROUP BY Bod.voorwerpnummer, titel");
  return $data ->fetchAll();
}
//Nieuwe object toevoegen functies
function insertNieuwObject($titel, $beschrijving, $startprijs, $betalingswijze, $betlingsinstructie, $plaatsnaam, $land, $looptijd, $looptijd_start_dag, $looptijd_start_tijdstip, $verzendkosten, $shipping_instructions, $verkoper, $looptijd_einde_dag, $looptijd_einde_tijdstip, $veilingstatus){
try {
global $pdo;
    
$data = $pdo->prepare("INSERT INTO Voorwerp (titel, beschrijving, startprijs, betalingswijze, betlingsinstructie,plaatsnaam, land, looptijd, looptijd_start_dag, looptijd_start_tijdstip, verzendkosten, shipping_instructions, verkoper, looptijd_einde_dag, looptijd_einde_tijdstip, veilingstatus, verkoopprijs) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, null)") ;
$data->execute(array($titel, $beschrijving, $startprijs, $betalingswijze, $betlingsinstructie,$plaatsnaam, $land, $looptijd, $looptijd_start_dag, $looptijd_start_tijdstip, $verzendkosten, $shipping_instructions, $verkoper, $looptijd_einde_dag, $looptijd_einde_tijdstip, $veilingstatus));
}
      catch(PDOexeption $e){
          echo $e->getMessage();
}
                return true;
 }
function insertNieuwFiles($voorwerpnummer, $filenaam){
  try {
global $pdo;
foreach ([$filenaam]['name'] as $file)
    {    
$data = $pdo->prepare("INSERT INTO Bestand (filenaam, voorwerpnummer) VALUES (?,?)") ;
$data->execute(array($file, $voorwerpnummer));
}
}
      catch(PDOexeption $e){
          echo $e->getMessage();
}
                return true;
 
}
function insertNieuwObject_in_Heading($voorwerpnummer, $rubriek_op_laagste_niveau){
try {
global $pdo;
$data = $pdo->prepare("INSERT INTO Voorwerp_in_Rubriek (voorwerpnummer, rubriek_op_laagste_niveau) VALUES (?,?)") ;
$data->execute(array($voorwerpnummer, $rubriek_op_laagste_niveau));
}
      catch(PDOexeption $e){
          echo $e->getMessage();
}
                return true;
 }
function getObjectnummer($titel, $looptijd_start_dag, $looptijd_start_tijdstip, $verkoper){
global $pdo;
  
  $data = $pdo->prepare("SELECT voorwerpnummer FROM Voorwerp WHERE titel = ? AND looptijd_start_dag = ? AND looptijd_start_tijdstip = ? AND verkoper = ?");
  $data->execute(array($titel, $looptijd_start_dag, $looptijd_start_tijdstip, $verkoper));
  return $data;
}
// Querys voor admin pagina
// Geeft aantal gebruikers terug
function getAantalGebruikers()
{
  global $pdo;
  $stmt = $pdo->query("SELECT COUNT(gebruiker_id) FROM dbo.Gebruiker");
  
  return $stmt->fetch(PDO::FETCH_NUM);
} 
function getAantalVeilingen(){
    global $pdo;
  $stmt = $pdo->query("SELECT COUNT(voorwerpnummer) FROM dbo.Voorwerp");
  
  return $stmt->fetch(PDO::FETCH_NUM);
}
function getAantalCategorieen(){
    global $pdo;
  $stmt = $pdo->query("SELECT COUNT(rubrieknummer) FROM dbo.Rubriek");
  
  return $stmt->fetch(PDO::FETCH_NUM);
}
// Geeft alle afgelopen veilingen terug
function getAfgelopenVeilingen(){
  global $pdo;
  $data = $pdo ->query("SELECT voorwerpnummer, titel, koper, verkoper FROM dbo.Voorwerp
      WHERE  veilingstatus = 0 AND CAST(GETDATE() AS DATE) >= looptijd_einde_dag");
      //AND CAST(GETDATE() AS TIME) >= duration_end_time";
       //AND CAST(GETDATE() AS TIME >= duration_end_time)"; 
    return $data ->fetchAll();
}
function getVeilingenAdmin($laagRijNummer, $hoogRijNummer){
  global $pdo;
  $stmt = $pdo ->prepare("SELECT * FROM  
                  (SELECT ROW_NUMBER() OVER(ORDER BY voorwerpnummer) 
                  AS rownumber, voorwerpnummer, titel, verkoper, koper FROM dbo.Voorwerp) 
                AS Temp 
                WHERE rownumber BETWEEN ? AND ?");
  $stmt->execute(array($laagRijNummer, $hoogRijNummer));
  //$data = $pdo -> query("SELECT object_nr, title, seller, buyer FROM dbo.Object ORDER BY object_nr");
  return $stmt -> fetchAll();
}
function getCategorieenAdmin($laagRijNummer, $hoogRijNummer){
  global $pdo;
  $stmt = $pdo -> prepare("SELECT * FROM  
                  (SELECT ROW_NUMBER() OVER(ORDER BY rubrieknummer) 
                  AS rownumber, rubrieknummer, rubrieknaam, rubriek FROM dbo.Rubriek) 
                AS Temp 
                WHERE rownumber BETWEEN ? AND ?");
  $stmt->execute(array($laagRijNummer, $hoogRijNummer));
  return $stmt ->fetchAll();
}
function getGebruikersAdmin($laagRijNummer, $hoogRijNummer){
  global $pdo;
  $stmt = $pdo -> prepare("SELECT * FROM  
                  (SELECT ROW_NUMBER() OVER(ORDER BY gebruiker_id) 
                  AS rownumber, gebruiker_id, gebruikersnaam, voornaam, achternaam, emailadres FROM dbo.Gebruiker) 
                AS Temp 
                WHERE rownumber BETWEEN ? AND ?");
  $stmt->execute(array($laagRijNummer, $hoogRijNummer));
  return $stmt ->fetchAll();
}
// delete
function deleteVeilingAdmin($verwijder_id){
    global $pdo;
  $stmt = $pdo -> prepare("DELETE FROM Voorwerp WHERE voorwerpnummer='$verwijder_id'");
  return $stmt ->execute();
}
function deleteGebruikerAdmin($verwijder_id){
    global $pdo;
  $stmt = $pdo -> prepare("DELETE FROM Gebruiker WHERE gebruiker_id='$verwijder_id'");
  return $stmt ->execute();
}
function deleteCategorieAdmin($verwijder_id){
    global $pdo;
  $stmt = $pdo -> prepare("DELETE FROM Rubriek WHERE rubrieknummer='$verwijder_id'");
  return $stmt ->execute();
}
// update
function koperInObject($object_nr, $username){
    global $pdo;
      
    $stmt = $pdo->prepare("UPDATE Voorwerp 
                          SET koper = (?)
                          WHERE voorwerpnummer = '$object_nr'");
    $stmt ->execute(array($username));
}
function veilingSluiten($voorwerpnummer){
    global $pdo;
      
    $stmt = $pdo->prepare("UPDATE Voorwerp 
                          SET veilingstatus = 1
                          WHERE voorwerpnummer = '$voorwerpnummer'");
    $stmt ->execute(array());
}
function getAfgeslotenVeilingen(){
    global $pdo;
  $data = $pdo ->query("SELECT voorwerpnummer, titel, koper, verkoper FROM Voorwerp
      WHERE  veilingstatus = 1");
      //AND CAST(GETDATE() AS TIME) >= duration_end_time";
       //AND CAST(GETDATE() AS TIME >= duration_end_time)"; 
    return $data ->fetchAll();
}
function getEmail($gebruikersnaam){
  global $pdo;
  $data = $pdo -> query("SELECT emailadres FROM Gebruiker WHERE gebruikersnaam = '$gebruikersnaam'");
  return $data -> fetch();
}
function getFeedback($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Feedback JOIN Voorwerp ON Voorwerp.voorwerpnummer = Feedback.voorwerpnummer WHERE verkoper = '$param' or koper = '$param'");
  return $data ->fetchAll();
}
function getFeedbackBeschikbaar($verkoper, $koper) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Voorwerp WHERE (verkoper = '$verkoper' AND koper = '$koper') OR (verkoper = '$koper' AND koper = '$verkoper')");
  return $data ->fetchAll();
}
function insertFeedback($voorwerpnummer, $feedbacksoort, $commentaar, $schrijver) {
  global $pdo;
  $stmt = $pdo->prepare("INSERT INTO Feedback VALUES (?,?,GETDATE(),?,GETDATE(),?)") ;
  $stmt ->execute(array($voorwerpnummer, $schrijver, $feedbacksoort, $commentaar));
}
function buyerOfseller($gebruiker, $voorwerpnummer) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Voorwerp WHERE voorwerpnummer = $voorwerpnummer");
  $data = $data ->fetch();
  if ($data['koper'] == $gebruiker) {
    return 'koper';
  } else {
    return 'verkoper';
  }
}
function adminZoekenGebruiker($zoekinput){
  global $pdo;
 
  $stmt = $pdo -> query("SELECT gebruiker_id, gebruikersnaam, voornaam, achternaam, emailadres FROM Gebruiker
                     WHERE gebruiker_id LIKE '%$zoekinput%'
                        OR gebruikersnaam LIKE '%$zoekinput%'
                        OR voornaam LIKE '%$zoekinput%'
                        OR achternaam LIKE '%$zoekinput%'
                        OR emailadres LIKE '%$zoekinput%'");
 
  return $stmt ->fetchAll();
}
function adminZoekenCategorie($zoekinput){
  global $pdo;
  $zoekinput = $_POST['zoeken'];
  $stmt = $pdo -> query("SELECT rubrieknummer, rubrieknaam, rubriek FROM Rubriek
               WHERE rubrieknummer LIKE '%$zoekinput%'
                  OR rubrieknaam LIKE '%$zoekinput%'
                  OR rubriek LIKE '%$zoekinput%'");
 
  return $stmt ->fetchAll();
}
function adminZoekenVeiling($zoekinput){
  global $pdo;
  $zoekinput = $_POST['zoeken'];
  $stmt = $pdo -> query("SELECT voorwerpnummer, titel, verkoper, koper FROM Voorwerp
               WHERE voorwerpnummer LIKE '%$zoekinput%'
                  OR titel LIKE '%$zoekinput%'
                  OR verkoper LIKE '%$zoekinput%'
                  OR koper LIKE '%$zoekinput%'");
 
  return $stmt ->fetchAll();
}
?>