<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LeSuperCoin - Votre Compte</title>
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
    </header>

    <main style="margin-top: 7rem;">
        <div class="container">
            <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto">
                <div class="tab-content">
                    <div class="tab-pane fade show active">
                        <form method="post" action="./backoffice/verif.php">
                            <div class="text-center mb-3">
                                <p>Se connecter :</p>
                                <!-- Email pour se connecter -->
                                <div class="form-outline mb-4">
                                    <input type="email" name="e-mail" class="form-control" placeholder="Votre email" required/>
                                </div>
                                <!-- Password input -->
                                <div class="form-outline mb-4">
                                    <input type="password" name="Mot_de_passe" class="form-control" placeholder="Mot de passe" required/>
                                </div>
                                <!-- 2 column grid layout -->
                                <div class="row mb-4">
                                    <div class="col-md-6 d-flex justify-content-center">
                                        <!-- Checkbox -->
                                        <div class="form-check mb-3 mb-md-0">
                                            <a href="./forgotpw.php">Mot de passe oublié</a>
                                        </div>
                                    </div>
                                    <div class="col-md-6 d-flex justify-content-center">
                                        <a href="./ariane_register.php">S'inscrire !</a>
                                    </div>
                                </div>
                                <!-- Submit button -->
                                <button type="submit" class="btn btn-primary btn-block mb-4">Se connecter</button>
                                <?php
                                if (isset($_SESSION['error_message'])) {
                                    echo "<p style='color: red;'>{$_SESSION['error_message']}</p>";
                                    unset($_SESSION['error_message']);
                                }
                                ?>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>

</body>
</html>
