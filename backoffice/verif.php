<?php

    // Démarrage de la session
    session_start();
    $servername = "localhost"; // Nom du serveur où se trouve la base de données
    $username = "root"; // Nom d'utilisateur pour accéder à la base de données
    $password = ""; // Mot de passe pour accéder à la base de données
    $dbname = "mastertheweb"; // Nom de la base de données

    // Crée une connexion
    $conn = new mysqli($servername, $username, $password, $dbname);

    $email = $_POST['e-mail'];
    $passworduser = $_POST['Mot_de_passe'];
    $sql = "SELECT `Droits` FROM `utilisateur` WHERE `e-mail` = '$email' AND `Mot_de_passe` = '$passworduser'    ";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $droits = $row['Droits'];

    // Vérifier si l'utilisateur a le droit admin
    if ($droits == 'admin') {
      header("Location: ./backoffice.php");
      exit();
    } else {
      header("Location: ./reject.php");
      exit();
    }
?>