<?php

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

    //Server settings
    //    $mail->SMTPDebug = SMTP::DEBUG_SERVER;            //Enable verbose debug output
    $mail->isSMTP();                                        //Send using SMTP
    $mail->Host       = parameters('SMTPHost');             //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                               //Enable SMTP authentication
    $mail->Username   = $Username;                          //SMTP username
    $mail->Password   = $Password;                          //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;        //Enable implicit TLS encryption
    //$mail->SMTPSecure = "ssl";
    $mail->Port       = parameters('SMTPPort'); //465;       //TCP port to connect to; use 587 if you have set 'SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    $mail->setFrom($from);      //set from address

    if(isset($replyTo)){
        $mail->addReplyTo($replyTo);   //set reply to address,
    }else{
        $mail->addReplyTo($from);   //set reply to address, same as from when replyTo is not set.
    }
?>
