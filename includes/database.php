<?php
    
    function getDataBaseConnection($dbname) {
        // Database information and credentials
        $host = "localhost";
        //$dbname = "otter_express";
        $username = "web_user";
        $password = "s3cr3t";
        
        // Establishing a connection
        $dbConn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        
        // Setting Errorhandling to Exception
        $dbConn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);     
        
        return $dbConn;
    }

    function getMultipleQueryResults($sql, $connection) {
        
        if (is_string($sql) ) {
                        
            // Prepare the query to get the results
            $statement = $connection -> prepare($sql);
            
            // Execute the query
            $statement -> execute();
            
            // Get the results
            $results = $statement -> fetchAll(PDO::FETCH_ASSOC);
            
             return $results;
        }
        
        else {
            return null;
        }
    }
    
    function getSingleQueryResult($sql, $connection) {
        
        if (is_string($sql) ) {
                        
            // Prepare the query to get the results
            $statement = $connection -> prepare($sql);
            
            // Execute the query
            $statement -> execute();
            
            // Get the results
            $results = $statement -> fetch(PDO::FETCH_ASSOC);
            
            return $results;
        }
        else {
            return null;
        }
    }
    
    function displayQueryResults($results) {
        
        if (isset($results) ) {
            
            reset($results);
            $first_key = key($results);
            
            if (is_array($results[$first_key]) ) {
                
                echo "<table>";
                foreach ($results as $result) {
                    echo "<tr>";
                    foreach ($result as $value) {
                        echo "<td> $value </td>";
                    }
                    echo "</tr>";
                }
                echo "</table>";
            }
            
            else {
                echo "<table>";
                echo "<tr>";
                foreach ($result as $value) {
                    echo "<td> $value </td>";
                }
                echo "</tr>";
                echo "<table>";
            }
        }
        
        else {
            echo "NULL<br>";
        }
        
        
    }

?>
