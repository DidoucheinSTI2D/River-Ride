<?php
session_start();
require "./component/bdd.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['delete_reservation'])) {
    try {
        $reservationId = $_POST['reservation_id'];

        $deleteQuery = "DELETE FROM reservations WHERE id_reservation = :reservation_id AND id_utilisateur = :id_utilisateur";
        $deleteStatement = $bdd->prepare($deleteQuery);
        $deleteStatement->bindParam(':reservation_id', $reservationId, PDO::PARAM_INT);
        $deleteStatement->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
        $deleteStatement->execute();

        header("Location: paiement.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur PDO :" . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['validate_reservation'])) {
    try {
        $updatepack = "UPDATE reservation_pack SET validation = 1 WHERE id_utilisateur = :id_utilisateur AND validation = 0";
        $updatepackStatement = $bdd->prepare($updatepack);
        $updatepackStatement->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
        $updatepackStatement->execute();
        
        $updateQuery = "UPDATE reservations SET validation = 1 WHERE id_utilisateur = :id_utilisateur AND validation = 0";
        $updateStatement = $bdd->prepare($updateQuery);
        $updateStatement->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
        $updateStatement->execute();

        $updateClientS = "UPDATE utilisateurs SET client = 1 WHERE id_utilisateur = :id_utilisateur";
        $updateClient = $bdd->prepare($updateClientS);
        $updateClient->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
        $updateClient->execute();


        $email = $_SESSION['email'];	
        $prenom = $_SESSION['prenom'];


        require 'PHPMailer/src/Exception.php';
        require 'PHPMailer/src/PHPMailer.php';
        require 'PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com'; 
        $mail->SMTPAuth   = true; 
        $mail->Username   = 'riveride.pro@gmail.com'; 
        $mail->Password   = 'yurscogsfjfmjgfv'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
        $mail->Port       = 465; 

        $mail->setFrom('riveride.pro@gmail.com', 'River Ride');
        $mail->addAddress($email, $prenom);

        $mail->isHTML(true);
        $mail->Subject = 'On se capte sur le Loire !';
        $message = "Cher {$prenom},<br><br>";
        $message .= "Nous sommes ravis de vous annoncer que votre commande a été validée.<br><br>";
        $message .= "<br>Nous sommes impatients de vous accueillir sur le Loire. Si vous avez des questions, n'hésitez pas à nous contacter.<br><br>";
        $message .= "Cordialement,<br>L'équipe River Ride";
        $mail->Body = $message;

        $mail->send();


        header("Location: ./reservation/confirmation.php");
        exit();
    } catch (PDOException $e) {
        die("Erreur PDO :" . $e->getMessage());
    }
}
?> 



<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <title>Réservation - Paiement</title>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-primary">
            <div class="container">
                <a class="navbar-brand" href="#">River Ride</a>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item active">
                            <a class="nav-link" href="reservation.php">Réserver</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="profil.php">Profil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="deconnexion.php">Se déconnecter</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="paiement.php">Panier</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>


    <main style="margin-top: 7rem;">
        <div class="container">
            <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto" style="text-align: center;">
                <h2>Votre Commande</h2>
                <?php
                $queryCommande = "SELECT r.id_reservation, l.nom, l.prix, r.date_debut, r.date_fin FROM reservations r
                                JOIN logements l ON r.id_logement = l.id_logement
                                WHERE r.id_utilisateur = :id_utilisateur AND r.validation = 0";
                $commandeStatement = $bdd->prepare($queryCommande);
                $commandeStatement->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
                $commandeStatement->execute();

                if ($commandeStatement->rowCount() > 0) {
                    echo "<ul>";
                    while ($rowCommande = $commandeStatement->fetch(PDO::FETCH_ASSOC)) {
                        echo "<li>{$rowCommande['nom']} - {$rowCommande['prix']} €</li>";
                        echo "<p>Date de début : {$rowCommande['date_debut']}</p>";
                        echo "<p>Date de fin : {$rowCommande['date_fin']}</p>";
                        echo "<p>Nombre de personnes : {$_SESSION['nombre_de_personnes']}</p>";
                        echo "<form action='' method='POST'>";
                        echo "<input type='hidden' name='reservation_id' value='{$rowCommande['id_reservation']}'>";
                        echo "<button type='submit' name='delete_reservation' class='btn btn-primary btn-block mb-4'>Supprimer cette réservation</button>";
                        echo "</form>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>Aucune réservation en cours.</p>";
                }
                ?>


            
                <div>
                    <h2>Vos Packs</h2>
                    <?php
                    $queryCommandePack = "SELECT rp.id_reservation_pack, p.nom, p.prix, rp.date_reservation FROM reservation_pack rp
                                        JOIN packs p ON rp.id_pack = p.id_pack
                                        WHERE rp.id_utilisateur = :id_utilisateur AND rp.validation = 0";
                    $commandePackStatement = $bdd->prepare($queryCommandePack);
                    $commandePackStatement->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
                    $commandePackStatement->execute();

                    if ($commandePackStatement->rowCount() > 0) {
                        echo "<ul>";
                        while ($rowCommandePack = $commandePackStatement->fetch(PDO::FETCH_ASSOC)) {
                            echo "<li>{$rowCommandePack['nom']} - {$rowCommandePack['prix']} €</li>";
                            echo "<p>Date de réservation : {$rowCommandePack['date_reservation']}</p>";
                            echo "<form action='' method='POST'>";
                            echo "<input type='hidden' name='reservation_pack_id' value='{$rowCommandePack['id_reservation_pack']}'>";
                            echo "<button type='submit' name='delete_reservation_pack' class='btn btn-primary btn-block mb-4'>Supprimer ce pack</button>";
                            echo "</form>";
                        }
                        echo "</ul>";
                    } else {
                        echo "<p>Aucun pack réservé.</p>";
                    }
                    ?>
                </div>
    
            
                <div>
                    <h2>Total </h2>
                    <?php
                    $queryTotalLogements = "SELECT SUM(l.prix) AS total FROM reservations r JOIN logements l ON r.id_logement = l.id_logement WHERE r.id_utilisateur = :id_utilisateur AND r.validation = 0";
                    $totalStatementLogements = $bdd->prepare($queryTotalLogements);
                    $totalStatementLogements->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
                    $totalStatementLogements->execute();

                    $totalPriceLogements = 0;
                    if ($rowTotalLogements = $totalStatementLogements->fetch(PDO::FETCH_ASSOC)) {
                        $totalPriceLogements = $rowTotalLogements['total'];
                    }

                    $queryTotalPacks = "SELECT SUM(p.prix) AS total FROM reservation_pack rp JOIN packs p ON rp.id_pack = p.id_pack WHERE rp.id_utilisateur = :id_utilisateur AND rp.validation = 0";
                    $totalStatementPacks = $bdd->prepare($queryTotalPacks);
                    $totalStatementPacks->bindParam(':id_utilisateur', $_SESSION['id'], PDO::PARAM_INT);
                    $totalStatementPacks->execute();

                    $totalPricePacks = 0;
                    if ($rowTotalPacks = $totalStatementPacks->fetch(PDO::FETCH_ASSOC)) {
                        $totalPricePacks = $rowTotalPacks['total'];
                    }

                    $totalPrice = $totalPriceLogements + $totalPricePacks;
                    
                    echo "<p>Total avant Réduction : {$totalPrice} €</p>";
                    ?>

                    <form action="" method="POST">
                        <label for="code_promo">Code Promo :</label>
                        <input type="text" id="code_promo" name="code_promo">
                        <button type="submit" class='btn btn-primary btn-block mb-4'>Vérifier</button>
                    </form>

                    <?php
                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['code_promo'])) {
                        $reduction = 0;
                        $codePromo = htmlspecialchars($_POST['code_promo'], ENT_QUOTES, 'UTF-8');

                        if (!empty($codePromo)) {
                            $queryPromo = "SELECT id, reduction, date_debut, date_fin, premier_usage FROM promotion WHERE code = :code";
                            $promoStatement = $bdd->prepare($queryPromo);
                            $promoStatement->bindParam(':code', $codePromo, PDO::PARAM_STR);
                            $promoStatement->execute();

                            $promoRow = $promoStatement->fetch(PDO::FETCH_ASSOC);

                            if ($promoRow) {
                                $currentDate = date('Y-m-d');
                                $promoStartDate = $promoRow['date_debut'];
                                $promoEndDate = $promoRow['date_fin'];

                                if ($currentDate >= $promoStartDate && $currentDate <= $promoEndDate) {
                                    $reduction = $promoRow['reduction'];
                                } else {
                                    echo "<p>Le code promo n'est pas encore valide ou a expiré.</p>";
                                }
                            } else {
                                echo "<p>Le code promo saisi n'est pas valide.</p>";
                            }

                            if ($promoRow && $_SESSION['client'] !== 0 && $promoRow['premier_usage'] === 1) {
                                $reduction = 0;
                                echo "<p>Ce code est valable uniquement lors de la première réservation.</p>";
                            }

                            $totalPriceAfterReduction = $totalPrice * ((100 - $reduction) / 100);

                            if ($reduction > 0) {
                                echo "<p>Réduction appliquée : {$reduction}%</p>";
                                echo "<p>Total après Réduction : {$totalPriceAfterReduction} €</p>";
                            } else {
                                echo "<p>Aucune réduction appliquée.</p>";
                            }
                        }
                    }

                    ?>
                </div>



                <div>
                <form action="" method="POST" onsubmit="return confirm(\'Attention, une fois une commande valider, impossible de retourner en arrière. êtes-vous sûre?\');">
                    <button type="submit" name="validate_reservation" class="btn btn-primary btn-block mb-4">Valider la commande</button>
                </form>
            </div>
        </div>
    </main>
        <br><br><br><br><br>



    <footer class="fixed-bottom bg-light py-2">
        <div class="container text-center">
            <p class="m-0">&copy; 2023 - River Ride</p>
        </div>
    </footer>

</body>