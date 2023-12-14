<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailController extends Controller
{

    public static function sendEmail() {
        $email = 't.zamachowiec@gmail.com';
        $name = 'Tadzio';
        $subject = 'test mail';
        $body = "test mail";
    
        // create a new object
        $mail = new PHPMailer();
        // configure an SMTP
        $mail->isSMTP();
        $mail->Host = env('MAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('MAIL_USERNAME');
        $mail->Password = env('MAIL_PASSWORD');
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = env('MAIL_PORT');
    
        $mail->setFrom('ride@byronbaybikes.com', 'Byron Bay Bikes');
        $mail->addAddress($email, $name);
        $mail->Subject = $subject;
        // Set HTML 
        $mail->isHTML(TRUE);
        
        $mail->Body = "<html>". $body . "</html>";
    
    
    // send the message
        
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        } else {
            echo 'Message has been sent';
        }
        
        
    }
}
