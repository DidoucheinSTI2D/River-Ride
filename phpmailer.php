<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
$usermail = $_POST['email'];
$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->SMTPAuth = true;
    $mail->Username = 'help.lesupercoin@gmail.com';
    $mail->Password = 'T1K1t@k@';
    $mail->setFrom('help.lesupercoin@gmail.com', 'Le SuperCoin');
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