<?php
    session_start();
    require "./config.php";
    $email = $_SESSION['email'];
    $pseudo = $_SESSION['pseudo'];
    $date_naissance = $_SESSION['date_naissance'];
    $password = $_SESSION['password'];

    $newuser = $bdd->prepare("INSERT INTO Utilisateur(`e-mail`, `Pseudo`, `date_de_naissance`, `Mot_de_passe`, `Droits`) VALUES (?, ?, ?, ?, ?)");
    if ($newuser->execute(array($email, $pseudo, $date_naissance, $password, 'user'))) {
        echo "Utilisateur enregistré avec succès.";
    } else {
        echo "Erreur lors de l'enregistrement de l'utilisateur : " . print_r($newuser->errorInfo(), true);
    }

    sleep(10);

    session_destroy();
    header("location: ./connect.php");
?>