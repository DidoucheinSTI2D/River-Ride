<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mail = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $date_naissance = $_POST['date'];
    $mot_de_passe = $_POST['password'];
    $confirmation_pw = $_POST['confirmation_pw'];

    if (empty($mail) and empty($mot_de_passe)) {
        $_SESSION['error_message'] = "Vous ne pouvez pas vous inscrire sans information 😡";
    } elseif (empty($mail) or empty($mot_de_passe)) {
        $_SESSION['error_message'] = "Il manque un ou plusieurs élément(s) nécessaires à l'inscription.";
    }

    if (!preg_match("/^.{8,}$/", $mot_de_passe)) {
        $_SESSION['error_message'] = "Le mot de passe doit faire au minimum 8 caractères. <br>";
    } elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W)(?=.*[0-9]).{8,}$/", $mot_de_passe)) {
        $_SESSION['error_message'] = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un caractère spécial et un chiffre, avec au moins 8 caractères. (ça fait beaucoup) <br>";
    } elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_message'] = "L'e-mail est invalide. <br>";
    }

    $servername = "localhost"; // Nom du serveur où se trouve la base de données
    $username = "root"; // Nom d'utilisateur pour accéder à la base de données
    $password = ""; // Mot de passe pour accéder à la base de données
    $dbname = "mastertheweb"; // Nom de la base de données

    try {
 
        $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);


        $stmt = $pdo->prepare("INSERT INTO utilisateur (`e-mail`, `Pseudo`, `date_de_naissance`, `Mot_de_passe`, `Droits`) VALUES (:mail, :pseudo, :date_naissance, :mot_de_passe, 'user')");

        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':date_naissance', $date_naissance);
        $stmt->bindParam(':mot_de_passe', $hashed_password);

        if ($stmt->execute()) {
            $id_utilisateur = $pdo->lastInsertId();
            $_SESSION['id_utilisateur'] = $id_utilisateur;
        } else {
            echo "Erreur lors de l'insertion des données dans la base de données : " . $stmt->errorInfo()[2];
        }

        $_SESSION['id_utilisateur'] = $id_utilisateur;

        header('Location: ./Captcha.php');
        exit;
    } catch (PDOException $e) {
        echo "Erreur de connexion à la base de données : " . $e->getMessage();
    }
}
?>
