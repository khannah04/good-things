<?php
//for SQL QUERY STUFF 
declare (strict_types=1); 

function set_note(object $pdo, string $note, string $username, int $id){
    $query = "INSERT INTO notes (note_text, username, users_id) VALUES (:note, :username, :id)"; 
    $stmt = $pdo->prepare($query); 

    //$stmt->bindParam(":username", $username); 
    $stmt->bindParam(":note", $note); 
    $stmt->bindParam(":username", $username); 
    $stmt->bindParam(":id", $id); 
    $stmt->execute(); 
}