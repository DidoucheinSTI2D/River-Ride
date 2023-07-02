<?php
    session_start();
    require "../BDD/config.php";
    require "../LeSuPerisien/fonctions.php";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../connect.php");
        exit();
    }


    if (isset($_POST['create_journal'])) {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $author = $_POST['author'];
        createJournal($title, $content, $author);
        echo "Journal ajouté avec succès !";
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
                <li><a href="./LeSuPerisien.php">LeSuPerisien</a></li>
                <li><a href="./topic.php">Topics</a></li>
                <li><a href="./comment.php">Commentaires</a></li>
                <li><a href="./alarm.php">Signalements</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="./settings.php">Paramètres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h3>Journaux :</h3>

            <?php
            // Récupérer les journaux
            $req = $bdd->prepare('SELECT * FROM journal');
            $req->execute();
            $journals = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            if (!empty($journals)) {
                echo '<p>Gestion des journaux :</p>';
                echo '<table class="table table-condensed table-striped">';
                echo '<tr> <th> Titre </th> <th> Contenu </th> <th> Date de création </th> <th> Rédacteur </th> <th> Modifier </th> <th> Supprimer </th> </tr>';
                // Affichage des informations des topics
                foreach ($journals as $journal) {
                    echo '<tr>';
                    echo '<td>' . $journal["Titre"] . '</td>';
                    echo '<td>' . $journal["Contenu"] . '</td>';
                    echo '<td>' . $journal["date_création"] . '</td>';
                    echo '<td>' . $journal["Rédacteur"] . '</td>';
                    echo "<td> <a class='badge badge-warning' href='./LeSuPerisien/modifier_LeSuPerisien.php?id_Journal=" . $journal["id_Journal"] . "'>Modifier</a> </td>";
                    echo "<td> <a class='badge badge-danger' href='./topic/supprimer.php?id_Journal=" . $journal["id_Journal"] . "'>Supprimer</a> </td>";
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "Aucun topic trouvé.";
            }
            ?>
            <h3> Création de Journal : </h3>
            <form action="" method="post">
                <p>
                    <label for="title">Titre :</label><br>
                    <input type="text" name="title" id="title" value="<?= isset($_POST['title']) ? $_POST['title'] : '' ?>">
                </p>
                <p>
                    <label for="content">Contenu :</label><br>
                    <textarea name="content" id="content" cols="30" rows="4"><?= isset($_POST['content']) ? $_POST['content'] : '' ?></textarea>
                </p>
                <p>
                    <label for="author">Auteur :</label><br>
                    <input type="text" name="author" id="author" value="<?= isset($_POST['author']) ? $_POST['author'] : '' ?>">
                </p>
                <button type="submit" name="create_journal">Créer !</button>
            
        </div>
    </div>
</body>

</html>