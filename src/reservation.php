<?php
session_start();

if (!isset($_SESSION['id'])) {
    header("Location: connexion.php");
    exit();
}


?>


<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>River Ride - Réserver</title>
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
        <h1 style="width: 100%; text-align: center;">
            Alors comme ça, tu veux réserver une place pour une balade en bateau ?
        </h1>

        <div style="width: 100%; text-align: center;">
            <div style="width: 500px; height: auto; display: inline-block; background-color:white; border-radius: 10px; margin-top: 2%; margin-left: 2%; margin-right: 2%; -webkit-box-shadow:0px 0px 80px 0px #9e9e9e ; -moz-box-shadow:0px 0px 80px 0px #9e9e9e ; box-shadow:0px 0px 80px 0px #9e9e9e ;">
            <h2> Une idée de votre trajet?</h2>
            <img src="./img/travel.jpg" alt="Une petite promenade?" style="width: 300px; height: 200px">
            <h4>
                Composez votre propre trajet, en choissisant votre point de départ et votre point d'arrivée. <br>
                Réserver aussi des hôtels et choisissez votre temps de séjour !
            </h4>
            <a href="./reservation/reservationunique.php">
            <button>
                J'ai une idée !
            </button> </a> <br>
            </div>
            <div style="width: 500px; height: auto; display: inline-block; background-color:white; border-radius: 10px; margin-top: 2%; margin-left: 2%; margin-right: 2%; -webkit-box-shadow:0px 0px 80px 0px #9e9e9e ; -moz-box-shadow:0px 0px 80px 0px #9e9e9e ; box-shadow:0px 0px 80px 0px #9e9e9e ;">
            <h2> Besoin d'un guide ?</h2>
            <img src="./img/pack.png" alt="Une petite promenade?" style="width: 300px; height: 200px">
            <h4>
                Nous vous proposons des trajets pré-définis, via les expériences de nos utilisateurs. <br>
                Plus qu'à choisir votre période !
            </h4>
            <button>
                Je veux un pack !
            </button><br>
            </div>
        </div>
        <br>
        
    </main>

    <footer class="fixed-bottom bg-light py-2">
        <div class="container text-center">
            <p class="m-0">&copy; 2023 - River Ride</p>
        </div>
    </footer>
    
</body>

</html>