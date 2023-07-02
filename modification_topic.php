<?php
session_start();
require_once('./LeSuPerisien/fonctions.php');
if (!isset($_GET['id_Topic']) OR !is_numeric($_GET['id_Topic'])) 
    header('Location: index.php');
else
{
    // Vérifier si l'utilisateur est connecté
    $isUserLoggedIn = false; // Supposons que l'utilisateur n'est pas connecté par défaut

    if (isset($_SESSION['id_Utilisateur'])) {
        $isUserLoggedIn = true;
    }
    
    $pseudo = getPseudo();
    $idUser = $_SESSION['id_Utilisateur'];
    extract($_GET);
    $id_Topic = strip_tags($id_Topic);

    if (isset($_POST['edit_topic'])) {
        // Ajoutez ici la logique pour modifier le topic
        // Assurez-vous de valider et sécuriser les données avant de les enregistrer dans la base de données
        $new_title = strip_tags($_POST['new_title']);
        $new_content = strip_tags($_POST['new_content']);

        if (empty($new_title)) {
            $errors[] = 'Entrez un titre pour le topic';
        }

        if (empty($new_content)) {
            $errors[] = 'Entrez le contenu du topic';
        }

        if (count($errors) == 0) {
            // Ajoutez ici la logique pour mettre à jour les informations du topic dans la base de données
            updateTopic($id_Topic, $new_title, $new_content);
            $success = 'Le topic a été modifié avec succès';
        }
    }
}
$Topic = getTopic($id_Topic);

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - modification_topic</title>
</head>
<body>
    <header>
        <?php  
            include "./component/header.php"; 
            require_once('BDD/config.php');
            require_once('LeSuPerisien/fonctions.php');
        ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">
    <h1> Bienvenue sur l'espage de modification de Topic !</h1>
    <?php 
        if (!isset($_SESSION['id_Utilisateur'])){
        header("Location: blog.php");
        exit;
        }
    ?>
    <div class="container py-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
    <?php if ($isUserLoggedIn && $Topic->Utilisateur_id_Utilisateur == $_SESSION['id_Utilisateur']): ?>
        <form action="topic.php?id_Topic=<?= $Topic->id_Topic ?>" method="post">
            <h2>Modifier le topic</h2>
            <p>
                <label for="new_title">Nouveau titre :</label><br>
                <input type="text" name="new_title" id="new_title" value="<?= $Topic->titre ?>">
            </p>
            <p>
                <label for="new_content">Nouveau contenu :</label><br>
                <textarea name="new_content" id="new_content" cols="30" rows="4"><?= $Topic->contenu ?></textarea>
            </p>
            <button type="submit" name="edit_topic">Modifier</button>
        </form>
    <?php endif; ?>

    </div>
    </div>

    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>



