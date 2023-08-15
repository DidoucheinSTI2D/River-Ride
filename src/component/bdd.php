<?php 
try{
    $bdd = new PDO('mysql:host=localhost;dbname=RiverRide', 'root', '');
} catch (PDOException $e) {
    die('Erreur PDO :' . $e->getMessage());
}
?>