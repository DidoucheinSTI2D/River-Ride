<?php
require '../BDD/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $coursId = $_POST['cours_id'];
    $reponse = $_POST['reponse'];

    $query = $bdd->prepare("SELECT Reponse FROM quizz WHERE LearnTOWin_Cours_idLearnToWin_Cours = :cours_id");
    $query->bindParam(':cours_id', $coursId);
    $query->execute();
    $row = $query->fetch(PDO::FETCH_ASSOC);

    if ($row && $reponse === $row['Reponse']) {
        $userId = $_SESSION['id_Utilisateur'];

        $updateQuery = $bdd->prepare("INSERT INTO utilisateur_has_token (Utilisateur_Id_Utilisateur, Token_id_Token, nombre) VALUES (:user_id, 1, 1) ON DUPLICATE KEY UPDATE nombre = nombre + 1");
        $updateQuery->bindParam(':user_id', $userId);
        $updateQuery->execute();

        $resultat = "bonne réponse ! :)";
    } else {
        $resultat = "mauvais réponse ! :(";
    }
} else {
    echo "Erreur : Méthode de requête non valide.";
}
?>