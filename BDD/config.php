<?php
// Informations de connexion à la base de données
$host = 'localhost';
$db = 'MasterTheWeb';
$user = 'root';
$password = '';

try {
    // Connexion à la base de données avec PDO
    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $password);
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Erreur de bdd: ' . $e->getMessage());
}
?>