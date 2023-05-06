<?php 
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $mail = $_POST["mail"];
        $password = $_POST["password"];
        $confirmation_pw = $_POST["confirmation_pw"];

        if (empty($mail) and empty($password) and empty($confirmation_pw)){
            echo "<script> alert('Vous ne pouvez pas vous inscrire sans information 😡') </script>";
        } 
        elseif (empty($mail) or empty($password) or empty($confirmation_pw)){
            echo "Il manque un ou plusieurs élement(s) nécessaires à l'inscription. <br>";
        }


        if ( $password != $confirmation_pw){
            echo "Les mots de passes ne correspondent pas. <br>";
        } 
        elseif ($password == $mail or $confirmation_pw==$mail){
            echo "Un minimum de sérieux : Pas d'email en mot de passe 😂 <br>";
        }
        elseif(!preg_match("/^.{8,}$/", $password)){
            echo "Le mot de passe doit faire au minimum 8 caractères. <br>";
        }
        elseif (!preg_match("/^(?=.*[A-Z])(?=.*[a-z])(?=.*\W)(?=.*[0-9]).{8,}$/", $password)) {
            echo "Le mot de passe doit contenir au moins une majuscule, une minuscule, un caractère spécial, et un chiffre en + 8 caractères. (ça fait beaucoup) <br>";
        }

        elseif (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            echo "L'e-mail est invalide. <br>";
        }

        else{
            header("Location: merci.html");
            exit;
        }

    }  
    

?>