<?php
// Répertoire de destination des parties d'image
$cheminDestination = "../component/";

// Parcourir chaque partie d'image envoyée
for ($i = 1; $i <= 9; $i++) {
    $partieNom = $i;
    $partieFichier = $_FILES["partie" . $partieNom]["tmp_name"];

    // Vérifier si le fichier est une image
    if (getimagesize($partieFichier) !== false) {
        // Déplacer le fichier vers le répertoire de destination avec le nom approprié
        move_uploaded_file($partieFichier, $cheminDestination . $partieNom . ".jpg");
    } else {
        http_response_code(400);
        echo "Erreur lors du téléchargement de la partie " . $partieNom . ".";
        exit;
    }
}

// Répondre avec un statut 200 pour indiquer que tout s'est bien passé
http_response_code(200);
?>