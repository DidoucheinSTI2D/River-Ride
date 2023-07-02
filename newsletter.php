<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription à la newsletter - Le SuperCoin</title>
</head>
<body>
    <header>
        <?php 
        include "./component/header.php";
        ?>
        <?php include "./logs.php"; ?>
    </header>
    <main class="container">
    <h2>Inscription à la newsletter</h2>
    <form action="./php_mail_send/index.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" id="nom" name="nom" required><br><br>

        <label for="email">Adresse e-mail :</label>
        <input type="email" id="email" name="email" required><br><br>

        <input type="submit" value="S'inscrire">
    </form>
    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>