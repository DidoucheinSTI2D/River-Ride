<?php

session_start();

require "../component/bdd.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        foreach ($_POST['logement'] as $pointArretId => $logements) {
            foreach ($logements as $logementId => $selectedLogementId) {
                $insertQuery = "INSERT INTO reservations (id_utilisateur, id_logement, validation, date_debut, date_fin) 
                                VALUES (:id_utilisateur, :id_logement, FALSE, :date_debut, :date_fin)";
                $insertStatement = $bdd->prepare($insertQuery);
                $insertStatement->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
                $insertStatement->bindParam(':id_logement', $selectedLogementId, PDO::PARAM_INT);
                $insertStatement->bindParam(':date_debut', $_SESSION['date_debut_vacances']);
                $insertStatement->bindParam(':date_fin', $_SESSION['date_fin_vacances']);
                $insertStatement->execute();
            }
        }

        header("Location: ../paiement.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur PDO :" . $e->getMessage());
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
    <title>Réservation - Etape 2</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">River Ride</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="../reservation.php">Réserver</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../profil.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../deconnexion.php">Se déconnecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../paiement.php">Panier</a>
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
                    <form action="" method="POST">
                        <?php
                        $query = "SELECT id_point_arret, nom, description FROM pointarret";
                        $result = $bdd->query($query);
                        
                        if ($result) {
                            while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                                $pointArretId = $row['id_point_arret'];
                                $pointArretNom = $row['nom'];
                                $pointArretDescription = $row['description'];
                                
                                echo "<h2>$pointArretNom</h2>";
                                echo "<p>$pointArretDescription</p>";
                                
                                $querylogements = "SELECT id_logement, nom, capacite, prix FROM logements WHERE id_point_arret = :pointArretId AND (disponibilite IS NULL OR disponibilite = 0) AND capacite >= :capacite";
                                $logementsStatement = $bdd->prepare($querylogements);
                                $logementsStatement->bindValue(':pointArretId', $pointArretId, PDO::PARAM_INT);
                                $logementsStatement->bindValue(':capacite', $_SESSION['nombre_de_personnes'], PDO::PARAM_INT);
                                $logementsStatement->execute();
                                
                                if ($logementsStatement->rowCount() > 0) {
                                    while ($rowLogement = $logementsStatement->fetch(PDO::FETCH_ASSOC)) {
                                        $logementId = $rowLogement['id_logement'];
                                        $logementNom = $rowLogement['nom'];
                                        $logementCapacite = $rowLogement['capacite'];
                                        $logementPrix = $rowLogement['prix'];
                                        
                                        echo "<input type='checkbox' name='logement[$pointArretId][$logementId]' value='$logementId'>";
                                        echo "<label for='logement_$logementId'>$logementNom - Capacité: $logementCapacite - Prix: $logementPrix €</label><br>";
                                    }
                                }
                            }
                        }
                        ?>
                        <br><button type='submit' class="btn btn-primary btn-block mb-4">Payer</button>
                    </form>
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