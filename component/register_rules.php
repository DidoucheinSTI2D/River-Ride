<?php 

    session_start();

      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mail = $_POST['email'];
        $pseudo = $_POST['pseudo'];
        $date_naissance = $_POST['date'];
        $mot_de_passe = $_POST['password'];
        $confirmation_pw = $_POST['confirmation_pw'];

        if (empty($mail) and empty($mot_de_passe)){
            $_SESSION['error_message'] = "Vous ne pouvez pas vous inscrire sans information 😡";
        } 
        elseif (empty($mail) or empty($mot_de_passe)){
            $_SESSION['error_message'] = "Il manque un ou plusieurs élement(s) nécessaires à l'inscription.";
        }


        if (!preg_match("/^.{8,}$/", $mot_de_passe)){
            $_SESSION['error_message'] = "Le mot de passe doit faire au minimum 8 caractères. <br>";
        }
        elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W)(?=.*[0-9]).{8,}$/", $mot_de_passe)) {
            $_SESSION['error_message'] = "Le mot de passe doit contenir au moins une majuscule, une minuscule, un caractère spécial, et un chiffre en + 8 caractères. (ça fait beaucoup) <br>";
        }

        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "L'e-mail est invalide. <br>";
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

        // Envoi de l'e-mail de validation
        $to = $mail;
        $subject = "Validation de votre inscription sur LeSuperCoin";
        $message = "Bonjour " . $pseudo . ",\n\nMerci de vous être inscrit sur LeSuperCoin !\n\n" . $id_utilisateur . "&hash=" . md5($mail) . "\n\nCordialement,\nL'équipe de LeSuperCoin";
        $headers = "From: Gorimfanboy2002@gmail.com" . "\r\n" .
                "Reply-To: noreply@example.com" . "\r\n" .
                "X-Mailer: PHP/" . phpversion();

        //vérification si tout est bon
        if (mail($to, $subject, $message, $headers)) {
            echo "Un e-mail de validation a été envoyé à votre adresse e-mail. Veuillez cliquer sur le lien de validation pour activer votre compte.";
        } else {
            echo "Erreur lors de l'envoi de l'e-mail de validation.";
        }

        header('Location: ./Captcha.php');
         exit; 
        
    }  
    





?>