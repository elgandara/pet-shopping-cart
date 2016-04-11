<?php
    session_start();
    include ("includes/database.php");
    
    $dbConnection = getDataBaseConnection('pet_shop');
    
    function getSpeciesTypes() {
        global $dbConnection;
        $sql = "SELECT * FROM species";
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
        <h1> Rescue Pet Shop </h1>
        
        <form>
            Select Species:
            <select name="speciesName">
                <option value=""> All </option>
                <?php
                    $speciesTypes = getSpeciesTypes();
                    foreach($speciesTypes as $speciesType) {
                        echo "<option value='" . $speciesType['speciesId'] . "'>" . $speciesType['speciesType'] . "</option>";
                    }
                    
                ?>
                
            </select>
        </form>

    </body>
</html>
<!--there is a group chat in the collaborate tab -->

