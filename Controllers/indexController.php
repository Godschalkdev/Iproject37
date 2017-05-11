<?php 

require_once './db-util.php';

connectToDatabase();

function printPopulaireVeilingen(){

echo "<div class=\"ui three doubling stackable cards grid container\">";
  $veilingen = getPopulaireVeilingen();
  foreach($veilingen as $veilingen){
        echo "<div class=\"ui card\">";
         echo "<div class=\"image\">";
           echo "<img src=\"../images/Vazen.jpg\">";
          echo "</div>";
          echo "<div class=\"content\">";
            echo "<div class=\"header\">".$veilingen["title"]."</div>";
            echo "<div class=\"meta\">";
              echo "<a>Hoogst uitgebracht bod: €".$veilingen["hoogsteBod"]."</a>";
            echo "</div>";
            echo "<div class=\"description\">".$veilingen["description"]."</div>";
          echo "<div class=\"extra content\">";
            echo "<a href=\"#\">";
              echo "<i class=\"large legal icon\"></i>";
              echo "Ga naar veiling";
            echo "</a>";
         echo "</div>";
        echo "</div>";
        echo "</div>";
    

    
  }
}
?>