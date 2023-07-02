<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - S'inscrire</title>
</head>

<?php
require "./BDD/config.php";

if (isset($_POST['register'])){
        $email = $_POST['email'];
        $stremail = strlen($email);

        // Cette partie va permettre de vérifier si l'email n'est pas déjà utiliser.
        $askEmail = $bdd->prepare("SELECT * FROM Utilisateur WHERE `e-mail` = ?");
        $askEmail->execute(array($email));
        $mailInfo = $askEmail->rowCount();

        if ($stremail > 255) $erreurmail = "Votre email ne doit pas dépasser les 250 caractères";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $erreurmail = "Veuillez indquer un email valide";
        if ($mailInfo != 0) $erreurmail = "Adresse déjà utilisé";

        if(empty($erreurmail)){
            session_start();
            $_SESSION['email'] = $email;
            header("location: ./register_pseudo.php");
            exit();
    }
}
?>

<body>

    <header>
        <?php include "./component/header.php"; ?>
        <?php include "./logs.php"; ?>
    </header>

<main style="margin-top: 7rem;">
  <div class="container">
    <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto">
        <div class="tab-content">
          <form method="POST">
              <div class="tab-pane fade show active">
                  <div class="text-center mb-3">
                      <div id="email">
                    <p>Merci de nous communiquer votre adresse email :</p>
                      <div class="form-outline mb-4">
                         <input type="email" name="email" class="form-control" placeholder="Votre adresse email" required="required" autocomplete="on" />
                        <p style="color: red;"><?php if (isset($erreurmail)) echo $erreurmail ?></p>
                      </div>
                      <div class="form-outline mb-4">
                            <button type="submit" class="btn btn-primary btn-block" name="register">Valider votre adresse email</button>
                      </div>
                    </div>
                </div>
              </div>
          </form>
        </div>
    </div>
  </div>
</main>


    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>



    
</body>
</html>