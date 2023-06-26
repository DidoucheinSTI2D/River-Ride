<?php
$pseudo = $_SESSION['Pseudo'];

// Requête pour récupérer les choix de l'utilisateur
$sqlGetAvatar = "SELECT rond, yeux, nez, sourire FROM utilisateur WHERE Pseudo = :pseudo";
$stmtGetAvatar = $bdd->prepare($sqlGetAvatar);
$stmtGetAvatar->bindParam(':pseudo', $pseudo);
$stmtGetAvatar->execute();

$avatar = $stmtGetAvatar->fetch(PDO::FETCH_ASSOC);
?>