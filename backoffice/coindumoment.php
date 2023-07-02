<?php
    session_start();
    require "../BDD/config.php";
    require "../LeSuPerisien/fonctions.php";

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../connect.php");
        exit();
    }


    if (isset($_POST['add_coin'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $potential = $_POST['potential'];
        $comment = $_POST['comment'];
        $link = $_POST['link'];
        addCoin($name, $price, $potential, $comment, $link);
        echo "Coin ajouté avec succès !";
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
                <li><a href="./coindumoment.php">Coin du moment</a></li>
                <li><a href="./comment.php">Commentaires</a></li>
                <li><a href="./alarm.php">Signalements</a></li>
                <li><a href="./contact.php">Contact</a></li>
                <li><a href="./settings.php">Paramètres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h3>Coins :</h3>

            <?php
            // Récupérer les coins
            $req = $bdd->prepare('SELECT * FROM coindumoment');
            $req->execute();
            $coins = $req->fetchAll(PDO::FETCH_ASSOC);
            $req->closeCursor();

            if (!empty($coins)) {
                echo '<p>Gestion des Coins :</p>';
                echo '<table class="table table-condensed table-striped">';
                echo '<tr> <th> Nom </th> <th> Prix </th> <th> Potentiel </th> <th> Commentaire </th> <th> Lien </th> <th> Date </th> <th> Modifier </th> <th> Supprimer </th> </tr>';
                // Affichage des informations des topics
                foreach ($coins as $coin) {
                    echo '<tr>';
                    echo '<td>' . $coin["nom"] . '</td>';
                    echo '<td>' . $coin["prix"] . '</td>';
                    echo '<td>' . $coin["potentiel"] . '</td>';
                    echo '<td>' . $coin["commentaire"] . '</td>';
                    echo '<td>' . $coin["lien"] . '</td>';
                    echo '<td>' . $coin["date"] . '</td>';
                    echo "<td> <a class='badge badge-warning' href='./coindumoment/modifier_coin.php?id_Coin=" . $coin["id_Coin"] . "'>Modifier</a> </td>";
                    echo "<td> <a class='badge badge-danger' href='./topic/supprimer.php?id_Coin=" . $coin["id_Coin"] . "'>Supprimer</a> </td>";
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo "Aucun topic trouvé.";
            }
            ?>
            <h3> Ajout de Coin : </h3>
            <form action="" method="post">
                <p>
                    <label for="name">Nom :</label><br>
                    <input type="text" name="name" id="name" value="<?= isset($_POST['name']) ? $_POST['name'] : '' ?>">
                </p>
                <p>
                    <label for="price">Prix :</label><br>
                    <input type="text" name="price" id="price" value="<?= isset($_POST['price']) ? $_POST['price'] : '' ?>">
                </p>
                <p>
                    <label for="potential">Potentiel :</label><br>
                    <input type="text" name="potential" id="potential" value="<?= isset($_POST['potential']) ? $_POST['potential'] : '' ?>">
                </p>
                <p>
                    <label for="comment">Commentaire :</label><br>
                    <textarea name="comment" id="comment" cols="30" rows="4"><?= isset($_POST['comment']) ? $_POST['comment'] : '' ?></textarea>
                </p>
                <p>
                    <label for="link">Lien :</label><br>
                    <input type="text" name="link" id="link" value="<?= isset($_POST['link']) ? $_POST['link'] : '' ?>">
                </p>
                <button type="submit" name="add_coin">Ajouter !</button>
            
        </div>
    </div>
</body>

</html>