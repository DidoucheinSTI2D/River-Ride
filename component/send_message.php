<?php
require '../BDD/config.php';
session_start();

if (!isset($_SESSION['id_Utilisateur'])) {
    header('location: connect.php?error=notconnected');
    exit;
}

if (isset($_POST['message'])) {
    $content = $_POST['message'];
    $user_id = $_SESSION['id_Utilisateur'];
    $chat_id = $_SESSION['current_chat_id'];

    $query = $bdd->prepare("INSERT INTO messages (Date_du_message, Utilisateur_id_Utilisateur, Contenu, Chat_id_Chat) VALUES (NOW(), :user_id, :content, :chat_id)");
    $query->bindParam(':user_id', $user_id);
    $query->bindParam(':content', $content);
    $query->bindParam(':chat_id', $chat_id);
    $query->execute();
}
header("Location: ../chat_room.php?chat_id=$chat_id");
exit();
?>
