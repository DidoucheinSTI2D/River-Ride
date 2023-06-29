<?php
session_start();
require "../../BDD/config.php";
require "../../LeSuPerisien/fonctions.php";
// Vérifier si l'ID du topic a été spécifié dans l'URL
if (isset($_GET['id_Topic']) && is_numeric($_GET['id_Topic'])) {
    $id_Topic = $_GET['id_Topic'];

    $req = $bdd->prepare('DELETE FROM topic WHERE id_Topic = ? ');
    $req->execute(array($id_Topic));
    $req->closeCursor();

    // Redirection vers la page principale ou une autre page appropriée après la suppression
    header("Location: ../topic.php");
    exit;
} elseif (isset($_GET['id_Commentaires']) && is_numeric($_GET['id_Commentaires'])) {
    $id_Commentaires = $_GET['id_Commentaires'];

    $req = $bdd->prepare('DELETE FROM commentaires WHERE id_Commentaires = ? ');
    $req->execute(array($id_Commentaires));
    $req->closeCursor();

    // Redirection vers la page principale ou une autre page appropriée après la suppression
    header("Location: ../comment.php");
    exit;
}else {
    // Redirection vers la page principale ou une autre page appropriée si l'ID du topic n'est pas spécifié ou n'est pas valide
    header("Location: ../../index.php");
    exit;
}
?>
