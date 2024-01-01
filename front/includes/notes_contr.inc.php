<?php

//FOR HELPER FUNCTIONS TO DEDUCE ERRORS 

declare (strict_types=1); 

function is_input_empty(string $note){
    if(empty($note))
        return true; 
    else
        return false; 
} 

function create_note(object $pdo, string $note, string $username, int $id){
    set_note($pdo, $note, $username, $id); 
}