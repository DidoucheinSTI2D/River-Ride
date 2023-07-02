<?php
require "./BDD/config.php";
session_start();
if (!isset($_SESSION['email']) || empty($_SESSION['email'])) {
    header("Location: ariane_register.php");
    exit();
}


if (isset($_POST['pseudo_date'])){

    $email = $_SESSION['email'];
    $pseudo = $_POST['pseudo'];
    $date_naissance = $_POST['date'];




    $askPseudo = $bdd->prepare("SELECT * FROM Utilisateur WHERE Pseudo = ?");
    $askPseudo->execute(array($pseudo));
    $pseudoInfo = $askPseudo->fetch();

    // Pour les navigateurs qui ne prennent pas en compte "required"
    if (empty($pseudo)) $erreurpseudo = "Veuillez remplir ce champ";
    if (empty($date_naissance)) $erreurdate = "Veuillez remplir ce champ";

    if ($pseudoInfo != 0 || $pseudo == $email) {
        $erreurpseudo = "Pseudo déjà utilisé ou identique à l'email";
    } else {
        $now = new DateTime();
        $date_naissance = new DateTime($date_naissance);
        $age = $now->diff($date_naissance)->y;

        if ($age < 18) {
            $erreurdate = "Vous devez avoir au moins 18 ans pour vous inscrire";
        } else {
            $_SESSION['pseudo'] = $pseudo;
            $_SESSION['date_naissance'] = $date_naissance->format('Y-m-d');
            header("location: ./register_final.php");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - S'inscrire</title>
</head>

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
                            <div>
                                <p>Choisissez votre pseudo et Entrez votre date de naissance :</p>
                                <div class="form-outline mb-4">
                                    <input type="text" name="pseudo" class="form-control" placeholder="Votre pseudo" required />
                                    <p style="color: red;"><?php if (isset($erreurpseudo)) echo $erreurpseudo ?></p>
                                </div>
                                <div class="form-outline mb-4">
                                    <input type="date" name="date" class="form-control" required />
                                    <p style="color: red;"><?php if (isset($erreurdate)) echo $erreurdate ?></p>
                                </div>
                                <div class="form-outline mb-4">
                                    <button type="submit"" class="btn btn-primary btn-block" name="pseudo_date">Valider votre pseudo et Votre Date de Naissance</button>
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