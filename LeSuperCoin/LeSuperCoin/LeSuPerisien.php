<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - LeSuPerisien</title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
    </header>
    <main class="container">
    <!-- // Connexion à la base de données
$bdd = new PDO('mysql:host=localhost;dbname=nom_de_la_base_de_donnees', 'nom_d_utilisateur', 'mot_de_passe');

    // Fermeture de la requête
    $requete->closeCursor();
}

// Fermeture de la connexion à la base de données
$bdd = null;
-->
    <div class="container py-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Titre de l'article recup via requete SQL</h1>
            <p>Eventuellement court résumé/description</p>
            <a href="./journal.php"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour lire l'article !</button></a>
        </div>
    </div>
    <div class="row align-items-md-stretch">
    <div class="col-md-6">
        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
            <h2>Titre de l'article recup via requete SQL</h2>
                <a href="./journal.php"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour lire l'article !</button></a>
        </div>
    </div>
    <div class="col-md-6">
        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
            <h2>Titre de l'article recup via requete SQL</h2>
                <a href="./journal.php"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour lire l'article !</button></a>
        </div>
    </div>
    </div>
    </div>
    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>