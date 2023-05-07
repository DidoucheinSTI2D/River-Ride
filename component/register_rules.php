<?php 

    session_start();

      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mail = $_POST['email'];
        $pseudo = $_POST['pseudo'];
        $date_naissance = $_POST['date'];
        $mot_de_passe = $_POST['password'];
        $confirmation_pw = $_POST['confirmation_pw'];

        if (empty($mail) and empty($mot_de_passe)){
            echo "<script> alert('Vous ne pouvez pas vous inscrire sans information 😡') </script>";
        } 
        elseif (empty($mail) or empty($mot_de_passe)){
            echo "Il manque un ou plusieurs élement(s) nécessaires à l'inscription. <br>";
        }


        if (!preg_match("/^.{8,}$/", $mot_de_passe)){
            echo "Le mot de passe doit faire au minimum 8 caractères. <br>";
        }
        elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W)(?=.*[0-9]).{8,}$/", $mot_de_passe)) {
            echo "Le mot de passe doit contenir au moins une majuscule, une minuscule, un caractère spécial, et un chiffre en + 8 caractères. (ça fait beaucoup) <br>";
        }

        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            echo "L'e-mail est invalide. <br>";
        }
        
        $servername = "localhost"; // Nom du serveur où se trouve la base de données
        $username = "root"; // Nom d'utilisateur pour accéder à la base de données
        $password = ""; // Mot de passe pour accéder à la base de données
        $dbname = "mastertheweb"; // Nom de la base de données

        // Crée une connexion
        $mysqli = new mysqli($servername, $username, $password, $dbname);

        // Exécution de la requête SQL pour insérer les données dans la table utilisateur
        $sql = "INSERT INTO utilisateur (`e-mail`, `Pseudo`, `date_de_naissance`, `Mot_de_passe`, `Droits`) VALUES ('$mail', '$pseudo', '$date_naissance', '$mot_de_passe', 'user')";
        
        if (mysqli_query($mysqli, $sql)) {
            // Récupération de l'identifiant de l'utilisateur inscrit
            $id_utilisateur = mysqli_insert_id($mysqli);
            $_SESSION['id_utilisateur'] = $id_utilisateur;

        } else {
            echo "Erreur lors de l'insertion des données dans la base de données : " . mysqli_error($mysqli);
        } 
            
        $_SESSION['id_utilisateur'] = $id_utilisateur;

        header('Location: ./index.php');
            exit; 
        
    }  
    





?>