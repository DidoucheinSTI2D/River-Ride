<?php
include("BDD/config.php");

if (isset($_POST['title'])) {
    $title = $_POST['title'];

    $req = $bdd->prepare("SELECT * FROM topic WHERE titre LIKE :title");
    $req->bindValue(':title', '%' . $title . '%', PDO::PARAM_STR);
    $req->execute(); 
    $data = '';
    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        $data .= "<tr><td>" . $row['id_Topic'] . "</td><td>" . $row['titre'] . "</td><td>" . $row['Utilisateur_id_Utilisateur'] . "</td><td>Topic</td></tr>";
    }
    $req = $bdd->prepare('SELECT * FROM journal where Titre LIKE :title');
    $req->bindValue(':title', '%' . $title . '%', PDO::PARAM_STR);
    $req->execute(); 
    while ($row = $req->fetch(PDO::FETCH_ASSOC)) {
        $data .= "<tr><td>" . $row['id_Journal'] . "</td><td>" . $row['Titre'] . "</td><td>" . $row['Rédacteur'] . "</td><td>Journal</td></tr>";
    }
    
    echo $data;
}
?>
