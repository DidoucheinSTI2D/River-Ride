<?php
    session_start();
    require "./BDD/config.php";
    require "./LeSuPerisien/fonctions.php";

    $journals = getJournals();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - LeSuPerisien</title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">    
    <div class="container py-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <?php foreach(array_slice($journals, 0, 1) as $journal): ?>
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold"> <?=$journal->Titre ?></h1>
            <p>Eventuellement court résumé/description</p>
            <a href="journal.php?id_Journal=<?= $journal->id_Journal ?>"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour lire l'article !</button></a>
        </div>
        <?php endforeach ?>
    </div>
    <div class="row align-items-md-stretch">
        <?php foreach(array_slice($journals, 1) as $journal): ?>
        <div class="col-md-6">
            <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                <h2><?=$journal->Titre ?></h2>
                <a href="journal.php?id_Journal=<?= $journal->id_Journal ?>"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour lire l'article !</button></a>
            </div>
        </div>
        <?php endforeach ?>
    </div>
</div>

    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>