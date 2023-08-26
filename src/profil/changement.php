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



$Nom = $infoUtilisateur['nom'];
$Prenom = $infoUtilisateur['prenom'];


if (isset($_POST['changepn'])){
    $newp = $_POST['newp'];
    $newn = $_POST['newn'];
    $newplength = strlen($newp);
    $newnlenght = strlen($newn);

    if ( $newplength > 50 || $newplength < 3 ) $erreurnom = "Le nom doit faire entre 3 et 50 caractères.";
    if ( $newnlenght > 50 || $newnlenght < 3 ) $erreurprenom = "Le prenom doit faire entre 3 et 50 caractères.";

    if (empty($erreurprenom) && empty($erreurnom)){
        $newPrenom = htmlspecialchars($newp);
        $newNom = htmlspecialchars($newn);
        $insertPrenom = $bdd->prepare('UPDATE utilisateurs SET prenom = ? WHERE id_utilisateur = ?');
        $insertNom = $bdd->prepare('UPDATE utilisateurs SET nom = ? WHERE id_utilisateur = ?');
        $insertPrenom->execute(array($newPrenom, $_SESSION['id']));
        $insertNom->execute(array($newNom, $_SESSION['id']));
        header("Location: ../profil.php?success=changepn");
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
    <h1> Changement de Nom et Prenom </h1>
    <form method="POST">
        <div>
            <input name="newp" required="required" autocomplete="on" placeholder="Nom ...">
        </div>
        <div>
            <input name="newn" required="required" autocomplete="on" placeholder="Prenom ...">
        </div>

        <div>
            <button type="submit" name="changepn">Effectuer les changements</button>
            <br>
            <h2 style="color: red;"><?php if (isset($erreurnom)) echo $erreurnom ?></h2>
            <h2 style="color: red;"><?php if (isset($erreurprenom)) echo $erreurprenom ?></h2>
        </div>
    </form>
    </main>

    <footer class="fixed-bottom bg-light py-2">
        <div class="container text-center">
            <p class="m-0">&copy; 2023 - River Ride</p>
        </div>
    </footer>

</body>