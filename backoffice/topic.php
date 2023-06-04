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
    $servername = "localhost"; // Nom du serveur où se trouve la base de données
    $username = "root"; // Nom d'utilisateur pour accéder à la base de données
    $password = ""; // Mot de passe pour accéder à la base de données
    $dbname = "mastertheweb"; // Nom de la base de données
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
      die("Erreur de connexion à la base de données : " . $conn->connect_error);
    }

    function checkAdminAccess() {
      // Vérifier si l'utilisateur est connecté
      if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../connect.php");
        exit();
      }
      
      // Vérifier si l'utilisateur a le droit admin
      if ($_SESSION['Droits'] !== 'admin') {
        header("Location: reject.php");
        exit();
      }
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
            session_start();
            if (!isset($_SESSION['Pseudo'])) {
                $_SESSION['Pseudo'] = "root";
            }
            echo $_SESSION['Pseudo'];
            ?>
            </div>
            <button class="logout-button">Déconnexion</button>
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
            function ajouter_topic($id_topic, $date_creation, $contenu, $createur) {
                global $conn;
                $stmt = $conn->prepare("INSERT INTO topic (id_Topic, Date_création, Contenu, Utilisateur_id_Utilisateur) VALUES (?, ?, ?, ?)");

                if (!$stmt) {
                    die("Erreur de préparation de la requête : " . $conn->error);
                }
                $stmt->bind_param("isss", $id_topic, $date_creation, $contenu, $createur);

                if (!$stmt->execute()) {
                    die("Erreur d'exécution de la requête : " . $stmt->error);
                }
                $stmt->close();
            }

            function supprimer_topic($id_topic) {
                global $conn;
                $stmt = $conn->prepare("DELETE FROM topic WHERE id_Topic = ?");

                if (!$stmt) {
                    die("Erreur de préparation de la requête : " . $conn->error);
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

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                echo '<p>Gestion des topics :</p>';
                echo '<table class="table table-condensed table-striped">';
                echo '<tr> <th> Id </th> <th> Date de création </th> <th> Contenu </th> <th> Utilisateur </th> <th> Modifier </th> <th> Supprimer </th> </tr>';
                // Affichage des informations des topics
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' .$row["id_Topic"]. '</td>';
                    echo "<td>" .$row["Date_création"]. "</td>";
                    echo "<td>" .$row["Contenu"]. "</td>";
                    echo "<td>" .$row["Utilisateur_id_Utilisateur"]. "</td>";
                    echo "<td> <a class='badge badge-warning' href='update.php?id=" . $row["id_Topic"] . "'>Modifier</a> </td>";
                    echo "<td> <a class='badge badge-danger' href='delete.php?id=" . $row["id_Topic"] . "'>Supprimer</a> </td>";
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "Aucun topic trouvé.";
            }

            $conn->close();
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