<?php

include('../../includes/database.php');

function getDescription() {
   $dbConnection = getDatabaseConnection('pet_shop');
   $sql = "SELECT petDescription 
           FROM pet
           WHERE animalId = :animalId";
   $namedParameters = array(":animalId"=>$_GET['animalId']);
   $statement =  $dbConnection->prepare($sql);
   $statement->execute($namedParameters);
   //$product = $statement->fetch(PDO::FETCH_ASSOC);
   //return $product;
   return $statement->fetch(PDO::FETCH_ASSOC);
    
}

?>

<!DOCTYPE html>
<html>
    <head>
        <title> </title>
    </head>
    <body>

        <?php
        
        $productInfo = getDescription();
        echo $productInfo['petDescription'];
        
        
        ?>

    </body>
</html>