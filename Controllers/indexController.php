<?php 

require('db-util.php');

connectToDatabase();

function printPopulaireVeilingen(){


  $populaireVeilingen = getPopulaireVeilingen();
  foreach($populaireVeilingen as $populaireVeilingen){
$piemel = <<<MYCONTENT
        <div class="ui card">
          <div class="image">
            <img src="../images/Vazen.jpg">
           </div>
         <div class="content">
            <div class="header"> $populaireVeilingen[title] </div>
              <a class ="meta">Hoogst uitgebracht bod: € $populaireVeilingen[hoogsteBod] </a>
           <div class="description"> $populaireVeilingen[description] </div>
          <div class="extra content">
            <a href="#">
             <i class="large legal icon"></i>
              Ga naar veiling </a>
              </div>
         </div>
       </div> 
MYCONTENT;
echo $piemel; 
 }
}

?>