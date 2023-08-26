<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

require "../component/bdd.php";



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dateDebutVacances = $_POST['date_debut_vacances'];
    $dateFinVacances = $_POST['date_fin_vacances'];
    $nombreDePersonnes = $_POST['nombre_de_personnes'];

    $today = new DateTime();
    $dateDebut = new DateTime($dateDebutVacances);


    if ($dateDebut < $today) {
        $erreur = "La date de début des vacances doit être au moins le lendemain.";
    }
    if ($nombreDePersonnes > 20) {
        $erreur = "Le nombre de personnes ne peut pas dépasser 20.";
    }

    if (empty($erreur)) {
        $_SESSION['date_debut_vacances'] = $dateDebutVacances;
        $_SESSION['date_fin_vacances'] = $dateFinVacances;
        $_SESSION['nombre_de_personnes'] = $nombreDePersonnes;

        header("Location: choixpack.php?date_debut_vacances=$dateDebutVacances&date_fin_vacances=$dateFinVacances&nombre_de_personnes=$nombreDePersonnes");
        exit();
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
    <title>Réservation - Etape 1</title>
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
                    <h1>Besoin de quelques petites infos</h1>
                    <form action="" method="POST">
                        <p style="color: red;"> <?php if (isset($erreur)) {echo $erreur;} ?> </p>
                        <label for="date_debut_vacances">Date de début de vacances :</label>
                        <input type="date" id="date_debut_vacances" name="date_debut_vacances" required>
                        <br>
                        <label for="date_fin_vacances">Date de fin de vacances :</label>
                        <input type="date" id="date_fin_vacances" name="date_fin_vacances" required>
                        <br>
                        <label for="nombre_de_personnes">Nombre de personnes :</label>
                        <input type="number" id="nombre_de_personnes" name="nombre_de_personnes" min="1" max="20" required>
                        <br>
                        <button type="submit" class="btn btn-primary btn-block mb-4">Valider la réservation</button>
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
</html>