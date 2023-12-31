<?php

declare (strict_types=1); 

function is_input_empty(string $note){
    if(empty($note))
        return true; 
    else
        return false; 
} 