<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$usermail = $_POST['email'];
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Remplacez 2 par SMTP::DEBUG_SERVER pour un débogage plus détaillé
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com'; // Remplacez par votre adresse e-mail Gmail
    $mail->Password = 'your_password'; // Remplacez par votre mot de passe Gmail
    $mail->setFrom('support@lesupercoin.com', 'Le SuperCoin');
    $mail->addAddress($usermail, 'Le SuperCoin');
    $mail->Subject = 'Merci pour votre inscription à la Super newsletter !';
    $mail->Body = 'lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet lorem ipsum dolor sit amet';
    $mail->AltBody = 'Test';
    $mail->send();
    echo 'Le message a bien été envoyé !';
} catch (Exception $e) {
    echo 'Erreur, message non envoyé : ', $mail->ErrorInfo;
}
?>