<?php

#declaring variables for the database
$host = 'localhost';
$dbname = 'notesdatabase';
$dbusername = 'root'; 
$dbpassword = '';

try{
    #connecting to the database
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
    
} catch (PDOException $e){
    #if connectoin failed, print error message
    die("Connection failed: " . $e->getMessage());
}