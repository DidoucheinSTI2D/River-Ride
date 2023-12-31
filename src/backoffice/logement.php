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

$sql = "SELECT * FROM logements";
$stmt = $bdd->prepare($sql);
$stmt->execute();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["submit"])) {
        $logement_id = $_POST["logement_id"];
        $action = $_POST["action"];

        try {
            if ($action == 'delete') {
                $query = "DELETE FROM logements WHERE id_logement = :logement_id";
            } else if ($action == 'rendre_indisponible') {
                $query = "UPDATE logements SET disponibilite = 1 WHERE id_logement = :logement_id";
            } else if ($action == 'rendre_disponible') {
                $query = "UPDATE logements SET disponibilite = 0 WHERE id_logement = :logement_id";
            }

            $stmt = $bdd->prepare($query);
            $stmt->bindParam(":logement_id", $logement_id);

            if ($stmt->execute()) {
                header('Location: logement.php?success=updated');
            } else {
                echo "Une erreur s'est produite lors de la mise à jour de l'état de disponibilité du logement.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        } 

    } else {
        $nom = $_POST["nom"];
        $type = $_POST["type"];
        $capacite = $_POST["capacite"];
        $prix = $_POST["prix"];
        $id_point_arret = $_POST["id_point_arret"];

        try {
            $query = "INSERT INTO logements (id_point_arret, nom, type, capacite, disponibilite, prix)
                      VALUES (:id_point_arret, :nom, :type, :capacite, '0', :prix)";
            $stmt = $bdd->prepare($query);
            $stmt->bindParam(":id_point_arret", $id_point_arret);
            $stmt->bindParam(":nom", $nom);
            $stmt->bindParam(":type", $type);
            $stmt->bindParam(":capacite", $capacite);
            $stmt->bindParam(":prix", $prix);

            if ($stmt->execute()) {
                header('Location: logement.php?success=added');
            } else {
                echo "Une erreur s'est produite lors de l'ajout du logement.";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
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
                            Packs
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


    <h1 style="text-align: center;">Gérer les logements :</h1>
    <p style='color: green; text-align: center;'><?php if (isset($_GET['success']) && $_GET['success'] === "added") echo "Logement ajouté avec succès !"; ?></p>
    <p style='color: green; text-align: center;'><?php if (isset($_GET['success']) && $_GET['success'] === "updated") echo "Logement mis à jour avec succès !"; ?></p>

    <table border="1" style="margin: auto; width: 70%;">
        <tr>
            <th>Nom</th>
            <th>Type</th>
            <th>Capacité</th>
            <th>Disponibilité</th>
            <th>Prix</th>
            <th>Point d'arrêts</th>
            <th>Action</th>
        </tr>
        <?php while ($logement = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
            <tr>
                <td><?= $logement['nom'] ?></td>
                <td><?= $logement['type'] ?></td>
                <td><?= $logement['capacite'] ?></td>
                <td><?php if ($logement['disponibilite'] == 0) echo 'disponible'; else echo 'indisponible'; ?></td>
                <td><?= $logement['prix'] ?></td>
                <td><?= $logement['id_point_arret'] ?></td>
                <td>
                    <form method="post">
                        <input type="hidden" name="logement_id" value="<?= $logement['id_logement'] ?>">
                        <input type="hidden" name="action" value="<?php if ($logement['disponibilite'] == 0) echo 'rendre_indisponible'; else echo 'rendre_disponible'; ?>">
                        <button type="submit" name="submit">
                            <?php if ($logement['disponibilite'] == 0) echo 'Rendre Indisponible'; else echo 'Rendre Disponible'; ?>
                        </button>
                    </form>
                    <form method = "post">
                        <input type="hidden" name="logement_id" value="<?= $logement['id_logement'] ?>">
                        <input type="hidden" name="action" value="delete">
                        <button type="submit" name="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        <?php } ?>
    </table>




    <h1 style="text-align: center;">Ajouter un Logement</h1>
        <form method="post" style="text-align: center;">
            <label for="nom">Nom du Logement:</label>
            <input type="text" name="nom" required><br>
            
            <label for="type">Type:</label>
            <input type="text" name="type" required><br>
            
            <label for="capacite">Capacité:</label>
            <input type="number" name="capacite" required><br>
            
            <label for="prix">Prix:</label>
            <input type="number" step="0.01" name="prix" required><br>
            
            <label for="id_point_arret">Point d'Arrêt:</label>
            <select name="id_point_arret" required>
                <?php 

                $query = "SELECT id_point_arret, nom FROM pointarret";
                $stmt = $bdd->prepare($query);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$row['id_point_arret']}'>{$row['nom']}</option>";
                }
                ?>
            </select><br>

            <input type="submit" value="Ajouter">
        </form> 
    
</body>

</html>
