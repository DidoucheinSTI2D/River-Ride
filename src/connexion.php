<?php
session_start();

require "component/bdd.php";

if (isset($_POST['connexion'])){
    $mail = htmlspecialchars($_POST['mail']);
    $mdp = $_POST['mdp'];

    $connect = $bdd -> prepare("SELECT * FROM utilisateurs WHERE email = :mail");
    $connect -> bindValue('mail', $mail, PDO::PARAM_STR);
    $userexist = $connect->execute();
    $userexist = $connect->fetch();


    if (empty($mail) || empty($mdp)) $erreur = 'Vous devez remplir tout les champs';
    if (empty($userexist)) $erreur = ' vous n\'êtes pas inscrit';

    if(isset($userexist['mot_de_passe'])){
        $mdpcrypt = $userexist['mot_de_passe'];
        if (!password_verify($mdp, $mdpcrypt)) $erreur = 'Mot de passe incorrect';
    }

    if (empty($erreur)){
        $_SESSION['id'] = $userexist['id_utilisateur'];
        $_SESSION['prenom'] = $userexist['prenom'];
        $_SESSION['nom'] = $userexist['nom'];
        $_SESSION['email'] = $userexist['email'];
        $_SESSION['admin'] = $userexist['admin'];
        header("Location: main.php");
    }
}




?>


<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>RiverRide - Connexion</h1>

    <div>
        <form method="POST">
            <p style="color: green;"><?php if (isset($_GET['inscription']) && $_GET['inscription'] === "success") echo 'Inscription réussie !'; ?></p>
            <div>
                <input type="email" name="mail" placeholder="Votre email..." required="required" autocomplete="on">
            </div>
            <div>
                <input type="password" name="mdp" placeholder="Votre mot de passe..." required="required" autocomplete="on">
            </div>
            <p style="color: red;"><?php if (isset($erreur)) echo $erreur ?></p>

            <button type="submit" name="connexion"> Se connecter !</button>
            <p> Pas encore inscrit ?</p>
            <a type="button" href="inscription.php"> S'inscrire </a>
        </form>
    
</body>
</html>