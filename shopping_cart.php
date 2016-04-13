<?php
    session_start();
    
    /*
    if (!isset($_SESSION['count'] ) ) {
        $_SESSION['count'] = 0;
    }
    
    if ($_SESSION['count'] == 0) {
        initializeSessionArray();
        $_SESSION['count'] += 1;
    }
    
    function initializeSessionArray() {
        $petId = 0;
        $info = array("name", "size", "color", "sex", "price");
        
        $_SESSION['cart'] = array($petId => $info);
    }
    */
    
    // Remove a pet from the $_SESSION array
    if (isset($_GET['petId'] ) ) {
    
        $petId = $_GET['petId'];
        unset($_SESSION['cart'][$petId]);
        unset($_GET['petId']);
    }
    
    // $_SESSION['cart'] : an associative array 
    // (key -> petId | value -> array(name, size, color, sex, price)
    function displayShoppingCart() {

        if (sizeOf($_SESSION['cart']) > 0) {
            echo "<table>";
            
            echo "<th> Name </th>";
            echo "<th> Size </th>";
            echo "<th> Gender </th>";
            echo "<th> Price </th>";
            echo "<th> Remove </th>";
            
            foreach ($_SESSION['cart'] as $petId => $petInfo) {
                echo "<tr>";
                foreach ($petInfo as $data) {
                    echo "<td> $data </td>";
                }
                            
                // Create the anchor tag that will be used to remove an entry
                $link = "shopping_cart.php?petId=$petId";
                $anchor = "<a class='button' href='$link'> Remove </a>";
                echo "<td> $anchor </td>";
                echo "</tr>";
            }
            echo "</table>";
            
        }
        
        else {
            echo "<h3> Your shopping cart is empty. </h3>";
        }
    }
    
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <title> Shopping Cart</title>
        <link rel="stylesheet" href="css/style.css" >
    </head>
    <body>
    
    <h1> Rescue Pet Shop </h1><br>
    
    <div id="menu">
    <br>
    <form style="padding-left:25px"> <input type="submit" value="Keep Shopping" formaction="index.php" > </form>
    <br>
    </div>
    
    <h3> Shopping Cart </h3>
    
        <?= displayShoppingCart() ?>

    </body>
</html>