<?php
session_start();

$id = $_SESSION['id_Utilisateur'];
$pseudo = $_SESSION['Pseudo'];
$email = $_SESSION['Email'];
$droits = $_SESSION['droits'];

$content = "Info\n\n";
$content .= "ID: $id\n";
$content .= "Pseudo: $pseudo\n";
$content .= "Email: $email\n";
$content .= "Droits: $droits\n";

header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="Info.pdf"');

echo $content;

ob_end_flush(); // Sert à envoyer un tampon de sortie

header('Location: ../profil.php');
exit();