<?php


//creating a session to destroy when the user wants to log out
session_start(); 
session_unset(); 
session_destroy(); 

header("Location: ../index.php"); 
die(); 