<?php
session_start();
require_once('LeSuPerisien/fonctions.php');
if (!isset($_GET['id_Journal']) OR !is_numeric($_GET['id_Journal'])) 
    header('Location: index.php');
else
{
    // Vérifier si l'utilisateur est connecté
    $isUserLoggedIn = false; // Supposons que l'utilisateur n'est pas connecté par défaut

    if (isset($_SESSION['id_Utilisateur'])) {
        $isUserLoggedIn = true;
        $author = getPseudo();
        $idUser = $_SESSION['id_Utilisateur'];
    }
      
    extract($_GET);
    $id_Journal = strip_tags($id_Journal);


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
            $comment =addComment($id_Journal, $author, $comment);

            $success = 'Votre commentaire a été publié';

            unset($author);
            unset($comment);
        }
            
    }

    $journal = getJournal($id_Journal);
    $comments = getComments($id_Journal);
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $journal->Titre ?></title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">
        <div class="container py-4">
            <div class="p-5 mb-4 bg-body-tertiary rounded-3">
            <div class="content text-center">
            <h1><?= $journal->Titre ?></h1>
                <p><?= $journal->Contenu ?></p>
                <hr />
                <time> <?= $journal->date_création ?> </time>
                </div>
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
                    <h3><?= $comment-> Pseudo?></h3>
                    <time><?= $comment->Date ?> </time>
                    <p> <?= $comment-> Contenu ?> </p>
                <?php endforeach; ?>
            </div>
        </div>

        <?php
        if(!isset($_SESSION['id_Utilisateur'])){
        ?>
        <p> Connectez vous pour écrire un commentaire ! </p>
        <?php
        } else {
        ?>
        <form action="journal.php?id_Journal=<?= $journal->id_Journal ?>" method ="post">
            <p> <label for="comment"> Commentaire : </label> </br>
            <textarea name="comment" id="comment" cols="30" rows="4"></textarea></p>
            <button type="submit">Envoyer</button>
        </form>
        <?php
        }
        ?>
        
    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>

