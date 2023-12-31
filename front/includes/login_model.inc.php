<?php

declare(strict_types=1); 

//function to grab all results associated with user
function get_user(object $pdo, string $username){
    $query = "SELECT * FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query); 
    
    //bind the data to query and send it over
    $stmt->bindParam(":username", $username); 
    $stmt->execute(); 

    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    return $result; 
}