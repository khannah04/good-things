<?php
/* 
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require 'PHPMailer/phpmailer/src/Exception.php';
require 'PHPMailer/phpmailer/src/PHPMailer.php';
require 'PHPMailer/phpmailer/src/SMTP.php';
 
//Create an instance; passing `true` enables exceptions
if (true || isset($_POST["send"])) {
 
  $mail = new PHPMailer(true);
 
    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'newyearnotes24@gmail.com';   //SMTP write your email
    $mail->Password   = 'tuywjhkocxnsivwd';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                                    
 
    //Recipients
    $mail->setFrom( $_POST["email"], $_POST["name"]); // Sender Email and name
    $mail->addAddress('newyearnotes24@gmail.com');     //Add a recipient email  
    $mail->addReplyTo($_POST["email"], $_POST["name"]); // reply to sender email
 
    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $mail->Subject = $_POST["Sent automatically!"];   // email subject headings
    $mail->Body    = $_POST["first ever auto email i've sent..."]; //email message
      
    // Success sent message alert
    $mail->send();
    echo
    " 
    <script> 
     alert('Message was sent successfully!');
     document.location.href = 'index.php';
    </script>
    ";
}*/

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function

//include required phpmailer files
require 'PHPMailer/phpmailer/src/Exception.php';
require 'PHPMailer/phpmailer/src/PHPMailer.php';
require 'PHPMailer/phpmailer/src/SMTP.php';
require_once 'front/includes/dbh.inc.php'; //database connection
//require_once 

//define the namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//Load Composer's autoloader
//require 'vendor/autoload.php';

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

    $username = 'hello'; 
    $query = "SELECT note_text, created_at FROM notes WHERE username = :username;"; 
    $result = $pdo->prepare($query); 
    $result->bindParam(':username', $username); 
    $result->execute(); 

    //Recipients
    $mail->setFrom('newyearnotes24@gmail.com', 'Mailer');
    $mail->addAddress('newyearnotes24@gmail.com', 'Joe User');     //Add a recipient
    //$mail->addAddress('ellen@example.com');               //Name is optional
   /* $mail->addReplyTo('info@example.com', 'Information');
    $mail->addCC('cc@example.com');
    $mail->addBCC('bcc@example.com');

    //Attachments
    $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
    */

    $emailContent = "<p> Hello,</p>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        // Compose email content with data from the database
       // $emailContent = "heyhey"; 
        $emailContent .= "<p> Note: " . $row['note_text'] . " Time: " . $row['created_at'] . "</p>";
    }
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'sending auto email';
    $mail->Body    =  $emailContent . 'This is the HTML message body <b>in bold!</b>';
    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients' . strip_tags($emailContent);

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}