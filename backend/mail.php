<?php
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;



$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host       = 'smtp.gmail.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'shresthashreyan5@gmail.com'; 
    $mail->Password   = 'dauicfvgjphjiddf';         
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    
    $mail->setFrom('shresthashreyan5@gmail.com', 'Event Organizer');

    
    include_once('./connectToDb.php');
    $conn = connect();
    $result = $conn->query("SELECT email FROM users");

   

    $subject = "Upcoming Event: Tech Conference 2025";
    $body = "<h3>Hello!</h3><p>We’re excited to invite you to our upcoming event: <strong>Tech Conference 2025</strong>.<br>Date: July 5, 2025<br>Location: Kathmandu</p><p><a href='https://yourwebsite.com/events/123'>Click here to register</a></p><p>Best regards,<br>Event Team</p>";

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
