<?php
session_start();
if (!isset($_GET['id_Topic']) OR !is_numeric($_GET['id_Topic'])) 
    header('Location: index.php');
else
{
    extract($_GET);
    $id_Topic = strip_tags($id_Topic);

    require_once('./LeSuPerisien/fonctions.php');
    if (!empty($_POST))
    {
        extract($_POST);
        $errors = array();

        $author = strip_tags($author);
        $comment = strip_tags($comment);

        if(empty($author))
            array_push($errors, 'Entrez un pseudo');
        
        if(empty($comment))
            array_push($errors, 'Entrez un commentaire');

        if (count($errors) == 0)
        {
            $comment =addCommentTopic($id_Topic, $author, $comment);

            $success = 'Votre commentaire a été publié';

            unset($author);
            unset($comment);
        }
        elseif (isset($_POST['delete_comment']) && isset($_POST['delete_comment_id'])) {
            $delete_comment_id = $_POST['delete_comment_id'];
            
            // Ajoutez ici la logique pour supprimer le commentaire
            deleteComment($delete_comment_id);
            
            // Redirection vers la même page pour actualiser les commentaires
            header("Location: topic.php?id_Topic=$id_Topic");
            exit;
        }elseif (isset($_POST['edit_topic'])) {
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
    $comments = getCommentsTopic($id_Topic);

    // Vérifier si l'utilisateur est connecté
    $isUserLoggedIn = false; // Supposons que l'utilisateur n'est pas connecté par défaut

    // Ajoutez ici votre logique pour vérifier si l'utilisateur est connecté
    // Vous pouvez utiliser des sessions, des cookies ou toute autre méthode d'authentification

    if (isset($_SESSION['id_Utilisateur'])) {
        $isUserLoggedIn = true;
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $Topic->titre ?></title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
    </header>
    <main class="container">
        <div class="container py-4">
            <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                <h1><?= $Topic->titre ?></h1>
                <p><?= $Topic->contenu ?></p>
                <hr />
                <time> <?= $Topic->date_création ?> </time>
            </div>
        </div>

        <?php 
        if(isset($success))
            echo $success;

        if(!empty($errors)):?>
            <?php foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="container py-4">
            <h2> Commentaire(s) : </h2>
            <div class="p-5 mb-4 bg-body-tertiary rounded-3">
                <?php foreach($comments as $comment): ?>
                    <h3><?= $comment->Pseudo ?></h3>
                    <time><?= $comment->Date ?></time>
                    <p><?= $comment->Contenu ?></p>

                    <?php if ($isUserLoggedIn && $comment->Utilisateur_id_Utilisateur == $_SESSION['id_Utilisateur']): ?>
                        <form action="topic.php?id_Topic=<?= $Topic->id_Topic ?>" method="post">
                            <input type="hidden" name="delete_comment_id" value="<?= $comment->id_commentaire ?>">
                            <button type="submit" name="delete_comment">Supprimer</button>
                        </form>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>

        <form action="topic.php?id_Topic=<?= $Topic->id_Topic ?>" method="post">
            <?php if ($isUserLoggedIn): ?>
                <!-- Afficher le formulaire de commentaire uniquement si l'utilisateur est connecté -->
                <p>
                    <label for="author">Pseudo :</label><br/>
                    <input type="text" name="author" id="author" value="<?php if (isset($author)) echo $author ?>" />
                </p>
                <p>
                    <label for="comment">Commentaire :</label><br/>
                    <textarea name="comment" id="comment" cols="30" rows="4"><?php if (isset($comment)) echo $comment ?></textarea>
                </p>
                <button type="submit">Envoyer</button>
            <?php else: ?>
                <!-- Afficher un message invitant l'utilisateur à se connecter ou s'inscrire -->
                <p>Veuillez vous connecter pour laisser un commentaire.</p>
            <?php endif; ?>
        </form>
    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>
