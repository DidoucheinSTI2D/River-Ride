<?php
session_start();

if (!isset($_SESSION['id'])) {
    header('Location: ../connexion.php?error=notconnected');
    exit;
}
if ($_SESSION['admin'] != 1) {
    header('Location: ../main.php?error=notadmin');
    exit;
}

require "../component/bdd.php";

try {
    if (isset($_POST['ajouter'])){
        $datedebut = $_POST['datedebut'];
        $datefin = $_POST['datefin'];
        $pourcentage = $_POST['pourcentage'];
        $code = $_POST['code'];
        $usage = $_POST['usage'];

        $aujourdhui = date("Y-m-d");
        if ($datedebut < $aujourdhui) {
            $error = "La date de début doit être aujourd'hui ou ultérieure.";
        } else {
            $dateMinFin = date("Y-m-d H:i:s", strtotime($datedebut) + 24 * 60 * 60);
            if ($datefin <= $datedebut || $datefin <= $dateMinFin) {
                $error = "La date de fin doit être après la date de début et au moins 24 heures après.";
            }
        }

            if (isset($error)) {
                header('Location: promotion.php?error=' . $error);
                exit;
            } else {
                $sql = "INSERT INTO promotion (date_debut, date_fin, reduction, code, premier_usage) VALUES (?, ?, ?, ?, ?)";
                $stmt = $bdd->prepare($sql);
                $stmt->execute([$datedebut, $datefin, $pourcentage, $code, $usage]);
                header('Location: promotion.php?success=ajout');
                exit;
            }
        } 

    if (isset($_POST['supprimer'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM promotion WHERE id = ?";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([$id]);
        header('Location: promotion.php?success=suppression');
        exit;
    }

        $sql = "SELECT * FROM promotion";
        $stmt = $bdd->prepare($sql);
        $stmt->execute();
        $promotions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr-FR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RiverRide - backoffice</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</head>

<body style="background-color: lightblue;">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="backoffice.php">
                <img src="../img/riverlogo.png" alt="logo" width="40" height="40" class="rounded-circle">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="utilisateur.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3Zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Z" />
                            </svg>
                            Utilisateur
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="logement.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-fill" viewBox="0 0 16 16">
                                <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L8 2.207l6.646 6.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.707 1.5Z" />
                                <path d="m8 3.293 6 6V13.5a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 13.5V9.293l6-6Z" />
                            </svg>
                            Logement
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="promotion.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-percent" viewBox="0 0 16 16">
                                <path d="M13.442 2.558a.625.625 0 0 1 0 .884l-10 10a.625.625 0 1 1-.884-.884l10-10a.625.625 0 0 1 .884 0zM4.5 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5zm7 6a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3zm0 1a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5z" />
                            </svg>
                            promotion
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="pack.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-bar-graph-fill" viewBox="0 0 16 16">
                                <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm-2 11.5v-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm-2.5.5a.5.5 0 0 1-.5-.5v-4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1zm-3 0a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-1z" />
                            </svg>
                            Pack
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a href="#" class="d-flex align-items-center justify-content-center p-3 link-body-emphasis text-decoration-none dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="https://avatars.githubusercontent.com/u/103408502?v=4" alt="mdo" width="24" height="24" class="rounded-circle">
                        </a>
                        <ul class="dropdown-menu text-small shadow">
                            <li><a class="dropdown-item" href="../deconnexion.php">Se déconnecter</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <h1 style="text-align: center;">Gérer les promotions :</h1>
    <p style="color: red;"><?php if (isset($_GET['error'])) {echo $_GET['error'];} ?></p>
    <p style="color: green;"><?php if (isset($_GET['success'])) {if ($_GET['success'] == "ajout") {echo "Ajout réussi !";}} ?></p>
    <form action="" method="post">  
        <label for="datedebut">date de début :</label>
        <input type="date" name="datedebut" required><br>
        <label for="datefin">Date de fin :</label>
        <input type="date" name="datefin" required><br>
        <label for="pourcentage">Pourcentage :</label>
        <input type="number" name="pourcentage" required><br>
        <label for="code">Code :</label>
        <input type="text" name="code" required><br>
        <label for="usage">Première réservation?</label>
        <input type="radio" name="usage" value="1"> Première réservation uniquement
        <input type="radio" name="usage" value="0"> Toutes les réservations<br>
        <button type="submit" name="ajouter">Ajouter ce code de réduction</button>
    </form>

    <table border="1" style="margin: auto; width: 70%">
        <tr>
            <th>date de début</th>
            <th>date de fin</th>
            <th>pourcentage</th>
            <th>code</th>
            <th>première réservation uniquement</th>
            <th>supprimer</th>
        </tr>
        <?php foreach ($promotions as $promotion) { ?>
            <tr>
                <td><?php echo $promotion['date_debut']; ?></td>
                <td><?php echo $promotion['date_fin']; ?></td>
                <td><?php echo $promotion['reduction']; ?></td>
                <td><?php echo $promotion['code']; ?></td>
                <td><?php if ($promotion['premier_usage'] == 1) {echo "oui";} else {echo "non";} ?></td>
                <td>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?php echo $promotion['id']; ?>">
                        <button type="submit" name="supprimer" class="btn btn-danger">Supprimer</button>
                    </form>
            </tr>
        <?php } ?>
    </table>

    
</body>

</html>
