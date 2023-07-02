<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="LeSuperCoin">
    <title>SuperBackOffice</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <?php
    require_once "../BDD/config.php";
    session_start();

    if (!isset($_SESSION['id_Utilisateur'])){
       header("location: ../connect.php?error=notconnected");
       exit;
    }

      if ($_SESSION['droits'] !== 'admin') {
        header("Location: ../profil.php?error=notadmin");
        exit();
    }
    ?>
</head>
<body>
    <div class="header d-flex">
        <img src="../img/badge/staffbadge.png" alt="logo SuperCoin" id="logo"/>
        <div class="user-info">
            <img src="../img/picture/pp.png" alt="Photo de profil" class="profile-picture" id="pp"/>
            <div class="username mt-2 col-md-3 ">
              <?php 
              if (!isset($_SESSION['Pseudo'])) {
                  $_SESSION['Pseudo'] = "root";
              }
              echo $_SESSION['Pseudo'];
              ?>
            </div>
            <a href="../disconnect.php"><button id="logout" class="logout-button">Déconnexion</button></a>
        </div>
    </div>
    <div class="container">
        <div class="column-left" id="left">
            <h2>Menu</h2>
            <ul>
                <li><a href="../connect.php">Accueil</a></li>
                <li><a href="./backoffice.php">BackOffice</a></li>
                <li><a href="./user.php">Utilisateurs</a></li>
                <li><a href="./LeSuPerisien.php">LeSuPerisien</a></li>
                <li><a href="./topic.php">Topics</a></li>
                <li><a href="./coindumoment.php">Coin du moment</a></li>
                <li><a href="./comment.php">Commentaires</a></li>
                <li><a href="./alarm.php">Signalements</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="./settings.php">Paramètres</a></li>
                <li><a href="./configure_learn2win.php">Learn2win</a></li>
                <li><a href="./captcha.php">Captcha</a></li>
            </ul>
        </div>
        <div class="main-content">
        <h1>SuperBackOffice 1.0</h1>
        <h2>le back office</h2>
        <h3>le nombre d'utilisateurs</h3>
        <p>
            <?php
            $sql = "SELECT COUNT(*) AS nb FROM `utilisateur`";
            $stmt = $bdd->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $row['nb'];
            ?>
        </p>
        <h3>le nombre de topics</h3>
        <p>
            <?php
            $sql = "SELECT COUNT(*) AS nb FROM topic";
            $stmt = $bdd->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $row['nb'];
            ?>
        </p>
        <h3>le nombre de commentaires</h3>
        <p>
            <?php
            $sql = "SELECT COUNT(*) AS nb FROM commentaires";
            $stmt = $bdd->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $row['nb'];
            ?>
        </p>
        <h3>le nombre de signalements</h3>
        <p>
              EN COURS DE DEVELOPPEMENT
        </p>
        <h3>le nombre de messages</h3>
        <p>
            <?php
            $sql = "SELECT COUNT(*) AS nb FROM messages";
            $stmt = $bdd->query($sql);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            echo $row['nb'];
            ?>
        </p>
    </div>
</div>
</body>
</html>