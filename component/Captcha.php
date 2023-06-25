<!DOCTYPE html>
<html lang="fr|FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin | Captcha </title>
    <link rel="stylesheet" href="captcha.css">
    <script src="puzzle.js"></script>
</head>

<body>
<h1 style="color: red; display: block;">Bip Boup Bip?</h1>
<div id="board"></div>
<h1>Afin d'accéder au site, veuillez résoudre ce captcha. Une fois résolu, vous serez automatiquement redirigé vers la page d'accueil du site.<br> Vous avez l'image 3 qui est sticky. Pour placer les bonnes images au bon endroit, il vous suffit de cliquer sur l'emplacement de l'image puis l'image correspondante.</h1>

<form method="POST" action="traitement.php" id="captchaForm">
    <input type="hidden" name="email" value="<?php echo $email; ?>">
    <input type="hidden" name="pseudo" value="<?php echo $pseudo; ?>">
    <input type="hidden" name="date_naissance" value="<?php echo $date_naissance; ?>">
    <input type="hidden" name="password" value="<?php echo $password; ?>">
    <input type="submit" value="Enregistrer" id="submitBtn" disabled>
</form>

</body>

</html>
