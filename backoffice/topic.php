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
    session_start();
    require "../BDD/config.php";
    require "../LeSuPerisien/fonctions.php";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../connect.php");
        exit();
    }


    ?>
</head>

<body>
    <div class="header d-flex">
        <img src="../img/badge/staffbadge.png" alt="logo SuperCoin" id="logo" />
        <div class="user-info">
            <img src="../img/picture/pp.png" alt="Photo de profil" class="profile-picture" id="pp" />
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
    <?php if (isset($_GET['message']) && $_GET['message'] === 'success') {
        echo '<div class="success-message">Topic modifié avec succès !</div>';
    }
    ?>
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
            </ul>
        </div>
        <div class="main-content">
            <h3>Topics</h3>
            <?php

            // Récupérer les topics
            $req = $bdd->prepare('SELECT * FROM topic');
            $req->execute();
            $topics = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            if (!empty($topics)) {
                echo '<p>Gestion des topics :</p>';
                echo '<table class="table table-condensed table-striped">';
                echo '<tr> <th> Titre </th> <th> Date de création </th> <th> Contenu </th> <th> Id_Créateur </th> <th> Modifier titre </th> <th> Supprimer </th> </tr>';
                // Affichage des informations des topics
                foreach ($topics as $topic) {
                    echo '<tr>';
                    echo '<td>' . $topic["titre"] . '</td>';
                    echo '<td>' . $topic["date_création"] . '</td>';
                    echo '<td>' . $topic["contenu"] . '</td>';
                    echo '<td>' . $topic["Utilisateur_id_Utilisateur"] . '</td>';
                    echo "<td> <a class='badge badge-warning' href='./topic/modifier_topic.php?id_Topic=" . $topic["id_Topic"] . "'>Modifier</a> </td>";
                    echo "<td> <a class='badge badge-danger' href='./topic/supprimer.php?id_Topic=" . $topic["id_Topic"] . "'>Supprimer</a> </td>";
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "Aucun topic trouvé.";
            }
            ?>
        </div>
    </div>
</body>

</html>
