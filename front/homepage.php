<!DOCTYPE HTML>
<html>
    <head>
        
    </head>

    <body>
        <!--Asking the user for their message to their future self-->
        <p> What do you want to log?</p>

        <!--Line break and text input-->
        <br><br>

        <form action = "print.php" method = "post">
            <input type = "text" name = "note">
            <input type = "submit" value = "Until next year!">
        </form>

        <?php

            
            /*$notes = array(); 
            include 'print.php'; 
            storeInArray($notes, htmlspecialchars($note)); 
            print_r($notes); */ 
        ?>

    </body>
</html>