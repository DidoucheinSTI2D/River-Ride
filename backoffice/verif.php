<<<<<<< HEAD
<?php
session_start();

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mastertheweb";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $email = $_POST['e-mail'];
    $password = $_POST['Mot_de_passe'];

    $stmt = $conn->prepare("SELECT * FROM utilisateur WHERE `e-mail` = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $hashedPassword = $user['Mot_de_passe'];

        if (password_verify($password, $hashedPassword)) {
            $_SESSION['email'] = $user['e-mail'];
            $_SESSION['droits'] = $user['Droits'];

            if ($user['Droits'] === 'admin') {
                header("Location: ./backoffice.php");
                exit();
            } else {
                header("Location: ../index.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Mot de passe incorrect";
            header("Location: ../connect.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "Identifiants incorrects";
        header("Location: ../connect.php");
        exit();
    }
} catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
}
?>
=======
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
    $sql = "SELECT `Droits` FROM `utilisateur` WHERE `e-mail` = '$email' AND `Mot_de_passe` = '$passworduser'	";
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
>>>>>>> 76fa50cde1b0a7ad397ad50e5ef4d7041ab659e9
