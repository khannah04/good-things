<?php

declare(strict_types=1); 

/*function notes_inputs(){
    if(isset($_SESSION["errors_notes"]))
        echo '<input type = "text" name = "note" placeholder = "Note"> value ="' . $_SESSION["error_notes"] . '">'; 
}*/

function check_notes_errors(){
    if(isset($_SESSION["errors_notes"])){
        $error = $_SESSION['errors_notes'];

        echo "<br>";
        echo '<p class = "form-error">' .$error . '</p>'; 
        unset($_SESSION['errors_notes']); 
    }

   // else if()
}
