<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - Blog</title>
</head>
<body>
    <header>
        <?php 
            session_start(); 
            include "./component/header.php"; 
        ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">
    <?php
    require_once('BDD/config.php');
    require_once('LeSuPerisien/fonctions.php');

    $Topics = getTopics();
    ?>
    <h1> Bienvenue sur l'espage Blog de la communauté ! </h1>
    <?php 
        if (isset($_SESSION['id_Utilisateur'])){
    ?>
    <a href="création_topic.php" class="btn btn-primary btn-lg active" role="button" aria-pressed="true">Créer mon topic</a>
    <?php
        }
    ?>
    <div class="container py-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <?php foreach(($Topics) as $Topic): ?>
        <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold"> <?=$Topic->titre ?></h1>
            <a href="topic.php?id_Topic=<?= $Topic->id_Topic ?>"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour rejoindre cette discussion !</button></a>
        </div>
        <?php endforeach ?>
</div>

    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>