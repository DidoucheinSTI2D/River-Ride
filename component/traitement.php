<?php
session_start();
require "../BDD/config.php";

// Inscrit l'user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_SESSION['email'];
    $pseudo = $_SESSION['pseudo'];
    $date_naissance = $_SESSION['date_naissance'];
    $password = $_SESSION['password'];


    $newuser = $bdd->prepare("INSERT INTO Utilisateur(`e-mail`, `Pseudo`, `date_de_naissance`, `Mot_de_passe`, `Droits`) VALUES (?, ?, ?, ?, ?)");
    $newuser->execute(array($email, $pseudo, $date_naissance, $password, 'user'));

    // Destruction de la session
    $_SESSION['registrationSuccess'] = true;
    header("Location: ./remerciements.php");
    exit();
}


if (empty($_SESSION['email']) || empty($_SESSION['pseudo']) || empty($_SESSION['date_naissance']) || empty($_SESSION['password'])) {
    header("Location: ../ariane_register.php");
    exit();
}
?>