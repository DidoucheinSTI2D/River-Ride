<?php
session_start();

if (isset($_SESSION['id'])) {
    header("Location: main.php");
    exit();
}

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
        $_SESSION['client'] = $userexist['client'];
        if($_SESSION['admin'] == 1) header("Location: backoffice/backoffice.php");
        else header("Location: main.php");

    }
}




?>


<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>RiverRide - Connexion</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">River Ride</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="connexion.php">Se Connecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="inscription.php">S'inscrire</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div style="text-align: center;   width: 100vw; height: 100vh;">
    <h1>RiverRide - Connexion</h1>
        <form method="POST">
            <p style="color: red;"><?php if (isset($_GET['error']) && $_GET['error'] === "notconnected") echo 'Veuillez vous connectez avant d\'effectuer cette action.'; ?></p>
            <p style="color: green;"><?php if (isset($_GET['inscription']) && $_GET['inscription'] === "success") echo 'Inscription réussie !'; ?></p>
            <div class="form-outline mb-4">
                <input type="email" name="mail" placeholder="Votre email..." required="required" autocomplete="on">
            </div>
            <div class="form-outline mb-4">
                <input type="password" name="mdp" placeholder="Votre mot de passe..." required="required" autocomplete="on">
            </div>
            <p style="color: red;"><?php if (isset($erreur)) echo $erreur ?></p>

            <button type="submit" name="connexion" class="btn btn-primary btn-block mb-4"> Se connecter !</button>
            <p> Pas encore inscrit ?</p>
            <a type="button" href="inscription.php"> S'inscrire </a>
        </form>
    </div>
    
</body>
</html>