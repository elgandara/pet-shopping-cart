<?php
    session_start();
    include("includes/database.php");
    
    $dbConnection = getDataBaseConnection('pet_shop');
    
    if (!isset($_SESSION['count'] ) ) {
        $_SESSION['count'] = 0;
    }
    
    if (!isset($_SESSION['cart']) ) {
        $_SESSION['cart'] = array();
    }
    
    // Add the pet to the cart
    
    if (isset($_GET['addPet']) ) {
        
        $petId = $_SESSION['count'];
        $name = $_GET['addName'];
        $size = $_GET['addSize'];
        $sex = $_GET['addSex'];
        $price = $_GET['addPrice'];
        
        $info = array("name" => $name, "size" => $size, "sex" => $sex, "price" => $price);
        
        $_SESSION['cart'][$petId] = $info;
        
        $_SESSION['count'] = $_SESSION['count'] + 1;
    }
    
    function getInfo() {
        $sql = "SELECT * FROM pet";
        
        $statement = $dbConnection->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
    }
    
    function getSearch()
    {
        global $dbConnection;
        $sql = "SELECT name, size, color, sex, price
                FROM `pet` WHERE 1 ";
        
        if(!empty($_GET['speciesName']))
        {
            $sql .= " AND speciesID = '" . $_GET['speciesName'] . "'";
        }
        if(!empty($_GET['color']))
        {
            $sql .= " AND color = '" . $_GET['color'] . " '";
        }
        if(!empty($_GET['size']) )
        {
            $sql .= " AND size = '" . $_GET['size'] . "'";
        }
        if(!empty($_GET['sex']))
        {
            $sql .= " AND sex = '" . $_GET['sex'] . "'";
        }
        
        if(isset($_GET['maxPrice']) && !empty($_GET['maxPrice']))
        {
            $sql .= " AND price < '" . $_GET['maxPrice'] . "'";
        }
        
        if(isset($_GET['minPrice']) && !empty($_GET['minPrice']))
        {
            $sql .= " AND price > '" . $_GET['minPrice']. "'";
        }
        
        if(isset($_GET['orderBy']) )
        {
            $sql .= " ORDER BY " . $_GET['orderBy'] . " ASC";
        }
        
        $statement = $dbConnection->prepare($sql);
        $statement->execute();
        $records = $statement->fetchALL(PDO::FETCH_ASSOC);
        //var_dump($sql);
        return $records;
    }
    
    function getSpeciesTypes() {
        global $dbConnection;
        
        $sql = "SELECT * FROM `species` ORDER BY speciesName ASC";
        $statement = $dbConnection->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
                
        return $records;
    }
    
    function getAnimalColor() {
        global $dbConnection;
        
        $sql = "SELECT DISTINCT(color) FROM `pet` ORDER BY color ASC";
        $statement = $dbConnection->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
    }
    
    function getAnimalSize() {
        global $dbConnection;
        
        $sql = "SELECT DISTINCT(size) FROM `pet` ORDER BY size ASC";
        $statement = $dbConnection->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
    }
    
    function getAnimalSex() {
        global $dbConnection;
        
        $sql = "SELECT DISTINCT(sex) FROM `pet`";
        $statement = $dbConnection->prepare($sql);
        $statement->execute();
        $records = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $records;
    }
    
    
?>

<!DOCTYPE html>
<html>
    <head>
        <link href = "css/style.css" rel="stylesheet" />
        <title> Rescue Pet Shop </title>
    </head>
    <body>
        <h3> <a href = "https://docs.google.com/document/d/1Eo2y2zFKD88kuV4mdn3TohApAFYa7fsRG6NAc5v-Th0/edit?usp=sharing" target = "_blank"> Documentation </a> </h3>
        <img id="banner" src = "img/banner.png" alt="Shop Banner" title="Shop Banner" />
        <br />
 
    <center>
    <table id="menu">       
        <form>
        <tr>
            <td>
             <!-- Dropdown menu for the sex of the animal -->
            Select Sex:
            <select name = "sex">
                <option value=""> All </option>
                <?php
                    $animalSexes = getAnimalSex();
                    foreach($animalSexes as $animalSex) {
                        echo "<option value'" . $animalSex['petId'] . "'>" . $animalSex['sex'] . "</option>";
                    }
                ?>
            </select>
            
            
            <br /><br />
            <!-- Dropdown menu for the color of the animals -->
            Select Color:
            <select name = "color">
                <option value=""> All </option>
                <?php
                    $animalColors = getAnimalColor();
                    foreach($animalColors as $animalColor) {
                        echo "<option value'" . $animalColor['petId'] . "'>" . $animalColor['color'] . "</option>";
                    }
                
                ?>
            </select>
            
            <br /><br />
            <!-- Dropdown menu for the size of the animal -->
            Select Size:
            <select name = "size">
                <option value=""> All </option>
                <?php
                    $animalSizes = getAnimalSize();
                    foreach($animalSizes as $animalSize) {
                        echo "<option value'" . $animalSize['petId'] . "'>" . $animalSize['size'] . "</option>";
                    }
                
                ?>
            </select>
            
            <br /><br />
            <!-- Dropdown menu for the species -->
            Select Species:
            <select name="speciesId">
                <option value=""> All </option>
                <?php
                    $speciesTypes = getSpeciesTypes();
                    foreach($speciesTypes as $speciesType) {
                        echo "<option value='" . $speciesType['speciesId'] . "'>" . $speciesType['speciesName'] . "</option>";
                    }
                    
                ?>
            </select>
           
            </td>
   
            <td>
                Maximum Price:
                <input type="text" name="maxPrice" size=6>
                <br /><br />
                Minimum Price:
                <input type="text" name="minPrice" size=6>
            </td>
            
            <td>
                Order animals by: <br />
                <input type="radio" name="orderBy" value="speciesId" id="theSpecies"><label for="theSpecies"> Species </lable><br />
                <input type="radio" name="orderBy" value="size" id="theSize"><label for="theSize"> Size </label><br />
                <input type="radio" name="orderBy" value="color" id="theColor"><label for="theColor"> Color </label><br />
                <input type="radio" name="orderBy" value="sex" id="theSex"><label for="theSex"> Sex </label><br />
                <input type="radio" name="orderBy" value="price" id="thePrice"><label for="thePrice"> Price </label><br />
            </td> 
            
        
            <td>   
                <input type="submit" value="Search Pet Shop" name="searchForm"/>
                <br /><br />
                <input type="submit" value="Shopping Cart" name="shoppingCart" formaction="shopping_cart.php"/>
                <br /><br />
            </td> 
        
        </tr>    
        </form>
    </table>
    </center>
     
    <center>  
     <div style="float:right"> 
    <br /><br />
    <table border=1>
        <tr>
            <th> Pet Name </th>
            <th> Species </th>
            <th> Size </th>
            <th> Color </th>
            <th> Sex </th>
            <th> Price </th>
            <th> Add </th>
        </tr>
            
        <div style="float:right">
            <iframe name="petDescriptioniFrame" align="none" src="getDescription.php" frameborder="0"> </iframe>
        </div>
        
        <?php
            $petShopList = getSearch();
            foreach($petShopList as $pet) {
                
                $petId = $pet['petId'];
                $name = $pet['name'];
                $size = $pet['size'];
                $sex = $pet['sex'];
                $price = $pet['price'];
                $link = "index.php?addPet=$petId&addName=$name&addSize=$size&addSex=$sex&addPrice=$price&";
                $anchor = "<a href='$link' > Add to Cart </a>";
                
                echo "<tr>";
                echo "<td><a target='petDescriptioniFrame' href='getDescription.php?petId=".$pet['petId']."' > " . $pet['name'] . "</a></td>";
                echo "<td>" . $pet['speciesId'] . "</td>";
                echo "<td>" . $pet['size'] . "</td>";
                echo "<td>" . $pet['color'] . "</td>";
                echo "<td>" . $pet['sex'] . "</td>";
                echo "<td>" . $pet['price'] . "</td>";
                echo "<td>  $anchor </td>";
                echo "</tr>";
            }
            
        ?>
            
    </table>
    </center> 
  
    
    </div>

    </body>
</html>
