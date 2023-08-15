<?php
include 'component/bdd.php';

if (isset($_POST['inscription'])){

    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];	
    $mail = $_POST['mail'];
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
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) $erreurmail = "Votre adresse mail n'est pas valide.";
    
    $reqmail = $bdd->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $reqmail->execute(array($mail));
    $mailexistant = $reqmail->rowCount();
    
    if ($mailexistant == 0) {
        if (empty($erreurprenom) && empty($erreurnom) && empty($erreurmdp) && empty($erreurmdpconf) && empty($erreurmail)) {
            $insertmbr = $bdd->prepare("INSERT INTO utilisateurs(prenom, nom, email, mot_de_passe) VALUES(?, ?, ?, ?)");
            $insertmbr->execute(array($prenom, $nom, $mail, $mdphash));
            
            header("Location: connexion.php");
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