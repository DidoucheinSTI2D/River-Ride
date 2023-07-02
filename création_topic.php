<?php
    session_start();
    require_once('BDD/config.php');
    require_once('LeSuPerisien/fonctions.php');
    
    // Vérifier si l'utilisateur est connecté
    $isUserLoggedIn = false; // Supposons que l'utilisateur n'est pas connecté par défaut

    if (isset($_SESSION['id_Utilisateur'])) {
        $isUserLoggedIn = true;
    }
    
    if (!$isUserLoggedIn) {
        header("Location: blog.php");
        exit;
    }

    $pseudo = getPseudo();
    $idUser = $_SESSION['id_Utilisateur'];

    if (isset($_POST['create_topic'])) {
        $title = strip_tags($_POST['title']);
        $content = strip_tags($_POST['content']);

        $errors = array();

        if (empty($title)) {
            $errors[] = 'Entrez un titre pour le topic';
        }

        if (empty($content)) {
            $errors[] = 'Entrez le contenu du topic';
        }

        if (count($errors) == 0) {
            // Ajoutez ici la logique pour enregistrer le nouveau topic dans la base de données
            $topicId = createTopic($title, $content, $idUser);

            if ($topicId) {
                // Redirigez vers la page du nouveau topic
                header("Location: topic.php?id_Topic=$topicId");
                exit;
            } else {
                $errors[] = 'Une erreur s\'est produite lors de la création du topic';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - Création de Blog</title>
</head>
<body>
    <header>
        <?php  
            include "./component/header.php"; 
        ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">
    <h1> Bienvenue sur la page de création de Blog !</h1>

    <div class="container py-4">
        <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <h2>Créer un nouveau topic</h2>
            <?php if (!empty($errors)): ?>
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            <?php endif; ?>
            <form action="création_topic.php" method="post">
                <p>
                    <label for="title">Titre :</label><br>
                    <input type="text" name="title" id="title" value="<?= isset($_POST['title']) ? $_POST['title'] : '' ?>">
                </p>
                <p>
                    <label for="content">Contenu :</label><br>
                    <textarea name="content" id="content" cols="30" rows="4"><?= isset($_POST['content']) ? $_POST['content'] : '' ?></textarea>
                </p>
                <button type="submit" name="create_topic">Créer !</button>
            </form>
        </div>
    </div>
    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>
