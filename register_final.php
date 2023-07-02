<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - S'inscrire</title>
</head>

<?php
require "./BDD/config.php";
session_start();
if (!isset($_SESSION['pseudo']) && empty($_SESSION['pseudo'])) {
    header("Location: ariane_register.php");
    exit();
}

if (isset($_POST['captcha'])){

    $email = $_SESSION['email'];
    $pseudo = $_SESSION['pseudo'];
    $date_naissance = $_SESSION['date_naissance'];
    $password = $_POST['password'];
    $pwval = $_POST['confirmation_pw'];



    if (!preg_match("/^.{8,}$/", $password)) $erreurpw = "Le mot de passe doit faire au minimum 8 caractères.";
    if (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W)(?=.*[0-9]).{8,}$/", $password)) $erreurpw = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un caractère spécial et un chiffre, avec au moins 8 caractères. (ça fait beaucoup)";
    if ($pwval != $password) $erreurpw = "Les deux mots de passes ne sont pas les mêmes.";

    $pwhash = password_hash($password, PASSWORD_BCRYPT);

    if(empty($erreurpw)){
        $_SESSION['password'] = $pwhash;
        header("location: ./component/captcha.php");
        exit();
    }
}
?>

<body>

<header>
    <?php include "./component/header.php"; ?>
    <?php include "./logs.php"; ?>
</header>

<main style="margin-top: 7rem;">
    <div class="container">
        <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto">
            <div class="tab-content">
                <form method="POST">
                    <div class="tab-pane fade show active">
                        <div class="text-center mb-3">
                            <div>
                                <p>Choisissez votre mot de passe :</p>
                                <div class="form-outline mb-4">
                                    <input type="password" name="password" class="form-control" placeholder="Votre mot de passe" required />
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="password" name="confirmation_pw" class="form-control" placeholder="Confirmez votre mot de passe" required />
                                </div>
                                <div class="form-outline mb-4">
                                    <button type="submit" class="btn btn-primary btn-block" name="captcha">Valider votre mot de passe</button>
                                    <p style="color: red;"><?php if (isset($erreurpw)) echo $erreurpw ?></p>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>


<footer>
    <?php include "./component/footer.php"; ?>
</footer>




</body>
</html>