<?php 
session_start();
require "component/bdd.php";

if (!isset($_SESSION['id'])) {
    header('Location: ../connexion.php?error=notconnected');
    exit;
}

$getId = $_SESSION['id'];

$connect = $bdd->prepare('SELECT * FROM utilisateurs WHERE id_utilisateur = :id');
$connect->bindValue('id', $getId, PDO::PARAM_INT);
$resultat = $connect->execute();
$infoUtilisateur = $connect->fetch();

$Email = $infoUtilisateur['email'];
$Nom = $infoUtilisateur['nom'];
$Prenom = $infoUtilisateur['prenom'];
$id = $infoUtilisateur['client'];

$query = "SELECT * FROM reservations WHERE id_utilisateur = :id AND validation = 1";
$result = $bdd->prepare($query);
$result->bindParam(':id', $id, PDO::PARAM_INT);
$result->execute();
$reservations = $result->fetchAll(PDO::FETCH_ASSOC);

$pack = "SELECT * FROM reservation_pack WHERE id_utilisateur = :id AND validation = 1";
$resultat = $bdd->prepare($pack);
$resultat->bindParam(':id', $id, PDO::PARAM_INT);
$resultat->execute();
$packs = $resultat->fetchAll(PDO::FETCH_ASSOC);


?>


<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>RiverRide - mon profil</title>
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

    <main style="margin-top: 7rem;">
    <div class="container">
        <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto" style="text-align: center;">
            <div class="tab-content">
                <p style="color: green;"> <?php if (isset($_GET['success']) && $_GET['success'] == 'changepw') { echo "Votre mot de passe a bien été modifié."; } ?> </p>
                <p style="color: green;"> <?php if (isset($_GET['success']) && $_GET['success'] == 'changepn') { echo "Votre nom et prenom a bien été modifié."; } ?> </p>
                    <h1>Mon profil</h1>
                Bienvue sur votre profil <?php echo $Prenom; ?> <?php echo $Nom; ?> ! <br>
                votre adresse mail est : <?php echo $Email; ?> <br>

                <a href="./profil/password.php">Changer de mot de passe</a>
                <a href="./profil/changement.php">Changer mes informations</a>
                </div>

                <div>
                    <h1> Mes réservations </h1>
                    <?php
                    if (count($reservations) > 0) {
                        foreach ($reservations as $reservation) {
                            echo "<div>";
                            echo "<h3>Réservation #" . $reservation['id_reservation'] . "</h3>";
                    
                            $logementQuery = "SELECT nom, capacite, prix FROM logements WHERE id_logement = :logementId";
                            $logementStatement = $bdd->prepare($logementQuery);
                            $logementStatement->bindParam(':logementId', $reservation['id_logement'], PDO::PARAM_INT);
                            $logementStatement->execute();
                            $logement = $logementStatement->fetch(PDO::FETCH_ASSOC);
                    
                            echo "<p>Logement: " . $logement['nom'] . "</p>";
                            echo "<p>Prix: " . $logement['prix'] . " €</p>";
                            echo "<p>Date de début:" . $reservation['date_debut']. "</p>";
                            echo "<p>Date de fin:" . $reservation['date_fin'] . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Vous n'avez pas de réservations.</p>";
                    } 
                    
                    if (count($packs) > 0) {
                        foreach ($packs as $pack) {
                            echo "<div>";
                            echo "<h3>Pack #" . $pack['id_pack'] . "</h3>";
                    
                            $packQuery = "SELECT nom, prix FROM packs WHERE id_pack = :packId";
                            $packStatement = $bdd->prepare($packQuery);
                            $packStatement->bindParam(':packId', $pack['id_pack'], PDO::PARAM_INT);
                            $packStatement->execute();
                            $pack = $packStatement->fetch(PDO::FETCH_ASSOC);
                    
                            echo "<p>Pack: " . $pack['nom'] . "</p>";
                            echo "<p>Prix: " . $pack['prix'] . " €</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p>Vous n'avez pas de packs.</p>";
                    }	
                    ?>
                </div>
            </div>
        </div>
    </div>
    </main>

    <br><br><br><br>

    
    <footer class="fixed-bottom bg-light py-2">
        <div class="container text-center">
            <p class="m-0">&copy; 2023 - River Ride</p>
        </div>
    </footer>

</body>