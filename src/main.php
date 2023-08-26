<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}

$nom = $_SESSION['nom'];
$prenom = $_SESSION['prenom'];
?>

<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>RiverRide - Acceuil</title>
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
    <div class="container">
        <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto">
            <div class="col-12" style="text-align: center;">
                        <?php echo "<h1> Bienvenue $prenom $nom !</h1>"; ?>
                <?php if (isset($_GET['error']) && $_GET['error'] == "notadmin") {
                    echo "<p style='color : red;'>Vous n'avez pas les droits pour accéder à cette page</p>";
                } ?>

                <h1 class="text-center">Bienvenue sur River Ride</h1>
                envie d'une reservation? <br>
                <a href="reservation.php"><button class="btn btn-primary btn-block mb-4"> Je reserve ! </button></a>
            </div>
    </main>




    <footer class="fixed-bottom bg-light py-2">
        <div class="container text-center">
            <p class="m-0">&copy; 2023 - River Ride</p>
        </div>
    </footer>
    
</body>
</html>