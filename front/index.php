<?php 
    require_once 'includes/config_session.inc.php';
    require_once 'includes/signup_view.inc.php';
    require_once 'includes/login_view.inc.php';
    require_once 'includes/notes_view.inc.php'; 
?>

<!DOCTYPE HTML>
<html lang = "en">
    <head> 
        <meta charset = "UTF-8">
        <meta http-equiv = "X-UA-Compatible" content = "IE=edge">
        <meta name = "viewport" content = "width=device-width, initial-scale=1.5">
        <link rel="stylesheet" href = "style.css">

    </head>

    <h3>
        <?php
            output_username(); 
        ?>
    </h3>

    <body>

    <?php
        if(!isset($_SESSION["user_id"]))
        {?>

        <h3>Login</h3>
        <form action = "includes/login.inc.php"  method = "post">
            <input type = "text" name = "username" placeholder = "Username">
            <input type = "password" name = "pwd" placeholder = "Password">
            <button>Login</button>

        </form>

        <?php
            check_login_errors(); 
        ?>

        <form action = "includes/signup.inc.php"  method = "post">
            <?php 
                signup_inputs(); 
            ?>
            <button>Sign Up</button>

        </form>

        <?php
            check_signup_errors(); 
        }

        else{ ?>
            <h3>Logout</h3>
            <form action = "includes/logout.inc.php"  method = "post">
            <button>Logout</button>
            </form>
            
            <p> What do you want to log?</p>

            <!--Line break and text input-->
            <br><br>

            <form action = "includes/notes.inc.php" method = "post">
                <input type = "text" name = "note">
                <button>Until next year!</button>
                <!--input type = "submit" value = "Until next year!"-->
                
            </form>

        <?php
            check_notes_errors(); 
        }
        ?>


       

</body>

        


   
</html>