<?php
if (!empty($_POST) && !empty($_POST['search'])) {
    extract($_POST);
    $search = strip_tags($search);

    require '../component/bdd.php';

    $reqr = $bdd->prepare("SELECT * FROM utilisateurs WHERE nom LIKE :search OR prenom LIKE :search OR email LIKE :search ORDER BY id");
    $reqr->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
    $reqr->execute();

    if ($reqr->rowCount() > 0) {
        echo '<table border="1" style="margin: auto; width: 70%;">';
        echo '<tr>';
        echo '<th>Nom</th>';
        echo '<th>Prénom</th>';
        echo '<th>Email</th>';
        echo '<th>Rôle</th>';
        echo '<th>Actions</th>';
        echo '</tr>';

        while ($data = $reqr->fetch(PDO::FETCH_OBJ)) {
            echo '<tr>';
            echo '<form method="post" action="">';
            echo '<td><input type="text" name="nom" value="' . $data->nom . '"></td>';
            echo '<td><input type="hidden" name="id_utilisateur" value="' . $data->id_utilisateur . '"><input type="text" name="prenom" value="' . $data->prenom . '"></td>';
            echo '<td><input type="text" name="email" value="' . $data->email . '"></td>';
            echo '<td><input type="radio" name="role" value="1" ' . ($data->admin == 1 ? 'checked' : '') . '> Admin
                        <input type="radio" name="role" value="0" ' . ($data->admin == 0 ? 'checked' : '') . '> Utilisateur</td>';
            echo '<td><button type="submit" name="modifier">Modifier</button> <button class="btn btn-danger"> <a href="?supprimer=' . $data->id_utilisateur . '">Supprimer</a></button></td>';
            echo '</form>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo '<h3>Aucun resultat</h3>';
    }
} else {
    echo '<h3>Aucun resultat</h3>';
}
?>