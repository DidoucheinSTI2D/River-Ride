<?php
$logFilePath = "logs.txt";
touch($logFilePath); // Crée le fichier s'il n'existe pas

$logContent = file_get_contents($logFilePath); // Récupère le contenu du fichier de logs
$traitementContent = file_get_contents("./component/traitement.php"); // Récupère le contenu de traitement.php
$disconnectContent = file_get_contents("./disconnect.php"); // Récupère le contenu de disconnect.php

$logMessage = ""; //Création de la variable qui contiendra le message de log
$traitementMessage .= $traitementContent; //Ajout du contenu de traitement.php à la variable
$disconnectMessage .= $disconnectContent; //Ajout du contenu de disconnect.php à la variable
$logMessage .= date('Y-m-d H:i:s') . " | "; //Ajout de la date et de l'heure au message de log
$logMessage .= $_SERVER['REMOTE_ADDR'] . " | "; //Ajout de l'adresse IP au message de log
$logMessage .= $_SERVER['PHP_SELF'] . "\n"; //Ajout du chemin du fichier au message de log

$logMessage .= $logContent; // Concaténation du contenu du fichier de logs avec le message de log

$logFile = fopen($logFilePath, "w") or die("Impossible d'ouvrir le fichier de logs."); // Ouverture du fichier de logs en mode écriture
$traitementFile = fopen("./component/traitement.php", "w"); // Ouverture de traitement.php en mode écriture
$disconnectFile = fopen("./disconnect.php", "w"); // Ouverture de disconnect.php en mode écriture

if ($logFile && $traitementFile && $disconnectFile) { // Si les fichiers ont bien été ouverts
    fwrite($logFile, $logMessage); // Ecriture du message de log dans le fichier de logs
    fwrite($traitementFile, $traitementMessage); // Ecriture du message de traitement.php dans le fichier
    fwrite($disconnectFile, $disconnectMessage); // Ecriture du message de disconnect.php dans le fichier

    fclose($logFile); // Fermeture du fichier de logs
    fclose($traitementFile); // Fermeture de traitement.php
    fclose($disconnectFile); // Fermeture de disconnect.php
} else { // Si les fichiers n'ont pas été ouverts
    die("Impossible d'ouvrir les fichiers en mode écriture."); // Arrêt du script
}
?>