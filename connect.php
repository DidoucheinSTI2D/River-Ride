<?php
session_start();
require "./BDD/config.php";

if (isset($_SESSION['id_Utilisateur'])){
    header('location: profil.php');
    exit;
}

if (isset($_POST['connect'])) {
    $Email = $_POST['email'];
    $Password = $_POST['password'];

    $connect = $bdd->prepare('SELECT * FROM Utilisateur WHERE `e-mail` = ?');
    $connect->bindValue(1, $Email);
    $result = $connect->execute();
    $resultUser = $connect->fetch();

    if (empty($Email) || empty($Password)) {
        $erreur = "Merci de remplir tous les champs";
    } elseif (empty($resultUser)) {
        $erreur = "Vous n'êtes pas inscrit !";
    } elseif (isset($resultUser['Mot_de_passe'])) {
        $pwcrypt = $resultUser['Mot_de_passe'];
        if (!password_verify($Password, $pwcrypt)) {
            $erreur = "Mot de passe invalide.";
        }
    }

    if (empty($erreur)) {
        $_SESSION['id_Utilisateur'] = $resultUser['id_Utilisateur'];
        $_SESSION['Pseudo'] = $resultUser['Pseudo'];
        $_SESSION['Email'] = $resultUser['e-mail'];
        $_SESSION['droits'] = $resultUser['Droits'];

        $updateLastLogin = $bdd->prepare('UPDATE Utilisateur SET last_login = NOW() WHERE id_Utilisateur = ?');
        $updateLastLogin->execute(array($_SESSION['id_Utilisateur']));

        if ($_SESSION['droits'] == 'user') {
            header("Location: leSuPerisien.php?id=" . $_SESSION['id_Utilisateur']);
            exit; // Terminer l'exécution du script après la redirection
        } elseif ($_SESSION['droits'] == 'admin') {
            header("Location: ./backoffice/backoffice.php?id=" . $_SESSION['id_Utilisateur']);
            exit; // Terminer l'exécution du script après la redirection
        }
    }
}
?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - Connexion</title>
</head>

<body>
<header>
    <?php include "./component/header.php"; ?>
    <?php include "./logs.php"; ?>
</header>

<main style="margin-top: 7rem;">
    <div class="container">
        <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto">
            <div class="tab-content">
                <div class="tab-pane fade show active">
                    <form method="POST">
                        <div class="text-center mb-3">
                            <h2 style="color : red;">
                                <?php
                                if (isset($_GET['error']) && $_GET['error'] == "notconnected") {
                                    echo "Veuillez vous connecter pour accéder à cette page.";
                                }
                                ?>
                            </h2>
                            <h2 style="color: green;">
                                <?php
                                if (isset($_GET['success']) && $_GET['success'] == "register"){
                                echo "Vous êtes inscrit sur le SuperCoin !";
                                }
                                ?>
                            </h2>
                            <p>Se connecter :</p>
                            <!-- Email pour se connecter -->
                            <div class="form-outline mb-4">
                                <input type="email" name="email" class="form-control" placeholder="Votre email" required />
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" name="password" class="form-control" placeholder="Mot de passe" required />
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6 d-flex justify-content-center">
                                    <div class="form-check mb-3 mb-md-0">
                                        <a href="./forgotpw.php">Mot de passe oublié</a>
                                    </div>
                                </div>
                                <div class="col-md-6 d-flex justify-content-center">
                                    <a href="./ariane_register.php">S'inscrire !</a>
                                </div>
                            </div>
                            <!-- Submit button -->
                            <button type="submit" class="btn btn-primary btn-block mb-4" name="connect">Se connecter</button>
                            <p style="color: red;"> <?php if (isset($erreur)) echo "$erreur" ?></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php include "./component/footer.php"; ?>
</footer>

</body>

</html>
