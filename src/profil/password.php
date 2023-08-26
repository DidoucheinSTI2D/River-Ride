<?php
session_start();
require '../component/bdd.php';


if (!isset($_SESSION['id'])) {
    header('Location: ../connexion.php?error=notconnected');
    exit;
}

$getId = $_SESSION['id'];

$connect = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur = :id');
$connect->bindValue('id', $getId, PDO::PARAM_INT);
$resultat = $connect->execute();
$infoUtilisateur = $connect->fetch();

$Prenom = $infoUtilisateur['prenom'];
$id = $infoUtilisateur['id_utilisateur'];
$Password = $infoUtilisateur['mot_de_passe'];

if (isset($_POST['pwchange'])){
    $PasswordChange = $_POST['Password'];
    $NewPassword = $_POST['NewPassword'];
    $Password_Validation = $_POST['Password_Validation'];
    $pwhash = password_hash($NewPassword, PASSWORD_DEFAULT);

    if (empty($PasswordChange) || empty($NewPassword) || empty($Password_Validation)) $erreur = "Merci de remplir tout les champs"; // Chrome va obliger l'utilisateur à remplir les éléments via le "required", mais certain navigateur non, c'est pour cela que j'ai ajouté cette condition :)
    if (!preg_match('/^(?=.*[A-Z])(?=.*[\W_])(?=.{8,})/', $NewPassword) ) $erreur = "Votre mot de passe doit contenir au moins 8 caractères, 1 majuscule et 1 caractère spéciale.";
    if (!password_verify($PasswordChange, $Password)) $erreur = "ancien mot de passe invalide";
    if ($NewPassword != $Password_Validation) $erreur = "La confirmation ne correspond à votre mot de passe";

    if(empty($erreur)){
        $insertbdd = $bdd->prepare("UPDATE utilisateurs SET mot_de_passe = ? WHERE id_utilisateur = ?");
        $insertbdd->execute(array($pwhash, $_SESSION['id']));
        header("Location: ../profil.php?success=changepw");
    }


}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>RiverRide - Modification MDP</title>
</head>



<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">River Ride</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="reservation.php">Réserver</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php">Se déconnecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="paiement.php">Panier</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <form method="POST">
            <div>
                <h1> Modification du mot de passe de <?php echo $Prenom ?></h1>
            </div>

            <div>
                <input type="password" name="Password" required="required" autocomplete="off" placeholder="Ancien mot de passe ...">
            </div>
            <div>
                <input type="password" name="NewPassword" required="required" autocomplete="off" placeholder="Nouveau mot de passe ...">
            </div>
            <div>
                <input type="password" name="Password_Validation" required="required" autocomplete="off" placeholder="Valider le nouveau mot de passe ...">
            </div>

            <div>
                <button type="submit" name="pwchange">Valider le nouveau mot de passe</button>
                <p style="color: red;"><?php if (isset($erreur)) echo $erreur ?></p>
            </div>

        </form>
    </main>

    <footer class="fixed-bottom bg-light py-2">
        <div class="container text-center">
            <p class="m-0">&copy; 2023 - River Ride</p>
        </div>
    </footer>


</body>