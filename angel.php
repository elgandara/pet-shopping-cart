<?php
    include("includes/database.php");
    
    $dbConnection = getDatabaseConnection('pet_shop');
    
    function getSearch()
    {
        global $dbConnection;
        $sql = "SELECT name, size, color, sex, price
                FROM pet WHERE 1 ";
        
        if(!empty($_GET['speciesID']))
        {
            $sql .= " AND speciesID = " . $_GET['speciesId'];
        }
        if(!empty($_GET['color']))
        {
            $sql .= " AND color = " . $_GET['color'];
        }
        if(!(empty($_GET['size'])))
        {
            $sql .= " AND size = " . $_GET['size'];
        }
        if(!empty($_GET['sex']))
        {
            $sql .= " AND sex = " . $_GET['sex'];
        }
        
        if(!isset($_GET['maxPrice']) )
        {
            $sql .= " AND price < " . $_GET['maxPrice'];
        }
        
        if(!isset($_GET['minPrice']) )
        {
            $sql .= " AND price > " . $_GET['minPrice'];
        }
        
        if(!isset($_GET['orderBy']) )
        {
            $sql .= " ORDER BY " . $_GET['orderBy'] . " ASC";
        }
        
        $statement = $dbConnection->prepare($sql);
        $statement->execute($nameParamaters);
        $records = $statement->fetchALL(PDO::FETCH_ASSOC);
        
        return $records;
    }
    
    getSearch();
?>