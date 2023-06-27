<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../php_mail_send/PHPMailer/src/Exception.php';
require '../php_mail_send/PHPMailer/src/PHPMailer.php';
require '../php_mail_send/PHPMailer/src/SMTP.php';

ob_start(); // Permet de mettre en tampon le contenu HTML qui suit
session_start();

$pseudo = $_SESSION['pseudo'];
$email = $_SESSION['email'];
$mail = new PHPMailer;
$mail->isSMTP();
$mail->SMTPDebug = 2;
$mail->Host = 'smtp.gmail.com';
$mail->Port = 587;
$mail->SMTPAuth = true;
$mail->Username = 'help.lesupercoin@gmail.com';
$mail->Password = 'zscfddohsnbupdke';
$mail->setFrom('help.lesupercoin@gmail.com', 'LeSuperCoin');
$mail->addReplyTo('help.lesupercoin@gmail.com', 'LeSuperCoin');
$mail->addAddress($email, $pseudo);
$mail->Subject = 'Les Super Remerciements';
//$mail->msgHTML(file_get_contents('message.html'), __DIR__);
$mail->Body = "Merci $pseudo pour votre inscription à la Super plateforme !";
//$mail->addAttachment('attachment.txt');
if (!$mail->send()) {
    echo 'Erreur: ' . $mail->ErrorInfo;
} else {
    echo 'Message envoyé !';
    ob_end_clean(); // Permet de vider le tampon
    header("Location: ../connect.php?success=register");
    exit();
}
session_destroy();
session_start(); //Destruction de la session
?>