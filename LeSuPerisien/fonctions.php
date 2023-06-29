<?php
//Fonction pour récupèrer tous les journaux
function getJournals()
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT id_Journal, Titre, date_création FROM journal ORDER BY date_création DESC');
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
    $req -> closeCursor();
}
//Fonction pour récupèrer un journal
function getJournal($id_Journal)
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT * FROM journal WHERE id_Journal = ?');
    $req->execute(array($id_Journal));
    if($req->rowCount() == 1)
    {
       $data= $req->fetch(PDO::FETCH_OBJ);
       return $data;
    }
}
//Fonction pour ajouter un commentaire à la base de données
function addComment($id_Journal, $author, $comment)
{
    require ('BDD/config.php');
    $req = $bdd->prepare('SELECT Pseudo FROM utilisateur WHERE id_Utilisateur = ?');
    $req = $bdd->prepare('INSERT INTO commentaires (Journal_id_Journal,Pseudo,Contenu, Date) VALUES (?, ?, ?, NOW())');
    $req->execute(array($id_Journal, $author, $comment));    
    $req->closeCursor();
}
//Fonction pour récupèrer les commentaires d'un article
function getComments($id_Journal)
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT * FROM commentaires WHERE Journal_id_Journal = ?');
    $req->execute(array($id_Journal));
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    $req -> closeCursor();
    return $data;
}

function getTopics()
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT id_Topic, titre, date_création FROM topic ORDER BY date_création DESC');
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    $req -> closeCursor();
    return $data;
}

//Fonction pour récupèrer un topic
function getTopic($id_Topic)
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT * FROM topic WHERE id_Topic = ? ');
    $req->execute(array($id_Topic));
    if($req->rowCount() == 1)
    {
       $data= $req->fetch(PDO::FETCH_OBJ);
       return $data;
    }
}

function addCommentTopic($id_Topic, $pseudo, $comment,$idUser)
{
    require ('BDD/config.php');
    $req = $bdd->prepare('INSERT INTO commentaires (Topic_id_Topic,Pseudo,Contenu, Date, Utilisateur_id_Utilisateur) VALUES (?, ?, ?, NOW(), ?)');
    $req->execute(array($id_Topic, $pseudo, $comment, $idUser));  
    $req->closeCursor();
}
    
//Fonction pour récupèrer les commentaires d'un topic
function getCommentsTopic($id_Topic)
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT * FROM commentaires WHERE Topic_id_Topic = ?');
    $req->execute(array($id_Topic));
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
    $req->closeCursor();
}

function deleteComment($commentId) 
{
    require('BDD/config.php');
    // Préparez la requête de suppression
    $req = $bdd->prepare('DELETE FROM commentaires WHERE id_Commentaires = ? ');
    $req->execute(array($commentId));
    $req->closeCursor(); 
        
}


function getPseudo () {

    require('BDD/config.php');
    if (isset($_SESSION['id_Utilisateur'])) {
        $idUtilisateur = $_SESSION['id_Utilisateur'];

        $req = $bdd->prepare('SELECT Pseudo FROM utilisateur WHERE id_Utilisateur = ?');
        $req->execute([$idUtilisateur]);
        $resultat = $req->fetch();

        if ($resultat) {
            return $resultat['Pseudo'];
        }
    }

    return null;
}

function updateTopic ($id_Topic, $new_title, $new_content){
    require('BDD/config.php');
    $req = $bdd->prepare('UPDATE topic SET titre = ? , contenu = ? WHERE id_Topic = ?');
    $req->execute(array($new_title, $new_content, $id_Topic));
    $req->closeCursor();
}

function createTopic($title, $content, $idUser){
    require('BDD/config.php');
    $req = $bdd->prepare('INSERT INTO topic (titre, contenu, Utilisateur_id_Utilisateur, date_création) VALUES ( ?, ?, ?, NOW() )');
    $req->execute(array($title, $content, $idUser));
    $id_Topic = $bdd->lastInsertId();
    $req->closeCursor();

    return $id_Topic;

}



function modificateTopic($id_Topic, $new_title)
{
    require('../../BDD/config.php');
    $req = $bdd->prepare('UPDATE topic SET titre = ? WHERE id_Topic = ?');
    $req->execute(array($new_title, $id_Topic));
    $req->closeCursor();
}
