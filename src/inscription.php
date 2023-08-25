<?php
include 'component/bdd.php';
session_start();

if (isset($_SESSION['id'])) {
    header("Location: main.php");
    exit();
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['inscription'])){

    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];	
    $email = $_POST['mail'];
    $mdp = $_POST['mdp'];
    $mdpconf = $_POST['mdpconf'];

    $mdplength = strlen($mdp);
    $prenomlength = strlen($prenom);
    $nomlength = strlen($nom);

    $mdphash = password_hash($mdp, PASSWORD_DEFAULT);

    if ($prenomlength >= 55 || $prenomlength <= 2) $erreurprenom = "Votre prenom doit contenir entre 2 et 55 caractères";
    if ($nomlength >= 55 || $nomlength <= 2) $erreurnom = "Votre nom doit contenir entre 2 et 55 caractères";
    if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_])(?=.{8,})/', $mdp) ) $erreurmdp = "Votre mot de passe doit contenir au moins 8 caractères, 1 majuscule et 1 caractère spéciale.";
    if ($mdp != $mdpconf) $erreurmdpconf = "Vos mots de passe ne correspondent pas.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurmail = "Votre adresse mail n'est pas valide.";
    
    $reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $reqmail->execute(array($email));
    $mailexistant = $reqmail->rowCount();
    
    if ($mailexistant == 0) {
        if (empty($erreurprenom) && empty($erreurnom) && empty($erreurmdp) && empty($erreurmdpconf) && empty($erreurmail)) {
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; 
            $mail->SMTPAuth   = true; 
            $mail->Username   = 'riveride.pro@gmail.com'; 
            $mail->Password   = 'yurscogsfjfmjgfv'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
            $mail->Port       = 465; 

            $mail->setFrom('riveride.pro@gmail.com', 'River Ride');
            $mail->addAddress($email, $prenom);

            $mail->isHTML(false);
            $mail->Subject = 'Une petite surprise vous attend !';
            $message = "Bienvenue $prenom sur River Ride ! \nNous sommes heureux de nous compter parmis nous, et pour remercier nos premiers clients, nous vous invitons à utilise le code \"SananesLeGoat\" pour obtenir 10% sur votre première balade ! \nà bientôt sur River Ride ❤ !";
            $mail->Body = $message;
    
            $mail->send();

            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(prenom, nom, email, mot_de_passe) VALUES(?, ?, ?, ?)");
            $insertmbr->execute(array($prenom, $nom, $email, $mdphash));
            
            header("Location: connexion.php?inscription=success");
            session_destroy(); 
            exit();
        }
    } else {
        $erreurmail = "Adresse mail déjà utilisée !";
    }

}



?>

<!DOCTYPE html>

<html lang="fr-FR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>RiverRide - Inscription</title>
    </head>

    <body>
        <h1>Inscription</h1>
            <div>
                <form method="POST">
                    <div>
                        <input type="email" name="mail" placeholder="votre@email.com" required="required" autocomplete="on">
                        <p style="color : red;"><?php if (isset($erreurmail)) echo $erreurmail ?></p>
                    </div>
                    <div>
                        <input type="text" name="nom" placeholder="Votre Nom..." required="required" autocomplete="on">
                        <p style="color : red;"><?php if (isset($erreurnom)) echo $erreurnom ?></p>
                    </div>
                    <div>
                        <input type="text" name="prenom" placeholder="Votre Prenom ..." required="required" autocomplete="on">
                        <p style="color : red;"><?php if (isset($erreurprenom)) echo $erreurprenom ?></p>
                    </div>
                    <div>
                        <input type="password" name="mdp" placeholder="Mot de passe ..." required="required" autocomplete="on">
                        <p style="color: red;"><?php if (isset($erreurmdp)) echo $erreurmdp ?></p>
                    </div>
                    <div>
                        <input type="password" name="mdpconf" placeholder="Valider votre mot de passe ..." required="required" autocomplete="on">
                        <p style="color: red;"><?php if (isset($erreurmdpconf)) echo $erreurmdpconf ?></p>
                    </div>

                    <button type="submit" name="inscription"> S'inscrire ! </button>
                    <p> Déjà inscrit ?</p>
                    <a type="button" href="connexion.php"> Se connecter </a>
                </form>
            </div>
    </body>

</html>