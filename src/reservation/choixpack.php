<?php

session_start();

require "../component/bdd.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['selected_pack'])) {
            $selectedPackId = $_POST['selected_pack'];

            $insertQuery = "INSERT INTO reservation_pack (id_utilisateur, id_pack, validation, date_reservation) 
                            VALUES (:id_utilisateur, :id_pack, FALSE, NOW())";
            $insertStatement = $bdd->prepare($insertQuery);
            $insertStatement->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
            $insertStatement->bindParam(':id_pack', $selectedPackId, PDO::PARAM_INT);
            $insertStatement->execute();

            header("Location: ../paiement.php");
            exit();
        } else {
            echo "Veuillez sélectionner un pack.";
        }
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
                        $dateDebutVacances = $_GET['date_debut_vacances'];
                        $dateFinVacances = $_GET['date_fin_vacances'];

                        $query = "SELECT id_pack, nom, description, prix FROM packs WHERE date_debut <= :date_debut AND date_fin >= :date_fin";
                        $packsStatement = $bdd->prepare($query);
                        $packsStatement->bindParam(':date_debut', $dateDebutVacances, PDO::PARAM_STR);
                        $packsStatement->bindParam(':date_fin', $dateFinVacances, PDO::PARAM_STR);
                        $packsStatement->execute();

                        if ($packsStatement->rowCount() > 0) {
                            while ($row = $packsStatement->fetch(PDO::FETCH_ASSOC)) {
                                $packId = $row['id_pack'];
                                $packNom = $row['nom'];
                                $packDescription = $row['description'];
                                $packPrix = $row['prix'];
                        
                                echo "<h2>$packNom</h2>";
                                echo "<p>$packDescription</p>";
                        
                                echo "<p>Prix: $packPrix €</p>";
                                echo "<input type='radio' name='selected_pack' value='$packId'>";
                            }
                        } else {
                            echo "Aucun pack disponible sur cette période.";
                        }
                        ?>
                        <br><button type='submit'>Payer</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <footer class="fixed-bottom bg-light py-2">
    </footer>
</body>
</html>
