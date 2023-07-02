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
</head>
<body>
    <div class="header d-flex">
        <img src="../img/badge/staffbadge.png" alt="logo SuperCoin" id="logo"/>
        <div class="user-info">
            <img src="../img/picture/pp.png" alt="Photo de profil" class="profile-picture" id="pp"/>
            <div class="username mt-2 col-md-3 ">
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
            </ul>
        </div>

        <div class="main-content">
            <h1>SuperBackOffice 1.0</h1>
            <h2>Les commentaires</h2>
            <h3>Les commentaires et leur contenus</h3>
            <?php

            // Récupérer les commentaires avec les informations du journal ou du topic
            $query = $bdd->prepare('SELECT c.*, j.titre AS journal_titre, t.titre AS topic_titre
                                   FROM commentaires c
                                   LEFT JOIN journal j ON c.Journal_id_Journal = j.id_Journal
                                   LEFT JOIN topic t ON c.Topic_id_Topic = t.id_Topic');
            
            $query->execute();
            $comments = $query->fetchAll(PDO::FETCH_ASSOC);
            $query->closeCursor();

            if (!empty($comments)) {
                echo '<p>Gestion des commentaires :</p>';
                echo '<table class="table table-condensed table-striped">';
                echo '<tr> <th> Contenu </th> <th> Pseudo </th> <th> Journal/Topic </th> <th> Supprimer </th> </tr>';
                // Affichage des informations des commentaires
                foreach ($comments as $comment) {
                    echo '<tr>';
                    echo '<td>' . $comment["Contenu"] . '</td>';
                    echo '<td>' . $comment["Pseudo"] . '</td>';
                    echo '<td>';
                    if (!empty($comment["journal_titre"])) {
                        echo 'Journal: ' . $comment["journal_titre"];
                    } elseif (!empty($comment["topic_titre"])) {
                        echo 'Topic: ' . $comment["topic_titre"];
                    } else {
                        echo 'N/A';
                    }
                    echo '</td>';
                    echo "<td> <a class='badge badge-danger' href='./topic/supprimer.php?id_Commentaires=" . $comment["id_Commentaires"] . "'>Supprimer</a> </td>";
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "Aucun commentaire trouvé.";
            }
            ?>
        </div>
    </div>
</body>
</html>
