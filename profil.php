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
</head>
<style>
    #avatar-result {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-top: 20px;
        margin-bottom: 20px;
    }

    .avatar-preview {
        width: 100px;
        height: 100px;
        overflow: hidden;
        border: 1px solid #ccc;
        margin-right: 20px;
    }

    .avatar-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
</style>

<body>

<header>
    <?php include "./component/header.php"; ?>
    <?php include "./logs.php"; ?>
    <?php include "./component/avatar/recuperer_avatar.php"; ?>
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
                        <div id="avatar-result">
                            <div class="avatar-preview">

                            </div>
                        </div>
                        <h3> <?php echo $_SESSION['Pseudo']?></h3>
                        <h5> <?php echo "Votre Email : " . $_SESSION['Email']?></h5>
                        <a href="./component/avatar/avatar.php"><button class="btn btn-primary btn-block"> Modifier l'avatar </button></a>
                        <a href="disconnect.php"><button class="btn btn-danger btn-block">Se déconnecter</button></a>
                        <a href="./component/exportpdf.php"><button class="btn btn-primary btn-block">Profil en PDF</button></a>
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

<script src="./component/avatar/avatar.js"></script>
<script>
    previewAvatar('<?php echo $avatar["rond"] ?>','<?php echo $avatar["yeux"] ?>','<?php echo $avatar["nez"] ?>','<?php echo $avatar["sourire"] ?>');
</script>

</body>
