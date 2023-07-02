<?php
    session_start();
    require "./BDD/config.php";
    require "./LeSuPerisien/fonctions.php";

    $coins = getCoins();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coin du moment</title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">    
    <div class="container py-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
        <?php foreach(array_slice($coins, 0, 1) as $coin): ?>
        <h1 class="display-5 fw-bold"> <?=$coin->nom ?></h1>
        <div class="container-fluid py-5">
            <h2> Prix : <?=$coin->prix ?> €</h2>
            <p><?=$coin->commentaire ?></p>
            <h4> Potentiel : <?=$coin->potentiel ?> !</h4>
            <a href="<?= $coin->lien ?>"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour en acheter sur CoinBase !</button></a>
            
        </div>
        <p> rédigé le : <?=$coin->date ?> </p>
        <?php endforeach ?> 
    </div>
    <div class="row align-items-md-stretch">
        <?php foreach(array_slice($coins, 1) as $coin): ?>
        <div class="col-md-6">
    
            <div class="h-100 p-5 bg-body-tertiary border rounded-3">
            <h2 class="display-5 fw-bold"> <?=$coin->nom ?></h2>
            <h3> Prix : <?=$coin->prix ?> €</h3>
            <p><?=$coin->commentaire ?></p>
            <h5> Potentiel : <?=$coin->potentiel ?> !</h5>
            <a href="<?= $coin->lien ?>"><button class="btn btn-outline-secondary" type="button">Cliquez ici pour en acheter sur CoinBase !</button></a>
            <p> rédigé le : <?=$coin->date ?> </p>
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