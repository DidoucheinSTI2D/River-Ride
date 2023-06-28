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
                <li><a href="./topic.php">Topics</a></li>
                <li><a href="./comment.php">Commentaires</a></li>
                <li><a href="./alarm.php">Signalements</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="./settings.php">Paramètres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h3>Utilisateurs</h3>
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["addUser"])) {
                $pseudo = $_POST["pseudo"];
                $userpassword = $_POST["mot_de_passe"];
                $droits = $_POST["droits"];
                $email = $_POST["email"];
                $birthdate = $_POST["date_de_naissance"];
                $sql = "INSERT INTO `utilisateur` (`Pseudo`, `Droits`, `e-mail`, `mot_de_passe`, `date_de_naissance`) VALUES ('$pseudo', '$droits', '$email', '$userpassword', '$birthdate')";
                if ($bdd->query($sql)) {
                    echo "Utilisateur ajouté avec succès.";
                } else {
                    echo "Erreur lors de l'ajout de l'utilisateur: " . $bdd->error;
                }
                }
            ?>
            <?php
                // Requête SQL pour récupérer les informations de l'utilisateur
                $sql = "SELECT * FROM `utilisateur` ORDER BY `id_Utilisateur` ASC";
                $result = $bdd->query($sql);

                if (isset($_GET['delete'])) {
                    $delete = $_GET['delete'];
                    // Vérifier si l'utilisateur existe avant de supprimer
                    $checkUserSql = "SELECT * FROM `utilisateur` WHERE `id_Utilisateur` = ?";
                    $stmt = $bdd->prepare($checkUserSql);
                    $stmt->bind_param("i", $delete);
                    $stmt->execute();
                    $stmt->store_result();
                    if ($stmt->num_rows > 0) {
                        // Afficher une confirmation de suppression
                        echo "<script>
                                var result = confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur?');
                                if (result) {
                                    window.location.href = '?delete_confirmed=' + $delete;
                                }
                            </script>";
                    } else {
                        echo "Utilisateur introuvable.";
                    }
                    $stmt->close();
                }
            
                if (isset($_GET['delete_confirmed'])) {
                    $deleteConfirmed = $_GET['delete_confirmed'];
                    $sql = "DELETE FROM `utilisateur` WHERE `id_Utilisateur` = ?";
                    $stmt = $bdd->prepare($sql);
                    $stmt->bind_param("i", $deleteConfirmed);
                    $stmt->execute();
                    $stmt->close();
                    // Rediriger vers la page principale après suppression
                    header("Location: ./user.php");
                    exit();
                }

                if (isset($_GET['isban'])) {
                    $isban = $_GET['isban'];
                    $sql = "UPDATE `utilisateur` SET `isban` = 'true' WHERE `id_Utilisateur` = ?";
                    $stmt = $bdd->prepare($sql);
                    $stmt->bind_param("i", $isban);
                    $stmt->execute();
                    $stmt->close();
                }

                if ($result->rowCount() > 0) {
                    // Récupération des données de l'utilisateur
                    echo '<p>Gestion des utilisateurs :</p>';
                    echo '<table class="table table-condensed table-striped">';
                    echo '<tr> <th> Id </th> <th> Pseudo </th> <th> Email </th> <th> Date de naissance </th> <th> Droits </th> <th> Banni? </th> <th> Supprimer </th> <th> Bannir </th> </tr>';
                    // Affichage des informations de l'utilisateur
                    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        echo '<tr>';
                        echo '<td>' .$row["id_Utilisateur"]. '</td>';
                        echo "<td>" .$row["Pseudo"]. "</td>";
                        echo "<td>" .$row["e-mail"]. "</td>";
                        echo "<td> " . $row["date_de_naissance"] . "</td>";
                        echo "<td>" .$row["Droits"]. "</td>";
                        echo "<td>" .$row["isban"]. "</td>";
                        echo "<td> <a class='badge badge-danger' href='?delete=" . $row["id_Utilisateur"] . "'>Supprimer</a> </td>";
                        echo "<td> <a class='badge badge-warning' href='?isban=" . $row["id_Utilisateur"] . "'>Bannir</a> </td>";
                        echo '</tr>';
                    }
                } else {
                    echo "Aucun utilisateur trouvé.";
                }

                $bdd = null;
            ?>
            <form method="POST">
                <label for="pseudo">Pseudo:</label> <input type="text" name="pseudo" required>
                <label for="mot_de_passe">Mot de passe:</label> <input type="password" name="mot_de_passe" required>
                <label for="email">Email:</label> <input type="email" name="email" required>
                <label for="date_de_naissance">Date de naissance:</label> <input type="date" name="date_de_naissance" required>
                <label for="droits">Droits:</label>
                <select name="droits" id="droits">
                <option value="admin">admin</option>
                <option value="user">user</option>
                </select>
                <button type="submit" name="addUser">Ajouter</button>
                <button type="submit" name="exp">Modifier</button>
            </form>
        </div>
    </div>
  </body>
</html>