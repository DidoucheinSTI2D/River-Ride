<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>River Ride - Accueil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <style>
        body{
            background-image: url(./img/background.jpg);
        }
    </style>
</head>
<body>
    <header>
    <nav class="navbar navbar-expand-lg navbar-light bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#">River Ride</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="connexion.php">Se Connecter</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="inscription.php">S'inscrire</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    </header>


    <main>
        <?php if (isset($_GET['disconnect']) && $_GET['disconnect'] === "success") echo 'Merci de votre visite !'; ?>
    </main>



    <footer class="bg-light container sticky-bottom">
            <p>&copy; 2023 River Ride. Tous droits réservés.</p>  
    </footer>



</body>
</html>
