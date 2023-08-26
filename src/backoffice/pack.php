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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_pack'])) {
    $pack_id_to_delete = $_POST['pack_a_supprimer'];

    try {
        $delete_packcontenu_query = "DELETE FROM packcontenu WHERE id_pack = ?";
        $stmt = $bdd->prepare($delete_packcontenu_query);
        $stmt->execute([$pack_id_to_delete]);

        $delete_pack_query = "DELETE FROM packs WHERE id_pack = ?";
        $stmt = $bdd->prepare($delete_pack_query);
        $stmt->execute([$pack_id_to_delete]);

        header('Location: pack.php?success=packdeleted');
        exit;
    } catch (PDOException $e) {
        header('Location: pack.php?error=packdeletionfailed');
        exit;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nom'])) {
    $nom = $_POST['nom'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $date_debut = $_POST['date_debut'];
    $date_fin = $_POST['date_fin'];

    try {
        $insert_query = "INSERT INTO packs (nom, description, prix, date_debut, date_fin) 
                         VALUES (?, ?, ?, ?, ?)";
        $stmt = $bdd->prepare($insert_query);
        $stmt->execute([$nom, $description, $prix, $date_debut, $date_fin]);

        $pack_id = $bdd->lastInsertId();

        $selected_logements = $_POST['contenu_logement'];

        foreach ($selected_logements as $logement_id) {
            $logement_query = "INSERT INTO packcontenu (id_pack, id_logement) VALUES (?, ?)";
            $stmt = $bdd->prepare($logement_query);
            $stmt->execute([$pack_id, $logement_id]);

            $points_query = "SELECT id_point_arret FROM logements WHERE id_logement = ?";
            $stmt = $bdd->prepare($points_query);
            $stmt->execute([$logement_id]);
            $points_arrêt = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($points_arrêt as $point) {
                $point_id = $point['id_point_arret'];
                $point_query = "INSERT INTO packcontenu (id_pack, id_point_arret) VALUES (?, ?)";
                $stmt = $bdd->prepare($point_query);
                $stmt->execute([$pack_id, $point_id]);
            }
        }

        header('Location: pack.php?success=packcreated');
        exit;
    } catch (PDOException $e) {
        header('Location: pack.php?error=packcreationfailed');
        exit;
    }
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

    <h1 style="text-align: center;">L'heure des packs!</h1>
    <p style="color: red;"> <?php if (isset($_GET['error'])) {if ($_GET['error'] == 'packcreationfailed') {echo "La création du pack a échoué.";}} ?> </p>
    <p style="color: green;"> <?php if (isset($_GET['success'])) {if ($_GET['success'] == 'packcreated') {echo "Le pack a été créé avec succès.";}} ?> </p>
    <p style="color: red;"> <?php if (isset($_GET['error'])) {if ($_GET['error'] == 'packdeletionfailed') {echo "La suppression du pack a échoué.";}} ?> </p>
    <p style="color: green;"> <?php if (isset($_GET['success'])) {if ($_GET['success'] == 'packdeleted') {echo "Le pack a été supprimé avec succès.";}} ?> </p>
    <main>

        <table class="table">
            <thead>
                <tr>
                    <th>Nom du Pack</th>
                    <th>Description</th>
                    <th>Contenu</th>
                    <th>Date de début</th>
                    <th>Date de fin</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = "SELECT p.id_pack, p.nom, p.description, p.date_debut, p.date_fin, GROUP_CONCAT(l.nom) AS contenu
                        FROM packs p
                        LEFT JOIN packcontenu pc ON p.id_pack = pc.id_pack
                        LEFT JOIN logements l ON pc.id_logement = l.id_logement
                        GROUP BY p.id_pack";
                $stmt = $bdd->prepare($query);
                $stmt->execute();
                $packs = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($packs as $pack) {
                    echo '<tr>';
                    echo '<td>' . $pack['nom'] . '</td>';
                    echo '<td>' . $pack['description'] . '</td>';
                    echo '<td>' . $pack['contenu'] . '</td>';
                    echo '<td>' . $pack['date_debut'] . '</td>';
                    echo '<td>' . $pack['date_fin'] . '</td>';
                    echo '<td>
                    <form method="POST" onsubmit="return confirm(\'Voulez-vous vraiment supprimer ce pack ?\');">
                        <input type="hidden" name="pack_a_supprimer" value="' . $pack['id_pack'] . '">
                        <button type="submit" class="btn btn-danger" name="delete_pack">Supprimer</button>
                    </form>
                    </td>';
                    echo '</tr>';
                }
                ?>
            </tbody>
        </table>

        <h3> Créer un Pack </h3>
        <form action="" method="POST">
            <label for="nom">Nom du Pack:</label>
            <input type="text" name="nom" required><br>

            <label for="description">Description:</label><br>
            <textarea name="description" rows="4" cols="50" required></textarea><br>

            <label for="prix">Prix:</label>
            <input type="number" step="0.01" name="prix" required><br>

            <label for="date_debut">Date de début:</label>
            <input type="date" name="date_debut" required><br>

            <label for="date_fin">Date de fin:</label>
            <input type="date" name="date_fin" required><br>
            <label for="contenu">Contenu du Pack:</label><br>

            <?php
            $query = "SELECT id_point_arret, nom FROM pointarret";
            $stmt = $bdd->prepare($query);
            $stmt->execute();
            $points_arrêt = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<label>Points d'arrêt :</label><br>";
            foreach ($points_arrêt as $row) {
                echo '<input type="checkbox" name="contenu_point[]" value="' . $row['id_point_arret'] . '"> ' . $row['nom'] . '<br>';
            }
            ?>

            <?php
            $query = "SELECT id_logement, nom FROM logements";
            $stmt = $bdd->prepare($query);
            $stmt->execute();
            $logements = $stmt->fetchAll(PDO::FETCH_ASSOC);

            echo "<label>Logements :</label><br>";
            foreach ($logements as $row) {
                echo '<input type="checkbox" name="contenu_logement[]" value="' . $row['id_logement'] . '"> ' . $row['nom'] . '<br>';
            }
            ?>
            
            <button type="submit">Créer le Pack</button>

        </form>


    </main>
</body>

</html>
