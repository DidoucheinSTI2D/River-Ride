<?php
require './BDD/config.php';
session_start();
if (!isset($_SESSION['id_Utilisateur'])) {
    header('location: connect.php?error=notconnected');
    exit;
}
$pseudo = $_SESSION['Pseudo'];

if (isset($_POST['chat_id'])) {
    $id_chat = $_POST['chat_id'];

    $query = $bdd->prepare("SELECT * FROM chat WHERE id_chat = :chat_id");
    $query->bindParam(':chat_id', $id_chat);
    $query->execute();

    if ($query->rowCount() > 0) {
        $_SESSION['current_chat_id'] = $id_chat;
        header("Location: chat_room.php?chat_id=$id_chat");
        exit();
    } else {
        $error = "ID de chat invalide. Veuillez réessayer.";
    }
}

if (isset($_GET['error']) && $_GET['error'] == 'notauthorized') {
    $error = "Vous n'êtes pas autorisé à accéder à ce chat privé.";
}

if (isset($_POST['chat_creation'])) {
    $chat_privacy = $_POST['privacy'];
    $id_redacteur = $_SESSION['id_Utilisateur'];

    $query = $bdd->prepare("INSERT INTO chat (id_rédacteur, `privé/publique`) VALUES (:id_redacteur, :prive)");
    $query->bindParam(':id_redacteur', $id_redacteur);

    if ($chat_privacy == 'public') {
        $default_privacy = 'public';
    } else {
        $default_privacy = 'privé';
    }

    $query->bindParam(':prive', $default_privacy);

    if ($query->execute()) {
        $id_chat = $bdd->lastInsertId();
        $success_msg = "Votre chat a été créé : $id_chat";
    }
}

if (isset($_GET['user'])) {
    $user = $_GET['user'];
    $query = $bdd->prepare("SELECT * FROM utilisateur WHERE Pseudo = :pseudo");
    $query->bindParam(':pseudo', $user);
    $query->execute();

    if ($query->rowCount() > 0) {
        $row = $query->fetch(PDO::FETCH_ASSOC);
        $user_id = $row['id_Utilisateur'];
        $id_redacteur = $_SESSION['id_Utilisateur'];

        // Vérifier si l'utilisateur tente de créer un chat avec lui-même
        if ($user_id != $id_redacteur) {
            $existingChatQuery = $bdd->prepare("SELECT contenu FROM utilisateur_chat_utilisateur WHERE ((Utilisateur_id_Utilisateur = :user_id AND Utilisateur_id_Utilisateur1 = :id_redacteur) OR (Utilisateur_id_Utilisateur = :id_redacteur AND Utilisateur_id_Utilisateur1 = :user_id)) AND contenu != ''");
            $existingChatQuery->bindParam(':user_id', $user_id);
            $existingChatQuery->bindParam(':id_redacteur', $id_redacteur);
            $existingChatQuery->execute();

            if ($existingChatQuery->rowCount() > 0) {
                $row = $existingChatQuery->fetch(PDO::FETCH_ASSOC);
                $id_chat = $row['contenu'];
                $success_msg = "Le chat privé existe déjà. Son ID est : $id_chat";
            } else {
                $query = $bdd->prepare("INSERT INTO chat (id_rédacteur, `privé/publique`) VALUES (:id_redacteur, 'privé')");
                $query->bindParam(':id_redacteur', $id_redacteur);

                if ($query->execute()) {
                    $id_chat = $bdd->lastInsertId();

                    $query = $bdd->prepare("INSERT INTO utilisateur_chat_utilisateur (Utilisateur_id_Utilisateur, Utilisateur_id_Utilisateur1, contenu) VALUES (:user_id, :id_redacteur, :id_chat)");
                    $query->bindParam(':user_id', $user_id);
                    $query->bindParam(':id_redacteur', $id_redacteur);
                    $query->bindParam(':id_chat', $id_chat);

                    if ($query->execute()) {
                        $success_msg = "Vous avez ouvert un chat privé avec l'utilisateur : $user";
                        header("Location: chat_room.php?chat_id=$id_chat");
                        exit();
                    } else {
                        $error = "Erreur lors de l'ouverture du chat privé. Veuillez réessayer.";
                    }
                }
            }
        } else {
            $error = "Vous ne pouvez pas créer un chat avec vous-même.";
        }
    } else {
        $error = "L'utilisateur indiqué n'existe pas.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Chat</title>
</head>
<body>
<header>
    <?php include "./component/header.php"; ?>
    <?php include "./logs.php"; ?>
</header>
<main style="margin-top: 7rem;">
    <div class="container">
        <div class="tab-pane fade show active">
            <div class="text-center mb-3">
                <div class="row justify-content-center p-3 mb-2 bg-light text-dark rounded mx-auto">
                    <h1>Chat</h1>

                    <?php if (isset($error)) {
                        echo "<p>$error</p>";
                    } ?>
                    <?php if (isset($success_msg)) {
                        echo "<p style=\"color: green;\">$success_msg</p>";
                    } ?>

                    <form method="post" action="chat.php">
                        <label for="chat_id">ID du chat :</label>
                        <input type="text" name="chat_id" id="chat_id" required>
                        <input type="submit" value="Accéder au chat">
                    </form>

                    <form method="POST" action="chat.php">
                        <input type="hidden" name="privacy" value="public">
                        <input type="submit" name="chat_creation" value="Créer un chat public">
                    </form>

                    <form method="GET" action="chat.php">
                        <label for="user">Ouvrir un chat privé avec :</label>
                        <input type="text" name="user" id="user" required>
                        <input type="submit" value="Ouvrir le chat privé">
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
