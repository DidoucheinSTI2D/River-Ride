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
    <div class="container">
        <div class="column-left" id="left">
            <h2>Menu</h2>
            <ul>
                <li><a href="../connect.php">Accueil</a></li>
                <li><a href="./backoffice.php">BackOffice</a></li>
                <li><a href="./user.php">Utilisateurs</a></li>
                <li><a href="./topic.php">Topics</a></li>
                <li><a href="./comment.php">Commentaires</a></li>
                <li><a href="./alarm.php">Signalements</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="./settings.php">Paramètres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h3>Topics</h3>
            <?php

            function deleteTopic($id_Topic)
            {
                require('../BDD/config.php');
                // Préparez la requête de suppression
                $req = $bdd->prepare('DELETE FROM topic WHERE id_Topic = ? ');
                $req->execute(array($id_Topic));
                $req->closeCursor();
            }

            function modificateTopic($id_Topic, $new_title)
            {
                require('../BDD/config.php');
                $req = $bdd->prepare('UPDATE topic SET titre = ? WHERE id_Topic = ?');
                $req->execute(array($new_title, $id_Topic));
                $req->closeCursor();
            }

            if (isset($_POST['addTopic'])) {
                $id_topic = $_POST['id_topic'];
                $date_creation = $_POST['date_creation'];
                $contenu = $_POST['contenu'];
                $createur = $_POST['createur'];
                ajouter_topic($id_topic, $date_creation, $contenu, $createur);
                echo "Topic ajouté avec succès !";
            }

            if (isset($_POST['deleteTopic'])) {
                $id_topic = $_POST['id_topic'];
                supprimer_topic($id_topic);
                echo "Topic supprimé avec succès !";
            }
            ?>

            <?php
            // Récupérer les topics
            $req = $bdd->prepare('SELECT * FROM topic');
            $req->execute();
            $topics = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            if (!empty($topics)) {
                echo '<p>Gestion des topics :</p>';
                echo '<table class="table table-condensed table-striped">';
                echo '<tr> <th> Id </th> <th> Date de création </th> <th> Contenu </th> <th> Utilisateur </th> <th> Modifier </th> <th> Supprimer </th> </tr>';
                // Affichage des informations des topics
                foreach ($topics as $topic) {
                    echo '<tr>';
                    echo '<td>' . $topic["id_Topic"] . '</td>';
                    echo '<td>' . $topic["Date_création"] . '</td>';
                    echo '<td>' . $topic["Contenu"] . '</td>';
                    echo '<td>' . $topic["Utilisateur_id_Utilisateur"] . '</td>';
                    echo "<td> <a class='badge badge-warning' href='update.php?id=" . $topic["id_Topic"] . "'>Modifier</a> </td>";
                    echo "<td> <a class='badge badge-danger' href='delete.php?id=" . $topic["id_Topic"] . "'>Supprimer</a> </td>";
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "Aucun topic trouvé.";
            }
            ?>

            <form method="POST">
                <label for="id_topic">ID du topic:</label> <input type="text" name="id_topic" required>
                <label for="date_creation">Date de création:</label> <input type="date" name="date_creation" required>
                <label for="contenu">Contenu:</label> <input type="text" name="contenu" required>
                <label for="createur">Id Créateur:</label> <input type="text" name="createur" required>
                <button type="submit" name="addTopic">Ajouter Topic</button>
            </form>
            <form method="POST">
                <label for="id_topic">ID du Topic:</label> <input type="text" name="id_topic" required>
                <button type="submit" name="deleteTopic">Supprimer Topic</button>
            </form>
        </div>
    </div>
</body>

</html>