<?php
session_start();
require "../../BDD/config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rond = $_POST['rond'];
    $yeux = $_POST['yeux'];
    $nez = $_POST['nez'];
    $sourire = $_POST['sourire'];

    $pseudo = $_SESSION['Pseudo'];

    $sqlUpdateAvatar = "UPDATE utilisateur SET rond = :rond, yeux = :yeux, nez = :nez, sourire = :sourire WHERE pseudo = :pseudo";
    $stmtUpdateAvatar = $bdd->prepare($sqlUpdateAvatar);
    $stmtUpdateAvatar->bindParam(':rond', $rond);
    $stmtUpdateAvatar->bindParam(':yeux', $yeux);
    $stmtUpdateAvatar->bindParam(':nez', $nez);
    $stmtUpdateAvatar->bindParam(':sourire', $sourire);
    $stmtUpdateAvatar->bindParam(':pseudo', $pseudo);

    if ($stmtUpdateAvatar->execute()) {
        // Succès de la mise à jour
        http_response_code(200); // Réponse HTTP 200 OK
    } else {
        // Erreur lors de la mise à jour
        http_response_code(500); // Réponse HTTP 500 Internal Server Error
    }
}

?>