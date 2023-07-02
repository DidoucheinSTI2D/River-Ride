<?php
require './BDD/config.php';

// Récupérer les cours
$query = $bdd->prepare("SELECT idLearnToWin_Cours, contenu, Utilisateur_id_Utilisateur FROM learntowin_cours");
$query->execute();
$cours = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - Connexion</title>
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
                <h1>Cours Learn2Win</h1>

                <?php foreach ($cours as $coursItem) { ?>
                    <div class="cours">
                        <h2>Cours ID: <?php echo $coursItem['idLearnToWin_Cours']; ?></h2>
                        <p><?php echo $coursItem['contenu']; ?></p>
                        <p>Admin ID: <?php echo $coursItem['Utilisateur_id_Utilisateur']; ?></p>

                        <form action="./component/resultat_quiz.php" method="post">
                            <input type="hidden" name="cours_id" value="<?php echo $coursItem['idLearnToWin_Cours']; ?>">
                            <label for="reponse">Réponse au quiz :</label>
                            <input type="text" name="reponse" id="reponse" required>
                            <input type="submit" value="Soumettre">
                        </form>
                    </div>
                <?php } ?>


            </div>
        </div>
    </div>
</main>

<footer>
    <?php include "./component/footer.php"; ?>
</footer>

</body>

</html>
