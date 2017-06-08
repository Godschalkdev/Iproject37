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
 function Chk_LoginDetails($username, $plaintextpassword)
    {
      global $pdo;
      $data = $pdo->prepare("SELECT username, password, emailaddress FROM [User] WHERE username = ? AND activated_yes_or_no = 'yes' ");
      $data->execute(array($username));

      $datas = $data->fetch();
      $count = count($datas);
      if ($count > 0) {
        if (password_verify($plaintextpassword, $datas["password"])) {
          return array($datas["username"],$datas["emailaddress"]);
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
  $data = $pdo->query("SELECT TOP 3 title, description, max(offer_amount) as hoogsteBod,count(offer_amount) as totaleOffers, b.object_nr FROM Object b inner join Offer f ON b.object_nr = f.object_nr GROUP BY title, description, b.object_nr ORDER BY TotaleOffers desc");
  return $data->fetchAll();
  
}

function getfile($objectnummer) {
  global $pdo;
    $data = $pdo->query("SELECT * FROM [File] WHERE object_nr = $objectnummer");
  return $data->fetch();
}

function getBijzondereVeilingen(){

  global $pdo;
  $data = $pdo->query("SELECT TOP 3 b.object_nr, title, description, starting_price, MAX(offer_amount) as hoogsteBod, CAST(((100 / (b.starting_price+1)) * (max(f.offer_amount) - b.starting_price)) as NUMERIC(12,2)) as percentageVerschil FROM Object as b Inner JOIN Offer as f On b.object_nr = f.object_nr Group by title, description, starting_price, b.object_nr ORDER BY percentageVerschil desc");
  return $data->fetchAll();
}


function getKoopjes(){
global $pdo; 
$data = $pdo ->query("SELECT TOP 3  b.object_nr, title, description, starting_price ,MAX(offer_amount) as hoogsteBod, count(offer_amount) as totaleOffers 
FROM Object b INNER JOIN Offer f on b.object_nr = f.object_nr 
GROUP BY starting_price, title, description , b.object_nr
having starting_price <= 100 AND ((100 / (b.starting_price+1)) * (max(f.offer_amount) - b.starting_price)) < 100
ORDER BY totaleOffers desc");
return $data -> fetchAll();
}

function getNieuweVeilingen(){

  global $pdo; 
  $data = $pdo ->query("SELECT top 3 Object.object_nr, duration_start_date, duration_start_time, title
                        FROM Object
                        ORDER BY duration_start_date desc, duration_start_time desc"); 
  return $data -> fetchAll();
}

function getHoogsteBod($param){
  global $pdo;
  $data = $pdo ->query("SELECT TOP 1 MAX(offer_amount) as hoogsteBod, username
                        FROM Offer
                        WHERE object_nr = $param
                        GROUP BY username
                        ORDER BY hoogsteBod DESC");
  return $data->fetch();
  }



//Functies op nieuwe gebruikers te registreren

 function Chk_UserAlreadyExist_email($emailaddress)
    {
      global $pdo;
      $data = $pdo->prepare("SELECT emailaddress FROM [User] WHERE emailaddress = ?");
      $data->execute(array($emailaddress));
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
        $data = $pdo->prepare("SELECT username FROM [User] WHERE username = ?");
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
                 
    $data = $pdo->prepare("SELECT emailaddress, activation_code, activated_yes_or_no FROM [user] WHERE emailaddress = ? AND activation_code = ? AND activated_yes_or_no = 'no' ");
    $data->execute(array($emailaddress, $activation_code));
    $count = count($data->fetchAll());
                 
    if($count > 0){
        // We have a match, activate the account
      $updateActive = $pdo->prepare("UPDATE [User] SET activated_yes_or_no ='yes' WHERE emailaddress = ? AND activation_code = ? AND activated_yes_or_no = 'no'");
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



function addNewUser($username, $firstname,$lastname,$address_field1,$address_field2, $ZIP_code, $city, $country, $birthday, $emailaddress, $password, $question_nr, $answer, $seller_yes_or_no, $activated_yes_or_no, $activation_code) {
              
                try{ 
                  global $pdo;
    
                $stmt = $pdo->prepare("INSERT INTO [User] (username, firstname, lastname, addressfield_1, addressfield_2, ZIP_code, city, country, birthday, emailaddress, password, question_nr, answer, seller_yes_or_no, activated_yes_or_no, activation_code) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)") ;
                $stmt->execute(array($username, $firstname, $lastname, $address_field1, $address_field2, $ZIP_code, $city, $country, $birthday, $emailaddress, $password, $question_nr, $answer, $seller_yes_or_no, $activated_yes_or_no, $activation_code));
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
  $data = $pdo ->query("SELECT * from heading where heading_nr_parent = $param");
  return $data ->fetchAll(); 
}

function getProductsByHeader($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Object JOIN Object_in_Heading ON Object.object_nr = Object_in_Heading.object_nr WHERE lowest_heading_nr = $param");

  return $data ->fetchAll();
}


function getVergelijkbareVeilingen($param) {
  global $pdo;
  $heading_nr = getObjectRubriek($param);
  $data = $pdo ->query("SELECT TOP 3 * FROM Object JOIN Object_in_Heading ON Object.object_nr = Object_in_Heading.object_nr WHERE lowest_heading_nr = $heading_nr[lowest_heading_nr] AND Object.object_nr != $param");

  return $data ->fetchAll();
}

function getObjectRubriek($param) {
  global $pdo;
  $data = $pdo ->query("SELECT lowest_heading_nr FROM Object_in_Heading WHERE object_nr = $param");

  return $data ->fetch();
}

function getAllFiles($param) {
  global $pdo;
  $data = $pdo ->query("SELECT filename FROM [File] WHERE object_nr = $param");

  return $data ->fetchAll();  
}

function getObject($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Object WHERE object_nr = $param");

  return $data ->fetch();
}

function getBiedingen($param) {
  global $pdo;
  $data = $pdo ->query("SELECT TOP 5 * FROM Offer WHERE object_nr = $param ORDER BY offer_amount DESC");

  return $data ->fetchAll(); 
}

function bodQuery($objectnr, $amount, $username) {
  global $pdo;
  $data = $pdo->prepare("INSERT INTO Offer VALUES (?,?,?,GETDATE(),CONVERT (time, SYSDATETIME()))");
  $data->execute(array($objectnr, $amount, $username));
}

function startBedragQuery($param) {
  global $pdo;
  $data = $pdo ->query("SELECT starting_price
                       FROM [Object]
                       WHERE object_nr = $param");

  return $data ->fetchAll();
}


function getUserVeilingen($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM [Object] WHERE seller = '$param'");
  return $data ->fetchAll();
}

function getUserVeilingenBieden($param) {
  global $pdo;
  $data = $pdo ->query("SELECT MAX(offer_amount) AS bod, Offer.object_nr, title FROM Offer JOIN [Object] ON [Object].object_nr = Offer.object_nr WHERE username = '$param' GROUP BY Offer.object_nr, title");
  return $data ->fetchAll();

}




//Nieuwe object toevoegen functies
function insertNieuwObject($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed){

try {
global $pdo;
    
$data = $pdo->prepare("INSERT INTO [Object] (title, description, starting_price, payment_method, payment_instructions,city, country, duration, duration_start_date, duration_start_time, shipping_costs, shipping_instructions, seller, duration_end_date, duration_end_time, auction_closed, selling_price) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?, null)") ;

$data->execute(array($title, $description, $starting_price, $payment_method, $payment_instructions,$city, $country, $duration, $duration_start_date, $duration_start_time, $shipping_costs, $shipping_instructions, $seller, $duration_end_date, $duration_end_time, $auction_closed));
}
      catch(PDOexeption $e){
          echo $e->getMessage();
}

                return true;
 }



function insertNieuwFiles($object_nr, $filename){
  try {
global $pdo;
foreach ([$filename]['name'] as $file)
    {    
$data = $pdo->prepare("INSERT INTO [File] (filename, object_nr) VALUES (?,?)") ;
$data->execute(array($file, $object_nr));

}
}
      catch(PDOexeption $e){
          echo $e->getMessage();
}

                return true;
 
}



function insertNieuwObject_in_Heading($object_nr, $lowest_heading_nr){
try {
global $pdo;

$data = $pdo->prepare("INSERT INTO [Object_in_Heading] (object_nr, lowest_heading_nr) VALUES (?,?)") ;
$data->execute(array($object_nr, $lowest_heading_nr));

}
      catch(PDOexeption $e){
          echo $e->getMessage();
}

                return true;
 }

function getObjectnummer($title, $duration_start_date, $duration_start_time, $seller){
global $pdo;
  
  $data = $pdo->prepare("SELECT object_nr FROM [Object] WHERE title = ? AND duration_start_date = ? AND duration_start_time = ? AND seller = ?");
  $data->execute(array($title, $duration_start_date, $duration_start_time, $seller));
  return $data;

}


// Querys voor admin pagina

// Geeft aantal gebruikers terug
function getAantalGebruikers()
{
  global $pdo;
  $stmt = $pdo->query("SELECT COUNT(user_id) FROM dbo.User");
  
  return $stmt->fetch(PDO::FETCH_NUM);
} 

function getAantalVeilingen(){
    global $pdo;
  $stmt = $pdo->query("SELECT COUNT(object_nr) FROM dbo.Object");
  
  return $stmt->fetch(PDO::FETCH_NUM);
}

function getAantalCategorieen(){
    global $pdo;
  $stmt = $pdo->query("SELECT COUNT(heading_nr) FROM dbo.Heading");
  
  return $stmt->fetch(PDO::FETCH_NUM);
}



// Geeft alle afgelopen veilingen terug
function getAfgelopenVeilingen(){
  global $pdo;

  $data = $pdo ->query("SELECT object_nr, title, buyer, seller FROM dbo.Object
      WHERE  auction_closed = 0 AND CAST(GETDATE() AS DATE) >= duration_end_date ");
      //AND CAST(GETDATE() AS TIME) >= duration_end_time";
       //AND CAST(GETDATE() AS TIME >= duration_end_time)"; 
    return $data ->fetchAll();
}


function getVeilingenAdmin($laagRijNummer, $hoogRijNummer){
  global $pdo;

  $stmt = $pdo ->prepare("SELECT * FROM  
                  (SELECT ROW_NUMBER() OVER(ORDER BY object_nr) 
                  AS rownumber, object_nr, title, seller, buyer FROM dbo.Object) 
                AS Temp 
                WHERE rownumber BETWEEN ? AND ?");
  $stmt->execute(array($laagRijNummer, $hoogRijNummer));
  //$data = $pdo -> query("SELECT object_nr, title, seller, buyer FROM dbo.Object ORDER BY object_nr");

  return $stmt -> fetchAll();
}

function getCategorieenAdmin($laagRijNummer, $hoogRijNummer){
  global $pdo;
  $stmt = $pdo -> prepare("SELECT * FROM  
                  (SELECT ROW_NUMBER() OVER(ORDER BY heading_nr) 
                  AS rownumber, heading_nr, heading_name, heading_nr_parent FROM dbo.Heading) 
                AS Temp 
                WHERE rownumber BETWEEN ? AND ?");

  $stmt->execute(array($laagRijNummer, $hoogRijNummer));
  return $stmt ->fetchAll();
}

function getGebruikersAdmin($laagRijNummer, $hoogRijNummer){
  global $pdo;
  $stmt = $pdo -> prepare("SELECT * FROM  
                  (SELECT ROW_NUMBER() OVER(ORDER BY user_id) 
                  AS rownumber, user_id, username, firstname, lastname, emailaddress FROM dbo.User) 
                AS Temp 
                WHERE rownumber BETWEEN ? AND ?");

  $stmt->execute(array($laagRijNummer, $hoogRijNummer));
  return $stmt ->fetchAll();
}

// delete
function deleteVeilingAdmin($verwijder_id){
    global $pdo;

  $stmt = $pdo -> prepare("DELETE FROM dbo.Object WHERE object_nr='$verwijder_id'");

  return $stmt ->execute();
}

function deleteGebruikerAdmin($verwijder_id){
    global $pdo;

  $stmt = $pdo -> prepare("DELETE FROM dbo.User WHERE user_id='$verwijder_id'");

  return $stmt ->execute();
}

function deleteCategorieAdmin($verwijder_id){
    global $pdo;

  $stmt = $pdo -> prepare("DELETE FROM dbo.Heading WHERE heading_nr='$verwijder_id'");

  return $stmt ->execute();
}

// update

function koperInObject($object_nr, $username){
    global $pdo;
      
    $stmt = $pdo->prepare("UPDATE [Object] 
                          SET buyer = (?)
                          WHERE object_nr = '$object_nr'");
    $stmt ->execute(array($username));
}

function veilingSluiten($object_nr){
    global $pdo;
      
    $stmt = $pdo->prepare("UPDATE [Object] 
                          SET auction_closed = 1
                          WHERE object_nr = '$object_nr'");
    $stmt ->execute(array());
}

function getAfgeslotenVeilingen(){
    global $pdo;

  $data = $pdo ->query("SELECT object_nr, title, buyer, seller FROM dbo.Object
      WHERE  auction_closed = 1");
      //AND CAST(GETDATE() AS TIME) >= duration_end_time";
       //AND CAST(GETDATE() AS TIME >= duration_end_time)"; 
    return $data ->fetchAll();
}

function getEmail($username){
  global $pdo;
  $data = $pdo -> query("SELECT emailaddress FROM dbo.User WHERE username = '$username'");
  return $data -> fetch();
}



function getFeedback($param) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM Feedback JOIN Object ON Object.object_nr = Feedback.object_nr WHERE seller = '$param'");
  return $data ->fetchAll();
}



function getFeedbackBeschikbaar($user, $logger) {
  global $pdo;
  $data = $pdo ->query("SELECT * FROM [Object] WHERE seller = '$user' AND buyer = '$logger'");
  return $data ->fetchAll();
}

// zoeken

function adminZoekenGebruiker($zoekinput){
  global $pdo;
 
  $zoekinput = $_POST['zoeken'];
  $stmt = $pdo -> query("SELECT user_id, username, firstname, lastname, emailaddress FROM dbo.User
                     WHERE user_id LIKE '%".$zoekinput."%'
                        OR username LIKE '%".$zoekinput."%'
                        OR firstname LIKE '%".$zoekinput."%'
                        OR lastname LIKE '%".$zoekinput."%'
                        OR emailaddress LIKE '%".$zoekinput."%'");
 

  return $stmt ->fetchAll();
}

function adminZoekenCategorie($zoekinput){
  global $pdo;
  $zoekinput = $_POST['zoeken'];

  $stmt = $pdo -> query("SELECT heading_nr, heading_name, heading_nr_parent FROM dbo.Heading
               WHERE heading_nr LIKE '%".$zoekinput."%'
                  OR heading_name LIKE '%".$zoekinput."%'
                  OR heading_nr_parent LIKE '%".$zoekinput."%'");
 

  return $stmt ->fetchAll();
}

function adminZoekenVeiling($zoekinput){
  global $pdo;
  $zoekinput = $_POST['zoeken'];

  $stmt = $pdo -> query("SELECT object_nr, title, seller, buyer FROM dbo.Object
               WHERE object_nr LIKE '%".$zoekinput."%'
                  OR title LIKE '%".$zoekinput."%'
                  OR seller LIKE '%".$zoekinput."%'
                  OR buyer LIKE '%".$zoekinput."%'");
 

  return $stmt ->fetchAll();
}

?>