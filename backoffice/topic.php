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
<<<<<<< HEAD

    <?php
    session_start();
    require "../BDD/config.php";
    require "../LeSuPerisien/fonctions.php";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../connect.php");
=======
    <?php
    require_once "../BDD/config.php";
    session_start();

    if (!isset($_SESSION['id_Utilisateur'])){
       header("location: ../connect.php?error=notconnected");
       exit;
    }

      if ($_SESSION['droits'] !== 'admin') {
        header("Location: ../profil.php?error=notadmin");
>>>>>>> 2ff2b293f270cbed8f533cd051e272b3f2dd2b26
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
<<<<<<< HEAD
                <?php
                if (!isset($_SESSION['Pseudo'])) {
                    $_SESSION['Pseudo'] = "root";
                }
                echo $_SESSION['Pseudo'];
                ?>
=======
            <?php 
            if (!isset($_SESSION['Pseudo'])) {
                $_SESSION['Pseudo'] = "root";
            }
            echo $_SESSION['Pseudo'];
            ?>
>>>>>>> 2ff2b293f270cbed8f533cd051e272b3f2dd2b26
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
<<<<<<< HEAD

            // Récupérer les topics
            $req = $bdd->prepare('SELECT * FROM topic');
            $req->execute();
            $topics = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            if (!empty($topics)) {
=======
            function ajouter_topic($id_topic, $date_creation, $contenu, $createur) {
                global $bdd;
                $stmt = $bdd->prepare("INSERT INTO topic (id_Topic, Date_création, Contenu, Utilisateur_id_Utilisateur) VALUES (?, ?, ?, ?)");

                if (!$stmt) {
                    die("Erreur de préparation de la requête : " . $bdd->error);
                }
                $stmt->bind_param("isss", $id_topic, $date_creation, $contenu, $createur);

                if (!$stmt->execute()) {
                    die("Erreur d'exécution de la requête : " . $stmt->error);
                }
                $stmt->close();
            }

            function supprimer_topic($id_topic) {
                global $bdd;
                $stmt = $bdd->prepare("DELETE FROM topic WHERE id_Topic = ?");

                if (!$stmt) {
                    die("Erreur de préparation de la requête : " . $bdd->error);
                }
                $stmt->bind_param("i", $id_topic);

                if (!$stmt->execute()) {
                    die("Erreur d'exécution de la requête : " . $stmt->error);
                }
                $stmt->close();
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
            // Affichage des topics
            $sql = "SELECT * FROM topic";

            $result = $bdd->query($sql);

            if ($result->rowCount() > 0) {
>>>>>>> 2ff2b293f270cbed8f533cd051e272b3f2dd2b26
                echo '<p>Gestion des topics :</p>';
                echo '<table class="table table-condensed table-striped">';
                echo '<tr> <th> Titre </th> <th> Date de création </th> <th> Contenu </th> <th> Id_Créateur </th> <th> Modifier titre </th> <th> Supprimer </th> </tr>';
                // Affichage des informations des topics
<<<<<<< HEAD
                foreach ($topics as $topic) {
=======
                while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
>>>>>>> 2ff2b293f270cbed8f533cd051e272b3f2dd2b26
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
<<<<<<< HEAD
=======

            $bdd = null;
>>>>>>> 2ff2b293f270cbed8f533cd051e272b3f2dd2b26
            ?>
        </div>
    </div>
</body>

</html>
