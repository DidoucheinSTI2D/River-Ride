<?php
session_start();
require "../../BDD/config.php";
require "../../LeSuPerisien/fonctions.php";

// Récupérer l'ID du journal à modifier
$id_Journal = $_GET['id_Journal'];

// Récupérer les informations du journal à partir de la base de données
$req = $bdd->prepare('SELECT * FROM journal WHERE id_Journal = ?');
$req->execute([$id_Journal]);
$journal = $req->fetch(PDO::FETCH_ASSOC);
$req->closeCursor();

if (!$journal) {
    echo "Journal introuvable.";
    exit;
}

// Vérifier si le formulaire de modification a été soumis
if (isset($_POST['modifier'])) {
    // Récupérer les nouvelles valeurs des champs du formulaire
    $new_title = $_POST['new_title'];
    $new_content = $_POST['new_content'];

    // Effectuer les modifications dans la base de données
    modificateJournal($id_Journal, $new_title, $new_content);
    // ...

    // Redirection vers LeSuPerisien.php avec le message de succès
    header("Location: ../LeSuPerisien.php?message=success");
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
                <li><a href="../topic.php">Topics</a></li>
                <li><a href="../LeSuPerisien.php">Topics</a></li>
                <li><a href="../comment.php">Commentaires</a></li>
                <li><a href="../alarm.php">Signalements</a></li>
                <li><a href="../contact.php">Contact</a></li>
                <li><a href="../settings.php">Paramètres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h3>Modifier le journal</h3>
            <form method="POST">
                <div class="form-group">
                    <p>
                        <label for="new_title">Titre :</label><br>
                        <input type="text" class="form-control" name="new_title" value="<?= $journal['Titre'] ?>" required>
                    </p>
                    <p>
                        <label for="new_content">Contenu :</label><br>
                        <textarea class="form-control" name="new_content" required><?= $journal['Contenu'] ?></textarea>
                    </p>
                </div>
                <button type="submit" name="modifier" class="btn btn-primary">Modifier</button>
            </form>
        </div>
    </div>
</body>

</html>
