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
    
    // Crée une connexion
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
        <div>
        <h3>Utilisateurs</h3>
        <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addUser"])) {
            $iduser = $_POST["id_Utilisateur"];
            $username = $_POST["Pseudo"];
            $password = $_POST["mot_de_passe"];
            $droits = $_POST["Droits"];
            $email = $_POST["e-mail"];
            $birthdate = $_POST["date_de_naissance"];
            $sql = "INSERT INTO `utilisateur` (`Id_utilisateur`, `Pseudo`, `Droits`, `e-mail`, `mot_de_passe`, `date_de_naissance`) VALUES ($iduser, $username, $droits, $email, $password, $birthdate);";        
            $conn = new mysqli("$servername", "$username", "$password", "$dbname");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if ($conn->query($sql) === TRUE) {
                echo "Utilisateur ajouté avec succès.";
            } else {
                echo "Erreur lors de l'ajout de l'utilisateur: " . $conn->error;
            }
            $conn->close();
            }
        ?>

        <?php
            // Requête SQL pour récupérer les informations de l'utilisateur
            $sql = "SELECT * FROM `utilisateur`";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
            // Récupération des données de l'utilisateur
            $user = $result->fetch_assoc();
            echo '<p>Gestion des utilisateurs :</p>';
            echo '<table class="table table-condensed table-striped">';
            echo '<tr> <th> Id </th> <th> Pseudo </th> <th> Email </th> <th> Date de naissance </th> <th> Droits </th> <th> Supprimer </th> </tr>';
            // Affichage des informations de l'utilisateur
            while ($row = $result->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' .$row["id_Utilisateur"]. '</td>';
                echo "<td>" .$row["Pseudo"]. "</td>";
                echo "<td>" .$row["e-mail"]. "</td>";
                echo "<td> " . $row["date_de_naissance"] . "</td>";
                echo "<td>" .$row["Droits"]. "</td>";
                echo "<td> <a class='badge badge-danger' href='delete.php?id=" . $row["id_Utilisateur"] . "'>Supprimer</a> </td>";
                echo '</tr>';
            }
            } else {
            echo "Aucun utilisateur trouvé.";
            }

            $conn->close();
        ?>
        <form method="POST">
            <label for="iduser">Id:</label> <input type="text" name="username" required>
            <label for="username">Pseudo:</label> <input type="text" name="username" required>
            <label for="password">Mot de passe:</label> <input type="password" name="password" required>
            <label for="email">Email:</label> <input type="email" name="email" required>
            <label for="birthdate">Date de naissance:</label> <input type="date" name="birthdate" required>
            <label for="droits">Droits:</label>
            <select name="droits" id="droits">
            <option value="admin">Admin</option>
            <option value="user">Users</option>
            </select>
            <button type="submit" name="addUser">Ajouter</button>
            <button type="submit" name="exp">Modifier</button>
            <button type="submit" name="deleteUser">Supprimer</button>
        </form>
        </div>
    </div>
  </body>
</html>