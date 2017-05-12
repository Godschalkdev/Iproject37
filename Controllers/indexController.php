<?php 

require_once 'Iproject37/db-util.php';

connectToDatabase();

function printPopulaireVeilingen(){

echo "<div class=\"ui three doubling stackable cards grid container\">";
  $populaireVeilingen = getPopulaireVeilingen();
  foreach($populaireVeilingen as $populaireVeilingen){
        echo "<div class=\"ui card\">";
         echo "<div class=\"image\">";
           echo "<img src=\"../images/Vazen.jpg\"></div>";
          echo "<div class=\"content\">";
            echo "<div class=\"header\">".$populaireVeilingen["title"]."</div>";
            echo "<div class=\"meta\">";
              echo "<a>Hoogst uitgebracht bod: €".$populaireVeilingen["hoogsteBod"]."</a>";
            echo "</div>";
            echo "<div class=\"description\">".$populaireVeilingen["description"]."</div>";
          echo "<div class=\"extra content\">";
            echo "<a href=\"#\">";
              echo "<i class=\"large legal icon\"></i>";
              echo "Ga naar veiling </a>";
         echo "</div>";
        echo "</div>";
        echo "</div>";
  }
}

function printKoopjesVeilingen(){


echo "<div class=\"ui three doubling stackable cards grid container\">";
  $koopjesVeilingen = getKoopjes();
  foreach($koopjesVeilingen as $koopjesVeilingen){
        echo "<div class=\"ui card\">";
         echo "<div class=\"image\">";
           echo "<img src=\"../images/Vazen.jpg\"></div>";
          echo "<div class=\"content\">";
            echo "<div class=\"header\">".$koopjesVeilingen["title"]."</div>";
            echo "<div class=\"meta\">";
              echo "<a>Hoogst uitgebracht bod: €".$koopjesVeilingen["hoogsteBod"]."</a>";
            echo "</div>";
            echo "<div class=\"description\">".$koopjesVeilingen["description"]."</div>";
          echo "<div class=\"extra content\">";
            echo "<a href=\"#\">";
              echo "<i class=\"large legal icon\"></i>";
              echo "Ga naar veiling</a>";
         echo "</div>";
        echo "</div>";
        echo "</div>";
    

    
  }
}

function printNieuweVeilingen(){
echo "<div class=\"ui three doubling stackable cards grid container\">";
  $nieuweVeilingen = getNieuweVeilingen();
  foreach($nieuweVeilingen as $nieuweVeilingen){
        echo "<div class=\"ui card\">";
         echo "<div class=\"image\">";
           echo "<img src=\"../images/Vazen.jpg\"></div>";
          echo "<div class=\"content\">";
            echo "<div class=\"header\">".$nieuweVeilingen["title"]."</div>";
            echo "<div class=\"meta\">";
              echo "<a>Hoogst uitgebracht bod: €".$nieuweVeilingen["hoogsteBod"]."</a>";
            echo "</div>";
            echo "<div class=\"description\">".$nieuweVeilingen["description"]."</div>";
          echo "<div class=\"extra content\">";
            echo "<a href=\"#\">";
              echo "<i class=\"large legal icon\"></i>";
              echo "Ga naar veiling</a>";
         echo "</div>";
        echo "</div>";
        echo "</div>";
    

    
  }
}


function printBijzondereVeilingen(){

echo "<div class=\"ui three doubling stackable cards grid container\">";
  $bijzondereVeilingen = getBijzondereVeilingen();
  foreach($bijzondereVeilingen as $bijzondereVeilingen){
        echo "<div class=\"ui card\">";
         echo "<div class=\"image\">";
           echo "<img src=\"../images/Vazen.jpg\"></div>";
          echo "<div class=\"content\">";
            echo "<div class=\"header\">".$bijzondereVeilingen["title"]."</div>";
            echo "<div class=\"meta\">";
              echo "<a>Hoogst uitgebracht bod: €".$bijzondereVeilingen["hoogsteBod"]."</a>";
            echo "</div>";
            echo "<div class=\"description\">".$bijzondereVeilingen["description"]."</div>";
          echo "<div class=\"extra content\">";
            echo "<a href=\"#\">";
              echo "<i class=\"large legal icon\"></i>";
              echo "Ga naar veiling</a>";
         echo "</div>";
        echo "</div>";
        echo "</div>";
    

    
  }
}
?>