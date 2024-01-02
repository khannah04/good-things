<?php

//implement strict types 
declare(strict_types=1); 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

//include required phpmailer files
require 'PHPMailer/phpmailer/src/Exception.php';
require 'PHPMailer/phpmailer/src/PHPMailer.php';
require 'PHPMailer/phpmailer/src/SMTP.php';
require 'front/includes/dbh.inc.php'; //database connection
//require_once 

//define the namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'newyearnotes24@gmail.com';                     //SMTP username
    $mail->Password   = 'tuywjhkocxnsivwd';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $query = "SELECT username FROM users;"; 
    $stmt = $pdo->prepare($query); 
    //$stmt->bindParam(); 
    $stmt->execute(); 
    $usernames = $stmt->fetchAll(PDO::FETCH_ASSOC); 

    foreach($usernames as $row){
        $username = $row['username']; 
        //need to check to see if there are even any notes to send
        send_email($pdo, $mail, $username); 
        echo "email sent successfully to " . $username; 
    }

    //$username = 'hello'; 
    
    
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


function get_info(object $pdo, object $mail, string $username){
    $query = "SELECT note_text, created_at FROM notes WHERE username = :username;"; 
    $result = $pdo->prepare($query); 
    $result->bindParam(':username', $username); 
    $result->execute(); 

    return $result; //result is pdo object 
    //we will pass this to the format function to format into a pretty printing string
}

function format(object $pdo, object $mail, string $username){
    $result = get_info($pdo, $mail, $username); 

    $year = date("Y"); 
    $emailContent = "<p> Hello, and Happy New Year!</p>";
    $emailContent .= "<br><p> Below, you'll see all the happiest memories you made this year. Cheers to more in " . ($year+1) . "!</p><br>";
    
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Compose email content with data from the database
       // $emailContent = "heyhey"; 
        $emailContent .= "<p> Date: " . $row['created_at'] . " Note: " . $row['note_text'] . "</p>";
    }
    if($emailContent === "<p> Hello, and Happy New Year!</p>" .  "<br><p> Below, you'll see all the happiest memories you made this year. Cheers to more in " . ($year+1) . "!</p><br>")
        return null; 
    
    return $emailContent; //returns a string with all info 

}

//this will go in a for each loop. for each user in the users db, send them a custom email with their notes! 
function send_email(object $pdo, object $mail, string $username){
    //Recipients
    $mail->setFrom('newyearnotes24@gmail.com', 'New Year Notes');

    //==============================================IMPORTANT TO DO===============================================\\
    //AFTER DONE TESTING FUNCTIONALITY (pull email from users table and shove that into the addAddress function)

    $query = "SELECT email FROM users WHERE username = :username;"; 
    $stmt = $pdo->prepare($query); 
    $stmt->bindParam(':username', $username);
    $stmt->execute(); //stmt should hold the email now

    $email = $stmt->fetch(PDO::FETCH_ASSOC)['email']; //email now holds email,, plug into addAddress WHEN NEEDED 
    
    $mail->addAddress('newyearnotes24@gmail.com');     //Add a recipient
    $mail->addAddress($email);     
    //$mail->addAddress('ellen@example.com', "NAME");               //Name is optional
   /* $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    */

    /*$emailContent = "<p> Hello,</p>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Compose email content with data from the database
       // $emailContent = "heyhey"; 
        $emailContent .= "<p> Note: " . $row['note_text'] . " Time: " . $row['created_at'] . "</p>";
    }*/


    $emailContent = format($pdo, $mail, $username);

    if(!empty($emailContent) && $emailContent){
        
    //Content
    $mail->isHTML(true); //Set email format to HTML
    //getting the current year 
    $year = date("Y"); 
    $mail->Subject = 'Your ' . $year . ' Notes';
    $mail->Body    =  $email . $emailContent . 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients' . strip_tags($emailContent);

    $mail->send();
    echo 'Message has been sent';
    }
}