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
                        WHERE object_nr = 400808373330
                        GROUP BY username
                        ORDER BY hoogsteBod DESC");
  return $data->fetch();
  }


 function Chk_UserAlreadyExist_email($emailaddress)
    {
      global $pdo;
      $data = $pdo->prepare("SELECT username FROM Users WHERE username = :emailaddress");
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
        $data = $pdo->prepare("SELECT username FROM Users WHERE username = ?");
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



function addNewUser($username, $firstname,$lastname,$address_field1,$address_field2, $ZIP_code, $city, $country, $birthday, $emailaddress, $password, $question_nr, $answer, $seller_yes_or_no,$activated_yes_or_no, $activation_code) {
              
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
  $data = $pdo ->query("SELECT TOP 3 * FROM Object JOIN Object_in_Heading ON Object.object_nr = Object_in_Heading.object_nr WHERE lowest_heading_nr = $heading_nr[lowest_heading_nr]");

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

  return $data ->fetch();  
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


?>
