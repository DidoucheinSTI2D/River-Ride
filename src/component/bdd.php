<?php 
try{
    $bdd = new PDO('mysql:host=localhost;dbname=RiverRide', 'root', '');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}