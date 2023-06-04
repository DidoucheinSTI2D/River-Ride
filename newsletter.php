<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription à la newsletter - Le SuperCoin</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header>
        <?php include "./component/header.php"; ?>
    </header>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <?php 
                require './phpmailer/PHPMailer.php';
                require './phpmailer/SMTP.php';
                require './phpmailer/Exception.php';

                use PHPMailer\PHPMailer\PHPMailer;
                use PHPMailer\PHPMailer\SMTP;
                use PHPMailer\PHPMailer\Exception;
                
                // Créer une nouvelle instance de PHPMailer
                $mail = new PHPMailer(true);
                
                try {
                    // Paramètres du serveur SMTP
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'help.lesupercoin@gmail.com';
                    $mail->Password = 'T1K1t@k@';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port = 465;            
                    
                    $username = $_POST['nom'];
                    $usermail = $_POST['email'];
                    // Paramètres du message
                    $mail->setFrom('help.lesupercoin@gmail.com', 'LeSuperCoin');
                    $mail->addAddress($usermail, $username);
                    $mail->isHTML(true);
                    $mail->Subject = 'Newsletter - LeSuperCoin';
                    $mail->Body = "Merci $username pour ton inscription à la SuperNewsletter du SuperCoin !";
                
                    // Envoyer le message
                    $mail->send();
                    echo 'La newsletter a été envoyée avec succès.';
                } catch (Exception $e) {
                    echo 'Une erreur est survenue lors de l\'envoi de la newsletter : ' . $mail->ErrorInfo;
                }
                ?>
                <h2>Inscription à la newsletter</h2>
                <form action="./newsletter.php" method="post">
                    <label for="nom">Nom :</label>
                    <input type="text" id="nom" name="nom" required><br><br>
                    <label for="email">Adresse e-mail :</label>
                    <input type="email" id="email" name="email" required><br><br>
                    <input type="submit" value="S'inscrire">
                </form>
            </div>
        </div>
    </main>
    <footer>
        <?php include "./component/footer.php"; ?>
    </footer>
</body>
</html>