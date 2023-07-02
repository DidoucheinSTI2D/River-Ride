<?php
    session_start();
    if (!isset($_SESSION['id_Utilisateur'])){
        header('location: connect.php?error=notconnected');
        exit;
    }
    $pseudo = $_SESSION['Pseudo'];
?>

<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - Profil</title>
    <link rel="stylesheet" href="./style.css">
    <link rel="stylesheet" href="./component/avatar.css">
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
                <p style="color: red;">
                    <?php
                    if(isset($_GET['error']) && $_GET['error'] ==  "notadmin"){
                        echo "Vous n'avez pas les permissions requises pour accéder à cette page 😡";
                    }
                    ?>
                </p>
                <div class="tab-pane fade show active">
                    <div class="text-center mb-3">
                        <h3> <?php echo $_SESSION['Pseudo']?></h3>
                        <h5> <?php echo "Votre Email : " . $_SESSION['Email']?></h5>
                        <button class="btn btn-primary btn-block"> Modifier les informations </button>
                        <a href="avatar.php"><button class="btn btn-primary btn-block"> Modifier l'avatar </button></a>
                        <a href="disconnect.php"><button class="btn btn-danger btn-block">Se déconnecter</button></a>
                        <div class="changeTheme"><button class="btn btn-dark btn-block">Basculer le mode sombre</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<footer>
    <?php include "./component/footer.php"; ?>
</footer>

<script>
    const switchThemeBtn = document.querySelector('.changeTheme button');
    const body = document.body;
    let isDarkMode = false;

    switchThemeBtn.addEventListener('click', () => {
        isDarkMode = !isDarkMode;
        if (isDarkMode) {
            body.classList.add('dark');
        } else {
            body.classList.remove('dark');
        }
    });
</script>

</body>
</html>