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
    return $data;
    $req->closeCursor();
}

function getTopics()
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT id_Topic, titre, date_création FROM topic ORDER BY date_création DESC');
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
    $req -> closeCursor();
}

//Fonction pour récupèrer un topic
function getTopic($id_Topic)
{
    require('BDD/config.php');
    $req = $bdd->prepare('SELECT * FROM topic WHERE id_Topic = ?');
    $req->execute(array($id_Topic));
    if($req->rowCount() == 1)
    {
       $data= $req->fetch(PDO::FETCH_OBJ);
       return $data;
    }
}

function addCommentTopic($id_Topic, $author, $comment)
{
    require ('BDD/config.php');
    $req = $bdd->prepare('INSERT INTO commentaires (Topic_id_Topic,Pseudo,Contenu, Date) VALUES (?, ?, ?, NOW())');
    $req->execute(array($id_Topic, $author, $comment));    
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
    try {
        $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Préparez la requête de suppression
        $query = "DELETE FROM commentaires WHERE id_commentaire = :commentId";
        $stmt = $db->prepare($query);
        
        // Liez les paramètres
        $stmt->bindParam(':commentId', $commentId, PDO::PARAM_INT);
        
        // Exécutez la requête
        $stmt->execute();
        
        // Fermez la connexion à la base de données
        $db = null;
    } catch (PDOException $e) {
        // Gérez les erreurs de la base de données
        // Par exemple, vous pouvez afficher un message d'erreur ou enregistrer les détails de l'erreur dans un fichier de journal
        echo "Erreur de la base de données : " . $e->getMessage();
        exit;
    }
}