<?php
    session_start();
    require "./BDD/config.php";

    if (isset($_SESSION['id_Utilisateur'])) {
        header("Location: LeSuperisien.php");
        exit();
    }

    if (isset($_POST['connect'])){

        if (empty($erreur)){
            $_SESSION['id_Utilisateur'] = $resultUser['id_Utilisateur'];
            $_SESSION['Pseudo'] = $resultUser['Pseudo'];
            $_SESSION['Email'] = $resultUser['e-mail'];
            $_SESSION['droits'] = $resultUser['Droits'];
            if ($_SESSION['droits'] == 'user'){
                header("Location: index.php?id=" .  $_SESSION['id']);
            } elseif ($_SESSION['droits'] == 'admin'){
                header("Location: ./admin/backoffice.php?id=" . $_SESSION['id']);
            }
            exit();
    }
}
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - Acceuil</title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
        <?php include "./logs.php"; ?>
    </header>
    <!---->
    <main class="container">
        <br>
            <h1 id="bvn"> Bienvenue Voyageur ! </h1>
            <h1 style="color: green;" id="bvn">
                <?php
                if(isset($_GET['disconnect']) && $_GET['disconnect'] = "success"){
                    echo "Merci de votre visite ! à bientôt ! ❤";
                }
                ?>
            </h1>
        <br>
        <!--Gros bloc-->
        <div class="align-content-end border-dark border-bottom container py-4">
            <div class="p-5 mb-4 text-bg-dark rounded-3" id="premierart">
                <div class="container-fluid py-5">
                <h1 class="display-4 fw-bold text-white"><br>Titre de l'article</h1>
                <p class="lead my-3 fw-semibold">Découvrez les meilleures articles dans le Domaine Crypto !</p>
                <p class="lead mb-0"><a href="BDD/register.php" class="text-white fw-bold">Je m'inscris !</a></p>
                </div>
            </div>
        </div>
        <!-- Fin partie Info-->
        <div>
            <div class="container py-4">
                <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                  <div class="container-fluid py-5">
                    <h1 class="display-5 fw-bold">Les Coins du Moment</h1>
                    <p class="col-md-8 fs-4">10, 20, 50, 100 ou encore 1000% ! découvrez les tokens du moment en voyant les plus perdants et les plus gagnants et prévoyez votre prochaine moove!</p>
                    <a href="connect.php"><button class="btn btn-primary btn-lg" type="button">Découvrez-les ici !</button></a>
                  </div>
                </div>
            
                <div class="row align-items-md-stretch">
                  <div class="col-md-6">
                    <div class="h-100 p-5 text-bg-dark rounded-3">
                      <h2>Blog</h2>
                      <br>
                      <p>Découvrez les derniers topics et participer à la création d'une communauté!</p>
                      <br>
                      <a href="connect.php"><button class="btn btn-outline-light" type="button">Je veux rejoindre le blog !</button></a>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="h-100 p-5 bg-body-tertiary border rounded-3">
                      <h2>🚧L̷e̷a̷r̷n̷2̷w̷i̷n̷🚧</h2>
                      <p>Actuellement en travaux, vous pourrez bientôt participer à notre e-learning en ligne, et pouvoir gagner le token "LeSuperCoin"! Inscrivez-vous à notre newsletter pour avoir les dernières informations de notre équipe de dev.</p>
                      <button class="btn btn-outline-secondary" type="button"><a href="./newsletter.php">Inscrivez-vous à notre newsletter</a></button>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </main>
    <!---->
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>