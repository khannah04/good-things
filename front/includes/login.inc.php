<?php

if($_SERVER["REQUEST_METHOD"] === "POST"){

    //grab the username and password
    $username = $_POST["username"]; 
    $pwd = $_POST["pwd"]; 

    try{
        require_once 'dbh.inc.php'; //connects to the database
        require_once 'login_model.inc.php'; //always model first 
        require_once 'login_contr.inc.php'; //then controler
       
        
        // ERROR HANDLERS

        $errors = []; 

        //checking to see if any input is empty
        if(is_input_empty($username, $pwd)){
            $errors["empty_input"] = "Fill in all fields!"; 

        }

        $result = get_user($pdo, $username); //will get the user

        //need to check if username exists 
        if(is_username_wrong($result)){
            $errors["login_incorrect"] = "Incorrect login info!";  
        }
        //need to check if username and passwords match 
        if(!is_username_wrong($result) && is_password_wrong($pwd, $result["pwd"])){
            $errors["login_incorrect"] = "Incorrect login info!";  
        }

        require_once 'config_session.inc.php'; //UPDATES SESSION ID FOR COOKIES AND BROWSER 
        //BASICALLY A SESSION SECURITY THING

        if($errors){
            $_SESSION["errors_login"] = $errors; 

            header("Location: ../index.php"); 
            die();  
        }

        //creating a session id with the user's id 
        $newSessionId = session_create_id(); 
        $sessionId = $newSessionId . "_" . $result["id"]; 
        session_id($sessionId); 

        //username and passwords match here! 
        $_SESSION["user_id"] = $result["id"]; 
        $_SESSION["user_username"] = htmlspecialchars($result["username"]); 

        $_SESSION["last_regeneration"] = time(); //reset the time
        header("Location: ../index.php?login=success"); 

        $pdo = null; 
        $stmt = null; 

        die(); 
    }
    catch(PDOException $e){
        die("Query failed: " .$e->getMessage()); 
    }
}
else {
    header("Location: ../index.php"); 
    die(); 
}