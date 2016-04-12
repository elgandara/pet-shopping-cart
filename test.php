<?php
    include("includes/database.php");
    
    $dbConnection = getDatabaseConnection('pet_shop');
    
    // Initialize values
    $_GET['color'] = '';
    $_GET['size'] = '';
    $_GET['sex'] = '';
    $_GET['orderBy'] = 'species';
    
    $_GET['speciesId'] = "3";
    
    
    function getSearch()
    {
        global $dbConnection;
        $sql = "SELECT name, size, color, sex, price
                FROM pet WHERE 1 ";
        $namedParamaters = array();
        
        
        if (!empty($_GET['speciesId'] ) ) {
            $sql .= " AND speciesId = :speciesId";
            $namedParamaters[":speciesId"] = $_GET["speciesId"];
        }
        
        if (!empty($_GET['size'] ) ) {
            $sql .= " AND size = :size";
            $namedParamaters[":size"] = $_GET["size"];
        }
        
        if (!empty($_GET['color'] ) ) {
            $sql .= " AND color = :color";
            $namedParamaters[":color"] = $_GET["color"];
        }
        if (!empty($_GET['sex'] ) ) {
            $sql .= " AND sex = :sex";
            $namedParamaters[":sex"] = $_GET["sex"];
        }
        if (isset($_GET['maxPrice'] ) ) {
            $sql .= " AND price < :maxPrice";
            $namedParamaters[":maxPrice"] = $_GET["maxPrice"];
        }
        if (isset($_GET['minPrice'] ) ) {
            $sql .= " AND price > :minPrice";
            $namedParamaters[":minPrice"] = $_GET["minPrice"];
        }
        if (isset($_GET['orderBy'] ) ) {
            $sql .= " ORDER BY :orderBy";
            $namedParamaters[":orderBy"] = $_GET["orderBy"];
        }
        
        $statement = $dbConnection->prepare($sql);
        $statement->execute($namedParamaters);
        $records = $statement->fetchALL(PDO::FETCH_ASSOC);
        
        return $records;
    }
    
    
    displayQueryResults( getSearch() );
?>