<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

ob_start(); // Permet de mettre en tampon le contenu HTML qui suit

$nom = $_POST['nom'];
$email = $_POST['email'];
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
$mail->addAddress($email, $nom);
$mail->Subject = 'La Super Newsletter';
//$mail->msgHTML(file_get_contents('message.html'), __DIR__);
$mail->Body = "Merci $nom pour votre inscription à la Super newsletter !";
//$mail->addAttachment('attachment.txt');
if (!$mail->send()) {
    echo 'Erreur: ' . $mail->ErrorInfo;
} else {
    echo 'Message envoyé !';
    ob_end_clean(); // Permet de vider le tampon
    header("Location: ../index.php");
    exit();
}
?>