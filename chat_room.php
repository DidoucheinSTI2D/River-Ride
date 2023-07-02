<?php
require './BDD/config.php';
session_start();

if (!isset($_SESSION['id_Utilisateur'])) {
    header('location: connect.php?error=notconnected');
    exit;
}

$Pseudo = $_SESSION['Pseudo'];

if (isset($_GET['chat_id'])) {
    $_SESSION['current_chat_id'] = $_GET['chat_id'];
    $chat_id = $_SESSION['current_chat_id'];

    // Vérifier si le chat est public ou privé
    $chat_query = $bdd->prepare("SELECT `privé/publique` FROM chat WHERE id_Chat = :chat_id");
    $chat_query->bindParam(':chat_id', $chat_id);
    $chat_query->execute();
    $chat = $chat_query->fetch(PDO::FETCH_ASSOC);

    if ($chat['privé/publique'] == 'public') {
        // Chat public, l'utilisateur a accès au code
        $query = $bdd->prepare("SELECT Utilisateur_id_Utilisateur, Contenu, Date_du_message FROM messages WHERE Chat_id_Chat = :chat_id");
        $query->bindParam(':chat_id', $chat_id);
        $query->execute();
        $messages = $query->fetchAll(PDO::FETCH_ASSOC);
    } elseif ($chat['privé/publique'] == 'privé') {
        $user_id = $_SESSION['id_Utilisateur'];

        $user_chat_query = $bdd->prepare("SELECT Utilisateur_id_Utilisateur, Utilisateur_id_Utilisateur1 FROM utilisateur_chat_utilisateur WHERE contenu = :chat_id AND (Utilisateur_id_Utilisateur = :user_id OR Utilisateur_id_Utilisateur1 = :user_id)");
        $user_chat_query->bindParam(':chat_id', $chat_id);
        $user_chat_query->bindParam(':user_id', $user_id);
        $user_chat_query->execute();
        $user_chat = $user_chat_query->fetch(PDO::FETCH_ASSOC);

        if (!$user_chat) {
            header("Location: chat.php?error=notauthorized");
            exit();
        }

        $query = $bdd->prepare("SELECT Utilisateur_id_Utilisateur, Contenu, Date_du_message FROM messages WHERE Chat_id_Chat = :chat_id");
        $query->bindParam(':chat_id', $chat_id);
        $query->execute();
        $messages = $query->fetchAll(PDO::FETCH_ASSOC);
    } else {
        header("Location: chat.php?error=notauthorized");
        exit();
    }
} else {
    header("Location: chat.php");
    exit();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Chat Room</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
                    <h1>Chat Room</h1>

                    <h2>Chat ID: <?php echo $chat_id; ?></h2>

                    <form method="post" action="./component/send_message.php">
                        <input type="hidden" name="chat_id" value="<?php echo $chat_id; ?>">
                        <label for="username"><?php echo "Pseudo : " . $Pseudo ?> </label>
                        <label for="message">Message :</label>
                        <input type="text" name="message" id="message" required>
                        <input type="submit" value="Envoyer">
                    </form>

                    <div id="messages">
                        <?php foreach ($messages as $message) {
                            $user_id = $message['Utilisateur_id_Utilisateur'];
                            $user_query = $bdd->prepare("SELECT Pseudo FROM utilisateur WHERE id_Utilisateur = :user_id");
                            $user_query->bindParam(':user_id', $user_id);
                            $user_query->execute();
                            $user = $user_query->fetch(PDO::FETCH_ASSOC);

                            echo "<p><strong>{$user['Pseudo']}:</strong> {$message['Contenu']} <span style='font-size: 12px;'>[{$message['Date_du_message']}]</span></p>";
                        } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            function loadNewMessages() {
                var chatId = "<?php echo $chat_id; ?>";

                $.ajax({
                    url: "./component/load_messages.php",
                    type: "POST",
                    data: { chat_id: chatId },
                    success: function(data) {
                        $("#messages").html(data);
                    }
                });
            }

            // chargement toutes les 2 secondes
            setInterval(loadNewMessages, 2000);
        });
    </script>
</main>
<footer>
    <?php include "./component/footer.php"; ?>
</footer>
</body>
</html>
