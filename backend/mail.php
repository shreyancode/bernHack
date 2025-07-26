<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 
    $mail->Password   =         
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    
    $mail->setFrom('shresthashreyan5@gmail.com', 'Event Organizer');

    
    include_once('./connectToDb.php');
    $conn = connect();
    $result = $conn->query("SELECT email FROM users");

   


    while ($row = $result->fetch_assoc()) {
        $mail->clearAllRecipients(); 
        $mail->addAddress($row['email']);
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();
    }

    echo "Emails sent successfully!";
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
