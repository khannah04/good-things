<?php

//checking to see if we got here correct (via a post method)
if($_SERVER["REQUEST_METHOD"] === "POST"){
    $note = $_POST["note"]; 

    try{
        //linking the db, notes model, and notes controller here
        require_once 'dbh.inc.php'; 
        require_once 'notes_model.inc.php'; 
        require_once 'notes_contr.inc.php'; 

        //ERROR HANDLERS (only if input is empty)
        $error = "";
        if(is_input_empty($note))
        {
            $error = "Enter a note!"; 
        }

        require_once 'config_session.inc.php';
        if($error){
            $_SESSION["errors_notes"] = $error; 
            header("Location: ../index.php"); 
            die();  
        }

        //if i'm here, no errors were found! 
        //which means i can add the note to the db 
        $user = $_SESSION["user_username"]; 
        $id = $_SESSION["user_id"]; 
        create_note($pdo, $note, $user, $id); 
        
        header("Location: ../index.php?note=success"); 
        $pdo = null; 
        $stmt = null; 

    }
    catch(PDOException $e){
        //if errors detected, fail with a specific message 
        die("Query failed: " . $e->getMessage()); 

    }

}
//otherwise return to the page
else{
    header("Location:../index.php"); 
    die(); 
}