<?php

//allow code to have type declarations
declare(strict_types=1);


function get_username(object $pdo, string $username){
    $query = "SELECT username FROM users WHERE username = :username;";
    $stmt = $pdo->prepare($query); 
    
    //bind the data to query and send it over
    $stmt->bindParam(":username", $username); 
    $stmt->execute(); 

    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    return $result; 
}

function get_email(object $pdo, string $email){
    $query = "SELECT username FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query); //bind the data to query and send it over
    $stmt->bindParam(":email", $email); 
    $stmt->execute(); 

    $result = $stmt->fetch(PDO::FETCH_ASSOC); 
    return $result; 
}

function set_user(object $pdo, string $username, string $pwd, string $email){
    $query = "INSERT INTO users (username, pwd, email) VALUES (:username, :pwd, :email);";
    $stmt = $pdo->prepare($query); 
    
    $options = [
        'cost' => 12
    ]; 

    $hashedPwd = password_hash($pwd, PASSWORD_BCRYPT, $options);
    
    //bind the data to query and send it over
    $stmt->bindParam(":username", $username); 
    $stmt->bindParam(":pwd", $hashedPwd); 
    $stmt->bindParam(":email", $email); 
    $stmt->execute(); 

   
}