<?php
//This script sends an email to a customer with bike(s) number and rack, pulled from database, one hour before rental begins
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';
header('Content-type: text/plain');//DEBUG

function sendEmail($email) {
	
	$mail = new PHPMailer(true); //defaults to using php "mail()"; the true param means it will throw exceptions on errors, which we need to catch

try {
    // configure an SMTP
    $mail->isSMTP();
	$mail->Host = 'vmpl01.ha-node.net';
    $mail->SMTPAuth = true;
    $mail->Username = 'ride@byronbaybikes.com';
    $mail->Password = 'Byronwood123';
	//$mail->Password = 'XCXiRFj,gpcV';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 25;

    $mail->setFrom('ride@byronbaybikes.com', 'Byron Bay Bikes');
    $mail->addAddress($email, 'Name');
    $mail->Subject = 'Test email';
    // Set HTML 
    $mail->isHTML(true);
    
    $mail->Body = "<html>Hi, this is a test email </html>";
	$mail->Send();
  echo "Message Sent OK\n";
} catch (phpmailerException $e) {
  echo $e->errorMessage(); //Pretty error messages from PHPMailer
} catch (Exception $e) {
  echo $e->getMessage(); //Boring error messages from anything else!
}
	
    

// send the message
    /*
    if(!$mail->send()){
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'Message has been sent';
    }
	*/
    
    
}

sendEmail('t.zamachowiec@gmail.com');


