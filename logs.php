<?php
require "./BDD/config.php";
$logFilePath = "logs.txt";
touch($logFilePath); // Crée le fichier s'il n'existe pas

$logContent = file_get_contents($logFilePath); // Récupère le contenu du fichier de logs

$logMessage = ""; //Création de la variable qui contiendra le message de log
$logMessage .= date('Y-m-d H:i:s') . " | "; //Ajout de la date et de l'heure au message de log
$logMessage .= $_SERVER['REMOTE_ADDR'] . " | "; //Ajout de l'adresse IP au message de log
$logMessage .= $_SERVER['PHP_SELF'] . "\n"; //Ajout du chemin du fichier au message de log

$logMessage .= $logContent; // Concaténation du contenu du fichier de logs avec le message de log

$logFile = fopen($logFilePath, "w") or die("Impossible d'ouvrir le fichier de logs."); // Ouverture du fichier de logs en mode écriture

if ($logFile) { // Si les fichiers ont bien été ouverts
    fwrite($logFile, $logMessage); // Ecriture du message de log dans le fichier de logs
    fclose($logFile); // Fermeture du fichier de logs
} else { // Si les fichiers n'ont pas été ouverts
    die("Impossible d'ouvrir les fichiers en mode écriture."); // Arrêt du script
}
?>