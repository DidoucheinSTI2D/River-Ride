<?php
session_start();
require "../../BDD/config.php";
require "../../LeSuPerisien/fonctions.php";

// Récupérer l'ID du coin à modifier
$id_Coin = $_GET['id_Coin'];

// Récupérer les informations du coin à partir de la base de données
$req = $bdd->prepare('SELECT * FROM coindumoment WHERE id_Coin = ?');
$req->execute([$id_Coin]);
$coin = $req->fetch(PDO::FETCH_ASSOC);
$req->closeCursor();

if (!$coin) {
    echo "coin introuvable.";
    exit;
}

// Vérifier si le formulaire de modification a été soumis
if (isset($_POST['modifier'])) {
    // Récupérer les nouvelles valeurs des champs du formulaire
    $new_name = $_POST['new_name'];
    $new_price = $_POST['new_price'];
    $new_potential = $_POST['new_potential'];
    $new_comment = $_POST['new_comment'];
    $new_link = $_POST['new_link'];

    // Effectuer les modifications dans la base de données
    modificateCoin ($new_name, $new_price, $new_potential, $new_comment, $new_link, $id_Coin);
    // ...

    // Redirection vers LeSuPerisien.php avec le message de succès
    header("Location: ../coindumoment.php?message=success");
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
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <?php
    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['id_Utilisateur'])) {
        header("Location: ../../connect.php");
        exit();
    }
    ?>
</head>

<body>
    <div class="header d-flex">
        <img src="../../img/badge/staffbadge.png" alt="logo SuperCoin" id="logo" />
        <div class="user-info">
            <img src="../../img/picture/pp.png" alt="Photo de profil" class="profile-picture" id="pp" />
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
                <li><a href="../../connect.php">Accueil</a></li>
                <li><a href="../backoffice.php">BackOffice</a></li>
                <li><a href="../user.php">Utilisateurs</a></li>
                <li><a href="../LeSuPerisien.php">LeSuPerisien</a></li>
                <li><a href="../topic.php">Topics</a></li>
                <li><a href="../coindumoment.php">Coin du moment</a></li>
                <li><a href="../comment.php">Commentaires</a></li>
                <li><a href="../alarm.php">Signalements</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <li><a href="../settings.php">Paramètres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h3>Modifier le coin</h3>
            <form method="POST">
                <div class="form-group">
                    <p>
                        <label for="new_name">Nom :</label><br>
                        <input type="text" class="form-control" name="new_name" value="<?= $coin['nom'] ?>" required>
                    </p>
                    <p>
                        <label for="new_price">Prix :</label><br>
                        <input type="text" class="form-control" name="new_price" value="<?= $coin['prix'] ?>" required>
                    </p>
                    <p>
                        <label for="new_potential">Potentiel :</label><br>
                        <input type="text" class="form-control" name="new_potential" value="<?= $coin['potentiel'] ?>" required>
                    </p>
                    <p>
                        <label for="new_comment">Commentaire :</label><br>
                        <textarea class="form-control" name="new_comment" required><?= $coin['commentaire'] ?></textarea>
                    </p>
                    <p>
                        <label for="new_link">Lien :</label><br>
                        <input type="text" class="form-control" name="new_link" value="<?= $coin['lien'] ?>" required>
                    </p>
                </div>
                <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
            </form>
        </div>
    </div>
</body>

</html>
