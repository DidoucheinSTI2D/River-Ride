<?php
// Connexion à la base de donnée, il faut bien penser à changer le username et le password pour le VPS :)
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=MasterTheWeb', 'root', '');
    }  catch(Exception $e)
    {
        die('Erreur de bdd:' . $e->getMessage());
    }
?>