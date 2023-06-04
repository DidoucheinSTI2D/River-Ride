<?php
//Fonction pour récupèrer tous les journaux
function getJournals()
{
    require('./connect_bdd.php');
    $req = $bdd->prepare('SELECT id_Journal, Titre, date_création FROM journal ORDER BY date_création DESC');
    $req->execute();
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
    $req -> closeCursor();
}
//Fonction pour récupèrer un journal
function getJournal($id_Journal)
{
    require('./connect_bdd.php');
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
    require ('./connect_bdd.php');
    $req = $bdd->prepare('INSERT INTO commentaires (Journal_id_Journal,Pseudo,Contenu, Date) VALUES (?, ?, ?, NOW())');
    $req->execute(array($id_Journal, $author, $comment));    
    $req->closeCursor();
}
//Fonction pour récupèrer les commentaires d'un article
function getComments($id_Journal)
{
    require('./connect_bdd.php');
    $req = $bdd->prepare('SELECT * FROM commentaires WHERE Journal_id_Journal = ?');
    $req->execute(array($id_Journal));
    $data = $req->fetchAll(PDO::FETCH_OBJ);
    return $data;
    $req->closeCursor();
}