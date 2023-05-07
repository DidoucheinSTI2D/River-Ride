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
        <h1>BackOffice</h1>
        <div class="row">
            <div class="col-12">
                <h2>Utilisateurs</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>id_Utilisateur</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Mail</th>
                            <th>Droits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM utilisateur";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id_Utilisateur']; ?></td>
                                    <td><?php echo $row['Nom']; ?></td>
                                    <td><?php echo $row['Prenom']; ?></td>
                                    <td><?php
                                    if ($row['Mail'] !== null) {
                                        echo $row['Mail'];
                                    } else {
                                        echo '<i>Non renseigné</i>';
                                    }
                                    ?></td>
                                    <td><?php echo $row['Droits']; ?></td>
                                    <td>
                                        <a href="./edit_user.php?id=<?php echo $row['id_Utilisateur']; ?>">Modifier</a>
                                        <a href="./delete_user.php?id=<?php echo $row['id_Utilisateur']; ?>">Supprimer</a>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "0 résultats";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="./add_user.php">Ajouter un utilisateur</a>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h2>Produits</h2>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>id_Produit</th>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Prix</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT * FROM produit";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) { ?>
                                <tr>
                                    <td><?php echo $row['id_Produit']; ?></td>
                                    <td><?php echo $row['Nom']; ?></td>
                                    <td><?php echo $row['Description']; ?></td>
                                    <td><?php echo $row['Prix']; ?></td>
                                    <td>
                                        <a href="./edit_product.php?id=<?php echo $row['id_Produit']; ?>">Modifier</a>
                                        <a href="./delete_product.php?id=<?php echo $row['id_Produit']; ?>">Supprimer</a>
                                    </td>
                                </tr>
                            <?php }
                        } else {
                            echo "0 résultats";
                        }
                        ?>
                    </tbody>
                </table>
                <a href="./add_product.php">Ajouter un produit</a>
            </div>
        </div>
    </div>
</body>
</html>